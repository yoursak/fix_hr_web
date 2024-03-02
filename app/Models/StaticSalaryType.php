<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticSalaryType extends Model
{
    use HasFactory;

    protected $table = 'static_salary_type';
    protected $primary_key = 'salary_type_id';
    public $timestamps = false;


    protected $fillable = [
        'salary_type_id ',
        'salary_type_name',
        'employee_type'
    ];
}
