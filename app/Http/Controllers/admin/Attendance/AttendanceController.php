<?php

namespace App\Http\Controllers\admin\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use App\Helpers\Central_unit;

use App\Helpers\MasterRulesManagement\RulesManagement;
use Alert;

class AttendanceController extends Controller
{
    public function index()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $root = compact('moduleName', 'permissions');

        // dd($root);
        return view('admin.attendance.attendance', $root);
    }
    public function details(Request $request)
    {
        // dd($request->emp_id);
        $model = DB::table('attendance_list')->where('emp_id', $request->emp_id)->first();
        $load = compact('model');
        return view('admin.attendance.emp_attendace', $load);
    }

    public function createShift()
    {
        $fixShift = DB::table('shift_fixed')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $openShift = DB::table('shift_open')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $rotationalShift = DB::table('shift_rotational')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $setShift = DB::table('shift_set')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $attendaceShift = DB::table('attendance_shift_settings')->where('business_id', Session::get('business_id'))->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.createshift', compact('setShift', 'rotationalShift', 'openShift', 'fixShift', 'permissions', 'moduleName', 'attendaceShift'));
    }
    public function submitTrackInTrackOut(Request $request)
    {
        $updated = DB::table('attendance_track_in_out')->where('business_id', Session::get('business_id'))->first();

        if (isset($updated)) {
            $load = DB::table('attendance_track_in_out')->where('business_id', Session::get('business_id'))->update([
                'business_id' => Session::get('business_id'),
                'track_in_out' => (isset($request->tranck_in_out)) ? $request->tranck_in_out : 0,
                'no_attendace_without_punch' => (isset($request->no_attendace_with_punch)) ? $request->no_attendace_with_punch : 0
            ]);
            if (isset($load)) {
                Alert::success('Mode of Attendence Set to Auto Updated');
            } else {

                Alert::info('Mode of Attendance Not Set! Update');
            }
        } else {


            $load = DB::table('attendance_track_in_out')->insert([
                'business_id' => Session::get('business_id'),
                'track_in_out' => (isset($request->tranck_in_out)) ? $request->tranck_in_out : 0,
                'no_attendace_without_punch' => (isset($request->no_attendace_with_punch)) ? $request->no_attendace_with_punch : 0
            ]);
            if (isset($load)) {
                Alert::success('Mode of Attendence Set to Auto');
            } else {

                Alert::info('Mode of Attendance Not Set!');
            }
        }

        return redirect()->to('admin/settings/attendance');
        //    dd($request->all());
    }

    public function getAttendaceShiftList(Request $request)
    {
        $load = DB::table('attendance_shift_type_items')->where('attendance_shift_id', $request->id)->get();
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
                'shift_type_name' => $request->fixedshiftName
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
                    'business_id' => $request->session()->get('business_id'),
                    'branch_id' => $request->session()->get('branch_id'),
                    'updated_at' => now(),
                ]);

                if ($fixShift) {
                    Alert::success('Fixed Shift Created Successfully', '');
                } else {
                    Alert::error('Fixed Shift is Not Created!');
                }
            }
        } else if ($request->shiftType == 2) {
            $load_second = DB::table('attendance_shift_settings')->insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->rotationalName
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
                        'branch_id' => $request->session()->get('branch_id'),
                        'business_id' => $request->session()->get('business_id'),
                        'updated_at' => now(),
                    ]);
                }

                if ($roatationalShift) {
                    Alert::success('Rotational Shift Created Successfully', '');
                } else {
                    Alert::error('Rotational Shift is Not Created');
                }
            }
        } else if ($request->shiftType == 3) {
            $load_third = DB::table('attendance_shift_settings')->insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->openShiftName
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
                    'branch_id' => $request->session()->get('branch_id'),
                    'business_id' => $request->session()->get('business_id'),
                    'updated_at' => now(),
                ]);

                if ($openShift) {
                    Alert::success('Open Shift Created Successfully', '');
                } else {
                    Alert::error('Open Shift is Not Created!');
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


        if ($request->ajax()) {
            if ($request->shift_type == 2) {
                $shiftData = []; // Create an array to store the cleaned data

                foreach ($request->updated_items as $key => $item) {
                    // Check if all required properties exist in the item
                    if (
                        isset($item['shift_name']) &&
                        isset($item['start_time']) &&
                        isset($item['end_time']) &&
                        isset($item['break_min']) &&
                        isset($item['is_paid']) &&
                        isset($item['work_hr']) &&
                        isset($item['work_min'])
                    ) {
                        // Access individual properties of each item
                        $defaultID = (int) $request->id;
                        $shiftName = $item['shift_name'];
                        $startTime = $item['start_time'];
                        $endTime = $item['end_time'];
                        $breakMin = $item['break_min'];
                        $isPaid = $item['is_paid'];
                        $workHour = $item['work_hr'];
                        $workMin = $item['work_min'];
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
                            'work_min' => $workMin
                        ];
                    }
                }

                $load = DB::table('attendance_shift_settings')->where('id', (int) $request->id)->where('shift_type', $request->shift_type)->where('business_id', Session::get('business_id'))->first();
                if (isset($load)) {
                    DB::table('attendance_shift_settings')->where('id', $load->id)->update(['shift_type_name' => $request->shift_rotation_name]);
                    $loadItems = DB::table('attendance_shift_type_items')->where('attendance_shift_id', $load->id)->where('business_id', Session::get('business_id'))->delete();
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
            $load_first = DB::table('attendance_shift_settings')->where(['business_id' => Session::get('business_id'), 'id' => $request->fixedshiftId])->update([
                'business_id' => Session::get('business_id'),
                'branch_id' => Session::get('branch_id'),
                'shift_type' => $request->fixiedshifttype,
                'shift_type_name' => $request->editfixedshiftname
            ]);

            $fixUpdate = DB::table('attendance_shift_type_items')->where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->fixedshiftId])->update([
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
                Alert::success('Fixed Shift is Updated Successfully');
            } else {
                Alert::error('Fixed Shift is Not Updated');
            }
            return redirect()->to('admin/settings/attendance/create_shift');
        }
        if ($request->EditShiftOpenShiftSubmit == 'OpenSubmit') {
            // dd($request->all());
            $load_first = DB::table('attendance_shift_settings')->where(['business_id' => Session::get('business_id'), 'id' => $request->openshiftId])->update([
                'business_id' => Session::get('business_id'),
                'branch_id' => Session::get('branch_id'),
                'shift_type' => $request->editshifttype,
                'shift_type_name' => $request->editopenShiftName
            ]);

            $fixUpdate = DB::table('attendance_shift_type_items')->where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->openshiftId])->update([
                'shift_name' => $request->editopenShiftName,
                'shift_hr' => $request->editopenHour,
                'shift_min' => $request->editopenMin,
                'break_min' => $request->editopenBreak,
                'is_paid' => $request->editopenPaid,
                'updated_at' => now(),
            ]);

            if (isset($fixUpdate) && isset($load_first)) {
                Alert::success('Open Shift is Updated Successfully');
            } else {
                Alert::error('Open Shift is Not Updated');
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

        $load_first = DB::table('attendance_shift_settings')->where(['business_id' => Session::get('business_id'), 'id' => $request->shift_id])->delete();
        $fixUpdate = DB::table('attendance_shift_type_items')->where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->shift_id])->delete();

        if (isset($fixUpdate) && isset($load_first)) {
            Alert::success('Deleted is Successfully');
        } else {
            Alert::error('Not Delete');
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
        
        // dd($LeavePolicy);
        $root = compact('moduleName', 'permissions', 'BusinessDetails', 'FinalEndGameRule', 'BranchList', 'LeavePolicy', 'HolidayPolicy', 'weeklyPolicy', 'attendanceModePolicy', 'attendanceShiftPolicy', 'attendanceTrackInOut');
        return view('admin.setting.active_rules.active_end_game', $root);
    }
    // End Games Rule Submit form
    public function FinalStartRuleEndGame(Request $request)
    {
        $data = [
            'business_id' => $request->b_id,
            'branch_id' => json_encode($request->input("branhcid")),
            'method_name' => $request->methodname,
            'policy_preference' => $request->policypreference,
            'level_type' => 1,
            'leave_policy_ids_list' => json_encode($request->input("leavepolicy")),
            'holiday_policy_ids_list' => json_encode($request->input("holidaypolicy")),
            'weekly_policy_ids_list' => json_encode($request->input("weeklypolicy")),
            'shift_settings_ids_list' => json_encode($request->input("shiftsetting")),
            'attendance_mode_list' => json_encode($request->input("attendancemode")),
            'track_in_out_ids_list' => json_encode($request->input("trackpunch"))
        ];
        $load =  DB::table('master_endgame_method')->insert($data);
        if (isset($load)) {
            Alert::success('Create Final Rules is Successfully');
        } else {
            Alert::error('Failed Final Rules Created!');
        }
        // 'depart_id	' => json_decode($request->input("depart_id")),
        // 'automation_rules_list' => json_encode($request->input("automationrules")),
        return redirect()->to('admin/attendance/active_mode_set');
        // dd($leavePolicyIds);
    }
}
