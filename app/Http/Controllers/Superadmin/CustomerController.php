<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Contractor;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * [GET] :  Customer list page for Super Admin
     */
    public function index(Request $request)
    {
        try {

            $contractor_id = $request->query("contractor");
            $customers = [];
            $contractor = null;

            if ($contractor_id) {
                $contractor = Contractor::find($contractor_id);
                $customers = $contractor->customers;
            } else
                $customers = Customer::all();

            $contractors = Contractor::all();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view("superadmin.customer.index", ["customers" => $customers, "contractors" => $contractors, "contractor" => $contractor]);
    }

    /**
     * [GET] :  Customer create page for Super Admin
     */
    public function create()
    {
        try {
            $contractors = Contractor::all();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('superadmin.customer.create', ['contractors' => $contractors]);
    }

    /**
     * [POST] : Customer create handler for Super Admin
     */
    public function store(Request $request)
    {
        $values = $request->validate([
            "contractor_id" => "required|exists:contractors,id",
            "source_website" => "required|string|max:255",
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "phone" => "required|string|max:255",
            "home_location" => "required|string|max:255",
            "home_state" => "required|string|max:255",
            "home_zip" => "required|string|max:255",
            "note" => "required|string",
        ]);

        try {
            Customer::create($values);

            return redirect()->route('super.customers.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [GET] :  Customer edit page for Super Admin
     */
    public function edit($customer)
    {
        try {
            $customer = Customer::find($customer);
            $contractors = Contractor::all();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('superadmin.customer.edit', ['customer' => $customer, "contractors" => $contractors]);
    }

    /**
     * [PUT] :  Customer update handler for Super Admin
     */
    public function update(Request $request, $customer)
    {
        $values = $request->validate([
            "contractor_id" => "required|exists:contractors,id",
            "source_website" => "required|string|max:255",
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "phone" => "required|string|max:255",
            "home_location" => "required|string|max:255",
            "home_state" => "required|string|max:255",
            "home_zip" => "required|string|max:255",
            "note" => "required|string",
        ]);

        try {
            $customer = Customer::findOrFail($customer);

            $customer->update($values);

            return redirect()->route('super.customers.index');
        } catch (\Exception $e) {
            return back()->with('error',  $e->getMessage());
        }
    }

    /**
     * [DELETE] :  Customer delete handler for Super Admin
     */
    public function destroy($customer)
    {
        try {
            Customer::destroy($customer);

            return redirect()->route('super.customers.index');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting customer: ' . $e->getMessage());
        }
    }
}
