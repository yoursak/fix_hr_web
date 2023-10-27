<?php

namespace App\Http\Controllers\admin\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use Carbon\Carbon;
use DateTime;
use App\Helpers\Central_unit;
use DB;
use App\Models\employee\LeaveRequestList;
use App\Models\employee\GatepassRequestList;
use App\Models\employee\MisspunchList;
use Session;
use RealRashid\SweetAlert\Facades\Alert;

class RequestController extends Controller
{
    // public function attendanceMark(Request $request)
    // {
    //     // dd($request->all())  ;
    //     $user_id_array = $request->input('id');
    //     $keys = 0;
    //     foreach ($user_id_array as $key => $value) {
    //         $attendance = DB::table('attendance_list')
    //             ->where('id', $value)
    //             ->where('business_id', Session::get('business_id'))
    //             ->update(['attendance_status' => $request->myAttendanceCheck[$keys]]);
    //         $keys = $keys + 1;
    //     }
    //     // if ($attendance) {
    //         Alert::success('Items updated successfully');
    //     // }
    //     return back();
    // }
    // public function index2(Request $request)
    // {
    //     // $check = DB::table('master_endgame_method')
    //     //     ->select('shift_settings_ids_list')
    //     //     ->get();
    //     // // dd($check);
    //     // foreach ($check as $item) {
    //     //     $very = json_decode($item->shift_settings_ids_list)->toArray();
    //     //     foreach ( $very as $key => $value) {
    //     //         dd($value);
    //     //     }
    //     //     $model=DB::table('employee_personal_details')->select('emp_shift_type')->where('emp_shift_type',$very)->first();
    //     //     dd($very,$model);
    //     //     // print_r($very,$model);
    //     // }
    //     $accessPermission = Central_unit::AccessPermission();
    //     $moduleName = $accessPermission[0];
    //     $permissions = $accessPermission[1];

    //     $DATA = DB::table('attendance_list')
    //         ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
    //         ->join('attendance_methods', 'attendance_list.working_from_method', '=', 'attendance_methods.id')
    //         ->join('atten_rule_late_entry', 'attendance_list.business_id', '=', 'atten_rule_late_entry.business_id')
    //         ->join('attendance_shift_type_items', 'employee_personal_details.emp_shift_type', '=', 'attendance_shift_type_items.attendance_shift_id')
    //         ->join('master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'master_endgame_method.id')
    //         ->whereRaw('JSON_CONTAINS(master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))')
    //         ->where('master_endgame_method.method_switch', 1)
    //         ->where('atten_rule_late_entry.switch_is', 1)
    //         ->where('employee_personal_details.business_id', Session::get('business_id'))
    //         ->select('attendance_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.profile_photo', 'employee_personal_details.designation_id', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'attendance_shift_type_items.shift_start', 'attendance_shift_type_items.shift_end', 'attendance_methods.method_name', 'atten_rule_late_entry.grace_time_min')
    //         ->orderBy('attendance_list.id', 'DESC')
    //         ->get();

    //     // Assuming the punch-in time and grace time are in the format "HH:MM"
    //     $punchInTime = '10:45'; // The time the person punched in
    //     $graceTime = 15; // Grace time in minutes

    //     // Convert the punch-in time and grace time to minutes since midnight
    //     $punchInMinutes = strtotime($punchInTime) / 60;
    //     $graceMinutes = $graceTime;

    //     // Calculate the allowed punch-in time
    //     $allowedPunchInMinutes = strtotime('10:30') / 60;

    //     // Calculate the late mark time
    //     $lateMarkTime = $allowedPunchInMinutes + $graceMinutes;

    //     if ($punchInMinutes <= $allowedPunchInMinutes) {
    //         // The person is on time or early
    //         // Mark attendance accordingly
    //         $attendanceStatus = 'On Time';
    //     } elseif ($punchInMinutes <= $lateMarkTime) {
    //         // The person is within the grace period
    //         // Mark attendance accordingly
    //         $attendanceStatus = 'Late (Grace Period)';
    //     } else {
    //         // The person is late beyond the grace period
    //         // Calculate the amount of lateness
    //         $latenessMinutes = $punchInMinutes - $allowedPunchInMinutes;
    //         // Mark attendance accordingly
    //         $attendanceStatus = 'Late (' . $latenessMinutes . ' minutes)';
    //     }

    //     echo 'Attendance Status: ' . $attendanceStatus;

    //     $root = compact('moduleName', 'permissions', 'DATA');

    //     // dd($root);
    //     return view('admin.attendance.attendance', $root);

    //     $targetValue = '30';

    //     $result = DB::table('master_endgame_method')
    //         ->where('business_id', Session::get('business_id'))
    //         ->where('id', 248)
    //         ->whereJsonContains('shift_settings_ids_list', $targetValue)
    //         ->get();
    //     dd($result);
    //     $accessPermission = Central_unit::AccessPermission();
    //     $moduleName = $accessPermission[0];
    //     $permissions = $accessPermission[1];

    //     //         $shiftType = 29;
    //     // $shiftSettingsIds = ["29", "30"];
    //     $result = DB::table('master_endgame_method')
    //         ->where('business_id', Session::get('business_id'))
    //         ->where('id', 248)
    //         ->select('shift_settings_ids_list')
    //         ->get();
    //     foreach ($result as $item) {
    //         $very = json_decode($item->shift_settings_ids_list, true);
    //         print_r($very);
    //     }

    //     // session()->forget('custom_success_message');
    //     // ->join('master_endgame_method', 'attendance_list.attendance_shift_id', '=', 'master_endgame_method.shift_settings_ids_list')
    //     $DATA = DB::table('attendance_list')
    //         ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
    //         ->join('master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'master_endgame_method.id')
    //         ->join('attendance_shift_settings', function ($join) {
    //             $join->on('master_endgame_method.shift_settings_ids_list', 'LIKE', DB::raw('CONCAT("%", attendance_shift_settings.id, "%")'));
    //         })

    //         ->select('attendance_list.*', 'employee_personal_details.emp_name', 'master_endgame_method.shift_settings_ids_list')
    //         ->distinct()
    //         ->get();
    //     dd($DATA);
    //     $root = compact('moduleName', 'permissions', 'DATA');
    //     // dd($root);
    //     return view('admin.attendance.attendance', $root);
    // }

    public function gatepass()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $DATA = DB::table('gatepass_request_list')
            ->join('employee_personal_details', 'gatepass_request_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('gatepass_request_list.business_id', Session::get('business_id'))
            ->select('gatepass_request_list.*', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_mobile_number')
            ->orderBy('gatepass_request_list.id', 'DESC')
            ->get();
        $root = compact('moduleName', 'permissions', 'DATA');
        return view('admin.request.gatepass', $root);
    }

    public function DestroyGatepass(Request $request)
    {
        $data = DB::table('gatepass_request_list')
            ->where('id', $request->id)
            ->delete();
        if ($data) {
            Alert::error('Not Updated', 'Your Gatepass Detail Delete is Fail');
        }
        return back();
    }

    public function ApproveGatepass(Request $request)
    {
        if ($request->has('id') && $request->has('in_time') && $request->has('approve')) {
            $gatepass = DB::table('gatepass_request_list')
                ->where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['in_time' => $request->in_time, 'status' => $request->approve]);
            Alert::success('Your Gatepass Request has been Approve Successfully');

            return back();
        } elseif ($request->has('id') && $request->has('in_time') && $request->has('submit') && $request->has('remark')) {
            $gatepass = DB::table('gatepass_request_list')
                ->where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['in_time' => $request->in_time, 'status' => $request->submit, 'remark' => $request->remark]);
            Alert::success('Your Gatepass Request has been Decline Successfully');
            // , 'Updated  Created'
            return back();
        } else {
            Alert::error('Not Updated', 'Your Gatepass Detail Updation is Fail');
            return back();
        }
    }

    public function ApproveLeave(Request $request)
    {
        // dd($request->all());
        if ($request->has('id') && $request->has('leave_type') && $request->has('from_date') && $request->has('to_date') && $request->has('days') && $request->has('approve')) {
            $gatepass = DB::table('leave_request_list')
                ->where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['leave_type' => $request->leave_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $request->days, 'status' => $request->approve]);
            Alert::success('Your Leave Request has been Approve Successfully');
            return back();
        } elseif ($request->has('id') && $request->has('leave_type') && $request->has('from_date') && $request->has('to_date') && $request->has('days') && $request->has('submit') && $request->has('remark')) {
            $gatepass = DB::table('leave_request_list')
                ->where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['leave_type' => $request->leave_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $request->days, 'remark' => $request->remark, 'status' => $request->submit]);
            Alert::success('Your Gatepass Request has been Decline Successfully');
            // , 'Updated  Created'
            return back();
        } else {
            Alert::error('Not Updated', 'Your Gatepass Detail Updation is Fail');
            return back();
        }

        $toDate = Carbon::parse($request->to_date);
        $fromDate = Carbon::parse($request->from_date);

        $loaded = $toDate->diffInDays($fromDate);
        $branch = DB::table('leave_request_list')
            ->where('id', $request->editLeaveId)
            ->where('business_id', Session::get('business_id'))
            ->update(['leave_type' => $request->leave_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $loaded, 'status' => $request->status]);
        if ($branch) {
            Alert::success('Data Updated', 'Leave Request Approve Successfully');
        }
        return back();
    }

    public function ApproveMisspunch(Request $request)
    {
        // dd($request->all());
        if ($request->has('id') && $request->has('time_type') && $request->has('in_time') && $request->has('out_time') && $request->has('approve')) {
            $misspunch = DB::table('misspunch_list')
                ->where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['emp_miss_time_type' => $request->time_type, 'emp_miss_in_time' => $request->in_time, 'emp_miss_out_time' => $request->out_time, 'status' => $request->approve]);
            Alert::success('Your Misspunch Request has been Approve Successfully');
            return back();
        } elseif ($request->has('id') && $request->has('time_type') && $request->has('in_time') && $request->has('out_time') && $request->has('submit') && $request->has('remark')) {
            $misspunch = DB::table('misspunch_list')
                ->where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['emp_miss_time_type' => $request->time_type, 'emp_miss_in_time' => $request->in_time, 'emp_miss_out_time' => $request->out_time, 'status' => $request->submit, 'remark' => $request->remark]);
            Alert::success('Your Gatepass Request has been Decline Successfully');
            return back();
        }
    }

    public function DestroyLeave($id)
    {
        // dd($id);
        $data = LeaveRequestList::find($id);
        $data->delete();
        if ($data) {
            Alert::success('Delete Success', 'Delete LeaveRequest Successfully');
        }
        // Session::flash('success', 'Succefully Deleted !');
        return back();
    }

    public function DestroyMisspunch($id)
    {
        // dd($id);
        $data = MisspunchList::find($id);
        $data->delete();
        if ($data) {
            Alert::success('Delete Success', 'Delete Gatepass Successfully');
        }
        // Session::flash('success', 'Succefully Deleted !');
        return back();
    }

    // DestroyMisspunch
    public function misspunch()
    {
        // return true;
        $DATA = DB::table('misspunch_list')
            ->join('employee_personal_details', 'misspunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('misspunch_list.business_id', Session::get('business_id'))
            ->select('misspunch_list.*', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->orderBy('misspunch_list.id', 'desc')
            ->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $root = compact('moduleName', 'permissions', 'DATA');

        // $data = MisspunchList::all();
        // dd($DATA);
        return view('admin.request.misspunch', $root);
    }

    public function leaves()
    {
        // $EmpCount = DB::table('employee_personal_details')
        //     ->where('business_id', Session::get('business_id'))
        //     ->count();
        // $AttendanceCount = DB::table('attendance_list')
        //     ->where(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d')])
        //     ->count();
        // dd($EmpCount);

        $item = DB::table('employee_personal_details')
            ->join('attendance_list', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            // ->join('leave_request_list', 'employee_personal_details.emp_id', 'leave_request_list.emp_id')
            // ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('attendance_list.punch_date', '!=', date('Y-m-d'))
            // ->where('leave_request_list.from_date' , date('Y-m-d'))

            ->select('employee_personal_details.emp_id')
            ->get();
        // dd($item);

        // $item  = DB::table('employee_personal_details')
        // ->join('attendance_list', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
        // ->join('leave_request_list', 'employee_personal_details.emp_id', 'leave_request_list.emp_id')
        // // ->where('employee_personal_details.business_id', Session::get('business_id'))
        // // ->where('attendance_list.punch_date' , '!=', date('Y-m-d'))
        // ->where('leave_request_list.from_date','!=',null)->where('leave_request_list.to_date','!=',null)
        // ->get();

        $TodayPresent = DB::table('attendance_list')
            ->where('business_id', Session::get('business_id'))
            ->where('punch_date', '=', now()->toDateString())
            ->get();

        $PresetCount = count($TodayPresent);
        // $daata= now()->toDateString();
        // dd($daata);

        // $TodayPresent = DB::table('leave_request_list')
        // ->join('attendance_list', 'leave_request_list.emp_id', '=', 'attendance_list.emp_id')
        // // ->join('employee_personal_details', 'leave_request_list.emp_id', '=', 'employee_personal_details.emp_id')

        // // ->join('attendance_list', 'leave_request_list.emp_id', '=', 'attendance_list.emp_id')
        // ->where('leave_request_list.business_id', Session::get('business_id'))
        // ->select('leave_request_list.id')
        // ->get();
        // dd($PresetCount);
        $DATA = DB::table('leave_request_list')
            ->join('employee_personal_details', 'leave_request_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('leave_request_list.business_id', Session::get('business_id'))
            ->select('leave_request_list.*', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->orderBy('leave_request_list.id', 'desc')
            ->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // dd($data);
        $root = compact('moduleName', 'permissions', 'DATA', 'PresetCount');
        return view('admin.request.leave', $root);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */

    public function gatepassEmployeeFilter(Request $request)
    {
        $branchId = $request->branch_id;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');

        // // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = DB::table('gatepass_request_list')
            ->join('employee_personal_details', 'gatepass_request_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'gatepass_request_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'gatepass_request_list.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'gatepass_request_list.designation_id', '=', 'designation_list.desig_id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('gatepass_request_list.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('gatepass_request_list.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('gatepass_request_list.designation_id', $designationId);
            })
            ->select('gatepass_request_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name')
            ->orderBy('gatepass_request_list.id', 'desc')
            ->get();

        // Return the filtered data as JSON response
        return response()->json(['get' => $filteredData]);
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function GatepassTable($tableName, Request $request)
    {
        // dd($tableName,$name);
        // Check if the table does not exist
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                // $table->integer('emp_id');
                // $table->string('emp_name');
                $table->date('emp_gatepass_date');
                $table->string('emp_gate_reason');
                $table->string('emp_gatepass_going_through');
                $table->time('out_time')->nullable();
                $table->time('in_time')->nullable();
                $table->timestamps();
            });
            DB::table($tableName)->insert([
                // 'emp_name' => $request->name,
                // 'emp_id' => $request->emp_id,
                'emp_gatepass_date' => $request->date,
                'emp_gate_reason' => $request->reason,
                'emp_gatepass_going_through' => $request->going_through,
                'out_time' => $request->outtime,
                'in_time' => $request->intime,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['gatpass_details' => $request->all()]);
        } else {
            return "Table '$tableName' already exists.";
        }
    }

    public function MisspunchTable($tableName, Request $request)
    {
        // dd($tableName,$name);
        // Check if the table does not exist
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                // $table->integer('emp_id');
                // $table->string('emp_name');
                $table->string('emp_name');
                $table->date('emp_miss_date');
                $table->enum('emp_miss_time_type', ['1' => 'intime', '2' => 'outtime']);
                $table->time('emp_miss_in_time')->nullable();
                $table->time('emp_miss_out_time')->nullable();
                $table->time('emp_working_hour')->nullable();
                $table->string('message');
                $table->timestamps();
            });
            DB::table($tableName)->insert([
                'emp_name' => $request->name,
                'emp_miss_date' => $request->date,
                'emp_miss_time_type' => $request->timetype,
                'emp_miss_in_time' => $request->intime,
                'emp_miss_out_time' => $request->outtime,
                'emp_working_hour' => addTimes($request->intime, $request->outtime),
                'message' => $request->message,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['gatpass_details' => $request->all()]);
            // return response($tableName->request);
        } else {
            return "Table '$tableName' already exists.";
        }
    }

    public function addTimes(Request $request)
    {
        $time1 = $request->time1;
        $time2 = $request->time2;

        // Create Carbon instances for the provided times
        $carbonTime1 = Carbon::parse($time1);
        $carbonTime2 = Carbon::parse($time2);

        // Add the two times together
        $sumTime = $carbonTime1->addHours($carbonTime2->hour)->addMinutes($carbonTime2->minute);

        return response()->json(['sum_time' => $sumTime->format('H:i')]);
        // return true;
    }

    public function show(Request $request)
    {
        $data = DB::table('gatepass_request_list')
            ->join('employee_personal_details', 'gatepass_request_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'gatepass_request_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'gatepass_request_list.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'gatepass_request_list.designation_id', '=', 'designation_list.desig_id')
            ->where('gatepass_request_list.id', $request->id)
            ->select('gatepass_request_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->first();
        return response()->json(['get' => $data]);
    }

    public function EditMisspunchDataGet(Request $request)
    {
        // return true;
        $data = DB::table('misspunch_list')
            ->join('employee_personal_details', 'misspunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'misspunch_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'misspunch_list.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'misspunch_list.designation_id', '=', 'designation_list.desig_id')
            ->where('misspunch_list.id', $request->id)
            ->select('misspunch_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->first();
        return response()->json(['get' => $data]);
    }

    public function MispunchEmployeeFilter(Request $request)
    {
        $branchId = $request->branch_id;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');

        // // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = DB::table('misspunch_list')
            ->join('employee_personal_details', 'misspunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'misspunch_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'misspunch_list.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'misspunch_list.designation_id', '=', 'designation_list.desig_id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('misspunch_list.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('misspunch_list.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('misspunch_list.designation_id', $designationId);
            })
            ->select('misspunch_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name')
            ->orderBy('misspunch_list.id', 'desc')
            ->get();

        // Return the filtered data as JSON response
        return response()->json(['get' =>  $filteredData]);
    }

    public function EditLeaveDataGet(Request $request)
    {
        // dd($request->all());
        // return $request->id;
        $data = DB::table('leave_request_list')
            ->join('employee_personal_details', 'leave_request_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'leave_request_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'leave_request_list.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'leave_request_list.designation_id', '=', 'designation_list.desig_id')
            ->where('leave_request_list.id', $request->id)
            ->select('leave_request_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->first();
        return response()->json(['get' => $data]);
    }

    public function LeaveEmployeeFilter(Request $request)
    {
        // return true;
        $branchId = $request->branch_id;
        $data = DB::table('leave_request_list')->get();
        return $data;
        // return $branchId;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        // $fromDate = $request->input('from_date');

        // // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = DB::table('leave_request_list')
            ->join('employee_personal_details', 'leave_request_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'leave_request_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'leave_request_list.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'leave_request_list.designation_id', '=', 'designation_list.desig_id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('leave_request_list.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('leave_request_list.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('leave_request_list.designation_id', $designationId);
            })
            ->when($fromDate, function ($query) use ($fromDate) {
                $query->where('leave_request_list.from_date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                $query->where('leave_request_list.to_date', '<=', $toDate);
            })

            // from_date

            ->select('leave_request_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name')
            ->orderBy('leave_request_list.id', 'desc')
            ->get();

        // Return the filtered data as JSON response
        return response()->json(['get' => $filteredData]);
    }
}

// Route::any('/gatepass/{tableName}', [RequestController::class, 'GatepassTable']);
// Route::any('/gatepass/{tableName}', [RequestController::class, 'MisspunchTable']);
// Route::any('/misspunch/detail', [RequestController::class, 'editMisspunchDataGet']);
// Route::any('/mispunchemployeefilter', [RequestController::class, 'MispunchEmployeeFilter']);
