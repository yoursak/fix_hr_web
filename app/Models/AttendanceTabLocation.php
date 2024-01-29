<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class AttendanceTabLocation extends Model
{
    protected $table = 'attendance_tab_location_list';
    protected $primary_key = 'id';
    protected $business_id = 'business_id';
    protected $fillable = [
        'business_id',
        'punch_time',
        'attendance_id',
        'latitude',
        'logitude',
        'address',
        'created_at',
        'updated_at'
    ];


}