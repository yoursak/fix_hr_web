<?php use App\Helpers\Central_unit;
$Helper = new Central_unit();
?>
<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a class="header-brand" href="index.html">
                <img src={{ asset('assets/images/brand/logo.png') }} class="header-brand-img desktop-lgo"
                    alt="FixingDotslogo">
                <img src={{ asset('assets/images/brand/logo-white.png') }} class="header-brand-img dark-logo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/logo/FixHR.png?v=0.1') }}" class="header-brand-img mobile-logo"
                    alt="FixingDotslogo">
                <img src="{{ asset('assets/logo/FixHR.png?v=0.1') }}" class="header-brand-img darkmobile-logo"
                    alt="FixingDotslogo">
            </a>
            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="javascript:void(0);">
                    <i class="feather feather-menu"></i>
                </a>
                <a class="close-toggle" href="javascript:void(0);">
                    <i class="feather feather-x"></i>
                </a>
            </div>
            <div class="d-flex order-lg-1 my-auto ms-auto">
                {{-- <div class="d-flex me-auto">
                    <div class="me-3 mt-0 mt-sm-1 d-block text-center">
                        <h6 class="fs-18 mb-0"><b>Welcome to FixHR Admin Dashboard.</b></h6>
                        <p class="text-muted mt-0 fs-12">Your Lats Login is 26/08/2023 : 01:05 pm</p>
                    </div>
                </div> --}}
                <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                </button>
                <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex ms-auto">
                            <div class="dropdown  d-flex">
                                <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                    <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                    <span class="light-layout"><i class="fe fe-sun"></i></span>
                                </a>
                            </div>
                            <div class="dropdown header-flags">
                                <a class="nav-link icon" data-bs-toggle="dropdown">
                                    <img src={{ asset('assets/images/flags/flag-png/india.png') }} class="h-24"
                                        alt="img">
                                </a>
                            </div>
                            <div class="dropdown header-fullscreen">
                                <a class="nav-link icon full-screen-link">
                                    <i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
                                    <i
                                        class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
                                </a>
                            </div>
                            <div class="dropdown header-notify">
                                <a class="nav-link icon" data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right">
                                    <i class="feather feather-bell header-icon"></i>
                                    <span class="bg-dot"></span>
                                </a>
                            </div>
                            <div class="d-flex" style="transform: translateX(20px);">

                                <div class="dropdown header-notify my-auto ms-5">
                                    <?php if(Session::has('business_id')){ ?>
                                    <div class="me-3 mt-0 mt-sm-1 d-block text-center">
                                        <span
                                            class="fs-14 mb-0"><b><?= $Helper->GenderCheck() != '' ? $Helper->GenderCheck() : '' ?>{{ Session::get('login_name') }}</b></span><br>
                                        <span class="text-muted mt-0">
                                            <b> <?= $Helper->RoleIdToName() ?></b>
                                        </span>
                                    </div>
                                    <?php }else{  ?>
                                    <div class="mt-0 mt-sm-1 d-block text-center">
                                        <span class="fs-14 mb-0">Login User</span><br>
                                        <span class="text-muted mt-0">Designation</span>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="dropdown profile-dropdown">
                                    <a href="javascript:void(0);" class="nav-link  ps-0 leading-none"
                                        data-bs-toggle="dropdown">
                                        <span>
                                            <img src="{{ asset('business_logo/' . Session::get('login_business_image')) }}"
                                                alt="img" class="avatar avatar-md rounded-circle">
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
                                        <a class="dropdown-item d-flex" href="profile1.html">
                                            <i class="feather feather-user me-3 fs-16 my-auto"></i>
                                            <div class="mt-1">Profile</div>
                                        </a>
                                        <a class="dropdown-item d-flex" href="{{ url('/subscription') }}">
                                            <i class="feather feather-award me-3 fs-16 my-auto"></i>
                                            <div class="mt-1">Upgrade</div>
                                        </a>
                                        <a class="dropdown-item d-flex" href="editprofile.html">
                                            <i class="feather feather-settings me-3 fs-16 my-auto"></i>
                                            <div class="mt-1">Settings</div>
                                        </a>
                                        </a>
                                        <a class="dropdown-item d-flex" href="{{ url('/logout') }}">
                                            <i class="feather feather-power me-3 fs-16 my-auto"></i>
                                            <div class="mt-1">Log Out</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
