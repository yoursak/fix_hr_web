<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public static function getHolidays(Request $request)
    {
        // $dateString = '2023-04';
        $selectDate = $request->selectDate;

        // // Split the date string into an array
        $dateArray = explode('-', $selectDate);

        // // Extract the year and month
        $year = $dateArray[0];
        $selectedMonth = $dateArray[1];
        // $selectedMonth = 1;
        $apiKey = 'RbY26M5nAlcl2pEc4so2jnhjEwgOqXoq'; // Replace with your Calendarific API key
        $countryCode = 'IN';
        // $year = date('Y');

        $response = Http::get("https://calendarific.com/api/v2/holidays?api_key={$apiKey}&country={$countryCode}&year={$year}");
        // dd($response);
        $data = $response->json();

        // dd($data);

        // foreach ($response['response']['holidays'] as $holiday) {
        //     $name = $holiday['name'];
        //     $dateIso = $holiday['date']['iso'];

        //     // Add name and date ISO to the result array
        //     $result[] = ['name' => $name, 'dateIso' => $dateIso];
        // }
        // $selectedMonth = 3;

        $filteredHolidays = [];
        $counter = 1;
        foreach ($data['response']['holidays'] as $holiday) {
            $dateIso = $holiday['date']['iso'];
            $month = date('m', strtotime($dateIso));
            $datedd = $holiday['primary_type'];
            if ((int) $month >= $selectedMonth && $holiday['primary_type'] !== "Observance" &&  $holiday['primary_type'] !== "Season" ) {
                // Include holidays from the selected month and onwards
                $filteredHolidays[] = $holiday;
                $name = $holiday['name'];
                $dateIso = $holiday['date']['iso'];
                
                $originalDate = Carbon::parse($dateIso);

                // Format the date as per your requirement
                $formattedDate = $originalDate->format('Y-m-d');
                $carbonDate = Carbon::parse($dateIso);

                // Get the day of the week
                $dayOfWeek = $carbonDate->format('l');

                $result[] = ['sno' => $counter,'name' => $name, 'dateIso' => $formattedDate, 'day' => $dayOfWeek, 'primarytype' => $datedd];
                $counter++;
            }
        }
// dd($result);
        // Now $filteredHolidays contains holidays from the selected month and onwards
        // dd($result);

        // If you want to return the result as JSON
        return response()->json($result);
        // return response()->json($data);
    }
}
