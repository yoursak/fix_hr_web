<?php
$Helper = new App\Helpers\Central_unit();
$Helper1 = new App\Helpers\Layout();
?>
<div class="sticky">
    @php
    $Sidebar = $Helper1->SidebarList();
    $SidebarMenu = $Helper1->SidebarMenu();
    $Permission = $Helper->GetModelPermission();
    $SiderBarLoad=$Helper->ModuleIdToPermission();
    // dd($ss);
    @endphp
    <aside class="app-sidebar ">
        <div class="app-sidebar__logo">
            <a class="header-brand" href="index.html">
                <img src="{{ asset('assets/logo/FixHR.png') }}" class="header-brand-img desktop-lgo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/logo/FixHR.png') }}" class="header-brand-img dark-logo" alt="FixingDotslogo">
                <img src="{{ asset('assets/logo/FixHR.png') }}" class="header-brand-img mobile-logo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/logo/FixHR.png') }}" class="header-brand-img darkmobile-logo"
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
                    <li class="side-item side-item-category mt-4">General</li>

                    {{-- @foreach ($SiderBarLoad as $item)

                    @php
                    $otherdetails= $Helper->sidebarMenu($Helper->patternViewDots($item->model_name));
                    @endphp
                    <?php
                //    if($Helper->patternViewDots($item->model_name)=='Dashboard'){ 
                //        print_r($otherdetails);
                       ?>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url($otherdetails->menu_link) }}">
                            <i class="feather feather-home sidemenu_icon"></i>
                            <span class="side-menu__label">{{$otherdetails->menu_name}}</span>
                        </a>
                    </li>
                    <?php //}?>
                    <?php //if($Helper->patternViewDots($item->model_name)=='Employee'){ ?>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url($otherdetails->menu_link) }}">
                            <i class="feather feather-users sidemenu_icon"></i>
                            <span class="side-menu__label">{{$otherdetails->menu_name}}</span>
                        </a>
                    </li>
                    <?php //}?>
                    @endforeach --}}
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/admin') }}">
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



                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/admin/attendance') }}">
                            <i class="feather feather-user-check sidemenu_icon"></i>
                            <span class="side-menu__label">Attendance</span>
                        </a>
                    </li>



                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-file-text sidemenu_icon"></i>
                            <span class="side-menu__label">Requests</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">
                            <li class="side-menu-label1"><a href="{{ url('/admin/leave') }}">Leave</a></li>

                            <li><a href="{{ url('/admin/requests/leaves') }}" class="slide-item"> Leave </a></li>


                            <li><a href="{{ url('/admin/requests/misspunch') }}" class="slide-item"> Miss Punch </a>
                            </li>

                            <li><a href="{{ url('/admin/requests/gatepass') }}" class="slide-item"> Gate Pass</a></li>

                        </ul>
                    </li>


                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/admin/report') }}">
                            <i class="feather feather-flag sidemenu_icon"></i>
                            <span class="side-menu__label">Report</span>
                        </a>
                    </li>


                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-file-text sidemenu_icon"></i>
                            <span class="side-menu__label">Role & Permission</span><i
                                class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">

                            <li><a href="{{ url('Role-permission/role_permission') }}" class="slide-item"> Role &
                                    Permission List </a></li>



                            <li><a href="{{ url('/Role-permission/admin-list') }}" class="slide-item"> Admin List </a>
                            </li>

                        </ul>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-settings sidemenu_icon"></i>
                            <span class="side-menu__label">Settings</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">

                            <li class="side-menu-label1"><a href="{{ url('settings/attendancesetting') }}">Attendance
                                    Setting</a></li>

                            <li><a href="{{ url('admin/settings/attendance') }}" class="slide-item"> Attendance
                                    Setting</a></li>

                            <li><a href="{{ url('admin/settings/business') }}" class="slide-item"> Business Setting</a>
                            </li>

                            <li><a href="{{ url('admin/settings/account') }}" class="slide-item"> Account Setting </a>
                            </li>

                            <li><a href="{{ url('admin/settings/localization') }}" class="slide-item"> Localization
                                    Setting </a></li>

                            <li><a href="{{ url('admin/settings/notification') }}" class="slide-item"> Notification
                                    Setting </a></li>

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