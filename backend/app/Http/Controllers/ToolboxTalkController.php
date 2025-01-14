<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToolboxTalk;
use App\Mail\ToolboxTalkMail;
use App\Models\Projects;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ToolboxTalkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->role == 'Employee') {
            $companyId = User::where('id', auth()->id())->pluck('company_id')->first();
            $projects = Projects::where('status', 'Active')->where('user_id', $companyId)->get();
        } elseif($user->role == 'Company') {
            $projects = Projects::where('status', 'Active')->where('user_id', $user->id)->get();
        } else {
            $projects = Projects::where('status', 'Active')->get();
        }
        $perPage = $request->input('per_page', 10);
        $toolboxTalks = ToolboxTalk::getAllToolBoxTalk()->paginate($perPage);
        return view('toolbox_talks.list', compact('toolboxTalks', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if($user->role == 'Employee') {
            $companyId = User::where('id', auth()->id())->pluck('company_id')->first();
            $projects = Projects::where('status', 'Active')->where('user_id', $companyId)->get();
        }
        return view('toolbox_talks.add', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'project_id' => 'required|integer',
            'topic' => 'required | string',
            'presented_by' => 'required | string',
        ]);

        $toolboxTalks = json_encode($request->only(['first_name', 'surname', 'date']));

        $test = ToolboxTalk::create([
            'project_id' => $request->project_id,
            'user_id' => auth()->id(),
            'topic' => $request->topic,
            'presented_by' => $request->presented_by,
            'toolbox_talk' => $toolboxTalks,
            'status' => $request->action == 'save' ? 'incomplete' : 'complete'
        ]);

        return redirect()->route('toolbox_talks.index')->with('success', $request->action == 'save' ? 'Toolbox Talk saved successfully' : 'Toolbox Talk completed successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $toolboxTalk = ToolboxTalk::with('project')->find($id);
        return view('toolbox_talks.details', compact('toolboxTalk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if($user->role == 'Employee') {
            $companyId = User::where('id', auth()->id())->pluck('company_id')->first();
            $projects = Projects::where('status', 'Active')->where('user_id', $companyId)->get();
        }
        $toolboxTalk = ToolboxTalk::find($id);
        return view('toolbox_talks.edit', compact('toolboxTalk', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'topic' => 'required | string',
            'presented_by' => 'required | string',
        ]);
        $email = Auth::user()->email;

        $toolboxData = json_encode($request->only(['first_name', 'surname', 'date']));

        $toolboxTalk = ToolboxTalk::find($id);

        $toolboxTalk->update([
            'project_id' => $request->project_id,
            'topic' => $request->topic,
            'presented_by' => $request->presented_by,
            'toolbox_talk' => $toolboxData,
            'status' => $request->action == 'save' ? 'incomplete' : 'complete'
        ]);

        if ($request->action == 'submit') {
            $pdf = Pdf::loadView('emails.toolbox_talks', compact('toolboxTalk'));
    
            // Save the PDF to public/uploads/pdf
            $pdfPath = public_path('uploads/pdf/Toolbox_Talk_Template' . time() . '.pdf');
            $pdf->save($pdfPath);
            // Send the email with the PDF attached
            Mail::to($email)->send(new ToolboxTalkMail($toolboxTalk, $pdfPath));
    
            // Delete the file after sending the email
            // if (file_exists($pdfPath)) {
            //     unlink($pdfPath);
            // }
        }

        return redirect()->route('toolbox_talks.index')->with('success', $request->action == 'save' ? 'Toolbox Talk saved successfully' : 'Toolbox Talk completed successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
