<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonials;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonials::getTestimonials();
        return view('testimonials.list', compact('testimonials'));
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

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $destinationPath = public_path('/images/testimonials');
            $avatar->move($destinationPath, $avatarName);
        }

        if ($request->hasFile('bgImage')) {
            $bgImage = $request->file('bgImage');
            $bgImageName = time() . '.' . $bgImage->getClientOriginalExtension();
            $destinationPath = public_path('/images/testimonials');
            $bgImage->move($destinationPath, $bgImageName);
        }

        Testimonials::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'avatar' => $avatarName ?? $request->avatar,
            'bgImage' => $bgImageName ?? $request->bgImage,
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

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $destinationPath = public_path('/images/testimonials');
            $avatar->move($destinationPath, $avatarName);
            $testimonial->avatar = $avatarName;
        }

        if ($request->hasFile('bgImage')) {
            $bgImage = $request->file('bgImage');
            $bgImageName = time() . '.' . $bgImage->getClientOriginalExtension();
            $destinationPath = public_path('/images/testimonials');
            $bgImage->move($destinationPath, $bgImageName);
            $testimonial->bgImage = $bgImageName;
        }

        Testimonials::find($id)->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'avatar' => $testimonial->avatar ?? $request->avatar,
            'bgImage' => $testimonial->bgImage ?? $request->bgImage,
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
    }
}
