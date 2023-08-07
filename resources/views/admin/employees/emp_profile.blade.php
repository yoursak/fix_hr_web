@extends('admin.layout.master')
@section('title')
    <i class="fa fa-user mx-2"></i>Employee Profile
@endsection


@section('css')
<style>
    .selected{
        background-color: #353a40;
        color: white;
    }
</style>
@endsection

@section('contents')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 ">
                        <img class="mx-auto d-block" src="{{ asset('imgs/user.png') }}" alt="">
                    </div>
                    <div class="col-xl-9">
                        <div class="card mx-3">
                            <div class="card-body">
                                <ul>
                                    <li class="my-5"><span class="fs-16"><b><i class="fa fa-user mx-3"></i>Name:</b></span><span class="fs-16 mx-2">Aman
                                            Sahu</span></li>
                                    <li class="my-5"><span class="fs-16"><b><i class="fa fa-briefcase mx-3"></i>Designation:</b></span><span
                                            class="fs-16 mx-2">Software Developer</span></li>
                                    <li class="my-5"><span class="fs-16"><b><i class="fa fa-calendar mx-3"></i>Date of Birth:</b></span><span
                                            class="fs-16 mx-2">July 07, 2000</span></li>
                                    <li class="my-5"><span class="fs-16"><b><i class="fa fa-phone mx-3"></i>Phone:</b></span><span class="fs-16 mx-2">+91
                                            8319151766</span></li>
                                    <li class="my-5"><span class="fs-16"><b><i class="fa fa-envelope mx-3"></i>Email:</b></span><span
                                            class="fs-16 mx-2">amansahu.er@gmail.com</span></li>
                                    <li class="my-5"><span class="fs-16"><b><i class="fa fa-address-card mx-3"></i>Address:</b></span><span
                                            class="fs-16 mx-2">Ring Road No. - 2 Opposite Dixit Doers, Gondwara, Bilaspur
                                            Rd, Bhanpuri, Raipur, Chhattisgarh 492001</span></li>
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
            <div class="page-title"><i class="fa fa-bank mx-2"></i>Bank Details<span
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
                    <div class="col-xl-12">
                        <div class="card mx-3">
                            <div class="card-body">
                                <ul>
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
                                            class="fs-16 mx-2">Ring Road No. - 2 Opposite Dixit Doers, Gondwara, Bilaspur
                                            Rd, Bhanpuri, Raipur, Chhattisgarh 492001</span></li>
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
                    <div id="selected_btn2" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-user mx-1"></i>Attendance</h4>
                    </div>
                    <div id="selected_btn3" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-inr mx-1"></i>Payment</h4>
                    </div>
                    <div id="selected_btn4" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-file mx-1"></i>Pay Slip</h4>
                    </div>
                    <div id="selected_btn5" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-hourglass mx-1"></i>Overtime</h4>
                    </div>
                    <div id="selected_btn6" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-truck mx-1"></i>Allowance Bonus</h4>
                    </div>
                    <div id="selected_btn7" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-dollar mx-1"></i>Deduction</h4>
                    </div>
                    <div id="selected_btn8" class="col-xl-3 btn btn-outline-dark">
                        <h4 class="mt-3"><i class="fa fa-taxi mx-1"></i>Leaves</h4>
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
@endsection
