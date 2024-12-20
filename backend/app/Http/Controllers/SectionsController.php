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

        if ($request->hasFile('image')) {
            // Step 1: Upload original image
            $image = $request->file('image');
            $originalName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/sections');

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

        Sections::create([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'content' => $request->content,
            'image' => $name,
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

        if ($request->hasFile('image')) {
            // Step 1: Upload original image
            $image = $request->file('image');
            $originalName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/sections');

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

            $section->image = $name;
        }

        $section->update([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'content' => $request->content,
            'image' => $section->image ?? $request->image,
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
    }
}
