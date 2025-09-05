<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\CategoryMapping;
use App\Models\FloorPlan;
use App\Helpers\ManageAssets;
use App\Models\FloorPlanCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FloorPlanController extends Controller
{
    /**
     * [GET] :  Floor plan List page for Super Admin
     */
    public function index()
    {
        try {
            $floorplans = FloorPlan::all();
            return view('superadmin.floorplan.index', ['floorplans' => $floorplans]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [GET] :  Floor plan create page for Super Admin
     */
    public function create()
    {
        $categories = FloorPlanCategories::all()->where("is_active", "=", true);
        return view('superadmin.floorplan.create', ['categories' => $categories]);
    }

    /**
     * [GET] :  Floor plan edit page for Super Admin
     */
    public function edit($floorPlan)
    {
        try {
            $floorPlan = FloorPlan::find($floorPlan);
            $categories = FloorPlanCategories::all()->where("is_active", "=", true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('superadmin.floorplan.edit', ['floorplan' => $floorPlan, 'categories' => $categories]);
    }

    /**
     * [POST] :  Floor plan create handler for Super Admin
     */
    public function store(Request $request)
    {

        $values = $request->validate([
            "plan_name" => "required|string|max:255",
            "plan_description" => "required|string|max:255",
            "plan_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
            "category_id" => "nullable",
            "order" => 'nullable',
            // 'media.*.vid_name' => 'required|string|max:255',
            // 'media.*.vid_url' => 'required|string|max:20480',
        ]);

        try {

            $c = 0;
            if ($request->get("media")) {
                foreach ($request->get("media") as $m) {
                    if (($m['vid_name'] != null) || ($m['custom_vid_url'] != null)) {
                        $values["media"][$c++] = $m;
                    }
                }
            }

            $values['plan_price'] = 0;
            $floorPlan = FloorPlan::create($values);
            $media = isset($values['media']) ? $values['media'] : NULL;
            $values = ManageAssets::updateAssets($values['images'], $media, ["model" => "floorplan", "instance" => $floorPlan]);

            return redirect()->route('super.floorplans.index')->with('success', 'Floor plan created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [PUT] :  Floor plan update handler for Super Admin
     */
    public function update(Request $request, $floorPlan)
    {
        $values = $request->validate([
            "plan_name" => "required|string|max:255",
            "plan_description" => "required|string|max:255",
            "plan_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
            "category_id" => "nullable",
            "order" => 'nullable|int',
            // "id" => "required|int",
            // 'media.*.vid_name' => 'required|string|max:255',
            // 'media.*.vid_url' => 'required|string|max:20480',
        ]);

        try {
            $c = 0;
            if ($request->get("media")) {
                foreach ($request->get("media") as $m) {
                    if (($m['vid_name'] != null) || ($m['custom_vid_url'] != null)) {
                        $values["media"][$c++] = $m;
                    }
                }
            }

            // $floorPlan = FloorPlan::find($values['id']);
            $floorPlan = FloorPlan::findOrFail($floorPlan);

            $floorPlan->update($values);

            $media = isset($values['media']) ? $values['media'] : NULL;

            $values = ManageAssets::updateAssets($values['images'], $media, ["model" => "floorplan", "instance" => $floorPlan]);

            return redirect()->route('super.floorplans.index')->with('success', 'Floor plan updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [DELETE] :  Floor plan delete handler for Super Admin
     */
    public function destroy($floorPlan)
    {
        try {
            FloorPlan::destroy($floorPlan);

            return redirect()->route('super.floorplans.index')->with('success', 'Floor plan has been deleted');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting floor plan: ' . $e->getMessage());
        }
    }
}
