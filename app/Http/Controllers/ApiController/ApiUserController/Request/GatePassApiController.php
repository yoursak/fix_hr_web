<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeePersonalDetail;
use App\Models\RequestGatepassList;
use App\Models\BranchList;
use App\Models\DepartmentList;
use App\Models\PolicyAttenRuleGatepass;
use App\Models\StaticGoingThroughType;
use App\Models\DesignationList;
use App\Http\Resources\Api\UserSideResponse\GatepassRequestResources;
use App\Http\Resources\Api\UserSideResponse\UserGatepassIdToDataResources;
use App\Http\Resources\Api\UserSideResponse\StaticGoingThroughResponse;
use App\Http\Resources\Api\UserSideResponse\CurrentGatePassRequestStatus;
use App\Models\ApprovalManagementCycle;
use App\Helpers\ReturnHelpers;
use DB;
use Carbon\Carbon;

class GatePassApiController extends Controller
{
    // select box going through value
    public function staticGoingThroughResponse()
    {
        $data = StaticGoingThroughType::get();
        return ReturnHelpers::jsonApiReturn(StaticGoingThroughResponse::collection($data)->all());
    }

    // gatpss store function
    public function store(Request $request)
    {
        $business_id = $request->business_id;
        $load = 0;

        $emp_id = $request->emp_id;
        $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
        $currentYear = $requestDate;
        $currentMonth = $requestDate;
        if ($business_id != null && $emp_id != null) {
            $checkAutomation = PolicyAttenRuleGatepass::where('business_id', $business_id)->first();
            if ($checkAutomation->switch_is == 1) {
                $emp = EmployeePersonalDetail::where('business_id', $business_id)
                    ->where('emp_id', $emp_id)
                    ->first();
                if (isset($emp)) {
                    $checkOccurrence = RequestGatepassList::where('emp_id', $emp_id)
                        ->where('business_id', $business_id)
                        ->whereYear('date', '=', $currentYear)
                        ->whereMonth('date', '=', $currentMonth)
                        ->select('id')
                        ->count();
                    // dd(gettype($checkAutomation->occurance_count), gettype($checkOccurrence));
                    // dd($checkOccurrence, $checkAutomation->occurance_count);
                    if ($checkAutomation->occurance_count > $checkOccurrence) {
                        $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $emp->business_id)
                            ->where('approval_type_id', 4)
                            ->first();
                        if ($approvalManagementCycle != null) {
                            $roleIds = json_decode($approvalManagementCycle->role_id, true); // Decode JSON string to PHP array

                            // Get the first index value of role_id
                            $firstRoleId = $roleIds[0] ?? null; // This will get the first value or null if it doesn't exist

                            // Get the last index value of role_id
                            $lastRoleId = end($roleIds); // Get the last value of the array

                            // $load = $approvalManagementCycle->cycle_type;
                            // dd($firstRoleId, $lastRoleId);
                        }

                        $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
                        $data = new RequestGatepassList();
                        $data->business_id = $emp->business_id;
                        $data->emp_id = $request->emp_id;
                        $data->source = $request->source;
                        $data->date = $requestDate->toDateString();
                        $data->destination = $request->destination;
                        $data->going_through = $request->going_through;
                        $data->in_time = $request->in_time;
                        $data->out_time = $request->out_time;
                        $data->reason = $request->reason;
                        $data->forward_by_role_id = $firstRoleId ?? 0;
                        $data->forward_by_status = 0;
                        $data->final_level_role_id = $lastRoleId ?? 0;
                        $data->final_status = 0;
                        $data->process_complete = 0;
                        // $data->status = 0;
                        if ($data->save()) {
                            return response()->json(['result' => true, 'case' => 1, 'message' => 'Gatepass Form Submitted Successfully', 'status' => true]); // case 2 when the gatepass record not store

                            // return ReturnHelpers::jsonApiReturnSecond(GatepassRequestResources::collection([RequestGatepassList::find($data->id)])->all(), 1); // case 1 when the gatepass date store
                        } else {
                            return response()->json(['result' => [], 'case' => 2, 'status' => true]); // case 2 when the gatepass record not store
                        }
                    } else {
                        // return 'case 3 this limit above exit';
                        return response()->json(['result' => [], 'case' => 3, 'status' => false]); // case 4 this limit above exit
                    }
                } else {
                    // return 'case 4 employee not found';
                    return response()->json(['result' => [], 'case' => 4, 'status' => false], 404); // case 4 when the employee not found
                }
            } else {
                $emp = EmployeePersonalDetail::where('business_id', $business_id)
                    ->where('emp_id', $emp_id)
                    ->first();
                $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
                $data = new RequestGatepassList();
                $data->business_id = $emp->business_id;
                $data->emp_id = $request->emp_id;
                $data->source = $request->source;
                $data->date = $requestDate->toDateString();
                $data->destination = $request->destination;
                $data->going_through = $request->going_through;
                $data->in_time = $request->in_time;
                $data->out_time = $request->out_time;
                $data->reason = $request->reason;
                $data->forward_by_role_id = $firstRoleId ?? 0;
                $data->forward_by_status = 0;
                $data->final_level_role_id = $lastRoleId ?? 0;
                $data->final_status = 0;
                $data->process_complete = 0;
                // $data->status = 0;
                if ($data->save()) {
                    return ReturnHelpers::jsonApiReturnSecond(GatepassRequestResources::collection([RequestGatepassList::find($data->id)])->all(), 1); // case 1 when the gatepass date store
                } else {
                    return response()->json(['result' => [], 'case' => 2, 'status' => true]); // case 2 when the gatepass record not store
                }
                // return 'case 5 gatepass switch off';
                // return response()->json(['result' => [], 'case' => 5, 'status' => false]); // case 5 gatepass switch off
            }
        } else {
            // return 'case 6 when the rquired field is null';
            return response()->json(['result' => [], 'case' => 6, 'status' => false], 404); // case 6 when the rquired field is null
        }
    }

    // gatepass record show
    public function gatepasssDataList(Request $request)
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
            if ($emp) {
                $gatepass = RequestGatepassList::join('static_going_through_type', 'static_going_through_type.id', '=', 'request_gatepass_list.going_through')
                    ->where('request_gatepass_list.emp_id', $emp_id)
                    ->where('request_gatepass_list.business_id', $business_id)
                    ->whereYear('request_gatepass_list.date', '=', $requestDate->year)
                    ->whereMonth('request_gatepass_list.date', '=', $requestDate->month)
                    ->select('request_gatepass_list.*', 'static_going_through_type.going_through as going_through_name')
                    ->orderBy('request_gatepass_list.id', 'desc')
                    ->get();
                // return $gatepass;
                // return $gatepass;
                if (count($gatepass) != 0) {
                    return ReturnHelpers::jsonApiReturnSecond(GatepassRequestResources::collection($gatepass)->all(), 1); // case 1 when the gatepass date find
                } else {
                    return response()->json(['result' => [], 'case' => 2, 'status' => true]); // case 2 when the employee gatepass record not found
                }
            } else {
                return response()->json(['result' => [], 'case' => 3, 'status' => false], 404); // case 3 when the employee not found
            }
        } else {
            return response()->json(['result' => [], 'case' => 4, 'status' => false], 404); // case 4 when the rquired field is null
        }

        // return $request->all();
    }

    // gatepassIdDate
    public function gatepassIdData(Request $request)
    {
        $gatepass = RequestGatepassList::where('id', $request->id)
            ->where('business_id', $request->business_id)
            ->first();
        if ($gatepass) {
            return ReturnHelpers::jsonApiReturnSecond(GatepassRequestResources::collection([RequestGatepassList::find($gatepass->id)])->all(), 1);
        } else {
            return response()->json(['result' => [], 'case' => 2, 'status' => false], 404);
        }
    }


    public function gatepassMonthFilterData(Request $request)
    {
        // return 'chal bhai';
        // $month
        $gatepass = RequestGatepassList::where('business_id', $request->business_id)
            ->whereRaw('MONTH(date) = ?', [$month])
            ->get();
        if ($gatepass) {
            return ReturnHelpers::jsonApiReturnSecond(GatepassRequestResources::collection([RequestGatepassList::find($gatepass->id)])->all(), 1);
        } else {
            return response()->json(['result' => [], 'case' => 2, 'status' => false], 404);
        }
    }

    // public function show($id)
    // {
    //     $data = RequestGatepassList::where($id);
    //     if ($data) {
    //         return ReturnHelpers::jsonApiReturn(GatepassRequestResources::collection([$data])->all());
    //     } else {
    //         return response()->json(['result' => [], 'status' => false], 404);
    //     }
    // }


    public function gatepassupdate(Request $request)
    {
        $id = $request->id;
        $business_id = $request->business_id;
        $emp_id = $request->emp_id;
        $data = RequestGatepassList::where('business_id', $business_id)->where('emp_id', $emp_id)->where('id', $id)->first();
        if ($data) {
            if ($data->forward_by_status == 0 && $data->final_status == 0 && $data->process_complete == 0) {
                $data->id = $request->id ?? $data->id;
                $data->business_id = $request->business_id ?? $data->business_id;
                $data->emp_id = $request->emp_id ?? $data->emp_id;
                $data->date = $request->date ?? $data->date;
                $data->going_through = $request->going_through ?? $data->going_through;
                $data->in_time = $request->in_time ?? $data->in_time;
                $data->out_time = $request->out_time ?? $data->out_time;
                $data->source = $request->source ?? $data->source;
                $data->destination = $request->destination ?? $data->destination;
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
        return response()->json(['result' => [], 'status' => false], 404);
    }


    public function destroy(Request $request)
    {
        $data = RequestGatepassList::where('business_id', $request->business_id)->where('emp_id', $request->emp_id)->where('id', $request->id)->first();
        if ($data) {
            if ($data->forward_by_status == 0 && $data->final_status == 0 && $data->process_complete == 0) {
                $data->delete();
                return response()->json(['result' => true, 'status' => true, 'case' => 1], 200);
            } else {
                return response()->json(['result' => 'You cannot delete your request, your request is a process you can not delete it.', 'status' => false, 'case' => 2], 201);
            }
        } else {
            return response()->json(['result' => [], 'status' => false, 'case' => 3], 404);
        }
    }

    public function currentStatusGatePassRequest(Request $request)
    {
        $goto = DB::table('request_gatepass_list')
            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_gatepass_list.id')
            ->join('policy_setting_role_create', 'approval_status_list.role_id', '=', 'policy_setting_role_create.id')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->leftJoin('employee_personal_details', 'approval_status_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->leftJoin('business_details_list', 'approval_status_list.business_id', '=', 'business_details_list.business_id')
            ->where('request_gatepass_list.id', $request->id) //primary id
            ->where('approval_status_list.approval_type_id', $request->approval_type) //leave type 2
            ->where('approval_status_list.business_id', $request->business_id)
            ->where('policy_setting_role_create.business_id', $request->business_id)
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
            // return $goto;

            return response()->json(['result' => CurrentGatePassRequestStatus::collection($goto)->all(), 'case' => 1, 'status' => true], 200); // case 3 when the employee not found
            // return ReturnHelpers::jsonApiReturnSecond([CurrentAttendanceRequestStatus::collection($goto)->all(), 1],200); // case 1 when the leave date find
        } else {
            return response()->json(['result' => [], 'case' => 2, 'status' => false], 404); // case 3 when the employee not found
        }
    }
}
