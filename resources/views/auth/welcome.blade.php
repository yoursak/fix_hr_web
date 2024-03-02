
<!doctype html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>FixHR - App for Attendance</title>
    <!--favicon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/demo_file/fix_hr/fav.png') }}" />
    <!--bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/demo_file/css/bootstrap.min.css') }}">
    <!--owl carousel css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/demo_file/css/owl.carousel.min.css') }}">
    <!--magnific popup css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/demo_file/css/magnific-popup.css') }}">
    <!--font awesome css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/demo_file/css/fontawesome-all.min.css') }}">
    <!--icomoon icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/demo_file/css/icomoon.css') }}">
    <!--icofont css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/demo_file/css/icofont.min.css') }}">
    <!--animate css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/demo_file/css/animate.css') }}">
    <!--main css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/demo_file/new-assets/css/style.css') }}">
    <!--responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/demo_file/new-assets/css/responsive.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* overflow: hidden; */
            /* max-width: 100%; */
            overflow-x: hidden;
        }

        .selected-plan {
            background-color: rgb(0, 102, 253);
            color: #fff;
            transition: 0.9ms
        }

        .selected-plan:hover {
            color: #fff
        }

        .totalPriceValue {
            padding-top: 2rem;
        }

        .freePlan {
            padding-top: 2rem;
        }

        .navbar-nav {
            background-color: #1877f2;
        }

        #awesome-feat-area {
            padding: 0 px 0 0px;
        }

    </style>
</head>

<body>
    <!--Start Preloader-->
    <div class="preloader">
        <div class="d-table">
            <div class="d-table-cell align-middle">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div>
    </div>
    <!--End Preloader-->
    <!--start header-->
    <header id="header" class="two">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <!-- Logo -->
                    <a class="logo" href="#"><img id="kite"
                            src="{{ asset('assets/demo_file/fix_hr/color fix hr (1).png') }}" alt="logo"
                            style="height: 3rem"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"><i class="icofont-navigation-menu"></i></span>
                    </button>
                    <!-- navbar links -->
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-scroll-nav="0">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-scroll-nav="1">Features</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-scroll-nav="2">ScreenShots</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-scroll-nav="3">Pricing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-scroll-nav="4">Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-scroll-nav="8">Free Demo</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <!--end header-->
    <script>
        var defaultImageSrc = "{{ asset('assets/demo_file/fix_hr/color fix hr (1).png') }}";

        // Function to be called when the header is scrolled
        function headerScrollHandler() {
            var headerElement = document.getElementById("header");
            console.log("Header is scrolled!");
            // Change the image source to a different image when scrolled
            $('#kite').attr('src', "{{ asset('assets/demo_file/fix_hr/Fix_HR1 (1).png') }}");
            // Your code here
            if (headerElement.classList.contains("two") && headerElement.classList.contains("sticky")) {
                console.log("Two");
            } else {
                defaultImageSrc = "{{ asset('assets/demo_file/fix_hr/color fix hr (1).png') }}";
                $('#kite').attr('src', defaultImageSrc);

                console.log("one");

            }
        }



        // Variable to track if scrolling has occurred
        var scrollingOccurred = false;

        // Add a scroll event listener to the window
        window.addEventListener("scroll", function() {
            scrollingOccurred = true;

            // Call the headerScrollHandler function when the window is scrolled
            headerScrollHandler();
        });

        // Check if no scrolling has occurred after a certain time and revert to the default image
        var timeout;
        window.addEventListener("scroll", function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                // If no scrolling occurred, revert to the default image
                if (!scrollingOccurred) {
                    $('#kite').attr('src', defaultImageSrc);
                }
                scrollingOccurred = false; // Reset the scrollingOccurred flag
            }, 1000); // Change the timeout duration as needed
        });
    </script>

    <!--start home area-->
    <section id="home-area" class="bg-2" data-scroll-index="0" style="width:100%">
        <div class="container">
            <div class="row">
                <!--start caption-->
                <div class="col-lg-7 col-md-8">
                    <div class="caption two d-table">
                        <div class="d-table-cell align-middle">
                            <h1 class="mb-3">Empowering Business with FixHR Solutions</h1>
                            <h4 class="text-dark font-open-sans">Fix HR is the most unique mobile and web based software, designed
                                for managing attendance records of startups, small businesses, and supporting modern
                                companies.</h4>
                            <div class="caption-btns v2">
                                <a class="bg" href="#">Download Now</a>
                            </div>
                            <div class="caption-download-btns v2">
                                <ul class="ml-xl-4 ml-2">
                                    <li><a href="#"><i class="icofont-brand-android-robot"></i></a></li>
                                    <li><a href="#"><i class="icofont-brand-apple"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end caption-->
            </div>
        </div>
    </section>
    <!--start home area-->
    <!--start core feature area-->
    <section id="core-feature-area" class="bg-3">
        <div class="core-feature-circle">
            <img class="circle1" src="{{ asset('assets/demo_file/new-assets/images/asset-6.png') }}" alt="">
            <img class="circle2" src="{{ asset('assets/demo_file/new-assets/images/asset-6.png') }}" alt="">
            <img class="circle3" src="{{ asset('assets/demo_file/new-assets/images/asset-6.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-md-10 offset-md-1">
                    <div class="section-heading text-center">
                        <h5>About our App</h5>
                        <h2>Wonderful features to satisfy you to use our mobile app</h2>
                        <p>Fix HR is designed for those who love to user interface. You will love the seamless way we
                            display the user inter face on your devices.As businesses rely on software or app to engage
                            customers, innovation and velocity becomes core to delivering value.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <!--start core feature single-->
                <div class="col-lg-3 col-md-6">
                    <div class="core-feature-single">
                        <div class="core-feature-single-item text-center">
                            <div class="icon">
                                <i class="icon-gear"></i>
                            </div>
                            <h3>Quick Setup</h3>
                            <p align="justify">The app is really easy to install, the complete business setup process will take
                                few minutes of your time.</p>
                        </div>
                        <img class="hover-shape-1 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-one.svg') }}" alt="Shape One">
                        <img class="hover-shape-2 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-two.svg') }}" alt="Shape Two">
                        <img class="hover-shape-3 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-three.svg') }}"
                            alt="Shape Three">
                        <img class="hover-shape-4 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-four.svg') }}" alt="Shape Four">
                        <img class="hover-shape-5 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-five.svg') }}" alt="Shape Five">
                    </div>
                </div>
                <!--end core feature single-->
                <!--start core feature single-->
                <div class="col-lg-3 col-md-6">
                    <div class="core-feature-single">
                        <div class="core-feature-single-item two text-center">
                            <div class="icon">
                                <i class="icon-web-design"></i>
                            </div>
                            <h3>Lovely Design</h3>
                            <p align="justify">With carefully thought-out design, Fix HR looks great on any device and
                                Easy to Use, Easy
                                way to customize from web.</p>
                        </div>
                        <img class="hover-shape-1 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-one.svg') }}" alt="Shape One">
                        <img class="hover-shape-2 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-two.svg') }}" alt="Shape Two">
                        <img class="hover-shape-3 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-three.svg') }}"
                            alt="Shape Three">
                        <img class="hover-shape-4 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-four.svg') }}" alt="Shape Four">
                        <img class="hover-shape-5 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-five.svg') }}" alt="Shape Five">
                    </div>
                </div>
                <!--end core feature single-->
                <!--start core feature single-->
                <div class="col-lg-3 col-md-6">
                    <div class="core-feature-single">
                        <div class="core-feature-single-item three text-center">
                            <div class="icon three">
                                <i class="icon-report"></i>
                            </div>
                            <h3>Optimized Data</h3>
                            <p align="justify">Speed is very important when you work with loading data, especially if
                                you have a large
                                number of users.</p>
                        </div>
                        <img class="hover-shape-1 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-one.svg') }}" alt="Shape One">
                        <img class="hover-shape-2 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-two.svg') }}" alt="Shape Two">
                        <img class="hover-shape-3 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-three.svg') }}"
                            alt="Shape Three">
                        <img class="hover-shape-4 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-four.svg') }}" alt="Shape Four">
                        <img class="hover-shape-5 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-five.svg') }}" alt="Shape Five">
                    </div>
                </div>
                <!--end core feature single-->
                <!--start core feature single-->
                <div class="col-lg-3 col-md-6">
                    <div class="core-feature-single">
                        <div class="core-feature-single-item four text-center">
                            <div class="icon four">
                                <i class="icon-list"></i>
                            </div>
                            <h3>Secure Data</h3>
                            <p align="justify">Transfer all information with the help of SSL - a solution allowing you
                                to save any data
                                from the public eye.</p>
                        </div>
                        <img class="hover-shape-1 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-one.svg') }}" alt="Shape One">
                        <img class="hover-shape-2 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-two.svg') }}" alt="Shape Two">
                        <img class="hover-shape-3 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-three.svg') }}"
                            alt="Shape Three">
                        <img class="hover-shape-4 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-four.svg') }}" alt="Shape Four">
                        <img class="hover-shape-5 hover-shape"
                            src="{{ asset('assets/demo_file/new-assets/images/shape-five.svg') }}" alt="Shape Five">
                    </div>
                </div>
                <!--end core feature single-->
            </div>

            {{-- <div class="row">

                <div class="col-lg-12">
                    <div class="load-more-btn text-center">
                        <a href="#">Learn More</a>
                    </div>
                </div>

            </div> --}}
        </div>
    </section>
    <!--end core feature area-->
    <!--start about area-->
    <section id="about-area" class="bg-3">
        <div class="about-area-circle">
            <img class="circle1" src="{{ asset('assets/demo_file/new-assets/images/asset-7.png') }}" alt="">
            <img class="circle2" src="{{ asset('assets/demo_file/new-assets/images/asset-7.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row">
                <!--start about content-->
                <div class="col-md-6">
                    <div class="about-cont">
                        <h5>About Fix HR</h5>
                        <h2>Delivering exceptional user experiences.</h2>
                        <p align="justify">The Fix HR attendance management system project was developed to help
                            employers track and
                            monitor their employees. It's the system used to track how much time the workers spend
                            working and how much time they spend off. An attendance management system monitors arrival
                            time, duration of absence from a section, mis-punch, gate pass, leave at credit and profit,
                            and the monthly aggregate of hours of duty and absence of employees. This monitoring is done
                            using computerized software and specific devices. This approach ensures that your employees
                            are only paid for the time they work. The attendance system provides a precise view of the
                            company's labor costs.</p>
                        <p>Our customer uses our application to adopt next-generation development practices, deliver new
                            applications, and modernize existing applications.</p>
                    </div>
                    {{-- <div class="about-info row">
                        <div class="col-md-6 col-6">
                            <div class="about-info-single">
                                <div class="icon">
                                    <i class="icon-employee"></i>
                                </div>
                                <div class="content">
                                    <h3>0</h3>
                                    <p>Premium User</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="about-info-single two">
                                <div class="icon">
                                    <i class="icon-eye-tracking"></i>
                                </div>
                                <div class="content">
                                    <h3>50</h3>
                                    <p>Daily Visitors</p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <!--end about content-->
            </div>
        </div>
        <!--start app mocup-->
        <div class="about-app-mocup">
            <img src="{{ asset('assets/demo_file/new-assets/images/changed/app-mocup-4.png') }}"
                style="height: 850px" class="img-fluid" alt="">
        </div>
        <!--end app mocup-->
    </section>
    <!--end about area-->
    <!--start video area-->
    <section id="video-area" class="bg-2">
        <div class="video-area-circle">
            <img class="circle1" src="{{ asset('assets/demo_file/new-assets/images/asset-8.png') }}" alt="">
            <img class="circle2" src="{{ asset('assets/demo_file/new-assets/images/asset-8.png') }}" alt="">
            <img class="circle3" src="{{ asset('assets/demo_file/new-assets/images/asset-8.png') }}" alt="">
        </div>
        <div class="video-cont d-table text-center">
            <div class="d-table-cell align-middle">
                <div class="video-overlay"></div>
                {{-- <a class="popup-video" href="https://www.youtube.com/watch?v=om4qTKMuPPs"><i
                        class="icofont-ui-play"></i></a> --}}
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="video title">
                        <h5>Explore Amazing features</h5>
                        <h2>That will boost your productivity</h2>
                        <p>With our wide range of features, you can create a custom web and app setup no matter what
                            your niche: startups, small business and all the rest!</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <div class="counter title">
                        <h5 class="text-light">Take a Look at our</h5>
                        <h2 class="text-white">Some Facts</h2>
                        <p>Fix HR enables all its users with constant support and wide set of tools to develop and grow
                            their businesses and projects.some of our favorite facts that you might not have known.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!--start counter single-->
                <div class="col-md-3 col-6">
                    <div class="counter-single">
                        <div class="icon">
                            <img src="{{ asset('assets/demo_file/new-assets/images/icon-like-1.png') }}"
                                class="img-fluid" alt="">
                        </div>
                        <h2>0</h2>
                        <p>5 star Rating</p>
                    </div>
                </div>
                <!--end counter single-->
                <!--start counter single-->
                <div class="col-md-3 col-6">
                    <div class="counter-single">
                        <div class="icon">
                            <img src="{{ asset('assets/demo_file/new-assets/images/icon-user-1.png') }}"
                                class="img-fluid" alt="">
                        </div>
                        <h2>0</h2>
                        <p>Happy Users</p>
                    </div>
                </div>
                <!--end counter single-->
                <!--start counter single-->
                <div class="col-md-3 col-6">
                    <div class="counter-single">
                        <div class="icon">
                            <img src="{{ asset('assets/demo_file/new-assets/images/icon-cloud-1.png') }}"
                                class="img-fluid" alt="">
                        </div>
                        <h2>0</h2>
                        <p>app download</p>
                    </div>
                </div>
                <!--end counter single-->
                <!--start counter single-->
                <div class="col-md-3 col-6">
                    <div class="counter-single">
                        <div class="icon">
                            <img src="{{ asset('assets/demo_file/new-assets/images/icon-trophy-1.png') }}"
                                class="img-fluid" alt="">
                        </div>
                        <h2>0</h2>
                        <p>Best Awards</p>
                    </div>
                </div>
                <!--end counter single-->
            </div>
        </div>
    </section>
    <!--end video area-->
    <!--start awesome feature area-->
    <section id="awesome-feat-area" class="bg-2" data-scroll-index="1">
        <div class="awesome-feat-area-circle">
            <img class="circle1" src="{{ asset('assets/demo_file/new-assets/images/asset-6.png') }}" alt="">
            <img class="circle2" src="{{ asset('assets/demo_file/new-assets/images/asset-8.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>an exhaustive thriving list of</h5>
                        <h2>Awesome Features</h2>
                        <p>We've mentioned everything you could possibly want to know about Fix HR. Some snapshots of our FixHR application are: </p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
        </div>
        <div class="row">
            <!--start feature images-->
            <div class="col-md-5">
                <div class="awesome-feat-img text-center">
                    <a data-owl-item="1" class="feature-link active">
                        <div class="feat-screen-single mt-5">
                            <img src="{{ asset('assets/demo_file/screenshort/app-mocup-3-4.png') }}"
                                class="img-fluid" alt="" style="height: 34rem">
                        </div>
                    </a>
                    <a data-owl-item="2" class="feature-link">
                        <div class="feat-screen-single mt-5">
                            <img src="{{ asset('assets/demo_file/screenshort/app-mocup-3-2.png') }}"
                                class="img-fluid" alt="" style="height: 34rem">
                        </div>
                    </a>
                    <a data-owl-item="3" class="feature-link">
                        <div class="feat-screen-single mt-5">
                            <img src="{{ asset('assets/demo_file/screenshort/app-mocup-3-3.png') }}"
                                class="img-fluid" alt="" style="height: 34rem">
                        </div>
                    </a>
                    <a data-owl-item="4" class="feature-link">
                        <div class="feat-screen-single mt-5">
                            <img src="{{ asset('assets/demo_file/screenshort/app-mocup-3-4.png') }}"
                                class="img-fluid" alt="" style="height: 34rem">
                        </div>
                    </a>
                    <a data-owl-item="4" class="feature-link">
                        <div class="feat-screen-single mt-5">
                            <img src="{{ asset('assets/demo_file/screenshort/app-mocup-3-1.png') }}"
                                class="img-fluid" alt="" style="height: 34rem">
                        </div>
                    </a>
                    <a data-owl-item="4" class="feature-link">
                        <div class="feat-screen-single mt-5">
                            <img src="{{ asset('assets/demo_file/screenshort/app-mocup-3-2.png') }}"
                                class="img-fluid" alt="" style="height: 34rem">
                        </div>
                    </a>
                </div>
            </div>
            <!--end feature images-->
            <div class="col-md-7">
                <div class="feat-carousel-wrap">
                    <div class="awesome-feat-carousel owl-carousel">

                        <div class="awesome-feat-single text-center">
                            <div class="icon">
                                <img src="{{ asset('assets/demo_file/new-assets/images/icon-setting.png') }}"
                                    class="img-fluid" alt="">
                            </div>
                            <h3>Attendance Method</h3>
                            <p align="justify">Enhanced flexibility to set On-duty or Off-duty attendance for auto or
                                manual In Premises, Outdoor and Remote setup to ensure accurate attendance
                                through QR code, Facial Recognition, Selfie and geo-location. </p>
                        </div>

                        <div class="awesome-feat-single text-center">
                            <div class="icon">
                                <img src="{{ asset('assets/demo_file/new-assets/images/icon-setting.png') }}"
                                    class="img-fluid" alt="">
                            </div>
                            <h3>Hybrid Attendance</h3>
                            <p align="justify">Multiple options for attendance such as app-based Selfie, Facial
                                Recognition, QR code and geo-location/geo-fancing/geo-tagging for enhanced flexibility.
                                It assists in keeping track of employee schedules and accurately records employee entry
                                and exit timings dynamically.</p>
                        </div>

                        <div class="awesome-feat-single text-center">
                            <div class="icon two">
                                <img src="{{ asset('assets/demo_file/new-assets/images/icon-responsive.png') }}"
                                    class="img-fluid" alt="">
                            </div>
                            <h3>On Demand Features</h3>
                            <p align="justify">The standard Fix HR software allows you to track employee attendance,
                                view timesheets, track overtime, lateness, shift setting, approve or decline leave, mis
                                punch,
                                and gate pass requests from any mobile or browser on your laptop or PC.</p>
                        </div>

                        <div class="awesome-feat-single text-center">
                            <div class="icon two">
                                <img src="{{ asset('assets/demo_file/new-assets/images/icon-responsive.png') }}"
                                    class="img-fluid" alt="">
                            </div>
                            <h3>Multi Level Approval System</h3>
                            <p align="justify">Fix HR web application provides you to create or define custom workflows
                                for approval from managers, HR, and administrators, to enable enhanced transparency.
                            </p>
                        </div>

                        <div class="awesome-feat-single text-center">
                            <div class="icon three">
                                <img src="{{ asset('assets/demo_file/new-assets/images/icon-setting.png') }}"
                                    class="img-fluid" alt="">
                            </div>
                            <h3>Easy to Manage Your All Data</h3>
                            <p>Fix HR is Best app to help you take control of your device data. Apps that have the power
                                to transform workflows, improve client relationships,boost your productivity and
                                organize your life. </p>
                        </div>

                        <div class="awesome-feat-single text-center">
                            <div class="icon two">
                                <img src="{{ asset('assets/demo_file/new-assets/images/icon-responsive.png') }}"
                                    class="img-fluid" alt="">
                            </div>
                            <h3>Responsive Design For All Devices</h3>
                            <p>Fix HR provides you user-friendly features and responsive design for attendance based
                                software, including web applications and mobile apps, is crucial for ensuring a positive
                                user experience on a wide range of devices. </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end awesome feature area-->
    <!--start how work area-->
    <section id="how-work-area" class="bg-3">
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Describe your App</h5>
                        <h2>Let’s See How It Work</h2>
                        <p>We've gone over everything you could possibly want to know about Fix HR, from how exactly the
                            app works.Three Simple Steps to journey.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row how-work-wrap my-5">
                <div class="how-work-bg"></div>
                <!--start how work single-->
                <div class="col-lg-offset-1 col-lg-3 col-md-4">
                    <div class="how-work-single">
                        <div class="icon">
                            <i class="icofont-cloud-download"></i>
                            <div class="number">01</div>
                        </div>
                        <h3>Download</h3>
                        <p align="justify">The first step to getting on your Fix HR is to download the Fix HR. Open the
                            <a href="#">Google Play</a>, or <a href="#">iTunes App Store</a> App on your
                            smartphone.
                        </p>
                    </div>
                </div>
                <!--end how work single-->
                <!--start how work single-->
                <div class="col-lg-3 col-md-4">
                    <div class="how-work-single two">
                        <div class="icon">
                            <i class="icofont-settings"></i>
                            <div class="number">02</div>
                        </div>
                        <h3>Configure It</h3>
                        <p align="justify">Open your web app's Settings tab that appear on your web screen, each of
                            these customizations
                            are unique to your Activity.</p>
                    </div>
                </div>
                <!--end how work single-->
                <!--start how work single-->
                <div class="col-lg-3 col-md-4">
                    <div class="how-work-single three">
                        <div class="icon">
                            <i class="icofont-trophy"></i>
                            <div class="number">03</div>
                        </div>
                        <h3>Yay! Done</h3>
                        <p align="justify">Explore and share Fix HR app. Check out our FAQ for more information on the
                            system,
                            subscriptions, 24-Hour Passes, features and more.</p>
                    </div>
                </div>
                <!--end how work single-->
            </div>
        </div>
    </section>
    <!--end how work area-->
    <!--start newsletter area-->
    <section id="newsletter-area" class="bg-2">
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-7 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Be the first to know</h5>
                        <h2 class="text-white">About New Features</h2>
                        <p class="text-light">If you want to receive monthly updates from us just pop your email in the
                            box.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <!--start newsletter form-->
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="newsletter-form two">
                        <form id="mc-newsletter" action="https://pixner.net/Fix HR/demo/newsletter/config.php"
                            method="post">
                            <div class="newsletter-input-bx" style="border: #fff 1px solid" >
                                <input type="email" class="form-control" id="mc-email" name="mc-email"
                                    placeholder="Enter Your Email" required>
                                <button type="submit">SUBSCRIBE</button>
                            </div>
                        </form>
                        <div id="response"></div>
                    </div>
                </div>
                <!--end newsletter form-->
            </div>
        </div>
    </section>
    <!--end newsletter area-->
    <!--screenshot area-->
    <section id="screenshot-area" class="bg-2" data-scroll-index="2">
        <div class="screenshot-area-img d-flex justify-content-end">
            <img src="{{ asset('assets/demo_file/new-assets/images/changed/screen-bg-3.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Showcase your app</h5>
                        <h2>The Screenshot Gallery</h2>
                        <p>This is easy way showcase your app screen . If you want to show your app just pop in the
                            screenshots and the magic happens.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="screen-wrap">
                <div class="screenshot-frame"></div>
                <div class="screen-carousel owl-carousel">
                    <img src="{{ asset('assets/demo_file/screenshort/sc1.png') }}" class="img-fluid" alt="">
                    <img src="{{ asset('assets/demo_file/screenshort/sc2.jpeg') }}" class="img-fluid"
                        alt="">
                    <img src="{{ asset('assets/demo_file/screenshort/sc3.jpeg') }}" class="img-fluid"
                        alt="">
                    <img src="{{ asset('assets/demo_file/screenshort/sc4.png') }}" class="img-fluid" alt="">
                    <img src="{{ asset('assets/demo_file/screenshort/sc5.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>
    <!--end area-->
    <!--start pricing area-->
    <section id="pricing-area" data-scroll-index="3">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="section-heading">
                        <h5>Subscription Plan</h5>
                        <h2>Choose The Right Plan</h2>
                        <p>Build trust with prospective clients, delight existing customers, and increase the efficiency
                            and collaboration within your team. We have experience with plethora of technologies.</p>
                        <p>Fix HR has plans, from free to paid, that scale with your needs. Subscribe to a plan that
                            fits the size of your business. Fix HR monthly pricing is based on how many employees and
                            functions you need to start your work. If you ready to use Fix HR for a long time you can
                            customize is for quaterly, half yearly and annual basis to save your time and money.</p>
                    </div>
                    <div class="toggle-container two">
                        <div class="switch-toggles">
                            <div class="monthly active">Monthly</div>
                            <div class="yearly">Yearly</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div id="pricing-wrap">
                        <!--start monthly pricing table-->
                        <div class="monthly active">
                            <div class="price-tbl-single two highlighted">
                                <div class="table-inner text-center">
                                    <h4>start</h4>
                                    <div class="price">
                                        <div class="price-bg"></div>
                                        <h3><b><i class="icofont-rupee"></i>500/<span>Month</span></b></h3>
                                    </div>
                                    <ul>
                                        <li>10 Employees</li>
                                        <li>Easy to Customize</li>
                                        <li>Unlimited Server Space</li>
                                        <li>Support Unlimited User</li>
                                    </ul>
                                    <a href="#">get started</a>
                                </div>
                            </div>
                        </div>
                        <!--end monthly pricing table-->
                        <!--start monthly pricing table-->
                        <div class="yearly">
                            <div class="price-tbl-single two highlighted">
                                <div class="table-inner text-center">
                                    <h4>Standard</h4>
                                    <div class="price two">
                                        <div class="price-bg"></div>
                                        <h3><b><i class="icofont-rupee"></i>6000/<span>YEAR</span></b></h3>
                                    </div>
                                    <ul>
                                        <li>10 Employees</li>
                                        <li>Easy to Customize</li>
                                        <li>Unlimited Server Space</li>
                                        <li>Support Unlimited User</li>
                                    </ul>
                                    <a href="#">get started</a>
                                </div>
                            </div>
                        </div>
                        <!--end monthly pricing table-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end pricing area-->
    <!--start custom plan area-->
    <section id="custom-plan-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="custom-plan-wrap bg-2 row">
                        <div class="custom-plan-wrap-circle">
                            <img class="circle1" src="{{ asset('assets/demo_file/new-assets/images/asset-7.png') }}"
                                alt="">
                            <img class="circle2" src="{{ asset('assets/demo_file/new-assets/images/asset-8.png') }}"
                                alt="">
                        </div>
                        <div class="col-md-8 offset-md-2">
                            <div class="section-heading text-center">
                                <h5 class="text-light">Fix HR Cost Calculator</h5>
                                <h2 class="text-white">Need a Custom Plan?</h2>
                                <p class="text-white">We’ve created this handy plan cost calculator just for you. Find
                                    out how much your custom plan will cost in under a minute! </p>
                            </div>
                            <div class="col-lg-12">
                                <div class="plan-btn two text-center">
                                    <a href="" type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">Use Cost Calculator</a>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Price Calculator</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-10 offset-lg-1">
                                                    <div class="content">
                                                        <div class="btns">
                                                            <div class="row mx-auto">
                                                                <div class="text-center mx-auto">
                                                                    <span class="fs-26 fw-bold">Customize Your FixHR
                                                                        Subscription</span><br>
                                                                    <span class="fs-16 text-muted">Your registered
                                                                        Email
                                                                        Id is: <a href="#"><span
                                                                                class="text-primary mx-1">Login
                                                                                Now</span></a></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-12 mx-auto"
                                                                style="border:rgb(222,226,230) solid 2px">
                                                                <div class="d-flex justify-content-center py-3">
                                                                    <ul
                                                                        class="d-md-flex border border-primary  rounded">
                                                                        <li id="monthlyBtn"
                                                                            class="btn rounded selected-plan"
                                                                            onclick="changePlan(1)">
                                                                            <b>Monthly</b>
                                                                        </li>
                                                                        <li id="quaterlyBtn" class="btn rounded "
                                                                            onclick="changePlan(3)">
                                                                            <b>Quaterly</b>
                                                                        </li>
                                                                        <li id="halfBtn" class="btn rounded "
                                                                            onclick="changePlan(6)"><b>Half
                                                                                Yearly</b></li>
                                                                        <li id="annuallyBtn" class="btn rounded "
                                                                            onclick="changePlan(12)">
                                                                            <b>Anually</b>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="content my-5 mx-4">
                                                                    <div class="pricings"
                                                                        style="border-bottom: solid 1px rgb(222,226,230)">
                                                                        <div class="d-md-flex justify-content-between">
                                                                            <p>Base Plan (for upto 10 Employees) : </p>
                                                                            <h5 class=" text-end"
                                                                                style="text-align: right;"><span
                                                                                    class="ms-auto"
                                                                                    id="basePlan">500</span><br><span
                                                                                    class="text-muted fs-12 fw-light">For
                                                                                    <span
                                                                                        class="forPlan">Montly</span></span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>

                                                                    <div class="additional-employee mb-5">
                                                                        <div class="emp-content my-3">
                                                                            <div
                                                                                class="d-md-flex justify-content-between">
                                                                                <div class="d-block d-xl-flex">
                                                                                    <div class="d-flex">
                                                                                        <label
                                                                                            class="custom-control custom-checkbox mt-4">
                                                                                            <input type="checkbox"
                                                                                                class="custom-control-input"
                                                                                                name="example-checkbox1"
                                                                                                value="option1"
                                                                                                checked>
                                                                                            <span
                                                                                                class="custom-control-label"></span>
                                                                                        </label>
                                                                                        <h5 class=" pt-4">Add
                                                                                            Aditional
                                                                                            Employee :</span>
                                                                                        </h5>
                                                                                    </div>
                                                                                    <div class="add-employee my-3">
                                                                                        <ul class="rounded text-center mx-5 d-flex"
                                                                                            style="width: 7rem">
                                                                                            <li class="text-primary border my-auto mx-1 "
                                                                                                onclick="operateEmp('minus')">
                                                                                                <b><i
                                                                                                        class="fa fa-minus fs-15"></i></b>
                                                                                            </li>
                                                                                            <li class=""><input
                                                                                                    id="empCount"
                                                                                                    onchange="operateEmp()"
                                                                                                    value='0'
                                                                                                    class="fs-15 fw-bold text-center border border-primary border-0 py-1"
                                                                                                    type="text"
                                                                                                    style="width:3rem">
                                                                                            </li>
                                                                                            <li class="text-primary border border-5 my-auto mx-1 "
                                                                                                onclick="operateEmp('plus')">
                                                                                                <b><i
                                                                                                        class="fa fa-plus fs-15"></i></b>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="additionalAmount mt-4 text-end">
                                                                                    <h5 class="my-auto"
                                                                                        style="text-align: right;">
                                                                                        <span
                                                                                            id="additionalAmmount">0</span><br><span
                                                                                            class="text-muted fs-12 fw-light">Per
                                                                                            Employee <span
                                                                                                id="perEmpPrice">50</span>
                                                                                            / <span
                                                                                                class="forPlan">Monthly</span>
                                                                                    </h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="pricings mt-5 totalPriceValue"
                                                                        style="border-bottom: solid 1px rgb(222,226,230);">
                                                                        <div class="d-flex justify-content-between">
                                                                            <h5>Total Price : <br><span
                                                                                    class="text-muted fs-12 fw-light">For
                                                                                    upto 10
                                                                                    Employee <span
                                                                                        class="forPlan">Monthly</span>
                                                                                </span></h5>
                                                                            <h5 class="text-end"
                                                                                style="text-align: right;"><i
                                                                                    class="fa fa-inr mx-2"></i><span
                                                                                    id="totalPrice">500</span><br><span
                                                                                    class="text-muted fs-12 fw-light">(Inclusive
                                                                                    of All Taxes)</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                var monthlyBtn = document.getElementById('monthlyBtn');
                                                var quaterlyBtn = document.getElementById('quaterlyBtn');
                                                var halfBtn = document.getElementById('halfBtn');
                                                var annuallyBtn = document.getElementById('annuallyBtn');

                                                var basePlan = document.getElementById('basePlan');
                                                var forPlan = document.querySelectorAll(".forPlan");
                                                var perEmpPrice = document.getElementById("perEmpPrice");

                                                var empCount = document.getElementById('empCount');
                                                var additionalAmmount = document.getElementById('additionalAmmount');
                                                var additionalAmmount = document.getElementById('additionalAmmount');
                                                var totalPrice = document.getElementById('totalPrice');
                                                var i = 0;

                                                var BasePlan = 500;
                                                var ForPlan = 50;

                                                function changePlan(plan) {

                                                    // console.log(forPlan);
                                                    if (plan == 1) {
                                                        monthlyBtn.classList.add('selected-plan');
                                                        quaterlyBtn.classList.remove('selected-plan');
                                                        halfBtn.classList.remove('selected-plan');
                                                        annuallyBtn.classList.remove('selected-plan');
                                                        basePlan.innerHTML = '';
                                                        BasePlan = 500 * plan;
                                                        ForPlan = 50 * plan;
                                                        perEmpPrice.innerHTML = ForPlan;
                                                        basePlan.innerHTML = BasePlan;

                                                        forPlan.forEach(element => {
                                                            element.innerHTML = '';
                                                            element.innerHTML = 'Monthly';
                                                        });
                                                    } else if (plan == 3) {
                                                        quaterlyBtn.classList.add('selected-plan');
                                                        monthlyBtn.classList.remove('selected-plan');
                                                        halfBtn.classList.remove('selected-plan');
                                                        annuallyBtn.classList.remove('selected-plan');
                                                        basePlan.innerHTML = '';
                                                        BasePlan = 500 * plan;
                                                        ForPlan = 50 * plan;
                                                        perEmpPrice.innerHTML = ForPlan;
                                                        basePlan.innerHTML = BasePlan;
                                                        forPlan.forEach(element => {
                                                            element.innerHTML = '';
                                                            element.innerHTML = 'Quaterly';
                                                        });
                                                    } else if (plan == 6) {
                                                        halfBtn.classList.add('selected-plan');
                                                        monthlyBtn.classList.remove('selected-plan');
                                                        quaterlyBtn.classList.remove('selected-plan');
                                                        annuallyBtn.classList.remove('selected-plan');
                                                        basePlan.innerHTML = '';
                                                        BasePlan = 500 * plan;
                                                        ForPlan = 50 * plan;
                                                        perEmpPrice.innerHTML = ForPlan;
                                                        basePlan.innerHTML = BasePlan;
                                                        forPlan.forEach(element => {
                                                            element.innerHTML = '';
                                                            element.innerHTML = 'Half Yearly';
                                                        });
                                                    } else if (plan == 12) {
                                                        annuallyBtn.classList.add('selected-plan');
                                                        monthlyBtn.classList.remove('selected-plan');
                                                        quaterlyBtn.classList.remove('selected-plan');
                                                        halfBtn.classList.remove('selected-plan');
                                                        basePlan.innerHTML = '';
                                                        BasePlan = 500 * plan;
                                                        ForPlan = 50 * plan;
                                                        perEmpPrice.innerHTML = ForPlan;
                                                        basePlan.innerHTML = BasePlan;
                                                        forPlan.forEach(element => {
                                                            element.innerHTML = '';
                                                            element.innerHTML = 'Anually';
                                                        });
                                                    }
                                                    operateEmp(basePlan)
                                                }



                                                function operateEmp(operation) {
                                                    if (operation == 'plus') {
                                                        empCount.value = ++i;
                                                    }

                                                    if (operation == 'minus') {
                                                        if (i == 0) {
                                                            empCount.value = 0;
                                                        } else {
                                                            empCount.value = --i;
                                                        }
                                                    }
                                                    additionalAmmount.innerHTML = ''
                                                    totalPrice.innerHTML = ''
                                                    additionalAmmount.innerHTML = i * ForPlan;
                                                    totalPrice.innerHTML = i * ForPlan + BasePlan;


                                                }
                                            </script>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#alertModal">Payment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="alertModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                <h1 class="mx-auto"><i class="icofont-warning text-primary"></i></h1>
                                                <h3>You Need Login First</h3>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <a href="{{ url('/login') }}" type="button"
                                                class="btn btn-primary">Login Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end custom plan area-->
    <!--start team area-->
    {{-- <section id="team-area" data-scroll-index="4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Our creative team</h5>
                        <h2>Meet The Team</h2>
                        <p>Meet the people behind Fix HR We are the team of professional analysts, publishing dozens of
                            application. Join us!</p>
                    </div>
                </div>
            </div>



            <div class="row mt-5 text-center d-xl-flex justify-content-center">
                <!--start team single-->
                <div class="col-lg-2">
                    <div class="team-single text-end ">
                        <div class="team-img">
                            <img src="{{ asset('assets/demo_file/team/jasmitsir.jpeg') }}" class="img-fluid" alt="">
                            <div class="team-social two">
                                <ul class="text-center">
                                    <li><a href="#"><i class="icofont-facebook" target="blank"></i></a></li>
                                    <li><a href="#"><i class="icofont-twitter" target="blank"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/dilip-sahu-b1924396/" target="blank"><i
                                                class="icofont-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team-info text-center">
                            <h4 class="text-center">Jasmit Singh Bhasin</h4>
                            <p>MD</p>
                        </div>
                    </div>
                </div>
                <!--end team single-->
                <!--start team single-->
                <div class="col-lg-2">
                    <div class="team-single text-end ">
                        <div class="team-img">
                            <img src="{{ asset('assets/demo_file/team/panditkunal1sir.jpeg') }}" class="img-fluid" alt="">
                            <div class="team-social two">
                                <ul class="text-center">
                                    <li><a href="#"><i class="icofont-facebook" target="blank"></i></a></li>
                                    <li><a href="#"><i class="icofont-twitter" target="blank"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/jayant-nishad-8b9796191/" target="blank"><i
                                                class="icofont-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team-info text-center">
                            <h4 class="text-center">Kunal Pandit</h4>
                            <p>Project Manager</p>
                        </div>
                    </div>
                </div>
                <!--end team single-->
            </div>

            <div class="row mt-5">
                <!--start team single-->
                <div class="col-lg-2 mx-auto">
                    <div class="team-single text-end ">
                        <div class="team-img">
                            <img src="{{ asset('assets/demo_file/team/Dilip.png') }}" class="img-fluid"
                                alt="">
                            <div class="team-social two">
                                <ul class="text-center">
                                    <li><a href="#"><i class="icofont-facebook" target="blank"></i></a></li>
                                    <li><a href="#"><i class="icofont-twitter" target="blank"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/dilip-sahu-b1924396/" target="blank"><i
                                                class="icofont-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team-info text-center">
                            <h4 class="text-center">Dilip Sahu</h4>
                            <p>Project Head</p>
                        </div>
                    </div>
                </div>
                <!--end team single-->
                <!--start team single-->
                <div class="col-lg-2 mx-auto">
                    <div class="team-single text-end ">
                        <div class="team-img">
                            <img src="{{ asset('assets/demo_file/team/jayant.png') }}" class="img-fluid"
                                alt="">
                            <div class="team-social two">
                                <ul class="text-center">
                                    <li><a href="#"><i class="icofont-facebook" target="blank"></i></a></li>
                                    <li><a href="#"><i class="icofont-twitter" target="blank"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/jayant-nishad-8b9796191/"
                                            target="blank"><i class="icofont-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team-info text-center">
                            <h4 class="text-center">Jayant Nishad</h4>
                            <p>Full Stack Developer</p>
                        </div>
                    </div>
                </div>
                <!--end team single-->
                <!--start team single-->
                <div class="col-lg-2 mx-auto">
                    <div class="team-single text-end ">
                        <div class="team-img">
                            <img src="{{ asset('assets/demo_file/team/NISHA.png') }}" class="img-fluid"
                                alt="">
                            <div class="team-social two">
                                <ul class="text-center">
                                    <li><a href="#"><i class="icofont-facebook" target="blank"></i></a></li>
                                    <li><a href="#"><i class="icofont-twitter" target="blank"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/nisha-sahu-329876244/" target="blank"><i
                                                class="icofont-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team-info text-center">
                            <h4 class="text-center">Nisha Sahu</h4>
                            <p>Flutter Developer</p>
                        </div>
                    </div>
                </div>
                <!--end team single-->
                <!--start team single-->
                <div class="col-lg-2 mx-auto">
                    <div class="team-single text-end ">
                        <div class="team-img">
                            <img src="{{ asset('assets/demo_file/team/UMESH.png') }}" class="img-fluid"
                                alt="">
                            <div class="team-social two">
                                <ul class="text-center">
                                    <li><a href="#"><i class="icofont-facebook"></i></a></li>
                                    <li><a href="#"><i class="icofont-twitter"></i></a></li>
                                    <li><a href="#"><i class="icofont-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team-info text-center">
                            <h4 class="text-center">Umesh Sahu</h4>
                            <p>Laravel Developer</p>
                        </div>
                    </div>
                </div>
                <!--end team single-->
                <!--start team single-->
                <div class="col-lg-2 mx-auto">
                    <div class="team-single text-end ">
                        <div class="team-img">
                            <img src="{{ asset('assets/demo_file/team/AMAN.png') }}" class="img-fluid"
                                alt="">
                            <div class="team-social two">
                                <ul class="text-center">
                                    <li><a href="#"><i class="icofont-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/Yours_ak7"><i class="icofont-twitter"></i></a>
                                    </li>
                                    <li><a href="https://www.linkedin.com/in/aman-sahu-087004159/"><i
                                                class="icofont-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team-info text-center">
                            <h4 class="text-center">Aman Sahu</h4>
                            <p>Laravel Developer</p>
                        </div>
                    </div>
                </div>
                <!--end team single-->
            </div>
        </div>
    </section> --}}
    <!--end team area-->
    <!--start testimonial area-->
    <section id="testimonial-area">
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Trusted User</h5>
                        <h2>A Word From Our Customers</h2>
                        <p>Our passion drives us to work hard and deliver outstanding results so we can be the best app
                            development company. Hear what our clients have to say about Fix HR.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="testi-wrap">
                <!--start testimonial single-->
                <div class="client-single active position-1" data-position="position-1">
                    <div class="client-img">
                        <img src="{{ asset('assets/demo_file/new-assets/images/client-1.jpg') }}" alt="">
                    </div>
                    <div class="client-comment">
                        <h3>Installation was pretty easy.We have been Fix HR customers for years, and we have had
                            nothing but amazing experiences with the Fix HR and well-designed mobile app. Fix HR
                            provided that for us with easy-to-use software and personalized support. I like this app.
                            Thank you</h3>
                        <span><i class="icofont-quote-left"></i></span>
                    </div>
                    <div class="client-info">
                        <h3>Fatih Senel</h3>
                        <p>Digilite Web Solutions</p>
                    </div>
                </div>
                <!--end testimonial single-->
                <!--start testimonial single-->
                <div class="client-single inactive position-2" data-position="position-2">
                    <div class="client-img">
                        <img src="{{ asset('assets/demo_file/new-assets/images/client-7.jpg') }}" alt="">
                    </div>
                    <div class="client-comment">
                        <h3>Installation was pretty easy.We have been Fix HR customers for years, and we have had
                            nothing but amazing experiences with the Fix HR and well-designed mobile app. Fix HR
                            provided that for us with easy-to-use software and personalized support. I like this app.
                            Thank you</h3>
                        <span><i class="icofont-quote-left"></i></span>
                    </div>
                    <div class="client-info">
                        <h3>Fatih Senel</h3>
                        <p>Digilite Web Solutions</p>
                    </div>
                </div>
                <!--end testimonial single-->
                <!--start testimonial single-->
                <div class="client-single inactive position-3" data-position="position-3">
                    <div class="client-img">
                        <img src="{{ asset('assets/demo_file/new-assets/images/client-3.jpg') }}" alt="">
                    </div>
                    <div class="client-comment">
                        <h3>Installation was pretty easy.We have been Fix HR customers for years, and we have had
                            nothing but amazing experiences with the Fix HR and well-designed mobile app. Fix HR
                            provided that for us with easy-to-use software and personalized support. I like this app.
                            Thank you</h3>
                        <span><i class="icofont-quote-left"></i></span>
                    </div>
                    <div class="client-info">
                        <h3>Fatih Senel</h3>
                        <p>Digilite Web Solutions</p>
                    </div>
                </div>
                <!--end testimonial single-->
                <!--start testimonial single-->
                <div class="client-single inactive position-4" data-position="position-4">
                    <div class="client-img">
                        <img src="{{ asset('assets/demo_file/new-assets/images/client-6.jpg') }}" alt="">
                    </div>
                    <div class="client-comment">
                        <h3>Installation was pretty easy.We have been Fix HR customers for years, and we have had
                            nothing but amazing experiences with the Fix HR and well-designed mobile app. Fix HR
                            provided that for us with easy-to-use software and personalized support. I like this app.
                            Thank you</h3>
                        <span><i class="icofont-quote-left"></i></span>
                    </div>
                    <div class="client-info">
                        <h3>Fatih Senel</h3>
                        <p>Digilite Web Solutions</p>
                    </div>
                </div>
                <!--end testimonial single-->
                <!--start testimonial single-->
                <div class="client-single inactive position-5" data-position="position-5">
                    <div class="client-img">
                        <img src="{{ asset('assets/demo_file/new-assets/images/client-4.jpg') }}" alt="">
                    </div>
                    <div class="client-comment">
                        <h3>Installation was pretty easy.We have been Fix HR customers for years, and we have had
                            nothing but amazing experiences with the Fix HR and well-designed mobile app. Fix HR
                            provided that for us with easy-to-use software and personalized support. I like this app.
                            Thank you</h3>
                        <span><i class="icofont-quote-left"></i></span>
                    </div>
                    <div class="client-info">
                        <h3>Fatih Senel</h3>
                        <p>Digilite Web Solutions</p>
                    </div>
                </div>
                <!--end testimonial single-->
                <!--start testimonial single-->
                <div class="client-single inactive position-6" data-position="position-6">
                    <div class="client-img">
                        <img src="{{ asset('assets/demo_file/new-assets/images/client-5.jpg') }}" alt="">
                    </div>
                    <div class="client-comment">
                        <h3>Installation was pretty easy.We have been Fix HR customers for years, and we have had
                            nothing but amazing experiences with the Fix HR and well-designed mobile app. Fix HR
                            provided that for us with easy-to-use software and personalized support. I like this app.
                            Thank you</h3>
                        <span><i class="icofont-quote-left"></i></span>
                    </div>
                    <div class="client-info">
                        <h3>Fatih Senel</h3>
                        <p>Digilite Web Solutions</p>
                    </div>
                </div>
                <!--end testimonial single-->
                <!--start testimonial single-->
                <div class="client-single inactive position-7" data-position="position-7">
                    <div class="client-img">
                        <img src="{{ asset('assets/demo_file/new-assets/images/client-2.jpg') }}" alt="">
                    </div>
                    <div class="client-comment">
                        <h3>Installation was pretty easy.We have been Fix HR customers for years, and we have had
                            nothing but amazing experiences with the Fix HR and well-designed mobile app. Fix HR
                            provided that for us with easy-to-use software and personalized support. I like this app.
                            Thank you</h3>
                        <span><i class="icofont-quote-left"></i></span>
                    </div>
                    <div class="client-info">
                        <h3>Fatih Senel</h3>
                        <p>Digilite Web Solutions</p>
                    </div>
                </div>
                <!--end testimonial single-->
            </div>
        </div>
    </section>
    <!--end testimonial area-->
    <!--start app download area-->
    <section id="app-download-area" data-scroll-index="5">
        <div class="app-download-bg bg-1">
            <img src="{{ asset('assets/demo_file/new-assets/images/faq-bg-1.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-6 col-md-8">
                    <div class="section-heading">
                        <h5>Choose Your Device Platform</h5>
                        <h2>Get The App on</h2>
                        <p>Get the latest resources for downloading, installing, and updating Fix HR. Select your device
                            platform and Use Our app and Enjoy Your Life.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
        </div>
        <div class="app-downlod-review two">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="download-btns two">
                            <a href="#"><img
                                    src="{{ asset('assets/demo_file/new-assets/images/playstore-icon.png') }}"
                                    class="img-fluid" alt=""> Play Store</a><a class="bg"
                                href="#"><i class="icofont-brand-apple"></i> App Store</a>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="app-reviews">
                                    <h6>Reviews</h6>
                                    <div class="rating-number float-left">
                                        <h2>4.5</h2>
                                    </div>
                                    <div class="rating-details float-left">
                                        <p class="m-0"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half"></i></p>
                                        <p class="font-light">200 ratings</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="app-reviews">
                                    <h6>Reviews</h6>
                                    <div class="rating-number float-left">
                                        <h2>4.5</h2>
                                    </div>
                                    <div class="rating-details float-left">
                                        <p class="m-0"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half"></i></p>
                                        <p class="font-light">150 ratings</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-download-mockup">
            <img src="{{ asset('assets/demo_file/new-assets/images/changed/imac-mocup.png') }}" class="img-fluid"
                alt="">
        </div>
    </section>
    <!--end app download area-->
    <!--start faq area-->
    <section id="faq-area" class="bg-2">
        <div class="faq-area-img">
            <img src="{{ asset('assets/demo_file/new-assets/images/faq-bg-1.png') }}" class="img-fluid"
                alt="">
        </div>
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Take A look</h5>
                        <h2>Frequently Asked Questions</h2>
                        <p>Our Mobile App can be downloaded and installed on your compatible mobile device easily. If
                            you have any questions - please look through the most frequently asked questions or contact
                            us for more details.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div id="accordion" role="tablist">
                        <!--start faq single-->
                        <div class="card two">
                            <div class="card-header active" role="tab" id="faq1">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" href="#collapse1" aria-expanded="true"
                                        aria-controls="collapse1">Is the Mobile App Secure?</a>
                                </h5>
                            </div>
                            <div id="collapse1" class="collapse show" role="tabpanel" aria-labelledby="faq1"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <p>
                                        Fix HR mobile app uses strong encryption, user authentication, and access
                                        controls to ensure secure attendance management, complying with privacy
                                        regulations and industry standards. </p>
                                </div>
                            </div>
                        </div>
                        <!--end faq single-->
                        <!--start faq single-->
                        <div class="card two">
                            <div class="card-header" role="tab" id="faq2">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse2"
                                        aria-expanded="false" aria-controls="collapse2">What features does the Mobile
                                        App have?</a>
                                </h5>
                            </div>
                            <div id="collapse2" class="collapse" role="tabpanel" aria-labelledby="faq2"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <p>
                                        An attendance management system is software that tracks the working hours of
                                        employees.
                                        It does precise time tracking for attendance, breaks, the time off taken, clock
                                        in and clock out, by your employee.
                                        It prevents any type of error in a record. It makes your attendance management
                                        precise and efficient. In a Fix HR
                                        attendance management system, your employees can mark their time and attendance
                                        in the mobile app.
                                        The software automates your attendance management, so the data should be
                                        available to the HR department in real-time to do the precise payroll and your
                                        employees should be compensated for their time.</p>
                                </div>
                            </div>
                        </div>
                        <!--end faq single-->
                        <!--start faq single-->
                        <div class="card two">
                            <div class="card-header" role="tab" id="faq3">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse3"
                                        aria-expanded="false" aria-controls="collapse3">How do I get the Mobile App
                                        for my phone?</a>
                                </h5>
                            </div>
                            <div id="collapse3" class="collapse" role="tabpanel" aria-labelledby="faq3"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <p>First you need to setup Fix HR web application and then download Fix HR mobile
                                        application from the Play Store or IOS Store to explore Fix HR attendance
                                        features. Both the Mobile Apps and the Mobile Web App give you the ability to
                                        you to access your account information,
                                        view notice releases, request report, and contact us via email or phone. Once
                                        you've installed a Mobile App on your phone,
                                        you'll also have ability to setup web application to view a map of our offices
                                        and branch locations.</p>
                                </div>
                            </div>
                        </div>
                        <!--end faq single-->
                        <!--start faq single-->
                        <div class="card two">
                            <div class="card-header" role="tab" id="faq4">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse4"
                                        aria-expanded="false" aria-controls="collapse4">How does Fix HR differ from
                                        usual apps? </a>
                                </h5>
                            </div>
                            <div id="collapse4" class="collapse" role="tabpanel" aria-labelledby="faq4"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <p>
                                        Fix HR web and mobile application provides multiple attendance features such as
                                        facial recognization,
                                        QR code, and selfie based attendance mode in a single plateform. It also
                                        provides realtime and error free time tracking attendance Solutions
                                        with mispunch, leave and gatepass features which make us different from the
                                        other tech orgnization.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!--end faq single-->
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="faq-img">
                        <img src="{{ asset('assets/demo_file/new-assets/images/faq-img-1.png') }}" class="img-fluid"
                            alt="">
                        <img src="{{ asset('assets/demo_file/new-assets/images/changed/faq-img-2.png') }}"
                            class="img-icon" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end faq area-->
    <!--start contact area-->
    <section id="contact-area" class="bg-2" data-scroll-index="8">
        <div class="contact-area-circle">
            <img class="circle1" src="{{ asset('assets/demo_file/new-assets/images/asset-7.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-5 col-md-8">
                    <div class="section-heading">
                        <h5>Contact us</h5>
                        <h2>Get In Touch</h2>
                        <p>If you have any questions, just fill in the contact form, and we will answer you shortly.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <!--start contact form-->
                <div class="col-lg-5 col-md-7">
                    <div class="contact-form two">
                        <form id="ajax-contact" action="https://pixner.net/Fix HR/demo/contact.php" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Name*" required="required" data-error="name is required.">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email*" required="required" data-error="valid email is required.">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Message*"
                                    required="required" data-error="Please, leave us a message."></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <button type="submit">SUBMIT NOW</button>
                            <div class="messages"></div>
                        </form>
                    </div>
                </div>
                <!--end contact form-->
            </div>
        </div>
    </section>
    <!--end contact area-->
    <!--start footer-->
    <footer id="footer" class="bg-2">
        <div class="container">
            <div class="get-started two">
                <div class="row">
                    <div class="col-lg-6 col-md-8">
                        <h2>Ready To Get Started?</h2>
                        <p class="text-light">Don't waste another minute.Create an account now and start saving more
                            time.Do even more with the Fix HR.</p>
                    </div>
                    <div class="col-lg-6 col-md-4">
                        <a href="https://fixhr.app/signup">Create an Account</a>
                    </div>
                </div>
            </div>

            <div class="footer-copyright">
                <div class="row">
                    <div class="col-lg-12 col-md-12 text-center">
                        <p class="text-dark"><b>&copy; 2024 Fix HR | All right reserved | Designed by <a style="color: #1877f2; font-width:bold; font-size:16px" href="https://fixingdots.com/" target="blank">FixingDots</a>.</b></p>
                    </div>
                    {{-- <div class="col-lg-6 col-md-5">
                        <div class="footer-social text-right">
                            <ul>
                                <li><a href="#"><i class="icofont-facebook"></i></a></li>
                                <li><a href="#"><i class="icofont-linkedin"></i></a></li>
                                <li><a href="#"><i class="icofont-twitter"></i></a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </footer>
    <!--end footer-->
    <!--jQuery js-->
    <script src="{{ asset('assets/demo_file/js/jquery-3.3.1.min.js') }}"></script>
    <!--proper js-->
    <script src="{{ asset('assets/demo_file/js/popper.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('assets/demo_file/js/bootstrap.min.js') }}"></script>
    <!--counter js-->
    <script src="{{ asset('assets/demo_file/js/waypoints.js') }}"></script>
    <script src="{{ asset('assets/demo_file/js/counterup.min.js') }}"></script>
    <!--magnic popup js-->
    <script src="{{ asset('assets/demo_file/js/magnific-popup.min.js') }}"></script>
    <!--owl carousel js-->
    <script src="{{ asset('assets/demo_file/js/owl.carousel.min.js') }}"></script>
    <!--owl scrollIt js-->
    <script src="{{ asset('assets/demo_file/js/scrollIt.min.js') }}"></script>
    <!--validator js-->
    <script src="{{ asset('assets/demo_file/js/validator.min.js') }}"></script>
    <!--contact js-->
    <script src="{{ asset('assets/demo_file/js/contact.js') }}"></script>
    <!--ajax newsletter js-->
    <script src="newsletter/ajax-newsletter-form.js')}}"></script>
    <!--main js-->
    <script src="{{ asset('assets/demo_file/js/custom.js') }}"></script>
</body>

</html>
