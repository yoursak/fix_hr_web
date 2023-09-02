<div class="sticky">
    @php
        $Sidebar = App\Helpers\Layout::SidebarList();
        $SidebarMenu = App\Helpers\Layout::SidebarMenu();
        // dd($SidebarMenu);
    @endphp
    <aside class="app-sidebar ">
        <div class="app-sidebar__logo">
            <a class="header-brand" href="index.html">
                <img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img desktop-lgo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/images/brand/logo-white.png') }}" class="header-brand-img dark-logo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/images/brand/favicon.png') }}" class="header-brand-img mobile-logo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/images/brand/favicon1.png') }}" class="header-brand-img darkmobile-logo"
                    alt="FixingDotslogo">
            </a>
        </div>
        <div class="app-sidebar3">
            <div class="main-menu">
                <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                    </svg></div>
                {{-- <ul class="side-menu">
                    <li class="side-item side-item-category mt-4">General</li>
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
                        <a class="side-menu__item" href="{{ url('/help') }}">
                            <i class="feather feather-headphones sidemenu_icon"></i>
                            <span class="side-menu__label">Help & Support</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-settings sidemenu_icon"></i>
                            <span class="side-menu__label">Settings</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">
                            <li class="side-menu-label1"><a href="{{ url('settings/attendancesetting') }}">Attendance
                                    Setting</a></li>
                            <li><a href="{{ url('admin/settings/attendance') }}" class="slide-item"> Attendance
                                    Setting </a></li>
                            <li><a href="{{ url('admin/settings/business') }}" class="slide-item"> Business Setting
                                </a></li>
                            <li><a href="{{ url('admin/settings/businessinfo') }}" class="slide-item"> Business Info
                                    Setting </a></li>
                            <li><a href="{{ url('admin/settings/account') }}" class="slide-item"> Account Setting </a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="" data-bs-toggle="modal" data-bs-target="#LogoutModal">
                            <i class="fe fe-log-out sidemenu_icon"></i>
                            <span class="side-menu__label">Log Out</span>
                        </a>
                    </li>
                </ul> --}}
                <ul class="side-menu">
                    @foreach ($Sidebar as $item)
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                                <i class="{{$item->side_icon}} sidemenu_icon"></i>
                                <span class="side-menu__label">{{$item->sidebar_title}}</span><i
                                    class="angle fa fa-angle-right"></i>
                            </a>
                            <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">
                                <li class="side-menu-label1"><a href="{{ url('/admin/leave') }}">Leave</a></li>
                                @foreach ($SidebarMenu->where('sidebar_id',$item->bar_id) as $menu)
                                <li><a href="{{ url($menu->menu_link) }}" class="slide-item"> {{$menu->menu_name}} </a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/help') }}">
                            <i class="feather feather-headphones sidemenu_icon"></i>
                            <span class="side-menu__label">Help & Support</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="" data-bs-toggle="modal" data-bs-target="#LogoutModal">
                            <i class="fe fe-log-out sidemenu_icon"></i>
                            <span class="side-menu__label">Log Out</span>
                        </a>
                    </li>
                </ul>
                <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                    </svg></div>
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
                <a class="btn btn-danger px-5" href="{{ url('logout') }}">Log Out</a>
                <a aria-label="Close" class="btn btn-primary px-5 text-white" data-bs-dismiss="modal">Stay
                    Logedin</a>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->
