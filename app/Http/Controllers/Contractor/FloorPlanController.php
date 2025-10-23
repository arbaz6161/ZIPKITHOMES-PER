<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Superadmin\CategoryController;
use App\Models\CategoryMapping;
use App\Models\ContactFormLogs;
use App\Models\Contractor;
use App\Models\FloorPlan;
use App\Models\ContractorSetting;
use Exception;
use Illuminate\Http\Request;

class FloorPlanController extends Controller
{
    /**
     * [GET] : Floor plan index page.
     */
    public function index(Request $request, $subdomain)
    {
        try {
            $contractor  = Contractor::find($request->contractor_details->id);
            $setting = ContractorSetting::where('contractor_id', '=', $request->contractor_details->id)->first();
            if(!$setting){
                $setting = [
                    "home_url" => "",
                    "about_url" => "",
                    "contact_url" => "",
                ];
            }
            $floorPlansData = [];

            $floorplans = $contractor->floorplans()
                            ->with('category:id,category_name')
			    ->orderBy('floor_plans.category_id')
                            ->orderBy('floor_plans.order')
                            ->orderBy('floor_plans.id')
                            ->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')
                            ->get()
                            ->map( function ($floorplan) use (&$floorPlansData) {
                                $floorPlansData[$floorplan->category->category_name][] = $floorplan;
                            });

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.floorplan.index', ['subdomain' => $subdomain, 'floorplans' => $floorPlansData, "contractor" => $contractor, 'setting' => $setting]);
    }

    /**
     * [GET] : Floor plan detail page.
     */
    public function show(Request $request, $subdomain, $floorplan)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price', 'floor_plan_additional_text')->first();
            $contractor_floorplans = $contractor->floorplans()
                            ->orderBy('floor_plans.order')
                            ->orderBy('floor_plans.id')
                            ->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')
                            ->get();
            $category_mapping = CategoryMapping::where("contractor_id", "=", $request->contractor_details->id)->first()->category_ids;
            $rest_floorplans = $contractor->floorplans()->where('floor_plan_id', "<>", $floorplan->id)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price', 'floor_plan_additional_text')->get();

            $number_of_homes = ContactFormLogs::$number_of_homes;
            $budgets = ContactFormLogs::$budgets;
            $time_frames = ContactFormLogs::$time_frames;

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return view('contractor.floorplan.show', [
            'subdomain' => $subdomain,
            'floorplan' => $floorplan,
            "contractor" => $contractor,
            "floorplans" => $rest_floorplans,
            "contractor_floorplans" => $contractor_floorplans,
            "category_mapping" => $category_mapping,
            "number_of_homes" => $number_of_homes,
            "budgets" => $budgets,
            "time_frames" => $time_frames
        ]);
    }

    /**
     * [POST] : Floor plan Contact Submit
     */

     function contact_submit(Request $request) {
        try {
            $name = $request["name"];
            $email = $request["email"];
            $state = $request["state"];
            $zip_code = $request["zip_code"];
            $interest_in_buy = $request["interest_in_buy"];
            $interest_in_floor_plan = $request["interest_in_floor_plan"];
            $number_of_home = $request["number_of_home"];
            $budget = $request["budget"];
            $time_frame = $request["time_frame"];
            $comment = $request["comment"];

            ContactFormLogs::create([
                "contractor_id" => $request->contractor_details->id,
                "name" => $name,
                "email" => $email,
                "state" => $state,
                "zip_code" => $zip_code,
                "interest_in_buy" => $interest_in_buy,
                "interest_in_floor_plan" => $interest_in_floor_plan,
                "number_of_home" => $number_of_home,
                "budget" => $budget,
                "time_frame" => $time_frame,
                "comment" => $comment
            ]);

            return redirect()->route("contractor.floorplans.index");
        } catch(Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
     }
}
