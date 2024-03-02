{{-- <?php dd($DATA->updated_at_emp); ?> --}}
@extends('admin.pagelayout.master')
<script src="{{ asset('assets/js/cities.js?v=2.34') }}"></script>

@section('title')
    Employee Profile
@endsection

@section('css')
    <style>
        .selected {
            background-color: #353a40;
            color: white;
        }
        .employee_o {
            display: inline-block;
            font-weight: 10;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            line-height: 1.84615385;
            font-size: 14px;
            padding: 0.1rem 0.20rem;
            letter-spacing: 0.4px;
            border-radius: 5px;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        /* .image_o {
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
            } */
    </style>
@endsection

@section('content')
    @php
        $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        $Employee = $centralUnit->EmployeeDetails();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
    @endphp

    <div class=" p-0 pb-4">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>

            <li class="active"><span><b>Employee Profile</b></span></li>
        </ol>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row content-left">
                    <div class="col-md-2" >
                        <div class="widget-user-image text-center mt-5">
                            <span class="avatar avatar-md brround me-3 rounded-circle"
                            style="height: 100px; width: 100px; background-image: url('/storage/livewire_employee_profile/{{ $DATA->profile_photo ?? '' }}')"></span>
                            {{-- <a class="btn btn-primary mt-2 employee_o" data-bs-target="#modaldemo101" data-bs-toggle="modal" href="#">Update Employ image</a> --}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="pe-3">
                            <li class="my-4"><span class="h1"><b></b></span>
                                <p><span class="fs-16" style="color: #97928e"><b></b></span></p>
                            </li>
                            <li class="my-3"><span
                                    class="fs-16"><b>{{ $DATA->emp_name ?? '' }}&nbsp;{{ $DATA->emp_mname ?? '' }}&nbsp;{{ $DATA->emp_lname ?? '' }}</b></span><span
                                    class="fs-16 mx-2"></span></li>
                            <li class="my-3"><span class="fs-16"><b>Employee ID :-</b>{{ $DATA->emp_id ?? '' }}</span><span
                                    class="fs-16 mx-2"></span></li>
                            <li class="my-3"><span class="fs-16"><b>Date of Joining
                                        :-</b>{{ $DATA->emp_date_of_joining ?? '' }}</span><span class="fs-16 mx-2"></span></li>
                            <li class="my-3"><span class="fs-16"><b>Grade :-
                                    </b>{{ $DATA->grade_list->grade_name ?? '' }}</span><span class="fs-16 mx-2"></span></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="pe-3" style="">
                            <li class="my-3"><span class="fs-16"><b>Phone No.:-</b></span><span
                                    class="fs-16 ">+91{{ $DATA->emp_mobile_number ?? '' }}</span></li>
                            <li class="my-3"><span class="fs-16"><b>Email ID:-</b></span><span class="fs-16 ">
                                    {{ $DATA->emp_email ?? '' }}</span></li>
                            <li class="my-3"><span class="fs-16"><b>Date of Birth:-</b></span><span
                                    class="fs-16 ">{{ $DATA->emp_date_of_birth ?? '' }}</span></li>
                            <li class="my-3"><span class="fs-16"><b>Gender:-</b></span><span class="fs-16 ">
                                    @if (($DATA->emp_gender ?? 0) == 1)
                                        Male
                                    @endif
                                    @if (($DATA->emp_gender ?? 0) == 2)
                                        Female
                                    @endif
                                    @if (($DATA->emp_gender ?? 0) == 3)
                                        Other
                                    @endif
                                </span>
                            </li>
                            <li class="my-3">
                                <span class="fs-11 fw-bold with-effect-from-badge_wef">W.E.F. </span><span class="with-effect-from-badge_emp">{{date('d-M-Y h:i A',strtotime($DATA->updated_at_emp))}}</span>
                                {{-- <span class=""><b>W.E.F :- </b></span><span class="mx-2" style="text-color:yello">{{ $DATA->updated_at_emp ?? '' }}</span> --}}
                            </li>
                            {{-- <li class="my-3"><span class="fs-16"><b>Address:-</b></span><span
                                    class="fs-16 ">{{ $DATA->emp_address ?? '' }}</span>
                            </li> --}}
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <div class=" d-flex justify-content-end">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#modaldemo1"  class="btn btn-primary btn-icon btn-sm ">
                                <i class="feather feather-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class=" card">
                <div class="card-body ms-xl-5">
                    <div class="d-flex justify-content-between">
                        <span class="fs-24 content-left"><b>Residential Information</b></span>
                        <samp>
                            <button type="button" class="btn btn-primary btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#modaldemo2">
                                <i class="feather feather-edit" data-bs-toggle="tooltip" title="Edit"></i>
                            </button>
                        </samp>
                    </div>
                    <ul class="pe-4">
                        <li class="my-3"><span class="fs-16"><b>Country:- </b></span><span class="fs-16 mx-2">
                                <?= $DATA->CountyName ?>
                            </span></li>
                        <li class="my-3"><span class="fs-16"><b>State:- </b></span><span class="fs-16 mx-2">
                                <?= $DATA->StateName ?>
                            </span></li>
                        <li class="my-3"><span class="fs-16"><b>City:- </b></span> <span class="fs-16 mx-2">
                                <?= $DATA->CityName ?>
                            </span></li>
                        <li class="my-3"><span class="fs-16"><b>Zip Code:- </b></span><span
                                class="fs-16 mx-2">{{ $DATA->emp_pin_code ?? '' }}</span></li>
                        <li ><span class="fs-16"><b>Address:- </b></span><span
                                class="fs-16 mx-2">{{ $DATA->emp_address ?? '' }}</span></li>
                        <li class="my-3">
                            <span class="fs-11 fw-bold with-effect-from-badge_wef">W.E.F. </span><span class="with-effect-from-badge_emp">{{date('d-M-Y h:i A',strtotime($DATA->updated_at_reside))}}</span>
                            {{-- <span class=""><b>W.E.F :- </b></span><span class="mx-2" style="text-color:yello">{{ $DATA->updated_at_emp ?? '' }}</span> --}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body ms-xl-5">
                        <div class="d-flex justify-content-between">
                            <span class="fs-24 content-left"><b>Company Information</b></span>
                            <samp>
                                <button type="button" class="btn btn-primary btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#modaldemo3">
                                    <i class="feather feather-edit" data-bs-toggle="tooltip" title="Edit"></i>
                                </button>
                            </samp>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <ul>
                                    <li class="my-3"><span class="fs-16"><b>Assign Setup:- </b></span><span
                                            class="fs-16 mx-2">{{ $DATA->setup_name ?? '' }}</span></li>
                                    <li class="my-3"><span class="fs-16"><b>Branch:- </b></span><span
                                            class="fs-16 mx-2">{{ $DATA->branch_name ?? ' ' }}</span></li>
                                    <li class="my-3"><span class="fs-16"><b>Department:- </b></span><span
                                            class="fs-16 mx-2">{{ $DATA->depart_name ?? '' }}</span></li>
                                    <li class="my-3"><span class="fs-16"><b>Designation:- </b></span><span
                                            class="fs-16 mx-2">{{ $DATA->desig_name ?? '' }}</span></li>
                                    <li class=""><span class="fs-16"><b>Shift Type:- </b></span><span
                                            class="fs-16 mx-2">{{ $DATA->shift_type_name ?? ('' ?? 'Not Allotted') }}</span></li>
                                    <li class="my-3">
                                        <span class="fs-11 fw-bold with-effect-from-badge_wef">W.E.F. </span><span class="with-effect-from-badge_emp">{{date('d-M-Y h:i A',strtotime($DATA->updated_at_comp))}}</span>
                                        {{-- <span class=""><b>W.E.F :- </b></span><span class="mx-2" style="text-color:yello">{{ $DATA->updated_at_emp ?? '' }}</span> --}}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul>
                                    <li class="my-3"><span class="fs-16"><b>Attendance Method:- </b></span><span
                                            class="fs-16 mx-2">{{ $DATA->method_name ?? '' }}</span></li>
                                </ul>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body ms-xl-5">
                    <div class="d-flex justify-content-between">
                        <span class="fs-24 content-left"><b>Bank Details</b></span>
                        <samp>
                            <button type="button" class="btn btn-primary btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#modaldema4">
                                <i class="feather feather-edit" data-bs-toggle="tooltip" title="Edit"></i>
                            </button>
                        </samp>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <ul>
                                <li class="my-3"><span class="fs-16"><b>A/c Number:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->bank_account_no ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>Bank Name:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->bank_name ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>Branch Name:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->bank_branch_name ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>Account Code:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->account_code ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>IFSC Code:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->bank_ifsc_code ?? 'N/A' }}</span></li>
                                </div>
                            </ul>
                        <div class="col-6">
                            <ul>
                                <li class="my-3"><span class="fs-16"><b>Branch Code:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->bank_branch_code ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>MICR Code:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->bank_micr_code ?? ('N/A' ?? 'Not Allotted') }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>Address Line 1:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->bank_address_line1 ?? 'N/A' }}</span></li>
                                <li class=""><span class="fs-16"><b>Address Line 2:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->bank_address_line2 ?? 'N/A' }}</span></li>
                                <li class="my-3">
                                    <span class="fs-11 fw-bold with-effect-from-badge_wef">W.E.F. </span><span class="with-effect-from-badge_emp">{{date('d-M-Y h:i A',strtotime($DATA->updated_at_bank))}}</span>
                                    {{-- <span class=""><b>W.E.F :- </b></span><span class="mx-2" style="text-color:yello">{{ $DATA->updated_at_emp ?? '' }}</span> --}}
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body ms-xl-5">
                    <div class="d-flex justify-content-between">
                        <span class="fs-24 content-left"><b>Account Information</b></span>
                        <samp>
                            <button type="button" class="btn btn-primary btn-icon btn-sm" id="modal_eligibal" data-bs-toggle="modal" data-bs-target="#modaldemo102">
                                <i class="feather feather-edit" data-bs-toggle="tooltip" title="Edit"></i>
                            </button>
                        </samp>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <ul>
                                <li class="my-3"><span class="fs-16"><b>Government Id:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->emp_gov_select_id ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>Id Number:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->emp_gov_select_id_number ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>PF Eligible:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->pf_eligible_one ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>PF Joining Date:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->pf_joining_no ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>PF Number:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->pf_no ?? 'N/A' }}</span></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul>
                                <li class="my-3"><span class="fs-16"><b>EPS Eligible:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->eps_eligible_one ?? 'N/A' }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>EPS Joining Date:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->eps_joining_no ?? 'N/A' }}</span></li>
                                {{-- <li class="my-3"><span class="fs-16"><b>EPS Exit Date:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->eps_exit_data ?? 'N/A' }}</span></li> --}}
                                <li class="my-3"><span class="fs-16"><b>LWF Eligible:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->hps_eligible_three ?? ('N/A' ?? 'Not Allotted') }}</span></li>
                                <li class="my-3"><span class="fs-16"><b>EPS Number:-</b></span><span
                                        class="fs-16 mx-2">{{$DATA->eps_no ?? ''}}</span></li>
                                {{-- <li class=""><span class="fs-16"><b>HPS Elegible:-</b></span><span
                                        class="fs-16 mx-2">{{ $DATA->hps_eligible ?? 'N/A' }}</span></li> --}}
                                <li class="my-3">
                                    <span class="fs-11 fw-bold with-effect-from-badge_wef">W.E.F. </span><span class="with-effect-from-badge_emp">{{date('d-M-Y h:i A',strtotime($DATA->updated_at_account))}}</span>
                                    {{-- <span class=""><b>W.E.F :- </b></span><span class="mx-2" style="text-color:yello">{{ $DATA->updated_at_emp ?? '' }}</span> --}}
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body ms-xl-5">
                    <div class="d-flex justify-content-between">
                        <span class="fs-24 content-left"><b>Family Information</b></span>
                        <samp>
                            <button type="button" class="btn btn-primary btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#modaldemo103">
                                <i class="feather feather-edit" data-bs-toggle="tooltip" title="Edit"></i>
                            </button>
                        </samp>
                    </div>
                    <ul>
                        <li class="my-3"><span class="fs-16"><b>Family Name:-</b></span><span
                                class="fs-16 mx-2">{{ $DATA->family_name ?? 'N/A' }}</span></li>
                        <li class="my-3"><span class="fs-16"><b>Relationship:-</b></span><span
                                class="fs-16 mx-2">{{ $DATA->relationship ?? 'N/A' }}</span></li>
                        <li class="my-3"><span class="fs-16"><b>Date of Birth:-</b></span><span
                                class="fs-16 mx-2">{{ $DATA->relative_date_of_birth ?? 'N/A' }}</span></li>
                        <li class=""><span class="fs-16"><b>Relative Phone:-</b></span><span
                                class="fs-16 mx-2">{{ $DATA->relative_phone_no ?? 'N/A' }}</span></li>
                        <li class="my-3">
                            <span class="fs-11 fw-bold with-effect-from-badge_wef">W.E.F. </span><span class="with-effect-from-badge_emp">{{date('d-M-Y h:i A',strtotime($DATA->updated_at_fanily))}}</span>
                            {{-- <span class=""><b>W.E.F :- </b></span><span class="mx-2" style="text-color:yello">{{ $DATA->updated_at_emp ?? '' }}</span> --}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
        <!-- MODAL Image -->
        <div class="modal fade"  id="modaldemo101" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center " role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <button aria-label="Close" class="btn-close pt-2" data-bs-dismiss="modal" ><span aria-hidden="true">x</span></button>
                    </div>
                    <form method="POST" action="{{url('admin/employee/update/profile')}}">
                        @csrf
                        <input type="hidden" name="hidden_id" value="{{$DATA->employ_id}}">
                        <input type="hidden" name="data_update" value="image">
                            <div class="modal-body text-left">
                                <input type="file" name="update_image" id="">
                            </div>
                        {{-- </div> --}}
                        <div class="modal-footer">
                            <a class="btn btn-danger cancel" type="reset" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary savebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END MODAL Image -->
        <!-- MODAL Account Bank Information -->
        <div class="modal fade"  id="modaldemo102" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-left " role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Account Information</h6><button aria-label="Close" class="btn-close pt-2" data-bs-dismiss="modal" ><span aria-hidden="true">x</span></button>
                    </div>
                    <form method="POST" action="{{url('admin/employee/update/profile')}}">
                        @csrf
                        <input type="hidden" name="hidden_id" value="{{$DATA->employ_id}}">
                        <input type="hidden" name="data_update" value="employee_bank">
                            <div class="modal-body text-left">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Government Id<span class="text-danger mb-0">*</span></label>
                                        {{-- <input type="text" class="form-control" name="pan_no_aadar_no" placeholder="PAN Number" value="{{$DATA->pan_no_aadar_no}}"> --}}
                                        <select name="emp_gov_select_id"  class="form-control">
                                            @foreach ($staticGovId as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == ( $DATA->emp_gov_select_id ?? null) ? 'selected' : '' }}>
                                                    {{ $item->govt_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                            <label  class="form-label mb-0 mt-2">Id Number<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="emp_gov_select_id_number" placeholder="Id Number" value="{{$DATA->emp_gov_select_id_number ?? ''}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                            <label class="form-label mb-0 mt-2">PF Eligible<span class="text-danger">*</span></label>
                                            <select name="pf_eligible"  class="form-control" id="eligible_id" onchange="eligible_new_(this)">
                                                <option value=""> Select PF Eligible </option>
                                                @foreach ($eligible_id as $item)
                                                    <option value="{{ $item->eligible_id }}" {{ $item->eligible_id == ($DATA->pf_eligible ?? null) ? 'selected' : '' }}>
                                                        {{ $item->eligible }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">PF Joining Date<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="pf_joining_no" id="pf_joining_no" placeholder="PF Joining Date" value="{{$DATA->pf_joining_no ?? ''}}" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2" >PF Numner<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="pf_no" id="pf_no" placeholder="PF Numner" value="{{$DATA->pf_no ?? ''}}" >
                                    </div>
                                </div>
                                {{-- <br> --}}
                                {{-- <div style="display: inline-block;">
                                    <legend style="color:#7366ff; font-size:19px; font-weight:bold;">Add</legend>
                                    <legend style="color:#7366ff;font-size:15px;">(Extended Warranty if exist or applicable)</legend>
                                </div> --}}
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">EPS Eligible<span class="text-danger">*</span></label>
                                        {{-- <input type="text" class="form-control" name="eps_eligible" placeholder="EPS Eligible" value="{{$DATA->eps_eligible ?? ''}}"> --}}
                                        <select name="eps_eligible"  class="form-control" id="eligible_id_second" onchange="eligible_id_third(this)">
                                            <option value=""> Select EPS Eligible </option>
                                            @foreach ($eligible_id as $item)
                                                <option value="{{ $item->eligible_id }}" {{ $item->eligible_id == ( $DATA->eps_eligible ?? null) ? 'selected' : '' }}>
                                                    {{ $item->eligible }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">EPS Joining Date<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="eps_joining_no" id="eps_joining_no" placeholder="EPS Joining Date" value="{{$DATA->eps_joining_no ?? ''}}" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">EPS Number<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="eps_no" id="eps_no" placeholder="EPS Eligible" value="{{$DATA->eps_no ?? ''}}" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">LWF Eligible<span class="text-danger">*</span></label>
                                        {{-- <input type="text" class="form-control" name="lwf_eligible" placeholder="LWF Eligible" value="{{$DATA->lwf_eligible ?? ''}}"> --}}
                                        <select name="lwf_eligible"  class="form-control" id="eligible_id_second">
                                            <option value=""> Select LWF Eligible </option>
                                            @foreach ($eligible_id as $item)
                                                <option value="{{ $item->eligible_id }}" {{ $item->eligible_id == ( $DATA->lwf_eligible ?? null) ? 'selected' : '' }}>
                                                    {{ $item->eligible }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                </div> --}}
                            </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger cancel" type="reset" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary savebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END MODAL Employee Bank Information -->
        <!-- MODAL Family Information -->
        <div class="modal fade"  id="modaldemo103" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-left " role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Family Information</h6><button aria-label="Close" class="btn-close pt-2" data-bs-dismiss="modal" ><span aria-hidden="true">x</span></button>
                    </div>
                    <form method="POST" action="{{url('admin/employee/update/profile')}}">
                        @csrf
                        <input type="hidden" name="hidden_id" value="{{$DATA->employ_id}}">
                        <input type="hidden" name="data_update" value="Family">
                            <div class="modal-body text-left">
                                <div class="row">
                                    <div class="col-6">
                                            <label  class="form-label mb-0 mt-2">Family Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="family_name" placeholder="Family Name" value="{{$DATA->family_name}}">
                                    </div>
                                    <div class="col-6">
                                            <label  class="form-label mb-0 mt-2">Relationship<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="relationship" placeholder="Relationship" value="{{$DATA->relationship}}">
                                    </div>
                                    <div class="col-6">
                                            <label  class="form-label mb-0 mt-2">Date of Birth<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="relative_date_of_birth" placeholder="Date of Birth" value="{{$DATA->relative_date_of_birth}}">
                                    </div>
                                    <div class="col-6">
                                            <label  class="form-label mb-0 mt-2">Relative Phone<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="relative_phone_no"  placeholder="Relative Phone" value="{{$DATA->relative_phone_no}}">
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger cancel" type="reset" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary savebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END MODAL Family Information -->

    {{-- working modal --}}
        <div class="modal fade" id="modaldema4" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Bank Details</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                    </div>
                    <form method="POST" action="{{url('admin/employee/update/profile')}}">
                        @csrf
                        <input type="hidden" name="hidden_id" value="{{$DATA->employ_id}}">
                        <input type="hidden" name="data_update" value="Bank">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Bank Account No.<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="update_bank_accountno" value="{{ $DATA->bank_account_no ?? 'N/A' }}" placeholder="Enter Bank Account No.">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Bank Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="update_bank_name" value="{{ $DATA->bank_name ?? 'N/A' }}" placeholder="Enter Bank Name" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Branch Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="update_branch_name" value="{{ $DATA->bank_branch_name ?? 'N/A' }}" placeholder="Enter Branch Name" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Account Code<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="update_account_code" value="{{ $DATA->account_code ?? 'N/A' }}" placeholder="Enter Branch Name" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">IFSC Code<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="update_ifsc_code" value="{{ $DATA->bank_ifsc_code ?? 'N/A' }}" placeholder="Enter Ifsc Code" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Branch Code<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="update_branch_code" value="{{ $DATA->bank_branch_code ?? 'N/A' }}" placeholder="Enter Branch Code" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">MICR Code<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="update_micr_code" value="{{ $DATA->bank_micr_code ?? ('N/A' ?? 'Not Allotted') }}" placeholder="Enter Micr Code"  >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Address (Line 1)<span class="text-danger">*</span></label>
                                        <textarea type="text" class="form-control" name="update_bank_address_line1" placeholder="Enter Address Line 1 without State,City &amp; Pincode" >{{ $DATA->bank_address_line1 ?? 'N/A' }}</textarea>
                                        <span class="text-error-danger"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Address (Line 2)<span class="text-danger">*</span></label>
                                        <textarea type="text" class="form-control" name="update_bank_address_line2" placeholder="Enter Address Line 2 without State,City &amp; Pincode">{{ $DATA->bank_address_line2 ?? 'N/A' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger cancel" type="reset" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary savebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modaldemo1"  data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Empolyee Details</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                    </div>
                    <form method="POST" action="{{url('admin/employee/update/profile')}}">
                        @csrf
                        <input type="hidden" name="hidden_id" value="{{$DATA->employ_id}}">
                        <input type="hidden" name="data_update" value="Employee">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">First Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ $DATA->emp_name ?? '' }}" name="update_name" placeholder="Enter first name" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Middle Name</label>
                                        <input id="" type="text" class="form-control " value="{{ $DATA->emp_mname ?? '' }}" placeholder="Middle Name" name="middle_name" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Last
                                            Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ $DATA->emp_lname ?? '' }}" placeholder="Enter last name" name="last_name" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Employee ID<span class="text-danger">*</span></label>
                                        <input name="update_emp_id" id="emp_id_sd" value="{{ $DATA->emp_id ?? '' }}" type="text"  class=" form-control" placeholder="Employee ID Like: IT001"  readonly="">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Date Of Joining<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control " value="{{ $DATA->emp_date_of_joining ?? '' }}" id="doj_sd" placeholder="DD-MM-YYYY" name="update_doj">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Grade Type</label>
                                        <select name="update_grade"  class="form-control">
                                            @foreach ($grade_list as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == ($DATA['grade_list']['id'] ?? null) ? 'selected' : '' }}>
                                                    {{ $item->grade_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Contact Number<span class="text-danger">*</span></label>
                                        <input id="number_sd" type="number"  class="update_cnumber_sddd form-control" value="{{ $DATA->emp_mobile_number ?? '' }}" placeholder="Enter 10-digit phone number" name="update_mobile_number" maxlength="10" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Email ID<span class="text-danger">*</span></label>
                                        <input name="udpate_email" type="email" value="{{ $DATA->emp_email ?? '' }}" class="form-control"  placeholder="email" id="email_sd" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Date Of Birth<span class="text-danger">*</span></label>
                                        <input type="date" value="{{ $DATA->emp_date_of_birth ?? '' }}" class="form-control" placeholder="DD-MM-YYY"  name="dob" id="dateofbirth_sd" name="update_dob" wire:mode="dob">
                                        <span class="text-error-danger">  </span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-0 mt-2">Gender<span class="text-danger">*</span></label>
                                        <select class="form-control " aria-label="Type" id="" name="update_gender">
                                            <option value="">Select Gender</option>
                                            @foreach ($gender_id as $gender_item)
                                                <option value="{{ $gender_item->id}}" {{ $gender_item->id ==  $DATA->emp_gender ? 'selected' : '' }} >{{ $gender_item->gender_type}} </option>
                                            @endforeach
                                        {{-- @if (($DATA->emp_gender ?? 0) == 1)
                                            <option value="1"> Male</option>
                                        @endif
                                        @if (($DATA->emp_gender ?? 0) == 2)
                                        <option value="2">Female</option>
                                        @endif
                                        @if (($DATA->emp_gender ?? 0) == 3)
                                        <option value="3">Other</option>
                                        @endif --}}
                                        </select>
                                        <span class="text-error-danger"></span>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label mb-0 mt-2">Address<span class="text-danger">*</span></label>
                                        <textarea type="text" value="{{ $DATA->emp_address ?? '' }}" class="form-control" placeholder="Address" name="update_address" cols="30" rows="2">{{ $DATA->emp_address ?? '' }}</textarea>
                                        <span class="text-error-danger"> </span>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger cancel" type="reset" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary savebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <div class="modal fade" id="modaldemo2"  data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Residential Information</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                    </div>
                    <form method="POST" action="{{url('admin/employee/update/profile')}}">
                        @csrf
                        <input type="hidden" name="hidden_id" value="{{$DATA->employ_id}}">
                        <input type="hidden" name="data_update" value="Residential">
                            <div class="modal-body">
                                <div class="row p-4 m-0">
                                    <div class="col-12 -md-4">
                                        <label class="form-label mb-0 mt-2">Country<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-lg select2"  name="country" onchange="getState(this)">
                                            <option value="">Select State</option>
                                            @foreach ($country_list as $contry_item)
                                           <option value="{{ $contry_item->id}}" {{ $contry_item->id ==  $DATA->emp_country ? 'selected' : '' }} >{{ $contry_item->name}} </option>
                                           @endforeach
                                        </select>

                                    </div>
                                    <div class="col-12-md-4">
                                        <label class="form-label mb-0 mt-2">State<span class="text-danger" >*</span></label>
                                        <select class="form-control" name="state" id="getStateId" onchange="getCity(this)" >
                                            <option value="">Select State</option>
                                            @foreach ($state_list as $state_item)
                                            <option value="{{ $state_item->id}}" {{ $state_item->id ==  $DATA->emp_state ? 'selected' : '' }} >{{ $state_item->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 md-4">
                                        <label class="form-label mb-0 mt-2">City<span class="text-danger" >*</span></label>
                                        <select  class="form-control" name="city" id="getCityId">
                                            <option value="">Select City</option>
                                            @foreach ($city_list as $city_item)
                                            <option value="{{ $city_item->id}}" {{ $city_item->id ==  $DATA->emp_city ? 'selected' : '' }} >{{ $city_item->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 -md-4">
                                        <label class="form-label mb-0 mt-2">Pin Code<span class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control" placeholder="Postal PIN"  value="{{ $DATA->emp_pin_code ?? '' }}"name="pin_code">
                                    </div>
                                    <div class="col-12 -md-8">
                                        <label class="form-label mb-0 mt-2">Address<span class="text-danger">*</span></label>
                                        <textarea iid="address_sd" type="text"
                                            class="form-control" placeholder="Address" name="update_address" cols="30"
                                            rows="2">{{ $DATA->emp_address ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger cancel" type="reset" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary savebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade"  id="modaldemo3" data-bs-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Company Information</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" ><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{url('admin/employee/update/profile')}}">
                            @csrf
                            <input type="hidden" name="hidden_id" value="{{$DATA->employ_id}}">
                            <input type="hidden" name="data_update" value="Company">
                            <div class="modal-body">
                                <div class="row">
                                    <h4 class="font-weight-bold">Company Details</h4>
                                    <div class="col-12 -md-4">
                                        <label class="form-label">Assign Setup<span class="text-danger">*</span></label>
                                        <select class="form-control" name="master_endgame_id" >
                                            <option value="">Select Shift Type</option>
                                            @foreach ($policy_master_list as $policy_item)
                                            <option value="{{ $policy_item->id}}" {{ $policy_item->id ==  $DATA->set_id ? 'selected' : '' }} >{{ $policy_item->method_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 -md-4">
                                        <label class="form-label mb-0 mt-2">Branch<span class="text-danger">*</span></label>
                                        <select  class="form-control" name="branch">
                                            @foreach ($branch_list as $branch_item)
                                                <option value="{{ $branch_item->branch_id}}" {{ $branch_item->branch_id ==  $DATA->branch_id ? 'selected' : '' }} >{{ $branch_item->branch_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 -md-4">
                                        <label class="form-label mb-0 mt-2">Department<span class="text-danger">*</span></label>
                                        <select class="form-control" name="department" >
                                            @foreach ($department_list as $department_item)
                                                <option value="{{ $department_item->depart_id }}" {{ $department_item->depart_id ==  $DATA->depart_id ? 'selected' : '' }} >{{ $department_item->depart_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 -md-4">
                                        <label class="form-label mb-0 mt-2">Designation<span class="text-danger">*</span></label>
                                        <select class="form-control" name="designation" >
                                            @foreach ($designation_list as $designation_item)
                                                <option value="{{ $designation_item->desig_id  }}" {{ $designation_item->desig_id  ==  $DATA->desig_id  ? 'selected' : '' }} >{{ $designation_item->desig_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 -md-4">
                                        <label class="form-label mb-0 mt-2">Shift Type<span class="text-danger">*</span></label>
                                        <select class="form-control" name="emp_shift_type">
                                            @foreach ($policy_list as $policy_item)
                                                <option value="{{ $policy_item->id  }}" {{ $policy_item->id  ==  $DATA->shift_id ? 'selected' : '' }} >{{ $policy_item->shift_type_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 -md-4">
                                        <label class="form-label mb-0 mt-2">Assign Attendance Method<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control custom-select" name="attendance_method">
                                            @foreach ($attendance_list as $attendance_item)
                                                <option value="{{ $attendance_item->id}}" {{ $attendance_item->id  ==  $DATA->method_id ? 'selected' : '' }} >{{ $attendance_item->method_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-danger cancel" type="reset" data-bs-dismiss="modal">Cancel</a>
                                    <button type="submit" class="btn btn-primary savebtn">Update</button>
                                </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script>
                // stare
                function getState(countryValue) {
                    console.log('countryValue,',countryValue.value);
                    let country = countryValue.value;
                    // $('#getStateId').empty();
                    // $('#getCityId').empty();
                    // $('#district_one').empty();
                    $stateId = $('#getStateId');
                    $.ajax({
                        url: "{{ route('getCityStateCountry') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            state: null,
                            country: country
                        },
                        dataType: 'json',
                        cache: true,
                        success: function(result) {
                            var state = result.states;

                            $stateId.html('');

                            var defaultOption = $('<option>').val('').text('Select State').attr('selected', true);
                            $stateId.append(defaultOption);
                            // $stateId.append(

                            state.forEach(function(element) {
                                var option = $('<option>').val(element.id).text(element.name);
                                $stateId.append(option);
                            });
                            // Set the selected state after populating options
                            // $stateId.val(stateValue);
                        }
                    });
                }
            //end state

            //start city
            function getCity(stateValue) {
                // console.log('Hello');
                let city_one = stateValue.value;
                $cityId = $('#getCityId');
                $.ajax({
                    url: "{{ route('getCityStateCountry') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        state: city_one
                    },
                    dataType: 'json',
                    cache: true,
                    success: function(result) {
                        var city = result.city;
                        var defaultOptioncity = $('<option>').val('').text('Select City').attr('selected', true);
                        $cityId.html('');
                        $cityId.append(defaultOptioncity);

                        city.forEach(function(element) {
                            var option = $('<option>').val(element.id).text(element.name);
                            $cityId.append(option);
                        });

                        // console.log('city:'.city);
                        // $('#getStateId').val(stateValue);
                        // $('#getCityId').val(CityID);
                    }
                });

            }
            //End City
            </script>
            <script>
                    function eligible_new_(val) {  // PF
                        console.log('aaaya no ',val.value);
                        if (val.value == 1) {
                            document.getElementById('pf_joining_no').disabled = false;
                            document.getElementById('pf_no').disabled = false;
                        } else {
                            document.getElementById('pf_joining_no').disabled = true;
                            document.getElementById('pf_no').disabled = true;
                            document.getElementById('pf_joining_no').value = '';
                            document.getElementById('pf_no').value = '';
                        }
                    }
                function eligible_id_third(val){  //EPS Eligible
                    console.log(val);
                    if(val.value == 1){
                        document.getElementById('eps_joining_no').disabled = false;
                        document.getElementById('eps_no').disabled = false;
                    }else{
                        document.getElementById('eps_joining_no').disabled = true;
                        document.getElementById('eps_no').disabled = true;
                        document.getElementById('eps_joining_no').value = '';
                        document.getElementById('eps_no').value = '';
                    }
                }
            </script>
            <script>

                // $(document).ready(function(){
                    var data_pf = {{$DATA->pf_eligible}};
                    var data_eps = {{$DATA->eps_eligible}};
                    console.log('data_pf',data_pf,'data_eps',data_eps);
                    if( data_pf == 1 ){
                        document.getElementById('pf_joining_no').disabled = false;
                        document.getElementById('pf_no').disabled = false;
                    }else{
                        document.getElementById('pf_joining_no').disabled = true;
                        document.getElementById('pf_no').disabled = true;
                    }
                    if( data_eps == 1){
                        document.getElementById('eps_joining_no').disabled = false;
                        document.getElementById('eps_no').disabled = false;
                    }else{
                        document.getElementById('eps_joining_no').disabled = true;
                        document.getElementById('eps_no').disabled = true;
                    }

                // });
                // jq.click


            </script>
    @endsection
