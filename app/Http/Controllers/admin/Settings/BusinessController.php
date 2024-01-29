<?php

/**
 * Laravel Controller
 *
 *
 * @package		Laravel Controller
 * @subpackage  BusinessController
 * @category	Controller
 * @author		Aman Sahu
 *
 *
 **/

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ModelHasPermission;
use App\Models\AdminNotice;
use App\Models\BusinessDetailsList;
use App\Models\RequestLeaveList;
use App\Models\RequestMispunchList;
use App\Models\BranchList;
use App\Models\RequestGatepassList;
use App\Models\DesignationList;
use App\Models\AttendanceList;
use App\Models\EmployeePersonalDetail;
use App\Models\StaticSidebarMenu;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicySettingRoleCreate;
use App\Models\DepartmentList;
use App\Models\PolicyAttenRuleBreak;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\PolicyAttenRuleGatepass;
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\PolicyAttenRuleMisspunch;
use App\Models\PolicyAttenRuleOvertime;
use App\Models\PolicyHolidayTemplate;
use App\Models\PolicyPolicyHolidayDetail;
use App\Models\PolicySettingRoleItem;
use App\Models\PolicySettingLeavePolicy;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicyHolidayDetail;
use Carbon\Carbon;

class BusinessController extends Controller
{
    public function CreateHolidays(Request $request)
    {
        // dd($request->all());
        $hoidayCreateData = $request->hiddenHolidayCreate;
        $holidayName = $request->temp_name;
        $hoildayFrom = $request->temp_from;
        $hoildayTo = $request->temp_to;
        $businessId = Session::get('business_id');
        if (isset($holidayName)) {
            if ($request->has('temp_name')) {
                $template = PolicyHolidayTemplate::insert([
                    'temp_name' => $holidayName,
                    'temp_from' => date('Y-m-d', strtotime($hoildayFrom . '-01')),
                    'temp_to' => date('Y-m-d', strtotime($hoildayTo . '-30')),
                    'business_id' => $businessId,
                ]);
                $temp_obj = PolicyHolidayTemplate::where(['temp_name' => $holidayName, 'temp_from' => date('Y-m-d', strtotime($hoildayFrom . '-01')), 'temp_to' => date('Y-m-d', strtotime($hoildayTo . '-30')), 'business_id' => $businessId])->first();
                $i = 0;
                $hiddenHolidayData  = json_decode($request->input('hiddenHolidayCreate'), true);
                foreach ($hiddenHolidayData  as $item) {
                    $holiday = PolicyHolidayDetail::insert([
                        'template_id' => $temp_obj->temp_id,
                        'business_id' => $businessId,
                        'holiday_name' => $item['name'],
                        'holiday_date' => date('Y-m-d', strtotime(str_replace('/', '-', $item['date']))),
                        'day' => $item['day'],
                    ]);
                }
                if (isset($template) && isset($holiday)) {
                    Alert::success('', 'Your Holiday policy has been created successfully');
                } else {
                    Alert::error('', 'Your Holiday policy has not been created');
                }
            }
        } else {
            Alert::error('', 'Your Holiday policy has not been created');
        }
        return redirect()->back();
    }

    public function UpdateHoliday(Request $request)
    {
        // dd($request->all());
        $updateHolidayId = $request->update_temp_id;
        $updateName = $request->update_temp_name;
        $updateFrom = $request->update_temp_from;
        $updateTo = $request->update_temp_to;
        $bID = Session::get('business_id');
        $check = PolicyHolidayDetail::where('template_id', $updateHolidayId)
            ->where('business_id', $bID)
            ->delete();
        if ((true)) {
            PolicyHolidayTemplate::where('temp_id', $updateHolidayId)
                ->where('business_id', $bID)
                ->update([
                    'temp_name' => $updateName,
                    'temp_from' => date('Y-m-d', strtotime($updateFrom . '-01')),
                    'temp_to' => date('Y-m-d', strtotime($updateTo . '-' . date('t', strtotime($updateTo . '-01')))),
                ]);

            // Assuming $request->updated_items is a JSON string
            $hiddenHolidayData  = json_decode($request->input('hiddenHolidayData'), true);
            // dd($hiddenHolidayData);
            foreach ($hiddenHolidayData  as $item) {
                // dd(date('Y-m-d', strtotime(str_replace('/', '-', $item['day']))));
                $data = PolicyHolidayDetail::insert([
                    'template_id' => $request->update_temp_id,
                    'business_id' => $bID,
                    'holiday_name' => $item['name'],
                    'holiday_date' => date('Y-m-d', strtotime(str_replace('/', '-', $item['date']))),
                    'day' => $item['day'],
                ]);
            }
            // return response()->json(['message' => true]);
            Alert::success('', 'Your Holiday policy has been updated Successfully');
        } else {
            // return response()->json(['message' => false]);
            Alert::error('', 'Your Holiday policy has not been updated');
        }
        return  redirect()->back();
    }

    public function DeleteHoliday(Request $request)
    {
        $data = $request->state;
        $deleted = PolicyHolidayDetail::where('holiday_id', $data)->delete();
        if ($deleted) {
            Alert::success('Deleted Successfully', '');
            return response()->json(['res' => $deleted]);
        }
    }

    public function DeleteHolidayTemp(Request $request)
    {
        $checkmat = DB::table('policy_master_endgame_method')
            ->where('business_id', Session::get('business_id'))
            ->where('holiday_policy_ids_list', $request->holiday_policy_id)
            ->count();
        // dd($checkmat);
        if ($checkmat === 0) {
            $holiday_template = PolicyHolidayTemplate::where('temp_id', $request->holiday_policy_id)->delete();
            $holiday = PolicyHolidayDetail::where('template_id', $request->holiday_policy_id)->delete();
            if ($holiday_template && $holiday) {
                Alert::success('', 'Your Holiday policy has been deleted successfully');
            } else {
                Alert::error('', 'Your Holiday policy has not been deleted');
                // Alert::error('', 'You cannot delete the policy if you have an employee associated with it.')->persistent(true);
            }
        } else {
            Alert::error('', 'You cannot delete the policy if you have an employee associated with it.')->persistent(true);
        }
        return back();
    }

    public function AddManager(Request $request)
    {
        // dd($request->all());
        $getEmp = DB::table('employee_personal_details')
            ->where(['business_id' => $request->session()->get('business_id'), 'emp_id' => $request->EmpId])
            ->first();
        if ($getEmp) {
            $assign = DB::table('manager_details')->insert([
                'business_id' => $request->session()->get('business_id'),
                'mngr_name' => $getEmp->emp_name,
                'mngr_emp_id' => $getEmp->emp_id,
                'mngr_phone' => $getEmp->emp_mobile_number,
                'mngr_depart_id' => $getEmp->emp_name,
                'mngr_branch_id' => $getEmp->branch_id,
            ]);
            if ($assign) {
                Alert::success('Assigned Successfully', 'Manager Asigned Successfully.');
                return redirect('admin/settings/business/manager');
            } else {
                Alert::error('Failed', 'Fail to Assign Employee');
                return redirect('admin/settings/business/manager');
            }
        } else {
            Alert::error('Failed', 'Employee Id does not exist in emplopyee data');
            return redirect('admin/settings/business/manager');
        }
    }
}
