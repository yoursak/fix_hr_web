<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\employee\EmployeePersonalDetail;
use App\Models\admin\LoginAdmin;
// use App\Models\employee\LoginEmployee;
use Illuminate\Support\Facades\DB;
// /public_html/app/Models/admin
use App\Helpers\ReturnHelpers;
use App\Helpers\ApiResponse;
use App\Helpers\Central_unit;
use App\Models\AttendanceMonthlyCount;
use App\Models\LoginEmployee;
use App\Models\EmployeePersonalDetail;
use App\Http\Resources\Api\UserSideResponse\EmployeeResource;
use App\Http\Resources\Api\UserSideResponse\PersonalEmployeeDetails;
use App\Http\Resources\Api\UserSideResponse\UserDashboardCount;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;
use Session;
use Validator;

// /Http/Resources/Api

class EmployeeApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $emp = EmployeePersonalDetail::all();
        if ($emp) {
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection($emp)->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }
    public function store(Request $request)
    {
        dd($request);
        $validator = Validator::make($request->all(), [
            // 'business_id' => 'required',
            // 'branch_id' => 'required',
            // 'employee_type' => 'required',
            // 'name' => 'required',
            // 'emp_id' => 'required',
            // 'mobile_no' => 'required',
            // 'email' => 'required',
            // 'branch' => 'required',
            // 'department' => 'required',
            // 'designation' => 'required',
            // 'dob' => 'required',
            // 'doj' => 'required',
            // 'gender' => 'required',
            // 'address' => 'required',
            // 'country' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'pin_code' => 'required',
            // 'photo' => 'required',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->all();
            $response = [
                'status' => false,
                'message' => $errorMessage,
            ];
            return response()->json($response, 401);
        } else {
            if (
                EmployeePersonalDetail::where('emp_email', $request->email)
                    ->get()
                    ->first()
            ) {
                $data['msg'] = 'Email address already exists';
                return response()->json(['result' => [$data], 'status' => false]);
            } elseif (
                EmployeePersonalDetail::where('emp_mobile_number', $request->mobile_no)
                    ->get()
                    ->first()
            ) {
                $data['msg'] = 'Mobile number already exists';
                return response()->json(['result' => [$data], 'status' => false]);
            }
            // Employee Personal Detail Table
            $emp = new EmployeePersonalDetail();
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                // Adjust max size as needed
            ]);
            $image = $request->file('image');
            $path = public_path('business_logo/');
            $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
            $emp->emp_id = $request->emp_id;
            $emp->business_id = $request->business_id;
            $emp->branch_id = $request->branch_id;
            $emp->employee_type = $request->employee_type;
            $emp->emp_name = $request->name;
            $emp->emp_mobile_number = $request->mobile_no;
            $emp->emp_email = $request->email;
            // $emp->emp_branch = $request->branch;
            $emp->department_id = $request->department;
            $emp->designation_id = $request->designation;
            $emp->emp_date_of_birth = $request->dob;
            $emp->emp_date_of_joining = $request->doj;
            $emp->emp_gender = $request->gender;
            $emp->emp_address = $request->address;
            $emp->emp_country = $request->country;
            $emp->emp_state = $request->state;
            $emp->emp_city = $request->city;
            $emp->emp_pin_code = $request->pin_code;
            $emp->profile_photo = $imageName;

            // LoginEmployee Table
            $emplogin = new LoginEmployee();
            $emplogin->business_id = $request->business_id;
            $emplogin->name = $request->name;
            $emplogin->email = $request->email;
            $emplogin->country_code = $request->country_code;
            $emplogin->phone = $request->mobile_no;
            // return true;
            if ($emp->save() && $emplogin->save()) {
                return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([EmployeePersonalDetail::find($emp->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
    }

    public function show(Request $request)
    {
        $business_id = $request->business_id;
        $emp_id = $request->emp_id;
        $now = DB::table('employee_personal_details')
            ->join('policy_attendance_shift_settings', 'policy_attendance_shift_settings.id', '=', 'employee_personal_details.emp_shift_type')
            ->where('employee_personal_details.emp_id', $emp_id)
            ->where('employee_personal_details.business_id', $business_id)
            ->select('policy_attendance_shift_settings.shift_type')
            ->first(); // Use first() to retrieve a single row
        $now = (int) $now->shift_type;
        $item = DB::table('employee_personal_details')
            ->where('employee_personal_details.emp_id', $emp_id)
            ->where('employee_personal_details.business_id', $business_id)
            ->select('emp_rotational_shift_type_item')
            ->first();
        $item = (int) $item->emp_rotational_shift_type_item;
        // dd($item);
        $emp = DB::table('employee_personal_details')
            ->join('static_employee_join_gender_type as employeegender', 'employee_personal_details.emp_gender', '=', 'employeegender.id')
            ->join('static_employee_join_emp_type as employeetype', 'employee_personal_details.employee_type', '=', 'employeetype.type_id')
            ->leftJoin('static_employee_join_active_type', 'employee_personal_details.active_emp', '=', 'static_employee_join_active_type.id')
            ->join('policy_master_endgame_method as mem', 'employee_personal_details.master_endgame_id', '=', 'mem.id')
            ->join('static_attendance_endgame_policypreference as policypreference', 'mem.policy_preference', '=', 'policypreference.id')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('static_attendance_methods as am1', 'employee_personal_details.emp_attendance_method', '=', 'am1.id')
            ->join('policy_attendance_shift_settings as attendanceShift', 'employee_personal_details.emp_shift_type', '=', 'attendanceShift.id')
            ->join('static_attendance_shift_type', 'attendanceShift.shift_type', '=', 'static_attendance_shift_type.id')
            ->join('policy_attendance_shift_type_items', 'attendanceShift.id', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
            ->where('employee_personal_details.emp_id', $emp_id)
            ->where('employee_personal_details.business_id', $business_id)
            ->where(function ($query) use ($now, $item) {
                if ($now == 1) {
                    //fix
                    // $query->where('policy_attendance_shift_settings.shift_type', $now);
                    $query->where('attendanceShift.shift_type', $now);
                }
                if ($now == 2) {
                    //rotation
                    $query->where('attendanceShift.shift_type', $now)->where('policy_attendance_shift_type_items.id', $item);
                }
                if ($now == 3) {
                    //open
                    $query->where('attendanceShift.shift_type', $now);
                }
            })
            ->select('employee_personal_details.*', 'employee_personal_details.active_emp as active_employee_id', 'static_employee_join_active_type.name as active_employee_name', 'employeegender.gender_type as gender', 'policypreference.policy_name', 'mem.method_name', 'mem.method_switch', 'mem.method_name', 'mem.leave_policy_ids_list', 'mem.holiday_policy_ids_list', 'mem.weekly_policy_ids_list', 'mem.shift_settings_ids_list', 'employeetype.emp_type as emp_type_name', 'am1.method_name as attendance_method_name', 'static_attendance_shift_type.name as attendance_shift_name', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'policy_attendance_shift_type_items.shift_start', 'policy_attendance_shift_type_items.shift_end')
            ->first();
        if (isset($emp)) {
            return ReturnHelpers::jsonApiReturn(PersonalEmployeeDetails::collection([$emp])->all());
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function update(Request $request, $emp_id)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $emp_id)->first();
        $emp->business_id = $request->business_id ?? $emp->business_id;
        $emp->branch_id = $request->branch_id ?? $emp->branch_id;
        $emp->employee_type = $request->employee_type ?? $emp->employee_type;
        $emp->emp_name = $request->name ?? $emp->emp_name;
        $emp->emp_id = $request->emp_id ?? $emp->emp_id;
        $emp->emp_mobile_number = $request->mobile_no ?? $emp->emp_mobile_number;
        $emp->emp_email = $request->email ?? $emp->emp_email;
        // $emp->emp_branch = $request->branch ?? $emp->emp_branch;
        $emp->department_id = $request->department ?? $emp->department_id;
        $emp->designation_id = $request->designation ?? $emp->designation_id;
        $emp->emp_date_of_birth = $request->dob ?? $emp->emp_date_of_birth;
        $emp->emp_date_of_joining = $request->doj ?? $emp->emp_date_of_joining;
        $emp->emp_gender = $request->gender ?? $emp->emp_gender;
        $emp->emp_address = $request->address ?? $emp->emp_address;
        $emp->emp_country = $request->country ?? $emp->emp_country;
        $emp->emp_state = $request->state ?? $emp->emp_state;
        $emp->emp_city = $request->city ?? $emp->emp_city;
        $emp->emp_pin_code = $request->pin_code ?? $emp->emp_pin_code;
        $emp->profile_photo = $request->photo ?? $emp->profile_photo;

        $emplogin = LoginEmployee::where('emp_id', $emp_id)->first();
        $emplogin->business_id = $request->business_id ?? $emplogin->business_id;
        $emplogin->name = $request->name ?? $emplogin->name;
        $emplogin->email = $request->email ?? $emplogin->email;
        $emplogin->country_code = $request->country_code ?? $emplogin->country_code;
        $emplogin->phone = $request->mobile_no ?? $emplogin->phone;

        if ($emp->save() && $emplogin->update()) {
            // return true;
            // $emplogin->update();
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([EmployeePersonalDetail::find($emp->id)])->all());

            // return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([$emp])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function destroy($emp_id)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $emp_id)->first();
        $emplogin = LoginEmployee::where('emp_id', $emp_id)->first();
        if ($emp) {
            $emp->delete();
            $emplogin->delete();
            return response()->json(['result' => true, 'status' => true, 'msg' => 'Delete Successfully']);
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function bemployee($business_id)
    {
        $emp = EmployeePersonalDetail::where('business_id', $business_id)->get();
        // return $emp;
        if ($emp) {
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection(EmployeePersonalDetail::where('business_id', $business_id)->get()));
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function allemployee($business_id)
    {
        return ApiResponse::allBranch($business_id);
        // return ApiResponse::allEmployeeList($business_id);

        // allEmployeeList
    }

    public function departmenttoallEmployeeList($branch_id)
    {
        return ApiResponse::allBranch($branch_id);
    }

    public function dashboardcount(Request $request)
    {
        $business_id = $request->business_id;
        $branchID = $request->branch_id;
        $emp_id = $request->emp_id;
        $year = $request->year;
        $month = $request->month;

        $daliyempdetail = AttendanceMonthlyCount::where('business_id', $business_id)->where('branch_id',$branchID)
            ->where('emp_id', $emp_id)
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if ($daliyempdetail) {
            return response()->json([
                'result' => new UserDashboardCount($daliyempdetail),
                'status' => true,
                'case' => 1
            ], 200);
        }

        return response()->json(['result' => null, 'status' => false, 'case' => 2], 404);
    }

}
