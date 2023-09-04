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
        $businessID = md5($emp->client_name . $emp->business_email .$emp->gstnumber);
       if ($emp->business_id== $businessID) {
        return response()->json(['status' => true]);

        }

        return response()->json(['status' => false]);
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
