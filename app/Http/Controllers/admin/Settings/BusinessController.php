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

class BusinessController extends Controller
{

    public function CreateHoliday(Request $request){
        // dd($request->holiday_name[0]);
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
}
