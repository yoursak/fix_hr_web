<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\admin\Business_categories_list;
use App\Models\admin\Business_type;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

use App\Models\Migration;
use DateTime;
use Illuminate\Database\Migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ApiServiceController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function uploadImage(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
        ]);
        // Get the uploaded image file
        $image = $request->file('image');
        $path = public_path('business_logo/');
        $imageName = date('d-m-Y').'_'.md5($image).'.' .$request->image->extension();
        $request->image->move($path, $imageName);

        // $image  = new Image();
        // $image->name = $imageName;
        // $image->save();

        // Return a response with information about the uploaded image
        return response()->json([
            'message' => 'Image uploaded successfully.',
            'image_path' => $imageName,
        ]);

    }
    public function runMigrations(Request $request)
    {
        $userName=$request->client_name;
        $tableName = $request->table_name.'_dyn_'.$this->getFirstWord($userName).'_business_details';
        $businessID=md5($request->client_name . $request->business_name);
        // dd($tableName,$name);
        // Check if the table does not exist
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('business_id');
                $table->string('business_logo');
                $table->string('business_categories');
                $table->string('client_name');
                $table->string('business_name');
                $table->string('business_type');
                $table->string('mobile_no');
                $table->string('business_address');
                $table->string('gstnumber');
                $table->timestamps();
            });

            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
            ]);
            // // Get the uploaded image file
            $image = $request->file('image');
            $path = public_path('business_logo/');
            $imageName = date('d-m-Y').'_'.md5($image).'.' .$request->image->extension();
            $request->image->move($path, $imageName);
            
            DB::table($tableName)->insert([
                'business_id' => $businessID,
                'business_logo'=>$imageName,
                'business_categories' => $request->business_categories_selected,
                'client_name' => $userName,
                'business_name' => $request->business_name,
                'business_type' => $request->business_type_selected,
                'mobile_no' => $request->mobile_no,
                'business_address' => $request->business_address,
                'gstnumber' => $request->gstnumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('master_details')->insert([
                'business_table_name'=>$tableName,
                'business_id'=>$businessID,
                'business_client_name'=>$userName
            ]);
        
            return response()->json(["business_details" =>$request->all(),"business_logo"=>$imageName]);
            // return "Table '$tableName' has been created.";
        } else {
            return "Table '$tableName' already exists.";
        }
    }
    function getFirstWord($sentence) {
        $words = explode(' ', $sentence);
        if (!empty($words)) {
            return strtolower($words[0]); // Convert the first word to lowercase
   
        } else {
            return ""; // Return an empty string if the sentence is empty
        }
    }

    public function BusinessCategories()
    {

        $data = Business_categories_list::get();
        return response()->json(['business_categories_list' => $data]);
    }

    public function BusinessTypes()
    {

        $data = Business_type::get();
        return response()->json(['business_type_list' => $data]);
    }

    public function BusinessDetailsSubmit(Request $request)
    {

        $business_id = md5($request->client_name . $request->business_name);
        $request->business_categories_selected;
        $request->client_name;
        $request->business_name;
        $request->business_type_selected;
        $request->mobile_no;
        $request->business_address;
        $request->gstnumber;

        return response()->json(["business_id" => $business_id, "business_details" => 'unloaded', "business_details" => $request->all()]);
    }
}