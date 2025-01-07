<?php

namespace App\Http\Controllers;

use App\Models\PlantChecklist;
use Illuminate\Http\Request;
use App\Models\Projects;
use App\Mail\VehicleChecklistMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\VehicleChecklist;

class VehicleChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = Projects::getAllProjects()->get();
        // dd($projects[0]);
        $VehicleItems = VehicleChecklist::$VehicleItems;
        $perPage = $request->input('per_page', 10);
        $VehicleChecklists = VehicleChecklist::getAllVehicleChecklist()->paginate($perPage);
        return view('vehicle_checklist.list', compact('VehicleChecklists', 'VehicleItems', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Days = PlantChecklist::$Days;
        $Projects = Projects::getAllProjects()->get();
        $VehicleItems = VehicleChecklist::$VehicleItems;
        $VehicleData = VehicleChecklist::$VehicleData;
        return view('vehicle_checklist.add', compact('VehicleItems', 'VehicleData', 'Projects', 'Days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'project_id' => 'required|integer',
            'checklist' => 'required|array',
            'vehicle_data' => 'nullable|array',
        ]);

        $checklistData = json_encode($request->input('checklist'));
        $vehicleData = json_encode($request->only(['vehicle_registration', 'date', 'driver_name', 'miles']));
        $defectData = json_encode($request->only(['defect', 'date_reported', 'useable', 'reported_to', 'operator']));

        VehicleChecklist::create([
            'project_id' => $request->project_id,
            'user_id' => auth()->id(),
            'plant_type' => $request->plant_type,
            'checklist' => $checklistData,
            'vehicle_data' => $vehicleData,
            'reports' => $defectData,
            'status' => $request->action == 'save' ? 'incomplete' : 'complete'
        ]);

        return redirect()->route('vehicle_checklists.index')->with('success', $request->action == 'save' ? 'Vehicle Checklist Checklist saved successfully' : 'Vehicle Checklist submitted successfully');
    }//

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $VehicleItems = VehicleChecklist::$VehicleItems;
        $VehicleData = VehicleChecklist::$VehicleData;
        $Days = PlantChecklist::$Days;
        $DailyChecklist = VehicleChecklist::with(['project', 'user'])->find($id);
        return view('vehicle_checklist.details', compact('DailyChecklist', 'VehicleItems', 'VehicleData', 'Days'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $VehicleItems = VehicleChecklist::$VehicleItems;
        $VehicleData = VehicleChecklist::$VehicleData;
        $Days = PlantChecklist::$Days;
        $Projects = Projects::getAllProjects()->get();

        $DailyChecklist = VehicleChecklist::with(['project', 'user'])->find($id);
        // dd($DailyChecklist);

        return view('vehicle_checklist.edit', compact('DailyChecklist', 'VehicleItems', 'VehicleData', 'Projects', 'Days'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'checklist' => 'required|array',
            'vehicle_data' => 'nullable|array',
        ]);
    
        $VehicleItems = VehicleChecklist::$VehicleItems;
        $VehicleData = VehicleChecklist::$VehicleData;
        $Days = PlantChecklist::$Days;
        $email = Auth::user()->email;
    
        $checklistData = json_encode($request->input('checklist'));
        $vehicleData = json_encode($request->only(['vehicle_registration', 'date', 'driver_name', 'miles']));
        $defectData = json_encode($request->only(['defect', 'date_reported', 'useable', 'reported_to', 'operator']));
    
        $DailyChecklist = VehicleChecklist::find($id);
        $DailyChecklist->update([
            'project_id' => $request->project_id,
            'checklist' => $checklistData,
            'vehicle_data' => $vehicleData,
            'reports' => $defectData,
            'status' => $request->action == 'save' ? 'incomplete' : 'complete'
        ]);
    
        if ($request->action == 'submit') {
            $pdf = Pdf::loadView('emails.vehicle_checklist', compact('DailyChecklist', 'VehicleItems', 'VehicleData', 'Days'));
    
            // Save the PDF to public/uploads/pdf
            $pdfPath = public_path('uploads/pdf/Vehicle_Checklist_' . time() . '.pdf');
            $pdf->save($pdfPath);
            // Send the email with the PDF attached
            Mail::to($email)->send(new VehicleChecklistMail($DailyChecklist, $pdfPath, $VehicleItems, $VehicleData, $Days));
    
            // Delete the file after sending the email
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
    
        return redirect()->route('vehicle_checklists.index')->with('success', $request->action == 'save' ? 'Vehicle Checklist saved successfully' : 'Vehicle Checklist submitted successfully');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}