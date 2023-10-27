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

class ExportEmployeeDetails implements FromCollection, WithHeadings, Responsable
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
        return DB::table('export_employee_templates')->select('emp_id', 'emp_fname', 'emp_mname', 'emp_lname', 'emp_dob', 'emp_join', 'emp_gender', 'emp_mobile', 'emp_gmail', 'emp_blood_group', 'emp_iemi')->get();
    }
    public function headings(): array
    {
        return ["EmployeeID", "FirstName", "MiddleName", "LastName", "Dob", "JoiningDate", "Gender", "Mobile", "PersonalGmail", "BloodGroup", "IMEINumber"];
    }
}
