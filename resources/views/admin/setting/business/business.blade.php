@extends('admin.setting.setting')
@section('subtitle')
Business
@endsection
@section('settings')
<div class="row row-sm">
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-building-o "></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Branches</h5>
                            </a>
                            <p class="my-auto">2 Branch added | assign to all Employee</p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/business/branches') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-sitemap"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Department</h5>
                            </a>
                            <p class="my-auto">1 Departments | assign to 25/50 employees</p>
                        </div>
                        <div class="my-auto"> <a href="{{url('admin/settings/business/department')}}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fe fe-users"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Designations</h5>
                            </a>
                            <p class="my-auto">1 Designation | assign to 25/50 employees</p>
                        </div>
                        <div class="my-auto"> <a href="{{url('admin/settings/business/designation')}}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon las la-cog"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Admin Setting</h5>
                            </a>
                            <p class="my-auto">5 Admins</p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/business/admin') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon mdi mdi-account-settings-variant"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Manager Setting</h5>
                            </a>
                            <p class="my-auto">0 Managers Added</p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/business/manager') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-calendar-plus-o"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Holiday Policy</h5>
                            </a>
                            <p class="my-auto">One Template</p>
                        </div>
                        <div class="my-auto"><a href="{{ url('admin/settings/business/holiday_policy') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-calendar-times-o"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"> <a href="#">
                                <h5 class="my-auto text-dark">Leave Policy</h5>
                            </a>
                            <p class="my-auto">Three Templates</p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/business/leave_policy') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-calendar"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Weekly Holiday</h5>
                            </a>
                            <p class="my-auto">Sunday</p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/business/weekly_holiday') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-file-text-o"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Manage Employee Data</h5>
                            </a>
                            <p class="my-auto">No data added</p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/business/manage_emp') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-share-square-o"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Invite Employee</h5>
                            </a>
                            <p class="my-auto"></p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/business/invite_employee') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection