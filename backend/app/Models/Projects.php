<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projects extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = ['user_id', 'name', 'description', 'status'];

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    } //

    public function messages()
    {
        return $this->hasMany(Messages::class)->with('user');
    }

    public function plantChecklists()
    {
        return $this->hasMany(PlantChecklist::class, 'project_id', 'id');
    }

    public function projectFiles()
    {
        return $this->hasMany(ProjectFiles::class, 'project_id', 'id');
    }

    public static function getAllProjects()
    {
        $query = Projects::query();
        $query->with(['user', 'messages', 'projectFiles']);

        if (auth()->user()->role == 'Employee') {
            $companyId = User::where('id', auth()->id())->pluck('company_id')->first();
            $query->where('user_id', $companyId);
        } elseif (auth()->user()->role == 'Company') {
            $query->where('user_id', auth()->id());
        }

        if (request()->has('search') && request()->search != '') {
            $query->where('name', 'like', '%' . request()->search . '%');
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

    public static function canMakeDeletedProjectActive()
    {
        $user = auth()->user();
        $packageLimit = @$user->package->project_limit;
        $uploadedProjects = $user->projects()->where('status', 'Active')->count();
        return $uploadedProjects < $packageLimit;
    }
}
