<?php

namespace App\Http\Controllers\admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\AttendanceList;
use App\Models\EmployeePersonalDetail;
use App\Models\LoginEmployee;
use App\Models\DesignationList;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\StaticEmployeeJoinGenderType;
use App\Models\PolicyAttendanceTrackInOut;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicyMasterEndgameMethod;
use App\Models\StaticAttendanceMethod;
use App\Models\StaticEmployeeJoinMaritalType;
use App\Models\StaticEmployeeJoinCategoryCaste;
use App\Models\StaticEmployeeJoinBloodGroup;
use App\Models\StaticEmployeeJoinGovtDocType;
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
        $attendanceMethod = StaticAttendanceMethod::get();
        // dd($attendanceMethod);
        $shiftAttendance = DB::table('policy_attendance_shift_settings')
            ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
            ->where('business_id', Session::get('business_id'))
            ->select('policy_attendance_shift_settings.id as attendance_id', 'policy_attendance_shift_settings.shift_type_name')
            ->get();

        $DATA = EmployeePersonalDetail::join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->orderBy('employee_personal_details.id', 'desc')
            ->get();

        $staticGender = StaticEmployeeJoinGenderType::get();
        $staticMarital = StaticEmployeeJoinMaritalType::get();
        $statciCategory = StaticEmployeeJoinCategoryCaste::get();
        $staticbloodGroup = StaticEmployeeJoinBloodGroup::get();
        $staticGovId = StaticEmployeeJoinGovtDocType::get();
        return view('admin.employees.employee', compact('DATA', 'Branch', 'moduleName', 'permissions', 'shiftAttendance', 'attendanceMethod', 'staticGender', 'staticMarital', 'statciCategory', 'staticbloodGroup', 'staticGovId'));
    }

    //Import Files
    public function ImportAddEmployeeDetails(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:xlsx,txt', // Modify validation rules as needed
        ]);

        $file = $request->file('csv_file');
        // dd($file);
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
        $DATA = EmployeePersonalDetail::Join('static_attendance_methods', 'employee_personal_details.emp_attendance_method', '=', 'static_attendance_methods.id')
            ->Join('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
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
        // dd($request->all());
        $loginEmployee = LoginEmployee::where('emp_id', $request->update_emp_id)
        ->update([
            'email' => $request->udpate_email,
            'phone' => $request->update_mobile_number,
        ]);
        // dd($loginEmployee);
        

        $load = EmployeePersonalDetail::where('emp_id', $request->update_emp_id)
            ->select('profile_photo')
            ->first();
        // Validate the request data
        if ($request->image) {
            $validatedData = $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $image = $request->file('image');
            $imageName = date('d-m-Y') . '_' . md5(time()) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('employee_profile/'), $imageName);
        }

        // Update employee details in the database
        $updated = EmployeePersonalDetail::where('emp_id', $request->update_emp_id)->update([
            'business_id' => $request->session()->get('business_id'),
            // 'employee_type' => 1,
            // 'business_id' => $request->session()->get('business_id'),
            // 'master_endgame_id' => $masterEndgameId->id,
            // 'employee_type' => $request->employee_type,
            // 'employee_contractual_type' => $request->contractualtype != null ? $request->contractualtype : '0',

            // 'emp_id' => $request->update_emp_id,
            'emp_name' => $request->update_name,
            'emp_mname' => $request->update_mName,
            'emp_lname' => $request->update_lName,
            'emp_mobile_number' => $request->update_mobile_number,
            'emp_email' => $request->udpate_email,
            'emp_date_of_birth' => $request->update_dob,
            'emp_gender' => $request->update_gender,
            'emp_marital_status' => $request->update_marital,
            'emp_country' => $request->update_country,
            'emp_category' => $request->update_category,
            'emp_blood_group' => $request->update_blood,
            'emp_gov_select_id' => $request->update_gov_id,
            'emp_gov_select_id_number' => $request->update_id_no,
            'emp_nationality' => $request->update_nationality,
            'emp_state' => $request->update_state,
            'emp_city' => $request->update_city,
            'emp_pin_code' => $request->update_pincode,
            'emp_address' => $request->update_address,
            'emp_shift_type' => $request->update_shift_type,
            'branch_id' => $request->update_branch,
            'department_id' => $request->update_department,
            'designation_id' => $request->update_designation,
            'emp_reporting_manager' => $request->update_reporting_manager,
            'emp_date_of_joining' => $request->update_doj,
            'emp_attendance_method' => $request->update_attendance_method,
            'profile_photo' => $request->image ?? false && $request->has('image') ? $imageName : $load->profile_photo,
            // 'profile_photo' => $request->image ?? false && $request->has('image') ? $imageName : ($load ? $load->profile_photo : false),
        ]);



        // dd($updated);
        if ($updated && $loginEmployee) {
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
        $dataDelete = EmployeePersonalDetail::where('emp_id', $request->weekly_policy_id)->delete();
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
        $filteredData = EmployeePersonalDetail::join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
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
        $days = EmployeePersonalDetail::join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('branch_list.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_id', $request->employee_id)
            ->get();
        return response()->json(['get' => $days]);
    }

    public function empId()
    {
        $data = EmployeePersonalDetail::select(DB::raw('MAX(emp_id) as max_emp_id'))->first();
        return response()->json(['get' => $data]);
    }

    public function empIdCheck(Request $request)
    {
        $data = EmployeePersonalDetail::where('emp_id', $request->emp_id)->first();
        return response()->json(['get' => $data]);
    }

    public function shiftCheck(Request $request){
        // return $request->all();
        // return "orkias";
        $id = $request->shift_id;
        // return $reqeust->shift_id;
        $data = PolicyAttendanceShiftSetting::where('id', $id)->first();
        return response()->json(['get' => $data]);

    }

}
