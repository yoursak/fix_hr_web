<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeePersonalDetail;
use App\Models\RequestMispunchList;
use App\Models\PolicyAttenRuleMisspunch;
use App\Models\StaticMisPunchTimeType;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\UserSideResponse\MispunchRequestResources;
use App\Http\Resources\Api\UserSideResponse\MispunchStaticTimeTypeResources;
use App\Models\ApprovalManagementCycle;

// use App\Http\Resources\Api\MispunchRequestResources;
use Carbon\Carbon;
use App\Http\Resources\Api\UserSideResponse\UserMispunchIdToDataResources;
use DB;

class MispunchApiController extends Controller
{
    // static table time type data
    public function staticMispunchTimeType()
    {
        $data = StaticMisPunchTimeType::get();
        return ReturnHelpers::jsonApiReturn(MispunchStaticTimeTypeResources::collection($data)->all()); // case 1 when the gatepass date find
    }

    // mispunch data list custome month requested
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

    // misspunch store data
    public function store(Request $request)
    {
        $business_id = $request->business_id;
        $emp_id = $request->emp_id;
        $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
        $currentYear = $requestDate;
        $currentMonth = $requestDate;
        $load = 0;

        if ($business_id != null && $emp_id != null) {
            $checkAutomation = PolicyAttenRuleMisspunch::where('business_id', $business_id)->first();
            if ($checkAutomation->switch_is == 1) {
                $emp = EmployeePersonalDetail::where('business_id', $business_id)
                    ->where('emp_id', $emp_id)
                    ->first();
                if (isset($emp)) {
                    // why type = 2 leave for  using approval system checking actived
                    $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $emp->business_id)
                        ->where('approval_type_id', 3)
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

                    $checkOccurrence = RequestMispunchList::where('emp_id', $emp_id)
                        ->where('business_id', $business_id)
                        ->whereYear('emp_miss_date', '=', $requestDate)
                        ->whereMonth('emp_miss_date', '=', $requestDate)
                        ->select('id')
                        ->count();

                    if ($checkAutomation->occurance_count > $checkOccurrence) {
                        $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
                        $data = new RequestMispunchList();
                        $data->business_id = $emp->business_id;
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
                            // return $data;
                            return ReturnHelpers::jsonApiReturnSecond(MispunchRequestResources::collection([RequestMispunchList::find($data->id)])->all(), 1); // case 1 when the gatepass date store
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
                $data = new RequestMispunchList();
                $data->business_id = $emp->business_id;
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
                    // return $data;
                    return ReturnHelpers::jsonApiReturnSecond(MispunchRequestResources::collection([RequestMispunchList::find($data->id)])->all(), 1); // case 1 when the gatepass date store
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
            ->where('emp_id', $emp_id)
            ->where('id', $id)
            ->first();
        if ($data) {
            if ($data->forward_by_status == 0 && $data->final_status == 0 && $data->process_complete == 0) {
                $data->id = $request->id ?? $data->id;
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
                return response()->json(['result' => true, 'status' => true, 'case' => 1]);
            } else {
                return response()->json(['result' => 'You cannot delete your request, your request is under process you can not delete it.', 'status' => false, 'case' => 2]);
            }
        } else {
            return response()->json(['result' => [], 'status' => false, 'case' => 3], 404);
        }
    }
}
