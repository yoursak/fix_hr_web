<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LoginController extends Controller
{
    public function index(){
        $table=DB::table('login')->get();
        // dd($table);

    }
}
