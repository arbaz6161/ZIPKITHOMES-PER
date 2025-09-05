<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\ManageAssets;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmationMail;
use App\Models\Contractor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;

class ContractorController extends Controller
{
    /**
     * [GET] : Contractor List page for Super Admin
     */
    public function index()
    {
        $contractors = Contractor::where('sub_domain', '<>', config('app.superadmin'))->get();

        return view("superadmin.contractor.index", ["contractors" => $contractors]);
    }

    /**
     * [GET] : Contractor create page for Super Admin
     */
    public function create()
    {
        return view("superadmin.contractor.create");
    }

    /**
     * [GET] : Contractor edit page for Super Admin
     */
    public function edit($id)
    {
        try {
            $contractor = Contractor::findOrFail($id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view("superadmin.contractor.edit", ['contractor' => $contractor]);
    }

    /**
     * [POST] : Contractor create handler for Super Admin
     */
    public function store(Request $request)
    {
        $values = $request->validate([
            "company_name" => "required|string|max:255",
            "sub_domain" => "required|string|unique:contractors",
            "company_website" => "nullable|string|max:255",
            "address" => "nullable|string|max:255",
            "state" => "nullable|string|max:255",
            "county" => "nullable|string|max:255",
            "zip" => "nullable|string|max:255",
            "logo" => "nullable|string|max:255",
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "email" => "required|email|unique:users",
            "password" => "required|string|max:255",
            'g-recaptcha-response' => 'required',
        ]);

        // Retrieve the token from the request
        $token = $request->input('g-recaptcha-response');

        // Build verification request to Google
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.v3_secret_key'),
                'response' => $token
            ]
        ]);

        // Decode the response
        $result = json_decode($response->getBody(), true);

        // Check "success" and set your own score threshold (e.g., 0.5)
        if ($result['success'] && $result['score'] >= 0.5) {
            try {
                $contractor = Contractor::create($values);
                $values['contractor_id'] = $contractor->id;
                $values['user_role_id'] = 2;
                $values['password'] = bcrypt($values['password']);
    
                $user = User::create($values);
    
                if (!empty($values['logo'])) {
                    ManageAssets::updateLogo($values['logo'], ['instance' => $contractor]);
                }
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
    
            Mail::to($user->email)->send(new ConfirmationMail($user, $contractor));
    
            if (!Auth::user() || Auth::user()->user_role_id !== 1) {
                return redirect()->route('contractor.admin.login', ["subdomain" => $contractor->sub_domain]);
            }
    
            return redirect()->route('super.contractors.index')->with('success', 'Contractor created successfully');
        } else {
            return redirect()->back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.']);
        }
    }

    /**
     * [PUT] : Contractor update handler for Super Admin
     */
    public function update(Request $request, $id)
    {
        $values = $request->validate([
            "company_name" => "required|string|max:255",
            "sub_domain" => "required|string|unique:contractors,sub_domain," . $id,
            "company_website" => "nullable|string|max:255",
            "address" => "nullable|string|max:255",
            "state" => "nullable|string|max:255",
            "county" => "nullable|string|max:255",
            "zip" => "nullable|string|max:255",
            "logo" => "nullable|string|max:255",
        ]);

        try {
            $contractor = Contractor::findOrFail($id);

            $contractor->update($values);

            if (!empty($values['logo'])) {
                ManageAssets::updateLogo($values['logo'], ['instance' => $contractor]);
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('super.contractors.index')->with('success', 'Contractor updated successfully');
    }

    /**
     * [DELETE] : Contractor delete handler for Super Admin
     */
    public function destroy($id)
    {
        try {
            $contractor = Contractor::findOrFail($id);
            $contractor->delete();

            return redirect()->route('super.contractors.index')->with('success', 'Contractor has been deleted');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while deleting contractor: ' . $e->getMessage());
        }
    }
}
