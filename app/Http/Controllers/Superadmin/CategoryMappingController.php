<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\CategoryMapping;
use App\Models\Contractor;
use App\Models\FloorPlanCategories;
use Illuminate\Http\Request;

class CategoryMappingController extends Controller
{
    /**
     * [GET] :  Category Mapping Page for Super Admin
     */
    public function index()
    {
        try {
            $category_mappings = CategoryMapping::join("contractors","category_mapping.contractor_id","=","contractors.id")
                ->select("category_mapping.id as id",
                     "contractors.company_name as contractor_name",
                     "category_mapping.category_ids as category_ids")
                ->get();
            return view('superadmin.categorymapping.index', ['categorymappings' => $category_mappings ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [GET] :  Category Mapping create page for Super Admin
     */
    public function create()
    {
        try {
            $contractors = Contractor::all();
            $categories = FloorPlanCategories::all()->where("is_active", "=", true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('superadmin.categorymapping.create', ['contractors' => $contractors, 'categories' => $categories]);
    }

    /**
     * [GET] :  Category Mapping edit page for Super Admin
     */
    public function edit($categorymapping)
    {
        try {
            $category_mapping = CategoryMapping::join("contractors","category_mapping.contractor_id","=","contractors.id")
                ->select("category_mapping.id as id",
                     "contractors.company_name as contractor_name",
                     "category_mapping.category_ids as category_ids")
                ->where("category_mapping.id", $categorymapping)->first();
            $contractors = Contractor::all();
            $categories = FloorPlanCategories::all()->where("is_active", "=", true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return view('superadmin.categorymapping.edit', ['category_mapping' => $category_mapping, 'contractors' => $contractors, 'categories'=> $categories]);
    }

    /**
     * [PUT] :  Product update handler for Super Admin
     */
    public function update(Request $request, $categorymapping)
    {
        $values = $request->validate([
            "contractor_id" => "required|exists:contractors,id",
            "category_ids" => "exists:floor_plan_categories,id",
        ]);

        try {
            $category_mapping = CategoryMapping::find($categorymapping);
            $category_mapping->update([
                "contractor_id" => $values["contractor_id"],
                "category_ids" => isset($values["category_ids"]) ? json_encode($values["category_ids"]) : null
            ]);
            return redirect()->route('super.categorymapping.index')->with('success', 'Category Mapping has been updated');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [POST] : Category Mapping Update handler for Super Admin
     */
    public function store(Request $request)
    {
        $values = $request->validate([
            "contractor_id" => "required|exists:contractors,id",
            "category_ids" => "exists:floor_plan_categories,id",
        ]);

        try {
            $contract = Contractor::find($values["contractor_id"]);
            $values["contractor_id"] = $contract->id;
            $values["category_ids"] = isset($values["category_ids"]) ? json_encode($values["category_ids"]) : null;
            CategoryMapping::create($values);
            return redirect()->route('super.categorymapping.index')->with('success', 'Category Mapping has been created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [DELETE] : Category Mapping Delete handler for Super Admin
     */
    public function destroy($categorymapping)
    {
        try {
            CategoryMapping::destroy($categorymapping);

            return redirect()->route('super.categorymapping.index')->with('success', 'Category Mapping has been deleted');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting product: ' . $e->getMessage());
        }
    }
}
