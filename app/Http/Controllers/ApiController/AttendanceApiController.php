<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee\AttendanceList;


class AttendanceApiController extends Controller
{
    
    public function index()
    {
        $data = AttendanceList::all();
        if($data){
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection($data)->all());
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
