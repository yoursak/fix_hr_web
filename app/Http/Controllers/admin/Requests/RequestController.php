<?php

namespace App\Http\Controllers\admin\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\PolicyAttendanceMode;
use App\Models\EmployeePersonalDetail;
use App\Helpers\ApiResponse;
use Carbon\Carbon;
use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\RequestGatepassList;
use App\Models\StaticMissPunchTimeType;
use App\Models\RequestLeaveList;
use App\Models\AttendanceList;
use App\Models\RequestMispunchList;
use RealRashid\SweetAlert\Facades\Alert;
use DateTime;
use DB;
use Session;

class RequestController extends Controller
{
    public function gatepass()
    {
        $staticLeaveType = DB::table('employee_personal_details')
            ->join('attendance_list', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('attendance_list.punch_date', '!=', date('Y-m-d'))
            ->select('employee_personal_details.emp_id')
            ->get();

        $TodayPresent = AttendanceList::where('business_id', Session::get('business_id'))
            ->where('punch_date', '=', now()->toDateString())
            ->get();

        $PresetCount = count($TodayPresent);
        $leaveCategory = DB::table('policy_setting_leave_category')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $shiftType = DB::table('static_leave_shift_type')->get();
        $leaveType = DB::table('static_request_leave_type')->get();
        $DATA = RequestGatepassList::join('employee_personal_details', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('request_gatepass_list.business_id', Session::get('business_id'))
            ->whereMonth('request_gatepass_list.created_at', '=', Carbon::now()->month)
            ->whereYear('request_gatepass_list.created_at', '=', Carbon::now()->year)
            // ->where('request_gatepass_list.id', 21)
            ->select('request_gatepass_list.*', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.designation_id', 'employee_personal_details.emp_mobile_number')
            ->orderBy('request_gatepass_list.id', 'DESC')
            ->get();
        $ABCD = DB::table('approval_status_list')
            ->where('all_request_id', 26)
            ->where('approval_type_id', 4)
            ->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        // processCycle Seq. Parallel
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(4)[1];
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];

        $going_through = DB::table('static_going_through_type')->get();

        $owner_call_back_id = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $root = compact('moduleName', 'owner_call_back_id', 'going_through', 'permissions', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'DATA', 'PresetCount', 'leaveCategory', 'leaveType', 'shiftType');
        return view('admin.request.gatepass', $root);
    }

    // delete gatepass detail
    public function DestroyGatepass(Request $request)
    {
        $data = RequestGatepassList::where('id', $request->id)->delete();
        if ($data) {
            Alert::error('Not Updated', 'Your Gatepass Detail Delete is Fail');
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
    // public function ApproveGatepass(Request $request)
    // {
    //     // dd($request->all());
    //     if ($request->has('id') && $request->has('in_time') && $request->has('approve')) {
    //         $gatepass = RequestGatepassList::where('id', $request->id)
    //             ->where('business_id', Session::get('business_id'))
    //             ->update(['out_time' => $request->out_time, 'in_time' => $request->in_time, 'status' => $request->approve]);
    //         Alert::success('Your Gatepass Request has been Approve Successfully');
    //         return back();
    //     } elseif ($request->has('id') && $request->has('in_time') && $request->has('submit') && $request->has('remark')) {
    //         $gatepass = RequestGatepassList::where('id', $request->id)
    //             ->where('business_id', Session::get('business_id'))
    //             ->update(['status' => $request->submit, 'remark' => $request->remark]);
    //         Alert::success('Your Gatepass Request has been Decline Successfully');
    //         return back();
    //     } else {
    //         Alert::error('Not Updated', 'Your Gatepass Detail Updation is Fail');
    //         return back();
    //     }
    // }

    public function leaves()
    {
        // $filteredData = DB::table('request_leave_list')
        // ->join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
        // ->join('policy_setting_leave_category', 'policy_setting_leave_category.id', '=', 'request_leave_list.leave_category')
        // ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')

        // // ->when($branchId, function ($query) use ($branchId) {
        // //     $query->where('employee_personal_details.branch_id', $branchId);
        // // })
        // // ->when($departmentId, function ($query) use ($departmentId) {
        // //     $query->where('employee_personal_details.department_id', $departmentId);
        // // })
        // // ->when($designationId, function ($query) use ($designationId) {
        // //     $query->where('employee_personal_details.designation_id', $designationId);
        // // })
        // // ->when($fromDate, function ($query) use ($fromDate) {
        // //     $query->where('request_leave_list.from_date', '>=', $fromDate);
        // // })
        // // ->when($toDate, function ($query) use ($toDate) {
        // //     $query->where('request_leave_list.to_date', '<=', $toDate);
        // // })
        // ->where('employee_personal_details.branch_id', 3)
        // ->where('request_leave_list.business_id', Session::get('business_id'))
        // // ->where('request_leave_list.id', 12)
        // ->select('request_leave_list.*', 'static_request_leave_type.leave_day', 'policy_setting_leave_category.category_name', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.designation_id', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
        // ->orderBy('request_leave_list.id', 'desc')
        // ->get();
        // dd($filteredData);

        // $staticLeaveType = $item = DB::table('employee_personal_details')
        $staticLeaveType = DB::table('employee_personal_details')
            ->join('attendance_list', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('attendance_list.punch_date', '!=', date('Y-m-d'))
            ->select('employee_personal_details.emp_id')
            ->get();

        $TodayPresent = AttendanceList::where('business_id', Session::get('business_id'))
            ->where('punch_date', '=', now()->toDateString())
            ->get();

        $PresetCount = count($TodayPresent);
        $leaveCategory = DB::table('policy_setting_leave_category')
            ->where('business_id', Session::get('business_id'))
            ->get();
        // dd($leaveCategory);
        $shiftType = DB::table('static_leave_shift_type')->get();
        $leaveType = DB::table('static_request_leave_type')->get();
        $DATA = DB::table('request_leave_list')
            ->join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('policy_setting_leave_category', 'policy_setting_leave_category.id', '=', 'request_leave_list.leave_category')
            ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
            ->where('request_leave_list.business_id', Session::get('business_id'))
            ->where('request_leave_list.business_id', Session::get('business_id'))
            ->whereMonth('request_leave_list.created_at', '=', Carbon::now()->month)
            ->whereYear('request_leave_list.created_at', '=', Carbon::now()->year)
            // ->where('request_leave_list.id', 12)
            ->select('request_leave_list.*', 'static_request_leave_type.leave_day', 'policy_setting_leave_category.category_name', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.designation_id', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->orderBy('request_leave_list.id', 'desc')
            ->get();
        // dd($DATA);
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        // processCycle Seq. Parallel
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(2)[1];
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $owner_call_back_id = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        // current_RoleID
        // dd($checkApprovalCycleType->cycle_type);
        $root = compact('moduleName', 'owner_call_back_id', 'permissions', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'DATA', 'PresetCount', 'leaveCategory', 'leaveType', 'shiftType');
        return view('admin.request.leave', $root);
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
            ->where('request_leave_list.id', $request->id)
            ->select('request_leave_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
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
        $gatepass = RequestLeaveList::where('id', $request->id)
            ->where('business_id', $BID)
            ->update(['leave_type' => $request->leave_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $Days]);
        $ApprovalManagement = DB::table('approval_management_cycle')
            ->where('business_id', $BID)
            ->where('approval_type_id', $ApprovalTypeID)
            ->first();

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
        // cyclic dynamic data storing
        $Days = '';
        $status = 0;
        $PID = $request->id;
        $BID = RulesManagement::PassBy()[1];
        $FindRoleID = RulesManagement::PassBy()[3];
        $EmpID = RulesManagement::PassBy()[2];
        $BusinessId = Session::get('business_id');
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
        $ApprovalTypeID = 3; //Mispunch processType

        $attendance = AttendanceList::where('emp_id', $request->emp_id)
            ->where('punch_date', $request->date)
            ->first();
        // dd($attendance);

        $mispunch = RequestMispunchList::where('id', $request->id)
            ->where('business_id', $BusinessId)
            ->update(['emp_miss_time_type' => $request->time_type, 'emp_miss_in_time' => $request->in_time, 'emp_miss_out_time' => $request->out_time]);
        // $mispunch = RequestMispunchList::where('id', $request->id)
        //     ->where('business_id', $BID)
        //     ->update(['leave_type' => $request->leave_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $Days]);
        $ApprovalManagement = DB::table('approval_management_cycle')
            ->where('business_id', $BID)
            ->where('approval_type_id', $ApprovalTypeID)
            ->first();

        // dd($request->all(), $status, $ApprovalManagement, $sd);
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
            // if ($value->forward_by_role_id == $value->final_level_role_id) {
            //      DB::table('request_mispunch_list')
            //         ->where('business_id', $BID)
            //         ->where('id', $PID)
            //         ->update([
            //             'process_complete' => 1,
            //             'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 3)[0], //final status submit
            //         ]);
            //         // dd($darfdasd);
            // }
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
            if ($value->forward_by_role_id == $value->final_level_role_id) {
                DB::table('request_mispunch_list')
                    ->where('business_id', $BID)
                    ->where('id', $PID)
                    ->update([
                        'process_complete' => 1,
                        'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 3)[0], //final status submit
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
                // dd($FinalMispunchApprovalDeclineCheck->final_status);
                if ($FinalMispunchApprovalDeclineCheck->process_complete == 1) {
                    // $checkupdateAttendance = AttendanceList::where('emp_id', $request->emp_id)
                    //     ->where('punch_date', $request->date)
                    //     ->first();
                    // $lateEntry = DB::table('policy_atten_rule_late_entry')->where('business_id',Sesssion::get('business_id'))->first();
                    // $earlyExit = DB::table('policy_atten_rule_early_exit')->where('business_id',Sesssion::get('business_id'))->first();
                    // //Calculate Early Exit and Late BY // calculate late by and early exit by

                    // $shiftStartObj = Carbon::parse($shiftStart);
                    // $shiftEndObj = Carbon::parse($shiftEnd);
                    // $inTimeObj = Carbon::parse($request->in_time);
                    // $outTimeObj = Carbon::parse($request->out_time);
                    // $entryGracetime = ($lateEntry->grace_time_hr ?? 0)*60 + ($lateEntry->grace_time_min ?? 0);
                    // $exitGracetime = ($earlyExit->grace_time_hr ?? 0)*60 + ($earlyExit->grace_time_min ?? 0);
                    // $lateBy = 0;
                    // $earlyExitBy = 0;

                    // // add grace time to entry time
                    // $shiftStartObj = Carbon::parse($shiftStart);
                    // $addedTime = $shiftStartObj->addMinutes($entryGracetime);
                    // $entryGrace = date('H:i', strtotime($addedTime));

                    // // sub grace time to exit time
                    // $shiftEndObj = Carbon::parse($shiftEnd);
                    // $exitGraceTime = $shiftEndObj->subMinutes($exitGracetime);
                    // $exitGrace = date('H:i', strtotime($exitGraceTime));

                    // if($lateEntry->switch_is != null && $lateEntry->switch_is == 1 && $inTime > $entryGrace) {
                    //     $lateByObj = $shiftStartObj->diff($inTimeObj);
                    //     $lateBy = $lateByObj->h * 60 + $lateByObj->i;
                    // }

                    // if($earlyExit->switch_is != null && $earlyExit->switch_is == 1 && $outTime < $exitGrace && $inTime && $outTime) {
                    //     if(Carbon::parse($outTime)->format('H:i:s') !== '00:00:00') {
                    //         $earlyExitByObj = $shiftEndObj->diff($outTimeObj);
                    //         $earlyExitBy = $earlyExitByObj->h * 60 + $earlyExitByObj->i;
                    //     } else {
                    //         $earlyExitBy = 0;
                    //     }
                    // }
                    $checkupdateAttendance = AttendanceList::where('emp_id', $request->emp_id)
                            ->where('punch_date', $request->date)
                            ->first();
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

                        $updaetattendance = AttendanceList::where('emp_id', $request->emp_id)
                            ->where('punch_date', $request->date)
                            // ->update(['punch_in_time' => $request->in_time, 'punch_out_time' => $request->out_time]);
                            // dd($updaetattendance);
                            ->update(['punch_in_time' => $request->in_time, 'punch_out_time' => $request->out_time, 'emp_today_current_status' => '2', 'total_working_hour' => $totalWorking, 'process_complete' => 1, 'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 3)[0]]);
                        $countUpdate = Central_unit::getEmpAttSummaryApi(['punch_date' => $request->date, 'emp_id' => $request->emp_id, 'business_id' => Session::get('business_id')]);

                        $attenApprovalTypeId = 1;
                        AttendanceList::where('id', $checkupdateAttendance->id)->update(['today_status' => $countUpdate[0], 'late_by' => $countUpdate[12], 'early_exit' => $countUpdate[13], 'overtime' => $countUpdate[8]]);
                        // dd($updaetattendance);
                    // $updateattendance = AttendanceList::where('emp_id', $request->emp_id)
                    //     ->where('punch_date', $request->date)
                    //     ->update(['punch_in_time' => $request->in_time, 'punch_out_time' => $request->out_time, 'emp_today_current_status' => '2', 'total_working_hour' => $totalWorking, 'process_complete' => 1, 'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 3)[0]]);
                    // $attenApprovalTypeId = 1;
                    // $countUpdate = Central_unit::getEmpAttSummaryApi(['punch_date' => $request->date, 'emp_id' => $request->emp_id, 'business_id' => Session::get('business_id')]);
                    // dd($updaetattendance);
                    //         DB::table('approval_status_list')
                    // ->where('business_id', $BID)
                    // ->where('approval_type_id', $attenApprovalTypeId)
                    // ->where('all_request_id', $checkupdateAttendance->id)
                    // ->insert([
                    //     'applied_cycle_type' => 2,
                    //     'business_id' => $BID,
                    //     'approval_type_id' => $attenApprovalTypeId,
                    //     'all_request_id' => $checkupdateAttendance->id,
                    //     'role_id' => $FindRoleID,
                    //     'emp_id' => $EmpID,
                    //     'clicked' => 1,
                    //     'remarks' => $Remark,
                    //     'status' => $status,
                    // ]);
                }
                // dd($updateattendance);
            }
        }

        // default case
        if ($ApprovalManagement->cycle_type == 2) {
            // dd($request->all());
            DB::table('request_mispunch_list')
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
                $FinalMispunchApprovalDeclineCheck = DB::table('request_mispunch_list')
                    ->where('business_id', $BID)
                    // ->where('final_status', 1)
                    ->where('id', $PID)
                    ->first();
                // dd($FinalMispunchApprovalDeclineCheck);
                $punchInTimes = strtotime($request->in_time);
                $punchOutTimes = strtotime($request->out_time);
                $totalWorkingSeconds = $punchOutTimes - $punchInTimes;

                $totalWorkingTimestamp = strtotime('midnight') + $totalWorkingSeconds;
                $totalWorking = date('H:i:s', $totalWorkingTimestamp);
                if ($FinalMispunchApprovalDeclineCheck != null) {
                    if ($FinalMispunchApprovalDeclineCheck) {
                        $checkupdateAttendance = AttendanceList::where('emp_id', $request->emp_id)
                            ->where('punch_date', $request->date)
                            ->first();
                        $PreviousAttenStatus = $checkupdateAttendance->today_status;
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
                                'present' => $PreviousAttenStatus == 1 ? $empMonthlyCount->present - 1 : $empMonthlyCount->present ?? 0,
                                'absent' => $PreviousAttenStatus == 2 ? $empMonthlyCount->absent - 1 : $empMonthlyCount->absent ?? 0,
                                'late' => $PreviousAttenStatus == 3 ? $empMonthlyCount->late - 1 : $empMonthlyCount->late ?? 0,
                                'early_exit' => $PreviousAttenStatus == 12 ? $empMonthlyCount->early_exit - 1 : $empMonthlyCount->early_exit ?? 0,
                                'mispunch' => $PreviousAttenStatus == 4 ? ($empMonthlyCount->mispunch <= 0 ? 0 : $empMonthlyCount->mispunch - 1) : $empMonthlyCount->mispunch ?? 0,
                                'half_day' => $PreviousAttenStatus == 8 ? $empMonthlyCount->half_day - 1 : $empMonthlyCount->half_day ?? 0,
                                'overtime' => $PreviousAttenStatus == 9 ? $empMonthlyCount->overtime - 1 : $empMonthlyCount->overtime ?? 0,
                                'leave' => in_array($PreviousAttenStatus, [10, 11]) ? $empMonthlyCount->leave - 1 : $empMonthlyCount->leave ?? 0,
                            ]);

                        $updaetattendance = AttendanceList::where('emp_id', $request->emp_id)
                            ->where('punch_date', $request->date)
                            // ->update(['punch_in_time' => $request->in_time, 'punch_out_time' => $request->out_time]);
                            // dd($updaetattendance);
                            ->update(['punch_in_time' => $request->in_time, 'punch_out_time' => $request->out_time, 'emp_today_current_status' => '2', 'total_working_hour' => $totalWorking, 'process_complete' => 1, 'final_status' => $status]);
                        $countUpdate = Central_unit::getEmpAttSummaryApi(['punch_date' => $request->date, 'emp_id' => $request->emp_id, 'business_id' => Session::get('business_id')]);

                        $attenApprovalTypeId = 1;
                        AttendanceList::where('id', $checkupdateAttendance->id)->update(['today_status' => $countUpdate[0], 'late_by' => $countUpdate[12], 'early_exit' => $countUpdate[13], 'overtime' => $countUpdate[8]]);
                        // dd($updaetattendance);
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
                    }
                }
            }
            Alert::success('', 'Status is updated');
        }
        return redirect()->back();
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

    public function DestroyMispunch($id)
    {
        // dd($id);
        $data = MispunchList::find($id);
        $data->delete();
        if ($data) {
            Alert::success('Delete Success', 'Delete Gatepass Successfully');
        }
        // Session::flash('success', 'Succefully Deleted !');
        return back();
    }

    // DestroyMispunch
    public function mispunch()
    {
        $DATA = DB::table('request_mispunch_list')
            ->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')

            ->whereMonth('request_mispunch_list.created_at', '=', Carbon::now()->month)
            ->whereYear('request_mispunch_list.created_at', '=', Carbon::now()->year)
            ->where('request_mispunch_list.business_id', Session::get('business_id'))
            // ->where('request_mispunch_list.id', 1)
            ->select('request_mispunch_list.*', 'static_mispunch_timetype.time_type', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.designation_id')
            ->orderBy('request_mispunch_list.id', 'desc')
            ->get();
        $StaticMisspunchTimeType = DB::table('static_mispunch_timetype')->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // processCycle Seq. Parallel
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(3)[1];
        // dd($checkApprovalCycleType);
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        // dd($loginRoleBID);
        $loginEmpID = RulesManagement::PassBy()[2];
        $checkFistRoleId = DB::table('approval_management_cycle')
            ->where('approval_type_id', 3)
            ->where('business_id', Session::get('business_id'))
            ->select('role_id')
            ->first();
        // Assuming $checkFistRoleId is the result you showed
        $roleIdData = json_decode($checkFistRoleId->role_id ?? 0);

        if (!empty($roleIdData) && is_array($roleIdData)) {
            $checkmfirstRoleId = $roleIdData[0];
            // Now $firstRoleId contains the first element of the array
        } else {
            $checkmfirstRoleId = 0;
            // Handle the case where $roleIdData is not a valid array
            // It might be empty or not a valid JSON string
            // dd("Invalid role_id data");
        }

        $owner_call_back_id = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        // dd($owner_call_back_id);
        $root = compact('checkmfirstRoleId', 'owner_call_back_id', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'moduleName', 'permissions', 'DATA', 'StaticMisspunchTimeType');
        // $data = MispunchList::all();
        // dd($DATA);
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
        // dd($request->all());
        // $centralUnit = new App\Helpers\Central_unit();
        // $RuleManagement = new App\Helpers\MasterRulesManagement\RulesManagement();
        $empStatus = [];
        $branchId = $request->branch_id;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $approval_type_id_static = 4;
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(4)[1];
        // // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = RequestGatepassList::join('employee_personal_details', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            // ->join('branch_list', 'request_gatepass_list.branch_id', '=', 'branch_list.branch_id')
            // ->join('department_list', 'request_gatepass_list.department_id', '=', 'department_list.depart_id')
            // ->join('designation_list', 'request_gatepass_list.designation_id', '=', 'designation_list.desig_id')
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
            ->select('request_gatepass_list.*', 'designation_list.desig_name', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo')
            // ->select('request_gatepass_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name')
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
            ->select('request_gatepass_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->first();
        return response()->json(['get' => $data]);
    }

    public function EditMispunchDataGet(Request $request)
    {
        // return true;
        $data = DB::table('request_mispunch_list')
            ->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')
            ->where('request_mispunch_list.id', $request->id)
            ->select('request_mispunch_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'static_mispunch_timetype.id  as time_type')
            ->first();
        return response()->json(['get' => $data]);
    }

    public function MispunchEmployeeFilter(Request $request)
    {
        $branchId = $request->branch_id;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $dateSelectValue = $request->input('date_select_value') ? $request->input('date_select_value') : date('Y-m-d');
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $approval_type_id_static = 3;
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(3)[1];
        // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = DB::table('request_mispunch_list')
            ->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('static_mispunch_timetype', 'static_mispunch_timetype.id', '=', 'request_mispunch_list.emp_miss_time_type')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->where('attendance_list.emp_miss_date', isset($dateSelectValue) ? $dateSelectValue : date('Y-m-d'))

            ->when($branchId, function ($query) use ($branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->select('request_mispunch_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'static_mispunch_timetype.time_type')
            ->orderBy('request_mispunch_list.id', 'desc')
            ->get();

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
        // return true;
        $empStatus = [];
        $branchId = $request->branch_id;
        // $data = DB::table('request_leave_list')->get();
        // return $data;
        // return $branchId;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $approval_type_id_static = 2;
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(2)[1];

        // $fromDate = $request->input('from_date');

        // // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = DB::table('request_leave_list')
            ->join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('policy_setting_leave_category', 'policy_setting_leave_category.id', '=', 'request_leave_list.leave_category')
            ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')

            ->when($branchId, function ($query) use ($branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->when($fromDate, function ($query) use ($fromDate) {
                $query->where('request_leave_list.from_date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                $query->where('request_leave_list.to_date', '<=', $toDate);
            })
            ->where('request_leave_list.business_id', Session::get('business_id'))
            // ->where('request_leave_list.id', 22)
            // ->where('request_leave_list.id', 12)
            ->select('request_leave_list.*', 'static_request_leave_type.leave_day', 'policy_setting_leave_category.category_name', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.designation_id', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'designation_list.desig_name')
            ->orderBy('request_leave_list.id', 'desc')
            ->get();

        if (count($filteredData) != 0) {
            if ($checkApprovalCycleType == 1) {
                foreach ($filteredData as $key => $data) {
                    $EmpStatus = RulesManagement::RequestLeaveApprovalManage($checkApprovalCycleType, $data, $data->id, 2, $loginRoleID);
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
    // p

    public function allGatepassFilterDepartment(Request $request)
    {
        $branch_ID = $request->brand_id;
        $get = EmployeePersonalDetail::join('request_gatepass_list', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
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
        $get = EmployeePersonalDetail::join('request_gatepass_list', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.department_id', $request->depart_id)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select('designation_list.desig_id', 'designation_list.desig_name')
            ->distinct()
            ->get();
        return response()->json(['designation' => $get]);
    }

    public function allMispunchFilterDepartment(Request $request)
    {
        $branch_ID = $request->brand_id;
        $get = EmployeePersonalDetail::join('request_mispunch_list', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
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
        $get = EmployeePersonalDetail::join('request_mispunch_list', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.department_id', $request->depart_id)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select('designation_list.desig_id', 'designation_list.desig_name')
            ->distinct()
            ->get();
        return response()->json(['designation' => $get]);
    }

    public function allLeaveFilterDepartment(Request $request)
    {
        $branch_ID = $request->brand_id;
        $get = EmployeePersonalDetail::join('request_leave_list', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select('employee_personal_details.department_id as depart_id', 'department_list.depart_name')
            ->distinct()
            ->get();
        return response()->json(['department' => $get]);
    }

    public function allLeaveFilterDesignation(Request $request)
    {
        // return "chal";
        // $branch_ID = $request->brand_id;
        $branch_ID = $request->branch_id;
        $get = EmployeePersonalDetail::join('request_leave_list', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.department_id', $request->depart_id)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
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
