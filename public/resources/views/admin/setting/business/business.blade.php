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
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="fe fe-umbrella"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Holiday Policy</h5>
                        </a>
                        <p>One Template</p>
                        <a href="{{url('settings/business/holiday')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span
                                class="settings-icon bg-secondary-transparent text-secondary border-secondary"><i
                                    class="fe fe-user-minus"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Leave Policy</h5>
                        </a>
                        <p>Three Templates</p>
                        <a href="{{url('settings/business/leave')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-danger-transparent text-danger border-danger"><i
                                    class="fe fe-award"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Admin Setting</h5>
                        </a>
                        <p>5 Admins</p>
                        <a href="{{url('settings/business/adminsetting')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-warning-transparent text-warning border-warning"><i
                                    class="fe fe-grid"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Manager Setting</h5>
                        </a>
                        <p>0 Managers Added</p>
                        <a href="{{url('settings/business/manager')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-success-transparent text-success border-success"><i
                                    class="fe fe-flag"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Branches</h5>
                        </a>
                        <p>2 Branch added | assign to all Employee</p>
                        <a href="{{url('settings/business/branchesetting')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-success-transparent text-success border-success"><i
                                    class="fe fe-flag"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Departments & Designations</h5>
                        </a>
                        <p>One Departments | assign to 25/50 employees</p>
                        <a href="{{url('settings/business/department')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="fe fe-database"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Manage Employee Data</h5>
                        </a>
                        <p>No data added</p>
                        <a href="{{url('settings/business/manageEmp')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-info-transparent text-info border-info"><i
                                    class="fe fe-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Weekly Holiday</h5>
                        </a>
                        <p>Sunday</p>
                        <a href="{{url('settings/business/weeklyholiday')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-success-transparent text-success border-success"><i
                                    class="fe fe-mail"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Invite Employee</h5>
                        </a>
                        <p></p>
                        <a href="{{url('settings/business/invite')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
