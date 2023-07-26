<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- Mirrored from laravelui.spruko.com/FixingDots/index2 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 18 Jul 2023 06:20:41 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    @include('admin.layout.head')
    @yield('css')
</head>

<body class="app sidebar-mini ltr">

    <!-- SWITCHER -->
    <div class="switcher-wrapper">
        <div class="demo_changer">
            <div class="form_holder sidebar-right1">
                <div class="row">
                    <div class="predefined_styles">
                        <div class="swichermainleft text-center">
                            <div class="p-3">
                                <a href="index-2.html" class="btn ripple btn-primary btn-block mt-0" target="blank">View
                                    Demo</a>
                                <a href="https://themeforest.net/item/FixingDots-laravel-admin-dashboard-template/33043521"
                                    class="btn ripple btn-secondary btn-block">Buy Now</a>
                                <a href="https://themeforest.net/user/spruko/portfolio"
                                    class="btn ripple btn-red btn-block">Our Portfolio</a>
                            </div>
                        </div>
                        <div class="swichermainleft mb-0">
                            <h4>Navigation Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-4">
                                        <span class="me-auto">Vertical Menu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch15"
                                                id="myonoffswitch34" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch34" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Horizontal Click Menu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch15"
                                                id="myonoffswitch35" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch35" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Horizontal Hover Menu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch15"
                                                id="myonoffswitch111" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch111" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft mb-0">
                            <h4>LTR AND RTL VERSIONS</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-4">
                                        <span class="me-auto">LTR</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch5"
                                                id="myonoffswitch54" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch54" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">RTL</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch5"
                                                id="myonoffswitch55" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch55" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Light Theme Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto mt-2">Light Theme</span>
                                        <p class="onoffswitch2"><input type="radio" name="onoffswitch1"
                                                id="myonoffswitch1" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch1" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto mt-2">Light Primary</span>
                                        <div class="">
                                            <input class="input-color-picker color-primary-light" value="#6c5ffc"
                                                id="colorID" type="color" data-id="bg-color" data-id1="bg-hover"
                                                data-id2="bg-border" data-id7="transparentcolor" name="lightPrimary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Dark Theme Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto mt-2">Dark Theme</span>
                                        <p class="onoffswitch2"><input type="radio" name="onoffswitch1"
                                                id="myonoffswitch2" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch2" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto  mt-2">Dark Primary</span>
                                        <div class="">
                                            <input class=" input-dark-color-picker color-primary-dark" value="#6c5ffc"
                                                id="darkPrimaryColorID" type="color" data-id="bg-color"
                                                data-id1="bg-hover" data-id2="bg-border" data-id3="primary"
                                                data-id8="transparentcolor" name="darkPrimary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Transparent Theme Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto  mt-2">Transparent Theme</span>
                                        <p class="onoffswitch2"><input type="radio" name="onoffswitch1"
                                                id="myonoffswitchTransparent" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitchTransparent" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto  mt-2">Transparent Primary</span>
                                        <div class="">
                                            <input
                                                class="w-30p h-30 input-transparent-color-picker color-primary-transparent"
                                                value="#6c5ffc" id="transparentPrimaryColorID" type="color"
                                                data-id="bg-color" data-id1="bg-hover" data-id2="bg-border"
                                                data-id3="primary" data-id4="primary" data-id9="transparentcolor"
                                                name="tranparentPrimary">
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto  mt-2">Transparent Background</span>
                                        <div class="">
                                            <input
                                                class="w-30p h-30 input-transparent-color-picker color-bg-transparent"
                                                value="#6c5ffc" id="transparentBgColorID" type="color"
                                                data-id5="body" data-id6="theme" data-id9="transparentcolor"
                                                name="transparentBackground">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Transparent Bg-Image Style</h4>
                            <div class="skin-body switch_section">
                                <div class="switch-toggle d-flex">
                                    <span class="me-auto ">Bg-Image Primary</span>
                                    <div class="">
                                        <input class="input-transparent-color-picker color-primary-transparent"
                                            value="#6c5ffc" id="transparentBgImgPrimaryColorID" type="color"
                                            data-id="bg-color" data-id1="bg-hover" data-id2="bg-border"
                                            data-id3="primary" data-id4="primary" data-id9="transparentcolor"
                                            name="tranparentPrimary">
                                    </div>
                                </div>
                                <div class="switch-toggle d-flex mt-2">
                                    <a class="bg-img1" href="javascript:void(0);"><img
                                            src={{ asset("assets/images/photos/bg-img1.jpg")}} alt="Bg-Image" id="bgimage1"></a>
                                    <a class="bg-img2" href="javascript:void(0);"><img
                                            src={{ asset("assets/images/photos/bg-img2.jpg")}} alt="Bg-Image" id="bgimage2"></a>
                                    <a class="bg-img3" href="javascript:void(0);"><img
                                            src={{ asset("assets/images/photos/bg-img3.jpg")}} alt="Bg-Image" id="bgimage3"></a>
                                    <a class="bg-img4" href="javascript:void(0);"><img
                                            src={{ asset("assets/images/photos/bg-img4.jpg")}} alt="Bg-Image" id="bgimage4"></a>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Leftmenu Layout width styles</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-4">
                                        <span class="me-auto">Default</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch2"
                                                id="myonoffswitch18" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch18" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Boxed</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch2"
                                                id="myonoffswitch19" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch19" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft leftmenu-styles">
                            <h4>Sidemenu Layout Versions</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Default Sidemenu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch8"
                                                id="myonoffswitch22" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch22" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Closed Sidemenu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch8"
                                                id="myonoffswitch23" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch23" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Hover Submenu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch8"
                                                id="myonoffswitch24" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch24" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Hover Submenu Style1</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch8"
                                                id="myonoffswitch30" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch30" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Icon Overlay</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch8"
                                                id="myonoffswitch25" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch25" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Icon Text</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch8"
                                                id="myonoffswitch29" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch29" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft  header-styles">
                            <h4>Header Styles Mode</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Light Header</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch7"
                                                id="background1" class="onoffswitch2-checkbox" checked>
                                            <label for="background1" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Color Header</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch7"
                                                id="background2" class="onoffswitch2-checkbox">
                                            <label for="background2" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Dark Header</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch7"
                                                id="background3" class="onoffswitch2-checkbox">
                                            <label for="background3" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Gradient Header</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch7"
                                                id="background11" class="onoffswitch2-checkbox">
                                            <label for="background11" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft  menu-styles">
                            <h4>Leftmenu Styles Mode</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Light Menu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch4"
                                                id="background4" class="onoffswitch2-checkbox">
                                            <label for="background4" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Color Menu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch4"
                                                id="background5" class="onoffswitch2-checkbox">
                                            <label for="background5" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Dark Menu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch4"
                                                id="background6" class="onoffswitch2-checkbox" checked>
                                            <label for="background6" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Gradient Menu</span>
                                        <div class="onoffswitch2"><input type="radio" name="onoffswitch4"
                                                id="background10" class="onoffswitch2-checkbox">
                                            <label for="background10" class="onoffswitch2-label"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Reset All Styles</h4>
                            <div class="skin-body">
                                <div class="switch_section my-4">
                                    <button class="btn btn-danger btn-block" id="resetAll" type="button">Reset All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SWITCHER -->
    <!--- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src={{ asset('imgs/loader.gif')}} alt="loader">
    </div>
    <!--- END GLOBAL-LOADER -->

    <div class="page">
        <div class="page-main">

            <!-- APP-HEADER -->
            @include('admin.layout.header')
            <!-- APP-HEADER CLOSED -->

            <!-- APP-SIDEBAR -->
            @include('admin.layout.sidebar')
            <!-- APP-SIDEBAR CLOSED -->

            <div class="app-content main-content mt-0">
                <div class="side-app main-container">

                    <!-- PAGE HEADER -->
                    @include('admin.layout.breadcrumb')
                    <!-- END PAGE HEADER -->


                    {{-- MAIN CONTENT --}}
                    @yield('contents')
                    {{-- END MAIN CONTENT --}}
                </div>
            </div><!-- end app-content-->
        </div>

        <!-- FOOTER -->
        @include('admin.layout.footer')
        <!-- END FOOTER -->

    </div>

    <!-- BACK TO TOP -->
    <a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>

    @yield('script')
    @include('admin.layout.script')
</body>

<!-- Mirrored from laravelui.spruko.com/FixingDots/index2 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 18 Jul 2023 06:20:43 GMT -->

</html>
