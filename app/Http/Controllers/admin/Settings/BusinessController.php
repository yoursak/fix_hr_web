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

class BusinessController extends Controller
{
    public function CreateHolidays(Request $request)
    {
        // dd($request->all());
        // return $request->all();

            // return true;
        
        $tempFrom = $request->temp_from;
        $updateItems = $request->updated_items;
        if (isset($updateItems)) {
            $template = PolicyHolidayTemplate::insert([
                'temp_name' => $request->temp_name,
                'temp_from' => date('Y-m-d', strtotime($request->temp_from . '-01')),
                'temp_to' => date('Y-m-d', strtotime($request->temp_to . '-30')),
                'business_id' => $request->session()->get('business_id'),
            ]);
            $temp_obj = PolicyHolidayTemplate::where(['temp_name' => $request->temp_name, 'temp_from' => date('Y-m-d', strtotime($request->temp_from . '-01')), 'temp_to' => date('Y-m-d', strtotime($request->temp_to . '-30')), 'business_id' => $request->session()->get('business_id')])->first();

            foreach ($updateItems as $item) {
                PolicyHolidayDetail::insert([
                    'template_id' => $temp_obj->temp_id,
                    'business_id' => $request->session()->get('business_id'),
                    'holiday_name' => $item['name'],
                    'holiday_date' => $item['date'],
                    'day' => $item['day'],
                ]);
            }
            
            return true;
        } else {
            return false;
        }

        // $holidayName = $request->holiday_name;
        // if (isset($holidayName)) {
        //     if ($request->has('temp_name')) {
        //         $template = PolicyHolidayTemplate::insert([
        //             'temp_name' => $request->temp_name,
        //             'temp_from' => date('Y-m-d', strtotime($request->temp_from . '-01')),
        //             'temp_to' => date('Y-m-d', strtotime($request->temp_to . '-30')),
        //             'business_id' => $request->session()->get('business_id'),
        //         ]);

        //         $i = 0;
        //         foreach ($request->holiday_name as $key => $holiday) {
        //             $holiday = PolicyHolidayDetail::insert([
        //                 'holiday_name' => $request->holiday_name[$i],
        //                 'day' => $request->holiday_day[$i],
        //                 'holiday_date' => $request->holiday_date[$i],
        //                 'business_id' => $request->session()->get('business_id'),
        //                 'template_id' => $temp_id->temp_id,
        //             ]);
        //             $i++;
        //         }

        //         if ($template && $holiday) {
        //             Alert::success('', 'Your Holiday Policy has been created Successfully');
        //         } else {
        //             Alert::error('', 'Your Holiday Policy has not been created');
        //         }
        //     }
        // } else {
        //     Alert::error('', 'Your Holiday Policy not created');
        // }
        // return redirect('/admin/settings/business/holiday_policy');
    }

    public function UpdateHoliday(Request $request)
    {
        // return $request->updated_items;
        $updateHolidayId = $request->updateId;
        $updateName = $request->updateName;
        $updateFrom = $request->updateFrom;
        $updateTo = $request->updateTo;
        $bID = Session::get('business_id');
        $check = PolicyHolidayDetail::where('template_id', $updateHolidayId)
            ->where('business_id', $bID)
            ->delete();

        if (isset($check)) {
            PolicyHolidayTemplate::where('temp_id', $updateHolidayId)
                ->where('business_id', $bID)
                ->update(['temp_name' => $updateName, 'temp_from' => date('Y-m-d', strtotime($updateFrom . '-01')), 'temp_to' => date('Y-m-d', strtotime($updateTo . '-' . date('t', strtotime($updateTo . '-01'))))]);
            // Assuming $request->updated_items is an array of updated items
            $updatedItems = $request->input('updated_items');
            foreach ($updatedItems as $item) {
                PolicyHolidayDetail::insert([
                    'template_id' => $request->updateId,
                    'business_id' => $bID,
                    'holiday_name' => $item['name'],
                    'holiday_date' => $item['date'],
                    'day' => $item['day'],
                ]);
            }
            return response()->json(['message' => true]);
        } else {
            return response()->json(['message' => false]);
        }
        // }

        // if ($request->has('update_temp_name')) {
        //     $updateTemp = PolicyHolidayTemplate::where([
        //         'temp_id' => $request->update_temp_id,
        //         'business_id' => $request->session()->get('business_id'),
        //     ])->update([
        //         'temp_name' => $request->update_temp_name,
        //         'temp_from' => date('Y-m-d', strtotime($request->update_temp_from . '-01')),
        //         'temp_to' => date('Y-m-d', strtotime($request->update_temp_to . '-30')),
        //     ]);

        //     if ($request->has('update_name')) {
        //         foreach ($request->update_name as $key => $value) {
        //             $holiday = PolicyHolidayDetail::insert([
        //                 'holiday_name' => $request->update_name[$key],
        //                 'day' => $request->update_day[$key],
        //                 'holiday_date' => $request->update_date[$key],
        //                 'business_id' => $request->session()->get('business_id'),
        //                 'template_id' => $request->update_temp_id,
        //             ]);
        //         }
        //         if ($holiday) {
        //             Alert::success('', 'Your Holiday Policy has been Updated Successfully');
        //         } else {
        //             Alert::error('failed', 'Your Holiday Policy has not been Updated Successfully');
        //         }
        //     }
        //     Alert::success('', 'Your Holiday Policy has been Updated Successfully');
        // }

        // return back();
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
            // $holiday_template = PolicyHolidayTemplate::where('temp_id' => $request->holiday_policy_id)->delete();
            // $holiday = PolicyHolidayDetail::where('template_id' => $request->holiday_policy_id)->delete();
            if ($holiday_template && $holiday) {
                Alert::success('', 'Holiday Policy has been Deleted Successfully');
            } else {
                Alert::error('', 'Your Holiday Policy has not been Deleted!');
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
