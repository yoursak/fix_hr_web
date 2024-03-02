<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeePersonalDetail;
use App\Models\RequestMispunchList;

use App\Models\AttendanceList;
use App\Models\PolicyAttenRuleMisspunch;
use App\Models\StaticMisPunchTimeType;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\UserSideResponse\MispunchRequestResources;
use App\Http\Resources\Api\UserSideResponse\FindOutMisPunchIn;

use App\Http\Resources\Api\UserSideResponse\MispunchStaticTimeTypeResources;
use App\Models\ApprovalManagementCycle;

// use App\Http\Resources\Api\MispunchRequestResources;
use Carbon\Carbon;
use App\Http\Resources\Api\UserSideResponse\UserMispunchIdToDataResources;
use App\Http\Resources\Api\UserSideResponse\CurrentMisPunchRequestStatus;
// use App\Http\Resources\Api\UserSideResponse\FindOutMisPunchIn;
use DB;

class MispunchApiController extends Controller
{
    // static table time type data
    public function staticMispunchTimeType()
    {
        $data = StaticMisPunchTimeType::get();
        return ReturnHelpers::jsonApiReturn(MispunchStaticTimeTypeResources::collection($data)->all()); // case 1 when the gatepass date find
    }

    // mispunch data list
    public function mispunchDataList(Request $request)
    {
        $emp_id = $request->emp_id;
        $business_id = $request->business_id;
        $date = $request->date;
        if ($emp_id != null && $business_id != null && $date != null) {
            $requestDate = Carbon::createFromFormat('d-m-Y', $date);
            $emp = DB::table('employee_personal_details')
                ->where('emp_id', $emp_id)
                ->where('business_id', $business_id)
                ->first();
            // return $emp;
            if ($emp) {
                $mispunch = RequestMispunchList::join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')
                    ->where('request_mispunch_list.emp_id', $emp_id)
                    ->where('request_mispunch_list.business_id', $business_id)
                    ->whereYear('request_mispunch_list.emp_miss_date', '=', $requestDate->year)
                    ->whereMonth('request_mispunch_list.emp_miss_date', '=', $requestDate->month)
                    ->select('request_mispunch_list.*', 'static_mispunch_timetype.time_type')
                    ->orderBy('request_mispunch_list.id', 'desc')
                    ->get();
                // return $mispunch;
                if (count($mispunch) != 0) {
                    // return $mispunch;
                    return ReturnHelpers::jsonApiReturnSecond(MispunchRequestResources::collection($mispunch)->all(), 1); // case 1 when the gatepass date find
                } else {
                    return response()->json(['result' => [], 'case' => 2, 'status' => true]); // case 2 when the employee gatepass record not found
                }
            } else {
                return response()->json(['result' => [], 'case' => 3, 'status' => false], 404); // case 3 when the employee not found
            }
        } else {
            return response()->json(['result' => [], 'case' => 4, 'status' => false], 404); // case 4 when the rquired field is null
        }
        // $businessID = $request->business_id;
        // $EmpID = $request->emp_id;
        // $date = $request->date;

        // $date = Carbon::createFromFormat('d-m-Y', $date);

        // // $date = $request->date; // Assuming $request->date is a valid date in 'Y-m-d' format
        // $FindMonthYear = $request->find_year_month; //like 2023-11
        // // return $date;
        // // // calculate present, absent, halfday, holiday, weekoff;

        // $preview = DB::table('request_mispunch_list')
        //     ->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
        //     ->where('request_mispunch_list.business_id', $businessID)
        //     ->where(function ($query) use ($date, $FindMonthYear, $EmpID) {
        //         if (!empty($date)) {
        //             $query->whereDate('request_mispunch_list.emp_miss_date', $date); // Use whereDate to compare the full date
        //         }
        //         if (!empty($FindMonthYear) && !empty($EmpID)) {
        //             $year = substr($FindMonthYear, 0, 4); // Extract the year (e.g., '2023')
        //             $month = substr($FindMonthYear, 5, 2); // Extract the month (e.g., '11')
        //             $query
        //                 ->where('request_mispunch_list.emp_id', $EmpID)
        //                 ->whereYear('request_mispunch_list.emp_miss_date', $year)
        //                 ->whereMonth('emp_miss_date.emp_miss_date', $month);
        //         }
        //     })
        //     // ->select('employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_shift_type', 'employee_personal_details.emp_attendance_method', 'employee_personal_details.profile_photo', 'attendance_list.*')
        //     // ->orderby('attendance_list.id', 'desc')
        //     ->get();
        // // return $preview;
        // $formattedData = AttendanceListResource::collection($preview);

        // if ($formattedData) {
        //     return response()->json(['result' => $formattedData, 'status' => true]);
        // }
        // return response()->json(['result' => [], 'status' => false], 404);
        // $emp = DB::table('employee_personal_details')
        //     ->where('emp_id', $id)
        //     ->first();
        // $Mispunch = DB::table('Mispunch_list')
        //     ->where('emp_id', $id)
        //     ->orderBy('id', 'desc')
        //     ->get();

        // if ($emp!=null  &&(count($Mispunch) != 0)) {
        //     // return $Mispunch;
        //     return ReturnHelpers::jsonApiReturn(UserMispunchIdToDataResources::collection($Mispunch)->all());
        // } else {
        //     return response()->json(['result' => [], 'status' => false], 404);
        // }
    }


    public function checkPermissionAllowMissPunch(Request $request)
    {
        $requestDate = Carbon::createFromFormat('d-m-Y', $request->now_date)->format('Y-m-d');
        // dd($requestDate);
        $EMPID = $request->emp_id;
        $BID = $request->business_id;
        $checkAutomation = PolicyAttenRuleMisspunch::where('business_id', $BID)->where('switch_is', 1)->first();
        $ModeAllow =  RequestMispunchList::where('emp_id', $EMPID)
            ->where('business_id', $BID)
            ->whereYear('emp_miss_date', Carbon::createFromFormat('Y-m-d', $requestDate)->year)
            ->whereMonth('emp_miss_date', Carbon::createFromFormat('Y-m-d', $requestDate)->month)
            ->select('id')
            ->count();
        // dd($ModeAllow);
        if ($checkAutomation->switch_is == 1) {
            //     if ($checkAutomation ? ($checkAutomation->request_day != '00' ? $requestDate->diffInDays($ModeAllow) <= $checkAutomation->request_day : 'true') : '') {
            //         return response()->json(['mode' => $ModeAllow]);
            //     }
            if ($checkAutomation->occurance_count >= $ModeAllow) {
                return response()->json(['now_date' => date('d-m-Y', strtotime($requestDate)), 'check_mode' => $checkAutomation->switch_is, 'automation_count' => (int) $checkAutomation->occurance_count, 'request_count' => $ModeAllow,'request_days_count' =>(int) $checkAutomation->request_day]);
            }
        } else {
            return response()->json(['now_date' => date('d-m-Y', strtotime($requestDate)), 'check_mode' => 0, 'automation_count' => (int) 0, 'request_count' => 0]);
        }
    }


    // misspunch store data
    public function store(Request $request)
    {
        $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
        $currentDate = now();
        $business_id = $request->business_id;
        $emp_id = $request->emp_id;

        $branchId = $request->branch_id;
        $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
        if ($business_id != null && $emp_id != null && $requestDate != null) {
            $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $business_id)
                ->where('approval_type_id', 3)
                ->first();
            if ($requestDate <= date('Y-m-d')) {
                if ($approvalManagementCycle != null) {
                    $roleIds = json_decode($approvalManagementCycle->role_id, true); // Decode JSON string to PHP array

                    // Get the first index value of role_id
                    $firstRoleId = $roleIds[0] ?? null; // This will get the first value or null if it doesn't exist

                    // Get the last index value of role_id
                    $lastRoleId = end($roleIds); // Get the last value of the array
                    // $load = $approvalManagementCycle->cycle_type;
                    // $checkAutomation = PolicyAttenRuleMisspunch::where('business_id', $business_id)->first();
                    // if ($checkAutomation != null ? $checkAutomation->switch_is == 1 : false) {

                    //     $emp = EmployeePersonalDetail::where('business_id', $business_id)
                    //         ->where('emp_id', $emp_id)
                    //         ->where('branch_id', $request->branch_id)
                    //         ->first();
                    //     if (isset($emp)) {

                    //         $checkOccurrence = RequestMispunchList::where('emp_id', $emp_id)
                    //             ->where('business_id', $business_id)
                    //             // ->where('branch_id', $branchId)
                    //             ->whereYear('emp_miss_date', '=', $requestDate)
                    //             ->whereMonth('emp_miss_date', '=', $requestDate)
                    //             ->select('id')
                    //             ->count();

                    //         if ($checkAutomation->occurance_count > $checkOccurrence) {
                    //             if ($checkAutomation ? ($checkAutomation->request_day != '00' ? $requestDate->diffInDays($currentDate) <= $checkAutomation->request_day : 'true') : '') {
                    //                 $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
                    //                 $data = new RequestMispunchList();
                    //                 $data->business_id = $emp->business_id;
                    //                 $data->branch_id = $request->branch_id;
                    //                 $data->emp_id = $request->emp_id;
                    //                 $data->emp_miss_date = $requestDate->toDateString();
                    //                 $data->emp_mobile_no = $emp->emp_mobile_number;
                    //                 $data->emp_miss_time_type = $request->emp_miss_time_type;
                    //                 $data->emp_miss_in_time = $request->emp_miss_in_time;
                    //                 $data->emp_miss_out_time = $request->emp_miss_out_time;
                    //                 $data->emp_working_hour = $request->emp_working_hour;
                    //                 $data->reason = $request->reason;
                    //                 $data->forward_by_role_id = $firstRoleId ?? 0;
                    //                 $data->forward_by_status = 0;
                    //                 $data->final_level_role_id = $lastRoleId ?? 0;
                    //                 $data->final_status = 0;
                    //                 $data->process_complete = 0;
                    //                 $data->final_status = 0;

                    //                 // $data->status = 0;
                    //                 if ($data->save()) {
                    //                     // return $data;
                    //                     return response()->json([
                    //                         'result' => MispunchRequestResources::collection([RequestMispunchList::find($data->id)])->all(),
                    //                         'case' => 1,
                    //                         'message' => 'Successfully Form Submitted',
                    //                         'status' => true
                    //                     ], 200);
                    //                     // return response()->json(['result' => MispunchRequestResources::collection([RequestMispunchList::find($data->id)])->all(), 'case' => 1, 'message' => 'Successfully Form Submitted', 'status' => true], 200);
                    //                 } else {
                    //                     return response()->json(['result' => [], 'case' => 2, 'message' => 'Not Form Submitted', 'status' => true], 200); // case 2 when the gatepass record not store
                    //                 }
                    //             } else {
                    //                 return response()->json(['result' => [], 'case' => 3, 'message' => 'before days expair', 'status' => true], 200); // jab mispunch date exced to automation rule
                    //             }
                    //         }

                    //         // else {
                    //         //     // return 'case 3 this limit above exit';
                    //         //     return response()->json(['result' => [], 'case' => 4, 'message' => 'Limit close to automation rule given automation rule', 'status' => true], 200); // case 3 this limit above exit
                    //         // }
                    //     } else {
                    //         // return 'case 4 employee not found';
                    //         return response()->json(['result' => [], 'message' => 'empid not find', 'case' => 5, 'status' => true], 200); // case 4 when the employee not found
                    //     }
                    // } else {
                    if (true) {
                        $emp = EmployeePersonalDetail::where('business_id', $business_id)
                            ->where('emp_id', $emp_id)
                            ->first();
                        $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
                        $data = new RequestMispunchList();
                        $data->business_id = $emp->business_id;
                        $data->branch_id = $request->branch_id;
                        $data->emp_id = $request->emp_id;
                        $data->emp_miss_date = $requestDate->toDateString();
                        $data->emp_mobile_no = $emp->emp_mobile_number;
                        $data->emp_miss_time_type = $request->emp_miss_time_type;
                        $data->emp_miss_in_time = $request->emp_miss_in_time;
                        $data->emp_miss_out_time = $request->emp_miss_out_time;
                        $data->emp_working_hour = $request->emp_working_hour;
                        $data->reason = $request->reason;
                        $data->forward_by_role_id = $firstRoleId ?? 0;
                        $data->forward_by_status = 0;
                        $data->final_level_role_id = $lastRoleId ?? 0;
                        $data->final_status = 0;
                        $data->process_complete = 0;
                        $data->final_status = 0;
                        // $data->status = 0;
                        if ($data->save()) {
                            return response()->json(['result' => MispunchRequestResources::collection([RequestMispunchList::find($data->id)])->all(), 'case' => 1, 'message' => 'Successfully Form Submitted', 'status' => true], 200);
                            // return ReturnHelpers::jsonApiReturnSecond(MispunchRequestResources::collection([RequestMispunchList::find($data->id)])->all(), 1); // case 1 when the gatepass date store
                        } else {
                            return response()->json(['result' => [], 'case' => 2, 'message' => 'Not Form Submitted', 'status' => true]); // case 2 when the gatepass record not store
                        }
                        // return 'case 5 gatepass switch off';
                        // return response()->json(['result' => [], 'case' => 5, 'status' => false]); // case 5 gatepass switch off
                    }
                } else {
                    return response()->json(['result' => [], 'message' => 'approval not found', 'case' => 6, 'status' => false], 404); // case 6 approvalmanagementcycle
                }
            } else {
                return response()->json(['result' => [], 'message' => 'date not found', 'case' => 7, 'status' => false], 404); // case 7 when the rquired field is null

            }
        } else {
            // return 'case 6 when the rquired field is null';
            return response()->json(['result' => [], 'message' => 'Null case', 'case' => 8, 'status' => false], 404); // case 7 when the rquired field is null
        }
    }

    public function index()
    {
        //
    }

    public function show($id)
    {
        $data = MispunchList::find($id);
        if ($data) {
            return ReturnHelpers::jsonApiReturn(MispunchRequestResources::collection([$data])->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    public function mispunchupdate(Request $request)
    {
        // return $request->all();
        $id = $request->id;
        $business_id = $request->business_id;
        $emp_id = $request->emp_id;
        $data = RequestMispunchList::where('business_id', $business_id)
            ->where('branch_id', $request->branch_id)
            ->where('emp_id', $emp_id)
            ->where('id', $id)
            ->first();
        if ($data) {
            if ($data->forward_by_status == 0 && $data->final_status == 0 && $data->process_complete == 0) {
                $data->id = $request->id ?? $data->id;
                $data->branch_id = $request->branch_id ?? $data->branch_id;
                $data->business_id = $request->business_id ?? $data->business_id;
                $data->emp_id = $request->emp_id ?? $data->emp_id;
                $data->emp_miss_date = $request->emp_miss_date ?? $data->emp_miss_date;
                $data->emp_miss_time_type = $request->emp_miss_time_type ?? $data->emp_miss_time_type;
                $data->emp_miss_in_time = $request->emp_miss_in_time ?? $data->emp_miss_in_time;
                $data->emp_miss_out_time = $request->emp_miss_out_time ?? $data->emp_miss_out_time;
                $data->emp_working_hour = $request->emp_working_hour ?? $data->emp_working_hour;
                $data->reason = $request->reason ?? $data->reason;
                $data->forward_by_role_id = $request->forward_by_role_id ?? $data->forward_by_role_id;
                $data->forward_by_status = $request->forward_by_status ?? $data->forward_by_status;
                $data->final_level_role_id = $request->final_level_role_id ?? $data->final_level_role_id;
                $data->final_status = $request->final_status ?? $data->final_status;
                $data->process_complete = $request->process_complete ?? $data->process_complete;
                $submit = $data->update();
                if ($submit) {
                    return response()->json(['result' => [], 'status' => true, 'case' => 1]); // case 1 update
                }
                return response()->json(['result' => [], 'status' => false, 'case' => 2]); // case 2 when the action perform
            }
            return response()->json(['result' => ['You cannot update your request, your request is a process you can not update it.'], 'status' => false, 'case' => 3]); // case 3 when the action perform
        }
        return response()->json(['result' => [], 'status' => false, 'case' => 4], 404); // case 4 when the data not found
    }

    public function destroy(Request $request)
    {
        $data = RequestMispunchList::where('business_id', $request->business_id)
            ->where('emp_id', $request->emp_id)
            ->where('id', $request->id)
            ->first();
        if ($data) {
            if ($data->forward_by_status == 0 && $data->final_status == 0 && $data->process_complete == 0) {
                $data->delete();
                return response()->json(['result' => 'Delete Successfuly', 'status' => true, 'case' => 1], 200);
            } else {
                return response()->json(['result' => 'You cannot delete your request, your request is under process you can not delete it.', 'status' => true, 'case' => 2], 200);
            }
        } else {
            return response()->json(['result' => 'Not Delete Successfuly', 'status' => false, 'case' => 3], 404);
        }
    }
    public function currentStatusMisspunchRequest(Request $request)
    {
        // ->where('policy_setting_role_create.business_id', $request->business_id)
        $goto = DB::table('request_mispunch_list')
            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_mispunch_list.id')
            ->join('policy_setting_role_create', 'approval_status_list.role_id', '=', 'policy_setting_role_create.id')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->leftJoin('employee_personal_details', 'approval_status_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->leftJoin('business_details_list', 'approval_status_list.business_id', '=', 'business_details_list.business_id')
            ->where('request_mispunch_list.id', $request->id) //primary id
            ->where('approval_status_list.approval_type_id', $request->approval_type) //leave type 2
            ->where('approval_status_list.business_id', $request->business_id)
            ->select(
                'approval_status_list.*',
                //  'policy_setting_role_create.roles_name',
                DB::raw('CASE WHEN approval_status_list.role_id = 1 THEN "Owner" ELSE policy_setting_role_create.roles_name END AS roles_name'),
                'static_status_request.request_response',
                // 'employee_personal_details.emp_name as first_name',
                DB::raw('CASE WHEN approval_status_list.role_id = 1 THEN business_details_list.client_name ELSE employee_personal_details.emp_name END AS first_name'),
                'employee_personal_details.emp_mname as middle_name',
                'employee_personal_details.emp_lname as last_name'
            )
            ->get();
        if (isset($goto)) {
            return response()->json(['result' => CurrentMisPunchRequestStatus::collection($goto)->all(), 'case' => 1, 'status' => true], 200); // case 3 when the employee not found
        } else {
            return response()->json(['result' => [], 'case' => 2, 'status' => false], 404); // case 3 when the employee not found
        }
    }

    public function findOutMisPunchRequest(Request $request)
    {

        $select = $request->find_date;
        $business_id = $request->business_id;
        $selectType = $request->type; //punch-out select
        $emp = $request->emp_id;

        if ($selectType == 3) {
            $selectDate = Carbon::createFromFormat('Y-m-d', $select)->toDateString();
            $punchInTimes = AttendanceList::where('business_id', $business_id)
                ->where('emp_id', $emp)
                ->whereDate('punch_date', $selectDate)
                ->where('today_status', 4)
                ->select('punch_in_time')
                ->first();
            if (!empty($punchInTimes)) {

                return response()->json([
                    'result' => FindOutMisPunchIn::collection([$punchInTimes]),
                    'case' => 1,
                    'status' => true,
                ], 200);
            } else {
                return response()->json(['result' => [], 'case' => 2, 'status' => false], 404); // case 3 when the employee not found
            }
        }
    }
}
