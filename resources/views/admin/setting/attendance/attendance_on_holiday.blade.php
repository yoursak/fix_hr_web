
@extends('admin.setting.setting')
@section('subtitle')
    Attendance / Attendance on Holiday
@endsection
@section('settings')
    <div class="row row-sm">
        <div class="">
            <div class="card">
                <div class="tab-menu-heading p-0 border-0">
                    <div class="tabs-menu1 px-3">
                        <ul class="nav">
                            <li><a href="#tab-7" class="active" data-bs-toggle="tab">Rules</a></li>
                            <li><a href="#tab-8" class="text-muted">Employee Selection</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-15 ms-3">Allow Attendance on paid holiday</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <p class="my-auto text-muted">14 Employee Asigned</p>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('settings/attendancesetting/automationrule/lateentry')}}">Assign Employee</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-15 ms-3">Camp Off Leave</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <p class="my-auto text-muted">14 Employee Asigned</p>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('settings/attendancesetting/automationrule/lateentry')}}">Assign Employee</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-15 ms-3">Do NOT allow Attendance on paid holiday</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <p class="my-auto text-muted">14 Employee Asigned</p>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('settings/attendancesetting/automationrule/lateentry')}}">Assign Employee</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
