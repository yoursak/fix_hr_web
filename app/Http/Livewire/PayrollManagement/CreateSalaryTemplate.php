<?php

namespace App\Http\Livewire\PayrollManagement;


use App\Http\Livewire\PowerGrid\EmployeePageTable;
use Livewire\Component;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
use App\Models\GradeList;
use App\Helpers\Central_unit;
use App\Exports\AddEmployeeDetails;
use App\Exports\ExportEmployeeDetails;
use App\Exports\TableExcelExport;
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
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\StaticAttendanceMode;
use App\Models\Image;
use App\Livewire\UploadPhoto;
use File;
use Illuminate\Http\Response;
// use Alert;
use Illuminate\Http\UploadedFile;
use Validator;
use Illuminate\Validation\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGrid;

use App\Helpers\MasterRulesManagement\RulesManagement;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BranchList;
use function PHPSTORM_META\type;
use App\Models\StaticSalaryType;
use App\Models\StaticSalaryEarningType;

class CreateSalaryTemplate extends Component
{
    use WithFileUploads, WithPagination;
    public $InterationCountMode = 0;
    public $cloneArray = [];

    public function mount()
    {
        $this->InterationCountMode = 1;
    }
    public function getAppended()
    {
        // $this->InterationCountMode++;
    }
    public function clickToAppended()
    {
        $this->cloneArray[] = $this->InterationCountMode++;
    }

    public function render()
    {
        $root = StaticSalaryType::get()->pluck('salary_type_name', 'salary_type_id');
        $SalaryType = $root; //['hourly' => 'Hourly', 'monthly' => 'Monthly', 'yearly' => 'Yearly'];
        $SalaryCalculateType = StaticSalaryEarningType::get()->pluck('name', 'type_id');
        return view('livewire.payroll-management.create-salary-template', compact('SalaryType', 'SalaryCalculateType'));
    }
}