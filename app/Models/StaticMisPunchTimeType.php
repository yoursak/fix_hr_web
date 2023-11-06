<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticMisPunchTimeType extends Model
{
    use HasFactory;
    protected $table = 'static_mispunch_timetype';
    public $timestamps = false;
    protected $primary_key = 'id';
}
