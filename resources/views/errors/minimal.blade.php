<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- Mirrored from laravelui.spruko.com/dayone/error503 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 18 Jul 2023 06:22:38 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

		<!-- META DATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="DayOne - It is one of the Major Dashboard Template which includes - HR, Employee and Job Dashboard. This template has multipurpose HTML template and also deals with Task, Project, Client and Support System Dashboard." name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="admin dashboard, dashboard ui, backend, admin panel, admin template, dashboard template, admin, bootstrap, laravel, laravel admin panel, php admin panel, php admin dashboard, laravel admin template, laravel dashboard, laravel admin panel"/>

		<!-- TITLE -->
		<title>@yield('title')</title>

        <!--FAVICON -->
		<link rel="icon" href="assets/images/brand/favicon.ico" type="image/x-icon"/>

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
		<link href="assets/switcher/css/switcher.css" rel="stylesheet"/>
		<link href="assets/switcher/demo.css" rel="stylesheet"/>

	</head>

	<body class="login-img">

		<!-- SWITCHER -->
        <div class="switcher-wrapper">
			<div class="demo_changer">
				<div class="form_holder sidebar-right1">
					<div class="row">
						<div class="predefined_styles">
							<div class="swichermainleft text-center">
								<div class="p-3">
									<a href="index-2.html" class="btn ripple btn-primary btn-block mt-0" target="blank" >View Demo</a>
									<a href="https://themeforest.net/item/dayone-laravel-admin-dashboard-template/33043521" class="btn ripple btn-secondary btn-block">Buy Now</a>
									<a href="https://themeforest.net/user/spruko/portfolio" class="btn ripple btn-red btn-block">Our Portfolio</a>
								</div>
							</div>
							<div class="swichermainleft mb-0">
								<h4>LTR AND RTL VERSIONS</h4>
								<div class="skin-body">
									<div class="switch_section">
										<div class="switch-toggle d-flex mt-4">
											<span class="me-auto">LTR</span>
											<div class="onoffswitch2"><input type="radio" name="onoffswitch5" id="myonoffswitch54" class="onoffswitch2-checkbox" checked>
												<label for="myonoffswitch54" class="onoffswitch2-label"></label>
											</div>
										</div>
										<div class="switch-toggle d-flex mt-2">
											<span class="me-auto">RTL</span>
											<div class="onoffswitch2"><input type="radio" name="onoffswitch5" id="myonoffswitch55" class="onoffswitch2-checkbox">
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
											<p class="onoffswitch2"><input type="radio" name="onoffswitch1" id="myonoffswitch1" class="onoffswitch2-checkbox" checked>
												<label for="myonoffswitch1" class="onoffswitch2-label"></label>
											</p>
										</div>
										<div class="switch-toggle d-flex">
											<span class="me-auto mt-2">Light Primary</span>
											<div class="">
												<input class="input-color-picker color-primary-light" value="#6c5ffc" id="colorID" type="color" data-id="bg-color" data-id1="bg-hover" data-id2="bg-border" data-id7="transparentcolor" name="lightPrimary">
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
											<p class="onoffswitch2"><input type="radio" name="onoffswitch1"	id="myonoffswitch2" class="onoffswitch2-checkbox">
												<label for="myonoffswitch2" class="onoffswitch2-label"></label>
											</p>
										</div>
										<div class="switch-toggle d-flex">
											<span class="me-auto  mt-2">Dark Primary</span>
											<div class="">
												<input class=" input-dark-color-picker color-primary-dark" value="#6c5ffc" id="darkPrimaryColorID" type="color" data-id="bg-color" data-id1="bg-hover" data-id2="bg-border"	data-id3="primary" data-id8="transparentcolor" name="darkPrimary">
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
											<p class="onoffswitch2"><input type="radio" name="onoffswitch1"	id="myonoffswitchTransparent" class="onoffswitch2-checkbox">
												<label for="myonoffswitchTransparent" class="onoffswitch2-label"></label>
											</p>
										</div>
										<div class="switch-toggle d-flex">
											<span class="me-auto  mt-2">Transparent Primary</span>
											<div class="">
												<input
													class="w-30p h-30 input-transparent-color-picker color-primary-transparent"	value="#6c5ffc" id="transparentPrimaryColorID" type="color" data-id="bg-color"	data-id1="bg-hover" data-id2="bg-border" data-id3="primary"	data-id4="primary" data-id9="transparentcolor" name="tranparentPrimary">
											</div>
										</div>
										<div class="switch-toggle d-flex">
											<span class="me-auto  mt-2">Transparent Background</span>
											<div class="">
												<input
													class="w-30p h-30 input-transparent-color-picker color-bg-transparent"	value="#6c5ffc" id="transparentBgColorID" type="color" data-id5="body" data-id6="theme"	data-id9="transparentcolor" name="transparentBackground">
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
											<input
												class="input-transparent-color-picker color-primary-transparent"	value="#6c5ffc" id="transparentBgImgPrimaryColorID" type="color" data-id="bg-color"	data-id1="bg-hover" data-id2="bg-border" data-id3="primary"	data-id4="primary" data-id9="transparentcolor" name="tranparentPrimary">
										</div>
									</div>
									<div class="switch-toggle d-flex mt-2">
										<a class="bg-img1" href="javascript:void(0);"><img
												src="assets/images/photos/bg-img1.jpg" alt="Bg-Image" id="bgimage1"></a>
										<a class="bg-img2" href="javascript:void(0);"><img
												src="assets/images/photos/bg-img2.jpg" alt="Bg-Image" id="bgimage2"></a>
										<a class="bg-img3" href="javascript:void(0);"><img
												src="assets/images/photos/bg-img3.jpg" alt="Bg-Image" id="bgimage3"></a>
										<a class="bg-img4" href="javascript:void(0);"><img
												src="assets/images/photos/bg-img4.jpg" alt="Bg-Image" id="bgimage4"></a>
									</div>
								</div>
							</div>
							<div class="swichermainleft">
                                <h4>Reset All Styles</h4>
                                <div class="skin-body">
                                    <div class="switch_section my-4">
                                        <button class="btn btn-danger btn-block" id="customresetAll" type="button">Reset All
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
        @yield('message')


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

<!-- Mirrored from laravelui.spruko.com/dayone/error503 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 18 Jul 2023 06:22:38 GMT -->
</html>
