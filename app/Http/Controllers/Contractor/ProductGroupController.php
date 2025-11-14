<?php

namespace App\Http\Controllers\Contractor;

use App\Helpers\ManageItems;
use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductGroupController extends Controller
{
    /**
     * [GET] : Product group index page.
     */

    public $group_id = 0;
    public function index(Request $request, $subdomain, $floorplan)
    {
        try {
            $group_id = request('group');
            $this->group_id = $group_id;
            $contractor = Contractor::find($request->contractor_details->id);
            $productgroups = $contractor->productgroups;
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();
            if ($this->group_id == 0) {
                $products = $contractor->products()->where('product_group_id', $productgroups[0]->id)->withPivot('is_not_display_price', 'is_enter_price', 'product_price')->get();
                $productgroup = $productgroups[0];
            } else {
                $products = $contractor->products()->where('product_group_id', $group_id)->withPivot('is_not_display_price', 'is_enter_price', 'product_price')->get();
                $productgroup = ProductGroup::where("id", "=", $this->group_id)->first();

            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.productgroup.index', [
            'subdomain' => $subdomain,
            'productgroups' => $productgroups,
            "floorplan" => $floorplan,
            "contractor" => $contractor,
            'products' => $products,
            "group" => $productgroup,
            "group_id" => $this->group_id
        ]);
    }

    /**
     * [GET] : Product group detail page.
     */
    public function show(Request $request, $subdomain, $floorplan, $productgroup)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();
            $productgroup = ProductGroup::find($productgroup);
            $products = $contractor->products()->where('product_group_id', $productgroup->id)->withPivot('is_not_display_price', 'is_enter_price', 'product_price')->get();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.productgroup.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan, 'productgroup' => $productgroup, 'products' => $products, "contractor" => $contractor]);
    }
    /**
     * [POST] : Add item handler.
     */
    public function add_item(Request $request, $subdomain, $floorplan)
    {
        $values = $request->validate([
            "product_id" => "required|exists:products,id",
            // "product_quantity" => "required|integer|min:1",
            "color" => "nullable|string",
            "comment" => "nullable|string",
        ]);

        try {
            ManageItems::update_items($request, $values, $floorplan);
            Session::put('selection', true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }

    public function update_item(Request $request, $subdomain, $floorplan)
    {
        $values = $request->validate([
            "product_id" => "required|exists:products,id",
            "comment" => "nullable|string",
        ]);

        try {
            ManageItems::update_items($request, $values, $floorplan);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500); // Internal Server Error
        }

        return response()->json([
            'success' => true,
            'data' => $values,
            'message' => 'Item updated successfully'
        ]);
    }

    /**
     * [PUT] : Update items color handler.
     */
    public function update_items_colors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "colors.*.color" => "required|string|max:255"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("color-list", true);
        }

        try {
            $validated = $validator->safe();

            ManageItems::update_colors($request, $validated);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }

    /**
     * [DELETE] : Delete item handler.
     */
    public function delete_item(Request $request, $subdomain, $item)
    {
        try {
            ManageItems::delete_item($request, $item);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }
}
