<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\LoginAdmin;
use App\Models\admin\BusinessDetailsList;


class CommonApiController extends Controller
{
    // $businessID = md5($userName . $businessEmail . $businessGSTNo);
    // businesscheck
    public function businesscheck(Request $request)
    {
        // $emp->emp_email = $request->email ?? $emp->emp_email;
       

        $emp = LoginAdmin::where('email',$request->email)->first();
        $emp = BusinessDetailsList::where('business_id',$emp->business_id)->first();
    // $businessID = md5($emp- . $businessEmail . $businessGSTNo);
       
        return $emp->client_name;
        if ($emp) {
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([$emp])->all());
        }

        return response()->json(['result' => [], 'status' => false]);
    }

    public function index()
    {
        //
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
