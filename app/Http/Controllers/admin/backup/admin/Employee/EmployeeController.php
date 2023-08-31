<?php

namespace App\Http\Controllers\admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;



class EmployeeController extends Controller
{
    public function index(){
        return view('admin.employees.employee');
    }

    public function add(){
        return view('admin.employees.addemp');
    }

    public function empProfile(Request $request){
        // echo $request->id;
        return view('admin.employees.emp_profile',['id'=>$request->id]);
    }


    // add employee 
    public function AddEmployee(Request $request){
        // dd($request);
            DB::table('employee_personal_details')->insert([
            'business_id' => $request->session()->get('business_id'),
            'employee_type' => $request->employee_type,
            'emp_name' => $request->name,
            'emp_id' => $request->emp_id,
            'emp_mobile_number' => $request->mobile_number,
            'emp_email' => $request->email,
            'branch_id' => $request->branch,
            'emp_department' => $request->department,
            'emp_designation' => $request->designation,
            'emp_date_of_birth' => $request->dob,
            'emp_date_of_joining' => $request->doj,
            'emp_gender' => $request->gender,
            'emp_address' => $request->address,
            'emp_country' => $request->country,
            'emp_state' => $request->state,
            'emp_city' => $request->city,
            'emp_pin_code' => $request->pincode,
            'profile_photo' => $request->photo,
            'created_at' => now(),
            'updated_at' => now()    
        ]);
    
        return redirect('admin/employee');
    } 

}
