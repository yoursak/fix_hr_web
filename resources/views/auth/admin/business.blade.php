<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from html.phoenixcoded.net/mintone/bootstrap/default/auth-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 Dec 2022 09:46:53 GMT -->

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
    <div class="row d-flex justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="display-6 card-title"><b>Business Details</b></div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <input type="file" class="dropify"
                                data-default-file="{{asset('imgs/business.gif')}}"
                                data-height="180" />
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Business Category</label>
                                <select class="form-control  select2" data-placeholder="Select Country">
                                    <option label="Select Country"></option>
                                    <option value="1">Germany</option>
                                    <option value="2">Canada</option>
                                    <option value="3">Usa</option>
                                    <option value="4">Afghanistan</option>
                                    <option value="5">Albania</option>
                                    <option value="6">China</option>
                                    <option value="7">Denmark</option>
                                    <option value="8">Finland</option>
                                    <option value="9">India</option>
                                    <option value="10">Kiribati</option>
                                    <option value="11">Kuwait</option>
                                    <option value="12">Mexico</option>
                                    <option value="13">Pakistan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Business Name</label>
                                <input type="text" class="form-control" placeholder="Business Name">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Owner Name</label>
                                <input type="text" class="form-control" placeholder="Owner Name">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" value="XXXXXsin@gmail.com" placeholder="Email" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" placeholder="eg. +91 XXXXXXXXX5">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <textarea name="" rows="2"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-end">
                    <a  href="{{url('admin/branch')}}" class="btn btn-primary">Save & Continue</a>
                    <a  href="#" class="btn btn-outline-primary">Skip</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="{{ asset('assetss/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assetss/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assetss/js/waves.min.js') }}"></script>
<script src="{{ asset('assetss/js/pages/TweenMax.min.js') }}"></script>
<script src="{{ asset('assetss/js/pages/jquery.wavify.js') }}"></script>
<!-- JQUERY JS -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- BOOTSTRAP JS-->
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- SELECT2 JS -->
<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

<!-- P-SCROLL JS -->
<script src="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script>

<!--STICKY JS -->
<script src="{{ asset('assets/js/sticky.js') }}"></script>

<!-- COLOR THEME JS-->
<script src="{{ asset('assets/js/themeColors.js') }}"></script>

<!-- CUSTOM JS -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- SWITCHER -->
<script src="{{ asset('assets/switcher/js/switcher.js') }}"></script>

<!-- INTERNAL FORM ADVANCED ELEMENT JS -->
<script src="{{ asset('assets/js/formelementadvnced.js') }}"></script>
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
