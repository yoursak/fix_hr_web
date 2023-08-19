<?php

namespace App\Http\Controllers\admin\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function leaves(){
        return view('admin.request.leave');
    }

    public function gatepass(){
        return view('admin.request.gatepass');
    }

    public function misspunch(){
        return view('admin.request.misspunch');
    }

}
