<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractorSetting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'contractor_id', 'home_url', 'about_url', 'contact_url'
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, "id");
    }

}
