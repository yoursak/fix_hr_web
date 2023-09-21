<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
class ShiftController extends Controller
{
    public function addShift(Request $request){

        if($request->shiftType == 'fixed'){
            $fixShift = DB::table('shift_fixed')->insert([
                'shift_name'=> $request->fixedshiftName,
                'shift_start'=> $request->fixShiftStart,
                'shift_end'=> $request->fixShiftEnd,
                'break_min'=> $request->fixShiftBreak,
                'is_paid'=> $request->fixpaid,
                'business_id'=> $request->session()->get('business_id'),
                'branch_id'=> $request->session()->get('branch_id'),
                'updated_at'=> now(),
            ]);

            if($fixShift ){
                Alert::success('Shift Created Successfully','');
                
            }else{
                Alert::error('Failed','');
                
            }

        }

        if($request->shiftType == 'rotational'){
            $shift = DB::table('shift_set')->insert([
                'set_name'=> $request->rotationalName,
                'branch_id'=> $request->session()->get('branch_id'),
                'business_id'=> $request->session()->get('business_id'),
            ]);

            $getShift = DB::table('shift_set')->where([
                'set_name'=> $request->rotationalName,
                'business_id'=> $request->session()->get('business_id'),
            ])->first('set_id');

            // dd($getShift->set_id);

            foreach ($request->rotationalShiftName as $key => $rotationalShiftName) {
                $roatationalShift = DB::table('shift_rotational')->insert([
                    'set_id'=> $getShift->set_id,
                    'shift_name'=> $request->rotationalShiftName[$key],
                    'shift_start'=> $request->rotationalShiftStart[$key],
                    'shift_end'=> $request->rotationalShiftEnd[$key],
                    'break_min'=> $request->rotationalShiftBreak[$key],
                    'is_paid'=> $request->rotationalpaid[$key],
                    'branch_id'=> $request->session()->get('branch_id'),
                    'business_id'=> $request->session()->get('business_id'),
                    'updated_at'=> now(),
                ]);
            }

            if($roatationalShift){
                Alert::success('Rotationa Shift Created Successfully','');

            }else{
                Alert::error('Failed','');
               
            }
        }

        if($request->shiftType == 'open'){
            $openShift = DB::table('shift_open')->insert([
                'shift_name'=> $request->openShiftName,
                'shift_hr'=> $request->openHour,
                'shift_min'=> $request->openMin,
                'break_min'=> $request->openBreak,
                'is_paid'=> $request->work_minute,
                'branch_id'=> $request->session()->get('branch_id'),
                'business_id'=> $request->session()->get('business_id'),
                'updated_at'=> now(),
            ]);

            if($openShift){
                Alert::success('Shift Created Successfully','');
                
            }else{
                Alert::error('Failed','');
                
            }
        }
        return back();

    }
}
