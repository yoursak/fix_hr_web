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

    public function empProfile(){
        return view('admin.employees.emp_profile');
    }

    public function EmployeeTable($tableName, Request $request)
    {
        // dd($tableName,$name);
        // Check if the table does not exist
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                // $table->boolean('employee_type');
                $table->enum('employee_type', ['1'=>'Regular Employee', '2'=>'Contractual Employee']);
                $table->string('emp_name');
                $table->integer('emp_id');
                $table->string('emp_mobile_number',10);
                $table->string('emp_email_id');
                $table->string('emp_branch');
                $table->string('emp_department');
                $table->string('emp_designation');
                $table->date('emp_date_of_birth')->nullable();
                $table->date('emp_date_of_joining')->nullable();
                $table->enum('emp_gender', ['1'=>'Male', '2'=>'Female', '3'=>'Other']);
                $table->string('emp_address');
                $table->string('emp_country');
                $table->string('emp_state');
                $table->string('emp_city');
                $table->string('emp_pin_code');
                $table->string('profile_photo')->nullable();
                $table->timestamps();
            });
            DB::table($tableName)->insert([
                // 'employee_type' => ($request->employee_type) == 1 ? "Regular" : "Contractual" ,
                'employee_type' => $request->employee_type ,
                'emp_name' => $request->name,
                'emp_id' => $request->emp_id,
                'emp_mobile_number' => $request->mobile_number,
                'emp_email_id' => $request->email,
                'emp_branch' => $request->branch,
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
                'updated_at' => now(),
                // 'verified' => true
                // CHHATTISGARH SWAMI VIVEKANAND TECHNICAL UNIVERSITY, BHILAI
                
            ]);
            // return "Table '$tableName' has been created.";
            return response($request);
        } else {
            return "Table '$tableName' already exists.";
        }
    }
}
