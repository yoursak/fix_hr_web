<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use Alert;

class CompOffController extends Controller {
    public function CompOffAndWOPPolicyView(Request $request) {
        $getPolicy = DB::table('policy_comp_off_lwop_leave')->where('business_id', Session::get('business_id'))->first();
        return view('admin.setting.business.compoff.compoff',compact('getPolicy'));
    }
    public function CompOffAndWOPPolicyCreate(Request $request) {
        // dd($request->all());

        $getPolicy = DB::table('policy_comp_off_lwop_leave')->where('business_id', Session::get('business_id'))->first();
        // dd(!isset($getPolicy));
        if(!isset($getPolicy)) {
                $policyCreated = DB::table('policy_comp_off_lwop_leave')->insert([
                    'business_id' => Session::get('business_id'),
                    'comp_off_switch' => ($request->CompOffSwitch ?? 'off') == 'on' ? 1 : 0,
                    'holiday_switch' => ($request->HolidaySwitch ?? 0),
                    'overtime_switch' => ($request->OvertimeSwitch ?? 0),
                    'overtime_hr' => ($request->overtime_hr ?? 0),
                    'lwop_switch' => ($request->LwopSwitch ?? 'off') == 'on' ? 1 : 0,
                    'lwop_leave_switch' => ($request->LwopLeaveSwitch ?? 0),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if($policyCreated) {
                    Alert::success('Policy Created Successfully');
                }else{
                    Alert::error('Policy Not Created');
                }
            
        }

        if(isset($getPolicy)) {
            $updatePolicy = DB::table('policy_comp_off_lwop_leave')->where('business_id', Session::get('business_id'))->update([
                'business_id' => Session::get('business_id'),
                'comp_off_switch' => ($request->CompOffSwitch ?? 'off') == 'on' ? 1 : 0,
                'holiday_switch' => ($request->HolidaySwitch ?? 0),
                'overtime_switch' => ($request->OvertimeSwitch ?? 0),
                'overtime_hr' => ($request->overtime_hr ?? 0),
                'lwop_switch' => ($request->LwopSwitch ?? 'off') == 'on' ? 1 : 0,
                'lwop_leave_switch' => ($request->LwopLeaveSwitch ?? 0),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if($updatePolicy) {
                Alert::success('Policy Updated Successfully');
            }else{
                Alert::error('Policy Not Updated');
            }
        }
        return back();
    }
}
