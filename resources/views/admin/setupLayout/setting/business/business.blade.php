@extends('admin.setupLayout.master')
@section('subtitle')
    Business
@endsection
@section('content')
    <?php $root = new App\Helpers\Central_unit();
    $branchCount = $root->CountersValue();
    $deparmtnetCount = $root->CountersValue();
    $designationCount = $root->CountersValue();
    $holidayCount = $root->CountersValue();
    $leaveCount = $root->CountersValue();
    $weeklyholidayCount = $root->CountersValue();
    
    ?>

    <div class="iniitial-header m-5">
        <h2><b>FixingDots Pvt.Ltd</b></h2>
        <span class="fs-16">
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Account Setting<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-circle mx-2 text-primary"></i>Business Setting<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Attendance Setting<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Setup Activation<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Subscription<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Add Employee<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Finish<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
        </span>
    </div>
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
                                    <div class="my-auto"> <a href="{{ url('/setup/business-settings/branches') }}"><i
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
                                    <div class="my-auto"> <a href="{{ url('/setup/business-settings/department') }}"><i
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
                                    <div class="my-auto"> <a href="{{ url('/setup/business-settings/designation') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


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
                                    <div class="my-auto"><a href="{{ url('/setup/business-settings/holiday') }}"><i
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
                                    <div class="my-auto"> <a href="{{ url('/setup/business-settings/leave') }}"><i
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
                                    <div class="my-auto"> <a
                                            href="{{ url('/setup/business-settings/weekly-holiday') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 my-auto">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="nav-icon fa fa-bell"></i></span>
                            </div>
                            <div class="col-10 d-flex justify-content-between">
                                <div class="my-auto"><a href="#">
                                        <h5 class="my-auto text-dark">Notice</h5>
                                    </a>
                                    <p class="my-auto">Notice Created</p>
                                </div>
                                <div class="my-auto"> <a href="{{ url('/setup/business-settings/notice') }}"><i
                                            class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ url('setup/account-settings') }}" class="btn btn-primary">Previous</a>
            </div>
        
            <div class="d-flex">
                <a href="{{url('setup/attendance-settings')}}" class="btn btn-primary">Save & Continue</a>
            </div>
        </div>

    </div>
@endsection
