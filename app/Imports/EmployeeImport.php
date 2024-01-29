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
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Crypt;
use Alert;
use App\Models\LoginAdmin;
use App\Models\LoginEmployee;
use App\Models\PendingAdmin;
use App\Models\AdminNotice;
use App\Models\BusinessDetailsList;
use App\Models\RequestLeaveList;
use App\Models\RequestMispunchList;
use App\Models\BranchList;
use App\Models\RequestGatepassList;
use App\Models\DesignationList;
use App\Models\AttendanceList;
use App\Models\EmployeePersonalDetail;
use App\Models\StaticSidebarMenu;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicySettingRoleCreate;
use App\Models\DepartmentList;
use App\Models\PolicyAttenRuleBreak;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\PolicyAttenRuleGatepass;
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\PolicyAttenRuleMisspunch;
use App\Models\PolicyAttenRuleOvertime;
use App\Models\PolicyHolidayTemplate;
use App\Models\PolicyPolicyHolidayDetail;
use App\Models\PolicySettingRoleItem;
use App\Models\PolicySettingLeavePolicy;
use App\Models\ApprovalManagementCycle;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\StaticApprovalName;
use App\Models\StaticEmployeeJoinEmpType;
use App\Exports\TableExcelExport;
use App\Models\StaticEmployeeJoinGenderType;
use App\Models\PolicyAttendanceTrackInOut;
use App\Models\PolicyMasterEndgameMethod;
use App\Models\StaticAttendanceMethod;
use App\Models\StaticEmployeeJoinActiveType;
use App\Models\StaticEmployeeJoinMaritalType;
use App\Models\StaticEmployeeJoinCategoryCaste;
use App\Models\StaticEmployeeJoinGovtDocType;
use App\Models\StaticEmployeeJoinReligion;
use App\Models\StaticEmployeeJoinContractualType;
use Session;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\Failure;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
// WithStyles, WithEvents,
use Carbon\Carbon;

class EmployeeImport implements ToModel, WithHeadingRow, WithValidation //ToCollection, WithHeadingRow
{
    use Importable;
    public $employeeType;
    protected $CurrentYourBusinesss;

    public function __construct($employeeType)
    {
        $this->CurrentYourBusinesss = Session::get('business_id');
        $this->employeeType = $employeeType;
    }


    public function rules(): array
    {

        // 'bank_ifsc_code' => $row['ifsc_code'],
        // 'bank_name' => $row['bank_name'],
        // 'bank_branch_name' => $row['branch_name'],
        // 'bank_account_no' => $row['bank_account_no'],
        // 'bank_branch_code' => $row['branch_code'],
        // 'bank_micr_code' => $row['micr_no'],
        // 'bank_address_line1' => $row['bank_adddress_line_1'],
        // 'bank_address_line2' => $row['bank_adddress_line_2'],
        // 'grade' => $row['grade'],
        // 'budget_code' => $row['budget_code'],
        // 'account_code' => $row['account_code']


        if ($this->employeeType == 1) {

            return [
                'employee_id' => 'required|unique:employee_personal_details,emp_id,NULL,id,business_id,' . $this->CurrentYourBusinesss,
                'first_name' =>  ['required', 'string', 'min:4', 'max:50'],
                'last_name' => 'required|string|min:4',
                'mobile_no' => 'required|numeric|digits_between:9,10',
                'email_id' => 'required|email',
                'dob' => 'required|date_format:d-m-Y',
                'gender' => 'required|in:Male,Female,Other',
                'marital_status' => ['required', Rule::in(StaticEmployeeJoinMaritalType::pluck('marital_type')->toArray()),],
                'doj' => 'required|date_format:d-m-Y',
                'nationality' => 'required',
                'religion' =>  ['required', Rule::in(StaticEmployeeJoinReligion::pluck('religion_name')->toArray()),],
                'caste_category' =>  ['required', Rule::in(StaticEmployeeJoinCategoryCaste::pluck('caste_category')->toArray()),],
                'blood_group' =>  ['required', Rule::in(StaticEmployeeJoinBloodGroup::pluck('blood_group')->toArray()),],
                'branch' => ['required', Rule::in(BranchList::where('business_id', $this->CurrentYourBusinesss)->pluck('branch_name')->toArray()),],
                'department' => ['required', 'string', Rule::in(DepartmentList::where('b_id', $this->CurrentYourBusinesss)->pluck('depart_name')->toArray()),],
                'designation' => ['required', 'string', Rule::in(DesignationList::where('business_id', $this->CurrentYourBusinesss)->pluck('desig_name')->toArray()),],
                'employee_type' => ['required', 'string', Rule::in(StaticEmployeeJoinEmpType::pluck('emp_type')->toArray()),],
                'assign_setup' => 'required',
                'assign_attendance_method' => ['required', 'string', Rule::in(StaticAttendanceMethod::pluck('method_name')->toArray()),],
                'assign_shift_type' => ['required',  Rule::in(PolicyAttendanceShiftSetting::where('business_id', $this->CurrentYourBusinesss)->pluck('shift_type_name')->toArray()),],
                'activein_active' => ['required', 'string', Rule::in(StaticEmployeeJoinActiveType::pluck('name')->toArray()),],
                'ifsc_code' => ['required', 'string'],
                'bank_name' => ['required', 'string'],
                'branch_name' => ['required', 'string'],
                'bank_account_no' => ['required', 'string'],
                'branch_code' => ['required', 'string'],
                'micr_no' => ['required', 'string'],
                'bank_adddress_line_1' => ['required', 'string'],
                'grade' => ['required', 'string'],
                'budget_code' => ['required', 'string'],
                'account_code' => ['required', 'string'],
            ];
        }

        if ($this->employeeType == 2) {

            return [
                'employee_id' => 'required|unique:employee_personal_details,emp_id,NULL,id,business_id,' . $this->CurrentYourBusinesss,
                'first_name' =>  ['required', 'string', 'min:4', 'max:50'],
                'last_name' => 'required|string|min:4',
                'mobile_no' => 'required|numeric|digits_between:9,10',
                'email_id' => 'required|email',
                'dob' => 'required|date_format:d-m-Y',
                'gender' => 'required|in:Male,Female,Other',
                'marital_status' => ['required', Rule::in(StaticEmployeeJoinMaritalType::pluck('marital_type')->toArray()),],
                'doj' => 'required|date_format:d-m-Y',
                'nationality' => 'required',
                'religion' =>  ['required', Rule::in(StaticEmployeeJoinReligion::pluck('religion_name')->toArray()),],
                'caste_category' =>  ['required', Rule::in(StaticEmployeeJoinCategoryCaste::pluck('caste_category')->toArray()),],
                'blood_group' =>  ['required', Rule::in(StaticEmployeeJoinBloodGroup::pluck('blood_group')->toArray()),],
                'branch' => ['required', Rule::in(BranchList::where('business_id', $this->CurrentYourBusinesss)->pluck('branch_name')->toArray()),],
                'department' => ['required', 'string', Rule::in(DepartmentList::where('b_id', $this->CurrentYourBusinesss)->pluck('depart_name')->toArray()),],
                'designation' => ['required', 'string', Rule::in(DesignationList::where('business_id', $this->CurrentYourBusinesss)->pluck('desig_name')->toArray()),],
                'employee_type' => ['required', 'string', Rule::in(StaticEmployeeJoinEmpType::pluck('emp_type')->toArray()),],
                'contractual_type' => ['required', 'string', Rule::in(StaticEmployeeJoinContractualType::pluck('contractual_type')->toArray()),],
                'assign_setup' => 'required',
                'assign_attendance_method' => ['required', 'string', Rule::in(StaticAttendanceMethod::pluck('method_name')->toArray()),],
                'assign_shift_type' => ['required',  Rule::in(PolicyAttendanceShiftSetting::where('business_id', $this->CurrentYourBusinesss)->pluck('shift_type_name')->toArray()),],
                'activein_active' => ['required', 'string', Rule::in(StaticEmployeeJoinActiveType::pluck('name')->toArray()),],
                'ifsc_code' => ['required', 'string'],
                'bank_name' => ['required', 'string'],
                'branch_name' => ['required', 'string'],
                'bank_account_no' => ['required', 'string'],
                'branch_code' => ['required', 'string'],
                'micr_no' => ['required', 'string'],
                'bank_adddress_line_1' => ['required', 'string'],
                'grade' => ['required', 'string'],
                'budget_code' => ['required', 'string'],
                'account_code' => ['required', 'string'],

            ];
        }
    }

    public function customValidationMessages() //customize message
    {
        if ($this->employeeType == 1) {

            return [
                'employee_id.required' => 'Employee ID is required.',
                'employee_id.unique' => 'Employee ID must be unique in the database.',
                'first_name.required' => 'First Name is required.',
                'last_name.required' => 'Last Name is required.',
                'mobile_no.required' => 'Mobile Number is required.',
                'mobile_no.digits_between' => 'Mobile Number should be between 9 and 10 digits.',
                'email_id.required' => 'Email ID is required.',
                'dob.required' => 'Date of Birth is required.',
                'gender.required' => 'Gender is required.',
                'marital_status.required' => 'Marital Status is required.',
                'doj.required' => 'Date of Joining is required.',
                'nationality.required' => 'Nationality is required.',
                'religion.required' => 'Religion is required.',
                'caste_category.required' => 'Caste Category is required.',
                'blood_group.required' => 'Blood Group is required.',
                'branch.required' => 'Branch Name is required.',
                'department.required' => 'Department Name is required.',
                'designation.required' => 'Designation Name is required.',
                'employee_type.required' => 'EmployeeType is required.',
                'contractual_type.required' => 'Contractual Type is required.',
                'assign_setup.required' => 'Assign Setup is required.',
                'assign_attendance_method.required' => 'Assign Attendance Method is required.',
                'assign_shift_type.required' => 'Employee Shift Type is required.',
                'activein_active.required' => 'Employee Status is required.',
                'ifsc_code' => 'IFSC code is required.',
                'bank_name' => 'Bank Name is required.',
                'branch_name' => 'Branch Name is required.',
                'bank_account_no' => 'Bank Account Number is required.',
                'branch_code' => 'Branch code is required.',
                'micr_no' => 'MICR No. is required.',
                'bank_adddress_line_1' => 'Bank Address is required.',
                'grade' => 'Grade Code is required.',
                'budget_code' => 'Budget  Code is required.',
                'account_code' => 'Account Code is required.',


            ];
        }
        if ($this->employeeType == 2) {

            return [
                'employee_id.required' => 'Employee ID is required.',
                'employee_id.unique' => 'Employee ID must be unique in the database.',
                'first_name.required' => 'First Name is required.',
                'last_name.required' => 'Last Name is required.',
                'mobile_no.required' => 'Mobile Number is required.',
                'mobile_no.digits_between' => 'Mobile Number should be between 9 and 10 digits.',
                'email_id.required' => 'Email ID is required.',
                'dob.required' => 'Date of Birth is required.',
                'gender.required' => 'Gender is required.',
                'marital_status.required' => 'Marital Status is required.',
                'doj.required' => 'Date of Joining is required.',
                'nationality.required' => 'Nationality is required.',
                'religion.required' => 'Religion is required.',
                'caste_category.required' => 'Caste Category is required.',
                'blood_group.required' => 'Blood Group is required.',
                'branch.required' => 'Branch Name is required.',
                'department.required' => 'Department Name is required.',
                'designation.required' => 'Designation Name is required.',
                'employee_type.required' => 'EmployeeType is required.',
                'assign_setup.required' => 'Assign Setup is required.',
                'assign_attendance_method.required' => 'Assign Attendance Method is required.',
                'assign_shift_type.required' => 'Employee Shift Type is required.',
                'activein_active.required' => 'Employee Status is required.',
                'ifsc_code' => 'IFSC code is required.',
                'bank_name' => 'Bank Name is required.',
                'branch_name' => 'Branch Name is required.',
                'bank_account_no' => 'Bank Account Number is required.',
                'branch_code' => 'Branch code is required.',
                'micr_no' => 'MICR No. is required.',
                'bank_adddress_line_1' => 'Bank Address is required.',
                'grade' => 'Grade Code is required.',
                'budget_code' => 'Budget  Code is required.',
                'account_code' => 'Account Code is required.',


            ];
        }
    }

    public function customMessages(): array
    {
        if ($this->employeeType == 1) {

            return $this->customValidationMessages();
        }
        if ($this->employeeType == 2) {

            return $this->customValidationMessages();
        }
    }
    public function model(array $row)
    {
        // dd($row);
        if ($this->employeeType == 1) {

            $CallGetName = RulesManagement::getCheckingCountryStateCity(true, $row['country'], $row['state'], $row['city']);
            $getAllStaticDataCheckAdjust = RulesManagement::getImportAllContent($this->CurrentYourBusinesss, $row['gender'], $row['marital_status'], $row['religion'], $row['caste_category'], $row['blood_group'], $row['govt_id_type'], $row['branch'], $row['department'], $row['designation'], $row['employee_type'], $row['assign_setup'], $row['assign_attendance_method'], $row['assign_shift_type'], $row['activein_active'], $row['country'], $row['employee_id'], $row['mobile_no'], $row['email_id']);

            return new EmployeePersonalDetail([
                'emp_id' => $row['employee_id'],
                'business_id' => $this->CurrentYourBusinesss,
                'emp_name' => $row['first_name'],
                'emp_mname' => $row['middle_name'],
                'emp_lname' => $row['last_name'],
                'emp_mobile_number' => $row['mobile_no'],
                'emp_email' => $row['email_id'],
                'emp_date_of_birth' => date('Y-m-d', strtotime($row['dob'])),
                'emp_gender' => $getAllStaticDataCheckAdjust[0],
                'emp_marital_status' => $getAllStaticDataCheckAdjust[1],
                'emp_date_of_joining' => date('Y-m-d', strtotime($row['doj'])),
                'emp_nationality' => $row['nationality'],
                'emp_religion' => $getAllStaticDataCheckAdjust[2],
                'emp_category' => $getAllStaticDataCheckAdjust[3],
                'emp_blood_group' => $getAllStaticDataCheckAdjust[4],
                'emp_gov_select_id' => $getAllStaticDataCheckAdjust[5],
                'emp_gov_select_id_number' => $row['govt_id_no'],
                'branch_id' => $getAllStaticDataCheckAdjust[6],
                'department_id' => $getAllStaticDataCheckAdjust[7],
                'designation_id' => $getAllStaticDataCheckAdjust[8],
                'employee_type' => $getAllStaticDataCheckAdjust[9],
                'emp_country' => $CallGetName[0],
                'emp_state' => $CallGetName[1],
                'emp_city' => $CallGetName[2],
                'emp_address' => $row['address'],
                'emp_pin_code' => $row['pincode'],
                'master_endgame_id' => $getAllStaticDataCheckAdjust[10],
                'emp_attendance_method' => $getAllStaticDataCheckAdjust[11],
                'emp_shift_type' => $getAllStaticDataCheckAdjust[12],
                'assign_shift_type' => $getAllStaticDataCheckAdjust[13],
                'emp_reporting_manager' => $row['reporting_manager'],
                'active_emp' => $getAllStaticDataCheckAdjust[14],
                'bank_ifsc_code' => $row['ifsc_code'],
                'bank_name' => $row['bank_name'],
                'bank_branch_name' => $row['branch_name'],
                'bank_account_no' => $row['bank_account_no'],
                'bank_branch_code' => $row['branch_code'],
                'bank_micr_code' => $row['micr_no'],
                'bank_address_line1' => $row['bank_adddress_line_1'],
                'bank_address_line2' => $row['bank_adddress_line_2'],
                'grade' => $row['grade'],
                'budget_code' => $row['budget_code'],
                'account_code' => $row['account_code']
            ]);
        }
        if ($this->employeeType == 2) {
            $CallGetName = RulesManagement::getCheckingCountryStateCity(true, $row['country'], $row['state'], $row['city']);
            $getAllStaticDataCheckAdjust = RulesManagement::getImportAllContentP2($this->CurrentYourBusinesss, $row['gender'], $row['marital_status'], $row['religion'], $row['caste_category'], $row['blood_group'], $row['govt_id_type'], $row['branch'], $row['department'], $row['designation'], $row['employee_type'], $row['contractual_type'], $row['assign_setup'], $row['assign_attendance_method'], $row['assign_shift_type'], $row['activein_active'], $row['country'], $row['employee_id'], $row['mobile_no'], $row['email_id']);

            return new EmployeePersonalDetail([
                'emp_id' => $row['employee_id'],
                'business_id' => $this->CurrentYourBusinesss,
                'emp_name' => $row['first_name'],
                'emp_mname' => $row['middle_name'],
                'emp_lname' => $row['last_name'],
                'emp_mobile_number' => $row['mobile_no'],
                'emp_email' => $row['email_id'],
                'emp_date_of_birth' => date('Y-m-d', strtotime($row['dob'])),
                'emp_gender' => $getAllStaticDataCheckAdjust[0],
                'emp_marital_status' => $getAllStaticDataCheckAdjust[1],
                'emp_date_of_joining' => date('Y-m-d', strtotime($row['doj'])),
                'emp_nationality' => $row['nationality'],
                'emp_religion' => $getAllStaticDataCheckAdjust[2],
                'emp_category' => $getAllStaticDataCheckAdjust[3],
                'emp_blood_group' => $getAllStaticDataCheckAdjust[4],
                'emp_gov_select_id' => $getAllStaticDataCheckAdjust[5],
                'emp_gov_select_id_number' => $row['govt_id_no'],
                'branch_id' => $getAllStaticDataCheckAdjust[6],
                'department_id' => $getAllStaticDataCheckAdjust[7],
                'designation_id' => $getAllStaticDataCheckAdjust[8],
                'employee_type' => $getAllStaticDataCheckAdjust[9],
                'employee_contractual_type' => $getAllStaticDataCheckAdjust[10],
                'emp_country' => $CallGetName[0],
                'emp_state' => $CallGetName[1],
                'emp_city' => $CallGetName[2],
                'emp_address' => $row['address'],
                'emp_pin_code' => $row['pincode'],
                'master_endgame_id' => $getAllStaticDataCheckAdjust[11],
                'emp_attendance_method' => $getAllStaticDataCheckAdjust[12],
                'emp_shift_type' => $getAllStaticDataCheckAdjust[13],
                'assign_shift_type' => $getAllStaticDataCheckAdjust[14],
                'emp_reporting_manager' => $row['reporting_manager'],
                'active_emp' => $getAllStaticDataCheckAdjust[15],
                'bank_ifsc_code' => $row['ifsc_code'],
                'bank_name' => $row['bank_name'],
                'bank_branch_name' => $row['branch_name'],
                'bank_account_no' => $row['bank_account_no'],
                'bank_branch_code' => $row['branch_code'],
                'bank_micr_code' => $row['micr_no'],
                'bank_address_line1' => $row['bank_adddress_line_1'],
                'bank_address_line2' => $row['bank_adddress_line_2'],
                'grade' => $row['grade'],
                'budget_code' => $row['budget_code'],
                'account_code' => $row['account_code']

            ]);
        }
    }



    // public function collection(Collection $rows)
    // {

    //     if ($this->employeeType == 1) {



    //         // $expectedHeaders = [
    //         //     'Employee ID',
    //         //     'First Name',
    //         //     'Middle name',
    //         //     'Last name',
    //         //     'Mobile No.',
    //         //     'Email ID',
    //         //     'DOB',
    //         //     'Gender',
    //         //     'Marital Status',
    //         //     'DOJ',
    //         //     'Nationality',
    //         //     'Religion',
    //         //     'Caste Category',
    //         //     'Blood Group',
    //         //     'Govt ID Type',
    //         //     'Govt ID No.',
    //         //     'Branch',
    //         //     'Department',
    //         //     'Designation',
    //         //     'Employee Type',
    //         //     'Country',
    //         //     'State',
    //         //     'City',
    //         //     'Address',
    //         //     'Pincode',
    //         //     'Assign Setup',
    //         //     'Assign Attendance Method',
    //         //     'Assign Shift Type',
    //         //     'Reporting Manager',
    //         //     'Active/In-Active'
    //         // ];
    //         // $fileHeaders = $rows->first()->toArray(); // Get the headers from the file and convert to array

    //         // // Check if any expected headers are missing
    //         // $missingHeaders = array_diff($expectedHeaders, $fileHeaders);

    //         // if (!empty($missingHeaders)) {
    //         //     // Handle missing headers
    //         //     // Log an error, throw an exception, or handle it based on your application flow
    //         //     $errorMessage = 'Missing headers: ' . implode(', ', $missingHeaders);
    //         //     // Example: Log the error and return
    //         //     // Log::error($errorMessage);
    //         //     Alert::info('', $errorMessage);
    //         //     return back();
    //         // }
    //         // $validator = Validator::make($rows->toArray(), [
    //         //     '*.0' => 'required',
    //         // ])->validate();
    //         // $validator = Validator::make($rows->first()->toArray(), [
    //         //     'Employee ID' => 'required',
    //         //     // 'emp_name' => 'required',
    //         //     // 'emp_lname' => 'required',
    //         //     // 'emp_mobile_number' => 'required',
    //         //     // 'emp_email' => 'required',
    //         //     // 'Gender' => 'required',
    //         //     // 'emp_date_of_joining' => 'required',
    //         //     // 'emp_category' => 'required',
    //         //     // 'emp_gov_select_id' => 'required',
    //         //     // 'emp_gov_select_id_number' => 'required',
    //         //     // 'branch_id' => 'required',
    //         //     // 'department_id' => 'required',
    //         //     // 'designation_id' => 'required',
    //         //     // 'employee_type' => 'required',
    //         //     // 'master_endgame_id' => 'required',
    //         //     // 'emp_attendance_method' => 'required',
    //         //     // 'emp_shift_type' => 'required',
    //         //     // 'emp_reporting_manager' => 'required',
    //         //     // 'active_emp' => 'required'
    //         // ]);

    //         // if ($validator->fails()) {
    //         //     // dd($validator);
    //         //     $errors = $validator->errors(); // Retrieve specific error messages if needed

    //         //     Alert::error('', 'Validation Failed! Please Check Your Data.')->autoclose(5000);
    //         //     return back();
    //         // }
    //         //  else {
    //         //     dd("D");
    //         // }

    //         $dataToSave = [];


    //         $dataToSave = $rows->splice(1); // Exclude the first row (headers)


    //         $employees = $dataToSave->map(function ($row) {
    //             // 'india' ,'Chhattisgarh','Raipur return if ID then True otherwise false only return Nameget
    //             $CallGetName = RulesManagement::getCheckingCountryStateCity(true, $row[20], $row[21], $row[22]);
    //             $getAllStaticDataCheckAdjust = RulesManagement::getImportAllContent($this->CurrentYourBusinesss, $row[7], $row[8], $row[11], $row[12], $row[13], $row[14], $row[16], $row[17], $row[18], $row[19], $row[26], $row[27], $row[29], $row[25]); //  StaticEmployeeJoinGenderType::where('gender_type', $row[7])->select('id')->first();

    //             $genderType = $getAllStaticDataCheckAdjust[0]; //RulesManagement::getImportAllContent($row[7], $row[8]); //  StaticEmployeeJoinGenderType::where('gender_type', $row[7])->select('id')->first();
    //             $maritalType = $getAllStaticDataCheckAdjust[1]; // StaticEmployeeJoinMaritalType::where('marital_type', $row[8])->select('id')->first();
    //             $religionType = $getAllStaticDataCheckAdjust[2]; //StaticEmployeeJoinReligion::where('religion_name', $row[11])->select('id')->first();
    //             $castCategoryType = $getAllStaticDataCheckAdjust[3]; ////StaticEmployeeJoinCategoryCaste::where('caste_category', $row[12])->select('id')->first();
    //             $bloodGroupType = $getAllStaticDataCheckAdjust[4]; // StaticEmployeeJoinBloodGroup::where('blood_group', $row[13])->select('id')->first();
    //             $govtDocType = $getAllStaticDataCheckAdjust[5]; // StaticEmployeeJoinGovtDocType::where('govt_type', $row[14])->select('id')->first();
    //             $branchFind = $getAllStaticDataCheckAdjust[6]; // BranchList::where('business_id', $this->CurrentYourBusinesss)->where('branch_name', $row[16])->select('branch_id')->first();
    //             $departmentFind = $getAllStaticDataCheckAdjust[7]; // DepartmentList::where('b_id', $this->CurrentYourBusinesss)->where('depart_name', $row[17])->select('depart_id')->first();
    //             $designationFind = $getAllStaticDataCheckAdjust[8]; //DesignationList::where('business_id', $this->CurrentYourBusinesss)->where('desig_name', $row[18])->select('desig_id')->first();
    //             $employeeType = $getAllStaticDataCheckAdjust[9]; // StaticEmployeeJoinEmpType::where('emp_type', $row[19])->select('type_id')->first();
    //             $attendanceMethod = $getAllStaticDataCheckAdjust[10]; //StaticAttendanceMethod::where('method_name', $row[26])->select('id')->select('id')->first();
    //             $policyShiftType = $getAllStaticDataCheckAdjust[11]; // PolicyAttendanceShiftSetting::where('business_id', $this->CurrentYourBusinesss)->where('shift_type_name', $row[27])->select('id')->first();
    //             $activeEmployee = $getAllStaticDataCheckAdjust[12]; // StaticEmployeeJoinActiveType::where('name', $row[29])->select('id')->first();
    //             $masterPolicyEndGameType = $getAllStaticDataCheckAdjust[13]; // PolicyMasterEndgameMethod::where('business_id', $this->CurrentYourBusinesss)->where('method_name', $row[25])->select('id')->first();

    //             $employeeCollectData = [
    //                 'emp_id' => $row[0],
    //                 'business_id' => $this->CurrentYourBusinesss,
    //                 'emp_name' => $row[1],
    //                 'emp_mname' => ($row[2] != null) ? $row[2] : '',
    //                 'emp_lname' => ($row[3] != null) ? $row[3] : '',
    //                 'emp_mobile_number' => ($row[4] != null) ? $row[4] : '',
    //                 'emp_email' => ($row[5] != null) ? $row[5] : '',
    //                 'emp_date_of_birth' => ($row[6] != null) ? date('Y-m-d', strtotime($row[6])) : '',
    //                 'emp_gender' => $genderType,
    //                 'emp_marital_status' => $maritalType,
    //                 'emp_date_of_joining' => ($row[9] != null) ? date('Y-m-d', strtotime($row[9])) : '',
    //                 'emp_nationality' => ($row[10] != null) ? $row[10] : '',
    //                 'emp_religion' => $religionType,
    //                 'emp_category' => $castCategoryType, //($row[12] != null && $castCategoryType != null) ? $castCategoryType->id : '',
    //                 'emp_blood_group' => $bloodGroupType, //($row[13] != null && $bloodGloopType != null) ? $bloodGloopType->id : '',
    //                 'emp_gov_select_id' => $govtDocType,  //($row[14] != null && $govtDocType != null) ? $govtDocType->id : '',
    //                 'emp_gov_select_id_number' => ($row[15] != null) ? $row[15] : '',
    //                 'branch_id' => $branchFind, // ($row[16] != null && $branchFind != null) ? $branchFind->branch_id : '',
    //                 'department_id' => $departmentFind, //($row[17] != null && $departmentFind != null) ? $departmentFind->depart_id : '',
    //                 'designation_id' => $designationFind, //($row[18] != null && $designationFind != null) ? $designationFind->desig_id : '',
    //                 'employee_type' => $employeeType, // ($row[19] != null && $employeeType != null) ? $employeeType->type_id : '',
    //                 'emp_country' => $CallGetName[0],
    //                 'emp_state' => $CallGetName[1],
    //                 'emp_city' => $CallGetName[2],
    //                 'emp_pin_code' => ($row[23] != null) ? $row[23] : '',
    //                 'emp_address' => ($row[24] != null) ? $row[24] : '',
    //                 'master_endgame_id' => $masterPolicyEndGameType,  // ($row[25] != null && $masterPolicyEndGameType != null) ? $masterPolicyEndGameType->id : '',
    //                 'emp_attendance_method' => $attendanceMethod, //($row[26] != null && $attendanceMethod != null) ? $attendanceMethod->id : '',
    //                 'emp_shift_type' => $policyShiftType, //($row[27] != null && $policyShiftType != null) ? $policyShiftType->id : '',
    //                 'emp_reporting_manager' => ($row[28] != null) ? $row[28] : '',
    //                 'active_emp' => $activeEmployee //($row[29] != null && $activeEmployee != null) ? $activeEmployee->id : ''
    //             ];
    //             return $employeeCollectData;
    //         })->toArray();

    //         $existingEmpIds = EmployeePersonalDetail::where('business_id', $this->CurrentYourBusinesss)
    //             ->whereIn('emp_id', array_column($employees, 'emp_id'))
    //             ->pluck('emp_id')
    //             ->toArray();
    //         if ($existingEmpIds) {
    //             Alert::warning('', 'Already Data has been Imported !');
    //         }

    //         $nonExistingEmployees = array_filter($employees, function ($employee) use ($existingEmpIds) {
    //             return !in_array($employee['emp_id'], $existingEmpIds);
    //         });

    //         foreach ($nonExistingEmployees as $employee) {
    //             // Check if the emp_id already exists
    //             $existingEmployee = EmployeePersonalDetail::where('emp_id', $employee['emp_id'])
    //                 ->where('business_id', $this->CurrentYourBusinesss)
    //                 ->first();

    //             if ($existingEmployee) {
    //                 // If the employee exists, update the details
    //                 // $existingEmployee->update($employee);
    //                 Alert::warning('', 'Already Data has been Imported !');
    //             } else {
    //                 // If the employee doesn't exist, create a new entry
    //                 // $saveData[] = $employee;
    //                 // dd($employee);
    //                 $done = EmployeePersonalDetail::where('business_id', $this->CurrentYourBusinesss)
    //                     ->insert($employee);
    //                 if ($done) {
    //                     Alert::success('', 'Employee Data has been Imported Successfully')->autoclose(3000);
    //                 } else {
    //                     Alert::info('', 'Employee Data has been Not Imported !');
    //                 }
    //             }
    //         }
    //     }
    //     if ($this->employeeType == 2) {
    //         $expectedHeaders = [
    //             'Employee ID',
    //             'First Name',
    //             'Middle name',
    //             'Last name',
    //             'Mobile No.',
    //             'Email ID',
    //             'DOB',
    //             'Gender',
    //             'Marital Status',
    //             'DOJ',
    //             'Nationality',
    //             'Religion',
    //             'Caste Category',
    //             'Blood Group',
    //             'Govt ID Type',
    //             'Govt ID No.',
    //             'Branch',
    //             'Department',
    //             'Designation',
    //             'Employee Type',
    //             'Contractual Type',
    //             'Country',
    //             'State',
    //             'City',
    //             'Address',
    //             'Pincode',
    //             'Assign Setup',
    //             'Assign Attendance Method',
    //             'Assign Shift Type',
    //             'Reporting Manager',
    //             'Active/In-Active'
    //         ];
    //         $fileHeaders = $rows->first()->toArray(); // Get the headers from the file and convert to array

    //         // Check if any expected headers are missing
    //         $missingHeaders = array_diff($expectedHeaders, $fileHeaders);

    //         if (!empty($missingHeaders)) {
    //             // Handle missing headers
    //             // Log an error, throw an exception, or handle it based on your application flow
    //             $errorMessage = 'Missing headers: ' . implode(', ', $missingHeaders);
    //             // Example: Log the error and return
    //             // Log::error($errorMessage);
    //             Alert::info('', $errorMessage);
    //             return back();
    //         }
    //         $dataToSave = [];


    //         $dataToSave = $rows->splice(1); // Exclude the first row (headers)


    //         $employees = $dataToSave->map(function ($row) {
    //             // dd($row);
    //             // 'india' ,'Chhattisgarh','Raipur return if ID then True otherwise false only return Nameget
    //             $CallGetName = RulesManagement::getCheckingCountryStateCity(true, $row[21], $row[22], $row[23]);
    //             $getAllStaticDataCheckAdjust = RulesManagement::getImportAllContent2($this->CurrentYourBusinesss, $row[7], $row[8], $row[11], $row[12], $row[13], $row[14], $row[16], $row[17], $row[18], $row[19], $row[20], $row[26], $row[27], $row[29], $row[25]); //  StaticEmployeeJoinGenderType::where('gender_type', $row[7])->select('id')->first();

    //             $genderType = $getAllStaticDataCheckAdjust[0]; //RulesManagement::getImportAllContent($row[7], $row[8]); //  StaticEmployeeJoinGenderType::where('gender_type', $row[7])->select('id')->first();
    //             $maritalType = $getAllStaticDataCheckAdjust[1]; // StaticEmployeeJoinMaritalType::where('marital_type', $row[8])->select('id')->first();
    //             $religionType = $getAllStaticDataCheckAdjust[2]; //StaticEmployeeJoinReligion::where('religion_name', $row[11])->select('id')->first();
    //             $castCategoryType = $getAllStaticDataCheckAdjust[3]; ////StaticEmployeeJoinCategoryCaste::where('caste_category', $row[12])->select('id')->first();
    //             $bloodGroupType = $getAllStaticDataCheckAdjust[4]; // StaticEmployeeJoinBloodGroup::where('blood_group', $row[13])->select('id')->first();
    //             $govtDocType = $getAllStaticDataCheckAdjust[5]; // StaticEmployeeJoinGovtDocType::where('govt_type', $row[14])->select('id')->first();
    //             $branchFind = $getAllStaticDataCheckAdjust[6]; // BranchList::where('business_id', $this->CurrentYourBusinesss)->where('branch_name', $row[16])->select('branch_id')->first();
    //             $departmentFind = $getAllStaticDataCheckAdjust[7]; // DepartmentList::where('b_id', $this->CurrentYourBusinesss)->where('depart_name', $row[17])->select('depart_id')->first();
    //             $designationFind = $getAllStaticDataCheckAdjust[8]; //DesignationList::where('business_id', $this->CurrentYourBusinesss)->where('desig_name', $row[18])->select('desig_id')->first();
    //             $employeeType = $getAllStaticDataCheckAdjust[9]; // StaticEmployeeJoinEmpType::where('emp_type', $row[19])->select('type_id')->first();
    //             $attendanceMethod = $getAllStaticDataCheckAdjust[10]; //StaticAttendanceMethod::where('method_name', $row[26])->select('id')->select('id')->first();
    //             $policyShiftType = $getAllStaticDataCheckAdjust[11]; // PolicyAttendanceShiftSetting::where('business_id', $this->CurrentYourBusinesss)->where('shift_type_name', $row[27])->select('id')->first();
    //             $activeEmployee = $getAllStaticDataCheckAdjust[12]; // StaticEmployeeJoinActiveType::where('name', $row[29])->select('id')->first();
    //             $masterPolicyEndGameType = $getAllStaticDataCheckAdjust[13]; // PolicyMasterEndgameMethod::where('business_id', $this->CurrentYourBusinesss)->where('method_name', $row[25])->select('id')->first();
    //             $contractualType = $getAllStaticDataCheckAdjust[14];
    //             $employeeCollectData = [
    //                 'emp_id' => $row[0],
    //                 'business_id' => $this->CurrentYourBusinesss,
    //                 'emp_name' => $row[1],
    //                 'emp_mname' => ($row[2] != null) ? $row[2] : '',
    //                 'emp_lname' => ($row[3] != null) ? $row[3] : '',
    //                 'emp_mobile_number' => ($row[4] != null) ? $row[4] : '',
    //                 'emp_email' => ($row[5] != null) ? $row[5] : '',
    //                 'emp_date_of_birth' => ($row[6] != null) ? date('Y-m-d', strtotime($row[6])) : '',
    //                 'emp_gender' => $genderType,
    //                 'emp_marital_status' => $maritalType,
    //                 'emp_date_of_joining' => ($row[9] != null) ? date('Y-m-d', strtotime($row[9])) : '',
    //                 'emp_nationality' => ($row[10] != null) ? $row[10] : '',
    //                 'emp_religion' => $religionType,
    //                 'emp_category' => $castCategoryType, //($row[12] != null && $castCategoryType != null) ? $castCategoryType->id : '',
    //                 'emp_blood_group' => $bloodGroupType, //($row[13] != null && $bloodGloopType != null) ? $bloodGloopType->id : '',
    //                 'emp_gov_select_id' => $govtDocType,  //($row[14] != null && $govtDocType != null) ? $govtDocType->id : '',
    //                 'emp_gov_select_id_number' => ($row[15] != null) ? $row[15] : '',
    //                 'branch_id' => $branchFind, // ($row[16] != null && $branchFind != null) ? $branchFind->branch_id : '',
    //                 'department_id' => $departmentFind, //($row[17] != null && $departmentFind != null) ? $departmentFind->depart_id : '',
    //                 'designation_id' => $designationFind, //($row[18] != null && $designationFind != null) ? $designationFind->desig_id : '',
    //                 'employee_type' => $employeeType,
    //                 'employee_contractual_type' => $contractualType, // ($row[19] != null && $employeeType != null) ? $employeeType->type_id : '',
    //                 'emp_country' => $CallGetName[0],
    //                 'emp_state' => $CallGetName[1],
    //                 'emp_city' => $CallGetName[2],
    //                 'emp_pin_code' => ($row[24] != null) ? $row[24] : '',
    //                 'emp_address' => ($row[25] != null) ? $row[25] : '',
    //                 'master_endgame_id' => $masterPolicyEndGameType,  // ($row[25] != null && $masterPolicyEndGameType != null) ? $masterPolicyEndGameType->id : '',
    //                 'emp_attendance_method' => $attendanceMethod, //($row[26] != null && $attendanceMethod != null) ? $attendanceMethod->id : '',
    //                 'emp_shift_type' => $policyShiftType, //($row[27] != null && $policyShiftType != null) ? $policyShiftType->id : '',
    //                 'emp_reporting_manager' => ($row[28] != null) ? $row[28] : '',
    //                 'active_emp' => $activeEmployee //($row[29] != null && $activeEmployee != null) ? $activeEmployee->id : ''
    //             ];
    //             return $employeeCollectData;
    //         })->toArray();

    //         $existingEmpIds = EmployeePersonalDetail::where('business_id', $this->CurrentYourBusinesss)
    //             ->whereIn('emp_id', array_column($employees, 'emp_id'))
    //             ->pluck('emp_id')
    //             ->toArray();
    //         if ($existingEmpIds) {
    //             Alert::warning('', 'Already Data has been Imported !');
    //         }

    //         $nonExistingEmployees = array_filter($employees, function ($employee) use ($existingEmpIds) {
    //             return !in_array($employee['emp_id'], $existingEmpIds);
    //         });

    //         foreach ($nonExistingEmployees as $employee) {
    //             // Check if the emp_id already exists
    //             $existingEmployee = EmployeePersonalDetail::where('emp_id', $employee['emp_id'])
    //                 ->where('business_id', $this->CurrentYourBusinesss)
    //                 ->first();

    //             if ($existingEmployee) {
    //                 // If the employee exists, update the details
    //                 // $existingEmployee->update($employee);
    //                 Alert::warning('', 'Already Data has been Imported !');
    //             } else {
    //                 // If the employee doesn't exist, create a new entry
    //                 // $saveData[] = $employee;
    //                 // dd($employee);
    //                 $done = EmployeePersonalDetail::where('business_id', $this->CurrentYourBusinesss)
    //                     ->insert($employee);
    //                 if ($done) {
    //                     Alert::success('', 'Employee Data has been Imported Successfully')->autoclose(3000);
    //                 } else {
    //                     Alert::info('', 'Employee Data has been Not Imported !');
    //                 }
    //             }
    //         }
    //     }
    // }

    public function headings(): array
    {

        if ($this->employeeType == 1) {


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
        if ($this->employeeType == 2) {
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
            ];
        }
    }
    public function registerEvents(): array
    {
        if ($this->employeeType == 1) {

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
                    $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD'];
                    $event->sheet->getDelegate()->setAutoFilter('A1:AD1');
                    foreach ($columns as $column) {
                        $event->sheet->getColumnDimension($column)->setAutoSize(false);
                        $event->sheet->getColumnDimension($column)->setWidth(25);
                    }
                },
            ];
        }
        if ($this->employeeType == 2) {
            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $event->sheet->getDelegate()->getStyle('A1:AE1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('FF1877F2');


                    $event->sheet->getDelegate()->getStyle('A1:AE1')
                        ->getFont()
                        ->getColor()
                        ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                    $event->sheet->getDelegate()->getStyle('A:AE')
                        ->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    // Set width for columns
                    $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE'];
                    $event->sheet->getDelegate()->setAutoFilter('A1:AE1');
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
