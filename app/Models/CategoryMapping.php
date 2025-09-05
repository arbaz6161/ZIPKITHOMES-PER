<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractor_id',
        'contractor_name',
        'category_ids',
    ];

    protected $table = 'category_mapping';
}
