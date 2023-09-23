<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
class ShiftController extends Controller
{
    public function addShift(Request $request){

        // dd($request->all());

        if($request->shiftType == 'fixed'){
            $fixShift = DB::table('shift_fixed')->insert([
                'shift_name'=> $request->fixedshiftName,
                'shift_start'=> $request->fixShiftStart,
                'shift_end'=> $request->fixShiftEnd,
                'break_min'=> $request->fixShiftBreak,
                'is_paid'=> $request->fixpaid,
                'work_hr'=> $request->f_WorkHour,
                'work_min'=> $request->f_WorkMin,
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
                    'work_hr'=> $request->r_WorkHour[$key],
                    'work_min'=> $request->r_WorkMin[$key],
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
                'is_paid'=> $request->openPaid,
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

    public function updateShift(Request $request){
        // dd($request->all());

        if($request->has('fixedId')){
            $fixUpdate = DB::table('shift_fixed')->where(['business_id'=>$request->session()->get('business_id'),'fixed_id'=>$request->fixedId])->update([
                'shift_name'=> $request->UpdatedFixedshiftName,
                'shift_start'=> $request->UpdatedFixShiftStart,
                'shift_end'=> $request->UpdatedFixShiftEnd,
                'break_min'=> $request->UpdatedFixShiftBreak,
                'is_paid'=> $request->UpdatedFixpaid,
                'work_hr'=> $request->fu_WorkHour,
                'work_min'=> $request->fu_WorkMin,
                'updated_at'=> now(),
            ]);

            if($fixUpdate ){
                Alert::success('Shift Updated Successfully','');
                
            }else{
                Alert::error('Failed','');
                
            }
        }

        if($request->has('openId')){
            $updateOpen = DB::table('shift_open')->where(['business_id'=>$request->session()->get('business_id'),'open_id'=>$request->openId])->update([
                'shift_name'=> $request->updatedOpenShiftName,
                'shift_hr'=> $request->updatedOpenHour,
                'shift_min'=> $request->updatedOpenMin,
                'break_min'=> $request->updatedOpenBreak,
                'is_paid'=> $request->updatedOpenPaid,
                'updated_at'=> now(),
            ]);

            if($updateOpen){
                Alert::success('Shift Updated Successfully','');
            }else{
                Alert::error('Failed','');
            }
        }

        if($request->has('setId')){
            // dd($request->all());

            $shift = DB::table('shift_set')->where(['business_id'=> $request->session()->get('business_id'),'set_id'=> $request->setId])->update([
                'set_name'=> $request->updatedRotationalName,
                'updated_at'=>now(),
            ]);

            $roatationalRemove = DB::table('shift_rotational')->where(['business_id'=> $request->session()->get('business_id'),'set_id'=> $request->setId])->delete();

            foreach ($request->updatedRotationalShiftName as $key => $rotationalShiftName) {
                $roatationalShift = DB::table('shift_rotational')->insert([
                    'set_id'=> $request->setId,
                    'shift_name'=> $request->updatedRotationalShiftName[$key],
                    'shift_start'=> $request->updatedRotationalShiftStart[$key],
                    'shift_end'=> $request->updatedRotationalShiftEnd[$key],
                    'break_min'=> $request->updatedRotationalShiftBreak[$key],
                    'is_paid'=> $request->updatedRotationalpaid[$key],
                    'work_hr'=> $request->ru_WorkHour[$key],
                    'work_min'=> $request->ru_WorkMin[$key],
                    'branch_id'=> $request->session()->get('branch_id'),
                    'business_id'=> $request->session()->get('business_id'),
                    'updated_at'=> now(),
                ]);
            }

            if($roatationalShift){
                Alert::success('Rotational Shift Created Successfully','');
            }else{
                Alert::error('Failed','');
            }
        }

        return back();
    }

    public function deleteShift(Request $request ,$id){
        // dd($request->all());

        if($request->has('fixed')){
            $fixDelete = DB::table('shift_fixed')->where(['business_id'=>$request->session()->get('business_id'),'fixed_id'=>$id])->delete();
            if($fixDelete){
                Alert::success('Fixed Shift Delete Successfully','');
            }else{
                Alert::error('Failed','');
            }
        }

        if($request->has('open')){
            $openDelete = DB::table('shift_open')->where(['business_id'=>$request->session()->get('business_id'),'open_id'=>$id])->delete();
            if($openDelete){
                Alert::success('Open Shift Delete Successfully','');
            }else{
                Alert::error('Failed','');
            }
        }

        if($request->has('set')){
            $roatationalDelete = DB::table('shift_rotational')->where(['business_id'=> $request->session()->get('business_id'),'set_id'=> $id])->delete();
            $setDelete = DB::table('shift_set')->where(['business_id'=> $request->session()->get('business_id'),'set_id'=> $id])->delete();
            if($setDelete){
                Alert::success('Rotational Shift Delete Successfully','');
            }else{
                Alert::error('Failed','');
            }
        }
        return back();
    }
}
