<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactFormLogs extends Model
{
    use HasFactory;

    protected $table = "contact_form_logs";

    protected $fillable = [
        "contractor_id",
        "name",
        "email",
        "state",
        "zip_code",
        "interest_in_buy",
        "interest_in_floor_plan",
        "number_of_home",
        "budget",
        "time_frame",
        "comment"
    ];

    public static $number_of_homes = [
        "1" => "1",
        "2" => "2 ~ 5",
        "3" => "5 ~ 10",
        "4" => "10 +",
    ];

    public static $budgets = [
        "1" => "Under $100",
        "2" => "$100 to $250k",
        "3" => "$250k to $400k",
        "4" => "$400K - $600K",
        "5" => "Over $600K",
    ];

    public static $time_frames = [
        "1" => "ASAP",
        "2" => "3 to 6 months",
        "3" => "6-months to 1 year",
        "4" => "1 to 2 years",
        "5" => "More than 2 years",
    ];
}
