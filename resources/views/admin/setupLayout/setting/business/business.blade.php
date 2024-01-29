@extends('admin.setupLayout.master')
@section('title')
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

    <div class="iniitial-header my-5">
        <h2 class="m-0"><b>Welcome to FixHR</b></h2>
        <p class="fs-16 text-muted">Kindly complete step by step process to register your business with us, do not skip setup
            process other wise it will not function</p>
        <span class="fs-16">
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Account Settings<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-circle mx-2 text-primary"></i>Business Settings<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Attendance Settings<i
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
        {{-- @if (in_array('Business Setting.View', $permissions)) --}}
        @if (in_array('Branch Settings.View', $permissions) || in_array('Branch Settings.All', $permissions))
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
        @if (in_array('Department Settings.View', $permissions))
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
        @if (in_array('Designation Settings.View', $permissions))
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


        @if (in_array('Holiday Settings.View', $permissions))
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
        @if (in_array('Leave Settings.View', $permissions))
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
        @if (in_array('WeeklyHoliday Settings.View', $permissions))
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
                                <div class="my-auto"> <a href="{{ url('/setup/business-settings/weekly-holiday') }}"><i
                                            class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array('Notice Board.View', $permissions))
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
                                        <h5 class="my-auto text-dark">Notice (Optional)</h5>
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
        @if (in_array('Comp-Off & LWP Policy.View', $permissions))
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
                                        <h5 class="my-auto text-dark">Comp-Off & LWP Policy</h5>
                                    </a>
                                    <p class="my-auto">Comp-Off & LWP Activated</p>
                                </div>
                                <div class="my-auto"> <a href="{{ url('setup/business-settings/compoff-lwop') }}"><i
                                            class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- @endif --}}
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ url('setup/account-settings') }}" class="btn btn-primary">Previous</a>
            </div>

            <div class="d-flex">
                <a href="{{ url('setup/attendance-settings') }}" id="saveButton" class="btn btn-primary">Save &
                    Continue</a>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            var branchcv = '<?= $branchCountValue ?>';
            var departmentcv = '<?= $departmentCountValue ?>';
            var designationcv = '<?= $designationCountValue ?>';
            var holidaycv = '<?= $holidayPolicyCountValue ?>';
            var leavepolicycv = '<?= $leavePolicyCountValue ?>';
            var weekholidaycv = '<?= $weeklyHolidayPolicyCountValue ?>';
            var policycompoffCoutnValue = '<?= $policycompoffCoutnValue ?>';

            document.getElementById('saveButton').addEventListener('click', function(event) {
                // Your condition to check

                if (policycompoffCoutnValue == 0) {
                    // Condition is false, show a SweetAlert alert
                    event.preventDefault(); // Prevent the default action (following the link)

                    Swal.fire({
                        icon: 'error',
                        // title: 'Oops...',
                        text: 'Your fields can not be empty!',
                    });
                }
                if ((branchcv == 0) || (departmentcv == 0) || (designationcv == 0) || (holidaycv == 0) || (
                        leavepolicycv == 0) || (weekholidaycv == 0) || (noticeboardcv == 0) || (
                        policycompoffCoutnValue == 0)) {
                    // Condition is false, show a SweetAlert alert
                    event.preventDefault(); // Prevent the default action (following the link)

                    Swal.fire({
                        icon: 'error',
                        // title: 'Oops...',
                        text: 'Your fields can not be empty!',
                    });
                }
            });
        </script>
    </div>
@endsection
