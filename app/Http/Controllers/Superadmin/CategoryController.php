<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\FloorPlanCategories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * [GET] :  Floor plan category List page for Super Admin
     */
    public function index()
    {
        try {
            $categories = FloorPlanCategories::all();
            return view('superadmin.categories.index', ['categories' => $categories]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [GET] :  Floor plan category create page for Super Admin
     */
    public function create()
    {
        return view('superadmin.categories.create');
    }
    
    /**
     * [GET] :  Floor plan category edit page for Super Admin
     */
    public function edit($category)
    {
        try {
            $category = FloorPlanCategories::find($category);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('superadmin.categories.edit', ['category' => $category]);
    }

    /**
     * [PUT] :  Floor plan category update handler for Super Admin
     */
    public function update(Request $request, $category)
    {
        $values = $request->validate([
            "category_name" => "required|string|max:255",
            "category_description" => "string|max:255",
            "is_active" => "string|max:255"
        ]);

        try {
            if( isset($values["is_active"])  )
            {
                if ( $values["is_active"] == "active" )
                    $values["is_active"] = true;
            }
            else
            {
                $values["is_active"] = false;
            }
            $floor_plan_category = FloorPlanCategories::findOrFail($category);
            
            $floor_plan_category->update($values);

            return redirect()->route('super.categories.index')->with('success', 'Floor plan category updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [POST] :  Floor plan category create handler for Super Admin
     */
    public function store(Request $request)
    {

        $values = $request->validate([
            "category_name" => "required|string|max:255",
            "category_description" => "string|max:255",
            "is_active" => "string|max:255"
        ]);

        try {
            if( isset($values["is_active"])  )
            {
                if ( $values["is_active"] == "active" )
                    $values["is_active"] = true;
            }
            $category = FloorPlanCategories::create($values);
            return redirect()->route('super.categories.index')->with('success', 'Floor plan category created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [DELETE] :  Floor plan category delete handler for Super Admin
     */
    public function destroy($category)
    {
        try {
            FloorPlanCategories::destroy($category);

            return redirect()->route('super.categories.index')->with('success', 'Floor plan category has been deleted successfully');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting floor plan: ' . $e->getMessage());
        }
    }
}
