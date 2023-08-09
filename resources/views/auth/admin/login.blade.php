<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- Developed from Aman sahu  by Aman Sahu [XR&CO'2014], Tue, 18 Jul 2023 06:22:37 GMT -->
<!-- Added by FixingDots-->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by FixingDots-->

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta
        content="DayOne - It is one of the Major Dashboard Template which includes - HR, Employee and Job Dashboard. This template has multipurpose HTML template and also deals with Task, Project, Client and Support System Dashboard."
        name="description">
    <meta content="Spruko Technologies Private Limited" name="author">
    <meta name="keywords"
        content="admin dashboard, dashboard ui, backend, admin panel, admin template, dashboard template, admin, bootstrap, laravel, laravel admin panel, php admin panel, php admin dashboard, laravel admin template, laravel dashboard, laravel admin panel" />

    <!-- TITLE -->
    <title> Dayone - Laravel Multipurpose Admin & Dashboard Template</title>

    <!--FAVICON -->
    <link rel="icon" href="{{ asset('assets/images/brand/favicon.ico') }}" type="image/x-icon" />

    <!-- BOOTSTRAP CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" />

    <!-- ANIMATE CSS -->
    <link href="{{ asset('assets/css/animated.css') }}" rel="stylesheet" />

    <!---ICONS CSS -->
    <link href="{{ asset('assets/plugins/icons/icons.css') }}" rel="stylesheet" />


    <!-- INTERNAL SWITCHER CSS -->
    <link href="{{ asset('assets/switcher/css/switcher.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/switcher/demo.css') }}" rel="stylesheet" />
     <style>
        // best seen at 1500px or less

html, body { height: 100%; }
body {
  background:radial-gradient(ellipse at center, rgba(255,254,234,1) 0%, rgba(255,254,234,1) 35%, #B7E8EB 100%);
  overflow: hidden;
}

.ocean {
  height: 5%;
  width:100%;
  position:absolute;
  bottom:0;
  left:0;
  background: #015871;
}

.wave {
  background: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/85486/wave.svg) repeat-x;
  position: absolute;
  top: -198px;
  width: 6400px;
  height: 198px;
  animation: wave 7s cubic-bezier( 0.36, 0.45, 0.63, 0.53) infinite;
  transform: translate3d(0, 0, 0);
}

.wave:nth-of-type(2) {
  top: -175px;
  animation: wave 7s cubic-bezier( 0.36, 0.45, 0.63, 0.53) -.125s infinite, swell 7s ease -1.25s infinite;
  opacity: 1;
}

@keyframes wave {
  0% {
    margin-left: 0;
  }
  100% {
    margin-left: -1600px;
  }
}

@keyframes swell {
  0%, 100% {
    transform: translate3d(0,-25px,0);
  }
  50% {
    transform: translate3d(0,5px,0);
  }
}
     </style>

</head>

<body class="login-img">

    <div class="page responsive-log coming-bg">
        <div class="page-content p-7 m-0">
            <div class="container text-center">
                <span class="avatar avatar-xxl bradius" style="background-image: url(assets/images/users/8.jpg)"></span>
                <div class="display-4 mb-1 mt-3 font-weight-semibold">Welcome to <span style="color: #0000ff"><b><span style="color: #080808">Fix</span>HR</b></span>
                </div>
                <h1 class="h4">Make Your Human Resource Online</h1>
                <div class="coming-footer">
                    <form class="card-body pt-1" id="login" name="login">
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <label for="login" class="fw-bold">Enter Your Email</label>
                                <div class="input-group">
                                    <a href="#" class="input-group-text">
                                        <i class="fe fe-mail" aria-hidden="true"></i>
                                    </a>
                                    <input class="form-control" placeholder="eg. xyz@gmail.com">
                                </div>
                            </div>
                        </div>
                        <div class="submit">
                            <a class="btn btn-primary btn-block btn-lg" href="#">Login</a>
                        </div>
                        <div class="text-center mt-3">
                            <p class="text-dark mb-0">Don't have account?<a class="text-primary ms-1"
                                    href="javascript:void(0);">Register</a></p>
                        </div>
                    </form>
                    <div class="card-body border-top-0 pb-6 pt-2">
                        <div class="text-center">
                            <span class="avatar btn brround me-3 bg-primary-transparent text-primary"><i
                                    class="ri-facebook-line"></i></span>
                            <span class="avatar btn brround me-3 bg-primary-transparent text-primary"><i
                                    class="ri-instagram-line"></i></span>
                            <span class="avatar btn brround me-3 bg-primary-transparent text-primary"><i
                                    class="ri-twitter-line"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ocean">
            <div class="wave"></div>
            <div class="wave"></div>
          </div>
    </div>


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

</body>

<!-- Developed from Aman sahu  by Aman Sahu [XR&CO'2014], Tue, 18 Jul 2023 06:22:37 GMT -->

</html>
