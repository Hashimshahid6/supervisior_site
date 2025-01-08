<?php

namespace App\Http\Controllers;

use App\Models\PlantChecklist;
use Illuminate\Http\Request;
use App\Models\Projects;
use App\Mail\PlantChecklistMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PlantChecklistController extends Controller
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
        $DailyChecklists = PlantChecklist::getAllPlantChecklist()->paginate($perPage);
        $PlantTypes = PlantChecklist::$PlantTypes;

        return view('plant_checklist.list', compact('DailyChecklists', 'projects', 'PlantTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if($user->role == 'Employee') {
            $companyId = User::where('id', auth()->id())->pluck('company_id')->first();
            $Projects = Projects::where('status', 'Active')->where('user_id', $companyId)->get();
        }
        $Days = PlantChecklist::$Days;
        $PlantTypes = PlantChecklist::$PlantTypes;
        $PlantChecklists = PlantChecklist::$PlantChecklists;
        return view('plant_checklist.add', compact('PlantChecklists', 'PlantTypes', 'Projects', 'Days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'plant_type' => 'required|string',
            'plant_details' => 'required|string',
            'checklist' => 'required|array',
        ]);

        $checklistData = json_encode($request->input('checklist'));
        $defectData = json_encode($request->only(['defect', 'date_reported', 'useable', 'reported_to', 'operator']));

        PlantChecklist::create([
            'project_id' => $request->project_id,
            'user_id' => auth()->id(),
            'plant_type' => $request->plant_type,
            'plant_details' => $request->plant_details,
            'checklist' => $checklistData,
            'reports' => $defectData,
            'status' => $request->action == 'save' ? 'incomplete' : 'complete'
        ]);

        return redirect()->route('plant_checklists.index')->with('success', $request->action == 'save' ? 'Checklist saved successfully' : 'Checklist submitted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $PlantChecklists = PlantChecklist::$PlantChecklists;
        $PlantTypes = PlantChecklist::$PlantTypes;
        $Days = PlantChecklist::$Days;
        $DailyChecklist = PlantChecklist::with('project')->find($id);
        return view('plant_checklist.details', compact('DailyChecklist', 'PlantChecklists', 'PlantTypes', 'Days'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if($user->role == 'Employee') {
            $companyId = User::where('id', auth()->id())->pluck('company_id')->first();
            $Projects = Projects::where('status', 'Active')->where('user_id', $companyId)->get();
        }

        $PlantChecklists = PlantChecklist::$PlantChecklists;
        $PlantTypes = PlantChecklist::$PlantTypes;
        $Days = PlantChecklist::$Days;

        $DailyChecklist = PlantChecklist::with('project')->find($id);
        // dd($DailyChecklist);

        return view('plant_checklist.edit', compact('DailyChecklist', 'PlantChecklists', 'PlantTypes', 'Projects', 'Days'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'plant_type' => 'required|string',
            'plant_details' => 'required|string',
            'checklist' => 'required|array',
        ]);
    
        $PlantChecklists = PlantChecklist::$PlantChecklists;
        $PlantTypes = PlantChecklist::$PlantTypes;
        $Days = PlantChecklist::$Days;
        $email = Auth::user()->email;
    
        $checklistData = json_encode($request->input('checklist'));
        $defectData = json_encode($request->only(['defect', 'date_reported', 'useable', 'reported_to', 'operator']));
    
        $DailyChecklist = PlantChecklist::find($id);
        $DailyChecklist->update([
            'project_id' => $request->project_id,
            'plant_type' => $request->plant_type,
            'plant_details' => $request->plant_details,
            'checklist' => $checklistData,
            'reports' => $defectData,
            'status' => $request->action == 'save' ? 'incomplete' : 'complete'
        ]);
    
        if ($request->action == 'submit') {
            $pdf = Pdf::loadView('emails.plant_checklist', compact('DailyChecklist', 'PlantChecklists', 'PlantTypes', 'Days'));
    
            // Save the PDF to public/uploads/pdf
            $pdfPath = public_path('uploads/pdf/Plant_Checklist_' . time() . '.pdf');
            $pdf->save($pdfPath);
            // Send the email with the PDF attached
            Mail::to($email)->send(new PlantChecklistMail($DailyChecklist, $pdfPath, $PlantChecklists, $PlantTypes, $Days));
    
            // Delete the file after sending the email
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
    
        return redirect()->route('plant_checklists.index')->with('success', $request->action == 'save' ? 'Checklist saved successfully' : 'Checklist submitted successfully');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}