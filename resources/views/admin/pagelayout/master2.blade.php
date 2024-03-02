<!DOCTYPE html>
<html lang="en" dir="ltr">
<!-- using search with filters supports dropdown -->

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta content="" name="description">
    <meta content="" name="author">
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title>FixHR - @yield('title')</title>

    {{-- @laravelViewsStyles --}}
    @livewireStyles
    <!--sweet alert-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

    <!-- FAVICON  QA Changes-->
    <link rel="icon" href="{{ asset('assets/logo/f_fav.ico') }}" type="image/x-icon" />
    <!-- BOOTSTRAP CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" wire:ignore />
    <!-- STYLE CSS -->
    <link href="{{ asset('assets/css/style.css?v=3.2') }}" rel="stylesheet" wire:ignore />
    <!-- Custome Models Load -->
    <link href="{{ asset('assets/css/customeModel.css?v=3.1') }}" rel="stylesheet" wire:ignore />

    <link href="{{ asset('assets/css/plugins.css?v=1.5') }}" rel="stylesheet" wire:ignore />
    <!-- ANIMATE CSS -->
    <link href="{{ asset('assets/css/animated.css') }}" rel="stylesheet" wire:ignore />
    <!---ICONS CSS -->
    <link href="{{ asset('assets/plugins/icons/icons.css') }}" rel="stylesheet" wire:ignore />


    <!-- INTERNAL SWITCHER CSS -->
    <link href="{{ asset('assets/switcher/css/switcher.css') }}" rel="stylesheet" wire:ignore />
    <link href="{{ asset('assets/switcher/demo.css') }}" rel="stylesheet" wire:ignore />

    <!-- Add external css -->
    <link href="{{ asset('assets/plugins/jQuerytransfer/icon_font/icon_font.css') }}" rel="stylesheet" wire:ignore />

    <!----hatasactahy -->
    @yield('css')
</head>

<body class="app sidebar-mini ltr">
    @include('sweetalert::alert')
    <style>
        body *::-webkit-scrollbar-thumb,
        body *:hover::-webkit-scrollbar-thumb {
            /* color: #f1f4fb; */
            background: #1877f2;
        }

        body *::-webkit-scrollbar {
            width: 5px;
            height: 8px;
            -webkit-transition: 0.3s;
            transition: 0.3s;
        }

        /* span[aria-hidden="true"] {
            color: white;
        } */
        tr {
            line-height: 1.5;
        }
    </style>
    <!-- SWITCHER -->
    <div class="switcher-wrapper">
        <div class="demo_changer">
            <div class="form_holder sidebar-right1">
                <div class="row">
                    <div class="predefined_styles">
                        <div class="swichermainleft text-center">
                            <div class="p-3">
                                <a href="" class="btn ripple btn-primary btn-block mt-0" target="blank">View
                                    Demo</a>
                                <a href="" class="btn ripple btn-secondary btn-block">Buy Now</a>
                                <a href="" class="btn ripple btn-red btn-block">Our Portfolio</a>
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
                                            src={{ asset('assets/images/photos/bg-img1.jpg') }} alt="Bg-Image"
                                            id="bgimage1"></a>
                                    <a class="bg-img2" href="javascript:void(0);"><img
                                            src={{ asset('assets/images/photos/bg-img2.jpg') }} alt="Bg-Image"
                                            id="bgimage2"></a>
                                    <a class="bg-img3" href="javascript:void(0);"><img
                                            src={{ asset('assets/images/photos/bg-img3.jpg') }} alt="Bg-Image"
                                            id="bgimage3"></a>
                                    <a class="bg-img4" href="javascript:void(0);"><img
                                            src={{ asset('assets/images/photos/bg-img4.jpg') }} alt="Bg-Image"
                                            id="bgimage4"></a>
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
        <img src={{ asset('imgs/loader.gif?v=0.0.1') }} alt="loader">
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

                <div class="side-app main-container pt-3">

                    <!-- PAGE HEADER -->
                    @include('admin.layout.breadcrumb')
                    <!-- END PAGE HEADER -->

                    {{-- MAIN CONTENT --}}
                    @yield('content')
                    {{-- END MAIN CONTENT --}}
                </div>
            </div><!-- end app-content-->
        </div>

        @livewireScripts
        <!-- FOOTER -->
        @include('admin.layout.footer')
        <!-- END FOOTER -->

    </div>
    @yield('js')

    <!-- BACK TO TOP -->
    <a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>
    <!-- BACK TO TOP -->

    <!-- New Url Modified set BY JAYANT template bug fixied change overwrite set JS -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}" type="text/javascript" wire:ignore></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" wire:ignore></script>

    <!-- MOMENT JS -->
    <script src="{{ asset('assets/plugins/moment/moment.js') }}" wire:ignore></script>

    <!-- CIRCLE-PROGRESS JS -->
    <script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}" wire:ignore></script>

    <!--SIDEMENU JS -->
    <script src="{{ asset('assets/plugins/sidemenu/sidemenu.js') }}" wire:ignore></script>

    <!-- P-SCROLL JS -->
    <script src="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/p-scrollbar/p-scroll1.js') }}" wire:ignore></script>

    <!--SIDEBAR JS -->
    <script src="{{ asset('assets/plugins/sidebar/sidebar.js') }}" wire:ignore></script>

    <!-- SELECT2 JS -->
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}" wire:ignore></script>

    <!-- INTERNAL TIMEPICKER JS -->
    <script src="{{ asset('assets/plugins/time-picker/jquery.timepicker.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/time-picker/toggles.min.js') }}" wire:ignore></script>


    <!-- INTERNAL DATEPICKER JS -->
    <script src="{{ asset('assets/plugins/date-picker/date-picker.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.maskedinput.js') }}" wire:ignore></script>


    <!-- INTERNAL FILE-UPLOADS JS -->
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js') }}" wire:ignore></script>


    <!-- INTERNAL FILE-UPLOADS JS -->
    <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/js/filupload.js') }}" wire:ignore></script>

    <!-- INTERNAL SUMOSELECT JS -->
    <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}" wire:ignore></script>

    <!-- INTERNAL INTLTELINPUT JS -->
    <script src="{{ asset('assets/plugins/intl-tel-input-master/intlTelInput.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/intl-tel-input-master/country-select.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/intl-tel-input-master/utils.js') }}" wire:ignore></script>

    <!-- INTERNAL JQUERY TRANSFER JS -->
    <script src="{{ asset('assets/plugins/jQuerytransfer/jquery.transfer.js') }}" wire:ignore></script>

    <!-- INTERNAL MULTI JS -->
    <script src="{{ asset('assets/plugins/multi/multi.min.js') }}" wire:ignore></script>

    <!-- INTERNAL BOOTSTRAP-DATEPICKER JS -->
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}" wire:ignore></script>

    <!-- INTERNAL FORM ADVANCED ELEMENT JS -->
    <script src="{{ asset('assets/js/formelementadvnced.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/js/form-elements.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/js/select2.js') }}" wire:ignore></script>

    <!-- INTERNAL MULTIPLE SELECT JS -->
    <script src="{{ asset('assets/plugins/multipleselect/multiple-select.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/multipleselect/multi-select.js') }}" wire:ignore></script>

    <!-- STICKY JS -->
    <script src="{{ asset('assets/js/sticky.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/js/tooltip.js?0.2') }}" wire:ignore></script>

    <!-- COLOR THEME JS  -->
    <script src="{{ asset('assets/js/themeColors.js') }}" wire:ignore></script>

    <!-- CUSTOM JS -->
    <script src="{{ asset('assets/js/custom.js?v=0.6') }}" wire:ignore></script>
    <!-- SWITCHER JS -->
    <script src="{{ asset('assets/switcher/js/switcher.js') }}" wire:ignore></script>

    <!-- Other url external additional added in modifeid set -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" wire:ignore></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"  wire:ignore></script> ignor --}}
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js" wire:ignore></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js" wire:ignore></script>
    <!-- INTERNAl BOOTATRAP-TIMEPICKER JS -->
    <script src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js') }}" wire:ignore></script>

    <!-- INTERNAL INDEX JS -->
    <script src="{{ asset('assets/js/hr/hr-attlist.js') }}" wire:ignore></script>

    {{-- external link used by js script use at sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" wire:ignore></script>

    <!-- INTERNAL DATA TABLES -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}" wire:ignore></script>
    <script src="{{ asset('assets/js/datatables.js?v=0.7') }}" wire:ignore></script>
    <script src="{{ asset('assets/js/select2.js') }}" wire:ignore></script>
    {{-- <script src="assets/js/tooltip.js"  wire:ignore></script> --}}




</body>

</html>
