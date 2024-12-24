<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $projectId = request()->get('project_id');
        // $messages = Messages::where('project_id', $projectId)->with('user')->get();
        // return response()->json($messages);
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
        // dd($request->all());
        $request->validate([
            'projects_id' => 'required|integer',
            'message' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif',
        ]);

        $fileName = null;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $file->move('public/uploads/messages', $fileName);
        }

        $message = Messages::create([
            'projects_id' => $request->projects_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'image' => $fileName,
        ]);

        return response()->json([
            'status' => true,
            'message' => $message->load('user'), // Load the user relationship
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project_id = request()->get('project_id');
        $message = Messages::where('project_id', $project_id)->get();
        return response()->json($message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
