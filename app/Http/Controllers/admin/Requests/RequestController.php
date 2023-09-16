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
use App\Models\employee\GatepassRequestList;    
use App\Models\employee\MisspunchList;    


class RequestController extends Controller
{
    public function leaves(){
        return view('admin.request.leave');
    }

    public function gatepass(){
        $data = GatepassRequestList::all(); 
        // $data1 = BranchList::where('branch_id')
        // return $data;
        // dd($data->id);
        return view('admin.request.gatepass', compact('data'));
    }

    public function ApproveGatepass(Request $request, $id)
    {
        // dd($request->all());
        // $data = GatepassRequestList::find($id);
        // $data->status = 'Approve';
        // $data->in_time = $request->in_time;
        // if($data->save()){
        // return back();
            // return redirect()->route('/admin/requests/gatepass');
        // }
    }

    public function DestroyGatepass($id)
    {
        // dd($id);    
        $data = GatepassRequestList::find($id);
        $data->delete();

        return back();
    }


    public function misspunch(){
        $data = MisspunchList::all();    
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
            return response()->json(["gatpass_details" =>$request->all()]);
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
                $table->enum('emp_miss_time_type', ['1'=>'intime', '2'=>'outtime']);
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
            return response()->json(["gatpass_details" =>$request->all()]);
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
