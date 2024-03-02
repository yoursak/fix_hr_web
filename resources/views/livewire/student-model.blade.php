<style>
    .text-error-danger {
        font-size: 10px;
        color: red;
    }

    .custom-switch-indicator {
        background: red;
        /* Change this to the desired red color */
    }

    .profile-pic-wrapper {
        width: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .pic-holder {
        text-align: center;
        position: relative;
        border-radius: 50%;
        width: 120px;
        /* //150px; */
        height: 120px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .pic-holder .pic {
        /* height: 100%;
        width: 100%; */
        -o-object-fit: cover;
        object-fit: cover;
        -o-object-position: center;
        object-position: center;
    }

    .text-danger {
        color: red;
        /* or any other red color you prefer */
    }

    .pic-holder .upload-file-block,
    .pic-holder .upload-loader {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(90, 92, 105, 0.7);
        color: #f8f9fc;
        font-size: 12px;
        font-weight: 600;
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .pic-holder .upload-file-block {
        cursor: pointer;
    }

    .pic-holder:hover .upload-file-block,
    .uploadProfileInput:focus~.upload-file-block {
        opacity: 1;
    }

    .pic-holder.uploadInProgress .upload-file-block {
        display: none;
    }

    .pic-holder.uploadInProgress .upload-loader {
        opacity: 1;
    }

    /* Snackbar css */
    .snackbar {
        visibility: hidden;
        min-width: 250px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 14px;
        transform: translateX(-50%);
    }

    .snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @-webkit-keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }

    @keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }
</style>

<script src="{{ asset('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>
<div wire:ignore.self class="modal fade" id="newStudentModal" tabindex="-1" aria-labelledby="newStudentModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h5 class="modal-title" id="newStudentModalLabel">Add New Employee</h5>
                <a aria-label="Close" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"><span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">

                <form wire:submit.prevent="createSubmit" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="step-one">
                        @if ($newCurrentStep == 1)

                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">

                                    <h4 class="mb-2 font-weight-bold">Personal Details</h4>
                                    <div class="row profile-image">
                                        <div class="col-md-4">

                                        </div>

                                        <div class="col-md-4 text-center ">
                                            {{-- <input type="file" name="csv_file" class="load" data-height="90"> --}}
                                            <div class="profile-pic-wrapper">
                                                <div class="pic-holder">
                                                    @if ($image)
                                                    <img class="pic rounded-circle" src="{{ $image->temporaryUrl() }}" height="150px" width="150px" alt="upload profile image new" class="mt-2">
                                                    @endif
                                                    @if (!$image)
                                                    <img class="pic rounded-circle" src="{{ asset('business_logo/' . Session::get('login_business_image')) }}" alt="profile image">
                                                    @endif
                                                    {{-- <input class="uploadProfileInput" type="file" class="form-control"
                                                    wire:model="image" id="newProfilePhoto" style="padding: 3px 5px; "
                                                    name="profile_pic" style="opacity: 0;" wire:target="uploadImage"
                                                    wire:key="uploadImage" /> --}}
                                                    <label for="newProfilePhoto" class="upload-file-block">
                                                        <div class="text-center">
                                                            <div class="mb-2">
                                                                <i class="fa fa-camera fa-2x"></i>
                                                            </div>
                                                            <div class="text-uppercase">
                                                                Update <br /> Profile Photo
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>

                                            </div>


                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">


                                            <div class="">
                                                <div wire:loading wire:target="image" wire:key="image"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Uploading
                                                </div>

                                                <div class="col-md-8">
                                                </div>
                                            </div>

                                            @error('image')
                                            <span class="text-error-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror





                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">First Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="" wire:keyup="newEmployeeJoiningValidation" placeholder="Enter first name" wire:model="new_first_name">
                                            <span class="text-error-danger">
                                                @error('new_first_name')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Middle Name</label>
                                            <input id="" type="text" class="update_mname_sddd form-control" placeholder="Middle Name" wire:model="new_middle_name" name="new_middle_name">
                                            <span class="text-error-danger">
                                                @error('middle_name')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Last
                                                Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="" placeholder="Enter last name" wire:keyup="newEmployeeJoiningValidation" wire:model="new_last_name">
                                            <span class="text-error-danger">
                                                @error('new_last_name')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Contact Number<span class="text-danger">*</span></label>
                                            <input id="" type="number" wire:model="new_phone" class=" form-control" wire:keyup="newEmployeeJoiningValidation" placeholder="Enter 10-digit phone number">
                                            <span class="text-error-danger">
                                                @error('new_phone')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Email ID<span class="text-danger">*</span></label>
                                            <input class=" form-control" wire:model="new_email" placeholder="email" id="" wire:keyup="newEmployeeJoiningValidation" name="">
                                            <span class="text-error-danger">
                                                @error('new_email')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Date Of Birth<span class="text-danger">*</span></label>
                                            <input type="date" class=" form-control fc-datepicker" placeholder="DD-MM-YYY" wire:keyup="newEmployeeJoiningValidation" wire:model="new_dob" id="dateofbirth_sd">
                                            <span class="text-error-danger">
                                                @error('new_dob')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Gender<span class="text-danger">*</span></label>
                                            <select class="form-control " aria-label="Type" id="" name="" wire:model="new_gender" wire:change="newEmployeeJoiningValidation">
                                                <option value="">Select Gender</option>
                                                @foreach ($staticGender as $gender)
                                                <option value="{{ $gender->id }}">
                                                    {{ $gender->gender_type }}
                                                </option>
                                                @endforeach

                                            </select>
                                            <span class="text-error-danger">
                                                @error('new_gender')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Marital Status<span class="text-danger">*</span></label>
                                            <select class="form-control marital_satatu_sddd" aria-label="Type" id="" name="" wire:model.live="new_martial_status" wire:model="new_martial_status" wire:change="newEmployeeJoiningValidation">
                                                <option value="">Select Marital Status</option>
                                                @foreach ($staticMarital as $martial)
                                                <option value="{{ $martial->id }}">
                                                    {{ $martial->marital_type }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="text-error-danger">
                                                @error('new_martial_status')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Date Of Joining<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control fc-datepicker " id="" placeholder="DD-MM-YYYY" name="" wire:change="newEmployeeJoiningValidation" wire:model="new_doj">
                                            <span class="text-error-danger">
                                                @error('new_doj')
                                                {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Nationality<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control " name="" id="" wire:model="new_nationality">

                                            <span class="text-error-danger">
                                                @error('new_nationality')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Religion<span class="text-danger">*</span></label>
                                            <select class="form-control" aria-label="Type" id="" name="" wire:model="religion" wire:model.live="new_religion" wire:change="newEmployeeJoiningValidation">
                                                <option value="">Select Religion</option>
                                                @foreach ($this->religion() as $staticreligon)
                                                <option value="{{ $staticreligon->id }}">
                                                    {{ $staticreligon->religion_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="text-error-danger">
                                                @error('new_religion')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Category<span class="text-danger">*</span></label>
                                            <select class="form-control update_caste_sddd" wire:model="new_category" wire:change="newEmployeeJoiningValidation" aria-label="Type" id="" name="">
                                                <option value="">Select Category</option>
                                                @foreach ($statciCategory as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->caste_category }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="text-error-danger">
                                                @error('new_category')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>



                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Blood Group<span class="text-danger">*</span></label>
                                            <select class="form-control " aria-label="Type" id="" name="" wire:model="new_blood_group" wire:change="newEmployeeJoiningValidation">
                                                <option value="">Select Blood Group</option>
                                                @foreach ($staticbloodGroup as $bloodgroup)
                                                <option value="{{ $bloodgroup->id }}">
                                                    {{ $bloodgroup->blood_group }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="text-error-danger">
                                                @error('new_blood_group')
                                                {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Select Government Id<span class="text-danger">*</span></label>
                                            <select class="form-control" aria-label="Type" id="select_id_dd" name="" wire:model="new_govt_id" wire:change="newEmployeeJoiningValidation">
                                                <option value="">Select Any Government Id</option>
                                                @foreach ($staticGovId as $govId)
                                                <option value="{{ $govId->id }}">
                                                    {{ $govId->govt_type }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="text-error-danger">
                                                @error('new_govt_id')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Id Number<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control " wire:model="new_govt_id_no" name="" wire:keyup="newEmployeeJoiningValidation">
                                            <span class="text-error-danger">
                                                @error('new_govt_id_no')
                                                {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        {{-- <div class="col-md-6 p-3 ">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1"
                                                value="option1">
                                            <span class="custom-control-label"><b>Send SMS
                                                    Employee</b></span>
                                            <span class="fs-11">By continuing you agree to <b><a href="#"
                                                        class="text-primary">Tearm &
                                                        Conditions</a></b>
                                            </span>
                                        </label>

                                        </select>
                                    </div> --}}
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- STEP 2 --}}
                    <div class="step-two">
                        @if ($newCurrentStep == 2)
                        {{-- frameworks --}}
                        <div class="card">
                            <div class="card-body">
                                <div class=" row ">
                                    <h4 class=" font-weight-bold">Company Details</h4>

                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Branch<span class="text-danger">*</span></label>
                                        <select name="" id="" wire:model.live="new_branch" wire:model="new_branch" class=" form-control" wire:change="newEmployeeJoiningValidation">
                                            <option value="">Select Branch Name</option>
                                            @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-error-danger">
                                            @error('new_branch')
                                            {{ $message }}
                                            @enderror
                                        </span>

                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Department<span class="text-danger">*</span></label>
                                        <select name="" wire:model.live="new_department" class=" form-control" wire:change="newEmployeeJoiningValidation" wire:model="new_department">
                                            <option value="">
                                                Select Deparment Name</option>
                                            @foreach ($Department as $data)
                                            <option value="{{ $data->depart_id }}">
                                                {{ $data->depart_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-error-danger">
                                            @error('new_department')
                                            {{ $message }}
                                            @enderror
                                        </span>

                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Designation<span class="text-danger">*</span></label>
                                        <select name="" class="form-control" wire:model.live="new_designation" wire:change="newEmployeeJoiningValidation" wire:model="new_designation">
                                            <option value="">Select Designation Name</option>
                                            @foreach ($Designation as $data)
                                            <option value="{{ $data->desig_id }}">
                                                {{ $data->desig_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-error-danger">
                                            @error('new_designation')
                                            {{ $message }}
                                            @enderror
                                        </span>

                                    </div>


                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Employee ID<span class="text-danger">*</span>
                                            {{-- <a wire:click="getGenerateEmpID"
                                                class="p-0 btn btn-primary btn-sm">EmpId
                                                A.I.</a>  --}}
                                            {{-- $generate_emp_id != null ? 'IT001' : ' not create module' --}}
                                        </label>
                                        <input name="" id="" type="text" wire:keyup="newEmployeeValidation" wire:change="newEmployeeJoiningValidation" class=" form-control" wire:model.live="generate_emp_id" wire:model="generate_emp_id" placeholder="Employee ID Like: IT001">
                                        <span class="text-error-danger">
                                            @error('generate_emp_id')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Assign Attendance Method<span class="text-danger">*</span></label>
                                        <select class="form-control custom-select" wire:model.live="new_attendance_method" wire:change="newEmployeeJoiningValidation" wire:model="new_attendance_method">
                                            <option value="">Select Attendence
                                                Method
                                            </option>
                                            @foreach ($this->getAssignAttendanceMethod() as $assign_attendance)
                                            <option value="{{ $assign_attendance->id }}">
                                                {{ $assign_attendance->method_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-error-danger">
                                            @error('new_attendance_method')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Assign Setup<span class="text-danger">*</span></label>
                                        @php
                                        $assignSetup = $this->getNewAssignSetup();
                                        @endphp
                                        @if ($assignSetup && count($assignSetup) > 0)
                                        <select wire:model.live="new_master_endgame_id" class="form-control  custom-select" wire:change="newEmployeeJoiningValidation" wire:model="new_master_endgame_id">
                                            <option value="">Select Shift Type</option>
                                            @foreach ($assignSetup as $shiftsetSetup)
                                            <option value="{{ $shiftsetSetup->id }}">
                                                {{ $shiftsetSetup->method_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @else
                                        <span>No Shift Settings Found</span>
                                        @endif
                                        <span class="text-error-danger">
                                            @error('new_master_endgame_id')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="col-md-4" wire:ignore>
                                        {{-- <span
                                                class="text-danger">*</span> --}}
                                        <label class="form-label mb-0 mt-2">Reporting Manager</label>
                                        <select wire:model='new_report_manager' wire:change="getReportingList" wire:keyup="validateData" placeholder="Select Employee" class=" form-control search_test">
                                            <option selected value="">Select Reporting Manager</option>
                                            @if (!empty($listMode))
                                            @foreach ($listMode as $option)
                                            <option value="{{ $option->emp_id }}">
                                                {{ $option->first_name . '' . $option->last_name }}
                                                | {{ $option->desig_name }}
                                            </option>
                                            @endforeach
                                            @else
                                            <div class="list-item">No Result</div>
                                            @endif
                                        </select>
                                        <span class="text-error-danger">
                                            @error('new_report_manager')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                        <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.min.js') }}"></script>
                                        <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.js') }}"></script>
                                        <script>
                                            $('.search_test').SumoSelect({
                                                search: true,
                                                searchText: 'Enter here.'
                                            });
                                        </script>

                                    </div>


                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Assign Shift<span class="text-danger">*</span></label>
                                        @php
                                        $newassignShiftType = $this->getNewAssignShiftType();
                                        @endphp
                                        @if ($newassignShiftType && count($newassignShiftType) > 0)

                                        <select wire:model.live="new_emp_shift_type" wire:change="selectNewRotationalCheck" wire:model="new_emp_shift_type" class="form-control">
                                            <option value="">Select Shift Type</option>
                                            @foreach ($newassignShiftType as $shiftset)
                                            <option value="{{ $shiftset->id }}">
                                                {{ $shiftset->shift_type_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @else
                                        <span>No Assign Shift Found</span>
                                        @endif
                                        <span class="text-error-danger">
                                            @error('new_emp_shift_type')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="col-md-4">
                                        @if ($new_rotational_shift_active != 0)
                                        @php
                                        $assignRotationalShiftType = $this->getNewAssignRotationalShift();
                                        @endphp
                                        @if ($assignRotationalShiftType && count($assignRotationalShiftType) > 0)
                                        <label class="form-label mb-0 mt-2">Select Rotational Type<span class="text-danger">*</span></label>

                                        <select wire:model="new_select_rotation_type" wire:change="newEmployeeJoiningValidation" wire:model.live="new_select_rotation_type" class="form-control">
                                            <option value="">Select Rotational Type</option>
                                            @foreach ($assignRotationalShiftType as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->shift_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @else
                                        <span>No Rotational Found</span>
                                        @endif
                                        <span class="text-error-danger">
                                            @error('new_select_rotation_type')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                        @endif

                                    </div>
                                    <h4 class="pt-5 font-weight-bold">Communication Details</h4>

                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Country<span class="text-danger">*</span></label>
                                        <select class="form-control w-100 border rounded" wire:model.live="new_country" wire:model="new_country" wire:change="newEmployeeJoiningValidation">
                                            <option value="">Select Country</option>
                                            @foreach ($this->country() as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}
                                            </option>
                                            @endforeach
                                        </select>

                                        <span class="text-error-danger">
                                            @error('new_country')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>


                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">State<span class="text-danger">*</span></label>
                                        <select class="form-control w-100 border rounded" wire:model="new_state" wire:model.live="new_state" wire:change="newEmployeeJoiningValidation">
                                            <option value="">Select State</option>
                                            @foreach ($this->state() as $phone)
                                            <option value="{{ $phone->id }}">{{ $phone->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-error-danger">
                                            @error('new_state')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">City<span class="text-danger">*</span></label>
                                        <select wire:model.live="new_city" class="form-control w-100 border rounded" name="" wire:model="new_city" wire:change="newEmployeeJoiningValidation">
                                            <option value="">Select City</option>
                                            @foreach ($this->city() as $cities)
                                            <option value="{{ $cities->id }}">{{ $cities->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-error-danger">
                                            @error('new_city')
                                            {{ $message }}
                                            @enderror
                                        </span>

                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Pin Code<span class="text-danger">*</span></label>
                                        <input type="number" class=" form-control" placeholder="Postal PIN" name="" wire:keyup="newEmployeeJoiningValidation" wire:model="new_pin_code">
                                        <span class="text-error-danger">
                                            @error('new_pin_code')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label mb-0 mt-2">Address<span class="text-danger">*</span></label>
                                        <textarea id="" type="text" wire:model="new_address" class=" form-control" wire:keyup="newEmployeeJoiningValidation" placeholder="Address" name="" cols="30" rows="2"></textarea>
                                        <span class="text-error-danger">
                                            @error('new_address')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 p-3">

                                            <label class="custom-switch">
                                                Active &nbsp;
                                                <input type="checkbox" wire:model="new_isEnabled" class="custom-switch-input" <?= $new_isEnabled !== false ? 'checked' : '' ?>>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Enable/Disable</span>
                                            </label>
                                        </div>

                                    </div>

                                    {{-- <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="example-checkbox2"
                                        value="option2">
                                    <span class="custom-control-label">I agree terms &
                                        Conditions</span>
                                </label> --}}
                                </div>
                            </div>
                        </div>

                        @endif
                    </div>
                    <div class="step-three">
                        @if ($newCurrentStep == 3)
                        {{-- frameworks --}}
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group">

                                    <h4 class="mb-2 font-weight-bold">Add Bank Details</h4>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">IFSC Code</label>
                                            <input type="text" class="form-control" name="new_ifsc_code" placeholder="Enter Ifsc Code" wire:model="new_ifsc_code" wire:keyup="newEmployeeJoiningValidation">
                                            <span class="text-error-danger">
                                                @error('new_ifsc_code')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Bank Name</label>
                                            <input type="text" class="form-control" name="new_bank_name" placeholder="Enter Bank Name" wire:model="new_bank_name" wire:keyup="newEmployeeJoiningValidation">
                                            <span class="text-error-danger">
                                                @error('new_bank_name')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Branch Name</label>
                                            <input type="text" class="form-control" name="new_branch_name" placeholder="Enter Branch Name" wire:model="new_branch_name" wire:keyup="newEmployeeJoiningValidation">
                                            <span class="text-error-danger">
                                                @error('new_branch_name')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Branch Code</label>
                                            <input type="text" class="form-control" name="new_branch_code" placeholder="Enter Branch Code" wire:model="new_branch_code" wire:keyup="newEmployeeJoiningValidation">
                                            <span class="text-error-danger">
                                                @error('new_branch_code')
                                                {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Bank Account No.</label>
                                            <input type="number" class="form-control" name="new_bank_accountno" placeholder="Enter Bank Account No." wire:model="new_bank_accountno" wire:keyup="newEmployeeJoiningValidation">
                                            <span class="text-error-danger">
                                                @error('new_bank_accountno')
                                                {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">MICR Code</label>
                                            <input type="number" class="form-control" name="new_micr_code" placeholder="Enter Micr Code" wire:model="new_micr_code" wire:keyup="newEmployeeJoiningValidation">
                                            <span class="text-error-danger">
                                                @error('new_micr_code')
                                                {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0 mt-2">Address (Line 1)</label>
                                            <textarea type="text" class="form-control" name="new_bank_address_line1" placeholder="Enter Address Line 1 without State,City & Pincode" wire:model="new_bank_address_line1" wire:keyup="newEmployeeJoiningValidation"></textarea>
                                            <span class="text-error-danger">
                                                @error('new_bank_address_line1')
                                                {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label mb-0 mt-2">Address (Line 2)</label>
                                            <textarea type="text" class="form-control" name="new_bank_address_line2" placeholder="Enter Address Line 2 without State,City & Pincode" wire:model="new_bank_address_line2" wire:keyup="newEmployeeJoiningValidation"></textarea>
                                            <span class="text-error-danger">
                                                @error('new_bank_address_line2')
                                                {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">

                                    <h4 class="mb-2 font-weight-bold">Add Other Details</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Grade Type</label>
                                            <select wire:model="new_grade" wire:change="newEmployeeJoiningValidation" wire:model.live="new_grade" class="form-control">
                                                <option value="">Select Grade Type</option>
                                                @foreach ($this->getGradeList() as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->grade_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="text-error-danger">
                                                @error('new_grade')
                                                {{ $message }}
                                                @enderror
                                            </span>

                                        </div>

                                        {{-- <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Grade<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="new_grade"
                                                placeholder="Enter Grade " wire:model="new_grade"
                                                wire:keyup="validateData">
                                            <span class="text-error-danger">
                                                @error('new_grade')
                                                    {{ $message }}
                                        @enderror
                                        </span>
                                    </div> --}}

                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Budget Code</label>
                                        <input type="number" class="form-control" name="new_budget_code" placeholder="Enter Budget Code" wire:model="new_budget_code" wire:keyup="newEmployeeJoiningValidation">
                                        <span class="text-error-danger">
                                            @error('new_budget_code')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mb-0 mt-2">Account Code</label>
                                        <input type="number" class="form-control" name="new_account_code" placeholder="Enter Account Code" wire:model="new_account_code" wire:keyup="newEmployeeJoiningValidation">
                                        <span class="text-error-danger">
                                            @error('new_account_code')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

            </div>
            {{-- pt-2 pb-2 bg-white --}}
            <div class="action-buttons d-flex justify-content-between   bg-white p-2 ">

                @if ($newCurrentStep == 1)
                <div></div>
                <button type="button" class="btn btn-md btn-primary" wire:click="newIncreaseStep()">Next</button>
                @endif
                @if ($newCurrentStep == 2 || $newCurrentStep == 3)
                <button type="button" class="btn btn-md btn-danger" wire:click="newDecreaseStep()">Back</button>
                @endif
                @if ($newCurrentStep == 2)
                <button type="button" class="btn btn-md btn-primary" wire:click="newIncreaseStep()">Next</button>
                @endif
                @if ($newCurrentStep == 3)
                <button type="button" class="btn btn-md btn-primary" wire:click="newIncreaseStep()" hidden>Next</button>
                @endif
                @if ($newCurrentStep == 3)
                <button type="submit" class="btn btn-md btn-primary">Submit</button>
                @endif

            </div>

            </form>
        </div>
    </div>
</div>
</div>
<div wire:ignore.self class="modal fade" id="empTypeComponent" data-bs-backdrop="static">

    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h5 style="color: #fff!important">Add New Employee</h5>
                <a aria-label="Close" class="btn-close" data-bs-dismiss="modal" wire:click="EmployeeType"><span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body  justify-content-around">
                <div class="row justify-content-center  ">
                    <div class="col-sm-10 justify-content-center">
                        <p class="form-label">Select Employee Type</p>
                        <div class="form-group">
                            <select wire:model="employee_type" name="employee_type" class="form-control form-select" wire:change="showHideModel">
                                <option value="" selected>Select Employee Type</option>
                                @foreach ($getEmpType as $item)
                                <option value="<?= $item->type_id ?>">
                                    <?= $item->emp_type ?>
                                </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                @if ($EmployeeTypeCheck == 1)

                <div class="col-sm-12 text-center ">
                    <div>
                        <h3><b style="color:#1877f2">Regular Employee</b></h3>
                    </div>
                    <div>
                        <a type="button" class="btn btn-primary my-2 border-0" data-bs-toggle="modal" data-effect="effect-scale" data-bs-target="#newStudentModal"><b> Add New Employee</b></a>


                        <a href="{{ url('admin/employee/export_file/1') }}" class="btn btn-primary my-2 border-0" data-bs-toggle="modal" data-bs-target="{{ url('admin/employee/export_file') }}"><b><i class="fa fa-file-excel-o me-1"></i>Download
                                Sample Template</b>
                        </a>
                        <form action="{{ url('admin/employee/import_file') }}" method="POST" enctype="multipart/form-data" wire:ignore>
                            @csrf

                            <input type="text" id="emp_type" name="emp_type" value="1" hidden>
                            <input type="file" name="csv_file" class="load" data-height="90" data-allowed-file-extensions="xlsx">
                            <button type="submit" class="btn btn-primary my-2 border-0"> <b>Upload
                                    Employees</b></button>
                            <script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js?v1.3') }}"></script>
                            <script src="{{ asset('assets/plugins/formwizard/fromwizard.js?v3.80') }}"></script>
                            <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
                            <script src="{{ asset('assets/js/filupload.js?v=10') }}"></script>

                            <script>
                                LoaderPackageDropify('load', 'Employee Bulk Upload Select Regular Excel File');
                                LoaderPackageDropify('load2', 'Employee Bulk Upload Select Contractual Excel File');
                            </script>
                        </form>

                    </div>
                </div>
                @elseif ($EmployeeTypeCheck == 2)

                <div class="col-sm-12 justify-content-center ">
                    <div class="row justify-content-center  ">
                        <div class="col-sm-10 justify-content-center">
                            <p class="form-label">Select Contractual Type</p>
                            <div class="form-group ">
                                <select id="ContractType" wire:model="employee_contractual_type" name="contractualtype" class="form-control form-select">
                                    <option value="" selected>Select Contractual Type</option>
                                    @foreach ($getContractualType as $item)
                                    <option value="<?= $item->id ?>">
                                        <?= $item->contractual_type ?>
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-center"><b style="color:#1877f2">Contractual Employee</b></h3>

                    <div class="text-center">
                        <a type="button" class="modal-effect btn btn-primary my-2 border-0" data-bs-toggle="modal" data-effect="effect-scale" data-bs-target="#newStudentModal"><b>
                                Add
                                Employee</b></a>
                        <a href="{{ url('admin/employee/export_file/2') }}" class="btn btn-primary my-2 border-0 " data-bs-toggle="modal" data-bs-target="{{ url('admin/employee/export_file/2') }}"><b><i class="fa fa-file-excel-o me-1"></i>Download
                                Sample Template</b>
                        </a>
                        <form action="{{ url('admin/employee/import_file') }}" method="POST" enctype="multipart/form-data" wire:ignore>
                            @csrf
                            <input type="text" id="emp_type" name="emp_type" value="2" hidden>
                            <input type="file" name="csv_file" class="load2" data-height="90" data-allowed-file-extensions="xlsx">
                            <button type="submit" class="btn btn-primary my-2 border-0 "> <b>Upload
                                    Employees</b></button>

                            <script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js?v1.3') }}"></script>
                            <script src="{{ asset('assets/plugins/formwizard/fromwizard.js?v3.80') }}"></script>
                            <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
                            <script src="{{ asset('assets/js/filupload.js?v=10') }}"></script>

                            <script>
                                LoaderPackageDropify('load', 'Employee Bulk Upload Select Regular Excel File');
                                LoaderPackageDropify('load2', 'Employee Bulk Upload Select Contractual Excel File');
                            </script>
                        </form>

                    </div>


                </div>

                @endif

            </div>
        </div>
    </div>
</div>
<!-- Update Student Modal -->
<div wire:ignore.self class="modal fade " id="updateStudentModal" tabindex="-1" aria-labelledby="updateStudentModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog   modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Update Employee Details</h6>
                <a aria-label="Close" class="btn-close" id="closeModalButton" wire:click="closeModal" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">

                <form wire:submit.prevent="updateSubmit" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="step-one">

                        @if ($currentStep == 1)


                        <div class="card">


                            <div class="card-body">

                                {{-- <div class="form-group">
                                <div class="col-md-4">
                                    <input wire:model="enter_searching" wire:keydown.enter="search" type="text"
                                        class="form-input " placeholder="Report Manager Search..">
                                </div>
                                <div wire:loading
                                    class="absolute z-10 list-group bg-white w-full round-t-none shadow-lg">
                                    <div class="list-item">Searching...</div>
                                </div>
                                <div class="absolute z-10 list-group bg-white w-full round-t-none shadow-lg"
                                    wire:loading.remove>
                                    @if (!empty($listReportManager))
                                    @foreach ($listReportManager as $manager)
                                    <div class="list-item">{{ $manager['emp_id'] }} - {{ $manager['emp_name'] }}
                            </div>
                            @endforeach
                            @else
                            <div class="list-item">No Result</div>
                            @endif
                        </div>
                    </div> --}}
                    <div class="form-group">

                        <h4 class="mb-2 font-weight-bold">Personal Details</h4>
                        <div class="row profile-image">
                            <div class="col-md-4">

                            </div>

                            <div class="col-md-4 text-center ">
                                {{-- <input type="file" name="csv_file" class="load" data-height="90"> --}}
                                <div class="profile-pic-wrapper">
                                    <div class="pic-holder">
                                        @if ($image)
                                        <img class="pic rounded-circle" src="{{ $image->temporaryUrl() }}" height="150px" width="150px" alt="upload profile image new" class="mt-2">
                                        @elseif ($profile_image)
                                        <img class="pic rounded-circle" src="{{ asset('storage/livewire_employee_profile/' . $profile_image) }}" alt="profile image">
                                        @elseif(!$profile_image)
                                        <img class="pic rounded-circle" src="{{ asset('business_logo/' . Session::get('login_business_image')) }}" alt="profile image">
                                        @endif

                                        {{-- @if ($image)
                                                <img class="pic rounded-circle" src="{{ $image->temporaryUrl() }}"
                                        height="150px" width="150px" alt="upload profile image new"
                                        class="mt-2">
                                        @endif
                                        @if ($profile_image)
                                        <img class="pic rounded-circle" src="{{ asset('storage/livewire_employee_profile/' . $profile_image) }}" alt="profile image">
                                        @endif
                                        @if (!$profile_image)
                                        <img class="pic rounded-circle" src="{{ asset('business_logo/' . Session::get('login_business_image')) }}" alt="profile image">
                                        @endif --}}

                                        <input class="uploadProfileInput" type="file" class="form-control" wire:model="image" id="newProfilePhoto" style="padding: 3px 5px; " name="profile_pic" style="opacity: 0;" wire:target="uploadImage" wire:key="uploadImage" />
                                        <label for="newProfilePhoto" class="upload-file-block">
                                            <div class="text-center">
                                                <div class="mb-2">
                                                    <i class="fa fa-camera fa-2x"></i>
                                                </div>
                                                <div class="text-uppercase">
                                                    Update <br /> Profile Photo
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                </div>


                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">


                                <div class="">
                                    <div wire:loading wire:target="image" wire:key="image"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Uploading
                                    </div>

                                    <div class="col-md-8">
                                    </div>
                                </div>

                                @error('image')
                                <span class="text-error-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror





                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="update_name" placeholder="Enter first name" wire:model="first_name" wire:keyup="validateData">
                                <span class="text-error-danger">
                                    @error('first_name')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Middle Name</label>
                                <input id="" type="text" class="update_mname_sddd form-control " placeholder="Middle Name" wire:model="middle_name" name="update_mName" wire:keyup="validateData">
                                <span class="text-error-danger">
                                    @error('middle_name')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Last
                                    Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="update_lName" placeholder="Enter last name" wire:model="last_name" wire:keyup="validateData">
                                <span class="text-error-danger">
                                    @error('last_name')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Contact Number<span class="text-danger">*</span></label>
                                <input id="number_sd" type="number" wire:model="phone_no" class="update_cnumber_sddd form-control" placeholder="Enter 10-digit phone number" name="update_mobile_number" maxlength="10" pattern="[0-9]{10}" wire:keyup="validateData">
                                <span class="text-error-danger">
                                    @error('phone_no')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Email ID<span class="text-danger">*</span></label>
                                <input name="udpate_email" type="email" class="update_email_sddd form-control" wire:model="email" placeholder="email" id="email_sd" name="update_email" wire:keyup="validateData">
                                <span class="text-error-danger">
                                    @error('email')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Date Of Birth<span class="text-danger">*</span></label>
                                <input type="date" class="update_dob_sddd form-control fc-datepicker" placeholder="DD-MM-YYY" wire:model="dob" id="dateofbirth_sd" wire:mode="dob" name="update_dob" wire:keyup="validateData">
                                <span class="text-error-danger">
                                    @error('dob')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Gender<span class="text-danger">*</span></label>
                                <select class="form-control " aria-label="Type" id="" name="update_gender" wire:model="gender" wire:change="validateData">
                                    <option value="">Select Gender</option>
                                    @foreach ($staticGender as $gender)
                                    <option value="{{ $gender->id }}">
                                        {{ $gender->gender_type }}
                                    </option>
                                    @endforeach

                                </select>
                                <span class="text-error-danger">
                                    @error('gender')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Marital Status<span class="text-danger">*</span></label>
                                <select class="form-control marital_satatu_sddd" aria-label="Type" id="marital_status_dd" name="update_marital" wire:model.live="marital_status" wire:model="marital_status" wire:change="validateData">
                                    <option value="">Select Marital Status</option>
                                    @foreach ($staticMarital as $martial)
                                    <option value="{{ $martial->id }}">
                                        {{ $martial->marital_type }}
                                    </option>
                                    @endforeach
                                </select>
                                <span class="text-error-danger">
                                    @error('marital_status')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Date Of Joining<span class="text-danger">*</span></label>
                                <input type="date" class="form-control fc-datepicker update_doj_dd" id="doj_sd" placeholder="DD-MM-YYYY" name="update_doj" wire:change="validateData" wire:model="doj">
                                <span class="text-error-danger">
                                    @error('doj')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Nationality<span class="text-danger">*</span></label>
                                <input type="text" class="form-control update-nationality_sddd" name="update_nationality" id="nationality_dd" wire:keyup="validateData" wire:model="nationality">
                                {{-- <select class="form-control update_nationality_sddd" name="nationality_dd"
                                            aria-label="Type" id="nationality_dd" name="nationality_dd">
                                            <option value="">Select Nationality</option>
                                            <option value="1">India</option>
                                            <option value="2">USA</option>
                                        </select> --}}
                                <span class="text-error-danger">
                                    @error('nationality')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Religion<span class="text-danger">*</span></label>
                                <select class="form-control" aria-label="Type" id="select_religon" name="religions" wire:model="religion" wire:model.live="religion" wire:change="validateData">
                                    <option value="">Select Religion</option>
                                    @foreach ($this->religion() as $staticreligon)
                                    <option value="{{ $staticreligon->id }}">
                                        {{ $staticreligon->religion_name }}
                                    </option>
                                    @endforeach
                                </select>
                                <span class="text-error-danger">
                                    @error('religion')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Category<span class="text-danger">*</span></label>
                                <select class="form-control update_caste_sddd" wire:model="caste_category" wire:change="validateData" aria-label="Type" id="" name="update_category">
                                    <option value="">Select Category</option>
                                    @foreach ($statciCategory as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->caste_category }}
                                    </option>
                                    @endforeach
                                </select>
                                <span class="text-error-danger">
                                    @error('caste_category')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Blood Group<span class="text-danger">*</span></label>
                                <select class="form-control updateblood_group_sddd" aria-label="Type" id="blood_group_dd" name="update_blood" wire:model="blood_group" wire:change="validateData">
                                    <option value="">Select Blood Group</option>
                                    @foreach ($staticbloodGroup as $bloodgroup)
                                    <option value="{{ $bloodgroup->id }}">
                                        {{ $bloodgroup->blood_group }}
                                    </option>
                                    @endforeach
                                </select>
                                <span class="text-error-danger">
                                    @error('blood_group')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Select Government Id<span class="text-danger">*</span></label>
                                <select class="form-control" aria-label="Type" id="select_id_dd" name="select_govt_type" wire:model="select_govt_type" wire:change="validateData">
                                    <option value="">Select Any Government Id</option>
                                    @foreach ($staticGovId as $govId)
                                    <option value="{{ $govId->id }}">
                                        {{ $govId->govt_type }}
                                    </option>
                                    @endforeach
                                </select>
                                <span class="text-error-danger">
                                    @error('select_govt_type')
                                    {{ $message }}
                                    @enderror
                                </span>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 mt-2">Id Number<span class="text-danger">*</span></label>
                                <input type="text" class="form-control " wire:model="select_govt_id_no" wire:keyup="validateData" name="select_govt_id_no">
                                <span class="text-error-danger">
                                    @error('select_govt_id_no')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            {{-- <div class="col-md-6 p-3 ">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1"
                                                value="option1">
                                            <span class="custom-control-label"><b>Send SMS
                                                    Employee</b></span>
                                            <span class="fs-11">By continuing you agree to <b><a href="#"
                                                        class="text-primary">Tearm &
                                                        Conditions</a></b>
                                            </span>
                                        </label>

                                        </select>
                                    </div> --}}
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>

            </div>
        </div>
        @endif
    </div>

    {{-- STEP 2 --}}



    <div class="step-two">
        @if ($currentStep == 2)



        {{-- <div class="form-group">

                        <div x-ignore>
                            <div class=" d-block" wire:ignore>

                                <select placeholder="Hello  im from placeholder" class="search_test">
                                    <option class="hemant" selected value="saab">Saab</option>
                                    <option class="hemant" value="opel">Opel</option>
                                    <option disabled="disabled" value="mercedez">Mercedez</option>
                                    <option value="aston-martin">Aston Martin</option>
                                    <option value="hyundai">Hyundai</option>
                                    <option value="mitsubishi">Mitsubishi</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
        <div>

            <div>
                {{-- <div class="form-group row">
                                <label class="col-md-4 form-label">Search Select-1:</label>
                                <div class="col-md-4">
                                    <select wire:model="selectedCar" class="search_test">
                                        <option class="hemant" selected value="saab">Saab</option>
                                        <option class="hemant" value="opel">Opel</option>
                                        <option disabled="disabled" value="mercedez">Mercedez</option>
                                        <optgroup label="US Brands">
                                            <option value="chrysler">Chrysler</option>
                                            <option value="gm">General Motors</option>
                                            <option value="ford">Ford</option>
                                            <option disabled="disabled" value="plymouth">Plymouth
                                            </option>
                                        </optgroup>
                                        <option value="aston-martin">Aston Martin</option>
                                        <option value="hyundai">Hyundai</option>
                                        <option value="mitsubishi">Mitsubishi</option>
                                    </select>
                                </div>
                            </div> --}}
            </div>



            {{-- frameworks --}}
            <div class="card">
                <div class="card-body">
                    <div class=" row ">
                        <h4 class=" font-weight-bold">Company Details</h4>
                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Branch<span class="text-danger">*</span></label>
                            <select name="branch" id="" wire:model.live="branch" wire:model="branch" class=" form-control" wire:change="validateData">
                                <option value="">Select Branch Name</option>
                                @foreach ($Branch as $data)
                                <option value="{{ $data->branch_id }}">
                                    {{ $data->branch_name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-error-danger">
                                @error('branch')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Department<span class="text-danger">*</span></label>
                            <select name="department" wire:model.live="department" class=" form-control" wire:change="validateData" wire:model="department">
                                <option value="">
                                    Select Deparment Name</option>
                                @foreach ($Department as $data)
                                <option value="{{ $data->depart_id }}">
                                    {{ $data->depart_name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-error-danger">
                                @error('department')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>

                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Designation<span class="text-danger">*</span></label>
                            <select name="designation" class="form-control" wire:model.live="designation" wire:change="validateData" wire:model="designation">
                                <option value="">Select Designation Name</option>
                                @foreach ($Designation as $data)
                                <option value="{{ $data->desig_id }}">
                                    {{ $data->desig_name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-error-danger">
                                @error('designation')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>


                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Employee ID<span class="text-danger">*</span></label>
                            <input name="update_emp_id" id="emp_id_sd" type="text" wire:keyup="validateData" class=" form-control" wire:model="emp_id" placeholder="Employee ID Like: <?= $EmpID->model_id != null ? $EmpID->model_id : 'not create module' ?>" value="" readonly>
                            <span class="text-error-danger">
                                @error('emp_id')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Assign Attendance Method<span class="text-danger">*</span></label>
                            <select class="form-control custom-select" wire:model.live="attendance_method" wire:change="validateData" wire:model="attendance_method">
                                <option value="">Select Attendence
                                    Method
                                </option>
                                @foreach ($this->getAssignAttendanceMethod() as $assign_attendance)
                                <option value="{{ $assign_attendance->id }}">
                                    {{ $assign_attendance->method_name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-error-danger">
                                @error('attendance_method')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Assign Setup<span class="text-danger">*</span></label>
                            @php
                            $assignSetup = $this->getAssignSetup();
                            @endphp
                            @if ($assignSetup && count($assignSetup) > 0)
                            <select wire:model.live="master_endgame_id" class="form-control  custom-select" wire:change="validateData" wire:model="master_endgame_id">
                                <option value="">Select Shift Type</option>
                                @foreach ($assignSetup as $shiftsetSetup)
                                <option value="{{ $shiftsetSetup->id }}">
                                    {{ $shiftsetSetup->method_name }}
                                </option>
                                @endforeach
                            </select>
                            @else
                            <span>No Shift Settings Found</span>
                            @endif
                            <span class="text-error-danger">
                                @error('master_endgame_id')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-4" wire:ignore>
                            {{-- <span
                                            class="text-danger">*</span> --}}
                            <label class="form-label mb-0 mt-2">Reporting Manager
                            </label>
                            {{-- <input type="text" wire:keyup="validateData" class="form-control"
                                                    wire:model="report_manager">
                                                <span class="text-error-danger">
                                                    @error('report_manager')
                                                        {{ $message }}
                            @enderror
                            </span> --}}
                            <select wire:model='report_manager' wire:change="getReportingList" wire:keyup="validateData" placeholder="Select Employee" class=" form-control search_test">
                                <option selected value="">Select Reporting Manager</option>
                                @if (!empty($listMode))
                                @foreach ($listMode as $option)
                                <option value="{{ $option->emp_id }}">
                                    {{ $option->first_name . ' ' . $option->last_name }}
                                    | {{ $option->desig_name }}
                                </option>
                                @endforeach
                                @else
                                <div class="list-item">No Result</div>
                                @endif
                            </select>
                            <span class="text-error-danger">
                                @error('report_manager')
                                {{ $message }}
                                @enderror
                            </span>
                            {{-- @include('admin.pagelayout.globel.globeluse', [
                                                    'wiremodel' => 'fast',
                                                    'placeholder' => 'Hello  im from placeholder',
                                                    'class' => 'search_test',
                                                    'options' => $options,
                                                ]) --}}
                            {{-- additional add because remove after click in livewire this library set case on time --}}
                            <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.min.js') }}"></script>
                            <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.js') }}"></script>
                            <script>
                                $('.search_test').SumoSelect({
                                    search: true,
                                    searchText: 'Enter here.'
                                });
                            </script>


                        </div>


                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Assign Shift<span class="text-danger">*</span></label>
                            @php
                            $assignShiftType = $this->getAssignShiftType();
                            @endphp
                            @if ($assignShiftType && count($assignShiftType) > 0)

                            <select wire:model.live="emp_shift_type" wire:change="selectRotationalCheck" wire:model="emp_shift_type" class="form-control">
                                <option value="">Select Shift Type</option>
                                @foreach ($assignShiftType as $shiftset)
                                <option value="{{ $shiftset->id }}">
                                    {{ $shiftset->shift_type_name }}
                                </option>
                                @endforeach
                            </select>
                            @else
                            <span>No Assign Shift Found</span>
                            @endif
                            <span class="text-error-danger">
                                @error('emp_shift_type')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-4">
                            @if ($rotational_shift_active != 0)
                            @php
                            $assignRotationalShiftType = $this->getAssignRotationalShift();
                            @endphp
                            @if ($assignRotationalShiftType && count($assignRotationalShiftType) > 0)
                            <label class="form-label mb-0 mt-2">Select Rotational Type<span class="text-danger">*</span></label>

                            <select wire:model="select_rotation_type" wire:change="validateData" wire:model.live="select_rotation_type" class="form-control">
                                <option value="">Select Rotational Type</option>
                                @foreach ($assignRotationalShiftType as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->shift_name }}
                                </option>
                                @endforeach
                            </select>
                            @else
                            <span>No Rotational Found</span>
                            @endif
                            <span class="text-error-danger">
                                @error('select_rotation_type')
                                {{ $message }}
                                @enderror
                            </span>
                            @endif

                        </div>
                        <h4 class="pt-5 font-weight-bold">Communication Details</h4>

                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Country<span class="text-danger">*</span></label>
                            <select class="form-control w-100 border rounded" wire:model.live="country" wire:model="country" wire:change="validateData">
                                <option value="">Select Country</option>
                                @foreach ($this->country() as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}
                                </option>
                                @endforeach
                            </select>

                            <span class="text-error-danger">
                                @error('country')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">State<span class="text-danger">*</span></label>
                            <select class="form-control w-100 border rounded" wire:model="state" wire:model.live="state" wire:change="validateData">
                                <option value="">Select State</option>
                                @foreach ($this->state() as $phone)
                                <option value="{{ $phone->id }}">{{ $phone->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-error-danger">
                                @error('state')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">City<span class="text-danger">*</span></label>
                            <select wire:model.live="city" class="form-control w-100 border rounded" name="city" wire:model="city" wire:change="validateData">
                                <option value="">Select City</option>
                                @foreach ($this->city() as $cities)
                                <option value="{{ $cities->id }}">{{ $cities->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-error-danger">
                                @error('city')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Pin Code<span class="text-danger">*</span></label>
                            <input type="number" wire:keyup="validateData" class="update_pcode_sddd form-control" placeholder="Postal PIN" name="pin_code" wire:model="pin_code">
                            <span class="text-error-danger">
                                @error('pin_code')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label mb-0 mt-2">Address<span class="text-danger">*</span></label>
                            <textarea iid="address_sd" type="text" wire:model="address" wire:keyup="validateData" class="update_address_sddd form-control" placeholder="Address" name="update_address" cols="30" rows="2"></textarea>
                            <span class="text-error-danger">
                                @error('address')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-4 p-3">

                                <label class="custom-switch">
                                    Active &nbsp;
                                    <input type="checkbox" wire:model="isEnabled" class="custom-switch-input" <?= $isEnabled !== false ? 'checked' : '' ?>>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Enable/Disable</span>
                                </label>
                            </div>

                        </div>

                        {{-- <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="example-checkbox2"
                                            value="option2">
                                        <span class="custom-control-label">I agree terms &
                                            Conditions</span>
                                    </label> --}}
                    </div>
                </div>
            </div>
        </div>

        @endif

    </div>

    <div class="step-three">
        @if ($currentStep == 3)
        {{-- frameworks --}}
        <div class="card">
            <div class="card-body">

                <div class="form-group">

                    <h4 class="mb-2 font-weight-bold">Add Bank Details</h4>
                    <div class="row">

                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">IFSC Code
                            </label>
                            <input type="text" class="form-control" name="update_ifsc_code" placeholder="Enter Ifsc Code" wire:model="update_ifsc_code" wire:keyup="validateData">
                            <span class="text-error-danger">
                                @error('update_ifsc_code')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Bank Name</label>
                            <input type="text" class="form-control" name="update_bank_name" placeholder="Enter Bank Name" wire:model="update_bank_name" wire:keyup="validateData">
                            <span class="text-error-danger">
                                @error('update_bank_name')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Branch Name</label>
                            <input type="text" class="form-control" name="update_branch_name" placeholder="Enter Branch Name" wire:model="update_branch_name" wire:keyup="validateData">
                            <span class="text-error-danger">
                                @error('update_branch_name')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Branch Code</label>
                            <input type="text" class="form-control" name="update_branch_code" placeholder="Enter Branch Code" wire:model="update_branch_code" wire:keyup="validateData">
                            <span class="text-error-danger">
                                @error('update_branch_code')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Bank Account No.</label>
                            <input type="number" class="form-control" name="update_bank_accountno" placeholder="Enter Bank Account No." wire:model="update_bank_accountno" wire:keyup="validateData">
                            <span class="text-error-danger">
                                @error('update_bank_accountno')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">MICR Code</label>
                            <input type="number" class="form-control" name="update_micr_code" placeholder="Enter Micr Code" wire:model="update_micr_code" wire:keyup="validateData">
                            <span class="text-error-danger">
                                @error('update_micr_code')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label mb-0 mt-2">Address (Line 1)</label>
                            <textarea type="text" class="form-control" name="update_bank_address_line1" placeholder="Enter Address Line 1 without State,City & Pincode" wire:model="update_bank_address_line1" wire:keyup="validateData"></textarea>
                            <span class="text-error-danger">
                                @error('update_bank_address_line1')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label mb-0 mt-2">Address (Line 2)</label>
                            <textarea type="text" class="form-control" name="update_bank_address_line2" placeholder="Enter Address Line 2 without State,City & Pincode" wire:model="update_bank_address_line2" wire:keyup="validateData"></textarea>
                            <span class="text-error-danger">
                                @error('update_bank_address_line2')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                </div>
                <div class="form-group">

                    <h4 class="mb-2 font-weight-bold">Add Other Details</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label mb-0 mt-2">Grade Type</label>
                            <select wire:model="update_grade" wire:change="validateData" wire:model.live="update_grade" class="form-control">
                                <option value="">Select Grade Type</option>
                                @foreach ($this->getGradeList() as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->grade_name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-error-danger">
                                @error('update_grade')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>
                        {{-- <div class="col-md-4">
                                            <label class="form-label mb-0 mt-2">Grade<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="update_grade"
                                                placeholder="Enter Grade " wire:model="update_grade"
                                                wire:keyup="validateData">
                                            <span class="text-error-danger">
                                                @error('update_grade')
                                                    {{ $message }}
                        @enderror
                        </span>
                    </div> --}}

                    <div class="col-md-4">
                        <label class="form-label mb-0 mt-2">Budget Code</label>
                        <input type="number" class="form-control" name="update_budget_code" placeholder="Enter Budget Code" wire:model="update_budget_code" wire:keyup="validateData">
                        <span class="text-error-danger">
                            @error('update_budget_code')
                            {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label mb-0 mt-2">Account Code</label>
                        <input type="number" class="form-control" name="update_account_code" placeholder="Enter Account Code" wire:model="update_account_code" wire:keyup="validateData">
                        <span class="text-error-danger">
                            @error('update_account_code')
                            {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>


{{-- pt-2 pb-2 bg-white --}}
<div class="action-buttons d-flex justify-content-between   bg-white p-2 ">

    @if ($currentStep == 1)
    <div></div>
    <button type="button" class="btn btn-md btn-primary" wire:click="increaseStep()">Next</button>
    @endif
    @if ($currentStep == 2 || $currentStep == 3)
    <button type="button" class="btn btn-md btn-danger" wire:click="decreaseStep()">Back</button>
    @endif
    @if ($currentStep == 2)
    <button type="button" class="btn btn-md btn-primary" wire:click="increaseStep()">Next</button>
    @endif
    @if ($currentStep == 3)
    <button type="button" class="btn btn-md btn-primary" wire:click="increaseStep()" hidden>Next</button>
    @endif
    @if ($currentStep == 3)
    <button type="submit" class="btn btn-md btn-primary">Submit</button>
    @endif
</div>

</form>
</div>
</div>
</div>
</div>
<script>
    document.addEventListener("change", function(event) {
        if (event.target.classList.contains("uploadProfileInput")) {
            var triggerInput = event.target;
            var currentImg = triggerInput.closest(".pic-holder").querySelector(".pic")
                .src;
            var holder = triggerInput.closest(".pic-holder");
            var wrapper = triggerInput.closest(".profile-pic-wrapper");

            var alerts = wrapper.querySelectorAll('[role="alert"]');
            alerts.forEach(function(alert) {
                alert.remove();
            });

            triggerInput.blur();
            var files = triggerInput.files || [];
            if (!files.length || !window.FileReader) {
                return;
            }

            if (/^image/.test(files[0].type)) {
                var reader = new FileReader();
                reader.readAsDataURL(files[0]);

                reader.onloadend = function() {
                    holder.classList.add("uploadInProgress");
                    holder.querySelector(".pic").src = this.result;

                    var loader = document.createElement("div");
                    loader.classList.add("upload-loader");
                    loader.innerHTML =
                        '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>';
                    holder.appendChild(loader);

                    setTimeout(function() {
                        holder.classList.remove("uploadInProgress");
                        loader.remove();

                        var random = Math.random();
                        if (random < 0.9) {
                            wrapper.innerHTML +=
                                '<div class="snackbar show" role="alert"><i class="fa fa-check-circle text-success"></i> Profile image updated successfully</div>';
                            triggerInput.value = "";
                            setTimeout(function() {
                                wrapper.querySelector('[role="alert"]').remove();
                            }, 3000);
                        } else {
                            holder.querySelector(".pic").src = currentImg;
                            wrapper.innerHTML +=
                                '<div class="snackbar show" role="alert"><i class="fa fa-times-circle text-error-danger"></i> There is an error while uploading! Please try again later.</div>';
                            triggerInput.value = "";
                            setTimeout(function() {
                                wrapper.querySelector('[role="alert"]').remove();
                            }, 3000);
                        }
                    }, 1500);
                };
            } else {
                wrapper.innerHTML +=
                    '<div class="alert alert-danger d-inline-block p-2 small" role="alert">Please choose a valid image.</div>';
                setTimeout(function() {
                    var invalidAlert = wrapper.querySelector('[role="alert"]');
                    if (invalidAlert) {
                        invalidAlert.remove();
                    }
                }, 3000);
            }
        }
    });
</script>
{{-- <div wire:ignore.self class="modal fade" id="updateStudentModal" tabindex="-1"
    aria-labelledby="updateStudentModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"></button>
            </div>

            <form wire:submit.prevent="updateStudent">
                <div class="modal-body">

                    <img class="avatar avatar-md brround me-3 rounded-circle"
                        src="{{ asset('employee_profile/' . $profile_image) }}" alt="profile image">
<div class="mb-3">

    <label>Student Name</label>
    <input type="text" wire:model="business_id" class="form-control">
    <input type="text" wire:model="emp_id" class="form-control">

    <input type="text" wire:model="branch_id" class="form-control">

    @error('name') <span class="text-error-danger">{{ $message }}</span> @enderror
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Update</button>
</div>
</form>
</div>
</div>
</div> --}}

<!-- Delete Student Modal -->
<div wire:ignore.self class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStudentModalLabel">Delete Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="destroyStudent">
                <div class="modal-body">
                    <h4>Are you sure you want to delete this data ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Yes! Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {


        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.profile-pic').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $(".file-upload").on('change', function() {
            readURL(this);
        });

        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });
    });
</script>
