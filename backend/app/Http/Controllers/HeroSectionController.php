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

        $imageName = null;
        $destinationPath = public_path('images/hero-section');
        if ($request->hasFile('image')) {
            $imageName = $this->processImage($request->file('image'), $destinationPath);
        }
        HeroSection::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imageName,
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

        $destinationPath = public_path('/images/hero-section');
        $imageName = $heroSection->image;

        if ($request->hasFile('image')) {
            $imageName = $this->processImage($request->file('image'), $destinationPath);
        }

        $heroSection->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imageName,
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
