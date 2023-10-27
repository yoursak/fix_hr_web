<?php

namespace App\Http\Controllers\ApiController\UserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeDetailApiController extends Controller
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
    public function showIdToEmpDetail(Request $request)
    {
        $employeeData = DB::table('employee_personal_details')->where('emp_id', $request->emp_id)->first();
        if($employeeData){
            $attendanceData = DB::table('attendance_list')->where('emp_id', $request->emp_id)->get();
            return $attendanceData;
        }else{

        }
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
