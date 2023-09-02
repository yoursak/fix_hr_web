<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayTemplate extends Model
{
    use HasFactory;
    protected $table = "holiday_template";
    protected $primary_key = "temp_id";

    protected $fillable = [
        "temp_name",
        "temp_from",
        "temp_to",
        "business_id"
    ] ;
}
