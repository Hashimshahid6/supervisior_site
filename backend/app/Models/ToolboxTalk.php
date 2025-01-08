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
    }//end of user

    public static function getAllToolBoxTalk()
    {

        $query = ToolboxTalk::query();
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
                $q->orWhereHas('project', function ($query) {
                    $query->where('name', 'like', '%' . request()->search . '%');
                })->orWhere('topic', 'like', '%' . request()->search . '%')
                ->orWhere('presented_by', 'like', '%' . request()->search . '%');
            });
        }

        if (request()->has('project_id') && request()->project_id != '') {
            $query->where('project_id', request()->project_id);
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
