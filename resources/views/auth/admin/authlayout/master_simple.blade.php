<!doctype html>

<html lang="en">

<head>
    <title>FixHR - @yield('title')</title>
    @include('auth/admin/authlayout.head_simple')
    @yield('css')
    @livewireStyles

    <script src="{{ config('app.cdn') }}"></script>
</head>

<body>

    @include('sweetalert::alert')
    <div class="auth-wrapper">
        @yield('content')
    </div>

    @yield('js')

    <!-- JQUERY JS -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <!-- BOOTSTRAP JS-->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- SELECT2 JS -->
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

    <!-- P-SCROLL JS -->
    {{-- <script src="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script> --}}

    <!--STICKY JS -->
    <script src="{{ asset('assets/js/sticky.js') }}"></script>

    <!-- COLOR THEME JS-->
    <script src="{{ asset('assets/js/themeColors.js') }}"></script>

    <!-- CUSTOM JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- SWITCHER -->
    <script src="{{ asset('assets/switcher/js/switcher.js') }}"></script>

    <!-- INTERNAL FORM ADVANCED ELEMENT JS -->
    {{-- <script src="{{ asset('assets/js/formelementadvnced.js') }}"></script> --}}
    <script src="{{ asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

    <!-- INTERNAL FILE-UPLOADS JS -->
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!-- INTERNAL FILE-UPLOADS JS -->
    <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ asset('assets/js/filupload.js') }}"></script>
    @livewireScripts

</body>

</html>