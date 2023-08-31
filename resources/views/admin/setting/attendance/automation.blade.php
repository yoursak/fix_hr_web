
@extends('admin.setting.setting')
@section('subtitle')
    Attendance / Automation Rule
@endsection
@section('settings')
    <div class="row row-sm">
        <div class="col-lg-8">
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
                        <div class="d-flex justify-content-around">
                            <i class="fa fa-female fs-30 m-2"></i>
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-16 ms-3">Late Entry Rule</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('admin/settings/attendance/automation/late_entry')}}">Create Rule</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-around">
                            <i class="fa fa-female fs-30 m-2"></i>
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-16 ms-3">Break Rule</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('admin/settings/attendance/automation/break_rule')}}">Create Rule</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-around">
                            <i class="fa fa-female fs-30 m-2"></i>
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-16 ms-3">Early Exit Rule</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('admin/settings/attendance/automation/early_exit')}}">Create Rule</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-around">
                            <i class="fa fa-female fs-30 m-2"></i>
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-16 ms-3">Overtime Rule</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('admin/settings/attendance/automation/overtime_rule')}}">Create Rule</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-around">
                            <i class="fa fa-female fs-30 m-2"></i>
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-16 ms-3">Early Overtime Rule</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('admin/settings/attendance/automation/early_overtimes')}}">Create Rule</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body pt-2">
                    <ul class="timeline ">
                        <li class="primary mt-6">
                            <a target="_blank" href="#"
                                class="font-weight-semibold fs-14  ms-3">Create your first rule</a>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the box
                            </p>
                        </li>
                        <li class="primary mt-6">
                            <a target="_blank" href="#"
                                class="font-weight-semibold fs-14 text-muted ms-3">Set a rule value</a>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">set a value for your rule type</p>
                        </li>
                        <li class="pink mt-6">
                            <a target="_blank" href="#"
                                class="font-weight-semibold fs-14 text-muted ms-3">Assign Employee</a>
                            <p class="mb-0 pb-0 text-muted fs-12  ms-3 mt-1">Select thwe that you want the rule to be
                                assigned to.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
