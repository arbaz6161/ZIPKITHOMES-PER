<?php

namespace App\Http\Controllers\Contractor\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\ContractorSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * [GET] : Setting first page.
     */
    public function index(Request $request, $subdomain)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $setting = ContractorSetting::where('contractor_id', '=', $request->contractor_details->id)->first();
            if(!$setting){
                $setting = [
                    "home_url" => "",
                    "about_url" => "",
                    "contact_url" => "",
                ];
            }
            return view(
                'contractor.admin.setting.index',
                [
                    'subdomain' => $subdomain,
                    "contractor" => $contractor,
                    'setting' => $setting
                ]
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    /**
     * [POST] : Save contractor urls.
     */
    public function store_urls(Request $request, $subdomain)
    {
        try {
            ContractorSetting::updateOrCreate(
                ['contractor_id' => $request->contractor_details->id],
                [
                    "contractor_id" => $request->contractor_details->id,
                    "home_url" => $request->home_url,
                    "about_url" => $request->about_url,
                    "contact_url" => $request->contact_url,
                ]
            );
            return redirect()->route('contractor.admin.setting.index', ['subdomain' => $subdomain])->with('success', 'Contractor Url has updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }
}