<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleChecklist extends Model
{
    protected $table = 'vehicles';
    protected $fillable = [
        'project_id',
        'user_id',
        'vehicle_data',
        'checklist',
        'reports',
        'status',
        'created_by', // Add this line
        'updated_by'  // Add this line
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->created_by = auth()->id();
        });
        self::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    } //
    
    public static $VehicleData = [
        'Vehicle Registration',
        'Date',
        'Driver Name',
        'Odometer (km/miles) reading',
    ];

    public static $VehicleItems = [
        'Engine Oil',
        'Coolant Level',
        'Brake Fluid Level',
        'Steering Fluid Level',
        'Washer Fluid Level',
        'Wipers',
        'Lights & Horn',
        'Tyre Thread & Sidewall',
        'Tyre Pressure',
        'Bodywork',
        'Mirrors & Glass',
        'First Aid Kit',
        'Fire Extinguisher',
        'Tidy',
        'General Mechanical'
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getAllVehicleChecklist()
    {
        $query = VehicleChecklist::with(['project', 'user']); // Corrected the with method

        // Get the authenticated user
        $authUser = auth()->user();

        // Check role-based conditions
        if ($authUser->role == 'Employee') {
            // Employee can see their own records
            $query->where('user_id', $authUser->id);
        } elseif ($authUser->role == 'Company') {
            // Company can see records created by their employees
            $query->where(function ($q) use ($authUser) {
                $q->whereHas('user', function ($query) use ($authUser) {
                    $query->where('user_id', $authUser->id); // Match `user_id` with the company's ID
                })->orWhere('user_id', $authUser->id); // Include records directly created by the company itself
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
