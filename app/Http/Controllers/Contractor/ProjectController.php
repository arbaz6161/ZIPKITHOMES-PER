<?php

namespace App\Http\Controllers\Contractor;

use App\Helpers\ManageItems;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function create(Request $request, $subdomain, $floorplan)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $floorplan = $contractor->floorplans()
                ->where('floor_plan_id', $floorplan)
                ->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')
                ->first();
            $items = ManageItems::get_items($contractor, $floorplan);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.create_project', [
            'subdomain' => $subdomain,
            'floorplan' => $floorplan,
            'items' => $items,
            'contractor' => $contractor
        ]);
    }

    public function store(ProjectRequest $request, $contractor, $floorplan) {
        $contractor = Contractor::find($request->contractor_details->id);
        $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();

        $items = ManageItems::get_items($contractor, $floorplan);
        $products = [];

        foreach($items as $item) {
            $product = $contractor->products()->where('product_id', $item['product_id'])->withPivot('is_not_display_price', 'is_enter_price', 'product_price')->first();
            
            if ($product) {
                $products[] = $product;
            }
        }

        $data = $request->toArray();
        $data['products'] = $products;

        try {
            $response = Http::post('https://zipkit.zipkitstaging.xyz/api/projects/create', $data);
    
            if ($response->successful()) {
                return back()->with('success', 'Project created successfully');
            }
        
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
