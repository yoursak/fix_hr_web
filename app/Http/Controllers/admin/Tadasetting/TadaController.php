<?php

namespace App\Http\Controllers\admin\Tadasetting;

use App\Helpers\Central_unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class TadaController extends Controller
{
    public function index()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view('admin.setting.tadasetting.traveldailyallowance', compact('moduleName', 'permissions'));
    }

    public function travelType()
    {
        $businessId = Session::get('business_id');
        $travelType = DB::table('static_travel_type')->get();
        $staticCountry = DB::table('static_countries')->get();
        $MainData = DB::table('policy_allowance_settings')->where('business_id', $businessId)->first();
        $lastIdInternational = 0;
        $lastIdNational = 0;
        $lastIdLocal = 0;
        $internationlAllowanceData = [];
        $natioanlAllowanceData = [];
        $localAllowanceData = [];
        $kilometer_type = DB::table('static_travel_km_type')->get();
        $currency = DB::table('policy_tada_currency')->get();
        $variation = DB::table('policy_tada_variation')->get();
        // dd($currency,'$currency');
        if ($MainData) {
            $internationlAllowanceData = DB::table('policy_allowance_international_settings')
                ->where('business_id', Session::get('business_id'))
                ->where('policy_allowance_settings_id', $MainData->id)
                ->get();
            $natioanlAllowanceData = DB::table('policy_allowance_national_settings')
                ->where('business_id', Session::get('business_id'))
                ->where('policy_allowance_settings_id', $MainData->id)
                ->get();
            $localAllowanceData = DB::table('policy_allowance_local_settings')
                ->where('business_id', $businessId)
                ->where('policy_allowance_settings_id', $MainData->id)
                ->get();
            $lastIdInternational = $internationlAllowanceData->isNotEmpty() ? $internationlAllowanceData->last()->id : null;
            $lastIdNational = $natioanlAllowanceData->isNotEmpty() ? $natioanlAllowanceData->last()->id : null;
            $lastIdLocal = $localAllowanceData->isNotEmpty() ? $localAllowanceData->last()->id : null;
        }
        return view('admin.setting.tadasetting.travel_type', compact('travelType', 'staticCountry', 'MainData', 'internationlAllowanceData', 'lastIdInternational', 'natioanlAllowanceData', 'lastIdNational', 'kilometer_type', 'localAllowanceData', 'lastIdLocal','currency','variation'));
    }

    public function travelModeCategory()
    {
        $businessId = Session::get('business_id');
        $byAirStaticData = DB::table('static_by_air_travelmode')->get();
        $byRoadStaticData = DB::table('static_by_road_travelmode')->get();
        $byTrainStaticData = DB::table('static_by_train_travelmode')->get();
        $travelModeCategoryStatic = DB::table('static_by_road_travelmode_category')->get();
        $DATA = DB::table('policy_travel_mode_and_category')->where('business_id', $businessId)->first();
        return view('admin.setting.tadasetting.travel_mode', compact('byAirStaticData', 'byRoadStaticData', 'byTrainStaticData', 'travelModeCategoryStatic', 'DATA'));
    }

    public function traveModeSubmit(Request $request)
    {
        // Dump and die for testing
        $byAir = $request->byAir ? ($request->byAir == 'on' ? '1' : '0') : '0';
        $byRoad = $request->byRoad ? ($request->byRoad == 'on' ? '1' : '0') : '0';
        $byTrain = $request->byTrain ? ($request->byTrain == 'on' ? '1' : '0') : '0';
        $byAirItems = $request->byAirItems;
        $byRoadItems = $request->byRoadItems;
        $byTrainItems = $request->byTrainItems;
        $byRoadCategory = $request->hiddenCategory;

        $businessId = Session::get('business_id');
        $branchId = Session::get('branch_id');
        $CheckData = DB::table('policy_travel_mode_and_category')->where('business_id', $businessId)->first();
        if ($CheckData) {
            // $CheckData has items
            DB::table('policy_travel_mode_and_category')
                ->where('business_id', Session::get('business_id'))
                ->where('id', $CheckData->id)
                ->update([
                    'by_air_togglebtn' => $byAir,
                    'by_train_togglebtn' => $byTrain,
                    'by_road_togglebtn' => $byRoad,
                    'by_air_items' => $byAir == 1 ? json_encode($byAirItems) : '0',
                    'by_train_items' => $byTrain == 1 ? json_encode($byTrainItems) : '0',
                    'by_road_items' => $byRoad == 1 ? json_encode($byRoadItems) : '0',
                    'by_road_items_category' => json_encode($byRoadCategory),
                ]);
            Alert::Success('', 'Your Travel Mode has been Updated Successfully');
        } else {
            // $CheckData is empty
            DB::table('policy_travel_mode_and_category')->insert([
                'business_id' => $businessId,
                'branch_id' => $branchId,
                'by_air_togglebtn' => $byAir,
                'by_train_togglebtn' => $byTrain,
                'by_road_togglebtn' => $byRoad,
                'by_air_items' => $byAir == 1 ? json_encode($byAirItems) : '0',
                'by_train_items' => $byTrain == 1 ? json_encode($byTrainItems) : '0',
                'by_road_items' => $byRoad == 1 ? json_encode($byRoadItems) : '0',
                'by_road_items_category' => json_encode($byRoadCategory),
            ]);
            Alert::Success('', 'Your Travel Mode has been Created Successfully');
        }
        return redirect()->back();
    }

    public function traveAllowanceSubmit(Request $request)
    {
        // dd($request->all());
        $businessId = Session::get('business_id');
        $internationlAllowanceCheckbox = $request->custom_switch_checkbox_international ?? 0;
        $nationalAllowanceCheckbox = $request->custom_switch_checkbox_national ?? 0;
        $lolcalAllowanceCheckbox = $request->custom_switch_checkbox_local ?? 0;
        $updatePolicyAllowanceId = $request->updatePolicyAllowanceId;
        // first update or not check
        // update check
        if ($request->updatePolicyAllowanceId) {
            $existingRecordCheck = DB::table('policy_allowance_settings')->where('business_id', $businessId)->where('id', $updatePolicyAllowanceId)->first();
            if ($existingRecordCheck) {
                $updatePolicyAllowanceSettings = DB::table('policy_allowance_settings')
                    ->where('business_id', $businessId)
                    ->where('id', $updatePolicyAllowanceId)
                    ->update([
                        'international_id' => $internationlAllowanceCheckbox == 'on' ? 1 : 0,
                        'national_id' => $nationalAllowanceCheckbox == 'on' ? 1 : 0,
                        'local_id' => $nationalAllowanceCheckbox == 'on' ? 1 : 0,
                    ]);
            }
            if ($request->custom_switch_checkbox_international == 'on') {
                // update items id
                $updateItemId = $request->updateItmeIdNameInternationl;
                // check main table inedx id for confirmation
                if ($existingRecordCheck) {
                    // check the previous chiled element
                    $loadItemsCheck = DB::table('policy_allowance_international_settings')->where('business_id', $businessId)->where('policy_allowance_settings_id', $updatePolicyAllowanceId)->pluck('id')->toArray();
                    // check the different between old ids or new ids $nonExistendIds
                    $positiveValuesLoad = array_filter($updateItemId, function ($value) {
                        return $value > 0;
                    });
                    $nonExistentIds = array_diff($loadItemsCheck, $positiveValuesLoad);
                    if (isset($nonExistentIds) && !empty($nonExistentIds)) {
                        // delete previous id's jo update ke liye nhi aaya
                        $delete = DB::table('policy_allowance_international_settings')->where('business_id', $businessId)->whereIn('id', $nonExistentIds)->delete();
                    }
                    foreach ($request->updateItmeIdNameInternationl as $key => $item) {
                        // check the item exists then update
                        $loadItems = DB::table('policy_allowance_international_settings')->where('business_id', $businessId)->where('id', (int) $item)->first();

                        $countryValue = "internationalCountrySelectBox{$item}";
                        $internationlCategory = $request->internationlCategorySelectBox[$item] ?? '';

                        if (isset($loadItems)) {
                            // dd($request->all(), $countryValue, $item);
                            // Update existing item
                            $updateItems = DB::table('policy_allowance_international_settings')
                                ->where('business_id', $businessId)
                                ->where('id', (int) $item)
                                ->where('policy_allowance_settings_id', $updatePolicyAllowanceId)
                                ->update([
                                    'category' => $internationlCategory,
                                    'country_id' => isset($request->$countryValue) ? json_encode(array_unique($request->$countryValue)) : '',
                                ]);
                        } else {
                            // Create new item

                            $createNewItem = DB::table('policy_allowance_international_settings')->insert([
                                'business_id' => $businessId,
                                'policy_allowance_settings_id' => $updatePolicyAllowanceId,
                                'category' => $internationlCategory,
                                'country_id' => isset($request->$countryValue) ? json_encode(array_unique($request->$countryValue)) : '',
                            ]);
                        }
                    }
                }
                Alert::success('', 'Your Allowance Settings has been successfully updated')->persistent(true);
            } else {
                $delete = DB::table('policy_allowance_international_settings')->where('business_id', $businessId)->where('policy_allowance_settings_id', $updatePolicyAllowanceId)->delete();
            }
            if ($request->custom_switch_checkbox_national == 'on') {
                $updateItemId = $request->updateItmeIdNameNational;
                if ($existingRecordCheck) {
                    $loadItemsCheck = DB::table('policy_allowance_national_settings')->where('business_id', $businessId)->where('policy_allowance_settings_id', $updatePolicyAllowanceId)->pluck('id')->toArray();
                    $positiveValuesLoad = array_filter($updateItemId, function ($value) {
                        return $value > 0;
                    });
                    $nonExistentIds = array_diff($loadItemsCheck, $positiveValuesLoad);
                    if (isset($nonExistentIds)) {
                        // delete previous id's jo update ke liye nhi aaya
                        $delete = DB::table('policy_allowance_national_settings')->where('business_id', $businessId)->whereIn('id', $nonExistentIds)->delete();
                    }

                    foreach ($request->updateItmeIdNameNational as $key => $item) {
                        $loadItems = DB::table('policy_allowance_national_settings')->where('business_id', $businessId)->where('id', (int) $item)->first();
                        $nationalCategory = $request->nationalCategorySelectBox[$item];
                        $nationalCountry = $request->nationalCountrySelectBox[$item];
                        $cityValue = "nationalCitySelectBox{$item}" ?? '';
                        if (isset($loadItems)) {
                            $updateItems = DB::table('policy_allowance_national_settings')
                                ->where('business_id', $businessId)
                                ->where('id', (int) $item)
                                ->where('policy_allowance_settings_id', $updatePolicyAllowanceId)
                                ->update([
                                    'category' => $nationalCategory,
                                    'country_id' => $nationalCountry,
                                    'city_id' => $request->$cityValue ? json_encode(array_unique($request->$cityValue)) : '',
                                ]);
                        } else {
                            $createNewItem = DB::table('policy_allowance_national_settings')->insert([
                                'business_id' => $businessId,
                                'branch_id' => Session::get('business_id'),
                                'policy_allowance_settings_id' => $updatePolicyAllowanceId,
                                'category' => $nationalCategory,
                                'country_id' => $nationalCountry,
                                'city_id' => $request->$cityValue ? json_encode(array_unique($request->$cityValue)) : '',
                            ]);
                        }
                    }
                }
            } else {
                $delete = DB::table('policy_allowance_national_settings')->where('business_id', $businessId)->where('policy_allowance_settings_id', $updatePolicyAllowanceId)->delete();
            }

            if ($request->custom_switch_checkbox_local == 'on') {
                $updateItemId = $request->updateItmeIdNameLocal;
                if ($existingRecordCheck) {
                    $loadItemsCheck = DB::table('policy_allowance_local_settings')->where('business_id', $businessId)->where('policy_allowance_settings_id', $updatePolicyAllowanceId)->pluck('id')->toArray();
                    $positiveValuesLoad = array_filter($updateItemId, function ($value) {
                        return $value > 0;
                    });
                    $nonExistentIds = array_diff($loadItemsCheck, $positiveValuesLoad);
                    if (isset($nonExistentIds)) {
                        // delete previous id's jo update ke liye nhi aaya
                        $delete = DB::table('policy_allowance_local_settings')->where('business_id', $businessId)->whereIn('id', $nonExistentIds)->delete();
                    }
                    foreach ($request->updateItmeIdNameLocal as $key => $item) {
                        $loadItems = DB::table('policy_allowance_local_settings')->where('business_id', $businessId)->where('id', (int) $item)->first();
                        $localCategoryValue = $request->localCategory[$item];
                        $kilometerValue = $request->localKilometer[$key] ?? '';
                        if (isset($loadItems)) {
                            $updateItems = DB::table('policy_allowance_local_settings')
                                ->where('business_id', $businessId)
                                ->where('id', (int) $item)
                                ->where('policy_allowance_settings_id', $updatePolicyAllowanceId)
                                ->update([
                                    'category' => $localCategoryValue,
                                    'kilometer_value' => $kilometerValue,
                                ]);
                        } else {
                            $createNewItem = DB::table('policy_allowance_local_settings')->insert([
                                'business_id' => $businessId,
                                'branch_id' => Session::get('business_id'),
                                'policy_allowance_settings_id' => $updatePolicyAllowanceId,
                                'category' => $localCategoryValue,
                                'kilometer_value' => $kilometerValue,
                            ]);
                        }
                    }
                }
            } else {
                $delete = DB::table('policy_allowance_local_settings')->where('business_id', $businessId)->where('policy_allowance_settings_id', $updatePolicyAllowanceId)->delete();
            }
        } else {
            $createRecord = DB::table('policy_allowance_settings')->insert([
                'business_id' => $businessId,
                'international_id' => $internationlAllowanceCheckbox == 'on' ? 1 : 0,
                'national_id' => $nationalAllowanceCheckbox == 'on' ? 1 : 0,
                'local_id' => $nationalAllowanceCheckbox == 'on' ? 1 : 0,
            ]);
            $insertedIdCheck = DB::table('policy_allowance_settings')->where('business_id', $businessId)->select('id')->first()->id;
            if ($request->custom_switch_checkbox_international == 'on') {
                $categorySelectBox = $request->internationlCategorySelectBox;
                foreach ($categorySelectBox as $key => $value) {
                    $countryValue = "internationalCountrySelectBox{$key}" ?? '';
                    DB::table('policy_allowance_international_settings')->insert([
                        'business_id' => $businessId,
                        'policy_allowance_settings_id' => $insertedIdCheck,
                        'category' => $value,
                        'country_id' => $request->$countryValue ? json_encode(array_unique($request->$countryValue)) : '',
                    ]);
                }
            }
            if ($request->custom_switch_checkbox_national == 'on') {
                $categorySelectBox = $request->nationalCategorySelectBox;
                foreach ($categorySelectBox as $key => $value) {
                    $nationalCategory = $request->nationalCategorySelectBox[$key] ?? '';
                    $nationalCountry = $request->nationalCountrySelectBox[$key] ?? '';
                    $cityValue = "nationalCitySelectBox{$key}" ?? '';
                    DB::table('policy_allowance_national_settings')->insert([
                        'business_id' => $businessId,
                        'branch_id' => Session::get('branch_id'),
                        'policy_allowance_settings_id' => $insertedIdCheck,
                        'category' => $nationalCategory,
                        'country_id' => $nationalCountry,
                        'city_id' => $request->$cityValue ? json_encode(array_unique($request->$cityValue)) : '',
                    ]);
                }
            }
            if ($request->custom_switch_checkbox_local == 'on') {
                $localCategory = $request->localCategory;
                foreach ($localCategory as $key => $value) {
                    $kilometerValue = $request->localKilometer[$key] ?? '';
                    DB::table('policy_allowance_local_settings')->insert([
                        'business_id' => $businessId,
                        'branch_id' => Session::get('branch_id'),
                        'policy_allowance_settings_id' => $insertedIdCheck,
                        'category' => $value,
                        'kilometer_value' => $insertedIdCheck,
                    ]);
                }
            }
            Alert::success('', 'Your Allowance Settings has been Created Successfully')->persistent(true);
        }
        return redirect()->back();
    }

    public function countrytocityfilter(Request $request)
    {
        $id = $request->id;
        $get = DB::table('static_cities')->where('country_id', $id)->get();
        return response()->json(['static_cities' => $get]);
    }

    public function travelGrade()
    {
        return view('admin.setting.tadasetting.travel_grade');
    }
    public function lodging()
    {
        return view('admin.setting.tadasetting.lodging');
    }
    public function daily_allowance()
    {
        return view('admin.setting.tadasetting.daily_allowance');
    }

    public function travelGradeCategory(Request $request)
    {
        dd($request->all());
    }

    public function testing(Request $request)
    {
       return view('admin.setting.tadasetting.testing');
    }

    public function travelTypes(Request $request)
    {
       return view('admin.setting.tadasetting.travel_types');
    }

}
