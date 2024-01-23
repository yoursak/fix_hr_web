<?php

namespace App\Imports;

use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\employee\DemoImportModel;
// use App\Models\Demo;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use App\Models\StaticCountryModel;
use App\Models\StaticStatesModel;
use App\Models\StaticCityModel;
use App\Models\StaticEmployeeJoinBloodGroup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Crypt;

class EmployeeImport implements ToCollection, WithStyles, WithHeadings, WithEvents
{
    // public function model(array $row)
    // {
    //     dd($row);
    // }
    public function collection(Collection $rows)
    {
        $dataToSave = [];

        // // Assuming the first collection contains column headers
        // $headers = $rows[0]->toArray();

        // // Get the count of rows
        // $rowCount = $rows->count();

        // // Loop through rows starting from the second row (index 1)
        // for ($i = 1; $i <= $rowCount; $i++) {
        //     $rowData = [];
        //     $row = $rows[$i]->toArray();

        //     foreach ($headers as $index => $header) {
        //         $rowData[$header] = $row[$index] ?? null;
        //     }

        //     $dataToSave[] = $rowData;

        //     // Display the index value in the current iteration
        //     echo "Index value in iteration $i: " . $i . PHP_EOL;
        // }
        // dd($rows);
        // Skip the first row (header row) and start from the second row (index 1)
        foreach ($rows->skip(0) as $row) {
            // $employeeType = $row[0]; // Assuming States is in the third column
            // $employeeID = $row[1];
            // $employeeFN = $row[2];
            // $employeeMN = $row[3];
            // $employeeLN = $row[4];
            // $employeeContactNo = $row[5];
            // $employeeEmail = $row[6];
            // $employeeDOB = $row[7];
            // $employeeGender = $row[8];
            // $employeeDOJ = $row[9];
            // $employeeAddress = $row[10];
            // $employeeNationality = $row[11];
            // $employeeCountry = $row[12];
            // $employeeState = $row[13];
            // $employeeCity = $row[14];
            // $employeePinCode = $row[15];
            // $employeeBloodGroup = $row[16];

            // $rowData = [
            //     'emp_type' => $row[0],
            //     'emp_id' => $row[1],
            //     'emp_fname' => $row[2],
            //     'emp_mname' => $row[3],
            //     'emp_lname' => $row[4],
            //     'emp_mobile' => $row[5],
            //     'emp_gmail' => $row[6],
            //     'emp_dob' => $row[7],
            //     'emp_gender' => $row[8],
            //     'emp_join' => $row[9],
            //     'emp_address' => $row[10],
            //     'emp_nationality' => $row[11],
            //     'emp_country' => $row[12],
            //     'emp_state' => $row[13],
            //     'emp_cities' => $row[14],
            //     'emp_pincode' => $row[15],
            //     'emp_blood_group' => $row[16],
            //     // Add more fields as needed
            // ];
            // $dataToSave[] = $rowData;
            $dataToSave = $rows->splice(1); // Exclude the first row (headers)


            $dataToSave = $dataToSave->map(function ($row) {
                // 'india' ,'Chhattisgarh','Raipur

                // $CallCentralValue=RulesManagement::getCheckingBusinessCheck();
                $CallGetName = RulesManagement::getCheckingCountryStateCity($row[20], $row[21], $row[22]);
                // $BloodGloop = RulesManagement::getCheckingBloodGroup($row[16]);
                // $EmployeeType = RulesManagement::getCheckingEmployeeType($row[0]);
                // 'emp_type' => $EmployeeType[0],
                // 'emp_id' => $row[1],
                // 'emp_fname' => $row[2],
                // 'emp_mname' => $row[3],
                // 'emp_lname' => $row[4],
                // 'emp_mobile' => (string)$row[5],
                // 'emp_gmail' => $row[6],
                // 'emp_dob' => $row[7],
                // 'emp_gender' => $row[8],
                // 'emp_join' => $row[9],
                // 'emp_address' => $row[10],
                // 'emp_nationality' => $row[11],
                // 'emp_country' => $CallGetName[1],
                // 'emp_state' => $CallGetName[2],
                // 'emp_cities' => $CallGetName[3],
                // 'emp_pincode' => $row[15],
                // 'emp_blood_group' => $BloodGloop[0],

                return [
                    'emp_id' => $row[0],
                    'emp_fname' => $row[1],
                    'emp_mname' => $row[2],
                    'emp_lname' => $row[3],
                    // 'emp_prefix_phone_no' => $CallGetName[0],
                    'emp_mobile' => $row[4],
                    'emp_gmail' => $row[5],
                    'emp_dob' => $row[6],
                    'emp_gender' => $row[7],
                    'emp_marital' => $row[8],
                    'emp_join' => $row[9],
                    'emp_nationality' => $row[10],
                    'emp_religion' => $row[11],
                    'emp_caste_category' => $row[12],
                    'emp_blood_group' => $row[13],
                    'emp_gov_id' => $row[14],
                    'emp_gov_id_no' => $row[15],
                    'emp_branch' => $row[16],
                    'emp_department' => $row[16],
                    'emp_designation' => $row[17],
                    'emp_type' => $row[18],
                    'emp_assign_attendance_method' => $row[19],
                    'emp_country' => $CallGetName[0],
                    'emp_state' => $CallGetName[1],
                    'emp_cities' => $CallGetName[2],
                    'emp_pincode' => $row[23],
                    'emp_address' => $row[24],
                    'emp_active' => $row[25]
                    // ... (other fields)
                ];
            });
            // DB::table('export_employee_regular_templates')->insert($dataToSave);

            // $genderType = $row[6]; // Assuming gender_type is in the third column

            // dd($genderType);

            dd($dataToSave);

            // Look up the id value from the employee_gender table
            // $load = DB::table('employee_gender')
            //     ->where('gender_type', $genderType)
            //     ->select('id')
            //     ->first();

            // Check if a match was found
            // if ($load) {
            //     // Insert data into the DemoImportModel
            // } else {
            //     // Handle cases where gender_type doesn't match
            //     // You can log an error or take appropriate action
            // }
        }
    }

    public function headings(): array
    {

        return [
            'Employee ID',
            'First Name',
            'Middle name',
            'Last name',
            'Mobile',
            'Gmail',
            'DOB',
            'Gender',
            'Marital',
            'DOJ',
            'Nationality',
            'Religion',
            'Caste Category',
            'Blood Group',
            'Govt ID',
            'Govt No.',
            'Branch',
            'Department',
            'Designation',
            'Employee Type',
            'Attendance Method',
            'Country',
            'State',
            'Cities',
            'Pincode',
            'Address',
            'Active/Deactive'
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:Q1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF1877F2');

                $columns = range('A', 'Q');

                foreach ($columns as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(20); // 16 pixels (approximate width in Excel)
                }
                $event->sheet->getDelegate()->getStyle('A1:Q1')
                    ->getFont()
                    ->getColor()
                    ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A:Q')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                // ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    
            },
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // $cellRange = 'A1:' . Coordinate::stringFromColumnIndex($sheet->getHighestColumn()) . $sheet->getHighestRow();
        // $columns = range('A', $sheet->getHighestColumn());

        // foreach ($columns as $column) {
        //     $sheet->getColumnDimension($column)->setWidth(16);
        // }
        // $sheet->getColumnDimension('A')->setWidth(16);
        // $sheet->getColumnDimension('B')->setWidth(16);

        return [
            // Style the first row (which contains headers)
            1 => [
                'font' => [
                    'bold' => true, // Set font bold
                ],
                'background' => [
                    'color' => '#FFFF00'
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN, // Set border style
                        'color' => ['argb' => 'FF000000'], // Set border color (black in this case)
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER, // Align text horizontally to center
                    'vertical' => Alignment::VERTICAL_CENTER, // Align text vertically to center
                    // 'wrapText' => true, // Enable text wrapping
                    // 'indent' => 40, // Set inner spacing or indentation
                ],
            ],
        ];
    }
}
