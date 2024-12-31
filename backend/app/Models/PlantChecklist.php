<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantChecklist extends Model
{
    protected $table = 'plant_checklists';

    protected $fillable = [
        'project_id',
        'plant_type',
        'checklist',
        'reports',
        'status',
        'created_by',
        'updated_by'
    ];

    public static $PlantTypes = [
        'Dumper',
        'Excavator',
        'Roller',
        'Track Barrow',
        'Bull Dozer',
        'Fork Lift',
        'Other'
    ];

    public static $PlantChecklists = [
        'Brakes',
        'Steering Controls',
        'Mirrors',
        'Seat & Seat Belts',
        'Lights',
        'Rotating Beacon',
        'Warning Lights',
        'Tyres/Tracks',
        'Windows & Doors',
        'Horn',
        'Wipers',
        'Emergency Stop',
        'Oil / Fuel Leaks',
        'Greased Machine'
    ];

    public static $Days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getAllPlantChecklist()
    {
        $query = PlantChecklist::with('project');

        // Get the authenticated user
        $authUser = auth()->user();

        // Check role-based conditions
        if ($authUser->role == 'Employee') {
            // Employee can see their own records
            $query->where('created_by', $authUser->id);
        } elseif ($authUser->role == 'Company') {
            // Company can see records created by their employees
            $query->where(function ($q) use ($authUser) {
                $q->whereHas('user', function ($query) use ($authUser) {
                    $query->where('user_id', $authUser->id); // Match `user_id` with the company's ID
                })->orWhere('created_by', $authUser->id); // Include records directly created by the company itself
            });
        } elseif ($authUser->role == 'Admin') {
            // Admin can see all records
        } else {
            // Return an empty collection if the role doesn't match
            return collect();
        }

        return $query->get();
    }
}
