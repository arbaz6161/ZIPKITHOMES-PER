<?php

namespace App\Http\Controllers\Contractor;

use App\Helpers\ManageItems;
use App\Http\Controllers\Controller;
use App\Mail\CustomerMail;
use App\Models\Contractor;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Product;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;

class ExportController extends Controller
{
    /**
     * [GET] : Create mail form.
     */
    public function create_email(Request $request, $subdomain, $floorplan)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.create_email', ['subdomain' => $subdomain, 'floorplan' => $floorplan, "contractor" => $contractor]);
    }

    /**
     * [POST] : Send mail handler.
     */
    public function store_email(Request $request, $subdomain)
    {
        $values = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "phone" => "required|string|max:255",
            "home_location" => "required|string|max:255",
            "home_state" => "required|string|max:255",
            "home_zip" => "required|string|max:255",
            "note" => "nullable|string",
            "floorplan_id" => "required|exists:floor_plans,id",
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

            $contractor = Contractor::find($request->contractor_details->id);

            $values['contractor_id'] = $contractor->id;
            $values['source_website'] = $contractor->sub_domain . config("app.domain");

            $customer = Customer::updateOrCreate(["email" => $values['email']], $values);

            $floorplan = $contractor->floorplans()->where('floor_plan_id', $values["floorplan_id"])->withPivot('floor_plan_price')->first();

            $customer_submit = $customer->submits()->updateOrCreate(
                ["contractor_id" => $contractor->id, "floor_plan_id" => $floorplan->id],
                [
                    "floor_plan_id" => $values["floorplan_id"],
                    "floor_plan_price" => $floorplan->pivot->floor_plan_price ? $floorplan->pivot->floor_plan_price : 0,
                    "note" => $values["note"]
                ]
            );

            $items = ManageItems::get_items($contractor, $floorplan);

            foreach ($items as $item) {
                $product = Product::find($item['product_id']);

                $product_in_contractor = $contractor->products()->where("product_id", $product->id)->first();

                $customer_submit->customersubmitproducts()->updateOrCreate(
                    ["pdt_id" => $product->id],
                    [
                        "pdt_group_id" => $product->pdt_group_id,
                        "pdt_price" => $product_in_contractor->is_enter_price == 1 ? $product_in_contractor->pdt_price : 0,
                        "customer_comment" => $item['comment'],
                        "pdt_color" => $item['color']
                    ]
                );
            }

            if($subdomain == "shurtzcanyon") {
                // shurtzcantyon
                $super_admin_email = env("SHURTZCANYON_ADMIN_TARGET_EMAIL");
            } else if ($subdomain == "mvp") {
                // mvp
                $super_admin_email = env("SUPER_ADMIN_TARGET_EMAIL");
            } else {
                // zipkithomes and others
                $super_admin_email = env("ZIPKITHOMES_ADMIN_TARGET_EMAIL");
            }

            // to super admin
            Mail::to(env("TEST_EMAIL") ? env("TEST_TARGET_MAIL") : $super_admin_email )->send(new CustomerMail($subdomain, $customer, $floorplan, $items, $customer_submit->note));

            // to customer email.
            Mail::to(env("TEST_EMAIL") ? env("TEST_TARGET_MAIL") : $customer->email)->send(new CustomerMail($subdomain, $customer, $floorplan, $items, $customer_submit->note));

            ManageItems::delete_items($contractor, $floorplan);

            return redirect()->route('contractor.productgroups.index', ['subdomain' => $subdomain, "floorplan" => $floorplan->id])->with("success", "Email has been sent successfully");
        } else {
            // The token is invalid or suspicious (score < 0.5)
            return redirect()->back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.']);
        }
    }

    /**
     * [GET] : Create pdf form.
     */
    public function create_pdf(Request $request, $subdomain, $floorplan)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();

            $items = ManageItems::get_items($contractor, $floorplan);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.create_pdf', ['subdomain' => $subdomain, 'floorplan' => $floorplan, "items" => $items, "contractor" => $contractor]);
    }

    /**
     * [POST] : Create pdf handler.
     */
    public function store_pdf(Request $request, $subdomain)
    {
        $values = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "phone" => "required|string|max:255",
            "home_location" => "required|string|max:255",
            "home_state" => "required|string|max:255",
            "home_zip" => "required|string|max:255",
            "floor_plan_id" => "required|exists:floor_plans,id"
        ]);

        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $values['floor_plan_id'])->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();

            $items = ManageItems::get_items($contractor, $floorplan);

            $pdf = PDF::loadView("contractor.pdf", ["items" => $items, "values" => $values, "floorplan" => $floorplan]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return $pdf->download($contractor->sub_domain . config('app.domain') . ".pdf");
    }

    /**
     * [GET] : Create cart form.
     */
    public function create_cart(Request $request, $subdomain, $floorplan)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();

            $items = ManageItems::get_items($contractor, $floorplan);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.create_cart', ['subdomain' => $subdomain, 'floorplan' => $floorplan, "items" => $items, "contractor" => $contractor]);
    }
}

