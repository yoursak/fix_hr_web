<?php

namespace App\Http\Controllers\admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\employee\EmployeePersonalDetail;
use App\Helpers\Central_unit;

use App\Exports\AddEmployeeDetails;
use App\Exports\ExportEmployeeDetails;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index()
    {
        // dd($data);
        $call = new Central_unit();
        $Branch = $call->BranchList();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $attendanceMethod = DB::table('attendance_methods')->get();
        // dd($attendanceMethod);
        $shiftAttendance = DB::table('attendance_shift_settings')
            ->join('attendance_shift_type', 'attendance_shift_settings.shift_type', '=', 'attendance_shift_type.id')
            ->where('business_id', Session::get('business_id'))
            ->select('attendance_shift_settings.id as attendance_id', 'attendance_shift_settings.shift_type_name',      )
            // ->orderBy()
            ->get();
            // dd($shiftAttendance);
            // dd($shiftAttendance);
        // dd($shiftAttendance);
        // $call = new Central_unit();
        // $Branch = $call->BranchList();
        // $accessPermission = Central_unit::AccessPermission();
        // $moduleName = $accessPermission[0];
        // $permissions = $accessPermission[1];
        // $root= compact('moduleName', 'permissions');
        // $itemt = DB::table('employee_personal_details')
        //     ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
        //     ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
        //     ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
        //     ->get();
        // ->select('employee_personal_details.*', 'branch_list.branch_name', 'designation_list.desig_name')->get();
        // dd($itemt);
        $DATA = DB::table('employee_personal_details')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->orderBy('employee_personal_details.id','desc')

            ->get();
        // dd($DATA);
        return view('admin.employees.employee', compact('DATA', 'Branch', 'moduleName', 'permissions', 'shiftAttendance', 'attendanceMethod'));
    }

    //Import Files
    public function ImportAddEmployeeDetails(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:xlsx,txt', // Modify validation rules as needed
        ]);

        $file = $request->file('csv_file');
        Excel::import(new EmployeeImport(), $file);

        // Process the uploaded file using Maatwebsite/Excel
        // return   Excel::import(new AddEmployeeDetails, $file);

        // return redirect()->route('upload-employees')->with('success', 'Employee data uploaded successfully.');
    }

    // employee download
    public function ExportFileEmpDetails()
    {
        return Excel::download(new ExportEmployeeDetails(), 'Employee Excel Demo.xlsx');
    }

    public function add()
    {
        return view('admin.employees.addemp');
    }

    public function empProfile(Request $request)
    {
        // dd($id);
        // DB::enableQueryLog();

        $session_id = Session::get('business_id');
        $DATA = DB::table('employee_personal_details')
            ->Join('attendance_methods', 'employee_personal_details.emp_attendance_method', '=', 'attendance_methods.id')
            ->Join('attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'attendance_shift_settings.id')
            ->Join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->Join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->Join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->where('employee_personal_details.emp_id', $request->id)
            ->where('employee_personal_details.business_id', $session_id)
            ->first();

        // dd($shift);

        if (Session::has('business_id')) {
            return view('admin.employees.emp_profile', compact('DATA'));
            // return view('admin.dashboard.dashboard');
        } else {
            return back();
        }
    }

    // add employee

    public function AddContractualEmployee(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Adjust max size as needed
        ]);

        // Get the uploaded image file
        $image = $request->file('image');

        // Generate a unique image name
        $imageName = date('d-m-Y') . '_' . md5(time()) . '.' . $image->getClientOriginalExtension();

        // Move the uploaded image to the desired directory
        $image->move(public_path('employee_profile/'), $imageName);

        // dd($request);
        $added = DB::table('employee_personal_details')->insert([
            'business_id' => $request->session()->get('business_id'),
            'employee_type' => 2,
            'emp_name' => $request->name,
            'emp_id' => $request->emp_id,
            'emp_mobile_number' => $request->mobile_number,
            'emp_email' => $request->email,
            'branch_id' => $request->branch,
            'department_id' => $request->department,
            'designation_id' => $request->designation,
            'emp_date_of_birth' => $request->dob,
            'emp_date_of_joining' => $request->doj,
            'emp_gender' => $request->gender,
            'emp_address' => $request->address,
            'emp_country' => $request->country,
            'emp_state' => $request->state,
            'emp_city' => $request->city,
            'emp_pin_code' => $request->pincode,
            'profile_photo' => $imageName,
        ]);

        $loginEmp = DB::table('login_employee')->insert([
            'emp_id' => $request->emp_id,
            'business_id' => $request->session()->get('business_id'),
            'name' => $request->name,
            'email' => $request->email,
            'country_code' => '+91',
            'phone' => $request->mobile_number,
        ]);

        if (isset($added) && isset($loginEmp)) {
            Alert::success('Added Successfully', 'Your Employee Detail is Added Successfully');
            return redirect('admin/employee');
        }
        Alert::error('Not Updated', 'Your Employee Detail Updation is Fail');
        return redirect('admin/employee');
    }

    public function UpdateEmployee(Request $request)
    {
        $load = DB::table('employee_personal_details')
            ->where('emp_id', $request->emp_id)
            ->select('profile_photo')
            ->first();

        // dd();
        // Validate the request data
        if ($request->image) {
            $validatedData = $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                // Adjust max size as needed
            ]);

            // Get the uploaded image file
            $image = $request->file('image');

            // Generate a unique image name
            $imageName = date('d-m-Y') . '_' . md5(time()) . '.' . $image->getClientOriginalExtension();

            // Move the uploaded image to the desired directory
            $image->move(public_path('employee_profile/'), $imageName);
        }

        // Update employee details in the database
        $updated = DB::table('employee_personal_details')
            ->where('emp_id', $request->emp_id)
            ->update([
                'business_id' => $request->session()->get('business_id'),
                'employee_type' => 1,
                'emp_name' => $request->name,
                'emp_mname' => $request->mName,
                'emp_lname' => $request->lName,
                'emp_mobile_number' => $request->mobile_number,
                'emp_email' => $request->email_sd,
                'emp_date_of_birth' => $request->dob,
                'emp_gender' => $request->update_gender,
                'emp_country' => $request->country,
                'emp_state' => $request->state,
                'emp_city' => $request->city,
                'emp_pin_code' => $request->pincode,
                'emp_address' => $request->address,
                'emp_id' => $request->emp_id,
                'emp_shift_type' => $request->shift_type,
                'branch_id' => $request->branch_id2,
                'department_id' => $request->department_id,
                'designation_id' => $request->designation_id1,
                'emp_date_of_joining' => $request->doj,
                'emp_attendance_method' => $request->attendance_method,
                'profile_photo' => $request->image ?? false && $request->has('image') ? $imageName : $load->profile_photo,

                // 'business_id' => $request->session()->get('business_id'),
                // 'branch_id' => $request->branch_id2,
                // 'employee_type' => $request->employee_type,
                // 'emp_id' => $request->emp_id,
                // 'emp_name' => $request->first_name,
                // 'department_id' => $request->department_id,
                // 'designation_id' => $request->designation_id1,
                // 'emp_mobile_number' => $request->mobile_number,
                // 'emp_email' => $request->email,
                // 'emp_date_of_birth' => $request->dob,
                // 'emp_date_of_joining' => $request->doj,
                // 'emp_gender' => $request->gender,
                // 'emp_address' => $request->address,
                // 'emp_country' => $request->country,
                // 'emp_state' => $request->state,
                // 'emp_city' => $request->city,
                // 'emp_pin_code' => $request->pin,
                // 'profile_photo' => $imageName? $imageName: '',
            ]);

        // dd($updated);
        if ($updated) {
            Alert::success('Updated Successfully', 'Your Employee Detail is Updated Successfully');
            return redirect('admin/employee');
        } else {
            Alert::error('Not Updated', 'Your Employee Detail Updation is Fail');
            return redirect('admin/employee');
        }
    }

    public function DeleteEmployee(Request $request)
    {
        // dd($request->all());
        // echo $request->delete_employesd;
        $dataDelete = DB::table('employee_personal_details')
            ->where('emp_id', $request->weekly_policy_id)
            ->delete();
        if ($dataDelete) {
            Alert::success('Deleted Successfully', 'Success Message');
        } else {
            Alert::error('Failed');
        }
        return redirect('admin/employee');
    }

    public function filterEmployees(Request $request)
    {
        // dd($request->all());
        $branchId = $request->branch_id;
        // // dd($branchId);
        // // return true;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');

        // // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = DB::table('employee_personal_details')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->get();

        // Return the filtered data as JSON response
        return response()->json(['get' => $filteredData]);
    }

    public function allEmployee(Request $request)
    {
        $days = DB::table('employee_personal_details')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('branch_list.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_id', $request->employee_id)
            ->get();
        return response()->json(['get' => $days]);
    }

    public function empId()
    {
        // return true;

        $data = DB::table('employee_personal_details')
            ->select(DB::raw('MAX(emp_id) as max_emp_id'))
            ->first();

        return response()->json(['get' => $data]);
    }

    public function empIdCheck(Request $request)
    {
        // return $request;
        $data = DB::table('employee_personal_details')
            ->where('emp_id', $request->emp_id)
            ->first();
        // $data = DB::table('employee_personal_details')->select('emp_')get();
        return response()->json(['get' => $data]);
    }
}
