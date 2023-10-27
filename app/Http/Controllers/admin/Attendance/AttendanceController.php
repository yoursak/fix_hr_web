<?php

namespace App\Http\Controllers\admin\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use App\Helpers\Central_unit;
use App\Models\admin\setupsettings\MasterEndGameModel;

use Illuminate\Support\Facades\Route;
use App\Helpers\MasterRulesManagement\RulesManagement;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;
// use Alert;
class AttendanceController extends Controller
{
    public function index()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // session()->forget('custom_success_message');
        $DATA = DB::table('attendance_list')
            ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('attendance_methods', 'attendance_list.working_from_method', '=', 'attendance_methods.id')
            ->join('atten_rule_late_entry', 'attendance_list.business_id', '=', 'atten_rule_late_entry.business_id')
            ->join('atten_rule_break', 'attendance_list.business_id', '=', 'atten_rule_break.business_id')
            // atten_rule_break
            ->join('attendance_shift_type_items', 'employee_personal_details.emp_shift_type', '=', 'attendance_shift_type_items.attendance_shift_id')
            ->join('master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'master_endgame_method.id')
            // ->whereRaw('JSON_CONTAINS(master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))')
            // ->where('master_endgame_method.method_switch', 1)
            ->where('atten_rule_late_entry.switch_is', 1)
            ->where('attendance_list.punch_date', date('Y-m-d'))
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select('attendance_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.profile_photo', 'employee_personal_details.designation_id', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'attendance_shift_type_items.shift_start', 'attendance_shift_type_items.shift_end', 'attendance_methods.method_name', 'atten_rule_late_entry.grace_time_min', 'atten_rule_late_entry.grace_time_hr', 'atten_rule_break.break_extra_hr', 'atten_rule_break.break_extra_min', 'attendance_shift_type_items.break_min')
            // ->select('attendance_list.*')
            ->orderBy('attendance_list.id', 'desc')

            ->get();
        // dd($DATA);
        $data = [
            'labels' => ['Work', 'Break', 'Meetings'],
            'data' => [40, 20, 10], // Example data in hours
        ];
        $root = compact('moduleName', 'permissions', 'DATA', 'data');
        return view('admin.attendance.attendance', $root);
    }

    function attendanceSummary()
    {
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->get();
        return view('admin.attendance.summary', compact('Emp'));
    }

    public function attendanceMark(Request $request)
    {
        // dd($request->all())  ;
        $user_id_array = $request->input('id');
        $keys = 0;
        foreach ($user_id_array as $key => $value) {
            $attendance = DB::table('attendance_list')
                ->where('id', $value)
                ->where('business_id', Session::get('business_id'))
                ->update(['attendance_status' => $request->myAttendanceCheck[$keys]]);
            $keys = $keys + 1;
        }
        Alert::success('Items updated successfully');
        return back();
    }

    public function attendanceUpdate(Request $request)
    {
        // dd($request->editPunchInTime);

        $punchInTimes = strtotime($request->editPunchInTime);
        // dd($punchInTimes);
        $punchOutTimes = strtotime($request->editPunchOutTime);
        $totalWorkingSeconds = $punchOutTimes - $punchInTimes;
        $totalWorkingTimestamp = strtotime('midnight') + $totalWorkingSeconds;

        // dd($totalWorkingTimestamp);
        $totalWorking = date('H:i:s', $totalWorkingTimestamp);
        // dd($totalWorkingTimestamp);
        // dd($totalWorking);
        // $punchInTime = $request->editPunchInTime;
        // $punchOutTime = $request->editPunchOutTime;
        $atteUpdate = DB::table('attendance_list')
            ->where('id', $request->Updateid)
            ->where('business_id', Session::get('business_id'))
            ->update(['punch_in_time' => $request->editPunchInTime, 'punch_out_time' => $request->editPunchOutTime, 'total_working_hour' => $totalWorking, 'attendance_status' => 1]);
        if ($atteUpdate) {
            Alert::success('Attendacne Request has been Approve Successfully');
        } else {
            Alert::error('Attendacne Request has not been Approve Successfully');
        }
        return redirect()->to('admin/attendance');
    }

    public function attendanceListFilter(Request $request)
    {
        $branchId = $request->branch_id;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $dateSelectValue = $request->input('date_select_value');

        // $fromDate = $request->input('from_date');
        // $toDate = $request->input('to_date');
        // $empId = $request->input('emp_id');

        // Use the selected filter values to query your database and retrieve the filtered data
        // $filteredData = DB::table('attendance_list')
        // ->join('branch_list', 'attendance_list.branch_id', '=', 'branch_list.branch_id')
        // ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
        // ->join('attendance_shift_type', 'attendance_list.working_from_method', '=', 'attendance_shift_type.id')
        // ->join('attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'attendance_shift_settings.shift_type')
        // ->join('attendance_shift_type_items', 'attendance_shift_settings.id', '=', 'attendance_shift_type_items.attendance_shift_id')
        // ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
        // ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
        // ->when($branchId, function ($query) use ($branchId) {
        //     $query->where('attendance_list.branch_id', $branchId);
        // })
        // ->when($departmentId, function ($query) use ($departmentId) {
        //     $query->where('employee_personal_details.department_id', $departmentId);
        // })
        // ->when($designationId, function ($query) use ($designationId) {
        //     $query->where('employee_personal_details.designation_id', $designationId);
        // })
        // // ->when($empId, function ($query) use ($empId) {
        // //     $query->where('attendance_list.emp_id', $empId);
        // // })
        // ->when($fromDate, function ($query) use ($fromDate) {
        //     $query->where('attendance_list.punch_date', '>=', $fromDate);
        // })
        // ->when($toDate, function ($query) use ($toDate) {
        //     $query->where('attendance_list.punch_date', '<=', $toDate);
        // })
        // ->select('attendance_list.*', 'branch_list.branch_name', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'employee_personal_details.profile_photo', 'department_list.depart_name', 'designation_list.desig_name', 'attendance_shift_type.name', 'attendance_shift_type_items.shift_start')
        // // ->select('attendance_list.*')
        // ->orderBy('attendance_list.id', 'DESC')

        // ->get();
        $filteredData = DB::table('attendance_list')
            ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('attendance_methods', 'attendance_list.working_from_method', '=', 'attendance_methods.id')
            ->join('atten_rule_late_entry', 'attendance_list.business_id', '=', 'atten_rule_late_entry.business_id')
            ->join('atten_rule_break', 'attendance_list.business_id', '=', 'atten_rule_break.business_id')
            // atten_rule_break
            ->join('attendance_shift_type_items', 'employee_personal_details.emp_shift_type', '=', 'attendance_shift_type_items.attendance_shift_id')
            ->join('master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'master_endgame_method.id')
            ->join('branch_list', 'attendance_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            // ->whereRaw('JSON_CONTAINS(master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))')
            // ->where('master_endgame_method.method_switch', 1)
            ->where('atten_rule_late_entry.switch_is', 1)
            // ->where('attendance_list.punch_date', date('Y-m-d'))
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('attendance_list.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->when($dateSelectValue, function ($query) use ($dateSelectValue) {
                $query->where('attendance_list.punch_date', $dateSelectValue);
            })
            ->select('attendance_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.profile_photo', 'employee_personal_details.designation_id',  'designation_list.desig_name', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'attendance_shift_type_items.shift_start', 'attendance_shift_type_items.shift_end', 'attendance_methods.method_name', 'atten_rule_late_entry.grace_time_min', 'atten_rule_late_entry.grace_time_hr', 'atten_rule_break.break_extra_hr', 'atten_rule_break.break_extra_min', 'attendance_shift_type_items.break_min')
            // ->select('attendance_list.*')
            ->orderBy('attendance_list.id', 'desc')
            ->get();

        // $filteredData = DB::table('attendance_list')
        //     ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
        //     ->join('branch_list', 'attendance_list.branch_id', '=', 'branch_list.branch_id')
        //     ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
        //     ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
        //     ->where('attendance_list.business_id', Session::get('business_id'))
        //     ->when($branchId, function ($query) use ($branchId) {
        //         $query->where('attendance_list.branch_id', $branchId);
        //     })
        //     ->when($departmentId, function ($query) use ($departmentId) {
        //         $query->where('employee_personal_details.department_id', $departmentId);
        //     })
        //     ->when($designationId, function ($query) use ($designationId) {
        //         $query->where('employee_personal_details.designation_id', $designationId);
        //     })
        //     // ->select('attendance_list.*', 'branch_list.branch_name', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'employee_personal_details.profile_photo', 'department_list.depart_name', 'designation_list.desig_name', 'attendance_shift_type.name', 'attendance_shift_type_items.shift_start')

        //     ->select('attendance_list.*', 'employee_personal_details.department_id', 'employee_personal_details.designation_id', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name')
        //     ->get();

        // Return the filtered data as JSON response
        return response()->json(['get' => $filteredData]);
    }

    public function empIdToData(Request $request)
    {
        $SHOW = DB::table('attendance_list')
            // ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            // // ->
            ->where('id', $request->id)
            ->first();
        return response()->json(['get' => $SHOW]);
    }

    public function byemployee(Request $request, $id)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $emp = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->where('emp_id', $id)
            ->first();
        // dd($emp);
        // $Holiday = DB::table("holiday_details")->where('business_id',Session::get('business_id'))->get();
        // $Notice = DB::table("admin_notices")->where('business_id',Session::get('business_id'))->get();

        // $DATA = DB::table('attendance_list')
        //     ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
        //     ->join('attendance_shift_type', 'attendance_list.working_from_method', '=', 'attendance_shift_type.id')
        //     ->where('employee_personal_details.business_id', Session::get('business_id'))
        //     ->orderBy('attendance_list.id', 'DESC')
        //     ->select('attendance_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.profile_photo', 'employee_personal_details.designation_id', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'attendance_shift_type.name')
        //     ->get();
        // $root= compact('moduleName', 'permissions','Emp','Holiday','Notice', 'DATA');
        // return view('admin.dashboard.dashboard',$root);
        return view('admin.attendance.attendancevby_employee', compact('emp'));
    }

    public function details(Request $request)
    {
        // dd($request->emp_id);
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $Emp = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $designation = DB::table('designation_list')
            ->where('business_id', Session::get('business_id'))
            ->first();

        return view('admin.attendance.emp_attendace', compact('Emp', 'designation'));
    }

    public function createShift()
    {
        $attendaceShift = DB::table('attendance_shift_settings')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.createshift', compact('permissions', 'moduleName', 'attendaceShift'));
    }
    public function submitTrackInTrackOut(Request $request)
    {
        $updated = DB::table('attendance_track_in_out')
            ->where('business_id', Session::get('business_id'))
            ->first();

        if (isset($updated)) {
            $load = DB::table('attendance_track_in_out')
                ->where('business_id', Session::get('business_id'))
                ->update([
                    'business_id' => Session::get('business_id'),
                    'track_in_out' => isset($request->tranck_in_out) ? $request->tranck_in_out : 0,
                    'no_attendace_without_punch' => isset($request->no_attendace_with_punch) ? $request->no_attendace_with_punch : 0,
                ]);
            if (isset($load)) {
                Alert::success('Mode of Attendence Set to Auto Updated')->persistent(true);
            } else {
                Alert::info('Mode of Attendance Not Set! Update')->persistent(true);
            }
        } else {
            $load = DB::table('attendance_track_in_out')->insert([
                'business_id' => Session::get('business_id'),
                'track_in_out' => isset($request->tranck_in_out) ? $request->tranck_in_out : 0,
                'no_attendace_without_punch' => isset($request->no_attendace_with_punch) ? $request->no_attendace_with_punch : 0,
            ]);
            if (isset($load)) {
                Alert::success('Mode of Attendence Set to Auto')->persistent(true);
            } else {
                Alert::info('Mode of Attendance Not Set!')->persistent(true);
            }
        }

        return redirect()->to('admin/settings/attendance');
        //    dd($request->all());
    }

    public function getAttendaceShiftList(Request $request)
    {
        $load = DB::table('attendance_shift_type_items')
            ->where('attendance_shift_id', $request->id)
            ->get();
        return response()->json(['get' => $load]);
    }

    public function addShift(Request $request)
    {
        // PASSLOAD

        // dd($request->all());

        if ($request->shiftType == 1) {
            // : (($request->rotationalName!=null)?$request->rotationalName: $request->openShiftName);

            $load_first = DB::table('attendance_shift_settings')->insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->fixedshiftName,
                'shift_weekly_repeat' => $request->repeat_week,
            ]);
            if (isset($load_first)) {
                $firstload = DB::getPdo()->lastInsertId();

                $fixShift = DB::table('attendance_shift_type_items')->insert([
                    'attendance_shift_id' => $firstload,
                    'shift_name' => $request->fixedshiftName,
                    'shift_start' => $request->fixShiftStart,
                    'shift_end' => $request->fixShiftEnd,
                    'break_min' => $request->fixShiftBreak,
                    'is_paid' => $request->fixpaid,
                    'work_hr' => $request->f_WorkHour,
                    'work_min' => $request->f_WorkMin,
                    'is_active'=>1,
                    'business_id' => $request->session()->get('business_id'),
                    'branch_id' => $request->session()->get('branch_id'),
                    'updated_at' => now(),
                ]);

                if ($fixShift) {
                    Alert::success('Fixed Shift Created Successfully', '')->persistent(true);
                } else {
                    Alert::error('Fixed Shift is Not Created!')->persistent(true);
                }
            }
        } elseif ($request->shiftType == 2) {
            $load_second = DB::table('attendance_shift_settings')->insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->rotationalName,
            ]);
            if (isset($load_second)) {
                $secondload = DB::getPdo()->lastInsertId();

                foreach ($request->rotationalShiftName as $key => $rotationalShiftName) {
                    $roatationalShift = DB::table('attendance_shift_type_items')->insert([
                        'attendance_shift_id' => $secondload,
                        'shift_name' => $request->rotationalShiftName[$key],
                        'shift_start' => $request->rotationalShiftStart[$key],
                        'shift_end' => $request->rotationalShiftEnd[$key],
                        'break_min' => $request->rotationalShiftBreak[$key],
                        'is_paid' => $request->rotationalpaid[$key],
                        'work_hr' => $request->r_WorkHour[$key],
                        'work_min' => $request->r_WorkMin[$key],
                        'is_active' => ($key == 0) ? 1 : 0,
                        'branch_id' => $request->session()->get('branch_id'),
                        'business_id' => $request->session()->get('business_id'),
                        'updated_at' => now(),
                    ]);
                }

                if ($roatationalShift) {
                    Alert::success('Rotational Shift Created Successfully', '')->persistent(true);
                } else {
                    Alert::error('Rotational Shift is Not Created')->persistent(true);
                }
            }
        } elseif ($request->shiftType == 3) {
            $load_third = DB::table('attendance_shift_settings')->insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->openShiftName,
            ]);

            if (isset($load_third)) {
                $thridload = DB::getPdo()->lastInsertId();

                $openShift = DB::table('attendance_shift_type_items')->insert([
                    'attendance_shift_id' => $thridload,
                    'shift_name' => $request->openShiftName,
                    'shift_hr' => $request->openHour,
                    'shift_min' => $request->openMin,
                    'break_min' => $request->openBreak,
                    'is_paid' => $request->openPaid,
                    'is_active'=>1,
                    'branch_id' => $request->session()->get('branch_id'),
                    'business_id' => $request->session()->get('business_id'),
                    'updated_at' => now(),
                ]);

                if ($openShift) {
                    Alert::success('Open Shift Created Successfully', '')->persistent(true);
                } else {
                    Alert::error('Open Shift is Not Created!')->persistent(true);
                }
            }
        }
        return redirect()->to('/admin/settings/attendance/create_shift');

        // if($request->shiftType == 'fixed'){
        //     $fixShift = DB::table('shift_fixed')->insert([
        //         'shift_name'=> $request->fixedshiftName,
        //         'shift_start'=> $request->fixShiftStart,
        //         'shift_end'=> $request->fixShiftEnd,
        //         'break_min'=> $request->fixShiftBreak,
        //         'is_paid'=> $request->fixpaid,
        //         'work_hr'=> $request->f_WorkHour,
        //         'work_min'=> $request->f_WorkMin,
        //         'business_id'=> $request->session()->get('business_id'),
        //         'branch_id'=> $request->session()->get('branch_id'),
        //         'updated_at'=> now(),
        //     ]);

        //     if($fixShift ){
        //         Alert::success('Shift Created Successfully','');

        //     }else{
        //         Alert::error('Failed','');

        //     }

        // }

        // if($request->shiftType == 'rotational'){
        //     $shift = DB::table('shift_set')->insert([
        //         'set_name'=> $request->rotationalName,
        //         'branch_id'=> $request->session()->get('branch_id'),
        //         'business_id'=> $request->session()->get('business_id'),
        //     ]);

        //     $getShift = DB::table('shift_set')->where([
        //         'set_name'=> $request->rotationalName,
        //         'business_id'=> $request->session()->get('business_id'),
        //     ])->first('set_id');

        //     // dd($getShift->set_id);

        //     foreach ($request->rotationalShiftName as $key => $rotationalShiftName) {
        //         $roatationalShift = DB::table('shift_rotational')->insert([
        //             'set_id'=> $getShift->set_id,
        //             'shift_name'=> $request->rotationalShiftName[$key],
        //             'shift_start'=> $request->rotationalShiftStart[$key],
        //             'shift_end'=> $request->rotationalShiftEnd[$key],
        //             'break_min'=> $request->rotationalShiftBreak[$key],
        //             'is_paid'=> $request->rotationalpaid[$key],
        //             'work_hr'=> $request->r_WorkHour[$key],
        //             'work_min'=> $request->r_WorkMin[$key],
        //             'branch_id'=> $request->session()->get('branch_id'),
        //             'business_id'=> $request->session()->get('business_id'),
        //             'updated_at'=> now(),
        //         ]);
        //     }

        //     if($roatationalShift){
        //         Alert::success('Rotationa Shift Created Successfully','');

        //     }else{
        //         Alert::error('Failed','');

        //     }
        // }

        // if($request->shiftType == 'open'){
        //     $openShift = DB::table('shift_open')->insert([
        //         'shift_name'=> $request->openShiftName,
        //         'shift_hr'=> $request->openHour,
        //         'shift_min'=> $request->openMin,
        //         'break_min'=> $request->openBreak,
        //         'is_paid'=> $request->openPaid,
        //         'branch_id'=> $request->session()->get('branch_id'),
        //         'business_id'=> $request->session()->get('business_id'),
        //         'updated_at'=> now(),
        //     ]);

        //     if($openShift){
        //         Alert::success('Shift Created Successfully','');

        //     }else{
        //         Alert::error('Failed','');
        //     }
        // }
    }

    public function updateAttendaceShift(Request $request)
    {
        $updatedAttendaceShift = false;

        dd($request->all());

        if ($request->ajax()) {
            if ($request->shift_type == 2) {
                $shiftData = []; // Create an array to store the cleaned data

                foreach ($request->updated_items as $key => $item) {
                    // Check if all required properties exist in the item
                    if (isset($item['shift_name']) && isset($item['start_time']) && isset($item['end_time']) && isset($item['break_min']) && isset($item['is_paid']) && isset($item['work_hr']) && isset($item['work_min'])) {
                        // Access individual properties of each item
                        $defaultID = (int) $request->id;
                        $shiftName = $item['shift_name'];
                        $startTime = $item['start_time'];
                        $endTime = $item['end_time'];
                        $breakMin = $item['break_min'];
                        $isPaid = $item['is_paid'];
                        $workHour = $item['work_hr'];
                        $workMin = $item['work_min'];
                        // $isActive=($key==0)?1:0;
                        // Add the data to the $shiftData array or perform other operations
                        $shiftData[] = [
                            'attendance_shift_id' => $defaultID,
                            'business_id' => Session::get('business_id'),
                            'branch_id' => Session::get('branch_id'),
                            'shift_name' => $shiftName,
                            'shift_start' => $startTime,
                            'shift_end' => $endTime,
                            'break_min' => $breakMin,
                            'is_paid' => $isPaid,
                            'work_hr' => $workHour,
                            'work_min' => $workMin,

                        ];
                    }
                }

                $load = DB::table('attendance_shift_settings')
                    ->where('id', (int) $request->id)
                    ->where('shift_type', $request->shift_type)
                    ->where('business_id', Session::get('business_id'))
                    ->first();
                if (isset($load)) {
                    DB::table('attendance_shift_settings')
                        ->where('id', $load->id)
                        ->update(['shift_type_name' => $request->shift_rotation_name]);
                    $loadItems = DB::table('attendance_shift_type_items')
                        ->where('attendance_shift_id', $load->id)
                        ->where('business_id', Session::get('business_id'))
                        ->delete();
                    if (isset($loadItems)) {
                        $loadedChecked = DB::table('attendance_shift_type_items')->insert($shiftData);
                        // if (isset($loadedChecke/d)) {

                        $updatedAttendaceShift = true;
                        // }
                    }
                } else {
                    $updatedAttendaceShift = false;
                }
                // dd($load);
                // DB::table('attendance_shift_type_items')->where('business_id',Session::get('business_id'))->get();
                // Now $shiftData contains the cleaned data with all required properties
            }
            return response()->json(['root' => $updatedAttendaceShift]);
        }
        if ($request->EditShiftFixedShiftSubmit === 'FixedSubmit') {
            $load_first = DB::table('attendance_shift_settings')
                ->where(['business_id' => Session::get('business_id'), 'id' => $request->fixedshiftId])
                ->update([
                    'business_id' => Session::get('business_id'),
                    'branch_id' => Session::get('branch_id'),
                    'shift_type' => $request->fixiedshifttype,
                    'shift_type_name' => $request->editfixedshiftname,
                ]);

            $fixUpdate = DB::table('attendance_shift_type_items')
                ->where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->fixedshiftId])
                ->update([
                    'shift_name' => $request->editfixedshiftname,
                    'shift_start' => $request->UpdatedFixShiftStart,
                    'shift_end' => $request->UpdatedFixShiftEnd,
                    'break_min' => $request->UpdatedFixShiftBreak,
                    'is_paid' => $request->UpdatedFixpaid,
                    'work_hr' => $request->fu_WorkHour,
                    'work_min' => $request->fu_WorkMin,
                    'updated_at' => now(),
                ]);

            if (isset($fixUpdate) && isset($load_first)) {
                Alert::success('Fixed Shift is Updated Successfully')->persistent(true);
            } else {
                Alert::error('Fixed Shift is Not Updated')->persistent(true);
            }
            return redirect()->to('admin/settings/attendance/create_shift');
        }
        if ($request->EditShiftOpenShiftSubmit == 'OpenSubmit') {
            // dd($request->all());
            $load_first = DB::table('attendance_shift_settings')
                ->where(['business_id' => Session::get('business_id'), 'id' => $request->openshiftId])
                ->update([
                    'business_id' => Session::get('business_id'),
                    'branch_id' => Session::get('branch_id'),
                    'shift_type' => $request->editshifttype,
                    'shift_type_name' => $request->editopenShiftName,
                ]);

            $fixUpdate = DB::table('attendance_shift_type_items')
                ->where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->openshiftId])
                ->update([
                    'shift_name' => $request->editopenShiftName,
                    'shift_hr' => $request->editopenHour,
                    'shift_min' => $request->editopenMin,
                    'break_min' => $request->editopenBreak,
                    'is_paid' => $request->editopenPaid,
                    'updated_at' => now(),
                ]);

            if (isset($fixUpdate) && isset($load_first)) {
                Alert::success('Open Shift is Updated Successfully')->persistent(true);
            } else {
                Alert::error('Open Shift is Not Updated')->persistent(true);
            }
            return redirect()->to('admin/settings/attendance/create_shift');
        }

        // else {
        //     Alert::error('Failed', '');
        //     return redirect()->to('admin/settings/attendance/create_shift');

        // }
        // if ($request->has('fixedId')) {
        //     $fixUpdate = DB::table('shift_fixed')->where(['business_id' => $request->session()->get('business_id'), 'fixed_id' => $request->fixedId])->update([
        //         'shift_name' => $request->UpdatedFixedshiftName,
        //         'shift_start' => $request->UpdatedFixShiftStart,
        //         'shift_end' => $request->UpdatedFixShiftEnd,
        //         'break_min' => $request->UpdatedFixShiftBreak,
        //         'is_paid' => $request->UpdatedFixpaid,
        //         'work_hr' => $request->fu_WorkHour,
        //         'work_min' => $request->fu_WorkMin,
        //         'updated_at' => now(),
        //     ]);

        //     if ($fixUpdate) {
        //         Alert::success('Shift Updated Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // if ($request->has('openId')) {
        //     $updateOpen = DB::table('shift_open')->where(['business_id' => $request->session()->get('business_id'), 'open_id' => $request->openId])->update([
        //         'shift_name' => $request->updatedOpenShiftName,
        //         'shift_hr' => $request->updatedOpenHour,
        //         'shift_min' => $request->updatedOpenMin,
        //         'break_min' => $request->updatedOpenBreak,
        //         'is_paid' => $request->updatedOpenPaid,
        //         'updated_at' => now(),
        //     ]);

        //     if ($updateOpen) {
        //         Alert::success('Shift Updated Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // if ($request->has('setId')) {
        //     // dd($request->all());

        //     $shift = DB::table('shift_set')->where(['business_id' => $request->session()->get('business_id'), 'set_id' => $request->setId])->update([
        //         'set_name' => $request->updatedRotationalName,
        //         'updated_at' => now(),
        //     ]);

        //     $roatationalRemove = DB::table('shift_rotational')->where(['business_id' => $request->session()->get('business_id'), 'set_id' => $request->setId])->delete();

        //     foreach ($request->updatedRotationalShiftName as $key => $rotationalShiftName) {
        //         $roatationalShift = DB::table('shift_rotational')->insert([
        //             'set_id' => $request->setId,
        //             'shift_name' => $request->updatedRotationalShiftName[$key],
        //             'shift_start' => $request->updatedRotationalShiftStart[$key],
        //             'shift_end' => $request->updatedRotationalShiftEnd[$key],
        //             'break_min' => $request->updatedRotationalShiftBreak[$key],
        //             'is_paid' => $request->updatedRotationalpaid[$key],
        //             'work_hr' => $request->ru_WorkHour[$key],
        //             'work_min' => $request->ru_WorkMin[$key],
        //             'branch_id' => $request->session()->get('branch_id'),
        //             'business_id' => $request->session()->get('business_id'),
        //             'updated_at' => now(),
        //         ]);
        //     }

        //     if ($roatationalShift) {
        //         Alert::success('Rotational Shift Created Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // return redirect()->to('admin/settings/attendance/create_shift');
    }

    public function deleteShift(Request $request)
    {
        // dd($request->all());

        $load_first = DB::table('attendance_shift_settings')
            ->where(['business_id' => Session::get('business_id'), 'id' => $request->shift_id])
            ->delete();
        $fixUpdate = DB::table('attendance_shift_type_items')
            ->where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->shift_id])
            ->delete();

        if (isset($fixUpdate) && isset($load_first)) {
            Alert::success('Deleted is Successfully')->persistent(true);
        } else {
            Alert::error('Not Delete')->persistent(true);
        }

        return back();

        // return redirect()->to('admin/settings/attendance/create_shift');

        // if ($request->has('fixed')) {
        //     $fixDelete = DB::table('shift_fixed')->where(['business_id' => $request->session()->get('business_id'), 'fixed_id' => $id])->delete();
        //     if ($fixDelete) {
        //         Alert::success('Fixed Shift Delete Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // if ($request->has('open')) {
        //     $openDelete = DB::table('shift_open')->where(['business_id' => $request->session()->get('business_id'), 'open_id' => $id])->delete();
        //     if ($openDelete) {
        //         Alert::success('Open Shift Delete Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // if ($request->has('set')) {
        //     $roatationalDelete = DB::table('shift_rotational')->where(['business_id' => $request->session()->get('business_id'), 'set_id' => $id])->delete();
        //     $setDelete = DB::table('shift_set')->where(['business_id' => $request->session()->get('business_id'), 'set_id' => $id])->delete();
        //     if ($setDelete) {
        //         Alert::success('Rotational Shift Delete Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }
        // return back();
    }

    public function ActiveMode()
    {
        $accessPermission = Central_unit::AccessPermission();

        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];
        $BusinessDetails = $List[1];
        $BranchList = $List[2];
        $LeavePolicy = $List[3];
        $HolidayPolicy = $List[4];
        $weeklyPolicy = $List[5];
        $attendanceModePolicy = $List[6];
        $attendanceShiftPolicy = $List[7];
        $attendanceTrackInOut = $List[8];
        // dd($attendanceTrackInOut)
        // $attendaceShift = DB::table('attendance_shift_settings')->get();
        // alert()->success('Success Title', 'Success Message');

        // alert()->success('Success Title', 'Success Message');
        // alert()->success('Success Title', 'Success Message');
        // Alert::success('Success', 'Updated Rule Method Successfully');

        // dd($FinalEndGameRule);
        $root = compact('moduleName', 'permissions', 'BusinessDetails', 'FinalEndGameRule', 'BranchList', 'LeavePolicy', 'HolidayPolicy', 'weeklyPolicy', 'attendanceModePolicy', 'attendanceShiftPolicy', 'attendanceTrackInOut');
        return view('admin.setting.active_rules.active_end_game', $root);
    }
    // End Games Rule Submit form
    public function FinalStartRuleEndGame(Request $request)
    {
        // $checking = DB::table('master_endgame_method')
        //     ->where('business_id', $request->b_id)
        //     ->first();
        // if (isset($checking)) {
        //     Alert::error('Failed Final Rules Already Created!');
        // } else {
        // 'branch_id' => json_encode($request->input('branhcid')),
        $data = [
            'business_id' => $request->b_id,
            'method_name' => $request->methodname,
            'method_switch' => 0,
            'policy_preference' => $request->policypreference,
            'level_type' => 1,
            'leave_policy_ids_list' => json_encode($request->input('leavepolicy')),
            'holiday_policy_ids_list' => json_encode($request->input('holidaypolicy')),
            'weekly_policy_ids_list' => json_encode($request->input('weeklypolicy')),
            'shift_settings_ids_list' => json_encode($request->input('shiftsetting')),
        ];
        //  'attendance_mode_list' => json_encode($request->input("attendancemode")),
        //'track_in_out_ids_list' => json_encode($request->input("trackpunch"))

        $load = DB::table('master_endgame_method')->insert($data);
        if (isset($load)) {
            Alert::success('Create Final Rules is Successfully')->persistent(true);
        } else {
            Alert::error('Failed Final Rules Created!')->persistent(true);
        }
        // }

        // 'depart_id	' => json_decode($request->input("depart_id")),
        // 'automation_rules_list' => json_encode($request->input("automationrules")),

        // return self::ActiveMode();
        return redirect()->to('admin/attendance/active_mode_set');
        // dd($leavePolicyIds);
    }

    // ajax getMasterRules
    public function getMasterRules(Request $request)
    {
        $load = DB::table('master_endgame_method')
            ->where(['id' => $request->e_id, 'business_id' => $request->b_id])
            ->first();
        return response()->json($load);
    }
    // edit_master_rule
    public function editMasterRules(Request $request)
    {
        // dd($request->all());
        // Start a database transaction
        DB::beginTransaction();
        try {
            // Find and delete the existing record based on business_id
            MasterEndGameModel::where('business_id', $request->edit_bid)
                ->where('id', $request->edit_id)
                ->delete();

            // Create an array with the new data
            // 'branch_id' => json_encode($request->input('editbranhcid')),
            $data = [
                'business_id' => $request->edit_bid,
                'method_switch' => 1, //($request->switch != 0) ? $request->switch : 0
                'method_name' => $request->edit_mname,
                'policy_preference' => $request->editpolicypreference,
                'level_type' => 1,
                'leave_policy_ids_list' => json_encode($request->input('editleavepolicy')),
                'holiday_policy_ids_list' => json_encode($request->input('editholidaypolicy')),
                'weekly_policy_ids_list' => json_encode($request->input('editweeklypolicy')),
                'shift_settings_ids_list' => json_encode($request->input('editshiftsetting')),
            ];

            // Insert the new data into the database
            DB::table('master_endgame_method')->insert($data);
            // Commit the transaction if all operations were successful
            DB::commit();
            Alert::success('Success', 'Your Final Rules Activation is Updated')->persistent(true);
            // return redirect()->route('attendance.activeMode');
        } catch (\Exception $e) {
            // Handle any exceptions and rollback the transaction if an error occurs
            DB::rollback();
            Alert::info('failed', 'Not Updating this record!' . $e->getMessage())->persistent(true);
            // Handle the error, log it, or return an error response
        }
        return redirect()->to('admin/attendance/active_mode_set');
        // return self::ActiveMode();
    }

    // mode_master_rule switch ON/OFF
    public function modeMasterRules(Request $request)
    {
        $loaded = DB::table('master_endgame_method')
            ->where(['business_id' => $request->b_id, 'id' => $request->e_id])
            ->update(['method_switch' => 1]);
        DB::table('master_endgame_method')
            ->where('business_id', $request->b_id)
            ->where('id', '!=', $request->e_id)
            ->update(['method_switch' => 0]);
        DB::table('employee_personal_details')
            ->where('business_id', $request->b_id)
            ->update(['master_endgame_id' => $request->e_id]);
        return response()->json($loaded);
    }

    // parament delete_set
    public function deleteMasterRules(Request $request)
    {
        // dd($request->all());
        $load = DB::table('master_endgame_method')
            ->where('business_id', $request->bid)
            ->where('id', $request->eid)
            ->delete();
        if (isset($load)) {
            Alert::success('Delete Final Rules is Successfully')->persistent(true);
        } else {
            Alert::error('Failed Final Rules Not Deleted!')->persistent(true);
        }
        // Alert::success('Success Title', 'Success Message')->persistent(true);
        // return redirect('admin/attendance/active_mode_set')->with('success', 'Task Created Successfully!');
        // return self::ActiveMode();
        return redirect()->to('admin/attendance/active_mode_set');
        // return redirect()->to('');
        // return url('admin/attendance/active_mode_set');
    }
}
