<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolboxTalk extends Model
{
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
    }
}
