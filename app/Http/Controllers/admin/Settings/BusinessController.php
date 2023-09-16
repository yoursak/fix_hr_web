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

    public function CreateHoliday(Request $request){
        // dd($request->holiday_day[0]);
        if($request->has("temp_name")){
            $template = HolidayTemplate::create([
                "temp_name"=> $request->temp_name,
                "temp_from"=> $request->temp_from,
                "temp_to"=> $request->temp_to,
                "business_id"=> $request->session()->get('business_id')
            ]);
            $temp_id =  HolidayTemplate::where(['temp_name'=>$request->temp_name,'temp_from'=>$request->temp_from,'temp_to'=>$request->temp_to,'business_id'=>$request->session()->get('business_id')])->first(); 
        
    
            $i=0;
            foreach ($request->holiday_name as $key => $holiday) {
                $holiday = HolidayDetail::create([
                    'holiday_name'=> $request->holiday_name[$i],
                    'day'=> $request->holiday_day[$i],
                    'holiday_date'=> $request->holiday_date[$i],
                    'business_id'=> $request->session()->get('business_id'),
                    'template_id'=> $temp_id->temp_id
                ]);
                $i++;
            }  
            
            if($template && $holiday){
                Alert::success('Added Holiday Success','Your Holiday Template Added Successfully');
                return redirect('/admin/settings/business/holiday_policy')->with('success','Holiday Created Successfully');
            }else{

                Alert::error('Fail','Your Holiday Template Fail');
            }
        }


    }

    public function UpdateHoliday(Request $request){

        dd($request->all());
    }


    public function AddManager(Request $request){
        // dd($request->all());
        $getEmp = DB::table('employee_personal_details')->where(['business_id'=>$request->session()->get('business_id'),'emp_id'=>$request->EmpId])->first();
        if($getEmp){
            $assign = DB::table('manager_details')->insert([
                'business_id'=> $request->session()->get('business_id'),
                'mngr_name'=> $getEmp->emp_name,
                'mngr_emp_id'=> $getEmp->emp_id,
                'mngr_phone'=> $getEmp->emp_mobile_number,
                'mngr_depart_id'=> $getEmp->emp_name,
                'mngr_branch_id'=> $getEmp->branch_id
            ]);
            if($assign){
                Alert::success('Assigned Successfully','Manager Asigned Successfully.');
                return redirect('admin/settings/business/manager');
            }else{
                Alert::error('Failed','Fail to Assign Employee');
                return redirect('admin/settings/business/manager');
            }
        }else{
            Alert::error('Failed','Employee Id does not exist in emplopyee data');
            return redirect('admin/settings/business/manager');
        }
    }
}
