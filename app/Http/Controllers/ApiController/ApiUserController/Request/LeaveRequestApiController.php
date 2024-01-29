<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Request;

use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeePersonalDetail;
use App\Models\RequestLeaveList;
use App\Models\StaticLeaveShiftType;
use App\Models\StaticRequestLeaveType;
use App\Models\PolicySettingLeavePolicy;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\UserSideResponse\LeaveRequestResources;
use DB;
use App\Http\Resources\Api\UserSideResponse\StaticLeaveShiftTypeResources;
use App\Http\Resources\Api\UserSideResponse\LeaveCategoryResources;
use App\Http\Resources\Api\UserSideResponse\StaticRequestLeaveTypeResources;
use App\Http\Resources\Api\UserSideResponse\UserLeaveIdToDataResources;
use App\Http\Resources\Api\UserSideResponse\CurrentLeaveRequestStatus;
use App\Http\Resources\Api\UserSideResponse\LeaveBalanceListReport;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicyMasterEndgameMethod;
use Carbon\Carbon;
use App\Models\AttendanceList;
use App\Models\ApprovalManagementCycle;
use App\Models\PolicySettingLeaveCategory;

class LeaveRequestApiController extends Controller
{
    public function index()
    {
        $leave = LeaveRequestList::all();
        return ReturnHelpers::jsonApiReturn(LeaveRequestResources::collection($leave)->all());
    }

    // static table shift type
    public function staticLeaveShiftType()
    {
        $data = StaticLeaveShiftType::get();
        return ReturnHelpers::jsonApiReturn(StaticLeaveShiftTypeResources::collection($data)->all());
    }

    // static table requestLeaveType
    public function staticRequestLeaveType()
    {
        $data = StaticRequestLeaveType::get();
        return ReturnHelpers::jsonApiReturn(StaticRequestLeaveTypeResources::collection($data)->all());
    }

    // dynamic custome leave category
    public function policySettingLeaveCategory(Request $request)
    {
        $empId = $request->emp_id;
        $business = $request->business_id;

        //Disabled hide value 1 and show 0
        $data = DB::table('policy_setting_leave_policy')
            ->join('policy_master_endgame_method', 'policy_master_endgame_method.leave_policy_ids_list', '=', 'policy_setting_leave_policy.id')
            ->join('employee_personal_details', 'policy_master_endgame_method.id', 'employee_personal_details.master_endgame_id')
            ->join('policy_setting_leave_category', 'policy_setting_leave_category.leave_policy_id', '=', 'policy_setting_leave_policy.id')
            ->join('static_leave_category', 'static_leave_category.id', '=', 'policy_setting_leave_category.category_name')
            ->where('policy_setting_leave_category.business_id', '=', $business)
            ->where('employee_personal_details.emp_id', '=', $empId)
            ->select('static_leave_category.id', 'static_leave_category.name', 'employee_personal_details.emp_gender')
            ->get();

        // RulesManagement::

        $showHide = AttendanceList::where('leave_type_category', 8)
            ->where('emp_id', $empId)
            ->count();

        // static list
        $additionalData = [
            // static list additional added
            (object) [
                'id' => 8,
                'name' => 'Comp-Off (CO)',
                'disabled' => $showHide != 0 ? 1 : 0,
            ],
            (object) ['id' => 9, 'name' => 'Leave Without Pay (LWP) / (LOP)', 'disabled' => 0],
        ];

        if ($data->isNotEmpty()) {
            $mergedData = collect($data)
                ->reject(function ($item) {
                    return (($item->emp_gender === 1 || $item->emp_gender === 3) && $item->id === 4) || ($item->emp_gender === 2 && $item->id === 5);
                })
                ->merge($additionalData);

            return ReturnHelpers::jsonApiReturn(LeaveCategoryResources::collection($mergedData)->all());
        }

        return response()->json(['result' => [], 'status' => false], 404);
    }

    // modified leave request
    public function store(Request $request)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $request->emp_id)->first();
        $load = 0;

        if (isset($emp)) {
            // why type = 2 leave for  using approval system checking actived
            $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $emp->business_id)
                ->where('approval_type_id', 2)
                ->first();
            if ($approvalManagementCycle != null) {
                $roleIds = json_decode($approvalManagementCycle->role_id, true);
                $firstRoleId = $roleIds[0] ?? null;
                $lastRoleId = end($roleIds);

                $leave = new RequestLeaveList();
                $leave->business_id = $emp->business_id;
                $leave->emp_id = $emp->emp_id;
                $leave->leave_type = $request->leave_type;
                $leave->leave_category = $request->leave_category != null ? $request->leave_category : '0';
                $leave->shift_type = $request->shift_type != null ? $request->shift_type : '0';
                $leave->from_date = $request->from_date;
                $leave->to_date = $request->to_date;
                $leave->days = $request->days;
                $leave->apply_date = Carbon::now()->format('Y-m-d');
                $leave->reason = $request->reason;
                $leave->forward_by_role_id = $firstRoleId ?? 0;
                $leave->forward_by_status = 0;
                $leave->final_level_role_id = $lastRoleId ?? 0;
                $leave->final_status = 0;
                $leave->process_complete = 0;
                $leave->final_status = 0;
                $leave->leave_remaining = (float) $request->leave_remaining;
                $leave->leave_summary_debit_value = (float) $request->leave_summary_debit_value;
                $leave->leave_summary_unpaid_value = (float) $request->leave_summary_unpaid_value;
                if ($request->hasFile('image')) { //file document
                    // Handle image upload
                    $image = $request->file('image');
                    $imageName = time() . '_' . now()->format('d-m-y') . '_' . $image->getClientOriginalName();
                    // $image->storeAs('images', $imageName, 'public');
                    $image->move(public_path('leave_document'), $imageName);

                    // Add the image path to the $leave model
                    $leave->documents = 'leave_document/' . $imageName;
                }
                if ($leave->save()) {
                    return ReturnHelpers::jsonApiReturn(UserLeaveIdToDataResources::collection([RequestLeaveList::find($leave->id)])->all());
                }
                // return response()->json(['result' => [$request->all()], 'status' => true], 200);
            }
            return response()->json(['result' => [], 'status' => false], 404);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    // modified list filter
    public function leaveDataList(Request $request)
    {
        $EmpID = $request->emp_id;
        $business_id = $request->business_id;
        $FindMonthYear = $request->date;

        if ($EmpID != null && $business_id != null && $FindMonthYear != null) {
            $emp = DB::table('employee_personal_details')
                ->where('emp_id', $EmpID)
                ->where('business_id', $business_id)
                ->first();
            $checkingEndgameMethod = PolicyMasterEndgameMethod::where('business_id', $business_id)
                ->where('id', $emp->master_endgame_id)
                ->where('method_switch', 1)
                ->first();


            if (isset($emp) && isset($checkingEndgameMethod)) {
                $leave = RequestLeaveList::leftJoin('static_leave_category', 'static_leave_category.id', '=', 'request_leave_list.leave_category')
                    ->leftJoin('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
                    ->leftJoin('static_leave_shift_type', 'static_leave_shift_type.id', 'request_leave_list.shift_type')
                    ->where(function ($query) use ($FindMonthYear) {
                        if (!empty($FindMonthYear)) {
                            $year = substr($FindMonthYear, 0, 4); // Extract the year (e.g., '2023')
                            $month = substr($FindMonthYear, 5, 2); // Extract the month (e.g., '11')
                            $query->whereYear('request_leave_list.from_date', $year)->whereMonth('request_leave_list.from_date', $month);
                        }
                    })
                    ->where('request_leave_list.business_id', $business_id)
                    ->where('request_leave_list.emp_id', $EmpID)
                    ->orderBy('request_leave_list.id','desc')
                    ->select('request_leave_list.*', 'static_leave_category.name as leave_category', 'static_request_leave_type.leave_day as leave_day', 'static_leave_shift_type.leave_shift_type as leave_shift_type')
                    ->get();

                if (count($leave) != 0) {
                    return ReturnHelpers::jsonApiReturnSecond(LeaveRequestResources::collection($leave)->all(), 1); // case 1 when the leave date find
                } else {
                    return response()->json(['result' => [], 'case' => 2, 'status' => true]); // case 2 when the employee leave request record not found
                }
            } else {
                return response()->json(['result' => [], 'case' => 3, 'status' => false], 404); // case 3 when the employee not found
            }
        } else {
            return response()->json(['result' => [], 'case' => 4, 'status' => false], 404); // case 4 when the rquired field is null
        }
    }
    public function currentStatusLeaveRequest(Request $request)
    {
        $goto = DB::table('request_leave_list')
            ->leftJoin('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_leave_list.id')
            ->leftJoin('policy_setting_role_create', 'approval_status_list.role_id', '=', 'policy_setting_role_create.id')
            ->leftJoin('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->leftJoin('employee_personal_details', 'approval_status_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->leftJoin('business_details_list', 'approval_status_list.business_id', '=', 'business_details_list.business_id')
            ->where('request_leave_list.id', $request->id) //primary id
            ->where('approval_status_list.approval_type_id', $request->approval_type) //leave type 2
            ->where('approval_status_list.business_id', $request->business_id)
            // ->where('policy_setting_role_create.business_id', $request->business_id)
            ->select(
                'approval_status_list.*',
                // 'policy_setting_role_create.roles_name',
                DB::raw('CASE WHEN approval_status_list.role_id = 1 THEN "Owner" ELSE policy_setting_role_create.roles_name END AS roles_name'),
                'static_status_request.request_response',
                DB::raw('CASE WHEN approval_status_list.role_id = 1 THEN business_details_list.client_name ELSE employee_personal_details.emp_name END AS first_name'),
                // 'employee_personal_details.emp_name as first_name',
                'employee_personal_details.emp_mname as middle_name',
                'employee_personal_details.emp_lname as last_name'
            )
            ->get();
        if (isset($goto)) {
            // return $goto;
            return ReturnHelpers::jsonApiReturnSecond(CurrentLeaveRequestStatus::collection($goto)->all(), 1); // case 1 when the leave date find
        } else {
            return response()->json(['result' => [], 'case' => 3, 'status' => false], 404); // case 3 when the employee not found
        }
    }
    public function leaveBalanceList(Request $request)
    {
        $empId = $request->emp_id;
        $business = $request->business_id;
        $emp = EmployeePersonalDetail::where('emp_id', $empId)
            ->where('business_id', $business)
            ->first();

        if ($emp != null) {
            $getData = PolicySettingLeavePolicy::where('policy_setting_leave_policy.business_id', $business)
                ->leftJoin('policy_master_endgame_method', 'policy_setting_leave_policy.id', '=', 'policy_master_endgame_method.leave_policy_ids_list')
                ->where('policy_master_endgame_method.method_switch', 1)
                ->where('policy_setting_leave_policy.business_id', $business)
                ->select('policy_setting_leave_policy.*')
                ->first();

            if ($getData != null) {
                $Item = PolicySettingLeaveCategory::where('business_id', $business)
                    ->leftJoin('static_leave_category', 'policy_setting_leave_category.category_name', '=', 'static_leave_category.id')
                    ->leftJoin('static_leave_category_applicable_to', 'policy_setting_leave_category.applicable_to', '=', 'static_leave_category_applicable_to.id')
                    ->where('leave_policy_id', $getData->id)
                    ->select('policy_setting_leave_category.*', 'static_leave_category.name as apply_category_name', 'static_leave_category_applicable_to.name as applicable_name')
                    ->get();

                $applyLeaveRequests = RequestLeaveList::where('business_id', $business)
                    ->where('emp_id', $empId)
                    ->get();

                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;
                $LoadPolicyCase = [];
                $StoreModel = [];
                foreach ($Item as $key => $requests) {
                    $DOJ = Carbon::parse($emp->emp_date_of_joining);

                    // Calculate the start and end dates for the previous year
                    $previousYearStart = Carbon::now()
                        ->subYear()
                        ->startOfYear();
                    $previousYearEnd = Carbon::now()
                        ->subYear()
                        ->endOfYear();

                    // previous mode
                    $previousLeaveTaken = $applyLeaveRequests
                        ->where('leave_category', $requests->category_name)
                        ->filter(function ($request) use ($previousYearStart, $previousYearEnd) {
                            $requestDate = Carbon::parse($request->from_date);
                            return $requestDate->between($previousYearStart, $previousYearEnd);
                        })
                        ->sum('days');

                    // sensitive
                    $cycleLimitFrom = Carbon::parse($getData->temp_from);
                    $cycleLimitTo = Carbon::parse($getData->temp_to);

                    $monthsCount = 0;
                    $leaveAllotted = 0;
                    $leaveTaken = 0;
                    $leaveRemaining = 0;
                    $lwpDays = 0;

                    for ($date = $cycleLimitFrom; $date->lessThanOrEqualTo($cycleLimitTo); $date->addMonth()) {
                        $month = $date->month;
                        $year = $date->year;

                        if ($year < $currentYear || ($year === $currentYear && $month <= $currentMonth)) {
                            $monthsCount++;
                            // current mode request list
                            $leaveTaken = $applyLeaveRequests
                                ->where('leave_category', $requests->category_name)
                                ->filter(function ($request) use ($currentMonth, $DOJ) {
                                    $requestDate = Carbon::parse($request->from_date);
                                    // start doj year only and accept in status only request and accept status
                                    return $requestDate->month === $currentMonth && $requestDate->year >= $DOJ->year && ($request->final_status === 0 || $request->final_status === 1);
                                })
                                ->sum('days');

                            $leaveAllotted += $requests->days;

                            // Unused Leave Rule Set Show Restriction
                            $ruleType = $requests->unused_leave_rule;
                            if ($ruleType === 2) {
                                $openingBalance = $leaveAllotted - $previousLeaveTaken;
                                $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining];
                                // Apply carry forward limit logic to the opening balance
                            }
                            if ($ruleType === 1) {
                                // Lapse set logic (if needed)
                                $openingBalance = 0;
                                $leaveRemaining = $leaveAllotted - $leaveTaken;
                                $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining];
                            }
                            // Gender Restriction with category Show Hide
                            if (($emp->emp_gender === 1 || $emp->emp_gender === 3) && $requests->category_name === 4) {
                                //Restriction Paternity leave (PL)
                                continue; // Skip if the employee is male and the category is not maternity
                            }
                            if ($emp->emp_gender === 2 && $requests->category_name === 5) {
                                //Restriction Maternity leave (ML)
                                continue; // Skip if the employee is female and the category is not paternity
                            }

                            // 'information' => $Item->where('category_name', $requests->category_name)->first(),
                            $LoadPolicyCase[$key] = [
                                'current_month' => $monthsCount,
                                'leave_policy_id' => $requests->leave_policy_id,
                                'business_id' => $requests->business_id,
                                'policy_type_id' => $requests->category_name, //category_id
                                'policy_category_name' => $requests->apply_category_name, //category_name
                                'policy_monthly_cycle' => $requests->leave_cycle_monthly_yearly,
                                'policy_days' => $requests->days,
                                'policy_unused_leave_rule' => $requests->unused_leave_rule,
                                'policy_carry_forward_limit' => $requests->carry_forward_limit,
                                'policy_applicable_to_gender_id' => $requests->applicable_to, //gender ID
                                'policy_applicable_to_gender_name' => $requests->applicable_name, //gender name
                                'leave_opening' => $StoreModel[0],
                                'leave_allotted' => $StoreModel[1],
                                'leave_taken' => $StoreModel[2],
                                'leave_remaining' => $StoreModel[3],
                            ];
                            // Push the data for this leave type into $LoadPolicyCase
                            // $LoadPolicyCase[] = $leaveTypeData;
                        }
                    }
                }

                // add external Like : LWP or Comp OFF
                $externalData = [
                    [
                        'current_month' => 0,
                        'leave_policy_id' => 0,
                        'business_id' => $requests->business_id,
                        'policy_type_id' => 9, //category_id
                        'policy_category_name' => 'Leave Without Pay (LWP)', //category_name
                        'policy_monthly_cycle' => 0,
                        'policy_days' => 0,
                        'policy_unused_leave_rule' => 0,
                        'policy_carry_forward_limit' => 0,
                        'policy_applicable_to_gender_id' => 0, //gender ID
                        'policy_applicable_to_gender_name' => 0, //gender name
                        'leave_opening' => 0,
                        'leave_allotted' => 0,
                        'leave_taken' => $lwpDays,
                        'leave_remaining' => 0,
                    ],
                    [
                        'current_month' => 0,
                        'leave_policy_id' => 0,
                        'business_id' => $requests->business_id,
                        'policy_type_id' => 8, //category_id
                        'policy_category_name' => 'Comp-Off (CO)', //category_name
                        'policy_monthly_cycle' => 0,
                        'policy_days' => 0,
                        'policy_unused_leave_rule' => 0,
                        'policy_carry_forward_limit' => 0,
                        'policy_applicable_to_gender_id' => 0, //gender ID
                        'policy_applicable_to_gender_name' => 0, //gender name
                        'leave_opening' => 0,
                        'leave_allotted' => 0,
                        'leave_taken' => 0,
                        'leave_remaining' => 0,
                    ],
                    // Add more external data as needed
                ];
                $data = array_merge($LoadPolicyCase, $externalData);
                return response()->json(['result' => $data, 'status' => true, 'case' => 1], 200);
            } else {
                return response()->json(['result' => [], 'status' => false, 'case' => 2], 201);
            }
        }
    }

    // public function leaveBalanceList(Request $request)
    // {
    //     $empId = $request->emp_id;
    //     $business = $request->business_id;
    //     $emp = EmployeePersonalDetail::where('emp_id', $empId)->where('business_id', $business)->first();
    //     if ($emp) {
    //         // ->leftJoin('policy_setting_leave_category',  'policy_setting_leave_policy.id', '=', 'policy_setting_leave_category.leave_policy_id')
    //         $getData = PolicySettingLeavePolicy::where('policy_setting_leave_policy.business_id', $business)
    //             ->leftJoin('policy_master_endgame_method', 'policy_setting_leave_policy.id', '=', 'policy_master_endgame_method.leave_policy_ids_list')
    //             ->where('policy_master_endgame_method.method_switch', 1)
    //             ->where('policy_setting_leave_policy.business_id', $business)
    //             ->select('policy_setting_leave_policy.*')
    //             ->first();

    //         if ($getData) {

    //             $Item = PolicySettingLeaveCategory::where('business_id', $business)
    //                 ->leftJoin('static_leave_category', 'policy_setting_leave_category.category_name', '=', 'static_leave_category.id')
    //                 ->where('leave_policy_id', $getData->id)
    //                 ->get();
    //             $applyLeaveRequests = RequestLeaveList::where('business_id', $business)
    //                 ->where('emp_id', $empId)
    //                 ->get();

    //             $cycleLimitFrom = Carbon::parse($getData->temp_from);
    //             $cycleLimitTo = Carbon::parse($getData->temp_to);

    //             // Calculate the difference in months
    //             $leave_allotted_level = 0;
    //             $monthsCount = 0;
    //             $year = Carbon::now()->year;
    //             $cycleLimitFrom = Carbon::parse($getData->temp_from);
    //             $cycleLimitTo = Carbon::parse($getData->temp_to);
    //             // Case 1
    //             // Count the months between the two dates, starting from January 1st of $cycleLimitFrom's year
    //             // $monthsDifference = $cycleLimitFrom->diffInMonths($cycleLimitTo, false);
    //             // // Add 1 to include the first month (January)
    //             // $monthsCount = $monthsDifference + 1;

    //             // Case 2
    //             $currentMonth = Carbon::now()->month;
    //             $currentYear = Carbon::now()->year;

    //             foreach ($Item as $key => $requests) {

    //                 $DOJ = Carbon::parse($emp->emp_date_of_joining);

    //                 // // Present status
    //                 $applyLeaveRequest = $applyLeaveRequests
    //                     ->where('leave_category', $requests->category_name)
    //                     ->filter(function ($request) use ($currentMonth, $currentYear, $DOJ) {
    //                         $requestDate = Carbon::parse($request->from_date); // Replace 'your_date_field' with your request date field
    //                         // Check if the request month is the current month and its year is greater or equal to the DOJ's year
    //                         return $requestDate->month === $currentMonth && $requestDate->year >= $DOJ->year;
    //                     });

    //                 $leave_taken = $applyLeaveRequest->sum('days');

    //                 // Calculate the start and end dates for the previous year
    //                 $previousYearStart = Carbon::now()->subYear()->startOfYear();
    //                 $previousYearEnd = Carbon::now()->subYear()->endOfYear();

    //                 // Calculate opening balance based on leave requests between specific dates for the previous year
    //                 $previousLeaveTaken = $applyLeaveRequests
    //                     ->where('leave_category', $requests->category_name)
    //                     ->filter(function ($request) use ($previousYearStart, $previousYearEnd) {
    //                         $requestDate = Carbon::parse($request->from_date);
    //                         return $requestDate->between($previousYearStart, $previousYearEnd); // Filter for the previous year within the specific dates
    //                     })
    //                     ->sum('days');

    //                 // Iterate through each month within the date range
    //                 for ($date = $cycleLimitFrom; $date->lessThanOrEqualTo($cycleLimitTo); $date->addMonth()) {
    //                     $month = $date->month;
    //                     $year = $date->year;
    //                     $openingBalance = 0;
    //                     $leave_allotted_level = 0;
    //                     $leave_remaining = 0;

    //                     // Check if the current month is within the specified range
    //                     if ($year < $currentYear || ($year === $currentYear && $month <= $currentMonth)) {
    //                         // Calculate opening balance for the current year
    //                         $monthsCount += 1;
    //                         $leave_allotted_level += $request->days;
    //                         $openingBalance = $leave_allotted_level - $previousLeaveTaken;
    //                         $leave_remaining = ($openingBalance != null && $openingBalance != 0) ? $openingBalance + ($leave_allotted_level - $leave_taken) : $leave_allotted_level - $leave_taken;

    //                     }
    //                 }

    //                 // // Calculate opening balance for the previous year
    //                 // $previousYearLeaveTaken = $applyLeaveRequests
    //                 //     ->where('leave_category', $requests->category_name)
    //                 //     ->filter(function ($request) use ($DOJ) {
    //                 //         return Carbon::parse($request->from_date)->year === ($DOJ->year - 1);
    //                 //     })
    //                 //     ->sum('days');

    //                 // // Deduct the leave taken in the previous year from the total allotted leave
    //                 // $openingCaseHandling = $leave_allotted - $previousYearLeaveTaken;

    //                 // allotted-taken = remaining
    //                 $LoadPolicyCase[$key] = [
    //                     'type_policy' => $requests->category_name,
    //                     'current_month' => $monthsCount,
    //                     'information' => $Item->where('category_name', $requests->category_name)->first(),
    //                     'opening' => $openingBalance,
    //                     'leave_allotted' => $leave_allotted_level,
    //                     'leave_taken' => $leave_taken,
    //                     'leave_remaining' => $leave_remaining //$leave_allotted - $leave_taken,

    //                 ];

    //                 // Merge additional data into the current policy
    //                 // $LoadPolicyCase[$key] = array_merge($data[$key], ['additional_data' => $additionalData]);
    //             }

    //             // 'LeaveBalanceReportYearly' => $yearlyRemaining,
    //             //  'result' => $Item, $applyLeaveRequest
    //             return response()->json(['LeaveBalanceReportMonthly' => $LoadPolicyCase], 200);
    //         }
    //     }
    // }

    // static public function customLeavePolicyRule($typeCycle)
    // {
    //     //Monthly or Yearly
    //     switch ($typeCycle) {
    //         case 1:

    //         case 2:
    //     }

    // }

    public function show($id)
    {
        $data = LeaveRequestList::find($id);
        if ($data) {
            return ReturnHelpers::jsonApiReturn(LeaveRequestResources::collection([$data])->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    public function leaveUpdate(Request $request)
    {
        $id = $request->id;
        $businessId = $request->business_id;
        $EmpID = $request->emp_id;
        $leave = RequestLeaveList::join('policy_setting_leave_category', 'policy_setting_leave_category.id', '=', 'request_leave_list.leave_category')
            ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
            ->where('request_leave_list.id', $id)
            ->where('request_leave_list.business_id', $businessId)
            ->where('request_leave_list.emp_id', $EmpID)
            ->select('request_leave_list.*', 'policy_setting_leave_category.category_name', 'static_request_leave_type.leave_day')
            ->first();
        if ($leave) {
            if ($leave->forward_by_status == 0 && $leave->final_status == 0 && $leave->process_complete == 0) {
                $leave->id = $request->id ?? $leave->id;
                $leave->business_id = $request->business_id ?? $leave->business_id;
                $leave->emp_id = $request->emp_id ?? $leave->emp_id;
                $leave->leave_type = $request->leave_type ?? $leave->leave_type;
                $leave->leave_category = $request->leave_category ?? $leave->leave_category;
                $leave->shift_type = $request->shift_type ?? $leave->shift_type;
                $leave->from_date = $request->from_date ?? $leave->from_date;
                $leave->to_date = $request->to_date ?? $leave->to_date;
                $leave->reason = $request->reason ?? $leave->reason;
                $leave->days = $request->days ?? $leave->days;
                $leave->forward_by_role_id = $request->forward_by_role_id ?? $leave->forward_by_role_id;
                $leave->forward_by_status = $request->forward_by_status ?? $leave->forward_by_status;
                $leave->final_level_role_id = $request->final_level_role_id ?? $leave->final_level_role_id;
                $leave->final_status = $request->final_status ?? $leave->final_status;
                $leave->process_complete = $request->process_complete ?? $leave->process_complete;
                $submit = $leave->update();
                if ($submit) {
                    return response()->json(['result' => [], 'status' => true, 'case' => 1]); // case 1 update
                }
                return response()->json(['result' => [], 'status' => false, 'case' => 2]); // case 2 not update
            }
            return response()->json(['result' => [], 'status' => false, 'case' => 3]); // case 3 when the action perform
        }
        return response()->json(['result' => [], 'status' => false, 'case' => 4], 404); // case 4 when the data not found
    }

    public function destroy(Request $request)
    {
        $leave = RequestLeaveList::where('business_id', $request->business_id)
            ->where('emp_id', $request->emp_id)
            ->where('id', $request->id)
            ->first();
        if ($leave) {
            if ($leave->forward_by_status == 0 && $leave->final_status == 0 && $leave->process_complete == 0) {
                $leave->delete();
                return response()->json(['result' => 'Delete Successfuly', 'status' => true, 'case' => 1], 200);
            } else {
                return response()->json(['result' => 'You cannot delete your request, your request is a process you can not delete it.', 'status' => false, 'case' => 2], 200);
            }
        } else {
            return response()->json(['result' => [], 'status' => false, 'case' => 3], 404);
        }
    }
}
