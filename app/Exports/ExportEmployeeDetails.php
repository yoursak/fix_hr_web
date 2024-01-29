<?php

namespace App\Exports;


use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\employee\EmployeePersonalDetail;
use App\Helpers\Central_unit;
use Maatwebsite\Excel\Concerns\FromArray;

use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExportEmployeeDetails implements FromCollection, WithHeadings, WithStyles, WithEvents, Responsable
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;
    public $EmployeeType;
    public function __construct($EmployeeType)
    {
        $this->EmployeeType = $EmployeeType;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    // private $fileName = 'Employee Excel Demo.xlsx';

    /**
     * Optional Writer Type
     */
    // private $writerType = Excel::XLSX;

    /**
     * Optional headers
     */
    // private $headers = [
    //     'Content-Type' => 'text/csv',
    // ];
    public function collection()
    {

        if ($this->EmployeeType == 1) {
            return DB::table('export_employee_regular_templates')->select(
                'emp_id',
                'emp_fname',
                'emp_mname',
                'emp_lname',
                'emp_mobile',
                'emp_gmail',
                'emp_dob',
                'emp_gender',
                'emp_marital',
                'emp_join',
                'emp_nationality',
                'emp_religion',
                'emp_caste_category',
                'emp_blood_group',
                'emp_gov_id',
                'emp_gov_id_no',
                'emp_branch',
                'emp_department',
                'emp_designation',
                'emp_type',
                'emp_country',
                'emp_state',
                'emp_cities',
                'emp_address',
                'emp_pincode',
                'emp_assign_setup',
                'emp_assign_attendance_method',
                'emp_assign_shift_type',
                'emp_report_manager',
                'emp_active',
                'bank_ifsc_code',
                'bank_name',
                'bank_branch_name',
                'bank_branch_code',
                'bank_account_no',
                'bank_micr_code',
                'bank_address_line1',
                'bank_address_line2',
                'grade',
                'budget_code',
                'account_code'
            )->get();
        }
        if ($this->EmployeeType == 2) {
            return DB::table('export_employee_contractual_templates')->select(
                'emp_id',
                'emp_fname',
                'emp_mname',
                'emp_lname',
                'emp_mobile',
                'emp_gmail',
                'emp_dob',
                'emp_gender',
                'emp_marital',
                'emp_join',
                'emp_nationality',
                'emp_religion',
                'emp_caste_category',
                'emp_blood_group',
                'emp_gov_id',
                'emp_gov_id_no',
                'emp_branch',
                'emp_department',
                'emp_designation',
                'emp_type',
                'emp_contractual_type',
                'emp_country',
                'emp_state',
                'emp_cities',
                'emp_address',
                'emp_pincode',
                'emp_assign_setup',
                'emp_assign_attendance_method',
                'emp_assign_shift_type',
                'emp_report_manager',
                'emp_active',
                'bank_ifsc_code',
                'bank_name',
                'bank_branch_name',
                'bank_branch_code',
                'bank_account_no',
                'bank_micr_code',
                'bank_address_line1',
                'bank_address_line2',
                'grade',
                'budget_code',
                'account_code'
            )->get();
        }
    }
    public function headings(): array
    {
        // return ["Employee Type", "Emp ID", "First Name", "Middle Name", "Last Name", "Contact No", "Email", "Date of Birth", "Gender", "Joining Date", "Address", "Nationality", "Country", "State", "City", "Pin code", "Blood Group"];
        if ($this->EmployeeType == 1) {

            return [
                'Employee ID',
                'First Name',
                'Middle name',
                'Last name',
                'Mobile No.',
                'Email ID',
                'DOB',
                'Gender',
                'Marital Status',
                'DOJ',
                'Nationality',
                'Religion',
                'Caste Category',
                'Blood Group',
                'Govt ID Type',
                'Govt ID No.',
                'Branch',
                'Department',
                'Designation',
                'Employee Type',
                'Country',
                'State',
                'City',
                'Address',
                'Pincode',
                'Assign Setup',
                'Assign Attendance Method',
                'Assign Shift Type',
                'Reporting Manager',
                'Active/In-Active',
                'IFSC Code',
                'Bank Name',
                'Branch Name',
                'Branch Code',
                'Bank Account No.',
                'MICR No.',
                'Bank Adddress Line 1',
                'Bank Adddress Line 2',
                'Grade',
                'Budget Code',
                'Account Code'

            ];
        }
        if ($this->EmployeeType == 2) {

            return [
                'Employee ID',
                'First Name',
                'Middle name',
                'Last name',
                'Mobile No.',
                'Email ID',
                'DOB',
                'Gender',
                'Marital Status',
                'DOJ',
                'Nationality',
                'Religion',
                'Caste Category',
                'Blood Group',
                'Govt ID Type',
                'Govt ID No.',
                'Branch',
                'Department',
                'Designation',
                'Employee Type',
                'Contractual Type',
                'Country',
                'State',
                'City',
                'Address',
                'Pincode',
                'Assign Setup',
                'Assign Attendance Method',
                'Assign Shift Type',
                'Reporting Manager',
                'Active/In-Active',
                'IFSC Code',
                'Bank Name',
                'Branch Name',
                'Branch Code',
                'Bank Account No.',
                'MICR No.',
                'Bank Adddress Line 1',
                'Bank Adddress Line 2',
                'Grade',
                'Budget Code',
                'Account Code'
            ];
        }
    }
    public function registerEvents(): array
    {
        if ($this->EmployeeType == 1) {


            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $event->sheet->getDelegate()->getStyle('A1:AO1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('FF1877F2');


                    $event->sheet->getDelegate()->getStyle('A1:AO1')
                        ->getFont()
                        ->getColor()
                        ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                    $event->sheet->getDelegate()->getStyle('A:AO')
                        ->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    // Set width for columns
                    $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO'];
                    $event->sheet->getDelegate()->setAutoFilter('A1:AO1');
                    foreach ($columns as $column) {
                        $event->sheet->getColumnDimension($column)->setAutoSize(false);
                        $event->sheet->getColumnDimension($column)->setWidth(25);
                    }
                    // $event->sheet->getDelegate()->getStyle('A1:AA1')
                    //     ->getFill()
                    //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    //     ->getStartColor()
                    //     ->setARGB('FF1877F2');


                    // $event->sheet->getDelegate()->getStyle('A1:AA1')
                    //     ->getFont()
                    //     ->getColor()
                    //     ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                    // $event->sheet->getDelegate()->getStyle('A:AA')
                    //     ->getAlignment()
                    //     ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    // // Set width for columns
                    // $columns = range('A', 'Z'); // Adjust the range as per your columns
                    // foreach ($columns as $column) {
                    //     //     $event->sheet->getColumnDimension($column)->setWidth(20); // Adjust width as needed for each column
                    //     $event->sheet->getColumnDimension($column)->setAutoSize(false);
                    //     $event->sheet->getColumnDimension($column)->setWidth(20);
                    //     $event->sheet->getColumnDimension('AA')->setWidth(20);

                    //     // $event->sheet->getDelegate()->getStyle($column)->getAlignment()->setWrapText(true);
                    // }

                    // ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                },
            ];
        }
        if ($this->EmployeeType == 2) {


            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $event->sheet->getDelegate()->getStyle('A1:AP1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('FF1877F2');


                    $event->sheet->getDelegate()->getStyle('A1:AP1')
                        ->getFont()
                        ->getColor()
                        ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                    $event->sheet->getDelegate()->getStyle('A:AP')
                        ->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    // Set width for columns
                    $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',  'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP'];
                    $event->sheet->getDelegate()->setAutoFilter('A1:AP1');
                    foreach ($columns as $column) {
                        $event->sheet->getColumnDimension($column)->setAutoSize(false);
                        $event->sheet->getColumnDimension($column)->setWidth(25);
                    }
                    // $event->sheet->getDelegate()->getStyle('A1:AA1')
                    //     ->getFill()
                    //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    //     ->getStartColor()
                    //     ->setARGB('FF1877F2');


                    // $event->sheet->getDelegate()->getStyle('A1:AA1')
                    //     ->getFont()
                    //     ->getColor()
                    //     ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                    // $event->sheet->getDelegate()->getStyle('A:AA')
                    //     ->getAlignment()
                    //     ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    // // Set width for columns
                    // $columns = range('A', 'Z'); // Adjust the range as per your columns
                    // foreach ($columns as $column) {
                    //     //     $event->sheet->getColumnDimension($column)->setWidth(20); // Adjust width as needed for each column
                    //     $event->sheet->getColumnDimension($column)->setAutoSize(false);
                    //     $event->sheet->getColumnDimension($column)->setWidth(20);
                    //     $event->sheet->getColumnDimension('AA')->setWidth(20);

                    //     // $event->sheet->getDelegate()->getStyle($column)->getAlignment()->setWrapText(true);
                    // }

                    // ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                },
            ];
        }
    }
    public function styles(Worksheet $sheet)
    {
        return [
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
                ],
            ],
        ];
    }
}
