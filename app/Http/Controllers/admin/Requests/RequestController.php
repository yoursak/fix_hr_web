<?php

namespace App\Http\Controllers\admin\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use Carbon\Carbon;
use DateTime;
use App\Models\employee\LeaveRequestList;
use App\Models\employee\GatepassRequestList;
use App\Models\employee\MisspunchList;
use Session;
use RealRashid\SweetAlert\Facades\Alert;

class RequestController extends Controller
{
    public function leaves()
    {
        $data = LeaveRequestList::where('business_id', Session::get('business_id'))->get();
        return view('admin.request.leave', compact('data'));
    }

    public function gatepass()
    {
        $data = GatepassRequestList::where('business_id', Session::get('business_id'))->get();

        // $data = GatepassRequestList::all();
        // $data1 = BranchList::where('branch_id')
        // return $data;
        // dd($data->id);
        return view('admin.request.gatepass', compact('data'));
    }

    public function ApproveGatepass(Request $request)
    {
        // dd($request->all());

        $branch = DB::table('gatepass_request_list')
            ->where('id', $request->editGatepassId)
            ->where('business_id', Session::get('business_id'))
            ->update(['in_time' => $request->in_time, 'status' => $request->approve]);
        return back();
        if ($branch) {
            Alert::success('Data Updated', 'Updated  Created');
        }
    }

    public function ApproveLeave(Request $request)
    {
        // dd($request->all());

        $toDate = Carbon::parse($request->to_date);
        $fromDate = Carbon::parse($request->from_date);

        $loaded = $toDate->diffInDays($fromDate);
        $branch = DB::table('leave_request_list')
            ->where('id', $request->editLeaveId)
            ->where('business_id', Session::get('business_id'))
            ->update(['leave_type' => $request->leave_type, 'from_date' => $request->from_date, 'to_date' => $request->to_date, 'days' => $loaded, 'status' => $request->status]);
        if ($branch) {
            Alert::success('Data Updated', 'Updated  Created');
        }
        return back();
    }

    public function ApproveMisspunch(Request $request, $id)
    {
        $data = MisspunchList::where('id', $id)
            ->where('business_id', Session::get('business_id'))
            ->update(['emp_miss_in_time' => $request->in_time, 'emp_miss_out_time' => $request->out_time, 'status' => $request->approve]);

        if ($data) {
            Alert::success('Data Updated', 'Updated  Created');
        }
        return back();
    }

    public function DestroyGatepass($id)
    {
        // dd($id);
        $data = GatepassRequestList::find($id);
        $data->delete();
        if ($data) {
            Alert::success('Delete Success', 'Delete Gatepass Successfully');
        }
        // Session::flash('success', 'Succefully Deleted !');
        return back();
    }

    public function DestroyLeave($id)
    {
        // dd($id);
        $data = LeaveRequestList::find($id);
        $data->delete();
        if ($data) {
            Alert::success('Delete Success', 'Delete Gatepass Successfully');
        }
        // Session::flash('success', 'Succefully Deleted !');
        return back();
    }

    public function DestroyMisspunch($id)
    {
        // dd($id);
        $data = MisspunchList::find($id);
        $data->delete();
        if ($data) {
            Alert::success('Delete Success', 'Delete Gatepass Successfully');
        }
        // Session::flash('success', 'Succefully Deleted !');
        return back();
    }

    // DestroyMisspunch
    public function misspunch()
    {
        // return true;
        $data = MisspunchList::where('business_id', Session::get('business_id'))->get();

        // $data = MisspunchList::all();
        // dd($data);
        return view('admin.request.misspunch', compact('data'));
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

    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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
                // 'emp_name' => $request->name,
                // 'emp_id' => $request->emp_id,
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

    public function MisspunchTable($tableName, Request $request)
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
}

// Route::any('/gatepass/{tableName}', [RequestController::class, 'GatepassTable']);
// Route::any('/gatepass/{tableName}', [RequestController::class, 'MisspunchTable']);
