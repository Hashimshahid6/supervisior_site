<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySettings;

class CompanySettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companySettings = CompanySettings::getAllCompanySettings();
        return response()->json($companySettings);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|unique:company_settings',
            'company_email' => 'required|email',
            'company_phone' => 'required|numeric',
            'company_address' => 'required|string',
            'company_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_description' => 'required|string',
        ]);

        if ($request->hasFile('company_favicon')) {
            $company_favicon = $request->file('company_favicon');
            $faviconName = time() . '.' . $company_favicon->getClientOriginalExtension();
            $destinationPath = public_path('/images/company');
            $company_favicon->move($destinationPath, $faviconName);
        }

        if ($request->hasFile('company_logo')) {
            $company_logo = $request->file('company_logo');
            $logoName = time() . '.' . $company_logo->getClientOriginalExtension();
            $destinationPath = public_path('/images/company');
            $company_logo->move($destinationPath, $logoName);
        }

        CompanySettings::create([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'company_address' => $request->company_address,
            'company_city' => $request->company_city,
            'company_country' => $request->company_country,
            'company_postal_code' => $request->company_postal_code,
            'company_logo' => $logoName ?? $request->company_logo,
            'company_favicon' => $faviconName ?? $request->company_favicon,
            'company_description' => $request->company_description,
            'company_facebook' => $request->company_facebook,
            'company_twitter' => $request->company_twitter,
            'company_instagram' => $request->company_instagram,
            'company_linkedin' => $request->company_linkedin,
        ]);

        return response()->json(['message' => 'Company settings created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companySettings = CompanySettings::getCompanySettings($id);
        return response()->json($companySettings);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'company_name' => 'required',
            'company_email' => 'required|email',
            'company_phone' => 'required|numeric',
            'company_address' => 'required|string',
            'company_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_description' => 'required|string',
        ]);

        if ($request->hasFile('company_favicon')) {
            $company_favicon = $request->file('company_favicon');
            $faviconName = time() . '.' . $company_favicon->getClientOriginalExtension();
            $destinationPath = public_path('/images/company');
            $company_favicon->move($destinationPath, $faviconName);
        }

        if ($request->hasFile('company_logo')) {
            $company_logo = $request->file('company_logo');
            $logoName = time() . '.' . $company_logo->getClientOriginalExtension();
            $destinationPath = public_path('/images/company');
            $company_logo->move($destinationPath, $logoName);
        }

        CompanySettings::find($id)->update([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'company_address' => $request->company_address,
            'company_city' => $request->company_city,
            'company_country' => $request->company_country,
            'company_postal_code' => $request->company_postal_code,
            'company_logo' => $logoName ?? $request->company_logo,
            'company_favicon' => $faviconName ?? $request->company_favicon,
            'company_description' => $request->company_description,
            'company_facebook' => $request->company_facebook,
            'company_twitter' => $request->company_twitter,
            'company_instagram' => $request->company_instagram,
            'company_linkedin' => $request->company_linkedin,
        ]);

        return response()->json(['message' => 'Company settings updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
