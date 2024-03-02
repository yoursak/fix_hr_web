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
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

// models
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\ApprovalManagementCycle;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\AttendanceList;
use App\Models\AttendanceTimeLog;
use App\Models\EmployeePersonalDetail;
use App\Models\DesignationList;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicyAttendanceTrackInOut;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\LoginEmployee;
use App\Models\PolicyMasterEndgameMethod;
// use Alert;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $loginRoleID = Session::get('login_role');
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(1)[1];
        return view('admin.attendance.attendance', compact('permissions', 'moduleName', 'loginRoleID', 'checkApprovalCycleType'));
    }

    public function dashboardAttendanceCountFilter(Request $request)
    {
        $resDate = $request->date;
        $monthAbbreviations = [
            'Okt' => 'Oct',
            'Maj' => 'May',
        ];
        $engDate = str_replace(array_keys($monthAbbreviations), array_values($monthAbbreviations), $resDate);

        $date = date('Y-m-d', strtotime($engDate));
        $responseData = Central_unit::getDailyCountForDashboardAndDailyList(Session::get('business_id'), $date, Session::get('login_role'), Session::get('login_emp_id'));

        return response()->json($responseData);
    }

    public function attendanceSummary()
    {
        $businessId = Session::get('business_id');
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $EmpQuery = EmployeePersonalDetail::where('business_id', $businessId)->where('active_emp', 1);
        $roleIdToCheck = Session::get('login_role');
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)->where('emp_id', Session::get('login_emp_id'))->select('permission_branch_id')->first();
        if ($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && $checkBranchPermission->permission_type) {
            $Emp = $EmpQuery->where('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->get();
        } else {
            $Emp = $EmpQuery->get();
        }

        return view('admin.attendance.summary', compact('Emp', 'permissions', 'moduleName'));
    }

    public function attendanceMark(Request $request)
    {
        $Days = '';
        $status = 1;
        $PID = $request->Updateid;
        $UserType = RulesManagement::PassBy()[0]; //Session::get('user_type');
        $BID = RulesManagement::PassBy()[1];
        $EmpID = RulesManagement::PassBy()[2];
        $FindRoleID = RulesManagement::PassBy()[3];
        $load = RulesManagement::RoleDetailsGet();
        $AdminRoleId = $load[0];
        $ApprovalTypeID = 1; //Gatepass processType

        if ($request->has('status')) {
            $attendanced = DB::table('attendance_list')->where('id', $PID)->where('business_id', $BID)->where('emp_today_current_status', 2)->first();

            $array = [
                'redirect_id' => 1,
                'primary_id' => $PID,
                'punch_date' => $attendanced->punch_date,
            ];
            $SD = LoginEmployee::where('emp_id', $attendanced->emp_id)->first();

            $sdd = $request->status != 2 ? 'Approved' : 'Declined';

            if ($SD->notification_key != null) {
                // Convert the JSON string to an array
                $notificationKeys = json_decode($SD->notification_key, true);

                // // Iterate over each notification key and send the notification
                if (is_array($notificationKeys)) {
                    $result = RulesManagement::NotificationSendMode($notificationKeys, 'Fix HR Employee', 'Attendance ' . $sdd . ' By : ' . Session::get('login_name') . ' (' . Session::get('login_role_name') . ')' . ' ', $array);
                }
            }
            // dd(Session::all());

            if ($attendanced) {
                $ApprovalManagement = DB::table('approval_management_cycle')->where('business_id', $BID)->where('approval_type_id', $ApprovalTypeID)->first();
                if ($ApprovalManagement->cycle_type == 1) {
                    //sequential
                    // next forward
                    $status = $request->status;
                    $sd = DB::table('approval_management_cycle')->where('business_id', $BID)->where('approval_type_id', $ApprovalTypeID)->whereJsonContains('role_id', (string) $FindRoleID)->select('role_id')->first();
                    // dd($sd);
                    $value = DB::table('attendance_list')->where('business_id', $BID)->where('id', $PID)->first();
                    if ($sd) {
                        $roleIds = json_decode($sd->role_id, true); // Decode the JSON array
                        $currentIndex = array_search($FindRoleID, $roleIds); // Find the current index of forward_by_role_id
                        if ($currentIndex !== false) {
                            $nextIndex = $currentIndex + 1;
                            $prevIndex = $currentIndex - 1;

                            $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1; //sensitive case if last next end then recall 0
                            $prevRoleId = isset($roleIds[$prevIndex]) ? $roleIds[$prevIndex] : 0; //prev 1st start recall 0

                            DB::table('attendance_list')
                                ->where('business_id', $BID)
                                ->where('id', $PID)
                                ->update([
                                    'forward_by_role_id' => $nextRoleId,
                                    'forward_by_status' => $status,
                                ]);

                            DB::table('approval_status_list')
                                ->where('approval_type_id', $ApprovalTypeID)
                                ->where('role_id', $FindRoleID)
                                ->where('business_id', $BID)
                                ->where('all_request_id', $PID)
                                ->insert([
                                    'applied_cycle_type' => 1,
                                    'business_id' => $BID,
                                    'approval_type_id' => $ApprovalTypeID,
                                    'all_request_id' => $PID,
                                    'role_id' => $FindRoleID,
                                    'emp_id' => $EmpID,
                                    'clicked' => 1,
                                    'status' => $status,
                                    'prev_role_id' => $prevRoleId,
                                    'current_role_id' => $FindRoleID,
                                    'next_role_id' => $nextRoleId,
                                ]);
                            Alert::success('', 'Status is Updated');
                        }
                    }
                    if ($value->forward_by_role_id == $value->final_level_role_id) {
                        DB::table('attendance_list')
                            ->where('business_id', $BID)
                            ->where('id', $PID)
                            ->update([
                                'process_complete' => 1,
                                'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 1)[0], //final status submit
                            ]);
                    }
                }

                // default case
                if ($ApprovalManagement->cycle_type == 2) {
                    // paraller
                    $status = $request->status;

                    $parallerModalApprovalBtn = DB::table('attendance_list')
                        ->where('business_id', $BID)
                        ->where('id', $PID)
                        ->where('emp_today_current_status', 2)
                        ->update([
                            'process_complete' => 1,
                            'final_status' => $status,
                        ]);
                    if ($parallerModalApprovalBtn) {
                        $loadCheck = DB::table('approval_status_list')->where('approval_type_id', $ApprovalTypeID)->where('business_id', $BID)->where('all_request_id', $PID)->first();

                        if ($loadCheck) {
                        } else {
                            //Parallel
                            DB::table('approval_status_list')
                                ->where('business_id', $BID)
                                ->where('approval_type_id', $ApprovalTypeID)
                                ->where('all_request_id', $PID)
                                ->insert([
                                    'applied_cycle_type' => 2,
                                    'business_id' => $BID,
                                    'approval_type_id' => $ApprovalTypeID,
                                    'all_request_id' => $PID,
                                    'role_id' => $FindRoleID,
                                    'emp_id' => $EmpID,
                                    'clicked' => 1,
                                    // 'remarks' => $Remark,
                                    'status' => $status,
                                ]);
                        }
                        Alert::success('', 'Attendance is Approve');
                    } else {
                        Alert::info('', 'Attendance is not approved, punch-out is required for approval.');
                    }
                }
            } else {
                Alert::info('', 'Attendance is not approved,"\n" punch-out is required for approval.');
            }
        } elseif ($request->has('approveAll')) {

            if ($request->checkbox != '') {
                foreach ($request->checkbox as $key => $value) {
                    $PID = $request->checkbox[$key];

                    $checkPunchInPunchOut = DB::table('attendance_list')->where('business_id', $BID)->where('id', $PID)->where('emp_today_current_status', 2)->first();


                    if (isset($checkPunchInPunchOut)) {
                        // modal approval btn
                        $attendanced = DB::table('attendance_list')->where('id', $PID)->where('business_id', $BID)->where('emp_today_current_status', 2)->first();
                        $array = [
                            'redirect_id' => 1,
                            'primary_id' => $PID,
                            'punch_date' => $attendanced->punch_date,
                        ];
                        $SD = LoginEmployee::where('emp_id', $attendanced->emp_id)->first();

                        $sdd = $request->status != 2 ? 'Approved' : 'Declined';

                        if ($SD->notification_key != null) {
                            // Convert the JSON string to an array
                            $notificationKeys = json_decode($SD->notification_key, true);

                            // // Iterate over each notification key and send the notification
                            if (is_array($notificationKeys)) {
                                $result = RulesManagement::NotificationSendMode($notificationKeys, 'Fix HR Employee', 'Attendance ' . $sdd . ' By : ' . Session::get('login_name') . ' (' . Session::get('login_role_name') . ')' . ' ', $array);
                            }
                        }

                        // dd("SDf");
                        $roatationalShift = AttendanceList::where('business_id', $BID)
                            ->where('id', $PID)
                            ->where('final_status', 0)
                            ->where('emp_today_current_status', 2)
                            ->update([
                                'approved_by_role_id' => $AdminRoleId,
                                'approved_by_emp_id' => $EmpID,
                            ]);
                        $ApprovalManagement = DB::table('approval_management_cycle')->where('business_id', $BID)->where('approval_type_id', $ApprovalTypeID)->first();
                        if ($ApprovalManagement->cycle_type == 1) {
                            //sequential
                            // next forward
                            $status = $request->status;
                            $sd = DB::table('approval_management_cycle')->where('business_id', $BID)->where('approval_type_id', $ApprovalTypeID)->whereJsonContains('role_id', (string) $FindRoleID)->select('role_id')->first();
                            $value = DB::table('attendance_list')->where('business_id', $BID)->where('id', $PID)->first();
                            if ($sd) {
                                $roleIds = json_decode($sd->role_id, true); // Decode the JSON array
                                $currentIndex = array_search($FindRoleID, $roleIds); // Find the current index of forward_by_role_id

                                if ($currentIndex !== false) {
                                    $nextIndex = $currentIndex + 1;
                                    $prevIndex = $currentIndex - 1;
                                    // Check if the next index is within the bounds of the array
                                    $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1; //sensitive case if last next end then recall 0
                                    $prevRoleId = isset($roleIds[$prevIndex]) ? $roleIds[$prevIndex] : 0; //prev 1st start recall 0
                                    // Update the database for the current index
                                    DB::table('attendance_list')
                                        ->where('business_id', $BID)
                                        ->where('id', $PID)
                                        ->update([
                                            'forward_by_role_id' => $nextRoleId,
                                            'forward_by_status' => 1,
                                        ]);
                                    // Update the approval status for the current index
                                    //Sequential
                                    DB::table('approval_status_list')
                                        ->where('approval_type_id', $ApprovalTypeID)
                                        ->where('role_id', $FindRoleID)
                                        ->where('business_id', $BID)
                                        ->where('all_request_id', $PID)
                                        ->insert([
                                            'applied_cycle_type' => 1,
                                            'business_id' => $BID,
                                            'approval_type_id' => $ApprovalTypeID,
                                            'all_request_id' => $PID,
                                            'role_id' => $FindRoleID,
                                            'emp_id' => $EmpID,
                                            'clicked' => 1,
                                            'status' => 1,
                                            'prev_role_id' => $prevRoleId,
                                            'current_role_id' => $FindRoleID,
                                            'next_role_id' => $nextRoleId,
                                        ]);
                                    Alert::success('', 'Status is Updated');
                                }
                            }
                            if ($value->forward_by_role_id == $value->final_level_role_id) {
                                DB::table('attendance_list')
                                    ->where('business_id', $BID)
                                    ->where('id', $PID)
                                    ->update([
                                        'process_complete' => 1,
                                        'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 1)[0], //final status submit
                                    ]);
                            }
                        }

                        if ($ApprovalManagement->cycle_type == 2) {
                            $parallerModalApprovalBtn = DB::table('attendance_list')
                                ->where('business_id', $BID)
                                ->where('id', $PID)
                                ->where('emp_today_current_status', 2)
                                ->update([
                                    'process_complete' => 1,
                                    'final_status' => $status,
                                ]);

                            if ($parallerModalApprovalBtn) {
                                $loadCheck = DB::table('approval_status_list')->where('approval_type_id', $ApprovalTypeID)->where('business_id', $BID)->where('all_request_id', $PID)->first();

                                if ($loadCheck) {
                                } else {
                                    //Parallel
                                    DB::table('approval_status_list')
                                        ->where('business_id', $BID)
                                        ->where('approval_type_id', $ApprovalTypeID)
                                        ->where('all_request_id', $PID)
                                        ->insert([
                                            'applied_cycle_type' => 2,
                                            'business_id' => $BID,
                                            'approval_type_id' => $ApprovalTypeID,
                                            'all_request_id' => $PID,
                                            'role_id' => $FindRoleID,
                                            'emp_id' => $EmpID,
                                            'clicked' => 1,
                                            'status' => $status,
                                        ]);
                                }
                                Alert::success('', 'Attendance is Approve');
                            } else {
                                Alert::info('', 'Attendance is not approved, punch-out is required for approval.');
                            }
                        }
                    }
                }
                Alert::success('', 'Attendance Approval Updated Successfully');
            }
        } elseif ($request->has('pendingAll')) {
            $leavePendingRequestCheck = DB::table('request_leave_list')->join('employee_personal_details', 'employee_personal_details.emp_id', 'request_leave_list.emp_id')->where('employee_personal_details.active_emp', '1')->where('request_leave_list.business_id', $BID)->where('request_leave_list.final_status', 0)->first();
            $mispunchPendingRequestCheck = DB::table('request_mispunch_list')->join('employee_personal_details', 'employee_personal_details.emp_id', 'request_mispunch_list.emp_id')->where('employee_personal_details.active_emp', '1')->where('request_mispunch_list.business_id', $BID)->where('request_mispunch_list.final_status', 0)->first();
            $attendanceOutTimeMis = DB::table('attendance_list')->join('employee_personal_details', 'employee_personal_details.emp_id', 'attendance_list.emp_id')->where('employee_personal_details.active_emp', '1')->where('attendance_list.emp_today_current_status', '!=', '2')->whereDate('attendance_list.punch_date', '!=', now()->toDateString())->first();
            if ($leavePendingRequestCheck != null && $mispunchPendingRequestCheck != null && $attendanceOutTimeMis != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear your attendance, leave and mispunch first');
                return redirect('/admin/attendance');
            } elseif ($leavePendingRequestCheck != null && $mispunchPendingRequestCheck != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear your all your leave and mispunch first');
                return redirect('/admin/attendance');
            } elseif ($leavePendingRequestCheck != null && $attendanceOutTimeMis != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear all your attendance and leave first');
                return redirect('/admin/attendance');
            } elseif ($mispunchPendingRequestCheck != null && $attendanceOutTimeMis != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear all your attendance and mispunch first');
                return redirect('/admin/attendance');
            } elseif ($leavePendingRequestCheck != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear all your leave first');
                return redirect('/admin/attendance');
            } elseif ($mispunchPendingRequestCheck != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear all your mispunch first');
                return redirect('/admin/attendance');
            } elseif ($attendanceOutTimeMis != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly mark your punch out time first');
                return redirect('/admin/attendance');
            }

            $permissionBranchId = PolicySettingRoleAssignPermission::where('business_id', $BID)->where('emp_id', $EmpID)->first();
            if ($permissionBranchId !== null && !empty($permissionBranchId) && $FindRoleID != 1 && $permissionBranchId->permission_type == 2) {
                $PendingApproval = DB::table('attendance_list')
                    ->where('final_status', 0)
                    ->where('branch_id', $permissionBranchId->permission_branch_id)
                    ->where('process_complete', 0)
                    ->where('business_id', $BID)
                    ->where('emp_today_current_status', 2)
                    ->get();
            } else {
                $PendingApproval = DB::table('attendance_list')->where('final_status', 0)->where('process_complete', 0)->where('business_id', $BID)->where('emp_today_current_status', 2)->get();
            }
            if ($PendingApproval->count() == 0) {
                return back();
            }

            foreach ($PendingApproval as $key => $value) {
                $PID = $value->id;
                // modal approval btn
                $attendanced = DB::table('attendance_list')->where('id', $PID)->where('business_id', $BID)->where('emp_today_current_status', 2)->first();
                $array = [
                    'redirect_id' => 1,
                    'primary_id' => $PID,
                    'punch_date' => $attendanced->punch_date,
                ];
                $SD = LoginEmployee::where('emp_id', $attendanced->emp_id)->first();

                $sdd = $request->status != 2 ? 'Approved' : 'Declined';

                if ($SD->notification_key != null) {
                    // Convert the JSON string to an array
                    $notificationKeys = json_decode($SD->notification_key, true);

                    // // Iterate over each notification key and send the notification
                    if (is_array($notificationKeys)) {
                        $result = RulesManagement::NotificationSendMode($notificationKeys, 'Fix HR Employee', 'Attendance ' . $sdd . ' By : ' . Session::get('login_name') . ' (' . Session::get('login_role_name') . ')' . ' ', $array);
                    }
                }
                // dd("SDf");
                if (isset($PendingApproval)) {
                    $ApprovalManagement = DB::table('approval_management_cycle')->where('business_id', $BID)->where('approval_type_id', $ApprovalTypeID)->first();
                    if ($ApprovalManagement->cycle_type == 1) {
                        $status = $request->status;
                        $sd = DB::table('approval_management_cycle')->where('business_id', $BID)->where('approval_type_id', $ApprovalTypeID)->whereJsonContains('role_id', (string) $FindRoleID)->select('role_id')->first();
                        $value = DB::table('attendance_list')->where('business_id', $BID)->where('id', $PID)->first();
                        if ($sd) {
                            $roleIds = json_decode($sd->role_id, true); // Decode the JSON array
                            $currentIndex = array_search($FindRoleID, $roleIds); // Find the current index of forward_by_role_id

                            if ($currentIndex !== false) {
                                $nextIndex = $currentIndex + 1;
                                $prevIndex = $currentIndex - 1;

                                // Check if the next index is within the bounds of the array
                                $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1; //sensitive case if last next end then recall 0
                                $prevRoleId = isset($roleIds[$prevIndex]) ? $roleIds[$prevIndex] : 0; //prev 1st start recall 0

                                // Update the database for the current index
                                $attendanccelist = DB::table('attendance_list')
                                    ->where('business_id', $BID)
                                    ->where('id', $PID)
                                    ->update([
                                        'forward_by_role_id' => $nextRoleId,
                                        'forward_by_status' => 1,
                                    ]);

                                $approvalstatuslist = DB::table('approval_status_list')
                                    ->where('approval_type_id', $ApprovalTypeID)
                                    ->where('role_id', $FindRoleID)
                                    ->where('business_id', $BID)
                                    ->where('all_request_id', $PID)
                                    ->insert([
                                        'applied_cycle_type' => 1,
                                        'business_id' => $BID,
                                        'approval_type_id' => $ApprovalTypeID,
                                        'all_request_id' => $PID,
                                        'role_id' => $FindRoleID,
                                        'emp_id' => $EmpID,
                                        'clicked' => 1,
                                        'status' => 1,
                                        'prev_role_id' => $prevRoleId,
                                        'current_role_id' => $FindRoleID,
                                        'next_role_id' => $nextRoleId,
                                    ]);
                            }
                        }
                        if ($value->forward_by_role_id == $value->final_level_role_id) {
                            DB::table('attendance_list')
                                ->where('business_id', $BID)
                                ->where('id', $PID)
                                ->update([
                                    'process_complete' => 1,
                                    'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 1)[0], //final status submit
                                ]);
                        }
                    }

                    if ($ApprovalManagement->cycle_type == 2) {
                        $parallerModalApprovalBtn = DB::table('attendance_list')
                            ->where('business_id', $BID)
                            ->where('id', $PID)
                            ->where('emp_today_current_status', 2)
                            ->update([
                                'process_complete' => 1,
                                'final_status' => $status,
                            ]);
                        if ($parallerModalApprovalBtn) {
                            $loadCheck = DB::table('approval_status_list')->where('approval_type_id', $ApprovalTypeID)->where('business_id', $BID)->where('all_request_id', $PID)->first();

                            if ($loadCheck) {
                            } else {
                                //Parallel
                                DB::table('approval_status_list')
                                    ->where('business_id', $BID)
                                    ->where('approval_type_id', $ApprovalTypeID)
                                    ->where('all_request_id', $PID)
                                    ->insert([
                                        'applied_cycle_type' => 2,
                                        'business_id' => $BID,
                                        'approval_type_id' => $ApprovalTypeID,
                                        'all_request_id' => $PID,
                                        'role_id' => $FindRoleID,
                                        'emp_id' => $EmpID,
                                        'clicked' => 1,
                                        // 'remarks' => $Remark,
                                        'status' => $status,
                                    ]);
                            }
                            Alert::success('', 'Attendance is Approve');
                        } else {
                            Alert::info('', 'Attendance is not approved, punch-out is required for approval.');
                        }
                    }
                }
            }
            Alert::success('', 'Attendance Approval Updated Successfully');
        } else {
            Alert::warning('', 'Attendance Approval Not Updated');
        }

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

        $atteUpdate = AttendanceList::where('id', $request->Updateid)
            ->where('business_id', Session::get('business_id'))
            ->update(['punch_in_time' => $request->editPunchInTime, 'punch_out_time' => $request->editPunchOutTime, 'total_working_hour' => $totalWorking, 'final_status' => 1]);
        if ($atteUpdate) {
            Alert::success('Your aAttendacne request has been approve successfully');
        } else {
            Alert::error('Your attendacne request has not been approve successfully');
        }
        return redirect()->to('admin/attendance');
    }

    public function empIdToData(Request $request)
    {
        $SHOW = AttendanceList::where('id', $request->id)->first();
        // join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
        // // ->
        return response()->json(['get' => $SHOW]);
    }

    public function byemployee(Request $request, $id)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // dd($permissions);
        $emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->where('emp_id', $id)->first();

        return view('admin.attendance.attendancevby_employee', compact('emp', 'permissions'));
    }

    public function details(Request $request)
    {
        // dd($request->emp_id);
        $businessId = Session::get('business_id');
        $roleIdToCheck = Session::get('login_role');
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $permissionBranchId = PolicySettingRoleAssignPermission::where('business_id', $businessId)->where('emp_id', Session::get('login_emp_id'))->first();
        // dd($permissionBranchId);
        if ($permissionBranchId !== null && !empty($permissionBranchId) && $roleIdToCheck != 1 && $permissionBranchId->permission_type == 2) {
            $Emp = EmployeePersonalDetail::where('business_id', $businessId)
                ->where('employee_personal_details.branch_id', $permissionBranchId->permission_branch_id)
                ->where('active_emp', 1)
                ->get();
        } else {
            $Emp = EmployeePersonalDetail::where('business_id', $businessId)->where('active_emp', 1)->get();
        }
        $designation = DesignationList::where('business_id', $businessId)->first();

        return view('admin.attendance.emp_attendace', compact('Emp', 'designation', 'permissions'));
    }

    public function createShift()
    {
        $attendaceShift = DB::table('policy_attendance_shift_settings')->where('business_id', Session::get('business_id'))->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view('admin.setting.attendance.createshift', compact('permissions', 'moduleName', 'attendaceShift'));
    }
    public function submitTrackInTrackOut(Request $request)
    {
        $updated = PolicyAttendanceTrackInOut::where('business_id', Session::get('business_id'))->first();

        if (isset($updated)) {
            $load = PolicyAttendanceTrackInOut::where('business_id', Session::get('business_id'))->update([
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
            $load = PolicyAttendanceTrackInOut::insert([
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
    }

    public function getAttendaceShiftList(Request $request)
    {
        $load = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $request->id)->get();
        return response()->json(['get' => $load]);
    }

    public function addShift(Request $request)
    {


        if ($request->shiftType == 1) {


            $load_first = PolicyAttendanceShiftSetting::insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->fixedshiftName,
            ]);
            if (isset($load_first)) {
                $firstload = DB::getPdo()->lastInsertId();

                $fixShift = PolicyAttendanceShiftTypeItem::insert([
                    'attendance_shift_id' => $firstload,
                    'shift_name' => $request->fixedshiftName,
                    'shift_start' => $request->fixShiftStart,
                    'shift_end' => $request->fixShiftEnd,
                    'break_min' => $request->fixShiftBreak,
                    'is_paid' => $request->fixpaid,
                    'work_hr' => $request->f_WorkHour,
                    'work_min' => $request->f_WorkMin,
                    'is_active' => 1,
                    'business_id' => $request->session()->get('business_id'),
                    'branch_id' => $request->session()->get('branch_id'),
                    'updated_at' => now(),
                ]);

                if ($fixShift) {
                    Alert::success('', 'Your fixed shift has been created successfully', '')->persistent(true);
                } else {
                    Alert::error('', 'Your fixed shift has not been created')->persistent(true);
                }
            }
        } elseif ($request->shiftType == 2) {
            $load_second = PolicyAttendanceShiftSetting::insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->rotationalName,
            ]);
            if (isset($load_second)) {
                $secondload = DB::getPdo()->lastInsertId();

                foreach ($request->rotationalShiftName as $key => $rotationalShiftName) {
                    $roatationalShift = PolicyAttendanceShiftTypeItem::insert([
                        'attendance_shift_id' => $secondload,
                        'shift_name' => $request->rotationalShiftName[$key],
                        'shift_start' => $request->rotationalShiftStart[$key],
                        'shift_end' => $request->rotationalShiftEnd[$key],
                        'break_min' => $request->rotationalShiftBreak[$key],
                        'is_paid' => $request->rotationalpaid[$key],
                        'work_hr' => $request->r_WorkHour[$key],
                        'work_min' => $request->r_WorkMin[$key],
                        'is_active' => $key == 0 ? 1 : 0,
                        'branch_id' => $request->session()->get('branch_id'),
                        'business_id' => $request->session()->get('business_id'),
                        'updated_at' => now(),
                    ]);
                }

                if ($roatationalShift) {
                    Alert::success('', 'Your Rotational shift has been created successfully', '')->persistent(true);
                } else {
                    Alert::error('', 'Your Rotational shift has not been created')->persistent(true);
                }
            }
        } elseif ($request->shiftType == 3) {
            $load_third = PolicyAttendanceShiftSetting::insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->openShiftName,
            ]);

            if (isset($load_third)) {
                $thridload = DB::getPdo()->lastInsertId();

                $openShift = PolicyAttendanceShiftTypeItem::insert([
                    'attendance_shift_id' => $thridload,
                    'shift_name' => $request->openShiftName,
                    'shift_hr' => $request->openHour,
                    'shift_min' => $request->openMin,
                    'break_min' => $request->openBreak,
                    'is_paid' => $request->openPaid,
                    'is_active' => 1,
                    'branch_id' => $request->session()->get('branch_id'),
                    'business_id' => $request->session()->get('business_id'),
                    'updated_at' => now(),
                ]);

                if ($openShift) {
                    Alert::success('', 'Your open shift has been created successfully', '')->persistent(true);
                } else {
                    Alert::error('', 'Your open shift has not been created')->persistent(true);
                }
            }
        }
        return redirect()->back();
    }

    public function updateAttendaceShift(Request $request)
    {
        $updatedAttendanceShift = false;
        // dd($request->all());
        $defaultID = $request->setId;

        if (isset($request->setId)) {
            if (isset($request->shiftType) == 2) {
                if ($request->rotationName && $request->updateItmeIdName && $request->editshiftname && $request->editstartshift && $request->editshiftTimeend && isset($request->ru_WorkHour) && isset($request->ru_WorkMin) && isset($request->isPaid)) {
                    $shiftData = [];
                } // Create an array to store the cleaned data
                $load = PolicyAttendanceShiftSetting::where('id', (int) $request->setId)
                    ->where('shift_type', $request->shiftType)
                    ->where('business_id', Session::get('business_id'))
                    ->first();

                if (isset($load)) {
                    PolicyAttendanceShiftSetting::where('id', $load->id)->update(['shift_type_name' => $request->rotationName]);
                    $editshiftname = $request->editshiftname;
                    $editstartshift = $request->editstartshift;
                    $editshiftTimeend = $request->editshiftTimeend;
                    $updatedRotationalShiftBreak = $request->updatedRotationalShiftBreak;
                    $ru_WorkHour = $request->ru_WorkHour;
                    $ru_WorkMin = $request->ru_WorkMin;
                    $isPaid = $request->isPaid;
                    $loadItemsCheck = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)
                        ->where('business_id', Session::get('business_id'))
                        ->pluck('id')
                        ->toArray();
                    $updateItems = $request->updateItmeIdName;
                    $nonExistentIds = array_diff($loadItemsCheck, $updateItems);
                    if (isset($nonExistentIds)) {
                        $delete = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)
                            ->where('business_id', Session::get('business_id'))
                            ->whereIn('id', $nonExistentIds)
                            ->delete();
                    }

                    foreach ($request->updateItmeIdName as $key => $item) {
                        // Check if all required properties exist in the item
                        $loadItems = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)
                            ->where('id', (int) $item)
                            ->where('business_id', Session::get('business_id'))
                            ->first();

                        if (isset($loadItems)) {
                            $loadItems = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)
                                ->where('id', (int) $item)
                                ->where('business_id', Session::get('business_id'))
                                ->update([
                                    'shift_name' => $editshiftname[$item],
                                    'shift_start' => $editstartshift[$item],
                                    'shift_end' => $editshiftTimeend[$item],
                                    'work_hr' => $ru_WorkHour[$item],
                                    'work_min' => $ru_WorkMin[$item],
                                    'break_min' => $updatedRotationalShiftBreak[$item],
                                    'is_paid' => $isPaid[$item],
                                ]);
                        } else {
                            PolicyAttendanceShiftTypeItem::insert([
                                'attendance_shift_id' => $defaultID,
                                'business_id' => Session::get('business_id'),
                                'branch_id' => Session::get('branch_id'),
                                'shift_name' => $editshiftname[$item],
                                'shift_start' => $editstartshift[$item],
                                'shift_end' => $editshiftTimeend[$item],
                                'break_min' => $updatedRotationalShiftBreak[$item],
                                'is_paid' => $isPaid[$item],
                                'work_hr' => $ru_WorkHour[$item],
                                'work_min' => $ru_WorkHour[$item],
                            ]);
                        }
                    }
                }
                $updatedAttendanceShift = true;
                Alert::success('', 'Your Rotational shift has been updated successfully')->persistent(true);
            }
        }

        if ($request->EditShiftFixedShiftSubmit === 'FixedSubmit') {
            $load_first = PolicyAttendanceShiftSetting::where(['business_id' => Session::get('business_id'), 'id' => $request->fixedshiftId])->update([
                'business_id' => Session::get('business_id'),
                'branch_id' => Session::get('branch_id'),
                'shift_type' => $request->fixiedshifttype,
                'shift_type_name' => $request->editfixedshiftname,
            ]);

            $fixUpdate = PolicyAttendanceShiftTypeItem::where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->fixedshiftId])->update([
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
                Alert::success('', 'Your fixed shift has been updated successfully')->persistent(true);
            } else {
                Alert::error('', 'Your fixed shift has not been updated')->persistent(true);
            }
            return redirect()->back();
        }
        if ($request->EditShiftOpenShiftSubmit == 'OpenSubmit') {
            // dd($request->all());
            $load_first = PolicyAttendanceShiftSetting::where(['business_id' => Session::get('business_id'), 'id' => $request->openshiftId])->update([
                'business_id' => Session::get('business_id'),
                'branch_id' => Session::get('branch_id'),
                'shift_type' => $request->editshifttype,
                'shift_type_name' => $request->editopenShiftName,
            ]);

            $fixUpdate = PolicyAttendanceShiftTypeItem::where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->openshiftId])->update([
                'shift_name' => $request->editopenShiftName,
                'shift_hr' => $request->editopenHour,
                'shift_min' => $request->editopenMin,
                'break_min' => $request->editopenBreak,
                'is_paid' => $request->editopenPaid,
                'updated_at' => now(),
            ]);

            if (isset($fixUpdate) && isset($load_first)) {
                Alert::success('', 'Your open shift has been updated successfully')->persistent(true);
            } else {
                Alert::error('', 'Your open shift has not been updated')->persistent(true);
            }
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function restoreAllAttendanceCount()
    {
        $attendanceList = DB::table('attendance_list')->get();
        foreach ($attendanceList as $list) {
            Central_unit::MyCountForMonth($list->emp_id, $list->punch_date, $list->business_id, $list->branch_id);
            Central_unit::MyCountForDaily($list->punch_date, $list->business_id, $list->branch_id, 1, '');
        }
        dd('Completed');
    }

    public function deleteShift(Request $request)
    {
        $checkmat = PolicyMasterEndgameMethod::where('business_id', Session::get('business_id'))
            ->whereJsonContains('shift_settings_ids_list', $request->shift_id)
            ->count();

        if ($checkmat == 0) {
            $load_first = PolicyAttendanceShiftSetting::where(['business_id' => Session::get('business_id'), 'id' => $request->shift_id])->delete();
            $fixUpdate = PolicyAttendanceShiftTypeItem::where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->shift_id])->delete();
        }
        if (isset($fixUpdate) && isset($load_first)) {
            Alert::success('', 'Your shift has been deleted successfully')->persistent(true);
        } else {
            Alert::error('', 'You cannot delete the shift if you have an employee associated with it.')->persistent(true);
        }

        return back();
    }
}
