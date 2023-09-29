@extends('admin.setting.setting')
@section('subtitle')
    Business
@endsection
@section('settings')
    <?php $root = new App\Helpers\Central_unit();
    $branchCount = $root->CountersValue();
    $deparmtnetCount = $root->CountersValue();
    $designationCount = $root->CountersValue();
    $holidayCount=$root->CountersValue();
    $leaveCount=$root->CountersValue();
    $weeklyholidayCount=$root->CountersValue();
   
    ?>
    <div class="row row-sm">
        @if (in_array('Business Setting.View', $permissions))
            @if (in_array('Branch Setting.View', $permissions))
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
                                        <p class="my-auto">
                                            <?= $branchCount[0] ?>&nbsp;Branchs Created
                                            {{-- | assign to all Employee --}}
                                        </p>
                                    </div>
                                    <div class="my-auto"> <a href="{{ url('admin/settings/business/branches') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (in_array('Department Setting.View', $permissions))
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
                                            <h5 class="my-auto text-dark">Departments</h5>
                                        </a>
                                        <p class="my-auto"><?= $deparmtnetCount[1] ?>&nbsp;Departments Created
                                            {{-- | assign to 25/50
                                            employees --}}
                                        </p>
                                    </div>
                                    <div class="my-auto"> <a href="{{ url('admin/settings/business/department') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (in_array('Designation Setting.View', $permissions))
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
                                        <p class="my-auto"><?= $designationCount[2] ?>&nbsp;Designations Created
                                             {{-- | assign to 25/50
                                            employees --}}
                                        </p>
                                    </div>
                                    <div class="my-auto"> <a href="{{ url('admin/settings/business/designation') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- <div class="col-xl-6">
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
    </div> --}}

            @if (in_array('Holiday Setting.View', $permissions))
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
                                        <p class="my-auto"><?= $holidayCount[4] ?>&nbsp;Holiday Policy Created</p>
                                    </div>
                                    <div class="my-auto"><a href="{{ url('admin/settings/business/holiday_policy') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (in_array('Leave Setting.View', $permissions))
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
                                        <p class="my-auto"><?= $leaveCount[5] ?>&nbsp;Leave Policy Created</p>
                                    </div>
                                    <div class="my-auto"> <a href="{{ url('admin/settings/business/leave_policy') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (in_array('WeeklyHoliday Setting.View', $permissions))
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
                                        <p class="my-auto"><?= $weeklyholidayCount[6] ?>&nbsp;Weekly Holiday Created</p>
                                    </div>
                                    <div class="my-auto"> <a href="{{ url('admin/settings/business/weekly_holiday') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (in_array('Manage Employee Data Setting.View', $permissions))
                <!-- <div class="col-xl-6">
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
        </div> -->
            @endif
            {{-- @if (in_array('Invite Employee.View', $permissions))
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
                                    <div class="my-auto"> <a
                                            href="{{ url('admin/settings/business/invite_employee') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif --}}
        @endif

    </div>
@endsection
