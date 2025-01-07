<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolboxTalk extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'user_id',
        'topic',
        'presented_by',
        'toolbox_talk',
        'status',
        'created_by',
        'updated_by'
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
    } //end of boot

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }//

    public static function getAllToolBoxTalk()
    {
        $query = ToolboxTalk::with(['project', 'user']); // Corrected the with method

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
    }//

    public function scopeFilter($query, $filters)
    {
        if(isset($filters['project_id']) && $filters['project_id'] != '') {
            $query->where('project_id', $filters['project_id']);
        }

        if(isset($filters['search']) && $filters['search'] != '') {
            $query->where(function ($q) use ($filters) {
                $q->whereHas('project', function ($query) use ($filters) {
                    $query->where('name', 'like', '%' . $filters['search'] . '%');
                })->orWhere('topic', 'like', '%' . $filters['search'] . '%')
                ->orWhere('presented_by', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        if(isset($filters['status']) && $filters['status'] != '') {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['sort_by']) && isset($filters['sort_order'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_order']);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }//
}
