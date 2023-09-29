<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\SettingLeavePolicy;
use App\Models\admin\LeavePolicy;
use Session;
use Validator;
use DB;
// /public_html/app/Models/admin

class LeavePolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        return $request->all();     


        // $request->validate([
        //     'addmore.*.categoryname' => 'required',
        //     // 'addmore.*.qty' => 'required',
        //     // 'addmore.*.price' => 'required',
        // ]);

        // setting_leave_policy

        $data = new SettingLeavePolicy();
        $data->business_id = Session::get('business_id');
        $data->policy_name = $request->policyname;
        $data->policyname = $request->btnradio;
        $data->leave_period_from = $request->leave_period_from;
        $data->leave_period_to = $request->leave_period_to;
        $data->save();
        return back();
        

        // foreach ($request->addmore as $key => $value) {
        //     // LeavePolicy::create($value);
        //     $data[]= $value;
        //     LeavePolicy::create($data);
        // }
        // return $data;

        return back()->with('success', 'Record Created Successfully.');
    }

    public function stosre(Request $request)
    {
        $rules = [];
        // dd($request->all());
        // $leave = new LeavePolicy();
        // foreach ($request->input('categoryname') as $key => $value) {
        //     // return $key;
        //     $rules["category_name.{$key}"] = 'required';
        //     $rules["days.{$key}"] = 'required';
        // }

        // $validator = Validator::make($request->all(), $rules);

        if (true) {
            // for ($i = 0; $i < sizeof($request->input('categoryname')); $i++) {
            //     $data=['category_name' => $request->input('categoryname'),
            //     'days' => $request->input('days')];
            //     // dd(['category_name' => $request->input('categoryname'), 'days' => $request->input('days')]);
            //     // LeavePolicy::create($data);
            //     print($data['category_name']);
            //     print($data['days']);
            //     //   $sal=  DB::table('leave_policy');
            //     // $sal->category_name[$i]=$data[$i];
            // }
            $dataArray = $request->all();

            for ($i = 0; $i < sizeof($totalset); $i++) {
                $rake_loading_transportation = [
                    'category_name' => $rakeID,
                    'days' => $days[$i],
                  
                ];
                DB::table('leave_policy')->insert($rake_loading_transportation);
            }

            // foreach ($request->all() as $key => $value) {
            //     // LeavePolicy::create(['category_name'=>$value]);
            //     $data = ['category_name'=>$request->input('categoryname'),'day'=>$request->input['days']];

            //     //   $sal=  DB::table('leave_policy');
            //     // $sal->category_name=$request->input('categoryname');
            //       // dd($request->input('categoryname'));

            //       dd($data['category_name']);
            //     // dd($request->input('days'));
            //     LeavePolicy::create(['category_name'=>$data]);
            //     // return $data;
            //     // return back();
            // }

            // $leave->policy_name = $request->policyname;
            // $leave->leave_policy_cycle = ($request->btnradio) == 'on' ? 'Month': 'Year';
            // $leave->leave_period_from = $request->leavefrom ;
            // $leave->leave_period_to = $request->leaveto;
            // // $leave->category_name = $request->categoryname;
            // $leave->days = $request->days;
            // $leave->unused_leave_rule = $request->leaverule;
            // $leave->carry_forward_limit = $request->cfl;
            // $leave->applicable_to = $request->applicable;
            // if($leave->save([])){
            //     return back();
        }

        // $data = array(
        //         'day' => $days[$count],
        //         'start_time'  => $start_time[$count],
        //         'end_time'  => $end_time[$count],
        //         'zone_id'  => $zone_id,
        //       );
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
}
