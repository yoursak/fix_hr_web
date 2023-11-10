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
                if ($emp) {
                    $checkOccurrence = RequestGatepassList::where('emp_id', $emp_id)
                    ->where('business_id', $business_id)
                    ->whereYear('date', '=', $currentYear)
                    ->whereMonth('date', '=', $currentMonth)
                    ->select('id')
                    ->count();
                    // dd(gettype($checkAutomation->occurance_count), gettype($checkOccurrence));
                        // dd($checkOccurrence, $checkAutomation->occurance_count);
                    if ($checkAutomation->occurance_count > $checkOccurrence) {
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
                        $data->status = 0;
                        if ($data->save()) {
                            return ReturnHelpers::jsonApiReturnSecond(GatepassRequestResources::collection([RequestGatepassList::find($data->id)])->all(), 1); // case 1 when the gatepass date store
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
                // return 'case 5 gatepass switch off';
                return response()->json(['result' => [], 'case' => 5, 'status' => false]); // case 5 gatepass switch off
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

    public function update(Request $request, $id)
    {
        $data = RequestGatepassList::find($id);
        if ($data) {
            $data->business_id = $request->business_id ?? $data->business_id;
            $data->branch_id = $request->branch_id ?? $data->branch_id;
            $data->department_id = $request->department_id ?? $data->department_id;
            $data->designation_id = $request->designation_id ?? $data->designation_id;
            $data->emp_id = $request->emp_id ?? $data->emp_id;
            $data->emp_name = $request->emp_name ?? $data->emp_name;
            $data->emp_mobile_no = $emp->emp_mobile_number ?? $data->emp_mobile_no;
            $data->date = $request->date ?? $data->date;
            $data->going_through = $request->going_through ?? $data->going_through;
            $data->in_time = $request->in_time ?? $data->in_time;
            $data->out_time = $request->out_time ?? $data->out_time;
            $data->reason = $request->reason ?? $data->reason;
            $data->status = $request->status ?? $data->status;
            if ($data->update()) {
                return ReturnHelpers::jsonApiReturn(GatepassRequestResources::collection([RequestGatepassList::find($data->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function destroy(Request $request)
    {
        // return $request->all();
        $data = RequestGatepassList::find($request->id);
        $data = $data->where('status', '=', 0)->first();
        return $data;
        if ($data) {
            $data->delete();
            return response()->json(['result' => true, 'status' => true]);
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }
}
