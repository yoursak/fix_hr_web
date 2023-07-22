<div class="sticky">
    <aside class="app-sidebar ">
        <div class="app-sidebar__logo">
            <a class="header-brand" href="index.html">
                <img src={{ asset('assets/images/brand/logo.png') }} class="header-brand-img desktop-lgo"
                    alt="amansahulogo">
                <img src={{ asset('assets/images/brand/logo-white.png') }} class="header-brand-img dark-logo"
                    alt="amansahulogo">
                <img src={{ asset('assets/images/brand/favicon.png') }} class="header-brand-img mobile-logo"
                    alt="amansahulogo">
                <img src={{ asset('assets/images/brand/favicon1.png') }} class="header-brand-img darkmobile-logo"
                    alt="amansahulogo">
            </a>
        </div>
        <div class="app-sidebar3">
            <div class="main-menu">
                <div class="app-sidebar__user">
                    <div class="dropdown user-pro-body text-center">
                        <div class="user-pic">
                            <img src={{ asset('assets/images/users/16.jpg') }} alt="user-img"
                                class="avatar-xxl rounded-circle mb-1">
                        </div>
                        <div class="user-info">
                            <h5 class=" mb-2">Aman Kumar</h5>
                            <span class="text-muted app-sidebar__user-name text-sm">Laravel Developer</span>
                        </div>
                    </div>
                </div>
                <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                    </svg></div>
                <ul class="side-menu">
                    <li class="side-item side-item-category mt-4">Genral</li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/') }}">
                            <i class="feather feather-home  sidemenu_icon"></i>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/employee') }}">
                            <i class="feather feather-users sidemenu_icon"></i>
                            <span class="side-menu__label">Employee</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/attendance') }}">
                            <i class="feather feather-user-check sidemenu_icon"></i>
                            <span class="side-menu__label">Attendance</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-file-text sidemenu_icon"></i>
                            <span class="side-menu__label">Requests</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu">
                            <li class="side-menu-label1"><a href="{{ url('/leave') }}">Leave</a></li>
                            <li><a href="{{ url('/leave') }}" class="slide-item"> Leave </a></li>
                            <li><a href="{{ url('/misspunch') }}" class="slide-item"> Miss Punch </a></li>
                            <li><a href="{{ url('/gatepass') }}" class="slide-item"> Gate Pass</a></li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/payroll') }}">
                            <i class="feather feather-credit-card sidemenu_icon"></i>
                            <span class="side-menu__label">Payroll</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/onlinepay') }}">
                            <i class="feather feather-dollar-sign sidemenu_icon"></i>
                            <span class="side-menu__label">Online Pay</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/report') }}">
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
                        <a class="side-menu__item" href="{{ url('/setting') }}">
                            <i class="feather feather-settings sidemenu_icon"></i>
                            <span class="side-menu__label">Settings</span>
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
