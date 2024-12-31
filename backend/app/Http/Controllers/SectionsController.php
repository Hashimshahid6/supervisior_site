<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sections;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Sections::getSections();
        return view('sections.list', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sections.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_link' => 'nullable|url',
            'display_on' => 'required|in:Home,About,Services,Contact,Pricing',
        ]);

        $imageName = null;
        $destinationPath = public_path('images/sections');
        if ($request->hasFile('image')) {
            $imageName = $this->processImage($request->file('image'), $destinationPath);
        }

        Sections::create([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'content' => $request->content,
            'image' => $imageName,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'display_on' => $request->display_on,
            'order' => $request->order,
        ]);

        return redirect()->route('sections.index')->with('success', 'Section added successfully');
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
        $section = Sections::find($id);
        return view('sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_link' => 'nullable|url',
            'display_on' => 'required|in:Home,About,Services,Contact,Pricing',
        ]);

        $section = Sections::find($id);

        $imageName = $section->image;
        $destinationPath = public_path('images/sections');

        if ($request->hasFile('image')) {
            $imageName = $this->processImage($request->file('image'), $destinationPath);
        }

        $section->update([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'content' => $request->content,
            'image' => $imageName,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'display_on' => $request->display_on,
            'order' => $request->order,
        ]);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = Sections::find($id);
        $section->status = 'Deleted';
        $section->save();
        return redirect()->route('sections.index')->with('success', 'Section deleted successfully');
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
