<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourHotspot extends Model
{
    protected $fillable = [
        'tour_scene_id',
        'target_scene_id',
        'yaw',
        'pitch',
        'label',
        'type',
        'url',
        'description',
    ];

    protected $casts = [
        'yaw' => 'float',
        'pitch' => 'float',
    ];

    public function scene()
    {
        return $this->belongsTo(TourScene::class, 'tour_scene_id');
    }

    public function targetScene()
    {
        return $this->belongsTo(TourScene::class, 'target_scene_id');
    }
}