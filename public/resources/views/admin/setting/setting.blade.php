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
                        <div>
                            <a href="{{url('settings/attendancesetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fe fe-user-check fs-18 me-4 text-primary p-2 border border-primary rounded"></i>Attendance Setting
                            </a>
                        </div>
                        <div>
                            <a href="{{url('settings/businesssetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fe fe-bold fs-18 me-4 text-primary border border-primary rounded p-2"></i> Business Setting
                            </a>
                        </div>
                        </div>
                        <div>
                            <a href="{{url('settings/salarysetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fa fa-inr fs-18 me-4 text-primary border border-primary rounded p-2 px-3"></i> Salary Setting
                            </a>
                        </div>
                        <div>
                            <a href="{{url('settings/businessinfosetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fa fa-drivers-license-o fs-18 me-4 text-primary border border-primary rounded p-2"></i> Business Info Setting
                            </a>
                        </div>
                        <div>
                            <a href="{{url('setting/')}}" class="list-group-item  d-flex align-items-center px-0 border-top">
                                <i class="fe fe-user fs-18 me-4 text-primary border border-primary rounded p-2"></i>Account Setting
                            </a>
                        </div>
                        <div>
                            <a href="{{url('admin/login')}}" class="list-group-item  d-flex align-items-center px-0 border-top">
                                <i class="fe fe-log-out fs-18 me-4 text-danger border border-primary rounded p-2"></i>Logout
                            </a>
                        </div>
                        <div>
                            {{-- <a href="{{url('settings/othersetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fe fe-headphones fs-18 me-4 text-info border border-primary rounded p-2"></i> Others Setting
                            </a> --}}
                        <div>
                            {{-- <a href="{{url('settings/aboutsetting')}}" class="list-group-item  d-flex align-items-center px-0">
                                <i class="fe fe-help-circle fs-18 me-4 text-danger border border-primary rounded p-2"></i> About Setting
                            </a> --}}
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
