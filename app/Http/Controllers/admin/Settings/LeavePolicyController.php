<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\LeavePolicy;
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
        // dd($request->all());
        $leave = new LeavePolicy();
        $leave->policy_name = $request->policyname;
        $leave->leave_policy_cycle = ($request->btnradio) == 'on' ? 'Month': 'Year';
        $leave->leave_period_from = $request->leavefrom ;
        $leave->leave_period_to = $request->leaveto;
        $leave->category_name = $request->categoryname;
        $leave->days = $request->days;
        $leave->unused_leave_rule = $request->leaverule;
        $leave->carry_forward_limit = $request->cfl;
        $leave->applicable_to = $request->applicable;
        if($leave->save()){
            return back();
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
