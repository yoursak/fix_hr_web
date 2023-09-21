<!doctype html>

<html lang="en">

<head>
    <title>FixHR - @yield('title')</title>

    <script src="{{ config('app.cdn') }}"></script>
    @include('auth/admin/authlayout.head')
    @yield('css')
</head>

<body>

    @include('sweetalert::alert')
    <div class="auth-wrapper">

        <div class="auth-content text-center">
            @yield('contentes')
            @yield('content')
        </div>

        <svg width="100%" height="250px" version="1.1" xmlns="http://www.w3.org/2000/svg" class="wave bg-wave">
            <title>Wave</title>
            <defs></defs>
            <path id="feel-the-wave" d="" />
        </svg>
        <svg width="100%" height="250px" version="1.1" xmlns="http://www.w3.org/2000/svg" class="wave bg-wave">
            <title>Wave</title>
            <defs></defs>
            <path id="feel-the-wave-two" d="" />
        </svg>
        <svg width="100%" height="250px" version="1.1" xmlns="http://www.w3.org/2000/svg" class="wave bg-wave">
            <title>Wave</title>
            <defs></defs>
            <path id="feel-the-wave-three" d="" />
        </svg>
    </div>

    @yield('js')

    <script src="{{asset('wavetemplate/js/vendor-all.min.js')}}"></script>
    <script src="{{asset('wavetemplate/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('wavetemplate/js/waves.min.js')}}"></script>
    <script src="{{asset('wavetemplate/js/pages/TweenMax.min.js')}}"></script>
    <script src="{{asset('wavetemplate/js/pages/jquery.wavify.js')}}"></script>
    <script>
        $('#feel-the-wave').wavify({
            height: 100,
            bones: 3,
            amplitude: 90,
            color: 'rgba(72, 134, 255, 4)',
            speed: .25
        });
        $('#feel-the-wave-two').wavify({
            height: 70,
            bones: 5,
            amplitude: 60,
            color: 'rgba(72, 134, 255, .3)',
            speed: .35
        });
        $('#feel-the-wave-three').wavify({
            height: 50,
            bones: 4,
            amplitude: 50,
            color: 'rgba(72, 134, 255, .2)',
            speed: .45
        });
    </script>

</body>

</html>