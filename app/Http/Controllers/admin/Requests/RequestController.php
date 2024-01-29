<?php

namespace App\Http\Controllers\admin\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\PolicyAttendanceMode;
use App\Models\ApprovalManagementCycle;
use App\Models\EmployeePersonalDetail;
use App\Helpers\ApiResponse;
use Carbon\Carbon;
use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\RequestGatepassList;
use App\Models\ApprovalStatusList;
use App\Models\RequestLeaveList;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\AttendanceList;
use App\Models\StaticMisPunchTimeType;
use App\Models\StaticLeaveShiftType;
use App\Models\StaticRequestLeaveType;
use App\Models\LoginEmployee;
use App\Models\StaticGoingThroughType;
use App\Models\RequestMispunchList;
use RealRashid\SweetAlert\Facades\Alert;
use DateTime;
use DB;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class RequestController extends Controller
{
    public function gatepass()
    {
        $businessId = Session::get('business_id');
        $roleIdToCheck = Session::get('login_role');
        list($moduleName, $permissions) = Central_unit::AccessPermission();
        $checkArray = json_decode(
            PolicySettingRoleAssignPermission::where('business_id', $businessId)
                ->where('emp_id', Session::get('login_emp_id'))
                ->select('permission_branch_id')
                ->pluck('permission_branch_id')
                ->first(),
            true
        );
        $baseQuery = RequestGatepassList::join('employee_personal_details', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('request_gatepass_list.business_id', $businessId)
            ->where('employee_personal_details.active_emp', '1')
            ->whereMonth('request_gatepass_list.date', now()->month)
            ->whereYear('request_gatepass_list.date', now()->year)
            ->select(
                'request_gatepass_list.*',
                'employee_personal_details.profile_photo',
                'employee_personal_details.emp_name',
                'employee_personal_details.emp_mname',
                'employee_personal_details.emp_lname',
                'employee_personal_details.designation_id',
                'employee_personal_details.emp_mobile_number'
            )
            ->orderByDesc('request_gatepass_list.id');
        if ($checkArray !== null && !empty($checkArray) && $roleIdToCheck != 1) {
            $DATA = $baseQuery->whereIn('employee_personal_details.branch_id', $checkArray)->get();
        } else {
            $DATA = $baseQuery->get();
        }
        $approvalDetails = RulesManagement::ApprovalGetDetails(4);
        $checkApprovalCycleType = $approvalDetails[1];
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $going_through = StaticGoingThroughType::all();
        $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::where('business_id', $businessId)
            ->where('approval_type_id', 4)
            ->where('cycle_type', 2)
            ->whereJsonContains('role_id', (string) $roleIdToCheck)
            ->first();
        $root = compact('parallerCaseApprovalListRoleIdCheck', 'moduleName', 'going_through', 'permissions', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'DATA');
        return view('admin.request.gatepass', $root);
    }


    // delete gatepass detail
    public function DestroyGatepass(Request $request)
    {
        $data = RequestGatepassList::where('id', $request->id)->delete();
        if ($data) {
            Alert::error('', 'Your Gatepass detail has been  deleted');
        }
        return back();
    }

    // gatepas approve
    public function ApproveGatepass(Request $request)
    {
        // cyclic dynamic data storing
        $Days = '';
        $status = 0;
        $PID = $request->id;
        $BID = RulesManagement::PassBy()[1];
        $FindRoleID = RulesManagement::PassBy()[3];
        $EmpID = RulesManagement::PassBy()[2];

        $Remark = $request->remark;
        if ($request->approve == '1') {
            $status = 1;
        }
        if ($request->decline == '2') {
            $status = 2;
        }
        $ApprovalTypeID = 4; //Gatepass processType
        $gatepass = RequestGatepassList::where('id', $request->id)
            ->where('business_id', Session::get('business_id'))
            ->update(['out_time' => $request->out_time, 'in_time' => $request->in_time]);
        $gatepassNotification = RequestGatepassList::where('id', $request->id)
            ->where('business_id', Session::get('business_id'))
            ->first();
        // dd($gatepassNotification);
        // notification calling node model by jayant
        $array = [
            'redirect_id' => 4,
            'primary_id' => $PID,
            'punch_date' => $gatepassNotification->date, //when apply model
        ];
        $SD = LoginEmployee::where('emp_id', $gatepassNotification->emp_id)->first();
        $sdd = ($request->status !== 2) ? 'Approved' : 'Declined';
        if ($SD->notification_key != null) {
            $inTimeFormatted = date('h:i A', strtotime($gatepassNotification->in_time));
            $outTimeFormatted = date('h:i A', strtotime($gatepassNotification->out_time));

            RulesManagement::NotificationSendMode(
                $SD->notification_key,
                'Fix HR Employee',
                "Apply Date : {$gatepassNotification->date} \nGatePass Status {$sdd} By " . Session::get('user_type') . "\nInTime : {$inTimeFormatted} OutTime : {$outTimeFormatted}",
                $array
            ); //send notification
        }
        $ApprovalManagement = DB::table('approval_management_cycle')
            ->where('business_id', $BID)
            ->where('approval_type_id', $ApprovalTypeID)
            ->first();

        // dd($request->all(), $status, $ApprovalManagement, $sd);
        if ($ApprovalManagement->cycle_type == 1) {
            //sequential
            // next forward
            $sd = DB::table('approval_management_cycle')
                ->where('business_id', $BID)
                ->where('approval_type_id', $ApprovalTypeID)
                ->whereJsonContains('role_id', (string) $FindRoleID)
                ->select('role_id')
                ->first();
            // dd($request->all());
            $value = DB::table('request_gatepass_list')
                ->where('business_id', $BID)
                ->where('id', $PID)
                ->first();
            if ($sd) {
                $roleIds = json_decode($sd->role_id, true); // Decode the JSON array
                $currentIndex = array_search($FindRoleID, $roleIds); // Find the current index of forward_by_role_id

                if ($currentIndex !== false) {
                    $nextIndex = $currentIndex + 1;
                    $prevIndex = $currentIndex - 1;

                    // Check if the next index is within the bounds of the array
                    // if (isset($roleIds[$nextIndex])) {
                    $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1; //sensitive case if last next end then recall 0
                    $prevRoleId = isset($roleIds[$prevIndex]) ? $roleIds[$prevIndex] : 0; //prev 1st start recall 0

                    // dd($request->all(),$FindRoleID,$nextRoleId);
                    // Update the database for the current index
                    DB::table('request_gatepass_list')
                        ->where('business_id', $BID)
                        ->where('id', $PID)
                        ->update([
                            'forward_by_role_id' => $nextRoleId,
                            'forward_by_status' => $status,
                        ]);
                    // dd($sd);

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
                            'remarks' => $Remark != null ? $Remark : '',
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
                DB::table('request_gatepass_list')
                    ->where('business_id', $BID)
                    ->where('id', $PID)
                    ->update([
                        'process_complete' => 1,
                        'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 4)[0], //final status submit
                    ]);
            }
        }
        // dd($ApprovalManagement);

        // default case
        if ($ApprovalManagement->cycle_type == 2) {
            // paraller
            DB::table('request_gatepass_list')
                ->where('business_id', $BID)
                ->where('id', $PID)
                ->update([
                    'process_complete' => 1,
                    'final_status' => $status,
                ]);
            $loadCheck = DB::table('approval_status_list')
                ->where('approval_type_id', $ApprovalTypeID)
                ->where('business_id', $BID)
                ->where('all_request_id', $PID)
                ->first();
            // dd($loadCheck);

            if ($loadCheck) {
                // DB::table('approval_status_list')
                //     ->where('business_id', $BID)
                //     ->where('approval_type_id', $ApprovalTypeID)
                //     ->where('all_request_id', $PID)
                //     ->update([
                //         'business_id' => $BID,
                // 'applied_cycle_type' => 2,
                //         'approval_type_id' => $ApprovalTypeID,
                //         'all_request_id' => $PID,
                //         'role_id' => $FindRoleID,
                //         'emp_id' => $EmpID,
                //         'remarks' => $Remark,
                //         'status' => $status,
                //     ]);
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
                        'remarks' => $Remark,
                        'status' => $status,
                    ]);
            }
            Alert::success('', 'Status is updated');
        }
        return redirect()->back();
    }

    public function leaves()
    {
        // session data
        $businessId = Session::get('business_id');
        $roleIdToCheck = Session::get('login_role');
        $roleIdToCheck = Session::get('login_role');
        // helper call data
        $Branch = Central_unit::BranchList();
        $accessPermission = Central_unit::AccessPermission();
        // processCycle Seq. Parallel approval
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(2)[1];
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        list($moduleName, $permissions) = $accessPermission;
        // static dropdown data
        $shiftType = StaticLeaveShiftType::all();
        $leaveType = StaticRequestLeaveType::all();
        // check branch and business level permission
        $checkArray = json_decode(
            PolicySettingRoleAssignPermission::where('business_id', $businessId)
                ->where('emp_id', Session::get('login_emp_id'))
                ->pluck('permission_branch_id')
                ->first(),
            true
        );
        // main table data
        $leaveQuery = RequestLeaveList::join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('static_leave_category', 'static_leave_category.id', '=', 'request_leave_list.leave_category')
            ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
            ->where('request_leave_list.business_id', $businessId)
            ->where('employee_personal_details.active_emp', '1')
            ->whereMonth('request_leave_list.created_at', now()->month)
            ->whereYear('request_leave_list.created_at', now()->year)
            ->orderByDesc('request_leave_list.id')
            ->select('request_leave_list.*', 'static_request_leave_type.leave_day', 'static_leave_category.name as category_name', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.designation_id', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname');
        // check the permission of branch
        if ($checkArray !== null && !empty($checkArray) && $roleIdToCheck != 1) {
            $DATALEAVE = $leaveQuery->whereIn('employee_personal_details.branch_id', $checkArray)->get();
        } else {
            $DATALEAVE = $leaveQuery->get();
        }
        // check parallerl approval
        $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::where('business_id', Session::get('business_id'))
            ->where('approval_type_id', 2)
            ->where('cycle_type', 2)
            ->where(function ($query) use ($roleIdToCheck) {
                $query->whereJsonContains('role_id', (string) $roleIdToCheck)
                    ->orWhereJsonContains('role_id', (string) $roleIdToCheck);
            })->first();
        return view('admin.request.leave', compact('parallerCaseApprovalListRoleIdCheck', 'moduleName', 'permissions', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'DATALEAVE', 'leaveType', 'shiftType', 'Branch'));
    }

    public function EditLeaveDataGet(Request $request)
    {
        $ApprovalManagement = DB::table('approval_management_cycle')
            ->where('business_id', Session::get('business_id'))
            ->where('approval_type_id', 2)
            ->where('cycle_type', 1)
            ->first();

        $data = DB::table('request_leave_list')
            ->join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
            ->join('static_leave_category', 'static_leave_category.id', '=', 'request_leave_list.leave_category')
            ->where('request_leave_list.id', $request->id)
            ->where('employee_personal_details.active_emp', '1')
            ->select('request_leave_list.*', 'static_request_leave_type.leave_day', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'static_leave_category.name as static_category_name', 'employee_personal_details.emp_mobile_number')
            ->first();
        return response()->json(['get' => $data]);
    }

    public function ApproveLeave(Request $request)
    {
        // dd($request->all());
        // cyclic dynamic data storing
        $Days = '';
        $status = 0;
        $PID = $request->id;
        $BID = RulesManagement::PassBy()[1];
        $FindRoleID = RulesManagement::PassBy()[3];
        $EmpID = RulesManagement::PassBy()[2];
        // dd($FindRoleID);
        if ($request->days != null) {
            $Days = $request->days;
        } else {
            $Days = $request->days1;
        }

        $Remark = $request->remark;
        if ($request->approve == '1') {
            $status = 1;
        }
        if ($request->decline == '2') {
            $status = 2;
        }
        $ApprovalTypeID = 2; //leave processType
        // $gatepass = RequestLeaveList::where('id', $request->id)
        // ->where('business_id', $BID)
        // ->update(['from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $Days]);
        $LeaveReqListMode = RequestLeaveList::where('id', $PID)
            ->where('business_id', $BID)
            ->first();
        // notification calling node model by jayant
        $array = [
            'redirect_id' => 2,
            'primary_id' => $PID,
            'punch_date' => $LeaveReqListMode->apply_date, //when apply model
        ];
        $SD = LoginEmployee::where('emp_id', $LeaveReqListMode->emp_id)->first();
        $sdd = ($request->status !== 2) ? 'Approved' : 'Declined';
        if ($SD->notification_key != null) {
            RulesManagement::NotificationSendMode(
                $SD->notification_key,
                'Fix HR Employee',
                "Apply Date : {$LeaveReqListMode->apply_date} \nLeave Status {$sdd} By " . Session::get('user_type') . "\nFrom : {$LeaveReqListMode->from_date} To : {$LeaveReqListMode->to_date}",
                $array
            ); //send notification
        }

        $ApprovalManagement = DB::table('approval_management_cycle')
            ->where('business_id', $BID)
            ->where('approval_type_id', $ApprovalTypeID)
            ->first();
        // dd($ApprovalManagement);
        // dd($request->all());

        // dd($request->all(), $status, $ApprovalManagement, $sd);
        if ($ApprovalManagement->cycle_type == 1) {
            // next forward
            $sd = DB::table('approval_management_cycle')
                ->where('business_id', $BID)
                ->where('approval_type_id', $ApprovalTypeID)
                ->whereJsonContains('role_id', (string) $FindRoleID)
                ->select('role_id')
                ->first();
            $value = DB::table('request_leave_list')
                ->where('business_id', $BID)
                ->where('id', $PID)
                ->first();
            if ($value->forward_by_role_id == $value->final_level_role_id) {
                DB::table('request_leave_list')
                    ->where('business_id', $BID)
                    ->where('id', $PID)
                    ->update([
                        'process_complete' => 1,
                        'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 2)[0], //final status submit
                    ]);
            }
            if ($sd) {
                $roleIds = json_decode($sd->role_id, true); // Decode the JSON array
                $currentIndex = array_search($FindRoleID, $roleIds); // Find the current index of forward_by_role_id

                if ($currentIndex !== false) {
                    $nextIndex = $currentIndex + 1;
                    $prevIndex = $currentIndex - 1;

                    // Check if the next index is within the bounds of the array
                    // if (isset($roleIds[$nextIndex])) {
                    $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1; //sensitive case if last next end then recall 0
                    $prevRoleId = isset($roleIds[$prevIndex]) ? $roleIds[$prevIndex] : 0; //prev 1st start recall 0

                    // dd($request->all(),$FindRoleID,$nextRoleId);
                    // Update the database for the current index
                    DB::table('request_leave_list')
                        ->where('business_id', $BID)
                        ->where('id', $PID)
                        ->update([
                            'forward_by_role_id' => $nextRoleId,
                            'forward_by_status' => $status,
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
                            'remarks' => $Remark != null ? $Remark : '',
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
                DB::table('request_leave_list')
                    ->where('business_id', $BID)
                    ->where('id', $PID)
                    ->update([
                        'process_complete' => 1,
                        'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 2)[0], //final status submit
                    ]);
            }
        }

        // default case
        if ($ApprovalManagement->cycle_type == 2) {
            // dd($request->all());
            DB::table('request_leave_list')
                ->where('business_id', $BID)
                ->where('id', $PID)
                ->update([
                    'process_complete' => 1,
                    'final_status' => $status,
                ]);
            $loadCheck = DB::table('approval_status_list')
                ->where('approval_type_id', $ApprovalTypeID)
                ->where('business_id', $BID)
                ->where('all_request_id', $PID)
                ->first();

            if ($loadCheck) {
                // DB::table('approval_status_list')
                //     ->where('business_id', $BID)
                //     ->where('approval_type_id', $ApprovalTypeID)
                //     ->where('all_request_id', $PID)
                //     ->update([
                //         'business_id' => $BID,
                // 'applied_cycle_type' => 2,
                //         'approval_type_id' => $ApprovalTypeID,
                //         'all_request_id' => $PID,
                //         'role_id' => $FindRoleID,
                //         'emp_id' => $EmpID,
                //         'remarks' => $Remark,
                //         'status' => $status,
                //     ]);
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
                        'remarks' => $Remark,
                        'status' => $status,
                    ]);
            }
            Alert::success('', 'Status is updated');
        }
        return redirect()->back();
    }

    // } else {
    //     // Handle the case when

    //     // the record is not found
    //     echo 'No matching record found for: ' . $existingRecord;
    //     Alert::info('', 'Status is Not Updated');

    // }
    // if (!$leavelRequestChecking) {
    //     $loaded = DB::table('request_leave_list')->whereJsonContains('approved_by_role_id',$FindRoleID)->updateOrInsert(
    //         [
    //             'approved_by_role_id' => json_encode([$FindRoleID]),
    //             'approved_by_emp_id' => json_encode([$EmpID]),
    //             'approved_by_status' => json_encode(['1']),
    //         ],
    //     );
    //     echo 'Record in present ' . $FindRoleID;
    // } else {

    //     echo 'Record in Not Present';
    // }

    // if (isset($ApprovalManagement)) {
    //     if (!$leavelRequestChecking) {
    //         $loaded = DB::table('request_leave_list')->updateOrInsert(
    //             ['id' => $request->id],
    //             [
    //                 'approved_by_role_id' => json_encode([$FindRoleID]),
    //                 'approved_by_emp_id' => json_encode([$EmpID]),
    //                 'approved_by_status' => json_encode(['1']),
    //             ],
    //         );
    //         echo 'Record in present ' . $FindRoleID;
    //     } else {
    //         echo 'Record in Not Present';
    //     }
    // }
    // if (!$existingRecord) {
    //     // Insert the record if it doesn't exist
    //     DB::table('approval_management_cycle')->insert([
    //         'approval_type_id' => 2,
    //         'business_id' => Session::get('business_id'),
    //         'role_id' => json_encode([$roleIdToCheck]),
    //         // Other columns and their values
    //     ]);
    // } else {
    //     // Update the record if it exists
    //     DB::table('approval_management_cycle')
    //         ->where('id', $existingRecord->id)
    //         ->update([
    //             // Update other columns as needed
    //         ]);
    // }

    // dd($request->all(), $FindRoleID, $EmpID, $existingRecord, $ApprovalManagement);

    // // $allRoleList=$ApprovalManagement->role_id;//$request->has('id') && $request->has('leave_type') && $request->has('from_date') && $request->has('to_date') && $request->has('days') && $request->has('submit') &&
    // if ($request->has('approve')) {
    //     // $gatepass = RequestLeaveList::where('id', $request->id)
    //     // ->where('business_id', Session::get('business_id'))
    //     // ->update(['leave_type' => $request->time_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $request->days, 'approved_by_role_id' => json_encode([$FindRoleID]), 'approved_by_emp_id' => json_encode([$EmpID]), 'approved_by_status' => json_encode(['1']), 'status' => $request->approve]);
    //     // Check the current values of role_id
    //     Alert::success('Your Leave Request has been Approve Successfully');

    //     return back();
    // } elseif ($request->has('remark')) {
    //     $gatepass = RequestLeaveList::where('id', $request->id)
    //         ->where('business_id', Session::get('business_id'))
    //         ->update(['leave_type' => $request->time_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $request->days, 'remark' => $request->remark, 'status' => $request->submit]);
    //     Alert::success('Your Gatepass Request has been Decline Successfully');
    //     // , 'Updated  Created'
    //     return back();
    // } else {
    //     Alert::error('Not Updated', 'Your Leave Request Detail Updating is Fail');
    //     return back();
    // }
    // $toDate = Carbon::parse($request->to_date);
    // $fromDate = Carbon::parse($request->from_date);

    // $loaded = $toDate->diffInDays($fromDate);
    // $branch = RequestLeaveList::where('id', $request->editLeaveId)
    //     ->where('business_id', Session::get('business_id'))
    //     ->update(['leave_type' => $request->leave_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $loaded, 'status' => $request->status]);
    // if ($branch) {
    //     Alert::success('Data Updated', 'Leave Request Approve Successfully');
    // }
    // return back();

    public function ApproveMispunch(Request $request)
    {
        // dd($request->all());

        $checkupdateAttendancetest = AttendanceList::where('emp_id', $request->emp_id)
            ->where('punch_date', $request->date)
            ->first();
        // dd($checkupdateAttendancetest);
        // if (!$checkupdateAttendancetest) {
        //     Alert::error('', 'Your Mispunch Request Data Attendance List Not Found.');
        //     return redirect('admin/requests/mispunch');
        // }
        // cyclic dynamic data storing
        $requestEmpId = $request->emp_id;
        $requestMisspunchDate = $request->date;
        $requestPunchInTime = $request->in_time;
        $requestPunchOutTime = $request->out_time;
        $attenApprovalTypeId = 1;
        $hiddenTimeType = $request->hidden_time_type;
        $Days = '';
        $status = 0;
        $PID = $request->id;
        $BID = RulesManagement::PassBy()[1];
        $FindRoleID = RulesManagement::PassBy()[3];
        $EmpID = RulesManagement::PassBy()[2];
        $BusinessId = Session::get('business_id');
        if ($request->days != null) {
            $Days = $request->days;
        } else {
            $Days = $request->days1;
        }
        $Remark = $request->remark;
        if ($request->approve == '1') {
            $status = 1;
        }
        if ($request->decline == '2') {
            $status = 2;
        }
        $ApprovalTypeID = 3; //Mispunch processType
        $attendance = AttendanceList::where('emp_id', $request->emp_id)
            ->where('punch_date', $request->date)
            ->first();
        $mispunch = RequestMispunchList::where('id', $request->id)
            ->where('business_id', $BusinessId)
            ->update(['emp_miss_in_time' => $request->in_time, 'emp_miss_out_time' => $request->out_time]);

        $MisReqListMode = RequestMispunchList::where('id', $PID)
            ->where('business_id', $BID)
            ->first();
        // notification calling node model by jayant
        $array = [
            'redirect_id' => 3,
            'primary_id' => $PID,
            'punch_date' => $MisReqListMode->emp_miss_date, //when apply model
        ];
        $SD = LoginEmployee::where('emp_id', $MisReqListMode->emp_id)->first();
        $sdd = ($request->status !== 2) ? 'Approved' : 'Declined';
        if ($SD->notification_key != null) {
            RulesManagement::NotificationSendMode(
                $SD->notification_key,
                'Fix HR Employee',
                "Apply Date : {$MisReqListMode->emp_miss_date} \nMisPunch Status {$sdd} By " . Session::get('user_type') . "\nIn Time : {$MisReqListMode->emp_miss_in_time} Out Time : {$MisReqListMode->emp_miss_out_time}",
                $array
            ); //send notification
        }

        $ApprovalManagement = DB::table('approval_management_cycle')
            ->where('business_id', $BID)
            ->where('approval_type_id', $ApprovalTypeID)
            ->first();
        if ($ApprovalManagement->cycle_type == 1) {
            // next forward
            $sd = DB::table('approval_management_cycle')
                ->where('business_id', $BID)
                ->where('approval_type_id', $ApprovalTypeID)
                ->whereJsonContains('role_id', (string) $FindRoleID)
                ->select('role_id')
                ->first();
            $value = RequestMispunchList::where('business_id', $BID)
                ->where('id', $PID)
                ->first();
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
                    DB::table('request_mispunch_list')
                        ->where('business_id', $BID)
                        ->where('id', $PID)
                        ->update([
                            'forward_by_role_id' => $nextRoleId,
                            'forward_by_status' => $status,
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
                            'remarks' => $Remark != null ? $Remark : '',
                            'clicked' => 1,
                            'status' => $status,
                            'prev_role_id' => $prevRoleId,
                            'current_role_id' => $FindRoleID,
                            'next_role_id' => $nextRoleId,
                        ]);
                    $attenApprovalTypeId = 1;

                    $checkupdateAttendance = AttendanceList::where('emp_id', $request->emp_id)
                        ->where('punch_date', $request->date)
                        ->first();
                    DB::table('approval_status_list')
                        ->where('approval_type_id', $attenApprovalTypeId)
                        ->where('role_id', $FindRoleID)
                        ->where('business_id', $BID)
                        ->where('all_request_id', $checkupdateAttendance->id)
                        ->insert([
                            'applied_cycle_type' => 1,
                            'business_id' => $BID,
                            'approval_type_id' => $attenApprovalTypeId,
                            'all_request_id' => $checkupdateAttendance->id,
                            'role_id' => $FindRoleID,
                            'emp_id' => $EmpID,
                            'remarks' => $Remark != null ? $Remark : '',
                            'clicked' => 1,
                            'status' => $status,
                            'prev_role_id' => $prevRoleId,
                            'current_role_id' => $FindRoleID,
                            'next_role_id' => $nextRoleId,
                        ]);
                    Alert::success('', 'Status is Updated');
                }
            }
            $ruleMangementSequentialApprovalDeclinedCheck = RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 3)[0];
            if ($value->forward_by_role_id == $value->final_level_role_id) {
                DB::table('request_mispunch_list')
                    ->where('business_id', $BID)
                    ->where('id', $PID)
                    ->update([
                        'process_complete' => 1,
                        'final_status' => $ruleMangementSequentialApprovalDeclinedCheck, //final status submit
                    ]);

                $FinalMispunchApprovalDeclineCheck = DB::table('request_mispunch_list')
                    ->where('business_id', $BID)
                    ->where('id', $PID)
                    ->first();
                $punchInTimes = strtotime($request->in_time);
                $punchOutTimes = strtotime($request->out_time);
                $totalWorkingSeconds = $punchOutTimes - $punchInTimes;

                $totalWorkingTimestamp = strtotime('midnight') + $totalWorkingSeconds;
                $totalWorking = date('H:i:s', $totalWorkingTimestamp);
                if ($FinalMispunchApprovalDeclineCheck->process_complete == 1) {
                    $checkupdateAttendance = AttendanceList::where('emp_id', $request->emp_id)
                        ->where('punch_date', $request->date)
                        ->first();
                    if ($checkupdateAttendance) {
                        $AttenPrevStatus = $checkupdateAttendance->today_status;
                        $empMonthlyCount = DB::table('attendance_monthly_count')
                            ->where([
                                'emp_id' => $request->emp_id,
                                'month' => date('m', strtotime($request->date)),
                                'year' => date('Y', strtotime($request->date)),
                            ])
                            ->first();
                        $empMonthlyCountUpdate = DB::table('attendance_monthly_count')
                            ->where([
                                'emp_id' => $request->emp_id,
                                'month' => date('m', strtotime($request->date)),
                                'year' => date('Y', strtotime($request->date)),
                            ])
                            ->update([
                                'present' => $AttenPrevStatus == 1 ? $empMonthlyCount->present - 1 : $empMonthlyCount->present ?? 0,
                                'absent' => $AttenPrevStatus == 2 ? $empMonthlyCount->absent - 1 : $empMonthlyCount->absent ?? 0,
                                'late' => $AttenPrevStatus == 3 ? $empMonthlyCount->late - 1 : $empMonthlyCount->late ?? 0,
                                'early_exit' => $AttenPrevStatus == 12 ? $empMonthlyCount->early_exit - 1 : $empMonthlyCount->early_exit ?? 0,
                                'mispunch' => $AttenPrevStatus == 4 ? ($empMonthlyCount->mispunch <= 0 ? 0 : $empMonthlyCount->mispunch - 1) : $empMonthlyCount->mispunch ?? 0,
                                'half_day' => $AttenPrevStatus == 8 ? $empMonthlyCount->half_day - 1 : $empMonthlyCount->half_day ?? 0,
                                'overtime' => $AttenPrevStatus == 9 ? $empMonthlyCount->overtime - 1 : $empMonthlyCount->overtime ?? 0,
                                'leave' => in_array($AttenPrevStatus, [10, 11]) ? $empMonthlyCount->leave - 1 : $empMonthlyCount->leave ?? 0,
                            ]);
                        if ($ruleMangementSequentialApprovalDeclinedCheck == 1) {
                            $updaetattendance = AttendanceList::where('emp_id', $request->emp_id)
                                ->where('punch_date', $request->date)
                                ->update(['punch_in_time' => $request->in_time, 'punch_out_time' => $request->out_time, 'emp_today_current_status' => '2', 'total_working_hour' => $totalWorking, 'process_complete' => 1, 'final_status' => $ruleMangementSequentialApprovalDeclinedCheck]);
                        } elseif ($ruleMangementSequentialApprovalDeclinedCheck == 2) {
                            $updaetattendance = AttendanceList::where('emp_id', $request->emp_id)
                                ->where('punch_date', $request->date)
                                ->update(['today_status' => '2', 'punch_in_time' => '00:00:00', 'punch_out_time' => '00:00:00', 'emp_today_current_status' => '2', 'total_working_hour' => '00:00:00', 'process_complete' => 1, 'final_status' => $ruleMangementSequentialApprovalDeclinedCheck]);
                        }
                        $countUpdate = Central_unit::getEmpAttSummaryApi(['punch_date' => $request->date, 'emp_id' => $request->emp_id, 'business_id' => Session::get('business_id')]);

                        $attenApprovalTypeId = 1;
                        AttendanceList::where('id', $checkupdateAttendance->id)->update(['today_status' => $countUpdate[0], 'late_by' => $countUpdate[12], 'early_exit' => $countUpdate[13], 'overtime' => $countUpdate[8]]);
                    } elseif ((!$checkupdateAttendance) && ($hiddenTimeType == 2)) {
                        if ($status == 1) {
                            $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $BusinessId)
                                ->where('approval_type_id', 1)
                                ->first();
                            if ($approvalManagementCycle != null) {
                                $roleIds = json_decode($approvalManagementCycle->role_id, true); // Decode JSON string to PHP array

                                // Get the first index value of role_id
                                $firstRoleId = $roleIds[0] ?? null; // This will get the first value or null if it doesn't exist

                                // Get the last index value of role_id
                                $lastRoleId = end($roleIds); // Get the last value of the array

                            }
                            $TodayStatus = Central_unit::getEmpAttSummaryApi(['emp_id' => $requestEmpId, 'punch_date' => $requestMisspunchDate, 'business_id' => $BusinessId]);
                            $OverAllTodayStatus = $TodayStatus[0]; //only running PunchOut time By Aman Attendance
                            $Overtime = $TodayStatus[8];
                            $ShiftInterval = $TodayStatus[9];
                            $EarlyExit = $TodayStatus[13];
                            $LateBy = $TodayStatus[12];
                            $information = EmployeePersonalDetail::where('business_id', $BusinessId)
                                ->where('emp_id', $requestEmpId)
                                ->first();
                            $setupActivateEmpID = $information->master_endgame_id;
                            $setupActivateNameByAssignEmpID = DB::table('policy_master_endgame_method')
                                ->where('business_id', $BusinessId)
                                ->where('id', $setupActivateEmpID)
                                ->where('method_switch', 1)
                                ->first();
                            $checkingModes = PolicyAttendanceMode::where('business_id', $BusinessId)
                                ->where(function ($query) {
                                    $query->where('office_auto', 1)->orWhere('office_manual', 1); //->orWhere('office_face_id', 1)->orWhere('office_qr', 1)->orWhere('office_selfie', 1);
                                })
                                ->select('office_auto', 'office_manual')
                                ->first();
                            if (isset($checkingModes)) {
                                $currentMethodAuto = $checkingModes->office_auto;
                                $currentMethodManual = $checkingModes->office_manual;
                            }
                            $policyGetShiftPerDay = DB::table('employee_personal_details')
                                ->join('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
                                ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
                                ->where('employee_personal_details.emp_id', $requestEmpId) //check emp_id
                                ->where('employee_personal_details.business_id', $BusinessId) //check business_id
                                ->select('static_attendance_shift_type.id as emp_shift_type')
                                ->first(); //get empolyee shift type assigned
                            $ShiftTypeID = $policyGetShiftPerDay->emp_shift_type;
                            $RotationalShift = $information->emp_rotational_shift_type_item;
                            $DATA = EmployeePersonalDetail::leftJoin('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
                                ->leftJoin('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
                                ->leftJoin('policy_attendance_shift_type_items', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
                                ->leftJoin('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
                                ->whereRaw('JSON_CONTAINS(policy_master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))') //End-Games method array index values checking
                                ->where('policy_master_endgame_method.method_switch', 1) //end game method on also
                                ->where('employee_personal_details.active_emp', 1)
                                ->where('employee_personal_details.emp_id', $requestEmpId) //check emp_id
                                ->where('employee_personal_details.business_id', $BusinessId) //check business_id
                                ->Where(function ($query) use ($RotationalShift, $ShiftTypeID) {
                                    // only rotational case special
                                    if ($ShiftTypeID == 2 && $RotationalShift != 0) {
                                        $query->where('policy_attendance_shift_type_items.id', $RotationalShift);
                                    }
                                })
                                ->select('policy_master_endgame_method.id as method_id', 'policy_master_endgame_method.method_name as method_name', 'policy_attendance_shift_type_items.id as shift_item_id', 'policy_attendance_shift_type_items.shift_name as shift_template_name', 'static_attendance_shift_type.id  as shift_type_id', 'static_attendance_shift_type.name as shift_type_name', 'policy_attendance_shift_type_items.shift_start as shift_start_time', 'policy_attendance_shift_type_items.shift_end as shift_end_time', 'policy_attendance_shift_type_items.shift_hr as shift_hour', 'policy_attendance_shift_type_items.shift_min as shift_min', 'policy_attendance_shift_type_items.work_hr as working_hour', 'policy_attendance_shift_type_items.work_min as working_min', 'policy_attendance_shift_type_items.break_min as break_min', 'policy_attendance_shift_type_items.is_paid as is_paid')
                                ->first();
                            $ShiftItemID = $DATA->shift_item_id;
                            $appliedShift_template_name = $DATA->shift_template_name;
                            $appliedShift_type_name = $DATA->shift_type_name;
                            $appliedShift_comp_start_time = $DATA->shift_start_time;
                            $appliedShift_comp_end_time = $DATA->shift_end_time;
                            $appliedShift_break_time = $DATA->break_min;
                            $punchIn_shift_name = $DATA->shift_type_name;
                            $punchOut_shift_name = $DATA->shift_type_name;
                            $AttendanceCompOff = RulesManagement::AttendaceCompOffSet($requestEmpId, $BusinessId, $requestMisspunchDate);
                            $insertAttendaneData = AttendanceList::insert([
                                'today_status' => '4',
                                'setup_method_id' => $setupActivateEmpID,
                                'setup_method_name' => $setupActivateNameByAssignEmpID->method_name,
                                'emp_id' => $requestEmpId,
                                'business_id' => $BusinessId,
                                'branch_id' => $information->branch_id,
                                'working_from_method' => $information->emp_attendance_method,
                                'method_auto' => $currentMethodAuto, //current case on checking and value set
                                'method_manual' => $currentMethodManual,
                                'final_status' => '0',
                                'active_biometric_mode' => 0,
                                'emp_today_current_status' => 2,
                                'marked_in_mode' => '0',
                                'active_qr_mode' => '0',
                                'active_selfie_mode' => '0',
                                'active_biometric_mode' => '0',
                                'attendance_shift' => $ShiftItemID,
                                'punch_date' => $requestMisspunchDate, //anytime current upload DAY
                                'punch_in_time' => $requestPunchInTime,
                                'marked_out_mode' => '0',
                                'punch_in_latitude' => '0',
                                'punch_in_longitude' => '0',
                                'punch_in_address' => '0',
                                'applied_shift_template_name' => $appliedShift_template_name,
                                'applied_shift_type_name' => $appliedShift_type_name,
                                'applied_shift_comp_start_time' => $appliedShift_comp_start_time,
                                'applied_shift_comp_end_time' => $appliedShift_comp_end_time,
                                'brack_time' => $appliedShift_break_time,
                                'punch_in_shift_name' => $punchIn_shift_name, //punchIn shift Name
                                'forward_by_role_id' => $firstRoleId ?? 0,
                                'forward_by_status' => 0,
                                'final_level_role_id' => $lastRoleId ?? 0,
                                'final_status' => 1,
                                'process_complete' => 1,
                                'leave_type_category' => $AttendanceCompOff[0],
                                'comp_off_active' => $AttendanceCompOff[1],
                                'punch_out_selfie' => '',
                                'punch_out_time' => $requestPunchOutTime,
                                'punch_out_address' => '',
                                'punch_out_latitude' => '',
                                'punch_out_longitude' => '',
                                'total_working_hour' => $totalWorking,
                                'punch_out_shift_name' => $punchOut_shift_name,
                            ]);
                            $TodayStatus = Central_unit::getEmpAttSummaryApi(['emp_id' => $requestEmpId, 'punch_date' => $requestMisspunchDate, 'business_id' => $BusinessId]);
                            $OverAllTodayStatus = $TodayStatus[0]; //only running PunchOut time By Aman Attendance
                            $Overtime = $TodayStatus[8];
                            $ShiftInterval = $TodayStatus[9];
                            $EarlyExit = $TodayStatus[13];
                            $LateBy = $TodayStatus[12];
                            $updateTodaysStatus = [
                                'today_status' => $OverAllTodayStatus,
                                'overtime' => $Overtime,
                                'shift_interval' => $ShiftInterval,
                                'early_exit' => $EarlyExit,
                                'late_by' => $LateBy,
                            ];

                            $datameta = AttendanceList::where('punch_date', $requestMisspunchDate)
                                ->where('emp_id', $requestEmpId)
                                ->update($updateTodaysStatus);
                            $getemp = AttendanceList::where('punch_date', $requestMisspunchDate)->where('emp_id', $requestEmpId)->first();
                        } elseif ($status == 2) {
                        }
                    }
                }
            }
        }

        // default case
        if ($ApprovalManagement->cycle_type == 2) {
            // update kare ak requeestmispunchlist table ko
            RequestMispunchList::where('business_id', $BID)
                ->where('id', $PID)
                ->update(['process_complete' => 1, 'final_status' => $status]);
            // approvelstatuslist me check karta hai
            $loadCheck = ApprovalStatusList::where('approval_type_id', $ApprovalTypeID)
                ->where('business_id', $BID)
                ->where('all_request_id', $PID)
                ->first();

            if ($loadCheck) {
            } else {
                //Parallel in this case insert the data
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
                        'remarks' => $Remark,
                        'status' => $status,
                    ]);
                $FinalMispunchApprovalDeclineCheck = RequestMispunchList::where('business_id', $BID)
                    ->where('id', $PID)
                    ->first();
                $punchInTimes = strtotime($request->in_time);
                $punchOutTimes = strtotime($request->out_time);
                $totalWorkingSeconds = $punchOutTimes - $punchInTimes;
                $totalWorkingTimestamp = strtotime('midnight') + $totalWorkingSeconds;
                $totalWorking = date('H:i:s', $totalWorkingTimestamp);
                if ($FinalMispunchApprovalDeclineCheck != null) {
                    if ($FinalMispunchApprovalDeclineCheck) {
                        $checkupdateAttendance = AttendanceList::where('emp_id', $requestEmpId)
                            ->where('punch_date', $requestMisspunchDate)
                            ->first();
                        if ($checkupdateAttendance) {
                            $PreviousAttenStatus = $checkupdateAttendance->today_status;
                            $empMonthlyCount = DB::table('attendance_monthly_count')
                                ->where(['emp_id' => $request->emp_id, 'month' => date('m', strtotime($request->date)), 'year' => date('Y', strtotime($request->date))])
                                ->first();
                            $empMonthlyCountUpdate = DB::table('attendance_monthly_count')
                                ->where(['emp_id' => $request->emp_id, 'month' => date('m', strtotime($request->date)), 'year' => date('Y', strtotime($request->date))])
                                ->update([
                                    'present' => $PreviousAttenStatus == 1 ? $empMonthlyCount->present - 1 : $empMonthlyCount->present ?? 0,
                                    'absent' => $PreviousAttenStatus == 2 ? $empMonthlyCount->absent - 1 : $empMonthlyCount->absent ?? 0,
                                    'late' => $PreviousAttenStatus == 3 ? $empMonthlyCount->late - 1 : $empMonthlyCount->late ?? 0,
                                    'early_exit' => $PreviousAttenStatus == 12 ? $empMonthlyCount->early_exit - 1 : $empMonthlyCount->early_exit ?? 0,
                                    'mispunch' => $PreviousAttenStatus == 4 ? ($empMonthlyCount->mispunch <= 0 ? 0 : $empMonthlyCount->mispunch - 1) : $empMonthlyCount->mispunch ?? 0,
                                    'half_day' => $PreviousAttenStatus == 8 ? $empMonthlyCount->half_day - 1 : $empMonthlyCount->half_day ?? 0,
                                    'overtime' => $PreviousAttenStatus == 9 ? $empMonthlyCount->overtime - 1 : $empMonthlyCount->overtime ?? 0,
                                    'leave' => in_array($PreviousAttenStatus, [10, 11]) ? $empMonthlyCount->leave - 1 : $empMonthlyCount->leave ?? 0,
                                ]);
                            // approved
                            if ($status == 1) {
                                $updaetattendance = AttendanceList::where('emp_id', $request->emp_id)
                                    ->where('punch_date', $request->date)
                                    ->update(['punch_in_time' => $request->in_time, 'punch_out_time' => $request->out_time, 'emp_today_current_status' => '2', 'total_working_hour' => $totalWorking, 'process_complete' => 1, 'final_status' => $status]);
                            } elseif ($status == 2) {
                                // declined
                                $updaetattendance = AttendanceList::where('emp_id', $request->emp_id)
                                    ->where('punch_date', $request->date)
                                    ->update(['today_status' => '2', 'punch_in_time' => '', 'punch_out_time' => '', 'emp_today_current_status' => '2', 'total_working_hour' => '00:00:00', 'process_complete' => 1, 'final_status' => $status]);
                            }
                            $countUpdate = Central_unit::getEmpAttSummaryApi(['punch_date' => $request->date, 'emp_id' => $request->emp_id, 'business_id' => Session::get('business_id')]);
                            $attenApprovalTypeId = 1;
                            AttendanceList::where('id', $checkupdateAttendance->id)->update(['today_status' => $countUpdate[0], 'late_by' => $countUpdate[12], 'early_exit' => $countUpdate[13], 'overtime' => $countUpdate[8]]);
                            DB::table('approval_status_list')
                                ->where('business_id', $BID)
                                ->where('approval_type_id', $attenApprovalTypeId)
                                ->where('all_request_id', $checkupdateAttendance->id)
                                ->insert([
                                    'applied_cycle_type' => 2,
                                    'business_id' => $BID,
                                    'approval_type_id' => $attenApprovalTypeId,
                                    'all_request_id' => $checkupdateAttendance->id,
                                    'role_id' => $FindRoleID,
                                    'emp_id' => $EmpID,
                                    'clicked' => 1,
                                    'remarks' => $Remark,
                                    'status' => $status,
                                ]);
                        } elseif ((!$checkupdateAttendance) && ($hiddenTimeType == 2)) {
                            if ($status == 1) {
                                $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $BusinessId)
                                    ->where('approval_type_id', 1)
                                    ->first();
                                if ($approvalManagementCycle != null) {
                                    $roleIds = json_decode($approvalManagementCycle->role_id, true); // Decode JSON string to PHP array

                                    // Get the first index value of role_id
                                    $firstRoleId = $roleIds[0] ?? null; // This will get the first value or null if it doesn't exist

                                    // Get the last index value of role_id
                                    $lastRoleId = end($roleIds); // Get the last value of the array

                                }
                                $TodayStatus = Central_unit::getEmpAttSummaryApi(['emp_id' => $requestEmpId, 'punch_date' => $requestMisspunchDate, 'business_id' => $BusinessId]);
                                $OverAllTodayStatus = $TodayStatus[0]; //only running PunchOut time By Aman Attendance
                                $Overtime = $TodayStatus[8];
                                $ShiftInterval = $TodayStatus[9];
                                $EarlyExit = $TodayStatus[13];
                                $LateBy = $TodayStatus[12];
                                $information = EmployeePersonalDetail::where('business_id', $BusinessId)
                                    ->where('emp_id', $requestEmpId)
                                    ->first();
                                $setupActivateEmpID = $information->master_endgame_id;
                                $setupActivateNameByAssignEmpID = DB::table('policy_master_endgame_method')
                                    ->where('business_id', $BusinessId)
                                    ->where('id', $setupActivateEmpID)
                                    ->where('method_switch', 1)
                                    ->first();
                                $checkingModes = PolicyAttendanceMode::where('business_id', $BusinessId)
                                    ->where(function ($query) {
                                        $query->where('office_auto', 1)->orWhere('office_manual', 1); //->orWhere('office_face_id', 1)->orWhere('office_qr', 1)->orWhere('office_selfie', 1);
                                    })
                                    ->select('office_auto', 'office_manual')
                                    ->first();
                                if (isset($checkingModes)) {
                                    $currentMethodAuto = $checkingModes->office_auto;
                                    $currentMethodManual = $checkingModes->office_manual;
                                }
                                $policyGetShiftPerDay = DB::table('employee_personal_details')
                                    ->join('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
                                    ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
                                    ->where('employee_personal_details.emp_id', $requestEmpId) //check emp_id
                                    ->where('employee_personal_details.business_id', $BusinessId) //check business_id
                                    ->where('employee_personal_details.active_emp', '1')
                                    ->select('static_attendance_shift_type.id as emp_shift_type')
                                    ->first(); //get empolyee shift type assigned
                                $ShiftTypeID = $policyGetShiftPerDay->emp_shift_type;
                                $RotationalShift = $information->emp_rotational_shift_type_item;
                                $DATA = EmployeePersonalDetail::leftJoin('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
                                    ->leftJoin('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
                                    ->leftJoin('policy_attendance_shift_type_items', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
                                    ->leftJoin('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
                                    ->whereRaw('JSON_CONTAINS(policy_master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))') //End-Games method array index values checking
                                    ->where('policy_master_endgame_method.method_switch', 1) //end game method on also
                                    ->where('employee_personal_details.active_emp', 1)
                                    ->where('employee_personal_details.emp_id', $requestEmpId) //check emp_id
                                    ->where('employee_personal_details.business_id', $BusinessId) //check business_id
                                    ->Where(function ($query) use ($RotationalShift, $ShiftTypeID) {
                                        // only rotational case special
                                        if ($ShiftTypeID == 2 && $RotationalShift != 0) {
                                            $query->where('policy_attendance_shift_type_items.id', $RotationalShift);
                                        }
                                    })
                                    ->select('policy_master_endgame_method.id as method_id', 'policy_master_endgame_method.method_name as method_name', 'policy_attendance_shift_type_items.id as shift_item_id', 'policy_attendance_shift_type_items.shift_name as shift_template_name', 'static_attendance_shift_type.id  as shift_type_id', 'static_attendance_shift_type.name as shift_type_name', 'policy_attendance_shift_type_items.shift_start as shift_start_time', 'policy_attendance_shift_type_items.shift_end as shift_end_time', 'policy_attendance_shift_type_items.shift_hr as shift_hour', 'policy_attendance_shift_type_items.shift_min as shift_min', 'policy_attendance_shift_type_items.work_hr as working_hour', 'policy_attendance_shift_type_items.work_min as working_min', 'policy_attendance_shift_type_items.break_min as break_min', 'policy_attendance_shift_type_items.is_paid as is_paid')
                                    ->first();
                                $ShiftItemID = $DATA->shift_item_id;
                                $appliedShift_template_name = $DATA->shift_template_name;
                                $appliedShift_type_name = $DATA->shift_type_name;
                                $appliedShift_comp_start_time = $DATA->shift_start_time;
                                $appliedShift_comp_end_time = $DATA->shift_end_time;
                                $appliedShift_break_time = $DATA->break_min;
                                $punchIn_shift_name = $DATA->shift_type_name;
                                $punchOut_shift_name = $DATA->shift_type_name;
                                $AttendanceCompOff = RulesManagement::AttendaceCompOffSet($requestEmpId, $BusinessId, $requestMisspunchDate);
                                $insertAttendaneData = AttendanceList::insert([
                                    'today_status' => '4',
                                    'setup_method_id' => $setupActivateEmpID,
                                    'setup_method_name' => $setupActivateNameByAssignEmpID->method_name,
                                    'emp_id' => $requestEmpId,
                                    'business_id' => $BusinessId,
                                    'branch_id' => $information->branch_id,
                                    'working_from_method' => $information->emp_attendance_method,
                                    'method_auto' => $currentMethodAuto, //current case on checking and value set
                                    'method_manual' => $currentMethodManual,
                                    'final_status' => '0',
                                    'active_biometric_mode' => 0,
                                    'emp_today_current_status' => 2,
                                    'marked_in_mode' => '0',
                                    'active_qr_mode' => '0',
                                    'active_selfie_mode' => '0',
                                    'active_biometric_mode' => '0',
                                    'attendance_shift' => $ShiftItemID,
                                    'punch_date' => $requestMisspunchDate, //anytime current upload DAY
                                    'punch_in_time' => $requestPunchInTime,
                                    'marked_out_mode' => '0',
                                    'punch_in_latitude' => '0',
                                    'punch_in_longitude' => '0',
                                    'punch_in_address' => '0',
                                    'applied_shift_template_name' => $appliedShift_template_name,
                                    'applied_shift_type_name' => $appliedShift_type_name,
                                    'applied_shift_comp_start_time' => $appliedShift_comp_start_time,
                                    'applied_shift_comp_end_time' => $appliedShift_comp_end_time,
                                    'brack_time' => $appliedShift_break_time,
                                    'punch_in_shift_name' => $punchIn_shift_name, //punchIn shift Name
                                    'forward_by_role_id' => $firstRoleId ?? 0,
                                    'forward_by_status' => 0,
                                    'final_level_role_id' => $lastRoleId ?? 0,
                                    'final_status' => 1,
                                    'process_complete' => 1,
                                    'leave_type_category' => $AttendanceCompOff[0],
                                    'comp_off_active' => $AttendanceCompOff[1],
                                    'punch_out_selfie' => '',
                                    'punch_out_time' => $requestPunchOutTime,
                                    'punch_out_address' => '',
                                    'punch_out_latitude' => '',
                                    'punch_out_longitude' => '',
                                    'total_working_hour' => $totalWorking,
                                    'punch_out_shift_name' => $punchOut_shift_name,
                                ]);
                                $TodayStatus = Central_unit::getEmpAttSummaryApi(['emp_id' => $requestEmpId, 'punch_date' => $requestMisspunchDate, 'business_id' => $BusinessId]);
                                $OverAllTodayStatus = $TodayStatus[0]; //only running PunchOut time By Aman Attendance
                                $Overtime = $TodayStatus[8];
                                $ShiftInterval = $TodayStatus[9];
                                $EarlyExit = $TodayStatus[13];
                                $LateBy = $TodayStatus[12];
                                $updateTodaysStatus = [
                                    'today_status' => $OverAllTodayStatus,
                                    'overtime' => $Overtime,
                                    'shift_interval' => $ShiftInterval,
                                    'early_exit' => $EarlyExit,
                                    'late_by' => $LateBy,
                                ];

                                $datameta = AttendanceList::where('punch_date', $requestMisspunchDate)
                                    ->where('emp_id', $requestEmpId)
                                    ->update($updateTodaysStatus);
                                $getemp = AttendanceList::where('punch_date', $requestMisspunchDate)->where('emp_id', $requestEmpId)->first();
                                $attendanceappvovealsubmit = DB::table('approval_status_list')
                                    ->where('business_id', $BID)
                                    ->where('approval_type_id', $attenApprovalTypeId)
                                    ->where('all_request_id', $getemp->id)
                                    ->insert([
                                        'applied_cycle_type' => 2,
                                        'business_id' => $BID,
                                        'approval_type_id' => $attenApprovalTypeId,
                                        'all_request_id' => $getemp->id,
                                        'role_id' => $FindRoleID,
                                        'emp_id' => $EmpID,
                                        'clicked' => 1,
                                        'remarks' => $Remark,
                                        'status' => $status,
                                    ]);
                            } elseif ($status == 2) {
                            }
                        } else {
                            Alert::error('', 'Status has been not updated');
                            return redirect()->back();
                        }
                    }
                }
            }
            Alert::success('', 'Status has been updated successfully');
        }
        return redirect()->back();
    }

    public function DestroyLeave(Request $request)
    {
        $id = $request->leave_delete_name;
        $cheekApprovalLlst = ApprovalStatusList::where('business_id', Session::get('business_id'))
            ->where('approval_type_id', '2')
            ->where('all_request_id', $id)
            ->first();
        if ($cheekApprovalLlst) {
            Alert::error('', 'Leave has been    already been processed; deletion is not allowed.');
        } else {
            $data = RequestLeaveList::find($id);
            if ($data->delete()) {
                Alert::success('', 'Leave request has been deleted successfully');
            } else {
                Alert::error('', 'Leave request  has not been deleted');
            }
        }
        return redirect('/admin/requests/leaves');
    }

    public function DestroyMispunch($id)
    {
        // dd($id);
        $data = MispunchList::find($id);
        $data->delete();
        if ($data) {
            Alert::success('', 'Your Gatepass request has been deleted successfully');
        }
        // Session::flash('success', 'Succefully Deleted !');
        return back();
    }


        // public function mispunch()
        // {
        //     $checkpermission = PolicySettingRoleAssignPermission::
        //         where('business_id', Session::get('business_id'))
        //         ->where('emp_id', Session::get('login_emp_id'))
        //         ->select('permission_branch_id')
        //         ->pluck('permission_branch_id')
        //         ->first();

        //     // Decode the JSON string into an array
        //     $checkArray = json_decode($checkpermission, true);
        //     if ($checkArray !== null && !empty($checkArray) && (Session::get('login_role')) !=1 ) {
        //         $DATA = RequestMispunchList::
        //             join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
        //             ->join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')
        //             ->where('request_mispunch_list.business_id', Session::get('business_id'))
        //             ->where('employee_personal_details.active_emp', '1')
        //             ->whereIn('employee_personal_details.branch_id', $checkArray) // Use decoded array
        //             ->whereMonth('request_mispunch_list.created_at', '=', Carbon::now()->month)
        //             ->whereYear('request_mispunch_list.created_at', '=', Carbon::now()->year)
        //             ->select('request_mispunch_list.*', 'static_mispunch_timetype.time_type', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.designation_id')
        //             ->orderBy('request_mispunch_list.id', 'desc')
        //             ->get();
        //     } else{
        //         $DATA = RequestMispunchList::
        //             join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
        //             ->join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')
        //             ->whereMonth('request_mispunch_list.created_at', '=', Carbon::now()->month)
        //             ->whereYear('request_mispunch_list.created_at', '=', Carbon::now()->year)
        //             ->where('request_mispunch_list.business_id', Session::get('business_id'))
        //             ->where('employee_personal_details.active_emp', '1')
        //             ->select('request_mispunch_list.*', 'static_mispunch_timetype.time_type', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.designation_id')
        //             ->orderBy('request_mispunch_list.id', 'desc')
        //             ->get();
        //     }

        //     $StaticMisspunchTimeType = DB::table('static_mispunch_timetype')->get();
        //     $accessPermission = Central_unit::AccessPermission();
        //     $moduleName = $accessPermission[0];
        //     $permissions = $accessPermission[1];
        //     // processCycle Seq. Parallel
        //     $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(3)[1];
        //     // dd($checkApprovalCycleType);
        //     $loginRoleID = RulesManagement::PassBy()[3];
        //     $loginRoleBID = RulesManagement::PassBy()[1];
        //     // dd($loginRoleBID);
        //     $loginEmpID = RulesManagement::PassBy()[2];
        //     $checkFistRoleId = DB::table('approval_management_cycle')
        //         ->where('approval_type_id', 3)
        //         ->where('business_id', Session::get('business_id'))
        //         ->select('role_id')
        //         ->first();
        //     // Assuming $checkFistRoleId is the result you showed
        //     $roleIdData = json_decode($checkFistRoleId->role_id ?? 0);

        //     if (!empty($roleIdData) && is_array($roleIdData)) {
        //         $checkmfirstRoleId = $roleIdData[0];
        //         // Now $firstRoleId contains the first element of the array
        //     } else {
        //         $checkmfirstRoleId = 0;
        //         // Handle the case where $roleIdData is not a valid array
        //         // It might be empty or not a valid JSON string
        //     }
        //     $Branch = Central_unit::BranchList();

        //     $roleIdToCheck = Session::get('login_role');
        //     $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::where('business_id', Session::get('business_id'))
        //         ->where('approval_type_id', 3)
        //         ->where('cycle_type', 2)
        //         ->where(function ($query) use ($roleIdToCheck) {
        //             $query->whereJsonContains('role_id', (string) $roleIdToCheck)
        //                 ->orWhereJsonContains('role_id', (string) $roleIdToCheck);
        //         })
        //         ->first();
        //     $root = compact('checkmfirstRoleId', 'Branch', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'moduleName', 'permissions', 'DATA', 'StaticMisspunchTimeType', 'parallerCaseApprovalListRoleIdCheck');
        //     return view('admin.request.mispunch', $root);
        // }

        public function mispunch()
        {
            // sessio get data
            $businessId = Session::get('business_id');
            $roleIdToCheck = Session::get('login_role');
            // checck permission branch and business
            $checkArray = json_decode(
                PolicySettingRoleAssignPermission::where('business_id', $businessId)
                    ->where('emp_id', Session::get('login_emp_id'))
                    ->pluck('permission_branch_id')
                    ->first(),
                true
            );
            // main table data
            $misPunchQuery = RequestMispunchList::join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
                ->join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')
                ->where('request_mispunch_list.business_id', $businessId)
                ->where('employee_personal_details.active_emp', '1')
                ->whereMonth('request_mispunch_list.created_at', now()->month)
                ->whereYear('request_mispunch_list.created_at', now()->year)
                ->select('request_mispunch_list.*', 'static_mispunch_timetype.time_type', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.designation_id')
                ->orderByDesc('request_mispunch_list.id');

            if ($checkArray !== null && !empty($checkArray) && $roleIdToCheck != 1) {
                $DATA = $misPunchQuery->whereIn('employee_personal_details.branch_id', $checkArray)->get();
            } else {
                $DATA = $misPunchQuery->get();
            }
            // dropdown static data
            $staticMisspunchTimeType = StaticMisPunchTimeType::all();

            $accessPermission = Central_unit::AccessPermission();
            list($moduleName, $permissions) = $accessPermission;
            $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(3)[1];
            $loginRoleID = RulesManagement::PassBy()[3];
            $loginRoleBID = RulesManagement::PassBy()[1];
            $loginEmpID = RulesManagement::PassBy()[2];

            $checkFirstRoleId = ApprovalManagementCycle::where('approval_type_id', 3)
                ->where('business_id', $businessId)
                ->pluck('role_id')
                ->first();

            $firstRoleIdData = json_decode($checkFirstRoleId ?? 0, true);
            $checkmfirstRoleId = !empty($firstRoleIdData) && is_array($firstRoleIdData) ? $firstRoleIdData[0] : 0;
            $roleIdData = json_decode($checkFistRoleId->role_id ?? 0);
            // if (!empty($roleIdData) && is_array($roleIdData)) {
            //     $checkmfirstRoleId = $roleIdData[0];
            //     // Now $firstRoleId contains the first element of the array
            // } else {
            //     $checkmfirstRoleId = 0;
            //     // Handle the case where $roleIdData is not a valid array
            //     // It might be empty or not a valid JSON string
            // }

            $branchList = Central_unit::BranchList();

            $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::where('business_id', $businessId)
                ->where('approval_type_id', 3)
                ->where('cycle_type', 2)
                ->where(function ($query) use ($roleIdToCheck) {
                    $query->whereJsonContains('role_id', (string) $roleIdToCheck)
                        ->orWhereJsonContains('role_id', (string) $roleIdToCheck);
                })
                ->first();

            $root = compact('checkmfirstRoleId','checkFirstRoleId', 'branchList', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'moduleName', 'permissions', 'DATA', 'staticMisspunchTimeType', 'parallerCaseApprovalListRoleIdCheck');
            return view('admin.request.mispunch', $root);
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
        $empStatus = [];
        $branchId = $request->branch_id;
        $fromDate =
            $request->input('from_date') ??
            Carbon::now()->startOfMonth()->toDateString();
        $toDate =
            $request->input('to_date') ??
            Carbon::now()
            ->endOfMonth()
            ->toDateString();
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $approval_type_id_static = 4;
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(4)[1];
        // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = RequestGatepassList::join('employee_personal_details', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->where('employee_personal_details.active_emp', '1')

            ->when($branchId, function ($query) use ($branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->when($fromDate, function ($query, $fromDate) {
                $query->where('request_gatepass_list.date', '>=', $fromDate);
            })
            ->when($toDate, function ($query, $toDate) {
                $query->where('request_gatepass_list.date', '<=', $toDate);
            })
            ->select('request_gatepass_list.*', 'designation_list.desig_name', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo')
            ->orderBy('request_gatepass_list.id', 'desc')
            ->get();

        if (count($filteredData) != 0) {
            if ($checkApprovalCycleType == 1) {
                foreach ($filteredData as $key => $data) {
                    $EmpStatus = RulesManagement::RequestGatePassApprovalManage($checkApprovalCycleType, $data, $data->id, 4, $loginRoleID);
                    // $EmpStatus = RulesManagement::RequestGatePassApprovalManage($checkApprovalCycleType, $data, $data->id, 2, $loginRoleID);
                    $empStatus[$data->id] = $EmpStatus;

                    $current_status_particular_tb = DB::table('approval_status_list')
                        ->where('approval_type_id', $approval_type_id_static)
                        ->where('applied_cycle_type', 1)
                        ->where('emp_id', $loginEmpID)
                        ->where('role_id', $loginRoleID)
                        ->where('all_request_id', $data->id)
                        ->select('approval_status_list.id')
                        ->first();
                    $currentStatusParrticularDb[$data->id] = $current_status_particular_tb;
                }
            }

            if ($checkApprovalCycleType == 2) {
                foreach ($filteredData as $key => $data) {
                    $EmpStatus = RulesManagement::RequestGatePassApprovalManage($checkApprovalCycleType, $data, $data->id, 4, $loginRoleID);
                    $empStatus[$data->id] = $EmpStatus;
                    $current_status_particular_tb = DB::table('approval_status_list')
                        ->where('approval_type_id', $approval_type_id_static)
                        ->where('applied_cycle_type', 2)
                        ->where('all_request_id', $data->id)
                        ->first();
                    $currentStatusParrticularDb[$data->id] = $current_status_particular_tb;
                }
            }

            // Return the filtered data as JSON response
            return response()->json(['get' => $filteredData, 'currentstatupartdb' => $currentStatusParrticularDb, 'status' => $empStatus, 'checkapprovaltype' => $checkApprovalCycleType, 'loginroleid' => $loginRoleID]);
            // return $filteredData;
        } else {
            $filteredData = [];
            $currentStatusParrticularDb = [];
            $empStatus = [];
            return response()->json(['get' => $filteredData, 'currentstatupartdb' => $currentStatusParrticularDb, 'status' => $empStatus, 'checkapprovaltype' => $checkApprovalCycleType, 'loginroleid' => $loginRoleID]);
        }
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

    public function MispunchTable($tableName, Request $request)
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

    public function EditGatepassDataGet(Request $request)
    {
        $data = DB::table('request_gatepass_list')
            ->join('employee_personal_details', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->where('request_gatepass_list.id', $request->id)
            ->where('employee_personal_details.active_emp', '1')
            ->select('request_gatepass_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->first();
        return response()->json(['get' => $data]);
    }

    public function EditMispunchDataGet(Request $request)
    {
        $data = DB::table('request_mispunch_list')
            ->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('request_mispunch_list.id', $request->id)
            ->select('request_mispunch_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'static_mispunch_timetype.time_type  as time_type')
            ->first();
        return response()->json(['get' => $data]);
    }

    public function MispunchEmployeeFilter(Request $request)
    {
        $empStatus = [];
        $branchId = $request->branch_id;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $fromDate =
            $request->input('from_date') ??
            Carbon::now()
            ->startOfMonth()
            ->toDateString();
        $toDate =
            $request->input('to_date') ??
            Carbon::now()
            ->endOfMonth()
            ->toDateString();
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $approval_type_id_static = 3;
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(3)[1];
        // return $checkApprovalCycleType;
        // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = DB::table('request_mispunch_list')
            ->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('static_mispunch_timetype', 'static_mispunch_timetype.id', '=', 'request_mispunch_list.emp_miss_time_type')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            // ->where('request_mispunch_list.emp_miss_date', $dateSelectValue)
            ->where('employee_personal_details.active_emp', '1')

            ->when($branchId, function ($query) use ($branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->when($fromDate, function ($query, $fromDate) {
                $query->where('request_mispunch_list.emp_miss_date', '>=', $fromDate);
            })
            ->when($toDate, function ($query, $toDate) {
                $query->where('request_mispunch_list.emp_miss_date', '<=', $toDate);
            })
            ->where('request_mispunch_list.business_id', Session::get('business_id'))
            ->select('request_mispunch_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'static_mispunch_timetype.time_type')
            ->orderBy('request_mispunch_list.id', 'desc')
            ->get();
        // return $filteredData;
        if (count($filteredData) != 0) {
            if ($checkApprovalCycleType == 1) {
                foreach ($filteredData as $key => $data) {
                    $EmpStatus = RulesManagement::RequestMispunchApprovalManage($checkApprovalCycleType, $data, $data->id, 3, $loginRoleID);
                    // $EmpStatus = RulesManagement::RequestGatePassApprovalManage($checkApprovalCycleType, $data, $data->id, 2, $loginRoleID);
                    $empStatus[$data->id] = $EmpStatus;

                    $current_status_particular_tb = DB::table('approval_status_list')
                        ->where('approval_type_id', $approval_type_id_static)
                        ->where('applied_cycle_type', 1)
                        ->where('emp_id', $loginEmpID)
                        ->where('role_id', $loginRoleID)
                        ->where('all_request_id', $data->id)
                        ->select('approval_status_list.id')
                        ->first();
                    $currentStatusParrticularDb[$data->id] = $current_status_particular_tb;
                }
            }
            if ($checkApprovalCycleType == 2) {
                foreach ($filteredData as $key => $data) {
                    $EmpStatus = RulesManagement::RequestMispunchApprovalManage($checkApprovalCycleType, $data, $data->id, 3, $loginRoleID);
                    $empStatus[$data->id] = $EmpStatus;
                    $current_status_particular_tb = DB::table('approval_status_list')
                        ->where('approval_type_id', $approval_type_id_static)
                        ->where('applied_cycle_type', 2)
                        ->where('all_request_id', $data->id)
                        ->first();
                    $currentStatusParrticularDb[$data->id] = $current_status_particular_tb;
                }
            }

            // Return the filtered data as JSON response
            return response()->json(['get' => $filteredData, 'currentstatupartdb' => $currentStatusParrticularDb, 'status' => $empStatus, 'checkapprovaltype' => $checkApprovalCycleType, 'loginroleid' => $loginRoleID]);
            // return $filteredData;
        } else {
            $filteredData = [];
            $currentStatusParrticularDb = [];
            $empStatus = [];
            return response()->json(['get' => $filteredData, 'currentstatupartdb' => $currentStatusParrticularDb, 'status' => $empStatus, 'checkapprovaltype' => $checkApprovalCycleType, 'loginroleid' => $loginRoleID]);
        }
    }

    public function LeaveEmployeeFilter(Request $request)
    {
        $empStatus = [];
        $branchId = $request->branch_id;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $fromDate =
            $request->input('from_date') ??
            Carbon::now()
            ->startOfMonth()
            ->toDateString();
        $toDate =
            $request->input('to_date') ??
            Carbon::now()
            ->endOfMonth()
            ->toDateString();
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $approval_type_id_static = 2;
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(2)[1];

        $PendingLeave = DB::table('request_leave_list')
            ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('request_leave_list.business_id', Session::get('business_id'))
            ->where('request_leave_list.final_status', 0)
            ->where('employee_personal_details.active_emp', '1')
            ->when($branchId, function ($query, $branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })
            ->when($departmentId, function ($query, $departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query, $designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->whereDate('request_leave_list.from_date', '>=', $fromDate)
            ->whereDate('request_leave_list.to_date', '<=', $toDate)
            ->count();
        $UnpaidLeave = DB::table('request_leave_list')
            ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('request_leave_list.business_id', Session::get('business_id'))
            ->where('request_leave_list.leave_category', '9')
            ->when($branchId, function ($query, $branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })
            ->when($departmentId, function ($query, $departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query, $designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->whereDate('request_leave_list.from_date', '>=', $fromDate)
            ->whereDate('request_leave_list.to_date', '<=', $toDate)
            ->count();

        $PaidLeave = DB::table('request_leave_list')
            ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('request_leave_list.business_id', Session::get('business_id'))
            ->where('request_leave_list.leave_category', '!=', '9')
            ->when($branchId, function ($query, $branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })
            ->when($departmentId, function ($query, $departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query, $designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->whereDate('request_leave_list.from_date', '>=', $fromDate)
            ->whereDate('request_leave_list.to_date', '<=', $toDate)
            ->count();

        // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = DB::table('request_leave_list')
            ->join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('static_leave_category', 'static_leave_category.id', '=', 'request_leave_list.leave_category')
            ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
            ->leftJoin('static_leave_shift_type', 'static_leave_shift_type.id', '=', 'request_leave_list.shift_type')
            ->when($branchId, function ($query, $branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })
            ->when($departmentId, function ($query, $departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query, $designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->when($fromDate, function ($query, $fromDate) {
                $query->where('request_leave_list.from_date', '>=', $fromDate);
            })
            ->when($toDate, function ($query, $toDate) {
                $query->where('request_leave_list.to_date', '<=', $toDate);
            })
            ->where('request_leave_list.business_id', Session::get('business_id'))
            ->where('employee_personal_details.active_emp', '1')
            ->select('request_leave_list.*', 'static_request_leave_type.leave_day', 'static_leave_category.name as category_name', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.designation_id', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'designation_list.desig_name')
            ->orderBy('request_leave_list.id', 'desc')
            ->get();

        if (count($filteredData) != 0) {
            if ($checkApprovalCycleType == 1) {
                foreach ($filteredData as $key => $data) {
                    $EmpStatus = RulesManagement::RequestLeaveApprovalManage($checkApprovalCycleType, $data, $data->id, 2, $loginRoleID);
                    $empStatus[$data->id] = $EmpStatus;

                    $current_status_particular_tb = DB::table('approval_status_list')
                        ->where('approval_type_id', $approval_type_id_static)
                        ->where('applied_cycle_type', 1)
                        ->where('emp_id', $loginEmpID)
                        ->where('role_id', $loginRoleID)
                        ->where('all_request_id', $data->id)
                        ->select('approval_status_list.id')
                        ->first();
                    $currentStatusParrticularDb[$data->id] = $current_status_particular_tb;
                }
            }

            if ($checkApprovalCycleType == 2) {
                foreach ($filteredData as $key => $data) {
                    $EmpStatus = RulesManagement::RequestLeaveApprovalManage($checkApprovalCycleType, $data, $data->id, 2, $loginRoleID);
                    $empStatus[$data->id] = $EmpStatus;
                    $current_status_particular_tb = DB::table('approval_status_list')
                        ->where('approval_type_id', $approval_type_id_static)
                        ->where('applied_cycle_type', 2)
                        ->where('all_request_id', $data->id)
                        ->first();
                    $currentStatusParrticularDb[$data->id] = $current_status_particular_tb;
                }
            }
            //         $perPage = 10; // Adjust perPage as needed
            //     $currentPage = $filteredData->currentPage();

            //     $pagination = new LengthAwarePaginator(
            //         $filteredData->items(),
            //         $filteredData   ->total(),
            //         $perPage,
            //         $currentPage,
            //         [
            //             'path' => url()->current(),
            //             'query' => request()->query(),
            //         ]
            //     );

            // $paginationHtml = $pagination->links()->toHtml();

            // Return the filtered data as JSON response
            return response()->json(['get' => $filteredData, 'currentstatupartdb' => $currentStatusParrticularDb, 'status' => $empStatus, 'checkapprovaltype' => $checkApprovalCycleType, 'loginroleid' => $loginRoleID, 'PendingLeave' => $PendingLeave, 'UnpaidLeave' => $UnpaidLeave, 'PaidLeave' => $PaidLeave]);
        } else {
            $filteredData = [];
            $currentStatusParrticularDb = [];
            $empStatus = [];
            return response()->json(['get' => $filteredData, 'currentstatupartdb' => $currentStatusParrticularDb, 'status' => $empStatus, 'checkapprovaltype' => $checkApprovalCycleType, 'loginroleid' => $loginRoleID, 'PendingLeave' => $PendingLeave, 'UnpaidLeave' => $UnpaidLeave, 'PaidLeave' => $PaidLeave]);
        }
    }

    public function allGatepassFilterDepartment(Request $request)
    {
        $branch_ID = $request->brand_id;
        $get = EmployeePersonalDetail
            // join('request_gatepass_list', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ::join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.active_emp', '1')
            ->select('employee_personal_details.department_id as depart_id', 'department_list.depart_name')
            ->distinct()
            ->get();
        return response()->json(['department' => $get]);
    }

    public function allGatepassFilterDesignation(Request $request)
    {
        // return "chal";
        // $branch_ID = $request->brand_id;
        $branch_ID = $request->branch_id;
        $get = EmployeePersonalDetail
            // join('request_gatepass_list', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ::join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.department_id', $request->depart_id)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.active_emp', '1')
            ->select('designation_list.desig_id', 'designation_list.desig_name')
            ->distinct()
            ->get();
        return response()->json(['designation' => $get]);
    }

    public function allMispunchFilterDepartment(Request $request)
    {
        $branch_ID = $request->brand_id;
        $get = EmployeePersonalDetail
            // join('request_mispunch_list', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ::join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.active_emp', '1')
            ->select('employee_personal_details.department_id as depart_id', 'department_list.depart_name')
            ->distinct()
            ->get();
        return response()->json(['department' => $get]);
    }

    public function allMispunchFilterDesignation(Request $request)
    {
        // return "chal";
        // $branch_ID = $request->brand_id;
        $branch_ID = $request->branch_id;
        $get = EmployeePersonalDetail
            // join('request_mispunch_list', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ::join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.department_id', $request->depart_id)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.active_emp', '1')
            ->select('designation_list.desig_id', 'designation_list.desig_name')
            ->distinct()
            ->get();
        return response()->json(['designation' => $get]);
    }

    public function allLeaveFilterDepartment(Request $request)
    {
        $branch_ID = $request->brand_id;

        $get = EmployeePersonalDetail
            // join('request_leave_list', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ::join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.active_emp', '1')
            ->select('employee_personal_details.department_id as depart_id', 'department_list.depart_name')
            ->distinct()
            ->get();
        // dd($get);
        return response()->json(['department' => $get]);
    }

    public function allLeaveFilterDesignation(Request $request)
    {
        // return "chal";
        // $branch_ID = $request->brand_id;
        $branch_ID = $request->branch_id;
        $get = EmployeePersonalDetail
            // join('request_leave_list', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ::join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.department_id', $request->depart_id)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.active_emp', '1')
            ->select('designation_list.desig_id', 'designation_list.desig_name')
            ->distinct()
            ->get();
        return response()->json(['designation' => $get]);
    }
}

// Route::any('/gatepass/{tableName}', [RequestController::class, 'GatepassTable']);
// Route::any('/gatepass/{tableName}', [RequestController::class, 'MispunchTable']);
// Route::any('/mispunch/detail', [RequestController::class, 'editMispunchDataGet']);
// Route::any('/mispunchemployeefilter', [RequestController::class, 'MispunchEmployeeFilter']);
