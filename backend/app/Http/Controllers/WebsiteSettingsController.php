<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteSettings;
use Illuminate\Support\Facades\Auth;

class WebsiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role != 'Employee'){
            $websiteSettings = WebsiteSettings::getAllWebsiteSettings();
            return view('website_settings.list', compact('websiteSettings'));
        }
        else{
            return view('errors.403');
        }

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

        $siteFavicon = null;
        $siteLogo = null;

        $destinationPath = public_path('/images/websiteimages');

        if ($request->hasFile('site_favicon')) {
            $siteFavicon = $this->processImage($request->file('site_favicon'), $destinationPath);
        }

        if ($request->hasFile('site_logo')) {
            $siteLogo = $this->processImage($request->file('site_logo'), $destinationPath);
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
            'site_logo' => $siteLogo,
            'site_favicon' => $siteFavicon,
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

        $siteFavicon = $websiteSettings->site_favicon;
        $siteLogo = $websiteSettings->site_logo;

        $destinationPath = public_path('/images/websiteimages');

        if ($request->hasFile('site_favicon')) {
            $siteFavicon = $this->processImage($request->file('site_favicon'), $destinationPath);
        }

        if ($request->hasFile('site_logo')) {
            $siteLogo = $this->processImage($request->file('site_logo'), $destinationPath);
        }



        WebsiteSettings::find($id)->update([
            'site_name' => $request->site_name,
            'site_url' => $request->site_url,  
            'site_email' => $request->site_email,
            'site_email2' => $request->site_email2,
            'site_phone' => $request->site_phone,
            'site_phone2' => $request->site_phone2,
            'site_address' => $request->site_address,
            'site_city' => $request->site_city,
            'site_country' => $request->site_country,
            'site_postal_code' => $request->site_postal_code,
            'site_logo' => $siteLogo,
            'site_favicon' => $siteFavicon,
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

    private function processImage($image, $destinationPath)
    {
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $webpName = $originalName . '.webp';
        $counter = 1;

        // Check for duplicate names for both original and WebP files
        while (
            file_exists($destinationPath . '/' . $originalName . '.' . $extension) ||
            file_exists($destinationPath . '/' . $webpName)
        ) {
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . $counter;
            $webpName = $originalName . '.webp';
            $counter++;
        }

        $originalPath = $destinationPath . '/' . $originalName . '.' . $extension;
        $webpPath = $destinationPath . '/' . $webpName;

        // Move original image
        $image->move($destinationPath, $originalName . '.' . $extension);

        // Convert to WebP
        try {
            $imageType = mime_content_type($originalPath);

            switch ($imageType) {
                case 'image/jpeg':
                    $sourceImage = imagecreatefromjpeg($originalPath);
                    break;
                case 'image/png':
                    $sourceImage = imagecreatefrompng($originalPath);
                    break;
                case 'image/gif':
                    $sourceImage = imagecreatefromgif($originalPath);
                    break;
                default:
                    throw new \Exception('Unsupported image type');
            }

            imagewebp($sourceImage, $webpPath, 90); // Save as WebP
            imagedestroy($sourceImage);

            // Delete original image
            unlink($originalPath);

            return $webpName;
        } catch (\Exception $e) {
            throw new \Exception('Failed to process image: ' . $e->getMessage());
        }
    }
}
