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

        // print_r($SideBarList);

    @endphp
    <aside class="app-sidebar ">
        <div class="app-sidebar__logo">
            <a class="header-brand" href="index.html">
                <img src="{{ asset('assets/logo/FixHR.png?v=0.2') }}" class="header-brand-img desktop-lgo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/logo/Fix_HR_Dark.png?v=0.10') }}" class="header-brand-img dark-logo"
                    style="transform:translateY(-5px);max-width: 70%;}" alt="FixingDotslogo">
                <img src="{{ asset('assets/logo/Fix_HR_Dark.png?v=0.10') }}" class="header-brand-img mobile-logo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/logo/Fix_HR_Dark.png?v=0.10') }}" class="header-brand-img darkmobile-logo"
                    alt="FixingDotslogo">
            </a>
        </div>
        <div class="app-sidebar3">
            <div class="main-menu">
                <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                    </svg></div>
                <ul class="side-menu">

                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('setup/account-settings') }}">
                            <i class="feather feather-home sidemenu_icon"></i>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-settings sidemenu_icon"></i>
                            <span class="side-menu__label">Settings</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">

                            {{-- <li class="side-menu-label1"><a href="{{ url('settings/attendancesetting') }}">Attendance
                                    Setting</a></li> --}}

                            <li><a href="{{ url('setup/account-settings') }}" class="slide-item"> Account Setting
                                </a>
                            </li>
                            <li><a href="{{ url('/setup/business-settings') }}" class="slide-item"> Business
                                    Setting</a>
                            </li>
                            <li><a href="{{ url('setup/attendance-settings') }}" class="slide-item"> Attendance
                                    Setting</a></li>

                            <li><a href="{{ url('setup/set-all-mode') }}" class="slide-item"> Setup Activation </a></li>


                        </ul>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" href="" data-bs-toggle="modal" data-bs-target="#LogoutModal">
                            <i class="fe fe-log-out sidemenu_icon"></i>
                            <span class="side-menu__label">Log Out</span>
                        </a>
                    </li>
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
                <a href="{{ url('/logout') }}" class="btn btn-danger px-5">Log Out</a>
                <a aria-label="Close" class="btn btn-primary px-5 text-white" data-bs-dismiss="modal">StayLogedin</a>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->
