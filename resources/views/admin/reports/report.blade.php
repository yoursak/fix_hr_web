@extends('admin.layout.master')
@section('title')
    Report
@endsection

@section('css')
    <style>
        .rotate {
            transition: 500ms;
            transform: rotate(90deg);
            /* Adjust the desired rotation value */
        }

        .bg-inf {
            background-color: #a3d5dd;
            /* Change to your desired color */
        }
    </style>
@endsection
@if (in_array('Report.View', $permissions))
@section('contents')
    @php
        $root = new App\Helpers\Central_unit();
        $Department = $root->DepartmentList();
        $Branch = $root->BranchList();
        $Employee = $root->EmployeeDetails();
        $EmpID = $root->EmpPlaceHolder();
        $Designation = $root->DesignationList();
        $LOADED = new App\Helpers\MasterRulesManagement\RulesManagement();
        $ITEM = $LOADED->SectionEmployeeCounters();
    @endphp
    <div class="row">
        <div class="card" id="repoerCard1">
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-11 my-auto">
                        <h4 class="my-auto"><b>Monthly Attendance Reports</b></h4>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Attendance Report, Daily Attendance Report, Leave Balance Report and Attendance Summary Report,
                            Muster Roll Report
                        </p>
                    </div>
                    <div class="col-1 my-auto text-end">
                        <i class="fe fe-chevron-right fs-30 btn " id="reportBtn1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="contentCard1">
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Muster Roll Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Monthly view of day wise attendance details of all Employees.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        {{-- <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn"><i
                                class="fa fa-file-pdf-o me-2"></i>PDF</button> --}}
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#export1" id="newTempFormBtn"><i
                                class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Daily Attendance Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daily view of day wise attendance details of all Employees.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        {{-- <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn"><i
                                class="fa fa-file-pdf-o me-2"></i>PDF</button> --}}
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#export2" id="newTempFormBtn2"><i
                                class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Individual Employee Attendance Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Monthly view of day wise attendance details of individual Employee.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        {{-- <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn"><i
                                class="fa fa-file-pdf-o me-2"></i>PDF</button> --}}
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#export3" id="newTempFormBtn3"><i
                                class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Individual Employee AR Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            AR correction report of a individual Employee.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#export4" id="newTempFormBtn4"><i
                                class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card" id="repoerCard3">
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-11 my-auto">
                        <h4 class="my-auto"><b>Leave Report</b></h4>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Work Report, Staff Details Report, Daily Work Entry Report.
                        </p>
                    </div>
                    <div class="col-1 my-auto text-end">
                        <i class="fe fe-chevron-right fs-30 btn " id="reportBtn3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="contentCard3">
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Leave Balance Muster Roll Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Leave Muster Roll Report For All Employee.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#leaveExportMusterRoll" id="newTempFormBtn"><i
                                class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <!-- <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Leave Balance Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level Summary for individual attendance cycle
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#LeaveMusterRoll" id="newTempFormBtn"><i
                                class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Compensatory  Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level Overtime report as per goverment norms
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn"><i
                                class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn"><i
                                class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Leave Monthly Availed Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daywise attendance Summary, individual attendance view and punch logs
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn"><i
                                class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn"><i
                                class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Leave Availed detail Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn"><i
                                class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Pending Leave Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn"><i
                                class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    {{-- Temprarly Commented By Aman Sahu (Do not remove) --}}
    {{-- <div class="row">
        <div class="card" id="repoerCard2">
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-11 my-auto">
                        <h4 class="my-auto"><b>Complience Reports</b></h4>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            PF, ESL, LWF, and PT Report
                        </p>
                    </div>
                    <div class="col-1 my-auto text-end">
                        <i class="fe fe-chevron-right fs-30 btn " id="reportBtn2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="contentCard2">
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">ESI Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level Summary for individual attendance cycle
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>

                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">LWF Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level Overtime report as per goverment norms
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">PF Compliance Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daywise attendance Summary, individual attendance view and punch logs
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">PF Excel Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">PT Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Monthly view of day wise attendance , fine, OT, elc. of all Staff
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Temprarly Commented By Aman Sahu (Do not remove) --}}
    {{-- <div class="row">
        <div class="card" id="repoerCard4">
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-11 my-auto">
                        <h4 class="my-auto"><b>Payrolls Reports</b></h4>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Payroll Report, Fine Report, Loan Summary report, Allowence Report,
                        </p>
                    </div>
                    <div class="col-1 my-auto text-end">
                        <i class="fe fe-chevron-right fs-30 btn " id="reportBtn4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="contentCard4">
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Allowance Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level Summary for individual attendance cycle
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>

                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Bonus Reoprt</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level Overtime report as per goverment norms
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Bulk Salary Slip</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daywise attendance Summary, individual attendance view and punch logs
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Genrate Report</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Deduction Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Loan Summary Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level Summary for individual attendance cycle
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>

                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Payment Logs Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level Overtime report as per goverment norms
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">RTGS Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daywise attendance Summary, individual attendance view and punch logs
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Staff Fine Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Staff Payroll Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Level view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-pdf-o me-2"></i>PDF</button>
                        <button type="button" class="btn btn-outline-dark my-2" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Excel</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class=" text-end">
        {{-- <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Save</a> --}}
    </div>
    <form action="{{ route('export.LeaveMusterRoll', ['id' => 1]) }}" method="post">
        @csrf
        <div class="modal fade" id="LeaveMusterRoll" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Leave Report Muster Roll Report</h6><button aria-label="Close"
                            class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true"
                                type="reset">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <h6>Download muster roll report for a month</h6>
                        <div class="row text-start">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="form-label">Branch</p>
                                    <select name='branch_id' id="country-dd" class="form-control"
                                        data-nodays='{{ date('t') }}' data-modays='{{ date('d') }}'
                                        data-currentMonth='{{ date('m') }}' data-currentYear='{{ date('Y') }}'>
                                        <option value="" selected>All Branches</option>
                                        @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="form-label">Date</p>

                                    <div class="form-group mb-3">
                                        <input type="date" name="date" id="">
                                        {{-- <select name="month" id="monthFilter" class="form-control " required>
                                            <option value="">Select Month</option>
                                            @for ($month = 1; $month <= 12; $month++)
                                                <option value="{{ $month }}"
                                                    {{ $month == date('m') ? 'Selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endfor
                                        </select> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-6"> --}}
                            {{-- <div class="form-group">
                                    <p class="form-label">Year</p>
                                    <div class="form-group mb-3">
                                        <select name="year" id="yearFilter" class="form-control " required>
                                            <option value="">Select Year</option>
                                            @for ($year = date('Y'); $year >= date('Y') - 20; $year--)
                                                <option value="{{ $year }}"
                                                    {{ $year == date('Y') ? 'Selected' : '' }}>{{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div> --}}
                            {{-- </div> --}}
                            <div class="col-12">
                                <div class="form-group ">
                                    <div class="form-label">Document Formate</div>
                                    <div class="custom-controls-stacked d-flex">
                                        {{-- <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export"
                                                value="1" checked>
                                            <span class="custom-control-label"><b>PDF</b></span>
                                        </label> --}}
                                        <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export"
                                                value="2">
                                            <span class="custom-control-label"><b>Excel</b></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Export</button>
                        <button class="btn btn-light" data-bs-dismiss="modal" type="reset">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('export.LeaveMusterRollReport') }}" method="post">
        @csrf
        <div class="modal fade" id="leaveExportMusterRoll" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Employee Muster Roll Report</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true" type="reset">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <h6>Download muster roll report for a month</h6>
                        <div class="row text-start">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="form-label">Branch</p>
                                    <select name='branch_id' id="country-dd" class="form-control"
                                        data-nodays='{{ date('t') }}' data-modays='{{ date('d') }}'
                                        data-currentMonth='{{ date('m') }}' data-currentYear='{{ date('Y') }}'>
                                        <option value="">All Branches</option>
                                        @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="form-label">Month</p>
                                    <div class="form-group mb-3">
                                        <select name="month" id="monthFilter" class="form-control " required>
                                            <option value="">Select Month</option>
                                            @for ($month = 1; $month <= 12; $month++)
                                                <option value="{{ $month }}"
                                                    {{ $month == date('m') ? 'Selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <p class="form-label">Year</p>
                                    <div class="form-group mb-3">
                                        <select name="year" id="yearFilter" class="form-control " required>
                                            <option value="">Select Year</option>
                                            @for ($year = date('Y'); $year >= date('Y') - 20; $year--)
                                                <option value="{{ $year }}"
                                                    {{ $year == date('Y') ? 'Selected' : '' }}>{{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <div class="form-label">Document Formate</div>
                                    <div class="custom-controls-stacked d-flex">
                                        {{-- <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="1" checked>
                                            <span class="custom-control-label"><b>PDF</b></span>
                                        </label> --}}
                                        <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="2">
                                            <span class="custom-control-label"><b>Excel</b></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Export</button>
                        <button class="btn btn-light" data-bs-dismiss="modal" type="reset">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('export.AttendanceMusterRoll') }}" method="post">
        @csrf
        <div class="modal fade" id="export1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Muster Roll Report</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true" type="reset">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <h6>Download muster roll report for a month</h6>
                        <div class="row text-start">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="form-label">Branch</p>
                                    <select name='branch_id' id="country-dd" class="form-control"
                                        data-nodays='{{ date('t') }}' data-modays='{{ date('d') }}'
                                        data-currentMonth='{{ date('m') }}' data-currentYear='{{ date('Y') }}'>
                                        <option value="">All Branches</option>
                                        @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="form-label">Month</p>
                                    <div class="form-group mb-3">
                                        <select name="month" id="monthFilter" class="form-control " required>
                                            <option value="">Select Month</option>
                                            @for ($month = 1; $month <= 12; $month++)
                                                <option value="{{ $month }}"
                                                    {{ $month == date('m') ? 'Selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <p class="form-label">Year</p>
                                    <div class="form-group mb-3">
                                        <select name="year" id="yearFilter" class="form-control " required>
                                            <option value="">Select Year</option>
                                            @for ($year = date('Y'); $year >= date('Y') - 20; $year--)
                                                <option value="{{ $year }}"
                                                    {{ $year == date('Y') ? 'Selected' : '' }}>{{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <div class="form-label">Document Formate</div>
                                    <div class="custom-controls-stacked d-flex">
                                        {{-- <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="1" checked>
                                            <span class="custom-control-label"><b>PDF</b></span>
                                        </label> --}}
                                        <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="2">
                                            <span class="custom-control-label"><b>Excel</b></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Export</button>
                        <button class="btn btn-light" data-bs-dismiss="modal" type="reset">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('export.DailyAttendanceReport') }}" method="post">
        @csrf
        <div class="modal fade" id="export2" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Daily Attendance Report</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true" type='reset'>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <h6>Download daily attendance report</h6>
                        <div class="row text-start">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="form-label">Branch</p>
                                    <select name='branch_id' id="country-dd" class="form-control"
                                        data-nodays='{{ date('t') }}' data-modays='{{ date('d') }}'
                                        data-currentMonth='{{ date('m') }}' data-currentYear='{{ date('Y') }}'>
                                        <option value="">All Branches</option>
                                        @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Date</p>
                                    <div class="form-group mb-3">
                                        <input class="form-control " placeholder="" type="date" value=""
                                            name="date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <div class="form-label">Document Formate</div>
                                    <div class="custom-controls-stacked d-flex">
                                        {{-- <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="1" checked>
                                            <span class="custom-control-label"><b>PDF</b></span>
                                        </label> --}}
                                        <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="2">
                                            <span class="custom-control-label"><b>Excel</b></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-dismiss="modal" type="submit">Export</button>
                        <button class="btn btn-light" data-bs-dismiss="modal" type="reset">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('export.EmpAttendanceMusterRoll') }}" method="post">
        @csrf
        <div class="modal fade" id="export3" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">individual Attendance Report</h6><button type="reset" aria-label="Close"
                            class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true"
                                type='reset'>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <h6>Download individual employee attendance report</h6>
                        <div class="row text-start">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="form-label">Emp ID</p>
                                    <input type="text" class="form-control header-text" id=""
                                        placeholder="Enter Employee's ID" aria-label="text" tabindex="1"
                                        name="empID" required="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Date</p>
                                    <div class="form-group mb-3">
                                        <input class="form-control " placeholder="" type="month" value=""
                                            name="month" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <div class="form-label">Document Formate</div>
                                    <div class="custom-controls-stacked d-flex">
                                        {{-- <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="1" checked>
                                            <span class="custom-control-label"><b>PDF</b></span>
                                        </label> --}}
                                        <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="2">
                                            <span class="custom-control-label"><b>Excel</b></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-dismiss="modal" type="submit" onclick="modalAction()">Export</button>
                        <button class="btn btn-light" data-bs-dismiss="modal" type="reset">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('export.EmployeeARReport') }}" method="post">
        @csrf
        <div class="modal fade" id="export4" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">individual Attendance Report</h6><button type="reset" aria-label="Close"
                            class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true"
                                type='reset'>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <h6>Download individual employee AR report</h6>
                        <div class="row text-start">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="form-label">Emp ID</p>
                                    <input type="text" class="form-control header-text" id=""
                                        placeholder="Enter Employee's ID" aria-label="text" tabindex="1"
                                        name="empID" required="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Date</p>
                                    <div class="form-group mb-3">
                                        <input class="form-control " placeholder="" type="month" value=""
                                            name="month" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <div class="form-label">Document Formate</div>
                                    <div class="custom-controls-stacked d-flex">
                                        {{-- <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="1" checked>
                                            <span class="custom-control-label"><b>PDF</b></span>
                                        </label> --}}
                                        <label class="custom-control custom-radio mx-3">
                                            <input type="radio" class="custom-control-input" name="export1"
                                                value="2">
                                            <span class="custom-control-label"><b>Excel</b></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-dismiss="modal" type="submit" onclick="modalAction()">Export</button>
                        <button class="btn btn-light" data-bs-dismiss="modal" type="reset">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script>
        functon modalAction(){
            $('#export3').modal('hide');
        }
    </script>
@endsection
@endif
