@extends('admin.layout.master')
@section('title')
Employee Summary
@endsection

@section('contents')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header border-bottom-0">
                <h3 class="card-title">Payment Information</h3>
            </div>
            <div class="card-body">
                <div class="card-pay">
                    <ul class="tabs-menu nav">
                        <li><a href="#tab21" data-bs-toggle="tab" class="active"> Payment</a></li>
                        <li><a href="#tab22" data-bs-toggle="tab" class="">Attendance</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab21">
                            <div class="card">
                                <div class="card-header border-bottom-0">
                                    <h4 class="card-title">Non Weekly Staff</h4>
                                    <div class="page-rightheader ms-auto">
                                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                            <div class="btn-list d-flex">
                                                <div>
                                                    <button class="btn btn-outline-primary mx-3 border-0" href="#">Download</button>
                                                </div>
                                                <div class="my-auto">
                                                    <select name="month" class="form-control btn-outline-dark border-0 mx-3 " data-placeholder="Select Cycle">
                                                        <option label="Select Cycle"></option>
                                                        <option value="1">January</option>
                                                        <option value="2">February</option>
                                                        <option value="3">March</option>
                                                        <option value="4">April</option>
                                                        <option value="5">May</option>
                                                        <option value="6">June</option>
                                                        <option value="7">July</option>
                                                        <option value="8">August</option>
                                                        <option value="9">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 my-auto">
                                            <h5 class="my-auto">Aman Sahu</h5>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Monthly Regular Staff | Information Technology</p>
                                        </div>
                                        <div class="col-xl-2 col-md-3 my-auto">
                                            <h6 class="my-auto">Rs 0</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Aug 2023 Net Pay</p>
                                        </div>
                                        <div class="col-xl-2 col-md-3 my-auto">
                                            <h6 class="my-auto">Rs 0</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Aug 2023 Salary(Actual)</p>
                                        </div>
                                        <div class="col-xl-2 col-md-3 my-auto">
                                            <h6 class="my-auto">Rs 0</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Aug 2023 Payments</p>
                                        </div>
                                        <div class="col-xl-2 col-md-3 my-auto">
                                            <h6 class="my-auto">Rs 0</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Adjustment</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab22">
                            <div class="card">
                                <div class="card-header border-bottom-0">
                                    <div class="page-rightheader ms-auto">
                                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                            <div class="btn-list d-flex">
                                                <div>
                                                    <button class="btn btn-outline-primary mx-3 border-0" href="#">Download</button>
                                                </div>
                                                <div class="my-auto">
                                                    <select name="month" class="form-control btn-outline-dark border-0 mx-3 " data-placeholder="Select Cycle">
                                                        <option label="Select Cycle"></option>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="my-auto">
                                            <h5 class="my-auto">Aman Sahu</h5>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Monthly Regular Staff | Information Technology</p>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-sm-4 col-md-3 col-xl-1 my-auto text-center">
                                            <h6 class="my-auto">-</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Present</p>
                                        </div>
                                        <div class=" col-sm-4 col-md-3 col-xl-1 my-auto text-center">
                                            <h6 class="my-auto">-</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Absent</p>
                                        </div>
                                        <div class=" col-sm-4 col-md-3 col-xl-1 my-auto text-center">
                                            <h6 class="my-auto">-</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Half Day</p>
                                        </div>
                                        <div class=" col-sm-4 col-md-3 col-xl-1 my-auto text-center">
                                            <h6 class="my-auto">-</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Overtime</p>
                                        </div>
                                        <div class=" col-sm-4 col-md-3 col-xl-1 my-auto text-center">
                                            <h6 class="my-auto">-</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">fine</p>
                                        </div>
                                        <div class=" col-sm-4 col-md-3 col-xl-1 my-auto text-center">
                                            <h6 class="my-auto">-</h6>
                                            <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Paid Leave</p>
                                        </div>
                                        <div class=" col-sm-4 col-md-3 col-xl-2 my-auto text-center">
                                            <h6 class="my-auto"><b>1</b></h6>
                                            <p class="my-auto fs-13 text-muted" style="color:rgb(34, 33, 29)"><b>Not Marked</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

