<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
q
use Illuminate\Routing\Controller as BaseController;
use App\Models\admin\Business_categories_list;
use App\Models\admin\Business_type;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiResponse;
use App\Models\Migration;
use DateTime;
use Illuminate\Database\Migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BusinessController extends BaseController
{
    // use HasApiTokens, Notifiable,
    
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function uploadImage(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
        ]);
        // Get the uploaded image file
        $image = $request->file('image');
        $path = public_path('business_logo/');
        $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
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
    public function BusinessDetailsSubmit(Request $request)
    {
        $userName = $request->client_name;
        // $tableName = 'business_details_' . ApiResponse::concatenateFirstCharacters($request->table_name) . 'dyn' . ApiResponse::getFirstWord($userName);
        // $tableName1 = 'busienss_login_' . ApiResponse::concatenateFirstCharacters($request->table_name) . 'dyn' . ApiResponse::getFirstWord($userName);
        $businessEmail = $request->business_email;
        $businessGSTNo = $request->gstnumber;
        $businessID = md5($userName . $businessEmail . $businessGSTNo);


        $check = DB::table('business_details_list')->where('business_id', '!=', $businessID)->get();
        if ($check) {
            // Check if the table does not exist
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
            ]);
            // // Get the uploaded image file
            $image = $request->file('image');
            $path = public_path('business_logo/');
            $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
            $request->image->move($path, $imageName);


            // DB::table('$tableName')->insert([
            DB::table('business_details_list')->insert([
                'business_id' => $businessID,
                'business_logo' => $imageName,
                'business_categories' => $request->business_categories_selected,
                'client_name' => $userName,
                'business_email' => $businessEmail,
                'business_name' => $request->business_name,
                'business_type' => $request->business_type_selected,
                'mobile_no' => $request->mobile_no,
                'business_address' => $request->business_address,
                'gstnumber' => $businessGSTNo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('login_admin')->insert([
                'user' => 'admin',
                'business_id' => $businessID,
                'name' => $userName,
                'email' => $businessEmail,
                'country_code' => '+91',
                'phone' => $request->mobile_no,
                'otp' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            return response()->json(["business_details" => $request->all(), "business_logo" => $imageName]);
            // return "Table '$tableName' has been created.";
        } else {
            return "Table '$tableName' already exists.";
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

   
    public function Test(Request $request)
    {
        // // business name ,, 
        // // $tableName1 = 'busienss_login_' . ApiResponse::concatenateFirstCharacters($request->table_name) . 'dyn' . ApiResponse::getFirstWord($userName);
        // // $useremail=$request->user_email;
        // // $checking =DB::table('business_login'.ApiResponse::concatenateFirstCharacters($request->table_name) . 'dyn' . ApiResponse::getFirstWord($useremail))->get();
        // // $username=
        // // $tables=  DB::getSchemaBuilder()->getColumnListing('busienss_login_sc_dyn_umesh');
        // // $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        // // // $laoded=DB::connection()->getDatabaseName();
        // // // $DB=DB::table('master_table_all_details')->where('business_id','d845e2bc8a80f01f71ea5699a9130825')->get();
        // // dd($tables);

        // $email = "jayantnishad34@gmail.com";

        // // $targetTableName = 'busienss_login_sc_dyn_umesh'; // Replace with the table name you want to target
        // $pattern = '/^business_details/';

        // // Get the list of table names using the selected database connection
        // $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        // foreach ($tables as $table) {
        //     if (preg_match($pattern, $table)) {
        //         // Retrieve data from the matched table
        //         $data = DB::table($table)->get();

        //         echo "Matched: " . $table . PHP_EOL;

        //         // Display the data for the matched table
        //         foreach ($data as $row) {

        //             // return response()->json([$row]);
        //             print_r(json_encode($row));
        //             // return response()->json($row);

        //         }
        //     }
        // }
        // print(in_array($targetTableName, $tables));



        // if (in_array($targetTableName, $tables)) {
        //     // Get data from the target table
        //     $data = DB::table($targetTableName)->get();

        //     // You can process the $data here as needed
        //     dd($data);
        //     // return response()->download($data);
        // } else {
        //     echo "Target table not found in the database.";
        // }
        // if (Schema::hasTable('busienss_login_sc_dyn_umesh')==true)
        // {

        //    $value= DB::table('busienss_login_wsc_dyn_aman')->get();
        //     dd($value);
        //   }

        // return ApiResponse::JsonResponse($tables);
    }

  

}