@extends('admin.layout.master')
@section('title')
    Settings
@endsection

@section('contents')
    <!-- ROW -->
    <div class="row ">
        <div class="col-lg-3 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="list-group list-group-transparent mb-0 file-manager file-manager-border">
                        <h4>Settings</h4>
                        <div>
                            <a href="{{url('setting/')}}" class="list-group-item  d-flex align-items-center px-0 border-top">
                                <i class="fe fe-user fs-18 me-2 text-success p-2"></i>Account
                            </a>
                        </div>
                        <div>
                            <a href="{{url('settings/attendancesetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fe fe-user-check fs-18 me-2 text-secondary p-2"></i>Attendance
                            </a>
                        </div>
                        <div>
                            <a href="{{url('settings/businesssetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fe fe-bold fs-18 me-2 text-primary p-2"></i> Business
                            </a>
                        </div>
                        </div>
                        <div>
                            <a href="{{url('settings/salarysetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fe fe-dollar-sign fs-18 me-2 text-warning p-2"></i> Salary
                            </a>
                        </div>
                        <div>
                            <a href="{{url('settings/businessinfosetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fa fa-drivers-license-o fs-18 me-2 text-pink p-2"></i> Business Info
                            </a>
                        </div>
                        <div>
                            <a href="{{url('settings/helpsetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fe fe-headphones fs-18 me-2 text-info p-2"></i> Help & Support
                            </a>
                        <div>
                            <a href="{{url('settings/aboutsetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fe fe-help-circle fs-18 me-2 text-danger p-2"></i> About
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9">
            @yield('settings')
        </div>
    </div>
    <!-- END ROW -->
@endsection
