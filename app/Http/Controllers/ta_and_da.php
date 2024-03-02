<?php

namespace App\Http\Controllers;

use App\Models\admin\BusinessDetailsList;
use App\Models\GradeList;
use App\Models\StaticCityModel;
use App\Models\StaticCountryModel;
use App\Models\StaticStatesModel;
use App\Models\TaDaLodging;
use App\Models\TaDaLodgingType;
use App\Models\TaDaMiscA;
use App\Models\TaDaTolltaxExpenseList;
use App\Models\TaDaTravelMode;
use App\Models\TaDaTravelModeType;
use App\Models\TaDaSetamount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class ta_and_da extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('tada.index');
    }
    public function travel(Request $request)
    {
        return view('tada.ta');
    }
    public function daily(Request $request)
    {
        return view('tada.da');
    }
    public function lodging(Request $request)
    {
        $grade_list = GradeList::select('*')->get();
        $amount=TaDaSetamount::select('*')->get();
        $travel_modes=TaDaTravelModeType::select('*')->get();
        $lodging_type=TaDaLodgingType::select('*')->get();
        $data = TaDaLodging::select('*')->with('ta_da_setamount','grade_list','travel_type','travel_category','set_amount_one')->get();
        return view('tada.lodging',compact('grade_list','data','lodging_type','travel_modes','amount'));
    }
    public function toll(Request $request)// for view in toll
    {
        $grade_list = GradeList::select('*')->get();
        $travel_modes = TaDaTravelModeType::select('*')->get();
        $road_data=TaDaTravelMode::select('*')->where('travel_m_id',3)->get();
        $dataview = TaDaTolltaxExpenseList::select('*')->with('grade_list','ta_da_travel_mode')->get();
        return view('tada.toll_tax',compact('grade_list','travel_modes','road_data','dataview'));
    }
    // for storing the tolll data

    public function other(Request $request)
    {
        $grade_list = GradeList::select('*')->get();
        $data_view = TaDaMiscA::select('*')->with('grade_list')->get();
        return view('tada.other_misc', compact('grade_list', 'data_view'));
    }
    public function city(Request $request)
    {
        // $grade_list = GradeList::select('*')->get();
        // $data_view=TaDaMiscA::select('*')->with('grade_list')->get();
        $state_list = StaticStatesModel::select('*')->get();
        $country_list = StaticCountryModel::select('*')->get();
        return view('tada.city', compact('country_list', 'state_list'));
    }
    public function travel_mode_view(Request $request) //  for view file
    {
        $new_data = TaDaTravelMode::select('*')->get(); // Assuming you want to get the first record
        if (isset($new_data) && !empty($new_data)) {
            $newdata_first = TaDaTravelMode::select('*')->where('travel_m_id', 1)->get();
            $newdata_second = TaDaTravelMode::select('*')->where('travel_m_id', 2)->get();
            $newdata_third = TaDaTravelMode::select('*')->where('travel_m_id', 3)->get();
            $data_view = TaDaMiscA::select('*')->with('grade_list')->get();
            return view('tada.other_mode', compact('newdata_first', 'newdata_second', 'newdata_third'));
        } else {
            return view('tada.other_mode');
        }
    }
    public function travel_country(Request $request)
    {
        $grade_list = GradeList::select('*')->get();
        $city_list = StaticCityModel::select('*')->get();
        $country_list = StaticCountryModel::select('*')->get();
        // $state_list = StaticStatesModel::select('*')->get();    city_list
        $accDetail = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();
        $state_list = DB::table('static_states')->where('country_id', $accDetail->country)->orderBy('name', 'asc')->get();
        return view('tada.travel_country', compact('grade_list', 'city_list', 'country_list', 'state_list'));
    }

    public function travel_country_save(Request $request)
    {
        $business_id = Session::get('business_id');
        $branch_id = Session::get('branch_id');

        if (isset($request->by_air_hidden) || !empty($request->by_air_hidden) || isset($request->by_train_hidden) || !empty($request->by_train_hidden) || isset($request->by_road_hidden) || !empty($request->by_road_hidden)) {
            // dd('aaya 1');
            // Create
            if (!empty($request->by_air_hidden)) {
                $air_mode = TaDaTravelMode::whereNotIn('travel_id', $request->by_air_hidden)->where('travel_m_id', 1)->delete();
            } else {
                $air_mode = TaDaTravelMode::where('travel_m_id', 1)->delete();
            }
            if (!empty($request->by_train_hidden)) {
                // dd($request->by_train_hidden);
                $train_mode = TaDaTravelMode::whereNotIn('travel_id', $request->by_train_hidden)->where('travel_m_id', 2)->delete();
                // dd($request->by_air_hidden,'$train_mode',$train_mode);
            } else {
                $train_mode = TaDaTravelMode::where('travel_m_id', 2)->delete();
            }
            if (!empty($request->by_road_hidden)) {
                $road_mode = TaDaTravelMode::whereNotIn('travel_id', $request->by_road_hidden)->where('travel_m_id', 3)->delete();
            } else {
                $road_mode = TaDaTravelMode::where('travel_m_id', 3)->delete();
            }
            if (isset($request->air) && !empty($request->air)) {
                foreach ($request->air as $air) {
                    $travel = new TaDaTravelMode;
                    $travel->travel_type = $air;
                    $travel->travel_m_id = 1;
                    $travel->business_id = $business_id; // Corrected typo here
                    $travel->branch_id = $branch_id;
                    $travel->branch_id = $branch_id;
                    $travel->status = $request->by_air_toget == 0 ? 1 : 0;
                    $travel->save();
                }
            }
            if (isset($request->train) && !empty($request->train)) {
                // Save train travel modes
                foreach ($request->train as $train) {
                    $travel = new TaDaTravelMode; // Reinitialize $travel for each loop
                    $travel->travel_type = $train;
                    $travel->travel_m_id = 2;
                    $travel->business_id = $business_id;
                    $travel->branch_id = $branch_id;
                    $travel->status = $request->by_train_toget == 0 ? 1 : 0;
                    $travel->save();
                }
            }
            if (isset($request->road) && !empty($request->road)) {
                // Save road travel modes
                foreach ($request->road as $road) {
                    $travel = new TaDaTravelMode; // Reinitialize $travel for each loop
                    $travel->travel_type = $road;
                    $travel->travel_m_id = 3;
                    $travel->business_id = $business_id;
                    $travel->branch_id = $branch_id;
                    $travel->status = $request->by_road_toget == 0 ? 1 : 0;
                    $travel->save();
                }
            }
            // End Create
            //  Update
            if (isset($request->by_air_hidden) && !empty($request->by_air_hidden)) {
                foreach ($request->by_air_hidden as $index => $air_update) {
                    $travel = TaDaTravelMode::select('*')->where('travel_id', $air_update)->first();
                    $travel->travel_type = $request->air_update[$index];
                    $travel->travel_m_id = 1;
                    $travel->business_id = $business_id; // Corrected typo here
                    $travel->branch_id = $branch_id;
                    $travel->branch_id = $branch_id;
                    $travel->status = $request->by_air_toget == 0 ? 1 : 0;
                    $travel->save();
                }
            }
            // Save train travel modes
            if (isset($request->by_train_hidden) && !empty($request->by_train_hidden)) {
                foreach ($request->by_train_hidden as $index => $train_update) {
                    $travel = TaDaTravelMode::select('*')->where('travel_id', $train_update)->first();
                    $travel->travel_type = $request->train_update[$index];
                    $travel->travel_m_id = 2;
                    $travel->business_id = $business_id;
                    $travel->branch_id = $branch_id;
                    $travel->status = $request->by_train_toget == 0 ? 1 : 0;
                    $travel->save();
                }
            }
            // Save road travel modes
            if (isset($request->by_road_hidden) && !empty($request->by_road_hidden)) {
                foreach ($request->by_road_hidden as $index => $by_road_hidden) {
                    $travel = TaDaTravelMode::select('*')->where('travel_id', $by_road_hidden)->first();
                    $travel->travel_type = $request->road_update[$index];
                    $travel->travel_m_id = 3;
                    $travel->business_id = $business_id;
                    $travel->branch_id = $branch_id;
                    $travel->status = $request->by_road_toget == 0 ? 1 : 0;
                    $travel->save();
                }
            }
            // End Update
            return redirect('admin/settings/tada/travel_mode');
        } else {
            // dd('aaya 2');
            $travel = new TaDaTravelMode;
            foreach ($request->air as $air) {
                $travel->travel_type = $air;
                $travel->travel_m_id = 1;
                $travel->business_id = $business_id; // Corrected typo here
                $travel->branch_id = $branch_id;
                $travel->branch_id = $branch_id;
                $travel->status = $request->by_air_toget == 0 ? 1 : 0;
                $travel->save();
            }
            // Save train travel modes
            foreach ($request->train as $train) {
                $travel = new TaDaTravelMode; // Reinitialize $travel for each loop
                $travel->travel_type = $train;
                $travel->travel_m_id = 2;
                $travel->business_id = $business_id;
                $travel->branch_id = $branch_id;
                $travel->status = $request->by_train_toget == 0 ? 1 : 0;
                $travel->save();
            }
            // Save road travel modes
            foreach ($request->road as $road) {
                $travel = new TaDaTravelMode; // Reinitialize $travel for each loop
                $travel->travel_type = $road;
                $travel->travel_m_id = 3;
                $travel->business_id = $business_id;
                $travel->branch_id = $branch_id;
                $travel->status = $request->by_road_toget == 0 ? 1 : 0;
                $travel->save();
            }
            $newdata_first = TaDaTravelMode::select('*')->where('travel_m_id', 1)->get();
            $newdata_second = TaDaTravelMode::select('*')->where('travel_m_id', 2)->get();
            $newdata_third = TaDaTravelMode::select('*')->where('travel_m_id', 3)->get();
            $data_view = TaDaMiscA::select('*')->with('grade_list')->get();
            return view('tada.other_mode', compact('newdata_first', 'newdata_second', 'newdata_third'));
        }
    }

    public function other_amount(Request $request)
    {
        // dd($request->all());
        $business_id = Session::get('business_id');
        $branch_id = Session::get('branch_id');

        $data = TaDaMiscA::create([
            'business_id' => $business_id,
            'branch_id' => $branch_id,
            'grade_id' => $request->grade_id,
            'misc_amount' => $request->misc_amount,
            'set_amount' => $request->set_amount
            // 'status'=>$status,

        ]);
        $grade_list = GradeList::select('*')->get();
        $data_view = TaDaMiscA::select('*')->get();

        return view('tada.other_misc', compact('grade_list', 'data_view'));
    }
    public function edit_other_amount(Request $request)
    {
        // dd($request->all());
        // $editValue = $request->edit;
        // // dd($editValue);
        // $business_id = Session::get('business_id');
        // $branch_id = Session::get('branch_id');

        // $data= TaDaMiscA::select('*')->where('misc_id',$editValue)->first();
        // $data::update([
        //     'business_id' => $business_id,
        //     'branch_id' => $branch_id,
        //     'grade_id' => $request->grade_id,
        //     'misc_amount'=>$request->misc_amount,
        //     'set_amount'=>$request->set_amount
        //     // 'status'=>$status,

        // ]);
        // $grade_list = GradeList::select('*')->get();
        // $data_view=TaDaMiscA::select('*')->get();
        // return view('tada.other_misc',compact('grade_list','data_view'));

        // chat gpt
        // Retrieve the edit ID from the request
        $editValue = $request->edit;
        $business_id = Session::get('business_id');
        $branch_id = Session::get('branch_id');

        // Retrieve the record to update
        $data = TaDaMiscA::where('misc_id', $editValue)->first();

        // Check if the record exists
        if ($data) {
            // Update the record fields
            $data->business_id = $business_id;
            $data->branch_id = $branch_id;
            $data->grade_id = $request->grade_id;
            $data->misc_amount = $request->misc_amount;
            $data->set_amount = $request->set_amount;
            // Save the changes
            $data->save();
        }
        if ($data) {
            Alert::success('', 'Your have successfully updated other_miscellaneous amount');
        }
        // Fetch the grade list and data view
        $grade_list = GradeList::all();
        $data_view = TaDaMiscA::all();

        // Return the view with updated data
        return view('tada.other_misc', compact('grade_list', 'data_view'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCity(Request $request)
    {
        // dd($request);
        if ($request->data == 'tier_city') {
            $City = DB::table('static_cities')->where('tire', $request->state_id)->orderBy('Name')->get();
            return response()->json(['city' => $City]);
        } else {
            $City = DB::table('static_cities')->where('state_id', $request->state_id)->orderBy('Name')->get();
            return response()->json(['city' => $City]);
        }
    }
//  for save toll expense
    public function tollexpense(Request $request)
    {
        $business_id = Session::get('business_id');
        $branch_id = Session::get('branch_id');
        //  dd($request->parking_charge);
        $dataview= TaDaTolltaxExpenseList::create([
            'business_id' => $business_id,
            'branch_id' => $branch_id,
            'grade_id' => $request->grade_name,
            'travel_type'=>$request->travel_type,
            'travel_m_id_'=>$request->Vehicle_type,
            'toll_charge'=>$request->toll_charge,
            'toll_add_charge'=>$request->toll_add_charge,
            'parking_charge'=>$request->parking_charge ?? 400
            // 'status'=>$status,

        ]);
        // dd($dataview);
        // return view('tada.toll_tax',compact('dataview'));
        // $grade_list = GradeList::select('*')->get();
        // $dataview_second = TaDaTolltaxExpenseList::select('*')->with('grade_list','ta_da_travel_mode_type')->get();
        // dd($dataview_second->ta_da_travel_mode_type->travel_type);
        // $dataview_third=DB::
        return redirect('admin/settings/tada/toll');
        // $data_view=TaDaMiscA::select('*')->get();

        // return view('tada.other_misc',compact('grade_list','data_view'));
    }
    // for update tolll list '
    public function updateTollList(Request $request)
    {
        // dd($request->all());
        $business_id = Session::get('business_id');
        $branch_id = Session::get('branch_id');
        $editValue = $request->edit;
        $data = TaDaTolltaxExpenseList::select('*')->where('toll_id',$editValue)->first();
        if($data)
        {
            $data->business_id = $business_id;
            $data->branch_id = $branch_id;
            $data->grade_id = $request->grade_name;
            $data->travel_type = $request->travel_type;
            $data->travel_m_id_ = $request->Vehicle_type;
            $data->toll_charge = $request->toll_charge;
            $data->toll_add_charge = $request->toll_add_charge;
            $data->parking_charge = $request->parking_charge;
            // Save the changes
            $data->save();
        }
        if($data)
            {
                Alert::success('', 'Your have successfully updated Toll Tax amount');
            }
       return redirect('admin/settings/tada/toll');
    //    redirect('admin/settings/tada/travel_mode')
    }

    public function deletetollamount(Request $request)
    {
        $deleteid = $request->deleteId;

        // dd( $deleteid);
        // Fetch the record to be deleted and then delete it
        $data = TaDaTolltaxExpenseList::where('toll_id', $deleteid)->delete();
        if ($data) {

            Alert::success('', 'Your have successfully deleted other_miscellaneous amount');
        } else {
            Alert::error('', 'Failed to delete the TollTax amount details');
        }

        return redirect('admin/settings/tada/toll');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    //  for delete other amount

    public function deleteotheramount(Request $request)
    {
        $deleteid = $request->deleteId;

        // dd( $deleteid);
        // Fetch the record to be deleted and then delete it
        $data = TaDaMiscA::where('misc_id', $deleteid)->delete();
        if ($data) {

            Alert::success('', 'Your have successfully deleted other_miscellaneous amount');
        } else {
            Alert::error('', 'Failed to delete the other_miscellaneous amount details');
        }
    }
        // for select modes
        public function select_modes(Request $request)
        {
            // dd($request);
            $data_modes_value = $request->input('data_modes');
            $data_modes=TaDaTravelMode::select('*')->where('travel_m_id',$data_modes_value)->get();
            // dd($request->data_modes,'data_modes',$data_modes);
            //  dd($data_modes);
            return response()->json(['data_modes' => $data_modes]);
        }
        // for lodging store
        public function lodgingExp(Request $request)
        {
            //  dd($request->all());
            $business_id = Session::get('business_id');
            $branch_id = Session::get('branch_id');
            $data = TaDaLodging::create([
                'business_id' => $business_id,
                'branch_id' => $branch_id,
                'grade_id' => $request->grade_id,
                'travel_id'=>$request->travel_type,
                'Travel_category_id'=>$request->travel_category,
                'lodging_type'=>$request->lodging_type,
                'set_amount'=>$request->set_amount,
                'lodge_amount'=>$request->misc_amount
                // 'status'=>$status,

        ]);
        return redirect('admin/settings/tada/lodging');

    }
        // for editing in lodging
        public function lodgingedit(Request $request)
        {
           dd($request);
           $grade_list = GradeList::select('*')->get();
           $amount=TaDaSetamount::select('*')->get();
           $travel_modes=TaDaTravelModeType::select('*')->get();
           $lodging_type=TaDaLodgingType::select('*')->get();
           // $data=TaDaLodging::select('*')->with('grade_list')->get();

           $data = TaDaLodging::select('*')->with('ta_da_setamount','grade_list','travel_type','travel_category','set_amount_one')->get();
        }

    public function promotionalCategory()
    {
        $gradeData = GradeList::where('business_id', Session::get('business_id'))->get();
        return View('tada.promotional', compact('gradeData'));
    }

    public function addPromotional(Request $request){
        dd($request->all());
    }
}
