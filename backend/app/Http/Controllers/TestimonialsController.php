<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonials;
use Illuminate\Support\Facades\Auth;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role != 'Employee'){
            $testimonials = Testimonials::getTestimonials();
            return view('testimonials.list', compact('testimonials'));
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
        return view('testimonials.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'designation' => 'required|string',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bgImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        $avatarName = null;
        $bgImageName = null;

        $destinationPath = public_path('images/testimonials');

        if ($request->hasFile('avatar')) {
            $avatarName = $this->processImage($request->file('avatar'), $destinationPath);
        }

        if ($request->hasFile('bgImage')) {
            $bgImageName = $this->processImage($request->file('bgImage'), $destinationPath);
        }

        Testimonials::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'avatar' => $avatarName,
            'bgImage' => $bgImageName,
            'description' => $request->description,
        ]);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial added successfully.');
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
        $testimonial = Testimonials::find($id);
        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'designation' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bgImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'status' => 'required|in:Active,Inactive,Deleted',
        ]);

        $testimonial = Testimonials::find($id);

        $avatarName = $testimonial->avatar;
        $bgImageName = $testimonial->bgImage;

        $destinationPath = public_path('images/testimonials');

        if ($request->hasFile('avatar')) {
            $avatarName = $this->processImage($request->file('avatar'), $destinationPath);
        }

        if ($request->hasFile('bgImage')) {
            $bgImageName = $this->processImage($request->file('bgImage'), $destinationPath);
        }

        Testimonials::find($id)->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'avatar' => $avatarName,
            'bgImage' => $bgImageName,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonial = Testimonials::find($id);
        $testimonial->status = 'Deleted';
        $testimonial->save();

        return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted successfully.');
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
