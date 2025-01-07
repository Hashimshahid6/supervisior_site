<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\ProjectFiles;
use App\Services\PayPalService;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user

        // Fetch package project limit
        $packageLimit = @$user->package->project_limit;

        // Count user's uploaded projects
        $uploadedProjects = $user->projects()->where('status', 'Active')->count();

        // Determine if the user can add more projects
        $canAddProject = $uploadedProjects < $packageLimit;

        // Get all projects and deleted projects with pagination
        $perPage = $request->input('per_page', 10); // Default to 10 if not provided
        $projects = Projects::getAllProjects()->paginate($perPage);
        $deletedProjects = Projects::with('user', 'messages')->where('status', 'Deleted')->paginate($perPage);

        // Pass data to the view
        return view('projects.list', compact('projects', 'deletedProjects', 'canAddProject', 'uploadedProjects', 'packageLimit'));
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
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'files.*' => 'required|file|mimes:pdf',
        ]);

        $project = Projects::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = $file->getClientOriginalName();
                $file->move('public/uploads/projects', $fileName);
                ProjectFiles::create([
                    'user_id' => auth()->id(),
                    'project_id' => $project->id,
                    'file' => $fileName,
                ]);
            }
        }

        session()->flash('success', 'Project added successfully');
        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the project along with the associated user
        $project = Projects::with(['user', 'messages', 'projectFiles'])->find($id);

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
        $project = Projects::with('projectFiles')->find($id);
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
            'files.*' => 'nullable|file|mimes:pdf',
        ]);

        $project = Projects::find($id);
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = $file->getClientOriginalName();
                $file->move('public/uploads/projects', $fileName);
                ProjectFiles::create([
                    'user_id' => auth()->id(),
                    'project_id' => $project->id,
                    'file' => $fileName,
                ]);
            }
        }

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

    /**
     * Remove the specified file from storage.
     */
    public function destroyFile($id)
    {
        $file = ProjectFiles::find($id);

        if ($file) {
            $filePath = public_path('uploads/projects/' . $file->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $file->delete();

            return response()->json([
                'status' => true,
                'message' => 'File deleted successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'File not found',
        ], 404);
    }
    public function payment_intent()
    {
        $paypalService = new PayPalService();
        $paymentIntent = $paypalService->createPaymentIntent(10);
        return response()->json($paymentIntent);
    }
    public function capturePayment($orderId)
    {
        $paypalService = new PayPalService();
        $paymentIntent = $paypalService->capturePayment($orderId);
        return response()->json($paymentIntent);
    }
    public function retrievePaymentIntent($orderId)
    {
        $paypalService = new PayPalService();
        $paymentIntent = $paypalService->retrievePaymentIntent($orderId);
        return response()->json($paymentIntent);
    }
}