<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteSettings;

class WebsiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websiteSettings = WebsiteSettings::getAllWebsiteSettings();
        return view('website_settings.list', compact('websiteSettings'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website_settings.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'site_name' => 'required|unique:website_settings',
            'site_url' => 'required|url',
            'site_email' => 'required|email',
            'site_phone' => 'required|string',
            'site_address' => 'required|string',
            'site_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_description' => 'required|string',
        ]);

        if ($request->hasFile('site_favicon')) {
            $site_favicon = $request->file('site_favicon');
            $faviconName = time() . '.' . $site_favicon->getClientOriginalExtension();
            $destinationPath = public_path('/images/websiteimages');
            $site_favicon->move($destinationPath, $faviconName);
        }

        if ($request->hasFile('site_logo')) {
            $site_logo = $request->file('site_logo');
            $logoName = time() . '.' . $site_logo->getClientOriginalExtension();
            $destinationPath = public_path('/images/websiteimages');
            $site_logo->move($destinationPath, $logoName);
        }

        WebsiteSettings::create([
            'site_name' => $request->site_name,
            'site_url' => $request->site_url,
            'site_email' => $request->site_email,
            'site_phone' => $request->site_phone,
            'site_address' => $request->site_address,
            'site_city' => $request->site_city,
            'site_country' => $request->site_country,
            'site_postal_code' => $request->site_postal_code,
            'site_logo' => $logoName ?? $request->site_logo,
            'site_favicon' => $faviconName ?? $request->site_favicon,
            'site_description' => $request->site_description,
            'site_facebook' => $request->site_facebook,
            'site_twitter' => $request->site_twitter,
            'site_instagram' => $request->site_instagram,
            'site_linkedin' => $request->site_linkedin,
        ]);

        return redirect()->route('website_settings.index')->with('success', 'Company settings created successfully.');
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
        $websiteSettings = WebsiteSettings::find($id);
        return view('website_settings.edit', compact('websiteSettings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'site_name' => 'required',
            'site_url' => 'required|url',
            'site_email' => 'required|email',
            'site_phone' => 'required|string',
            'site_address' => 'required|string',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_description' => 'required|string',
        ]);

        $websiteSettings = WebsiteSettings::find($id);

        if ($request->hasFile('site_favicon')) {
            $site_favicon = $request->file('site_favicon');
            $faviconName = time() . '.' . $site_favicon->getClientOriginalExtension();
            $destinationPath = public_path('/images/websiteimages');
            $site_favicon->move($destinationPath, $faviconName);
            $websiteSettings->site_favicon = $faviconName;
        }

        if ($request->hasFile('site_logo')) {
            $site_logo = $request->file('site_logo');
            $logoName = time() . '.' . $site_logo->getClientOriginalExtension();
            $destinationPath = public_path('/images/websiteimages');
            $site_logo->move($destinationPath, $logoName);
            $websiteSettings->site_logo = $logoName;
        }

        WebsiteSettings::find($id)->update([
            'site_name' => $request->site_name,
            'site_url' => $request->site_url,  
            'site_email' => $request->site_email,
            'site_phone' => $request->site_phone,
            'site_address' => $request->site_address,
            'site_city' => $request->site_city,
            'site_country' => $request->site_country,
            'site_postal_code' => $request->site_postal_code,
            'site_logo' => $websiteSettings->site_logo ?? $request->site_logo,
            'site_favicon' => $websiteSettings->site_favicon ?? $request->site_favicon,
            'site_description' => $request->site_description,
            'site_facebook' => $request->site_facebook,
            'site_twitter' => $request->site_twitter,
            'site_instagram' => $request->site_instagram,
            'site_linkedin' => $request->site_linkedin,
        ]);

        return redirect()->route('website_settings.index')->with('success', 'Company settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
