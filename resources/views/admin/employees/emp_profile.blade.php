@extends('admin.layout.master')
@section('title')
    <i class="fa fa-user mx-2"></i>Employee Profile
@endsection

@section('css')
    <style>
        .selected {
            background-color: #353a40;
            color: white;
        }
    </style>
@endsection

@section('contents')
    <div class="row">
        @php
            $Details = App\Helpers\Central_unit::EmployeeDetails()
                ->where('emp_id', $id)
                ->first();
            // dd($Details)
        @endphp
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2">
                        <img class="mx-auto d-block" src="{{ asset('imgs/user.png') }}" alt="">
                    </div>
                    <div class="col-xl-3">
                        <ul>
                            <li class="my-4"><span class="h1"><b>{{ $Details->emp_name }}</b></span>
                                <p><span class="fs-16" style="color: #97928e"><b>{{ $Details->designation_id }}</b></span></p>
                            </li>
                            <li class="my-5"><span class="fs-16"><b><i
                                            class="fa fa-briefcase mx-3"></i>Department:</b></span><span
                                    class="fs-16 mx-2">{{ $Details->department_id }}</span></li>
                            <li class="my-5"><span class="fs-16"><b><i class="fa fa-briefcase mx-3"></i>Emp
                                        ID:</b></span><span class="fs-16 mx-2">{{ $Details->emp_id }}</span></li>
                            <li class="my-5"><span class="fs-16"><b><i class="fa fa-calendar mx-3"></i>Date of
                                        Joining:</b></span><span
                                    class="fs-16 mx-2">{{ $Details->emp_date_of_joining }}</span>
                            </li>
                            <li class="my-5"><span class="fs-16"><b><i class="fa fa-envelope mx-3"></i>Reports
                                        to:</b></span><span class="fs-16 mx-2"><span class="avatar avatar-sm brround mx-2"
                                        style="background-image: url(assets/images/users/15.jpg)"></span>Dilip Sahu</span>
                            </li>
                            <li class="btn btn-outline-primary"><a
                                    href="mailto:{{ $Details->emp_email }}?subject = Feedback&body = Message">
                                    Send Mail
                                </a></li>

                        </ul>
                    </div>
                    <div class="col-xl-7 bl">
                        <ul class="ps-4" style="border-left:dashed 2px #97928e;">
                            <li class="my-5"><span class="fs-16"><b><i
                                            class="fa fa-phone mx-3"></i>Phone:</b></span><span class="fs-16 mx-2">+91
                                    {{ $Details->emp_mobile_number }}</span></li>
                            <li class="my-5"><span class="fs-16"><b><i
                                            class="fa fa-envelope mx-3"></i>Email:</b></span><span
                                    class="fs-16 mx-2">{{ $Details->emp_email }}</span></li>
                            <li class="my-5"><span class="fs-16"><b><i class="fa fa-calendar mx-3"></i>Date of
                                        Birth:</b></span><span class="fs-16 mx-2">{{ $Details->emp_date_of_birth }}</span>
                            </li>
                            <li class="my-5"><span class="fs-16"><b><i
                                            class="fa fa-street-view mx-3"></i>Gender:</b></span><span class="fs-16 mx-2">
                                    @if ($Details->emp_gender == 1)
                                        Male
                                    @endif
                                    @if ($Details->emp_gender == 2)
                                        Female
                                    @endif
                                    @if ($Details->emp_gender == 3)
                                        Other
                                    @endif
                                </span></li>
                            <li class="my-5"><span class="fs-16"><b><i
                                            class="fa fa-address-card mx-3"></i>Address:</b></span><span
                                    class="fs-16 mx-2">{{ $Details->emp_address , }}{{ $Details->emp_city , }}{{ $Details->emp_state ,}}{{ $Details->emp_country }},{{ $Details->emp_pin_code }}</span>
                            </li>
                        </ul>
                    </div>
                    {{-- @dd($Details); --}}
                </div>
            </div>
        </div>
    </div>

    <div class="page-header d-sm-flex d-block">
        <div class="page-leftheader">
            <div class="page-title"><i class="fa fa-bank mx-2"></i>Bank Acount Details<span
                    class="font-weight-normal text-muted ms-2"></span></div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-flex">
                </div>
                <div class="d-lg-flex d-block">
                    <div class="btn-list my-auto">
                        <h6 class="btn btn-outline-primary border-0 btn-sm"><i class="fa fa-edit"></i>Edit</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mx-3">
                            <div class="card-body">
                                <ul class="pe-4" style="border-right:dashed 2px #97928e;">
                                    <li class="my-5"><span class="fs-24"><b>Bank Details</b></span></li>
                                    <li class="my-5"><span class="fs-16"><b>A/c Holder Name:</b></span><span
                                            class="fs-16 mx-2">Aman Sahu</span></li>
                                    <li class="my-5"><span class="fs-16"><b>A/c Number:</b></span><span
                                            class="fs-16 mx-2">XXXX XXXX XX18</span></li>
                                    <li class="my-5"><span class="fs-16"><b>IFSC Number:</b></span><span
                                            class="fs-16 mx-2">INDBI0005466</span></li>
                                    <li class="my-5"><span class="fs-16"><b>Bank Name:</b></span><span
                                            class="fs-16 mx-2">Indus Bank</span></li>
                                    <li class="my-5"><span class="fs-16"><b>Branch:</b></span><span
                                            class="fs-16 mx-2">Shankar Nagar, Raipur</span></li>
                                    <li class="my-5"><span class="fs-16"><b>Address:</b></span><span
                                            class="fs-16 mx-2">Ring
                                            Road No. - 2 Opposite Dixit Doers, Gondwara, Bilaspur
                                            Rd, Bhanpuri, Raipur, Chhattisgarh 492001</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mx-3">
                            <div class="card-body">
                                <ul>
                                    <li class="my-5"><span class="fs-24"><b>UPI Details</b></span></li>
                                    <li class="my-5"><span class="fs-16"><b>UPI Holder Name:</b></span><span
                                            class="fs-16 mx-2">Aman Sahu</span></li>
                                    <li class="my-5"><span class="fs-16"><b>UPI ID:</b></span><span
                                            class="fs-16 mx-2">83XXXXXX66@ybl</span></li>
                                    <li class="my-5"><span class="fs-16"><b>Phone:</b></span><span
                                            class="fs-16 mx-2">8319151766</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-header d-sm-flex d-block">
        <div class="page-leftheader">
            <div class="page-title"><i class="fa fa-file-text mx-2"></i>Summary<span
                    class="font-weight-normal text-muted ms-2"></span></div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-flex">
                </div>
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <h6></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row text-center">
                    <div id="selected_btn1" class="col-xl-3 btn btn-outline-dark selected">
                        <h4 class="mt-3"><i class="fa fa-file-text mx-2"></i>Summary</h4>
                    </div>
                    <a href="{{ url('/employee-attendance') }}" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-user me-2"></i>Attendance</h4>
                    </a>
                    <div id="selected_btn3" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-inr me-2"></i>Payment</h4>
                    </div>
                    <a id="selected_btn4" class="modal-effect col-xl-3 btn btn-outline-dark text-dark"
                        data-bs-toggle="modal" data-bs-target="#salarySlip">
                        <h4 class="mt-3"><i class="fa fa-file me-2"></i>Salary Slip</h4>
                    </a>
                    <div id="selected_btn5" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-hourglass me-2"></i>Overtime</h4>
                    </div>
                    <div id="selected_btn6" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-truck me-2"></i>Allowance Bonus</h4>
                    </div>
                    <div id="selected_btn7" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-scissors me-2"></i>Deduction</h4>
                    </div>
                    <div id="selected_btn8" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-taxi me-2"></i>Leaves</h4>
                    </div>
                </div>
            </div>
            <div class="card-header border-0">
                <h4 class="title"><i class="fa fa-chevron-right"></i>Augest 2023</h4>
                <div class="page-rightheader ms-md-auto">
                    <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                        <div class="btn-list d-flex">
                            <a class="modal-effect btn btn-outline-primary btn-sm" data-effect="effect-scale"
                                data-bs-toggle="modal" href="#empType">Add Payment</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row my-3">
                    <div class="col-xl-3 my-auto">
                        <h4 class="my-auto">Augest Net Salary</h4>
                    </div>
                    <div class="col-xl-3 my-auto">
                        <p class="my-auto" style="color::rgb(34, 33, 29)"><i class="fa fa-calendar mx-2"></i>Aug 1 - Aug
                            4</p>
                    </div>
                    <div class="col-xl-6 my-auto">
                        <p class="my-auto" style="color:rgb(63, 61, 55)"><b><i class="fa fa-inr mx-2"></i>1200</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-header d-sm-flex d-block">
        <div class="page-leftheader">
            <div class="page-title"><i class="fa fa-cogs mx-2"></i>Employee Setting<span
                    class="font-weight-normal text-muted ms-2"></span></div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-flex">
                </div>
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <h6></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 my-auto">
                        <h5 class="my-auto">Shift Hour</h5>
                    </div>
                    <div class="col-xl-6 my-auto">
                        <p class="my-auto text-muted" style="color:rgb(34, 33, 29)">08:00</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 my-auto">
                        <h5 class="my-auto">Staff Weekly Holiday</h5>
                    </div>
                    <div class="col-xl-6 my-auto">
                        <p class="my-auto text-muted" style="color:rgb(34, 33, 29)">Sunday</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 my-auto">
                        <h5 class="my-auto">Holiday Policy</h5>
                    </div>
                    <div class="col-xl-6 my-auto">
                        <p class="my-auto text-muted" style="color:rgb(34, 33, 29)">FY 23-24</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 my-auto">
                        <h5 class="my-auto">Leave Policy</h5>
                    </div>
                    <div class="col-xl-6 my-auto">
                        <p class="my-auto text-muted" style="color:rgb(34, 33, 29)">FD_Leave Policy</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 my-auto">
                        <h5 class="my-auto">Salary Cycle</h5>
                    </div>
                    <div class="col-xl-6 my-auto">
                        <p class="my-auto text-muted" style="color:rgb(34, 33, 29)">1 to 1 Even Month</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 my-auto">
                        <h5 class="my-auto">Salary Structure Details</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 p-3 m-3 border">
                        <div class="row">
                            <div class="col-xl-9">
                                <p><b>Earnings</b></p>
                            </div>
                            <div class="col-xl-3">
                                <p><b><i class="fa fa-inr mx-1"></i>4/Mo</b></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-9">
                                <p>Basic + DA</p>
                            </div>
                            <div class="col-xl-3">
                                <p><i class="fa fa-inr mx-1"></i>1</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-9">
                                <p>HRA</p>
                            </div>
                            <div class="col-xl-3">
                                <p><i class="fa fa-inr mx-1"></i>1</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-9">
                                <p>Medical Allowance</p>
                            </div>
                            <div class="col-xl-3">
                                <p><i class="fa fa-inr mx-1"></i>1</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-9">
                                <p>Special Allowance</p>
                            </div>
                            <div class="col-xl-3">
                                <p><i class="fa fa-inr mx-1"></i>1</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 p-3 m-3 border">
                        <div class="row">
                            <div class="col-xl-9">
                                <p><b>Deductions</b></p>
                            </div>
                            <div class="col-xl-3">
                                <p><b><i class="fa fa-inr mx-1"></i>1/Mo</b></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-9">
                                <p>Employee State Insurance(ESI)</p>
                            </div>
                            <div class="col-xl-3">
                                <p><i class="fa fa-inr mx-1"></i>1</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 p-3 m-3 border">
                        <div class="row">
                            <div class="col-xl-9">
                                <p><b>Contributions</b></p>
                            </div>
                            <div class="col-xl-3">
                                <p><b><i class="fa fa-inr mx-1"></i>1/Mo</b></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-9">
                                <p>Employee State Insurance(ESI)</p>
                            </div>
                            <div class="col-xl-3">
                                <p><i class="fa fa-inr mx-1"></i>1</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-header d-sm-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Others<span class="font-weight-normal text-muted ms-2"></span></div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-flex">
                </div>
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <h6></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 my-auto">
                        <p class="my-auto" style="color:rgb(34, 33, 29)"><b>Self
                                Attendance</b>
                        </p>
                    </div>
                    <div class="col-xl-4 my-auto">
                        <p class="my-auto fs-14 text-muted" style="color:rgb(34, 33, 29)">Allowing Self Attendance</p>
                    </div>
                    <div class="col-xl-2 my-auto">
                        <label class="custom-switch ">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 my-auto">
                        <p class="my-auto" style="color:rgb(34, 33, 29)"><b>Delete Employee</b>
                        </p>
                    </div>
                    <div class="col-xl-4 my-auto">
                        <p class="my-auto fs-14 text-muted" style="color:rgb(34, 33, 29)">Parmanent Delete Employee</p>
                    </div>
                    <div class="col-xl-2 my-auto">
                        <a href="#" class="btn btn-outline-danger btn-sm">Delete</a>
                    </div>
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
