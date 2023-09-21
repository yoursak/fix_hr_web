<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\WeeklyHolidayList;
use App\Models\admin\LoginAdmin;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class HolidayPolicyController extends Controller
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
        // dd($request->all());
        $data = new WeeklyHolidayList();
        // return back();
        $data->business_id = Session::get('business_id');
        $data->name = $request->templatename;
        $data->days = json_encode($request->days);
        if ($data->save()) {
            return back();
        }
    }

    public function UpdateHolidayPolicy(Request $request)
    {
        // dd($request->all()); 
        // $data = WeeklyHolidayList::find($id);
        $data = DB::table('weekly_holiday_list')
            ->where('id', $request->id)
            ->update(['name' => $request->templatename,'days' => json_encode($request->holidays),]);
        if ($data) {
            return redirect()->back();
        }
        // $data->business_id = Session::get('business_id');
        // $data->name = $request->templatename;
        // $data->days = json_encode($request->days);
        // if($data->save()){
        //     return back();
        // }
    }

    // delete.holidaypolicy

    public function DeleteHolidayPolicy($id)
    {
        $data = WeeklyHolidayList::where('id', $id)->delete();
        // dd($data);
        // dd($designation);
        if ($data) {
            Alert::success('Delete Success', 'Delete Holiday Policy Successfully');
        }
        // Session::flash('success', 'Succefully Deleted !');
        return redirect()->back();
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
