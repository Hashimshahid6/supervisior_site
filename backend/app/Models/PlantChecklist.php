<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantChecklist extends Model
{
    use HasFactory;
    protected $table = 'plant_checklists';

    protected $fillable = [
        'user_id',
        'project_id',
        'plant_type',
        'checklist',
        'reports',
        'status'
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getAllPlantChecklist()
    {

        $query = PlantChecklist::query();
        $query->with('project', 'user');

        if (auth()->user()->role == 'Employee') {
            // Employee can see only their own records
            $query->where('user_id', auth()->id());
        } elseif (auth()->user()->role == 'Company') {
            // The logged-in user is the company
            $companyId = auth()->id(); // The company's ID in the `users` table

            // Get the IDs of employees belonging to this company
            $employeeIds = User::where('company_id', $companyId)->pluck('id');

            // Include forms created by employees
            $query->whereIn('user_id', $employeeIds);
        }

        if (request()->has('search') && request()->search != '') {
            $query->where(function ($q) {
                $q->whereHas('project', function ($query) {
                    $query->where('name', 'like', '%' . request()->search . '%');
                })
                ->orWhere('plant_type', 'like', '%' . request()->search . '%');
            });
        }

        if (request()->has('project_id') && request()->project_id != '') {
            $query->where('project_id', request()->project_id);
        }

        if(request()->has('plant_type') && request()->plant_type != '') {
            $query->where('plant_type', request()->plant_type);
        }

        if (request()->has('status') && request()->status != '') {
            $query->where('status', request()->status);
        }

        if (request()->has('sort_by') && request()->has('sort_order')) {
            $query->orderBy(request()->sort_by, request()->sort_order);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }
}
