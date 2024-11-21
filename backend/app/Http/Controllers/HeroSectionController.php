<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSection;

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
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/hero-section');
            $image->move($destinationPath, $name);
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
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/hero-section');
            $image->move($destinationPath, $name);
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
