<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Holiday;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PolicyHolidayTemplate extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    public function index(Request $request)
    {
        // $data = DB::table('policy_holiday_template')
        // ->join('master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'master_endgame_method.id')
            // ->whereRaw('JSON_CONTAINS(master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))')
            // // ->where('master_endgame_method.method_switch', 1)
        // ->get();
        // return $data;
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
