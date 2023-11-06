<?php

namespace App\Http\Controllers\admin\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use Carbon\Carbon;
use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\RequestGatepassList;
use App\Models\StaticMissPunchTimeType;
use App\Models\RequestLeaveList;
use App\Models\RequestMispunchList;
// use App\Models\RequestMispunchList;  
use RealRashid\SweetAlert\Facades\Alert;
use DateTime;
use DB;
use Session;

class RequestController extends Controller
{
    // gatepass home page
    public function gatepass()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $going_through = DB::table('static_going_through_type')->get();
        $DATA = RequestGatepassList::join('employee_personal_details', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('request_gatepass_list.business_id', Session::get('business_id'))
            ->select('request_gatepass_list.*', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.designation_id', 'employee_personal_details.emp_mobile_number')
            ->orderBy('request_gatepass_list.id', 'DESC')
            ->get();
        $root = compact('moduleName', 'permissions', 'DATA', 'going_through');
        return view('admin.request.gatepass', $root);
    }

    // delete gatepass detail
    public function DestroyGatepass(Request $request)
    {
        $data = RequestGatepassList::where('id', $request->id)
            ->delete();
        if ($data) {
            Alert::error('Not Updated', 'Your Gatepass Detail Delete is Fail');
        }
        return back();
    }

    // gatepas approve
    public function ApproveGatepass(Request $request)
    {
        // dd($request->all());
        if ($request->has('id') && $request->has('in_time') && $request->has('approve')) {
            $gatepass = RequestGatepassList::where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['out_time' => $request->out_time, 'in_time' => $request->in_time, 'status' => $request->approve]);
            Alert::success('Your Gatepass Request has been Approve Successfully');
            return back();
        } elseif ($request->has('id') && $request->has('in_time') && $request->has('submit') && $request->has('remark')) {
            $gatepass = RequestGatepassList::where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['status' => $request->submit, 'remark' => $request->remark]);
            Alert::success('Your Gatepass Request has been Decline Successfully');
            return back();
        } else {
            Alert::error('Not Updated', 'Your Gatepass Detail Updation is Fail');
            return back();
        }
    }

    public function ApproveLeave(Request $request)
    {
        $FindRoleID = RulesManagement::PassBy()[3];
        $EmpID = RulesManagement::PassBy()[2];
        $ApprovalManagement = RulesManagement::ApprovalGetDetails(2, (string)$FindRoleID)[0]; //show hidden
        if (isset($ApprovalManagement)) {

            // $allRoleList=$ApprovalManagement->role_id;//$request->has('id') && $request->has('leave_type') && $request->has('from_date') && $request->has('to_date') && $request->has('days') && $request->has('submit') && 
            if ($request->has('approve')) {
                $gatepass = RequestLeaveList::where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['leave_type' => $request->time_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $request->days, 'approved_by_role_id' => json_encode($FindRoleID), 'approved_by_emp_id' => json_encode($EmpID), 'approved_by_status' => json_encode('1'), 'status' => $request->approve]);
                
                Alert::success('Your Leave Request has been Approve Successfully');
                // dd($request->all(), $FindRoleID, $EmpID, $ApprovalManagement);

                return back();
            } else if ($request->has('remark')) {
                $gatepass = RequestLeaveList::where('id', $request->id)
                    ->where('business_id', Session::get('business_id'))
                    ->update(['leave_type' => $request->time_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $request->days, 'remark' => $request->remark, 'status' => $request->submit]);
                Alert::success('Your Gatepass Request has been Decline Successfully');
                // , 'Updated  Created'
                return back();
            } else {
                Alert::error('Not Updated', 'Your Leave Request Detail Updating is Fail');
                return back();
            }
        }
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
    }

    public function ApproveMispunch(Request $request)
    {
        $attendance = DB::table('attendance_list')->where('emp_id', $request->emp_id)->where('punch_date', $request->date)->get();
        dd($attendance);
        if ($request->has('id') && $request->has('time_type') && $request->has('in_time') && $request->has('out_time') && $request->has('approve')) {
            $mispunch = RequestMispunchList::where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['emp_miss_time_type' => $request->time_type, 'emp_miss_in_time' => $request->in_time, 'emp_miss_out_time' => $request->out_time, 'status' => $request->approve]);

            Alert::success('Your Mispunch Request has been Approve Successfully');
            return back();
        } elseif ($request->has('id') && $request->has('time_type') && $request->has('in_time') && $request->has('out_time') && $request->has('submit') && $request->has('remark')) {
            $mispunch = RequestMispunchList::where('id', $request->id)
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
        // return true;
        $id = 38;
        // $data = DB::table('request_mispunch_list')->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
        //     ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
        //     ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
        //     ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
        //     ->join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')
        //     ->where('request_mispunch_list.id', $id)
        //     ->select('request_mispunch_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'static_mispunch_timetype.time_type  as time_type')
        //     ->first();
        //     dd($data);
        $DATA = DB::table('request_mispunch_list')
            ->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')
            ->where('request_mispunch_list.business_id', Session::get('business_id'))
            ->select('request_mispunch_list.*', 'static_mispunch_timetype.time_type', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.designation_id')
            ->orderBy('request_mispunch_list.id', 'desc')
            ->get();
        $StaticMisspunchTimeType = DB::table('static_mispunch_timetype')->get();
        // dd($leave_type);

        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $root = compact('moduleName', 'permissions', 'DATA', 'StaticMisspunchTimeType');

        // $data = MispunchList::all();
        // dd($DATA);
        return view('admin.request.mispunch', $root);
    }

    public function leaves()
    {
        $staticLeaveType =
            $item = DB::table('employee_personal_details')
            ->join('attendance_list', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('attendance_list.punch_date', '!=', date('Y-m-d'))
            ->select('employee_personal_details.emp_id')
            ->get();

        $TodayPresent = DB::table('attendance_list')
            ->where('business_id', Session::get('business_id'))
            ->where('punch_date', '=', now()->toDateString())
            ->get();

        $PresetCount = count($TodayPresent);
        $leaveCategory = DB::table('policy_setting_leave_category')->where('business_id', Session::get('business_id'))->get();
        // dd($leaveCategory);
        $shiftType = DB::table('static_leave_shift_type')->get();
        $leaveType = DB::table('static_request_leave_type')->get();
        $DATA = DB::table('request_leave_list')
            ->join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('policy_setting_leave_category', 'policy_setting_leave_category.id', '=', 'request_leave_list.leave_category')
            ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
            // static_request_leave_type`

            ->where('request_leave_list.business_id', Session::get('business_id'))
            ->select('request_leave_list.*', 'static_request_leave_type.leave_day', 'policy_setting_leave_category.category_name', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.designation_id', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->orderBy('request_leave_list.id', 'desc')
            ->get();
        // dd($DATA);   
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // dd($data);
        $root = compact('moduleName', 'permissions', 'DATA', 'PresetCount', 'leaveCategory', 'leaveType', 'shiftType');
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
        $filteredData = RequestGatepassList::join('employee_personal_details', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'request_gatepass_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'request_gatepass_list.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'request_gatepass_list.designation_id', '=', 'designation_list.desig_id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('request_gatepass_list.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('request_gatepass_list.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('request_gatepass_list.designation_id', $designationId);
            })
            ->select('request_gatepass_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name')
            ->orderBy('request_gatepass_list.id', 'desc')
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
        $data = DB::table('request_gatepass_list')->join('employee_personal_details', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
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
        $data = DB::table('request_mispunch_list')->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
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

        // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = RequestMispunchList::join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
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
            ->select('request_mispunch_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name')
            ->orderBy('request_mispunch_list.id', 'desc')
            ->get();

        // Return the filtered data as JSON response
        return response()->json(['get' => $filteredData]);
    }

    public function EditLeaveDataGet(Request $request)
    {
        // dd($request->all());
        // return $request->id;
        $data = DB::table('request_leave_list')->join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->where('request_leave_list.id', $request->id)
            ->select('request_leave_list.*', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'employee_personal_details.emp_mobile_number', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname')
            ->first();
        return response()->json(['get' => $data]);
    }

    public function LeaveEmployeeFilter(Request $request)
    {
        // return true;
        $branchId = $request->branch_id;
        $data = DB::table('request_leave_list')->get();
        return $data;
        // return $branchId;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        // $fromDate = $request->input('from_date');

        // // Use the selected filter values to query your database and retrieve the filtered data
        $filteredData = DB::table('request_leave_list')
            ->join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'request_leave_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'request_leave_list.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'request_leave_list.designation_id', '=', 'designation_list.desig_id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('request_leave_list.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('request_leave_list.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('request_leave_list.designation_id', $designationId);
            })
            ->when($fromDate, function ($query) use ($fromDate) {
                $query->where('request_leave_list.from_date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                $query->where('request_leave_list.to_date', '<=', $toDate);
            })

            // from_date

            ->select('request_leave_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name')
            ->orderBy('request_leave_list.id', 'desc')
            ->get();

        // Return the filtered data as JSON response
        return response()->json(['get' => $filteredData]);
    }
}

// Route::any('/gatepass/{tableName}', [RequestController::class, 'GatepassTable']);
// Route::any('/gatepass/{tableName}', [RequestController::class, 'MispunchTable']);
// Route::any('/mispunch/detail', [RequestController::class, 'editMispunchDataGet']);
// Route::any('/mispunchemployeefilter', [RequestController::class, 'MispunchEmployeeFilter']);
