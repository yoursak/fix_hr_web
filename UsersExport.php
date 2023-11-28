<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $absent;
    public function __construct($absent)
    {
        dd($absent);
        $this->absent = $absent;
    }

    public function collection()
    {
       
    }

    public function headings(): array
    {
        return [
            'S.no.',
           
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:L1'; // Adjust the range to match your column count

                // Set the font to bold and apply formatting to the heading row
                $event->sheet->getStyle($cellRange)
                    ->getFont()
                    ->setBold(true);

                $event->sheet->getStyle($cellRange)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $event->sheet->getStyle($cellRange)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('3490dc');

                $event->sheet->getStyle($cellRange)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()
                    ->setARGB('000000');
            },
        ];
    }
}
