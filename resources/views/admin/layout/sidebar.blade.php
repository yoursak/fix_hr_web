<?php
$Helper = new App\Helpers\Central_unit();
$Helper1 = new App\Helpers\Layout();
?>
<div class="sticky">
    @php
        $Sidebar = $Helper1->SidebarList();
        $SidebarMenu = $Helper1->SidebarMenu();
        $Permission = $Helper->GetModelPermission();
        $SiderBarLoad = $Helper->ModuleIdToPermission();
        $SideBarList = $Helper->sideBarLists();
        $accessPermission = $Helper->AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

    @endphp
    <aside class="app-sidebar ">
        <div class="app-sidebar__logo">
            <a class="header-brand" href="index.html">
                <img src="{{ asset('assets/logo/FixHR.png?v=0.2') }}" class="header-brand-img desktop-lgo"
                    alt="FixingDotslogo">
                <a href="{{ url('/dashboard') }}" style="display: flex; justify-content: center; align-items: center;">
                    <img src="{{ asset('assets/logo/Fix_HR_Dark.png?v=0.10') }}" class="header-brand-img dark-logo"
                        style="transform: translateY(-5px); max-width: 70%;" alt="FixingDotslogo">
                </a>
                <img src="{{ asset('assets/logo/Fix_HR_Dark.png?v=0.10') }}" class="header-brand-img mobile-logo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/logo/Fix_HR_Dark.png?v=0.10') }}" class="header-brand-img darkmobile-logo"
                    alt="FixingDotslogo">
            </a>
        </div>
        {{-- style="background-color:  #1034A6; --}}
        <div class="app-sidebar3">
            <div class="main-menu">
                <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                    </svg></div>
                <ul class="side-menu">
                    <?php if (Session::get('model_id') != null) {
                    ?>

                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/dashboard') }}">
                            <i class="feather feather-home sidemenu_icon"></i>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/admin/employee') }}">
                            <i class="feather feather-users sidemenu_icon"></i>
                            <span class="side-menu__label">Employee</span>
                        </a>
                    </li>

                    {{-- <li class="slide">
                        <a class="side-menu__item" href="{{ url('/admin/attendance') }}">
                        <i class="feather feather-user-check sidemenu_icon"></i>
                        <span class="side-menu__label">Attendance</span>
                        </a>
                    </li> --}}
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-user-check sidemenu_icon"></i>
                            <span class="side-menu__label">Attendance</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">
                            {{-- <li class="side-menu-label1"><a href="{{ url('/admin/attendance') }}"></a>
                                </li> --}}

                            <li><a href="{{ url('/admin/attendance') }}" class="slide-item">Daily Attendance</a></li>

                            <li>
                                <a href="{{ url('/admin/attendance/details') }}" class="slide-item">Monthly
                                    Attendance</a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/attendance/month-summary') }}" class="slide-item">Attendance
                                    Summary</a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/attendance/submit-attendance') }}" class="slide-item"> Submit
                                    Attendance</a>
                            </li>
                            {{-- <li>
                                <a href="{{ url('/admin/attendance/force-update-attendance') }}" class="slide-item"> Update Attendance</a>
                            </li> --}}

                            {{-- <li><a href="{{ url('/admin/attendance/byemployee') }}" class="slide-item">Attendance By Employee</a></li> --}}

                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-file-text sidemenu_icon"></i>
                            <span class="side-menu__label">Requests</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">
                            <li class="side-menu-label1"><a href="{{ url('/admin/leave') }}">Leave</a></li>

                            <li><a href="{{ url('/admin/requests/leaves') }}" class="slide-item"> Leave </a></li>

                            <li><a href="{{ url('/admin/requests/mispunch') }}" class="slide-item"> Mis Punch </a>
                            </li>

                            <li><a href="{{ url('/admin/requests/gatepass') }}" class="slide-item"> Gate Pass</a></li>

                        </ul>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/admin/report') }}">
                            <i class="fa fa-copy sidemenu_icon"></i>
                            <span class="side-menu__label">Report</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="fa fa-universal-access sidemenu_icon"></i>
                            <span class="side-menu__label">Role & Permission</span><i
                                class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">

                            <li><a href="{{ url('Role-permission/role_permission') }}" class="slide-item"> Role &
                                    Permission List </a></li>
                            <li><a href="{{ url('/Role-permission/admin-list') }}" class="slide-item"> Admin List
                                </a>
                            </li>
                            <li><a href="{{ url('/Role-permission/approval_settings') }}" class="slide-item"> Approval
                                    Setup</a></li>

                        </ul>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-settings sidemenu_icon"></i>
                            <span class="side-menu__label">Settings</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">

                            {{-- <li class="side-menu-label1"><a
                                    href="{{ url('settings/attendancesetting') }}">Attendance
                                Setting</a>
                            </li> --}}
                            <li><a href="{{ url('admin/settings/account') }}" class="slide-item"> Account Settings
                                </a>
                            </li>

                            <li><a href="{{ url('admin/settings/business') }}" class="slide-item"> Business
                                    Settings</a>
                            </li>

                            <li><a href="{{ url('admin/settings/attendance') }}" class="slide-item"> Attendance
                                    Settings</a></li>
                            <li><a href="{{ url('admin/attendance/active_mode_set') }}" class="slide-item">Setup
                                    Activation</a></li>
                            {{-- <li><a href="{{ url('admin/settings/localization') }}" class="slide-item"> Localization
                                Setting </a></li> --}}
                            {{--
                            <li><a href="{{ url('admin/settings/notification') }}" class="slide-item"> Notification
                                Setting </a></li> --}}

                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/subscription') }}">
                            <i class="feather feather-lock sidemenu_icon"></i>
                            <span class="side-menu__label">Subscription</span>
                        </a>
                    </li>

                    <?php } else { ?>
                    {{-- <li class="side-item side-item-category mt-4">General</li> --}}


                    @if (in_array('Dashboard.View', $permissions))
                        <li class="slide">
                            <a class="side-menu__item" href="{{ url('/dashboard') }}">
                                <i class="feather feather-home sidemenu_icon"></i>
                                <span class="side-menu__label">Dashboard</span>
                            </a>
                        </li>
                    @endif

                    @if (in_array('Employee.View', $permissions))
                        <li class="slide">
                            <a class="side-menu__item" href="{{ url('/admin/employee') }}">
                                <i class="feather feather-users sidemenu_icon"></i>
                                <span class="side-menu__label">Employee</span>
                            </a>
                        </li>
                    @endif
                    @if (in_array('Daily Attendance.View', $permissions) ||
                            in_array('Monthly Attendance.View', $permissions) ||
                            in_array('Attendance Summary.View', $permissions) || 
                            in_array('Submit Attendance.View', $permissions)) 

                        @php
                            $subItems1 = [['url' => '/admin/attendance', 'label' => 'Daily Attendance.View', 'name' => 'Daily Attendance'], 
                            ['url' => '/admin/attendance/details', 'label' => 'Monthly Attendance.View', 'name' => 'Monthly Attendance'], 
                            ['url' => '/admin/attendance/month-summary', 'label' => 'Attendance Summary.View', 'name' => 'Attendance Summary'],
                            ['url' => '/admin/attendance/submit-attendance', 'label' => 'Submit Attendance.View', 'name' => 'Submit Attendance']];
                            $showRequestsMenu1 = false; // Initialize a flag variable
                        @endphp
                        @foreach ($subItems1 as $subItem)
                            @if (in_array($subItem['label'], $permissions))
                                @php
                                    $showRequestsMenu1 = true; // Set the flag to true if any sub-item has permission
                                @endphp
                                {{-- Break the loop as soon as a sub-item with permission is found --}}
                            @break
                        @endif
                    @endforeach
                    @if ($showRequestsMenu1)
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                                <i class="feather feather-file-text sidemenu_icon"></i>
                                <span class="side-menu__label">Attendance</span><i
                                    class="angle fa fa-angle-right"></i>
                            </a>
                            <ul class="slide-menu" style="background-color: #1034A6; border-radius: 7px;">
                                @foreach ($subItems1 as $subItem)
                                    @if (in_array($subItem['label'], $permissions))
                                        <li><a href="{{ url($subItem['url']) }}"
                                                class="slide-item">{{ $subItem['name'] }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    {{-- <li class="slide">
                        <a class="side-menu__item" href="{{ url('/admin/attendance') }}">
                    <i class="feather feather-user-check sidemenu_icon"></i>
                    <span class="side-menu__label">Attendance</span>
                    </a>
                    </li> --}}
                @endif

                @if (in_array('Leave.All', $permissions) ||
                        in_array('Leave.View', $permissions) ||
                        in_array('Mis Punch.View', $permissions) ||
                        in_array('Gate Pass.View', $permissions))

                    @php
                        $subItems1 = [['url' => '/admin/requests/leaves', 'label' => 'Leave.View', 'name' => 'Leave'], ['url' => '/admin/requests/mispunch', 'label' => 'Mis Punch.View', 'name' => 'Mis Punch'], ['url' => '/admin/requests/gatepass', 'label' => 'Gate Pass.View', 'name' => 'Gate Pass']];
                        // print_r($subItems1);
                        $showRequestsMenu1 = false; // Initialize a flag variable
                    @endphp

                    @foreach ($subItems1 as $subItem)
                        @if (in_array($subItem['label'], $permissions))
                            @php
                                $showRequestsMenu1 = true; // Set the flag to true if any sub-item has permission
                            @endphp
                            {{-- Break the loop as soon as a sub-item with permission is found --}}
                        @break
                    @endif
                @endforeach
                @if ($showRequestsMenu1)
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-file-text sidemenu_icon"></i>
                            <span class="side-menu__label">Requests</span><i
                                class="angle fa fa-angle-right"></i>
                        </a>
                        <ul class="slide-menu" style="background-color: #1034A6; border-radius: 7px;">
                            @foreach ($subItems1 as $subItem)
                                @if (in_array($subItem['label'], $permissions))
                                    <li><a href="{{ url($subItem['url']) }}"
                                            class="slide-item">{{ $subItem['name'] }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endif

            @if (in_array('Report.View', $permissions))
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/admin/report') }}">
                        <i class="fa fa-copy sidemenu_icon"></i>
                        <span class="side-menu__label">Report</span>
                    </a>
                </li>
            @endif

            @php
                $subItems = [['url' => '/Role-permission/role_permission', 'label' => 'Roles & Permissions.View', 'name' => 'Roles & Permissions'], ['url' => '/Role-permission/admin-list', 'label' => 'Admin List.View', 'name' => 'Admin List'], ['url' => '/Role-permission/approval_settings', 'label' => 'Approval Setup.View', 'name' => 'Approval Setup']];
                $showRequestsMenu = false; // Initialize a flag variable
            @endphp

            @foreach ($subItems as $subItem)
                @if (in_array($subItem['label'], $permissions))
                    @php
                        $showRequestsMenu = true; // Set the flag to true if any sub-item has permission
                    @endphp
                    {{-- Break the loop as soon as a sub-item with permission is found --}}
                @break
            @endif
        @endforeach

        @if ($showRequestsMenu)
            <li class="slide">
                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                    <i class="feather feather-file-text sidemenu_icon"></i>
                    <span class="side-menu__label">Roles & Permissions</span><i
                        class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu" style="background-color: #1034A6; border-radius: 7px;">
                    @foreach ($subItems as $subItem)
                        @if (in_array($subItem['label'], $permissions))
                            <li><a href="{{ url($subItem['url']) }}"
                                    class="slide-item">{{ $subItem['name'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endif

        @php
            $settingsSubItems = [['url' => 'admin/settings/account', 'label' => 'Account Settings.View', 'name' => 'Account Settings'], 

            ['url' => 'admin/settings/business', 'label' => 'Branch Settings.View', 'name' => 'Business Settings'], 
            ['url' => 'admin/settings/business', 'label' => 'Department Settings.View', 'name' => 'Business Settings'], 
            ['url' => 'admin/settings/business', 'label' => 'Designation Settings.View', 'name' => 'Business Settings'], 
            ['url' => 'admin/settings/business', 'label' => 'Leave Settings.View', 'name' => 'Business Settings'], 
            ['url' => 'admin/settings/business', 'label' => 'Holiday Settings.View', 'name' => 'Business Settings'], 
            ['url' => 'admin/settings/business', 'label' => 'WeeklyHoliday Settings.View', 'name' => 'Business Settings'], 
            ['url' => 'admin/settings/business', 'label' => 'Notice Board.View', 'name' => 'Business Settings'], 
            ['url' => 'admin/settings/business', 'label' => 'Comp-Off & LWP Policy.View', 'name' => 'Business Settings'], 

            ['url' => 'admin/settings/attendance', 'label' => 'Shift Settings.View', 'name' => 'Attendance Settings'], 
            ['url' => 'admin/settings/attendance', 'label' => 'Attendance Mode.View', 'name' => 'Attendance Settings'], 
            ['url' => 'admin/settings/attendance', 'label' => 'Automation-Rules.View', 'name' => 'Attendance Settings'], 
            ['url' => 'admin/settings/attendance', 'label' => 'Camera Permission.View', 'name' => 'Attendance Settings'], 
            
            ['url' => 'admin/attendance/active_mode_set', 'label' => 'Setup Activation.View', 'name' => 'Setup Activation']];

            $showSettingsMenu = false; // Initialize a flag variable
            $uniqueNames = []; // Array to store unique 'name' values
        @endphp

        @foreach ($settingsSubItems as $subItem)
            @if (in_array($subItem['label'], $permissions))
                @php
                    $showSettingsMenu = true; // Set the flag to true if any sub-item has permission
                    // Add the 'name' to the uniqueNames array if it's not already present
                    if (!in_array($subItem['name'], $uniqueNames)) {
                        $uniqueNames[] = $subItem['name'];
                    }
                @endphp
            @endif
        @endforeach

        @if ($showSettingsMenu)
            <li class="slide">
                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                    <i class="feather feather-settings sidemenu_icon"></i>
                    <span class="side-menu__label">Settings</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu" style="background-color: #1034A6; border-radius: 7px;">
                    @foreach ($uniqueNames as $uniqueName)
                        <li>
                            @php
                                // Find the first matching item based on the 'name'
                                $firstMatchingItem = current(
                                    array_filter($settingsSubItems, function ($item) use ($uniqueName) {
                                        return $item['name'] == $uniqueName;
                                    }),
                                );
                            @endphp
                            <a href="{{ url($firstMatchingItem['url']) }}"
                                class="slide-item">{{ $uniqueName }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif


        {{-- @php

            $settingsSubItems = [
                ['url' => 'admin/settings/account', 'label' => 'Account Setting.View', 'name' => 'Account Setting'],
                [
                    'url' => 'admin/settings/business',
                    'label' => 'Business
                Setting.View',
                    'name' => 'Business Setting',
                ],
                ['url' => 'admin/settings/account', 'label' => 'Shift Settings.View', 'name' => 'Attendance Setting'],
                ['url' => 'admin/settings/account', 'label' => 'Attendance Automation-Rules.View', 'name' => 'Attendance Setting'],
                ['url' => 'admin/attendance/active_mode_set', 'label' => 'Setup Activation.View', 'name' => 'Setup Activation'],
            ];
            print_r($settingsSubItems);
            $showSettingsMenu = false; // Initialize a flag variable
        @endphp

        @foreach ($settingsSubItems as $subItem)
            @if (in_array($subItem['label'], $permissions))
                @php
                    $showSettingsMenu = true; // Set the flag to true if any sub-item has permission
                @endphp
            @break
        @endif
    @endforeach

    @if ($showSettingsMenu)
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <i class="feather feather-settings sidemenu_icon"></i>
                <span class="side-menu__label">Settings</span><i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu" style="background-color: #1034A6; border-radius: 7px;">
                @foreach ($settingsSubItems as $subItem)
                    @if (in_array($subItem['label'], $permissions))
                        <li><a href="{{ url($subItem['url']) }}"
                                class="slide-item">{{ $subItem['name'] }}</a></li>
                    @endif
                @endforeach
            </ul>
        </li>
    @endif --}}


        @if (in_array('Subscription.Create', $permissions))
            <li class="slide">
                <a class="side-menu__item" href="{{ url('/subscription') }}">
                    <i class="feather feather-lock sidemenu_icon"></i>
                    <span class="side-menu__label">Subscription</span>
                </a>
            </li>
        @endif

        <?php } ?>

        {{-- <li class="slide">
            <a class="side-menu__item" href="" data-bs-toggle="modal"
                data-bs-target="#LogoutModal">
                <i class="fe fe-log-out sidemenu_icon"></i>
                <span class="side-menu__label">Log Out</span>
            </a>
        </li> --}}
    </ul>

</div>
</div>
</aside>
</div>

<!-- MODAL -->
<div class="modal fade modal-effect" id="LogoutModal">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content tx-size-sm">
<div class="modal-body text-center">
    <i class="fe fe-alert-triangle fs-50"></i>
    <h4 class="text-primary fs-20 font-weight-semibold mt-2">Logout Alert</h4>
    <p class="mb-4 mx-4">Are you sure want to log out ???</p>
    <a class="btn btn-danger " href="https://phplaravel-1083191-3790162.cloudwaysapps.com/logout">
        Log Out
    </a>
    {{-- <a href="{{ url('/logout') }}" class="btn btn-danger px-5" id="logoutButton">Log Out</a> --}}

    <a aria-label="Close" class="btn btn-primary px-5 text-white" data-bs-dismiss="modal">StayLogedin</a>
</div>
</div>
</div>
</div>
<!-- END MODAL -->
