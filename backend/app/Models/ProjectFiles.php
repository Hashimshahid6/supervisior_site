<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFiles extends Model
{
    protected $table = 'project_files';
    protected $fillable = ['user_id', 'project_id', 'file'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->created_by = auth()->id();
        });
        self::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }//

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }//

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id', 'id');
    }
}
