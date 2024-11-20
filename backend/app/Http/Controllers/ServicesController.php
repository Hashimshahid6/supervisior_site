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
        return response()->json($services);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
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
            'icon' => $iconName ?? $request->icon,
            'bgImage' => $bgImageName ?? $request->bgImage,
        ]);

        return response()->json(['message' => 'Service created successfully.']);
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
        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required | image | mimes:jpeg,png,jpg,gif,svg | max:2048',
            'bgImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:Active,Inactive,Deleted',
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

        Services::find($id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $iconName ?? $request->icon,
            'bgImage' => $bgImageName ?? $request->bgImage,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Service updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Services::find($id);
        $service->status = 'Deleted';
        $service->save();
        return response()->json(['message' => 'Service deleted successfully.']);
    }
}
