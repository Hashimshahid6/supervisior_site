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
            'icon' => 'required | image | mimes:jpeg,png,jpg,gif,svg | max:2048',
            'bgImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '.' . $icon->getClientOriginalExtension();
            $destinationPath = public_path('/images/services');
            $icon->move($destinationPath, $iconName);
        }

        if ($request->hasFile('bgImage')) {
            $bgImage = $request->file('bgImage');
            $bgImageName = time() . '.' . $bgImage->getClientOriginalExtension();
            $destinationPath = public_path('/images/services');
            $bgImage->move($destinationPath, $bgImageName);
        }

        Services::create([
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'icon' => $iconName ?? $request->icon,
            'bgImage' => $bgImageName ?? $request->bgImage,
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
            'icon' => 'nullable | image | mimes:jpeg,png,jpg,gif,svg | max:2048',
            'bgImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:Active,Inactive,Deleted',
        ]);

        $service = Services::find($id);

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '.' . $icon->getClientOriginalExtension();
            $destinationPath = public_path('/images/services');
            $icon->move($destinationPath, $iconName);
            $service->icon = $iconName;
        }

        if ($request->hasFile('bgImage')) {
            $bgImage = $request->file('bgImage');
            $bgImageName = time() . '.' . $bgImage->getClientOriginalExtension();
            $destinationPath = public_path('/images/services');
            $bgImage->move($destinationPath, $bgImageName);
            $service->bgImage = $bgImageName;
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
}
