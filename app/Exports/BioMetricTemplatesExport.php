<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Illuminate\Support\Collection;
use Log;

class BioMetricTemplatesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    protected $month;
    protected $year;
    protected $totalDay;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
        $this->totalDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }

    public function startCell(): string
    {
        return 'A1';
    }


    public function collection(): Collection
    {

        $collectionData = [
            'S#' => '1',
            'Employee Name' => 'Aman Sahu',
            'Employee ID' => 'IT034',
            'Action' => 'Acton',
        ];

        for ($count = 1; $count <= $this->totalDay; $count++) {
            $dayNo = Date('N', strtotime($count . '-' . $this->month . '-' . $this->year));
            $status = 'A';
            if ($dayNo == 7) {
                $status = 'WO';
            } elseif ($dayNo == 14) {
                $status = 'HO';
            } elseif ($dayNo == 21) {
                $status = 'HD';
            } elseif ($dayNo == 24) {
                $status = 'A';
            } elseif ($dayNo == 26) {
                $status = 'MSP';
            } else {
                $status = 'P';
            }
            $collectionData[] = $status;
        }
        return collect([$collectionData]);
    }

    public function headings(): array
    {
        $headings = [
            'S no.',
            'Employee Name',
            'Employee ID',
            'Action',
        ];

        for ($count = 1; $count <= $this->totalDay; $count++) {
            $headings[] = $count;
        }

        return $headings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                try {
                    $columnIndex = Coordinate::stringFromColumnIndex($this->totalDay + 4);
                    $range = 'A1:' . $columnIndex . '1';
                    $sheet = $event->sheet->getDelegate();
                    $sheet->getStyle($range)->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'color' => [
                                'rgb' => 'FFFFFF', // White color code
                            ],
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '1877F2', // Blue color code
                            ],
                        ],
                    ]);

                    $sheet->mergeCells('A2:A6');
                    $sheet->mergeCells('B2:B6');
                    $sheet->mergeCells('C2:C6');

                    $sheet->getStyle('A2:' . $columnIndex . '6')->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    $sheet->setCellValue('D2', 'Attendance Status');
                    $sheet->setCellValue('D3', 'IN');
                    $sheet->setCellValue('D4', 'OUT');
                    $sheet->setCellValue('D5', 'WH');
                    $sheet->setCellValue('D6', 'OT');

                    $event->sheet->getRowDimension(1)->setRowHeight(30);

                    $sheet->getStyle('A1:' . $columnIndex . '6')->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'], // Black color code
                            ],
                        ],
                    ]);


                    $FromIndex = Coordinate::columnIndexFromString('E');
                    $ToIndex = Coordinate::columnIndexFromString($columnIndex);
                    for ($index = $FromIndex; $index <= $ToIndex; $index++) {
                        $column = Coordinate::stringFromColumnIndex($index);
                        $cell = $column . '3';
                        $cell2 = $column . '4';
                        $cell3 = $column . '5';
                        $cell4 = $column . '6';
                        $sheet->setCellValue($cell, '00:00:00');
                        $sheet->setCellValue($cell2, '00:00:00');
                        $sheet->setCellValue($cell3, '00:00:00');
                        $sheet->setCellValue($cell4, '0');
                    }

                    $sheet->setCellValue('A8', 'Note:-');
                    $sheet->getStyle('A8')->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                    ]);
                    $sheet->setCellValue('B8', 'This Template is Created For ' . date("F", mktime(0, 0, 0, $this->month, 1)) . '-' . $this->year);
                    $sheet->setCellValue('B9', '1. In and Out Time Formate should be in 24-hour formate (eg. 00:00:00 ) and total working hour should be h:m:s formate.');
                    $sheet->setCellValue('B10', '2. Any Shell Should Not Be black.');
                    $sheet->setCellValue('B11', '3. You can remove black day column data (eg. If your data is till 17 days then, remove remaining days from table ).');
                    $sheet->setCellValue('B12', '4. Before uploading data you need to remove this instructions.');
                    $sheet->setCellValue('B13', '5. A => Absent, P => Present, HD => Halfday, WO => Weekoff, HO => Holiday, MSP => Mispunch.');
                    $sheet->setCellValue('B14', '6. Do not add weekoff, holidfay or absent data. Simply Remove the column from the sheet.');
                    $sheet->setCellValue('B15', '7. Overtime value should be in the minutes (eg. 15).');
                    $sheet->setCellValue('B16', '8. Before uploading data you need to remove this instructions.');


                    $sheet->getColumnDimension('B')->setAutoSize(false);
                    $sheet->getColumnDimension('B')->setWidth(30);
                } catch (\Exception $e) {
                    Log::error('Error adding image to Excel sheet: ' . $e->getMessage());
                    Log::error('Stack trace: ' . $e->getTraceAsString());
                }
            },
        ];
    }
}
