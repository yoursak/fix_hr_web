<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\employee\EmployeePersonalDetail;
use App\Helpers\Central_unit;
use Maatwebsite\Excel\Concerns\FromArray;

use App\Models\LoginEmployee;
use App\Models\DesignationList;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\StaticEmployeeJoinGenderType;
use App\Models\PolicyAttendanceTrackInOut;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicyMasterEndgameMethod;
use App\Models\StaticAttendanceMethod;
use App\Models\StaticEmployeeJoinMaritalType;
use App\Models\StaticEmployeeJoinCategoryCaste;
use App\Models\StaticEmployeeJoinBloodGroup;
use App\Models\StaticEmployeeJoinGovtDocType;
use App\Models\StaticEmployeeJoinReligion;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TableExcelExport implements FromCollection, WithHeadings, WithStyles, WithEvents, Responsable
{
    use Exportable;

    protected $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
        // dd($collection);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->collection;
    }
    public function headings(): array
    {
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
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:AD1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF1877F2');


                $event->sheet->getDelegate()->getStyle('A1:AD1')
                    ->getFont()
                    ->getColor()
                    ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A:AD')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                // Set width for columns
                $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC','AD'];
                $event->sheet->getDelegate()->setAutoFilter('A1:AD1');
                foreach ($columns as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(false);
                    $event->sheet->getColumnDimension($column)->setWidth(25);
                }
            },
        ];
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
