<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LoginApiController extends Controller
{
    public function login(Request $request)
    {
        // $user = Login_Employee::where('email', $request->email)->first();
        // $user = DB::table('business_details_list')->where('business_email',$request->email)->first();
        // return $user;
        //     if ($user) {
        //         if (Hash::check($request->email)) {
        //             if ($user->user_token == null) {
        //                 $user->user_token = $user->createToken("API TOKEN")->plainTextToken;
        //                 $user->save();
        //             }
        //             return ReturnHelpers::jsonApiReturn(LoginResource::collection([$user])->all());
        //         }
        //     }
        // return response()->json(['result' => [], 'status' => false]);
    }




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
