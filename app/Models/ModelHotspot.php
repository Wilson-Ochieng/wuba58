<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHotspot extends Model
{
    protected $fillable = [
        'project_id', 'label',
        'position_x', 'position_y', 'position_z',
        'normal_x', 'normal_y', 'normal_z',
        'description', 'color', 'order',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}