<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banners;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banners::getBanners();
        return view('banners.list', compact('banners'));
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
        if ($request->hasFile('image')) {
            // Step 1: Upload original image
            $image = $request->file('image');
            $originalName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/banners');

            // Move the uploaded file to the destination
            $image->move($destinationPath, $originalName);

            // Step 2: Convert to WebP and Compress
            $webpName = time() . '.webp';
            $originalPath = $destinationPath . '/' . $originalName;
            $webpPath = $destinationPath . '/' . $webpName;

            // Create a WebP image using GD
            try {
                // Load the image
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
                    case 'image/jpg':
                        $sourceImage = imagecreatefromjpeg($originalPath);
                        break;
                    default:
                        throw new \Exception('Unsupported image type');
                }

                // Save as WebP with compression
                imagewebp($sourceImage, $webpPath, 90); // 90 is the compression quality
                imagedestroy($sourceImage);

                // Step 3: Delete the original image
                unlink($originalPath);

                // Return or save the WebP file name
                $name = $webpName;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        Banners::create([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'image' => $name ?? $request->image,
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

        if ($request->hasFile('image')) {
            // Step 1: Upload original image
            $image = $request->file('image');
            $originalName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/banners');

            // Move the uploaded file to the destination
            $image->move($destinationPath, $originalName);

            // Step 2: Convert to WebP and Compress
            $webpName = time() . '.webp';
            $originalPath = $destinationPath . '/' . $originalName;
            $webpPath = $destinationPath . '/' . $webpName;

            // Create a WebP image using GD
            try {
                // Load the image
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
                    case 'image/jpg':
                        $sourceImage = imagecreatefromjpeg($originalPath);
                        break;
                    default:
                        throw new \Exception('Unsupported image type');
                }

                // Save as WebP with compression
                imagewebp($sourceImage, $webpPath, 90); // 90 is the compression quality
                imagedestroy($sourceImage);

                // Step 3: Delete the original image
                unlink($originalPath);

                // Return or save the WebP file name
                $name = $webpName;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            $banner->image = $name;
        }

        $banner->update([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'image' => $banner->image ?? $request->image,
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
    }
}
