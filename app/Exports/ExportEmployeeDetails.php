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
    // public function __construct(InvoicesRepository $invoices)
    // {
    //     $this->invoices = $invoices;
    // }

    /**
     * @return \Illuminate\Support\Collection
     */
    private $fileName = 'Employee Excel Demo.xlsx';

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];
    public function collection()
    {
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
            'emp_assign_attendance_method',
            'emp_country',
            'emp_state',
            'emp_cities',
            'emp_pincode',
            'emp_address',
            'emp_active'
        )->get();
    }
    public function headings(): array
    {
        // return ["Employee Type", "Emp ID", "First Name", "Middle Name", "Last Name", "Contact No", "Email", "Date of Birth", "Gender", "Joining Date", "Address", "Nationality", "Country", "State", "City", "Pin code", "Blood Group"];
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

                $event->sheet->getDelegate()->getStyle('A1:AA1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF1877F2');


                $event->sheet->getDelegate()->getStyle('A1:AA1')
                    ->getFont()
                    ->getColor()
                    ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A:AA')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                // Set width for columns
                $columns = range('A', 'Z'); // Adjust the range as per your columns
                foreach ($columns as $column) {
                    //     $event->sheet->getColumnDimension($column)->setWidth(20); // Adjust width as needed for each column
                    $event->sheet->getColumnDimension($column)->setAutoSize(false);
                    $event->sheet->getColumnDimension($column)->setWidth(20);
                    $event->sheet->getColumnDimension('AA')->setWidth(20);
                    
                    // $event->sheet->getDelegate()->getStyle($column)->getAlignment()->setWrapText(true);
                }

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
