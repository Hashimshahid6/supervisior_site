<?php

namespace App\Http\Controllers;

use App\Models\PlantChecklist;
use Illuminate\Http\Request;
use App\Models\Projects;
use App\Mail\PlantChecklistMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PlantChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $PlantTypes = PlantChecklist::$PlantTypes;
        $DailyChecklists = PlantChecklist::getAllPlantChecklist();
        // dd($DailyChecklists);
        return view('plant_checklist.list', compact('DailyChecklists', 'PlantTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Days = PlantChecklist::$Days;
        $Projects = Projects::getAllProjects();
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
            'plant_type' => 'required|integer',
            'checklist' => 'required|array',
        ]);

        $checklistData = json_encode($request->input('checklist'));
        $defectData = json_encode($request->only(['defect', 'date_reported', 'useable', 'reported_to', 'operator']));

        PlantChecklist::create([
            'project_id' => $request->project_id,
            'created_by' => auth()->id(),
            'plant_type' => $request->plant_type,
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
        $PlantChecklists = PlantChecklist::$PlantChecklists;
        $PlantTypes = PlantChecklist::$PlantTypes;
        $Days = PlantChecklist::$Days;
        $Projects = Projects::getAllProjects();

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
            'plant_type' => 'required|integer',
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
            'updated_by' => auth()->id(),
            'plant_type' => $request->plant_type,
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