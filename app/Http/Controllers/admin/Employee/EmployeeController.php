<?php

namespace App\Http\Controllers\admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Session;
use RealRashid\SweetAlert\Facades\Alert;



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
        if(Session::has('business_id')){
            return view('admin.employees.emp_profile',['id'=>$request->id]);
            // return view('admin.dashboard.dashboard');
        }else{
            return back();
        }
    }


    // add employee 
    public function AddEmployee(Request $request){
        // dd($request);
         $added = DB::table('employee_personal_details')->insert([
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
        ]);

        if(isset($added)){
            Alert::success('Added Successfully', 'Your Employee Detail is Added Successfully');
            return redirect('admin/employee');
        }
        Alert::error('Not Updated', 'Your Employee Detail Updation is Fail');
        return redirect('admin/employee');
    } 

    public function UpdateEmployee(Request $request){
        // dd($request);
        $updated = DB::table('employee_personal_details')->where('emp_id',$request->emp_id)->update([
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
            'emp_pin_code' => $request->pin,
            'profile_photo' => $request->photo, 
        ]);

        if(isset($updated)){
            Alert::success('Updated Successfully', 'Your Employee Detail is Updated Successfully');
            return redirect('admin/employee');
        }
        Alert::error('Not Updated', 'Your Employee Detail Updation is Fail');
        return redirect('admin/employee');
    }
    public function DeleteEmployee(Request $request){
       echo $request->id;
       DB::table('employee_personal_details')->where('emp_id',$request->id)->delete();
       Alert::success('Deleted Successfully', 'Success Message');
       return redirect('admin/employee');
    }

}
