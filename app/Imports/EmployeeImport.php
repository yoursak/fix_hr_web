<?php

namespace App\Imports;

use App\Models\employee\DemoImportModel;
// use App\Models\Demo;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class EmployeeImport implements ToCollection, WithStyles, WithHeadings
{
    public function collection(Collection $rows)
    {
        // Skip the first row (header row) and start from the second row (index 1)
        foreach ($rows->skip(1) as $row) {
            $genderType = $row[2]; // Assuming gender_type is in the third column

            // Look up the id value from the employee_gender table
            $load = DB::table('employee_gender')
                ->where('gender_type', $genderType)
                ->select('id')
                ->first();

            // Check if a match was found
            if ($load) {
                // Insert data into the DemoImportModel
                DemoImportModel::create([
                    'emp_id' => $row[0],
                    'emp_fname' => $row[1],
                    'emp_gender' => $load->id,
                ]);
            } else {
                // Handle cases where gender_type doesn't match
                // You can log an error or take appropriate action
            }
        }
    }

    public function headings(): array
    {
        return ["EmployeeID", "FirstName", "Gender", "LastName", "Dob", "JoiningDate", "MiddleName", "Mobile", "PersonalGmail", "BloodGroup", "IMEINumber"];
        // return ['EmployeeID', 'FirstName'];
    }
    public function styles(Worksheet $sheet)
    {
        // $sheet->row(1, function ($row) {

        //     // call cell manipulation methods
        //     $row->setBackground('#FFFF00');

        // });

        return [
            // Style the first row as bold text.
            1 => [
                'font' =>
                [
                    'bold' => true,
                ],
                'background' => [
                    'color' => '#FFFF00'
                ]
            ]

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C' => ['font' => ['size' => 16]],
        ];
    }
}
