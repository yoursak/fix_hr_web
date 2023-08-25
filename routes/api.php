<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiServiceController;
use App\Http\Controllers\MigrationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::controller(ApiServiceController::class)->group(function () {
    Route::any('test','uploadImage');
    Route::post('/runmigrations', 'runMigrations');
   
    // Route::post('/runmigrations/{tableName}/{name}', 'runMigrations');
    Route::get('/business_categories','BusinessCategories');
    Route::get('/business_type','BusinessTypes');
    Route::post('/business_details_submit','BusinessDetailsSubmit');
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
