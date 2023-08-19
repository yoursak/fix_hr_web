<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\admin\Business_categories_list;
class ApiServiceController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function BusinessCategories(){

        $data=Business_categories_list::get();
        return  response()->json(['business_categories_list'=>$data]);
    }
}
