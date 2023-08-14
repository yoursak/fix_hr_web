<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a class="header-brand" href="index.html">
                <img src={{ asset("assets/images/brand/logo.png")}} class="header-brand-img desktop-lgo"
                    alt="FixingDotslogo">
                <img src={{ asset("assets/images/brand/logo-white.png")}} class="header-brand-img dark-logo"
                    alt="FixingDotslogo">
                <img src={{ asset("assets/images/brand/favicon.png")}} class="header-brand-img mobile-logo"
                    alt="FixingDotslogo">
                <img src={{ asset("assets/images/brand/favicon1.png")}} class="header-brand-img darkmobile-logo"
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
            <div class="mt-0">
                <form class="form-inline">
                    <div class="search-element">
                        <input type="search" class="form-control header-search" placeholder="Search…"
                            aria-label="Search" tabindex="1">
                        <button class="btn btn-primary-color">
                            <i class="feather feather-search"></i>
                        </button>
                    </div>
                </form>
            </div><!-- SEARCH -->
            <div class="d-flex order-lg-2 my-auto ms-auto">
                <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                </button>
                <div
                    class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex ms-auto">
                            <a class="nav-link  icon p-0 nav-link-lg d-lg-none navsearch"
                                href="javascript:void(0);" data-bs-toggle="search">
                                <i class="feather feather-search search-icon header-icon"></i>
                            </a>
                            <div class="dropdown  d-flex">
                                <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                    <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                    <span class="light-layout"><i class="fe fe-sun"></i></span>
                                </a>
                            </div>
                            <div class="dropdown header-flags">
                                <a class="nav-link icon" data-bs-toggle="dropdown">
                                    <img src={{ asset("assets/images/flags/flag-png/india.png")}}
                                        class="h-24" alt="img">
                                </a>
                            </div>
                            <div class="dropdown header-fullscreen">
                                <a class="nav-link icon full-screen-link">
                                    <i
                                        class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
                                    <i
                                        class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
                                </a>
                            </div>

                            <div class="dropdown header-notify">
                                <a class="nav-link icon" data-bs-toggle="sidebar-right"
                                    data-bs-target=".sidebar-right">
                                    <i class="feather feather-bell header-icon"></i>
                                    <span class="bg-dot"></span>
                                </a>
                            </div>
                            <div class="dropdown header-notify my-auto">
                                <h6 class="mx-2">Admin</h6>
                            </div>
                            <div class="dropdown profile-dropdown">
                                <a href="javascript:void(0);" class="nav-link pe-1 ps-0 leading-none"
                                    data-bs-toggle="dropdown">
                                    <span>
                                        <img src={{ asset("assets/images/users/16.jpg")}} alt="img"
                                            class="avatar avatar-md rounded-circle">
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
                                    <a class="dropdown-item d-flex" href="profile1.html">
                                        <i class="feather feather-user me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">Profile</div>
                                    </a>
                                    <a class="dropdown-item d-flex" href="editprofile.html">
                                        <i class="feather feather-settings me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">Settings</div>
                                    </a>
                                    </a>
                                    <a class="dropdown-item d-flex" href="login1.html">
                                        <i class="feather feather-power me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">Sign Out</div>
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
