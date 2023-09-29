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
use App\Models\admin\HolidayTemplate;
use App\Models\admin\HolidayDetail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Session;

class BusinessController extends Controller
{

    public function CreateHoliday(Request $request)
    {
        // dd($request->holiday_day[0]);
        if ($request->has("temp_name")) {
            $template = HolidayTemplate::create([
                "temp_name" => $request->temp_name,
                "temp_from" => $request->temp_from,
                "temp_to" => $request->temp_to,
                "business_id" => $request->session()->get('business_id')
            ]);
            $temp_id = HolidayTemplate::where(['temp_name' => $request->temp_name, 'temp_from' => $request->temp_from, 'temp_to' => $request->temp_to, 'business_id' => $request->session()->get('business_id')])->first();


            $i = 0;
            foreach ($request->holiday_name as $key => $holiday) {
                $holiday = HolidayDetail::create([
                    'holiday_name' => $request->holiday_name[$i],
                    'day' => $request->holiday_day[$i],
                    'holiday_date' => $request->holiday_date[$i],
                    'business_id' => $request->session()->get('business_id'),
                    'template_id' => $temp_id->temp_id
                ]);
                $i++;
            }

            if ($template && $holiday) {
                Alert::success('Added Holiday Success', 'Your Holiday Template Added Successfully');
            } else {

                Alert::error('Fail', 'Your Holiday Template Fail');
            }
        }
        return redirect('/admin/settings/business/holiday_policy');
    }

    public function UpdateHoliday(Request $request)
    {

        // dd($request->all());
        if ($request->has('update_temp_name')) {
            $updateTemp = DB::table('holiday_template')->where([
                'temp_id' => $request->update_temp_id,
                'business_id' => $request->session()->get('business_id')
            ])->update([
                'temp_name' => $request->update_temp_name,
                'temp_from' => $request->update_temp_from,
                'temp_to' => $request->update_temp_to
            ]);

            if ($request->has('update_name')) {
                foreach ($request->update_name as $key => $value) {
                    $holiday = DB::table('holiday_details')->insert([
                        'holiday_name' => $request->update_name[$key],
                        'day' => $request->update_day[$key],
                        'holiday_date' => $request->update_date[$key],
                        'business_id' => $request->session()->get('business_id'),
                        'template_id' => $request->update_temp_id
                    ]);
                }
                if ($holiday) {
                    Alert::success('Update Successfully', '');
                } else {
                    Alert::error('failed', '');
                }
            }
        }



        return back();
    }

    public function DeleteHoliday(Request $request)
    {
        $data = $request->state;
        $deleted = DB::table('holiday_details')->where('holiday_id', $data)->delete();
        if ($deleted) {
            // Alert::success('Deleted Successfully', '');
            return response()->json(['res' => $deleted]);
        }
    }

    public function DeleteHolidayTemp(Request $request)
    {
        $holiday_template = HolidayTemplate::where(['temp_id' => $request->holiday_policy_id])->delete();
        $holiday = HolidayDetail::where(['template_id' => $request->holiday_policy_id])->delete();
        if ($holiday_template && $holiday) {
            Alert::success('Holiday Policy Deleted Successfully');
        } else {
            Alert::error('Holiday Policy Not Delete!');
        }
        return back();
    }


    public function AddManager(Request $request)
    {
        // dd($request->all());
        $getEmp = DB::table('employee_personal_details')->where(['business_id' => $request->session()->get('business_id'), 'emp_id' => $request->EmpId])->first();
        if ($getEmp) {
            $assign = DB::table('manager_details')->insert([
                'business_id' => $request->session()->get('business_id'),
                'mngr_name' => $getEmp->emp_name,
                'mngr_emp_id' => $getEmp->emp_id,
                'mngr_phone' => $getEmp->emp_mobile_number,
                'mngr_depart_id' => $getEmp->emp_name,
                'mngr_branch_id' => $getEmp->branch_id
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
