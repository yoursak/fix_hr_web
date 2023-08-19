<div class="sticky">
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
                <ul class="side-menu">
                    <li class="side-item side-item-category mt-4">General</li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/admin') }}">
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
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">
                            <li class="side-menu-label1"><a href="{{ url('/leave') }}">Leave</a></li>
                            <li><a href="{{ url('/leave') }}" class="slide-item"> Leave </a></li>
                            <li><a href="{{ url('/misspunch') }}" class="slide-item"> Miss Punch </a></li>
                            <li><a href="{{ url('/gatepass') }}" class="slide-item"> Gate Pass</a></li>
                        </ul>
                    </li>

                    {{-- Temprarly Commented By Aman Sahu (Do not remove) --}}

                    {{-- <li class="slide">
                        <a class="side-menu__item" href="{{ url('/payroll') }}">
                            <i class="feather feather-credit-card sidemenu_icon"></i>
                            <span class="side-menu__label">Payroll</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/onlinepay') }}">
                            <i class="fa fa-inr sidemenu_icon"></i>
                            <span class="side-menu__label">Online Pay</span>
                        </a>
                    </li> --}} 


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
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="feather feather-settings sidemenu_icon"></i>
                            <span class="side-menu__label">Settings</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu" style="background-color:  #1034A6; border-radius:7px;">
                            <li class="side-menu-label1"><a href="{{ url('settings/attendancesetting') }}">Attendance
                                    Setting</a></li>
                            <li><a href="{{ url('settings/attendancesetting') }}" class="slide-item"> Attendance
                                    Setting </a></li>
                            <li><a href="{{ url('settings/businesssetting') }}" class="slide-item"> Business Setting
                                </a></li>
                            {{-- <li><a href="{{ url('settings/salarysetting') }}" class="slide-item"> Salary Setting </a>
                            </li> --}}
                            <li><a href="{{ url('settings/businessinfosetting') }}" class="slide-item"> Business Info
                                    Setting </a></li>
                            <li><a href="{{ url('setting/') }}" class="slide-item"> Account Setting </a></li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/') }}">
                            <i class="fe fe-log-out sidemenu_icon"></i>
                            <span class="side-menu__label">Log Out</span>
                        </a>
                    </li>
                </ul>
                {{-- <nav class="tree-nav default">
                    <ul class="main-items">
                        <li data-type="folder">
                            <a href="#1"> Main Item 1 </a>
                            <ul class="sub-items">
                                <li data-type="folder">
                                    <a href="#1"> sub Item 1</a>
                                    <ul class="sub-items">
                                        <li data-type="folder">
                                            <a href="#1"> sub Item 1.1</a>
                                            <ul class="sub-items">
                                                <li><a href="#1"> sub Item 1.1.1</a>
                                                </li>
                                                <li><a href="#1"> sub Item 1.1.2</a></li>
                                                <li data-type="folder">
                                                    <a href="#1"> sub Item 1.1.3</a>
                                                    <ul>
                                                        <li><a href="#1">Item 1.1.3.1 </a> </li>
                                                        <li><a href="#1">Item 1.1.3.2 </a> </li>
                                                        <li><a href="#1">Item 1.1.3.3</a> </li>
                                                    </ul>
                                                </li>
                                                <li><a href="#1"> sub Item 1.1.4 </a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#1"> <i class="fa fa-file-text"></i> sub Item 1.2 </a></li>
                                        <li><a href="#1"> <i class="fa fa-file-text"></i> sub Item 1.3 </a></li>
                                        <li><a href="#1"> <i class="fa fa-file-text"></i> sub Item 1.4 </a></li>
                                    </ul>
                                </li>
                                <li> <a href="#1"> sub Item 2</a></li>
                                <li><a href="#1"> sub Item 3</a></li>
                                <li><a href="#1"> sub Item 4</a></li>
                            </ul>
                        </li>
                        <li data-type="folder">
                            <a href="#1"> Main Item 2 </a>
                            <ul>
                                <li><a href="#1"> Sub Item 2.1</a> </li>
                                <li><a href="#1"> Sub Item 2.2 </a> </li>
                                <li><a href="#1"> Sub Item 2.3</a> </li>
                            </ul>
                        </li>
                        <li data-type="folder">
                            <a href="#1"> Main Item 3</a>
                            <ul>
                                <li><a href="#1"> Sub Item 2.1</a> </li>
                                <li><a href="#1"> Sub Item 2.2 </a> </li>
                                <li><a href="#1"> Sub Item 2.3</a> </li>
                            </ul>
                        </li>
                        <li data-type="folder">
                            <a href="#1"> Main Item 4</a>
                            <ul>
                                <li><a href="#1"> Sub Item 4.1</a> </li>
                                <li data-type="folder">
                                    <a href="#1"> Sub Item 4.2 </a>
                                    <ul>
                                        <li><a href="#1"> <i class="fa fa-file-text"></i> Sub Item 4.2.1</a>
                                        </li>
                                        <li><a href="#1"> <i class="fa fa-file-text"></i> Sub Item 4.2.2 </a>
                                        </li>
                                        <li><a href="#1"> <i class="fa fa-file-text"></i> Sub Item 4.2.3</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="#1"> Sub Item 4.3</a> </li>
                                <li><a href="#1"> Sub Item 4.4</a> </li>
                                <li><a href="#1"> Sub Item 4.5</a> </li>
                            </ul>
                        </li>
                        <li data-type="folder">
                            <a href="#1"> Main Item 5</a>
                            <ul>
                                <li><a href="#1"> Sub Item 5.1</a> </li>
                                <li><a href="#1"> Sub Item 5.2 </a> </li>
                                <li data-type="folder">
                                    <a href="#1"> Sub Item 5.3</a>
                                    <ul>
                                        <li><a href="#1"> <i class="fa fa-file-text"></i> Item 5.3.1 </a> </li>
                                        <li><a href="#1"> <i class="fa fa-file-text"></i> Item 5.3.2 </a> </li>
                                        <li><a href="#1"> <i class="fa fa-file-text"></i> Item 5.3.3</a> </li>
                                    </ul>
                                </li>
                                <li><a href="#1"> Sub Item 5.4</a> </li>
                                <li><a href="#1"> Sub Item 5.5</a> </li>
                                <li><a href="#1"> Sub Item 5.6</a> </li>
                            </ul>
                        </li>
                    </ul>
                </nav> --}}
                <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                    </svg></div>
            </div>
        </div>
    </aside>
</div>
