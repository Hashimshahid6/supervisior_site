<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Projects::getAllProjects();
        $deletedProjects = Projects::with('user', 'messages')->where('status', 'Deleted')->get();
        // dd($deletedProjects);
        return view('projects.list', compact('projects', 'deletedProjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf',
        ]);


        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->move('public/uploads/projects', $fileName);
        }

        Projects::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'file' => $fileName,
        ]);

        session()->flash('success', 'Project added successfully');
        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    } //

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the project along with the associated user
        $project = Projects::with('user','messages')->find($id);

        // Handle the case where the project is not found
        if (!$project) {
            return response()->json([
                'error' => 'Project not found',
            ], 404);
        }

        return response()->json($project);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Projects::find($id);
        return response()->json([
            'status' => true,
            'errors' => [],
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf',
        ]);

        $project = Projects::find($id);

        $fileName = $project->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->move('public/uploads/projects', $fileName);
        }

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'file' => $fileName,
        ]);

        session()->flash('success', 'Project updated successfully');
        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Projects::find($id);
        $project->status = 'Deleted';
        $project->save();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }
}
