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
            'display_on' => 'required|in:Home,About,Services,Contact',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images/banners'), $imageName);
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
            'status' => 'required|in:Active,Inactive,Deleted',
        ]);

        $banner = Banners::find($id);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images/banners'), $imageName);
            $banner->image = $imageName;
        }//

        $banner->update([
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'image' => $banner->image ?? $request->image,
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
