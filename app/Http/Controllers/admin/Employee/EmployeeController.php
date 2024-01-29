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
use App\Models\BusinessDetailsList;
use App\Exports\AddEmployeeDetails;
use App\Exports\ExportEmployeeDetails;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ExportEmployeeContractualTemplates;
use Barryvdh\DomPDF\Facade\Pdf;

use Maatwebsite\Excel\Validators\ValidationException;


class EmployeeController extends Controller
{
    public function index()
    {
        // dd($data);
        return view('admin.employees.employee');
    }

    public function CreateCurrentActiveTableActionData()
    {
        $queryParams = RulesManagement::getDecodeUrlFiltration();
        $branchActiveFilter = $queryParams['filters']['branch-active-filter'] ?? null;
        $DesignationActiveFilter = $queryParams['filters']['designation-active-filter'] ?? null;
        $DepartmentActiveFilter = $queryParams['filters']['department-active-filter'] ?? null;
        $ActiveFilter = $queryParams['filters']['users-active-filter'] ?? null;
        $sortBy = $queryParams['sortBy'] ?? null;
        $sortOrder = $queryParams['sortOrder'] ?? null;
        // //$this->model::query();
        $employeeDetailsQuery = EmployeePersonalDetail::join('branch_list', 'branch_list.branch_id', '=', 'employee_personal_details.branch_id')
            ->join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select('employee_personal_details.*', 'branch_list.branch_name as branch_name', 'department_list.depart_name as depart_name', 'designation_list.desig_name as designation_name');


        // $this->joinAndFilter($employeeDetailsQuery);
        if ($branchActiveFilter !== null) {
            $employeeDetailsQuery->where('branch_name', $branchActiveFilter);
        }
        if ($DepartmentActiveFilter !== null) {
            $employeeDetailsQuery->where('depart_name', $DepartmentActiveFilter);
        }
        if ($DesignationActiveFilter !== null) {
            $employeeDetailsQuery->where('designation_name', $DesignationActiveFilter);
        }
        if ($ActiveFilter !== null) {
            $employeeDetailsQuery->where('active_emp', $ActiveFilter);
        }
        if ($sortBy !== null && $sortOrder !== null) {
            $employeeDetailsQuery->orderBy($sortBy, $sortOrder);
        }
        // Fetch the results
        $employeeDetails = $employeeDetailsQuery->get();

        // runtime cloning set count active employee or in - active
        $activeEmployeeDetailsQuery = clone $employeeDetailsQuery;
        $inactiveEmployeeDetailsQuery = clone $employeeDetailsQuery;
        $activeCount = $activeEmployeeDetailsQuery->where('active_emp', '1')->count();
        $inactiveCount = $inactiveEmployeeDetailsQuery->where('active_emp', '0')->count();

        return [$employeeDetails, $branchActiveFilter, $DepartmentActiveFilter, $DesignationActiveFilter, $ActiveFilter, $sortBy, $sortOrder, $activeCount, $inactiveCount];
    }

    // public function generateEmployeePage($id)
    // {
    //     $collect = $this->CreateCurrentActiveTableActionData();
    //     $GetAllData = $collect[0];
    //     $branchName = $collect[1];
    //     $ActiveCount = $collect[7];
    //     $InActiveCount = $collect[8];

    //     $BusinessData = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();
    //     $send = compact('GetAllData', 'BusinessData', 'branchName', 'ActiveCount', 'InActiveCount');


    //     $redirectRoute = 'admin/employee'; // Set your desired redirect route
    //     $pdf = PDF::loadView('generate-pdf.employee_table', $send);

    //     switch ($id) {
    //         case 1:
    //             $response = Excel::download($GetAllData, 'FixHr-EmployeeList.csv');
    //             break;

    //         case 2:
    //             $response = Excel::download($GetAllData, 'FixHr-EmployeeList.xlsx');
    //             break;

    //         case 3:
    //             $response = $pdf->download('FixHr-EmployeeList.pdf');
    //             break;

    //         case 4:
    //             $response = $pdf->stream('FixHr-EmployeeList.pdf');
    //             break;

    //         default:
    //             $response = null; // Handle the default case
    //             break;
    //     }

    //     if ($response) {
    //         return $response->withHeaders(['Location' => $redirectRoute]);
    //     }

    //     return redirect()->to($redirectRoute);
    // }

    // public function generateEmployeePage($id)
    // {


    //     // $data = $this->getData();


    //     $send = compact('data');

    //     $pdf = PDF::loadView('generate-pdf.employee_table', $send);

    //     switch ($type) {
    //         case 1:
    //             // $response = Excel::download($GetAllData, 'FixHr-EmployeeList.csv');
    //             break;

    //         case 2:
    //             // $response = Excel::download($GetAllData, 'FixHr-EmployeeList.xlsx');
    //             break;

    //         case 3:
    //             $response = $pdf->download('FixHr-EmployeeList.pdf');
    //             break;

    //         case 4:
    //             // break;
    //             return $pdf->stream('FixHr-EmployeeList.pdf');

    //         default:
    //             $response = null; // Handle the default case
    //             break;
    //     }

    //     // dd($type);

    //     // //  href="{{ route('employee.page.print', ['id' => 1]) }}"
    //     // return  redirect('some/url');
    // }

    public function printMode()
    {
        // dd("DFd");
        $pdf = PDF::loadView('generate-pdf.employee_table');

        return $pdf->download('EmployeePage-FixHr.pdf');
    }

    public function getCountryStateCity(Request $request)
    {
        if ($request->country) {
            $response = DB::table('static_states')->where('country_id', $request->country)->get();
            return response()->json($response);
        }
    }
    public function getStateToCity(Request $request)
    {
        if ($request->state) {
            $response = DB::table('static_cities')->where('state_id', $request->state)->get();
            return response()->json($response);
        }
    }
    //Import Files
    public function ImportAddEmployeeDetails(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'emp_type' => 'required',
            'csv_file' => 'required|file|mimes:xlsx',
        ]);
        $empValue = $request->emp_type;

        try {
            $root =  Excel::import(new EmployeeImport($empValue), $request->file('csv_file'));
            if ($root instanceof \Exception) {
                Alert::info('', 'Not Import Data ');
            } else {

                Alert::success('', 'Data Import is Successfully');
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            // Alert::info($failures);
            $errorMessages = [];

            foreach ($failures as $failure) {
                $row = $failure->row(); // Get the row that failed validation
                $errors = $failure->errors(); // Get validation errors for the failed row

                $errorMessages[] = implode(', ', $errors);
            }

            Alert::info('', $errorMessages);
        }


        return redirect()->back();
    }

    // employee download
    public function ExportFileEmpDetails($id)
    {
        // get In-Employee Type 1 -2
        // filename =Employee Excel Demo.xlsx;
        return Excel::download(new ExportEmployeeDetails($id), ($id == 1) ? 'Regular Employee Excel Demo.xlsx' : 'Contractual Employee Excel Demo.xlsx');
        // ExportEmployeeContractualTemplates

    }

    public function add()
    {
        return view('admin.employees.addemp');
    }

    // public function empProfile(Request $request)
    // {
    //     // dd($id);
    //     // DB::enableQueryLog();

    //     $session_id = Session::get('business_id');
    //     $DATA = EmployeePersonalDetail::Join('static_attendance_methods', 'employee_personal_details.emp_attendance_method', '=', 'static_attendance_methods.id')
    //         ->Join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
    //         ->Join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
    //         ->Join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
    //         ->Join('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
    //         ->Join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
    //         ->where('employee_personal_details.emp_id', $request->id)
    //         ->where('employee_personal_details.business_id', $session_id)
    //         ->where('policy_master_endgame_method.business_id', $session_id)
    //         ->select('designation_list.desig_name', 'department_list.depart_name', 'branch_list.branch_name', 'employee_personal_details.*', 'policy_attendance_shift_settings.*', 'static_attendance_methods.*', 'policy_master_endgame_method.method_name as setup_name')
    //         ->first();

    //     // dd($DATA);

    //     if ($DATA) {
    //         return view('admin.employees.emp_profile', compact('DATA'));
    //         // return view('admin.dashboard.dashboard');
    //     } else {
    //         return back();
    //     }
    // }
    public function empProfile(Request $request)
    {
        // dd($id);
        // DB::enableQueryLog();

        $session_id = Session::get('business_id');
        $DATA = EmployeePersonalDetail::Join('static_attendance_methods', 'employee_personal_details.emp_attendance_method', '=', 'static_attendance_methods.id')
            ->Join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->Join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->Join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->Join('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
            ->Join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->Join('static_countries', 'employee_personal_details.emp_country', '=', 'static_countries.id')
            ->Join('static_cities', 'employee_personal_details.emp_city', '=', 'static_cities.id')
            ->Join('static_states', 'employee_personal_details.emp_state', '=', 'static_states.id')
            ->where('employee_personal_details.emp_id', $request->id)
            ->where('employee_personal_details.business_id', $session_id)
            ->where('policy_master_endgame_method.business_id', $session_id)
            ->select('designation_list.desig_name', 'department_list.depart_name', 'branch_list.branch_name', 'employee_personal_details.*', 'policy_attendance_shift_settings.*', 'static_attendance_methods.*', 'policy_master_endgame_method.method_name as setup_name', 'static_countries.name as CountyName','static_cities.name as CityName','static_states.name as StateName')
            ->first();

        // dd($DATA);

        if ($DATA) {
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
            'master_endgame_id' => $request->assign_setup,
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
            'master_endgame_id' => $request->edit_assign_setup,
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
            'emp_rotational_shift_type_item' => $request->update_rotational_type ? $request->update_rotational_type : '0',
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

        $days = EmployeePersonalDetail::
            // join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            //     ->
            join('policy_attendance_shift_settings', 'policy_attendance_shift_settings.id', '=', 'employee_personal_details.emp_shift_type')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            // ->where('branch_list.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_id', $request->employee_id)
            ->select('employee_personal_details.*', 'policy_attendance_shift_settings.shift_type')
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

    public function shiftCheck(Request $request)
    {
        // return $request->all();
        // return "orkias";
        $id = $request->shift_id;
        // return $reqeust->shift_id;
        $data = PolicyAttendanceShiftSetting::where('id', $id)->first();
        return response()->json(['get' => $data]);
    }
}
