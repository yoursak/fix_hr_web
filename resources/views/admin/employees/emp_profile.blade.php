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

    {{-- @foreach ($DATA as $item)
        @php
            $centralUnit = new App\Helpers\Central_unit();
            $branch = $centralUnit::Branchget($item->branch_id);
            $depart = $centralUnit::Departmentget($item->department_id);
        @endphp --}}
    {{-- <div class=""> --}}

        {{-- @dd($DATA); --}}

    <div class=" p-0 pb-4">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>

            <li class="active"><span><b>Employee Profile</b></span></li>
        </ol>
    </div>
    <div class="card">
        {{-- <div class="row"> --}}
        <div class="row">
            <div class="col-md-2 my-md-5">
                <div class="widget-user-image mt-5 text-center">
                    <span class="avatar avatar-md brround me-3 rounded-circle"
                        style="height: 100px; width: 100px; background-image: url('/employee_profile/{{ $DATA->profile_photo ?? '' }}')"></span>
                </div>

            </div>
            <div class="col-md-4 my-md-5">
                <ul class="ps-5">

                    <li class="my-4"><span class="h1"><b></b></span>

                        <p><span class="fs-16" style="color: #97928e"><b></b></span></p>
                    </li>
                    <li class="my-5"><span
                            class="fs-16"><b>{{ $DATA->emp_name ?? '' }}&nbsp;{{ $DATA->emp_mname ?? '' }}&nbsp;{{ $DATA->emp_lname ?? '' }}</b></span><span
                            class="fs-16 mx-2"></span></li>
                    <li class="my-5"><span class="fs-16">{{ $DATA->desig_name ?? '' }}</span><span class="fs-16 mx-2"></span>
                    </li>
                    <li class="my-5"><span class="fs-16"><b>Employee ID :
                                {{ $DATA->emp_id ?? '' }}</b></span><span class="fs-16 mx-2"></span></li>
                    <li class="my-5"><span class="fs-16">Date of Joining :
                            {{ $DATA->emp_date_of_joining ?? '' }}</span><span class="fs-16 mx-2"></span></li>

                </ul>
            </div>
            <div class="col-md-4 my-md-5">
                {{-- <ul class="ps-4" style="border-left:dashed 2px #97928e;"> --}}
                <ul class="ps-5" style="">
                    {{-- <i class="fa fa-phone mx-3"></i> --}}
                    <li class="my-5"><span class="fs-16"><b>Phone:</b></span><span class="fs-16 mx-2">+91
                            {{ $DATA->emp_mobile_number ?? '' }}
                        </span></li>

                    {{-- <i class="fa fa-envelope mx-3"></i> --}}
                    <li class="my-5"><span class="fs-16"><b>Email:</b></span><span class="fs-16 mx-2">
                            {{ $DATA->emp_email ?? '' }}
                        </span></li>
                    {{-- <i class="fa fa-calendar mx-3"></i> --}}
                    <li class="my-5"><span class="fs-16"><b>Date of

                                Birth:</b></span><span class="fs-16 mx-2">{{ $DATA->emp_date_of_birth ?? '' }}</span>
                    </li>
                    {{-- <i class="fa fa-street-view mx-3"></i> --}}
                    <li class="my-5"><span class="fs-16"><b>Gender:</b></span><span class="fs-16 mx-2">
                            @if (($DATA->emp_gender ?? 0) == 1)
                                Male
                            @endif
                            @if (($DATA->emp_gender ?? 0) == 2)
                                Female
                            @endif
                            @if (($DATA->emp_gender ?? 0) == 3)
                                Other
                            @endif
                        </span></li>
                    <li class="my-5"><span class="fs-16"><b>Address:</b></span><span
                            class="fs-16 mx-2">{{ $DATA->emp_address ?? '' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xl-6"">
            <div class="card">
                <div class="card-body ms-xl-5">
                    <ul class="pe-4" style="">
                        {{-- <ul class="pe-4" style="border-right:dashed 2px #97928e;"> --}}
                        <li class="my-5"><span class="fs-24"><b>Residential Information</b></span></li>
                        <li class="my-5"><span class="fs-16"><b>Country:</b></span><span class="fs-16 mx-2">
                                @if (($DATA->emp_country ?? 0) == 1)
                                    India
                                @endif
                                @if (($DATA->emp_country ?? 0) == 2)
                                    USA
                                @endif
                            </span></li>
                        <li class="my-5"><span class="fs-16"><b>State:</b></span><span class="fs-16 mx-2"
                            onload="print_state($DATA->emp_state)" id="printState">Chhattishgarh</span></li>
                        <li class="my-5"><span class="fs-16"><b>City:</b></span><span
                                class="fs-16 mx-2" onload="print_city($DATA->emp_city,$DATA->emp_state)" id="printCity">Raipur</span></li>
                        <li class="my-5"><span class="fs-16"><b>Zip Code:</b></span><span
                                class="fs-16 mx-2">{{ $DATA->emp_pin_code ?? '' }}</span></li>
                        <li class="my-5"><span class="fs-16"><b>Address:</b></span><span
                                class="fs-16 mx-2">{{ $DATA->emp_address ?? '' }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body ms-xl-5">
                    <ul>
                        <li class="my-5"><span class="fs-24"><b>Company Information</b></span></li>
                        <li class="my-5"><span class="fs-16"><b>Branch:</b></span><span
                                class="fs-16 mx-2">{{ $DATA->branch_name ?? ' ' }}</span></li>
                        <li class="my-5"><span class="fs-16"><b>Department:</b></span><span
                                class="fs-16 mx-2">{{ $DATA->depart_name ?? '' }}</span></li>
                        <li class="my-5"><span class="fs-16"><b>Designation:</b></span><span
                                class="fs-16 mx-2">{{ $DATA->desig_name ?? '' }}</span></li>
                        <li class="my-5"><span class="fs-16"><b>Shift Type:</b></span><span
                                class="fs-16 mx-2">{{ $DATA->shift_type_name ?? '' ?? 'Not Allotted' }}</span></li>
                        <li class="my-5"><span class="fs-16"><b>Attendance Method:</b></span><span
                                class="fs-16 mx-2">{{ $DATA->method_name ?? '' }}</span></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    </div>

    {{-- Employee Salary Slip --}}
    <div class="modal fade" id="salarySlip">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header py-3">
                    <h5>Download Salary slip</h5>
                </div>
                <div class="modal-body d-flex justify-content-around mt-3">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <select name="month" class="form-control btn-outline-dark btn-sm"
                                data-placeholder="Select Month" style="width: 18rem">
                                <option label="Select Month"></option>
                                <option value="1">January 2023</option>
                                <option value="2">February 2023</option>
                                <option value="3">March 2023</option>
                                <option value="4">April 2023</option>
                                <option value="5">May 2023</option>
                                <option value="6">June 2023</option>
                                <option value="7">July 2023</option>
                                <option value="8">August 2023</option>
                                <option value="9">September 2023</option>
                                <option value="10">October 2023</option>
                                <option value="11">November 2023</option>
                                <option value="12">December 2023</option>
                            </select>
                        </div>
                        <div class="col-sm d-flex justify-content-center my-5">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio111">
                                <label class="btn btn-outline-primary" for="btnradio111" style="width: 9rem">Full
                                    Slip</label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio333">
                                <label class="btn btn-outline-primary" for="btnradio333"
                                    style="width: 9rem">Summary</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-evenly my-2">
                                <a href="#" class="btn btn-sm btn-primary px-4"><i
                                        class="fa fa-mail-forward me-2"></i>Share</a>
                                <a href="#" class="btn btn-sm btn-primary"><i
                                        class="fa fa-download me-2"></i>Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
