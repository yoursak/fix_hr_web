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
@section('contents')
    <div class="row">
        <div class="card" id="repoerCard1">
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-11 my-auto">
                        <h4 class="my-auto"><b>Attendance Reports</b></h4>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Attendance Report, Daily Attendance Report, Leave Balance Report and Attendance Summery Report,
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
                        <h5 class="my-auto">Attendance Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Lavel Summery for indivisual attendance cycle
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Compliance OT Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Lavel Overtime report as per goverment norms
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Daily Attendance Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daywise attendance summery, indivisual attendance view and punch logs
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Leave Balance Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff lavel view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Muster Roll Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Monthly view of day wise attendance , fine, OT, elc. of all Staff
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
                            Staff Lavel Summery for indivisual attendance cycle
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>

                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">LWF Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Lavel Overtime report as per goverment norms
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">PF Compliance Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daywise attendance summery, indivisual attendance view and punch logs
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">PF Excel Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff lavel view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
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
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
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
                        <h4 class="my-auto"><b>Miscellaneous Reports</b></h4>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Work Report, Staff Details Report, Daily Work Entry Reports.
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
                        <h5 class="my-auto">Acount Details</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Lavel Summery for indivisual attendance cycle
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>

                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Daily Work Entry</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Lavel Overtime report as per goverment norms
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Staff Detail</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daywise attendance summery, indivisual attendance view and punch logs
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Work Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff lavel view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
                            Staff Lavel Summery for indivisual attendance cycle
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>

                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Bonus Reoprt</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Lavel Overtime report as per goverment norms
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Bulk Salary Slip</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daywise attendance summery, indivisual attendance view and punch logs
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Genrate Report</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Deduction Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff lavel view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Loan Summary Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Lavel Summery for indivisual attendance cycle
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>

                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Payment Logs Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff Lavel Overtime report as per goverment norms
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">RTGS Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Daywise attendance summery, indivisual attendance view and punch logs
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Staff Fine Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff lavel view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 m-3">
                <div class="row">
                    <div class="col-7 my-auto">
                        <h5 class="my-auto">Staff Payroll Report</h5>
                        <p class="my-auto fs-14 mt-1 text-muted" style="color:rgb(34, 33, 29)">
                            Staff lavel view of allowed leave, leave token, leave remaining, etc.
                        </p>
                    </div>
                    <div class="col-5 my-auto text-end">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-pencil me-2"></i>Custmize</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clockinmodal" id="newTempFormBtn"><i class="fa fa-file-excel-o me-2"></i>Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Save</a>
    </div>
@endsection
