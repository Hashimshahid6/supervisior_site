<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSection;
use Intervention\Image\ImageManagerStatic as Image;

class HeroSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroSections = HeroSection::getHeroSection();
        return view('hero_sections.list', compact('heroSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hero_sections.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_text' => 'required|string',
            'button_url' => 'required|url',
        ]);
        if ($request->hasFile('image')) {
            // Step 1: Upload original image
            $image = $request->file('image');
            $originalName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/hero-section');

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
        HeroSection::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $name ?? $request->image,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
        ]);

        return redirect()->route('hero_sections.index')->with('success', 'Hero section created successfully.');
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
        $heroSection = HeroSection::find($id);
        return view('hero_sections.edit', compact('heroSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_text' => 'required|string',
            'button_url' => 'required|url',
            'status' => 'required|in:Active,Inactive,Deleted',
        ]);

        $heroSection = HeroSection::find($id);

        if ($request->hasFile('image')) {
            // Step 1: Upload original image
            $image = $request->file('image');
            $originalName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/hero-section');

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

            $heroSection->image = $name;
        }

        $heroSection->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $heroSection->image ?? $request->image,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'status' => $request->status,
        ]);

        return redirect()->route('hero_sections.index')->with('success', 'Hero section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $heroSection = HeroSection::find($id);
        $heroSection->status = 'Deleted';
        $heroSection->save();

        return redirect()->route('hero_sections.index')->with('success', 'Hero section deleted successfully.');
    }
}
