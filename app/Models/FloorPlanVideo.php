<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FloorPlanVideo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'floor_plan_id',
        'vid_name',
        'vid_url',
        'vid_key',
    ];
}
