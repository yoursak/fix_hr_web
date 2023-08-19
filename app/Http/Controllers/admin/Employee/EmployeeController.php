<?php

namespace App\Http\Controllers\admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        return view('admin.employees.employee');
    }

    public function add(){
        return view('admin.employees.addemp');
    }

    public function empProfile(){
        return view('admin.employees.emp_profile');
    }
}
