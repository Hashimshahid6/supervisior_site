<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banners;
use Illuminate\Support\Facades\Auth;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role == 'Admin'){
            $banners = Banners::getBanners();
            return view('banners.list', compact('banners'));
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
        return view('banners.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'display_on' => 'required|in:Home,About,Services,Contact,Pricing',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
        $destinationPath = public_path('images/banners');
        if($request->hasFile('image')) {
            $imageName = $this->processImage($request->file('image'), $destinationPath);
        }

        Banners::create([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'image' => $imageName,
            'display_on' => $request->display_on,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner added successfully');
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
        $banner = Banners::find($id);
        return view('banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'heading' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'display_on' => 'required|in:Home,About,Services,Contact,Pricing',
            'status' => 'required|in:Active,Inactive,Deleted',
        ]);

        $banner = Banners::find($id);

        $destinationPath = public_path('images/banners');

        $imageName = $banner->image;

        if ($request->hasFile('image')) {
            $imageName = $this->processImage($request->file('image'), $destinationPath);
        }

        $banner->update([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'image' => $imageName,
            'display_on' => $request->display_on,
            'status' => $request->status,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banners::find($id);
        $banner->status = 'Deleted';
        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully');
    }//

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
