<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use Alert;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Helpers\Central_unit;

use App\Models\StaticEmployeeJoinReligion;
use App\Models\PolicyCompOffLwopLeave;
class CompOffController extends Controller
{
    public function CompOffAndWOPPolicyView(Request $request)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $getPolicy = DB::table('policy_comp_off_lwop_leave')
            ->where('business_id', Session::get('business_id'))
            ->first();
        return view('admin.setting.business.compoff.compoff', compact('getPolicy', 'permissions'));
    }

    public function CompOffAndWOPPolicyCreate(Request $request)
    {
        $business_id = Session::get('business_id');
        $getPolicy = PolicyCompOffLwopLeave::where('business_id', $business_id)
            ->first();
        $CompOffSwitch = ($request->CompOffSwitch ?? 'off') == 'on' ? 1 : 0;
        $HolidaySwitch = $request->HolidaySwitch ?? 0;
        $OvertimeSwitch = $request->OvertimeSwitch ?? 0;
        $overtime_hr = $request->overtime_hr ?? 0;
        $LWPLeaveSwitch =  $request->LWPLeaveSwitch ?? 0;
        $ExpiryPoint =  $request->expiry_point ?? 0;
        if (!isset($getPolicy)) {
            $policyCreated = PolicyCompOffLwopLeave::insert([
                'business_id' => $business_id,
                'switch' => $CompOffSwitch,
                'holiday_weekly_checked' => $HolidaySwitch,
                'overtime_checked' => $OvertimeSwitch,
                'overtime_hr' => $overtime_hr,
                'lwop_leave_checked' => $LWPLeaveSwitch,
                'expiry_point' => $ExpiryPoint,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (isset($policyCreated)) {
                Alert::success('', 'Your Comp-Off & LWP policy has been created successfully');
            } else {
                Alert::info('', 'Your Comp-Off & LWP policy has not been created');
            }
        }

        if (isset($getPolicy)) {
            $updatePolicy = DB::table('policy_comp_off_lwop_leave')
                ->where('business_id', $business_id)
                ->update([
                    'business_id' => $business_id,
                    'switch' => $CompOffSwitch,
                    'holiday_weekly_checked' => $HolidaySwitch,
                    'overtime_checked' => $OvertimeSwitch,
                    'overtime_hr' => $overtime_hr,
                    'lwop_leave_checked' => $LWPLeaveSwitch,
                    'expiry_point' => $ExpiryPoint,
                    'updated_at' => now(),
                ]);
            if (isset($updatePolicy)) {
                Alert::success('', 'Your Comp-Off & LWP policy has been updated successfully');
            } else {
                Alert::info('', 'Your Comp-Off & LWP policy has not been updated');
            }
        }
        return redirect()->back();
    }
}
