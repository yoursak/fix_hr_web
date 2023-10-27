<?php

namespace App\Exports;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\employee\EmployeePersonalDetail;
use App\Helpers\Central_unit;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Models\employee\DemoImportModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AddEmployeeDetails  implements FromCollection, WithHeadings //FromCollection, WithHeadings, ToCollection,ToModel, WithHeadingRow
{
    public function collection()
    {
        // Use the DB query builder to fetch employee data
        $employees = DB::table('export_employee_templates')->select('emp_fname')->get();

        // Map the data to the desired format
        $userCollection = $employees->map(function ($employee) {
            return [
                'FirstName' => $employee->emp_fname,
            ];
        });

        return $userCollection;
    }

    public function headings(): array
    {
        // Define the Excel headings
        return ['FirstName'];
        
    }
   
}

