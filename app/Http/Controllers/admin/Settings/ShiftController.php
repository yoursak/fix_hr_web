<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
class ShiftController extends Controller
{
    public function addShift(Request $request){
        dd($request->all());

        if($request->shift_type == 'fixed'){
            $fixShift = DB::table('shifts')->insert([
                'shift_name'=> $request->shift_name,
                'shift_type'=> $request->shift_type,
                'shift_from'=> $request->fix_shift_from,
                'shift_to'=> $request->fix_shift_to,
                'is_paid_break'=> $request->break_type,
                'break_from'=> $request->break_from,
                'break_to'=> $request->break_to,
                'business_id'=> $request->session()->get('business_id'),
                'updated_at'=> now(),
            ]);

            if($fixShift ){
                Alert::success('Shift Created Successfully','');
                return redirect('admin/settings/attendance/create_shift');
            }else{
                Alert::error('Failed','');
                return redirect('admin/settings/attendance/create_shift');
            }

        }elseif($request->shift_type == 'rotational'){
            $roatationalShift = DB::table('shifts')->insert([
                'shift_name'=> $request->Shiftname,
                'shift_type'=> $request->shift_type,
                'rotational_shift_name'=> $request->rotational_name,
                'shift_from'=> $request->from,
                'shift_to'=> $request->to,
                'break_hour'=> $request->rotetional_break,
                'is_paid_break'=> '0',
                'business_id'=> $request->session()->get('business_id'),
                'updated_at'=> now(),
            ]);

            if($roatationalShift){
                Alert::success('Shift Created Successfully','');
                return redirect('admin/settings/attendance/create_shift');
            }else{
                Alert::error('Failed','');
                return redirect('admin/settings/attendance/create_shift');
            }
        }elseif($request->shift_type == 'open'){
            $openShift = DB::table('shifts')->insert([
                'shift_name'=> $request->shift_name,
                'shift_type'=> $request->shift_type,
                'work_hour'=> $request->work_hour,
                'work_minute'=> $request->work_minute,
                'business_id'=> $request->session()->get('business_id'),
                'updated_at'=> now(),
            ]);

            if($openShift){
                Alert::success('Shift Created Successfully','');
                return redirect('admin/settings/attendance/create_shift');
            }else{
                Alert::error('Failed','');
                return redirect('admin/settings/attendance/create_shift');
            }
        }


            return redirect('admin/settings/attendance/create_shift');

    }
}
