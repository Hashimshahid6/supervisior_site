<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Services::getServices();
        return view('services.list', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'required|string',
            'button_url' => 'required|url',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bgImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $iconName = $this->handleImageUpload($request->file('icon'), 'services');
        $bgImageName = $this->handleImageUpload($request->file('bgImage'), 'services');

        Services::create([
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'icon' => $iconName,
            'bgImage' => $bgImageName,
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
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
        $service = Services::find($id);
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'required|string',
            'button_url' => 'required|url',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bgImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:Active,Inactive,Deleted',
        ]);

        $service = Services::find($id);

        if ($request->hasFile('icon')) {
            $service->icon = $this->handleImageUpload($request->file('icon'), 'services');
        }

        if ($request->hasFile('bgImage')) {
            $service->bgImage = $this->handleImageUpload($request->file('bgImage'), 'services');
        }

        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'icon' => $service->icon ?? $request->icon,
            'bgImage' => $service->bgImage ?? $request->bgImage,
            'status' => $request->status,
        ]);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Services::find($id);
        $service->status = 'Deleted';
        $service->save();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    private function handleImageUpload($image, $folder)
    {
        $originalName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images/' . $folder);

        $image->move($destinationPath, $originalName);

        $webpName = time() . '.webp';
        $originalPath = $destinationPath . '/' . $originalName;
        $webpPath = $destinationPath . '/' . $webpName;

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
                case 'image/jpg':
                    $sourceImage = imagecreatefromjpeg($originalPath);
                    break;
                default:
                    throw new \Exception('Unsupported image type');
            }

            imagewebp($sourceImage, $webpPath, 90);
            imagedestroy($sourceImage);

            unlink($originalPath);

            return $webpName;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
