<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta
        content="DayOne - It is one of the Major Dashboard Template which includes - HR, Employee and Job Dashboard. This template has multipurpose HTML template and also deals with Task, Project, Client and Support System Dashboard."
        name="description">
    <meta content="Spruko Technologies Private Limited" name="author">
    <meta name="keywords"
        content="admin dashboard, dashboard ui, backend, admin panel, admin template, dashboard template, admin, bootstrap, laravel, laravel admin panel, php admin panel, php admin dashboard, laravel admin template, laravel dashboard, laravel admin panel" />

    <!-- TITLE -->
    <title> FixHR Login</title>

    <!--FAVICON -->
    <link rel="icon" href="assets/images/brand/favicon.ico" type="image/x-icon" />

    <!-- BOOTSTRAP CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/plugins.css" rel="stylesheet" />

    <!-- ANIMATE CSS -->
    <link href="assets/css/animated.css" rel="stylesheet" />

    <!---ICONS CSS -->
    <link href="assets/plugins/icons/icons.css" rel="stylesheet" />


    <!-- INTERNAL SWITCHER CSS -->
    <link href="assets/switcher/css/switcher.css" rel="stylesheet" />
    <link href="assets/switcher/demo.css" rel="stylesheet" />
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assetss/images/favicon.png" type="image/x-icon') }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assetss/css/style.css') }}">
</head>

<!-- [ auth-signin ] start -->

<div class="auth-wrapper">
    <div class="auth-content text-center">
        <div class="card">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" class="img-fluid mb-4">
                        <h1 class="h3  mb-3">Welcome to <span style="color: black"><b>FIX<span
                                        style="color: #0000ff">HR</span></b></span></h1>
                        <p class="h5 font-weight-normal mb-4 leading-normal">Make Your Human Resource Online</p>
                        <h4 class="mb-3 f-w-400">Signin</h4>
                        <form method="POST" action="{{ route('login.otp') }}">
                            @csrf
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Email address" name="email"
                                    required>
                            </div>
                            <div class="text-start">
                                @if (Session::has('Fail'))
                                <span class="text-danger fs-14"><i class="fa fa-warning mx-1"></i>{{ Session::get('Fail') }}</span>
                            @endif
                            </div>
                            <button class="btn btn-block btn-primary mt-3 mb-4 rounded" style="background-color:#0000ff"
                                type="submit">Send OTP</button>
                        </form>
                        <p class="mb-0 text-muted">Don’t have an account? <a href="{{ url('/admin/signup') }}"
                                class="f-w-400" style="color: #0000ff">Signup</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <div class="saprator my-2"><span>OR</span></div>
            <button class="btn text-white bg-facebook mb-2 mr-2  wid-40 px-0 hei-40 rounded-circle"><i
                    class="fab fa-facebook-f"></i></button>
            <button class="btn text-white bg-googleplus mb-2 mr-2 wid-40 px-0 hei-40 rounded-circle"><i
                    class="fab fa-google-plus-g"></i></button>
            <button class="btn text-white bg-twitter mb-2  wid-40 px-0 hei-40 rounded-circle"><i
                    class="fab fa-twitter"></i></button>
        </div>
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
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="{{ asset('assetss/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assetss/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assetss/js/waves.min.js') }}"></script>
<script src="{{ asset('assetss/js/pages/TweenMax.min.js') }}"></script>
<script src="{{ asset('assetss/js/pages/jquery.wavify.js') }}"></script>
<!-- JQUERY JS -->
<script src="assets/plugins/jquery/jquery.min.js"></script>

<!-- BOOTSTRAP JS-->
<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- SELECT2 JS -->
<script src="assets/plugins/select2/select2.full.min.js"></script>

<!-- P-SCROLL JS -->
<script src="assets/plugins/p-scrollbar/p-scrollbar.js"></script>

<!--STICKY JS -->
<script src="assets/js/sticky.js"></script>

<!-- COLOR THEME JS-->
<script src="assets/js/themeColors.js"></script>

<!-- CUSTOM JS -->
<script src="assets/js/custom.js"></script>

<!-- SWITCHER -->
<script src="assets/switcher/js/switcher.js"></script>
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
