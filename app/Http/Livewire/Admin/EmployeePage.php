<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\AttendanceList;
use App\Models\EmployeePersonalDetail;
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
use App\Helpers\Central_unit;
use App\Exports\AddEmployeeDetails;
use App\Exports\ExportEmployeeDetails;
use App\Http\Livewire\EmployeeJoiningForm;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;
use App\Models\Student;
use App\Services\BannerService;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use App\Models\StaticCountryModel;
use App\Models\StaticStatesModel;
use App\Models\StaticCityModel;
use App\Models\PolicyAttendanceMode;
use App\Models\StaticAttendanceMode;
use App\Models\Image;
use App\Livewire\UploadPhoto;
use File;
// use Alert;
use Illuminate\Http\UploadedFile;
use Validator;
use Illuminate\Validation\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGrid;

class EmployeePage extends Component
{
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $currentPage = 1; 
    // employee_type
    public $employee_type;
    public $employee_contractual_type;

    // Start Edit Section 
    public $count_value, $emp_id, $business_id, $assign_shift_type, $first_name, $middle_name, $last_name, $phone_no, $email, $dob, $gender, $marital_status, $caste_category, $blood_group, $select_govt_type, $select_govt_id_no, $nationality, $country, $state, $city, $pin_code, $address, $doj, $emp_shift_type, $select_rotation_type, $branch, $department, $designation, $religion, $attendance_method, $report_manager, $master_endgame_id, $branch_id, $profile_image, $empID;
    // public $assign_shift_type_runtime;
    public $rotational_shift_active = 0;
    public $currentStep = 1;
    public $totalSteps = 2;
    // upload new edit images
    public $image;
    public $isEnabled = true; // active user checking 
    // End Section



    public function mount()
    {
        $this->currentStep = 1;
        $this->newCurrentStep = 1;
        $this->getAssignShiftType();
        // $this->validateData();
    }
    public function increaseStep()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if ($this->currentStep > $this->totalSteps) {
            $this->currentStep = $this->totalSteps;
        }
    }

    public function decreaseStep()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep--;
        if ($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }


    // new
    protected function removeError($field, $rule)
    {
        if ($this->getErrorBag()->has($field)) {
            $errors = $this->getErrorBag()->get($field);
            foreach ($errors as $key => $error) {
                if ($error === $rule) {
                    $this->resetError($field, $key);
                }
            }
        }
    }


    #[EndGameSetup()]
    public function getAssignSetup()
    {

        $loaded = PolicyMasterEndgameMethod::where('business_id', $this->business_id)
            ->where('method_switch', 1)
            ->get();
        //checking method loaded on process 
        // ->where('id', $this->master_endgame_id)
        return $loaded;
    }

    #[AssignShiftType()]
    public function getAssignShiftType()
    {
        $loaded = PolicyMasterEndgameMethod::where('id', $this->master_endgame_id)
            ->where('business_id', $this->business_id)
            ->where('method_switch', 1)
            ->select('shift_settings_ids_list')
            ->first();

        if ($loaded !== null) {
            $shiftSettingsIds = json_decode($loaded->shift_settings_ids_list);

            if ($shiftSettingsIds !== null) {
                $modes = PolicyAttendanceShiftSetting::where('business_id', $this->business_id)
                    ->whereIn('id', $shiftSettingsIds)
                    ->get();
                // // Assuming shift_type is a property of PolicyAttendanceShiftSetting
                // $shiftTypes = $modes->pluck('shift_type')->unique()->toArray();

                // // If you want to set a single shift type (assuming only one type is present in $modes)
                // $this->assign_shift_type_runtime = $shiftTypes ?? 0;

                if ($modes->isNotEmpty()) {

                    // dd($shiftTypes);
                    return $modes->isNotEmpty() ? $modes : [];
                }
            }
        }

        return [];
    }

    #[AssignRotationalShift()]
    public function getAssignRotationalShift()
    {
        return PolicyAttendanceShiftTypeItem::where('business_id', $this->business_id)->where('attendance_shift_id', $this->emp_shift_type)->get();
    }
    #[selectRotationalCheck()] //using only show rotational case and set on update value also
    public function selectRotationalCheck()
    {
        $this->validateData();
        if ($this->emp_shift_type != null) {
            $load = PolicyAttendanceShiftSetting::where('business_id', $this->business_id)->where('id', $this->emp_shift_type)->first();
            if ($load != null) {
                if ($load->shift_type !== '2') {
                    $this->select_rotation_type = 0; //default rotational type
                    $this->rotational_shift_active = 0;
                } else {

                    $this->rotational_shift_active = 1;
                }
            } else {
                return [];
            }
        }
    }
    #[AssignAttendanceMethod()] //globel destrib.
    public function getAssignAttendanceMethod()
    {

        $load = PolicyAttendanceMode::where('business_id', Session::get('business_id'))
            ->select('attendance_active_methods')
            ->first();

        if ($load) {
            $selectedIDs = json_decode($load->attendance_active_methods);
            $matchingModes = StaticAttendanceMethod::whereIn('id', $selectedIDs)->get();

            return $matchingModes;
        } else {
            return [];
        }

        return [];
    }


    protected $messages = [
        'email.required' => 'The Email Address cannot be empty.',
        'email.email' => 'The Email Address format is not valid.',
    ];
    public function validateData()
    {
        // 'profile_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        if ($this->currentStep == 1) {
            $this->validate([
                'first_name' => 'required|string|min:4|max:50',
                'last_name' => 'required|string|min:4',
                'phone_no' => 'required|min:11|numeric',
                'email' => 'required|email',
                'dob' => 'required',
                'gender' => 'required|in:1,2,3',
                'doj' => 'required',
                'marital_status' => 'required|in:1,2,3,4',
                'nationality' => 'required',
                'religion' => 'required|in:1,2,3,4,5',
                'caste_category' => 'required|numeric',
                'blood_group' => 'required|numeric',
                'select_govt_type' => 'required|in:1,2,3,4,5,6',
                'select_govt_id_no' => 'required'

            ]);
            $this->validateOnly('select_govt_id_no', [
                'select_govt_id_no' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $govtType = $this->select_govt_type;


                        if ($this->select_govt_id_no == 1 && empty($value)) {
                            $fail('The ' . $attribute . ' field is required');
                        }

                        if ($govtType == 1 && empty($value)) {
                            $fail('The ' . $attribute . ' field is required');
                        }
                        if ($this->select_govt_type == 1 && strlen($value) < 12) {
                            $fail('The govt id no must be at least 12 characters');
                        }
                        if ($this->select_govt_type == 2 && strlen($value) < 10) {
                            $fail('The govt id no must be at least 10 characters');
                        }
                        if ($this->select_govt_type == 3 && strlen($value) < 16) {
                            $fail('The govt id no must be  at least 16 characters');
                        }
                        if ($this->select_govt_type == 4 && strlen($value) <= 8) {
                            $fail('The govt id no must be  at least 8-9 characters');
                        }
                        if ($this->select_govt_type == 5 && strlen($value) <= 10) {
                            $fail('The govt id no must be  at least  10 characters');
                        }
                        // Add any other conditions for different govtType values here if needed
                    },
                ],
            ]);
        } elseif ($this->currentStep == 2) {

            $this->validate([
                'emp_id' => 'required',
                'branch' => 'required|nullable',
                'department' => 'required|nullable',
                'designation' => 'required|nullable',
                'attendance_method' => 'required|nullable|in:1,2,3',
                'master_endgame_id' => 'required|nullable',
                'report_manager' => 'required|nullable|string',
                'emp_shift_type' => 'required|nullable',
                'country' => 'required|nullable',
                'state' => 'required|nullable',
                'city' => 'required|nullable',
                'pin_code' => 'required|numeric',
                'address' => 'required|string'
            ]);
        }
    }
    public function change()
    {
        $this->emit('validateData');
    }

    // Edit Model Set all type of values
    public function editStudent($data)
    {
        $decodedData = json_decode($data);

        $studentId = $decodedData[0];
        $empId = $decodedData[1];
        $businessID = $decodedData[2];
        $student = EmployeePersonalDetail::where('id', $studentId)
            ->where('emp_id', $empId)
            ->where('business_id', $businessID)
            ->first();
        if ($student) {
            $this->emp_id = $student->emp_id;
            $this->isEnabled = ($student->active_emp != 0) ? true : false; //marked not present
            $this->business_id = $student->business_id;
            $this->profile_image = $student->profile_photo;
            $this->first_name = $student->emp_name;
            $this->middle_name = $student->emp_mname;
            $this->last_name = $student->emp_lname;
            $this->phone_no = $student->emp_mobile_number;
            $this->email = $student->emp_email;
            $this->dob = $student->emp_date_of_birth;
            $this->gender = $student->emp_gender;
            $this->marital_status = $student->emp_marital_status;
            $this->caste_category = $student->emp_category;
            $this->blood_group = $student->emp_blood_group;
            $this->select_govt_type = $student->emp_gov_select_id;
            $this->select_govt_id_no = $student->emp_gov_select_id_number;
            $this->nationality = $student->emp_nationality;
            $this->religion = $student->emp_religion;
            $this->country = $student->emp_country;
            $this->state = $student->emp_state;
            $this->city = $student->emp_city;
            $this->pin_code = $student->emp_pin_code;
            $this->address = $student->emp_address;
            $this->doj = $student->emp_date_of_joining;
            $this->emp_id = $student->emp_id;
            $this->emp_shift_type = $student->emp_shift_type;
            $this->select_rotation_type = $student->emp_rotational_shift_type_item;
            $this->branch = $student->branch_id;
            $this->department = $student->department_id;
            $this->designation = $student->designation_id;
            $this->attendance_method = $student->emp_attendance_method;
            $this->report_manager = $student->emp_reporting_manager;
            $this->master_endgame_id = $student->master_endgame_id;
            $this->selectRotationalCheck();
        } else {
            return redirect()->to('/admin/employee');
        }
    }

    public function updateSubmit()
    {
        //  dd($this->getAssignAttendanceMethod());



        $this->resetErrorBag();
        $initalLevel = '';
        $student = EmployeePersonalDetail::where('emp_id', $this->emp_id)
            ->where('business_id', $this->business_id)
            ->first();
        if ($student) {

            if ($this->image != null) {
                // temprary image upload in loaded
                $initalLevel = date('d-m-Y') . '_' . md5(time()) . '.' . $this->image->getClientOriginalExtension();
                $currentImage = $this->profile_image; //->image;
                // $load = EmployeePersonalDetail::where('emp_id', $this->emp_id)->where('business_id', $this->business_id)->where('profile_photo', $currentImage)->first();
                // if ($load != null) {
                //     // $filePath = $this->image->storeAs('livewire_employee_profile', $initalLevel);
                //     unlink(public_path('storage/livewire_employee_profile/') . $currentImage);
                // }
                $filePath = $this->image->storeAs('livewire_employee_profile', $initalLevel);
                $publicUrl = Storage::url($filePath);
            }

            $CheckingShiftType = PolicyAttendanceShiftSetting::where('business_id', $this->business_id)->where('id', $this->emp_shift_type)->first();
            $student->profile_photo = ($initalLevel != '' && $initalLevel != null) ? $initalLevel : $this->profile_image;
            $student->business_id = $this->business_id;
            $student->branch_id = $this->branch_id;
            $student->emp_name = $this->first_name;
            $student->emp_mname = $this->middle_name;
            $student->emp_lname = $this->last_name;
            $student->emp_mobile_number = $this->phone_no;
            $student->emp_religion = $this->religion;
            $student->emp_email = $this->email;
            $student->emp_date_of_birth = $this->dob;
            $student->emp_gender = $this->gender;
            $student->emp_marital_status = $this->marital_status;
            $student->emp_category = $this->caste_category;
            $student->emp_blood_group = $this->blood_group;
            $student->emp_gov_select_id = $this->select_govt_type;
            $student->emp_gov_select_id_number = $this->select_govt_id_no;
            $student->emp_nationality = $this->nationality;
            $student->emp_country = $this->country;
            $student->emp_state = $this->state;
            $student->emp_city = $this->city;
            $student->emp_pin_code = $this->pin_code;
            $student->emp_address = $this->address;
            $student->emp_date_of_joining = $this->doj;
            $student->emp_id = $this->emp_id;
            $student->emp_shift_type = $this->emp_shift_type;
            $student->assign_shift_type = $CheckingShiftType->shift_type;
            $student->emp_rotational_shift_type_item = $this->select_rotation_type;
            $student->branch_id = $this->branch;
            $student->department_id = $this->department;
            $student->designation_id = $this->designation;
            $student->emp_attendance_method = $this->attendance_method;
            $student->emp_reporting_manager = $this->report_manager;
            $student->master_endgame_id = $this->master_endgame_id;
            // $student->employee_type = $this->employee_type;
            // $student->employee_contractual_type = ($this->employee_contractual_type != null) ? $this->employee_contractual_type : 0;
            // Perform actions when isEnabled property is updated
            // For example, perform actions when enabled or disabled
            if ($this->isEnabled != false) {
                $student->active_emp = 1;
                // Handle enabled state
            } else {
                $student->active_emp = 0;
                // Handle disabled state
            }
            $student->update();


            // echo "file : Yes";
            Alert::success('', 'Success Updated');
        } else {
            Alert::warning('', 'Not Updated');
        }

        return redirect()->to('/admin/employee');
        // return  redirect()->back();

        // dd($this->all());

        //   return redirect()->route('registration.success', $data);
    }

    //previews photo delete
    protected function deletePreviousFile()
    {
        $previousFilePath = 'livewire_employee_profile';
        if ($previousFilePath && Storage::exists($previousFilePath)) {
            Storage::delete($previousFilePath);
        }
    }

    // Create Joining From uses
    public $new_first_name, $new_last_name, $new_middle_name, $new_phone, $new_email, $new_dob, $new_gender, $new_martial_status, $new_doj, $new_nationality, $new_religion, $new_category, $new_blood_group, $new_govt_id, $new_govt_id_no;

    public $new_branch, $new_department, $new_designation, $new_attendance_method, $new_master_endgame_id, $new_report_manager, $new_emp_shift_type, $new_select_rotation_type, $new_country, $new_state, $new_city, $new_pin_code, $new_address, $new_isEnabled = true;

    public $new_rotational_shift_active = 0;
    // created method requried
    public $generate_emp_id;
    public $newCurrentStep = 1;
    public $newTotalSteps = 2;

    public function newIncreaseStep()
    {
        $this->resetErrorBag();
        $this->newEmployeeJoiningValidation();
        $this->newCurrentStep++;
        if ($this->newCurrentStep > $this->newTotalSteps) {
            $this->newCurrentStep = $this->newTotalSteps;
        }
    }

    public function newDecreaseStep()
    {
        $this->resetErrorBag();
        // $this->newEmployeeJoiningValidation();
        $this->newCurrentStep--;
        if ($this->newCurrentStep < 1) {
            $this->newCurrentStep = 1;
        }
    }

    #[generatedEmpID()]
    public function getGenerateEmpID()
    {

        // $data = EmployeePersonalDetail::select(DB::raw('MAX(emp_id) as max_emp_id'))->first();
        $lastEmp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->count();

        $this->generate_emp_id = $lastEmp + 1;
    }


    public function newEmployeeValidation()
    {

        $this->resetErrorBag('generate_emp_id');
        $this->newEmployeeJoiningValidation();
        if ($this->generate_emp_id) {
            $existingID = EmployeePersonalDetail::where('emp_id', $this->generate_emp_id)
                ->where('business_id', Session::get('business_id'))
                ->exists();

            if ($existingID) {
                $this->addError('generate_emp_id', 'Employee ID already exists.');
            }
        }
    }

    public function validateField($fieldName)
    {
        $this->validateOnly($fieldName, [
            $fieldName => $this->getValidationRules($fieldName),
        ]);
    }
    public function newEmployeeJoiningValidation()
    {
        if ($this->newCurrentStep == 1) {


            $this->validate([
                'new_first_name' => $this->getValidationRules('new_first_name'),
                'new_last_name' => $this->getValidationRules('new_last_name'),
                'new_phone' => $this->getValidationRules('new_phone'),
                'new_email' => $this->getValidationRules('new_email'),
                'new_dob' => $this->getValidationRules('new_dob'),
                'new_gender' => $this->getValidationRules('new_gender'),
                'new_martial_status' => $this->getValidationRules('new_martial_status'),
                'new_doj' => $this->getValidationRules('new_doj'),
                'new_nationality' => $this->getValidationRules('new_nationality'),
                'new_religion' => $this->getValidationRules('new_religion'),
                'new_category' => $this->getValidationRules('new_category'),
                'new_blood_group' => $this->getValidationRules('new_blood_group'),
                'new_govt_id' => $this->getValidationRules('new_govt_id'),
                'new_govt_id_no' => $this->getValidationRules('new_govt_id_no'),


                // Define validations for other fields...
            ]);
        } elseif ($this->newCurrentStep == 2) {


            $this->validate([
                'new_branch' => $this->getValidationRules('new_branch'),
                'new_department' => $this->getValidationRules('new_department'),
                'new_designation' => $this->getValidationRules('new_designation'),
                'generate_emp_id' => $this->getValidationRules('generate_emp_id'),
                'new_attendance_method' => $this->getValidationRules('new_attendance_method'),
                'new_master_endgame_id' => $this->getValidationRules('new_master_endgame_id'),
                'new_report_manager' => $this->getValidationRules('new_report_manager'),
                'new_emp_shift_type' => $this->getValidationRules('new_emp_shift_type'),
                'new_country' => $this->getValidationRules('new_country'),
                'new_state' => $this->getValidationRules('new_state'),
                'new_city' => $this->getValidationRules('new_city'),
                'new_pin_code' => $this->getValidationRules('new_pin_code'),
                'new_address' => $this->getValidationRules('new_address'),


                // Define validations for other fields...
            ]);
        }
    }
    protected function getValidationRules($fieldName)
    {
        $rules = [];

        // Define rules based on field name
        switch ($fieldName) {
            case 'new_first_name':
                $rules = ['required', 'string', 'min:4', 'max:50'];
                break;
            case 'new_last_name':
                $rules = ['required', 'string', 'min:4'];
                break;
            case 'new_phone':
                $rules = ['required', 'min:10', 'digits:10', 'numeric'];
                break;
            case 'new_email':
                $rules = ['required', 'email'];
                break;
            case 'new_dob':
                $rules = ['required'];
                break;
            case 'new_gender':
                $rules = ['required', 'in:1,2,3'];
                break;
            case 'new_martial_status':
                $rules = ['required', 'in:1,2,3,4'];
                break;
            case 'new_doj':
                $rules = ['required'];
                break;
            case 'new_nationality':
                $rules = ['required'];
                break;
            case 'new_religion':
                $rules = ['required', 'in:1,2,3,4,5'];
                break;
            case 'new_category':
                $rules = ['required', 'numeric'];
                break;
            case 'new_blood_group':
                $rules = ['required', 'numeric'];
                break;
            case 'new_govt_id':
                $rules = ['required', 'in:1,2,3,4,5,6'];
                break;
            case 'new_govt_id_no':
                $rules = [
                    'required', function ($attribute, $value, $fail) {
                        $govtType = $this->new_govt_id;


                        if ($this->new_govt_id_no == 1 && empty($value)) {
                            $fail('The ' . $attribute . ' field is required');
                        }

                        if ($govtType == 1 && empty($value)) {
                            $fail('The ' . $attribute . ' field is required');
                        }
                        if ($this->new_govt_id == 1 && strlen($value) < 12) {
                            $fail('The govt id no must be at least 12 characters');
                        }
                        if ($this->new_govt_id == 2 && strlen($value) < 10) {
                            $fail('The govt id no must be at least 10 characters');
                        }
                        if ($this->new_govt_id == 3 && strlen($value) < 16) {
                            $fail('The govt id no must be  at least 16 characters');
                        }
                        if ($this->new_govt_id == 4 && strlen($value) <= 8) {
                            $fail('The govt id no must be  at least 8-9 characters');
                        }
                        if ($this->new_govt_id == 5 && strlen($value) <= 10) {
                            $fail('The govt id no must be  at least  10 characters');
                        }
                        // Add any other conditions for different govtType values here if needed
                    },
                ];
                break;
            case 'new_branch':
                $rules = ['required', 'nullable'];
                break;
            case 'new_department':
                $rules = ['required', 'nullable'];
                break;
            case 'new_designation':
                $rules = ['required', 'nullable'];
                break;
            case 'generate_emp_id':
                $rules = [
                    'required', 'nullable', 'numeric',
                    Rule::unique('employee_personal_details', 'emp_id')->where(function ($query) {
                        return $query->where('emp_id', '!=', 'generate_emp_id');
                    })->ignore(0),
                ];
                break;
            case 'new_attendance_method':
                $rules = ['required', 'nullable', 'in:1,2,3'];
                break;
            case 'new_master_endgame_id':
                $rules = ['required', 'nullable'];
                break;
            case 'new_report_manager':
                $rules = ['required', 'nullable', 'string'];
                break;
            case 'new_emp_shift_type':
                $rules = ['required', 'nullable'];
                break;
            case 'new_country':
                $rules = ['required', 'nullable'];
                break;
            case 'new_state':
                $rules = ['required', 'nullable'];
                break;
            case 'new_city':
                $rules = ['required', 'nullable'];
                break;
            case 'new_pin_code':
                $rules = ['required', 'nullable'];
                break;
            case 'new_address':
                $rules = ['required', 'string'];
                break;
                // Add more cases for other fields...
        }

        return $rules;
    }


    public function getNewAssignSetup()
    {

        $loaded = PolicyMasterEndgameMethod::where('business_id', Session::get('business_id'))
            ->where('method_switch', 1)
            ->get();
        //checking method loaded on process 
        // ->where('id', $this->master_endgame_id)
        return $loaded;
    }

    #[NewAssignShiftType()]
    public function getNewAssignShiftType()
    {
        $loaded = PolicyMasterEndgameMethod::where('id', $this->new_master_endgame_id)
            ->where('business_id', Session::get('business_id'))
            ->where('method_switch', 1)
            ->select('shift_settings_ids_list')
            ->first();

        if ($loaded !== null) {
            $shiftSettingsIds = json_decode($loaded->shift_settings_ids_list);

            if ($shiftSettingsIds !== null) {
                $modes = PolicyAttendanceShiftSetting::where('business_id', Session::get('business_id'))
                    ->whereIn('id', $shiftSettingsIds)
                    ->get();
                // // Assuming shift_type is a property of PolicyAttendanceShiftSetting
                // $shiftTypes = $modes->pluck('shift_type')->unique()->toArray();

                // // If you want to set a single shift type (assuming only one type is present in $modes)
                // $this->assign_shift_type_runtime = $shiftTypes ?? 0;


                if ($modes->isNotEmpty()) {

                    // dd($shiftTypes);
                    return $modes->isNotEmpty() ? $modes : [];
                }
            }
        }

        return [];
    }
    #[selectRotationalCheck()] //using only show rotational case and set on update value also
    public function selectNewRotationalCheck()
    {
        if ($this->new_emp_shift_type != null) {
            // dd($this->new_emp_shift_type,Session::get('business_id'));

            $load = PolicyAttendanceShiftSetting::where('business_id', Session::get('business_id'))->where('id', $this->new_emp_shift_type)->first();
            if ($load != null) {
                if ($load->shift_type !== '2') {
                    $this->new_select_rotation_type = 0; //default rotational type
                    $this->new_rotational_shift_active = 0;
                } else {

                    $this->new_rotational_shift_active = 1;
                }
            } else {
                return [];
            }
        }
    }

    #[getNewAssignRotationalShift()]
    public function getNewAssignRotationalShift()
    {
        return PolicyAttendanceShiftTypeItem::where('business_id', Session::get('business_id'))->where('attendance_shift_id', $this->new_emp_shift_type)->get();
    }



    #[SubmitForm()]
    public function createSubmit()
    {
        // dd($this->employee_type, $this->employee_contractual_type);
        $this->newEmployeeJoiningValidation();
        $imageUpload = '';
        if ($this->image != null) {
            // temprary image upload in loaded
            $initalLevel = date('d-m-Y') . '_' . md5(time()) . '.' . $this->image->getClientOriginalExtension();
            // $currentImage = $this->profile_image; //->image;
            // $load = EmployeePersonalDetail::where('emp_id', $this->emp_id)->where('business_id', $this->business_id)->where('profile_photo', $currentImage)->first();
            // if ($load != null) {
            //     // $filePath = $this->image->storeAs('livewire_employee_profile', $initalLevel);
            //     unlink(public_path('storage/livewire_employee_profile/') . $currentImage);
            // }
            $filePath = $this->image->storeAs('livewire_employee_profile', $initalLevel);
            $imageUpload = $initalLevel;
            $publicUrl = Storage::url($filePath);
        }

        $student = new EmployeePersonalDetail;
        $student->profile_photo = ($imageUpload != '' && $imageUpload != null) ? $imageUpload : '';
        $student->business_id = Session::get('business_id');
        $student->emp_name = $this->new_first_name;
        $student->emp_mname = $this->new_middle_name;
        $student->emp_lname = $this->new_last_name;
        $student->emp_mobile_number = $this->new_phone;
        $student->emp_religion = $this->new_religion;
        $student->emp_email = $this->new_email;
        $student->emp_date_of_birth = $this->new_dob;
        $student->emp_gender = $this->new_gender;
        $student->emp_marital_status = $this->new_martial_status;
        $student->emp_date_of_joining = $this->new_doj;
        $student->emp_category = $this->new_category;
        $student->emp_blood_group = $this->new_blood_group;
        $student->emp_gov_select_id = $this->new_govt_id;
        $student->emp_gov_select_id_number = $this->new_govt_id_no;
        $student->emp_nationality = $this->new_nationality;
        $student->emp_country = $this->new_country;
        $student->emp_state = $this->new_state;
        $student->emp_city = $this->new_city;
        $student->emp_pin_code = $this->new_pin_code;
        $student->emp_address = $this->new_address;
        $student->emp_id = $this->generate_emp_id;
        $student->emp_shift_type = $this->new_emp_shift_type;
        $student->assign_shift_type = $this->new_rotational_shift_active;
        $student->emp_rotational_shift_type_item = $this->new_select_rotation_type ?? 0;
        $student->branch_id = $this->new_branch;
        $student->department_id = $this->new_department;
        $student->designation_id = $this->new_designation;
        $student->emp_attendance_method = $this->new_attendance_method;
        $student->emp_reporting_manager = $this->new_report_manager;
        $student->master_endgame_id = $this->new_master_endgame_id;
        $student->employee_type = $this->employee_type;
        $student->employee_contractual_type = ($this->employee_contractual_type != null &&  $this->employee_type != '1') ? $this->employee_contractual_type : 0;
        $student->active_emp = ($this->new_isEnabled != false) ? 1 : 0;
        if ($student->save()) {

            Alert::success('Added Successfully', 'Your Employee Detail is Added Successfully');
        } else {
            Alert::info('Not Added', 'Your Employee Detail is Not Added ');
        }
        return redirect('admin/employee');

        // $data=EmployeePersonalDetail::insert($store);
        // dd($store);
    }


    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->reset();
        $this->image = '';
        $this->employee_type = '';
        $this->employee_contractual_type = '';
    }


    // Globel Uses at models all shows
    #[RELIGION()]
    public function religion()
    {

        return StaticEmployeeJoinReligion::all();
    }


    #[Country()]
    public function country()
    {

        return StaticCountryModel::all();
    }

    #[State()]
    public function state()
    {
        return StaticStatesModel::where('country_id', $this->country ?? $this->new_country)->get();
    }

    #[Cities()]
    public function city()
    {

        return StaticCityModel::where('state_id', $this->state ?? $this->new_state)->get();
    }


    public function render()
    {
        $call = new Central_unit();
        $Branch = $call->BranchList();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $attendanceMethod = StaticAttendanceMethod::get();
        // dd($attendanceMethod);
        $shiftAttendance = DB::table('policy_attendance_shift_settings')
            ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
            ->where('business_id', Session::get('business_id'))
            ->select('policy_attendance_shift_settings.id as attendance_id', 'policy_attendance_shift_settings.shift_type_name')
            ->get();

        $setupAssociated = DB::table('policy_master_endgame_method')
            ->where('business_id', Session::get('business_id'))
            ->where('method_switch', '1')
            ->select('id', 'method_name', 'method_switch')
            ->get();

        // join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
        $DATA = EmployeePersonalDetail::where('employee_personal_details.business_id', Session::get('business_id'))
            ->orderBy('employee_personal_details.id', 'desc')
            ->get();

        $staticGender = StaticEmployeeJoinGenderType::get();
        $staticMarital = StaticEmployeeJoinMaritalType::get();
        $statciCategory = StaticEmployeeJoinCategoryCaste::get();
        $staticbloodGroup = StaticEmployeeJoinBloodGroup::get();
        $staticGovId = StaticEmployeeJoinGovtDocType::get();
        $StaticReligon = StaticEmployeeJoinReligion::get();

        $getCountry = DB::table('static_countries')->get();

        return view('livewire.admin.employee-page', compact('DATA', 'StaticReligon', 'setupAssociated', 'Branch', 'moduleName', 'permissions', 'shiftAttendance', 'attendanceMethod', 'staticGender', 'staticMarital', 'statciCategory', 'staticbloodGroup', 'staticGovId', 'getCountry'));
    }
}
