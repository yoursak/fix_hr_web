<!-- JQUERY JS -->
<script src={{ asset('assets/plugins/jquery/jquery.min.js') }}></script>

<!-- BOOTSTRAP JS -->
<script src={{ asset('assets/plugins/bootstrap/js/popper.min.js') }}></script>
<script src={{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}></script>

<!-- MOMENT JS -->
<script src={{ asset('assets/plugins/moment/moment.js') }}></script>

<!-- CIRCLE-PROGRESS JS -->
<script src={{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}></script>

<!--SIDEMENU JS -->
<script src={{ asset('assets/plugins/sidemenu/sidemenu.js') }}></script>

<!-- P-SCROLL JS -->
<script src={{ asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}></script>
<script src={{ asset('assets/plugins/p-scrollbar/p-scroll1.js') }}></script>

<!--SIDEBAR JS -->
<script src={{ asset('assets/plugins/sidebar/sidebar.js') }}></script>

<!-- SELECT2 JS -->
<script src={{ asset('assets/plugins/select2/select2.full.min.js') }}></script>

<!-- INTERNAL DATEPICKER JS -->
<script src={{ asset('assets/plugins/date-picker/jquery-ui.js') }}></script>

<!-- INTERNAL TIMEPICKER JS -->
<script src={{ asset('assets/plugins/time-picker/jquery.timepicker.js') }}></script>
<script src={{ asset('assets/plugins/time-picker/toggles.min.js') }}></script>

<!-- INTERNAL CHART JS -->
<script src={{ asset('assets/plugins/chart/chart.bundle.js') }}></script>
<script src={{ asset('assets/plugins/chart/utils.js') }}></script>

<!-- INTERNAL CHARTJS ROUNDED-BARCHART -->
<script src={{ asset('assets/plugins/chart.min/chart.min.js') }}></script>
<script src={{ asset('assets/plugins/chart.min/rounded-barchart.js') }}></script>

<!-- INTERNAL DATA TABLES  -->
<script src={{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}></script>
<script src={{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}></script>
<script src={{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}></script>
<script src={{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}></script>
<script src={{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}></script>
<script src={{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}></script>

<!-- INTERNAL PG-CALENDAR-MASTER JS -->
<script src={{ asset('assets/plugins/pg-calendar-master/pignose.calendar.full.min.js') }}></script>

<!-- INTERNAL jQUERY-COUNTDOWNTIMER JS -->
<script src={{ asset('assets/plugins/jQuery-countdowntimer/jQuery.countdownTimer.js') }}></script>

<!-- INTERNAL DATERANGEPICKER JS -->
<script src={{ asset('assets/plugins/daterangepicker/moment.min.js') }}></script>
<script src={{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}></script>

<!-- INTERNAL INDEX JS -->
<script src={{ asset('assets/js/index2.js') }}></script>

<!-- STICKY JS -->
<script src={{ asset('assets/js/sticky.js') }}></script>

<!-- COLOR THEME JS  -->
<script src={{ asset('assets/js/themeColors.js') }}></script>

<!-- CUSTOM JS -->
<script src={{ asset('assets/js/custom.js') }}></script>

<!-- SWITCHER JS -->
<script src={{ asset('assets/switcher/js/switcher.js') }}></script>


<!-- INTERNAL  DATEPICKER JS -->
<script src={{ asset('assets/plugins/date-picker/jquery-ui.js') }}></script>
<!-- INTERNAL DATA TABLES  -->
<script src={{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}></script>
<script src={{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}></script>
<script src={{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}></script>
<script src={{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}></script>
<script src={{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}></script>
<script src={{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}></script>


<!-- INTERNAL INDEX JS -->
<script src={{ asset('assets/js/hr/hr-attview.js') }}></script>
<!-- INTERNAL INDEX JS -->
<script src={{ asset('assets/js/employee/emp-attendance.js') }}></script>
<script src={{ asset('assets/js/hr/hr-attmark.js') }}></script>

<!-- P-SCROLL JS -->
<script src={{ asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}></script>
<script src={{ asset('assets/plugins/p-scrollbar/p-scroll1.js') }}></script>

<!--SIDEBAR JS -->
<script src={{ asset('assets/plugins/sidebar/sidebar.js') }}></script>

<!-- SELECT2 JS -->
<script src={{ asset('assets/plugins/select2/select2.full.min.js') }}></script>

<!-- INTERNAl JQUERY STEPS JS -->
<script src={{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}></script>
<script src={{ asset('assets/plugins/parsleyjs/parsley.min.js') }}></script>

<!-- INTERNAL FORM-WIZARD JS -->
<script src={{ asset('assets/plugins/formwizard/jquery.smartWizard.js') }}></script>
<script src={{ asset('assets/plugins/formwizard/fromwizard.js') }}></script>

<!-- INTERNAL ACCORDION-WIZARD JS -->
<script src={{ asset('assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js') }}></script>
<script src={{ asset('assets/js/form-wizard.js') }}></script>

<!-- INTERNAL FILE-UPLOADS JS -->
<script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

<!-- INTERNAL FILE-UPLOADS JS -->
<script src="{{ asset('assets/plugins/fileupload/js/dropify.js')}}"></script>
<script src="{{ asset('assets/js/filupload.js')}}"></script>


<script>
    $("#calenderbtn").click(function() {
        $("#calendertbl").fadeToggle();
        $("#calendertbl").removeClass("d-none");
    });
</script>

<script>
    // script for dashboard
    $(document).ready(function() {
        $('#unpaidbreak').click(function(e) {
            $('#unpaidbreak').addClass('d-none');
            $('#unpaidbreaktbl').addClass('d-block');
        })

    });

    // script for shift create page
    $(document).ready(function() {

        $('#unpaiddelete').click(function(e) {
            $('#unpaidbreak').removeClass('d-none');
            $('#unpaidbreaktbl').removeClass('d-block');
        })

        // display input box for break time
        $('#addtime').click(function(e) {
            $('#addtime').addClass('d-none');
            $('#breaktime').addClass('d-block');
        })

        $('#shifttype').change(function(e) {
            $val = $('#shifttype').val();
            if ($val == 'fs') {
                $('#shifttime').removeClass('d-none');
                $('#unpaidbreaklabel').removeClass('d-none');
                $('#unpaidbreak').removeClass('d-none');
                $('#workhour').addClass('d-none');
                $('#additionaltbl').addClass('d-none');
            } else if ($val == 'rs') {
                $('#shifttime').addClass('d-none');
                $('#unpaidbreaklabel').addClass('d-none');
                $('#unpaidbreak').addClass('d-none');
                $('#workhour').addClass('d-none');
                $('#additionaltbl').removeClass('d-none');
            } else {
                $('#shifttime').addClass('d-none');
                $('#unpaidbreaklabel').addClass('d-none');
                $('#unpaidbreak').addClass('d-none');
                $('#workhour').removeClass('d-none');
                $('#additionaltbl').addClass('d-none');
            }
        });
    });

    //Late Entry Rule Page
    $(document).ready(function() {
        $('#occurence').change(function() {
            $val = $('#occurence').val();
            if ($val == 'count') {
                $('#o_time').addClass('d-none');
                $('#o_count').removeClass('d-none');
            } else {
                $('#o_time').removeClass('d-none');
                $('#o_count').addClass('d-none');
            }
        });

        $('#o_check').change(function() {
            if (this.checked) {
                $('#rowMx').removeClass('d-none');
            } else {
                $('#rowMx').addClass('d-none');
            }
        });

        $('#add_elem').click(function(e) {
            $("#more_time_range").clone().appendTo("#elem");
        });

        $('#remove_elem').click(function(e) {
            $("#more_time_range").remove();
        });

        $('#rule1').change(function() {
            if (this.checked) {
                $('#main_elem').removeClass('d-none');
                $('#next_btn').removeClass('d-none');
            } else {
                $('#main_elem').addClass('d-none');
                $('#next_btn').addClass('d-none');
            }
        });
    });


    //Add Delete Bussiness Section in setting

    $(document).ready(function() {
        $('#anbbtn2').click(function (e) {
           $('#anbbtns1').removeClass('d-none');
           $('#anbbtns').addClass('d-none');
           $('#anbc').removeClass('d-none');
           $('#anbc1').addClass('d-none');
        });

        $('#anbbtn3').click(function (e) {
           $('#anbbtns1').addClass('d-none');
           $('#anbbtns').removeClass('d-none');
           $('#anbc').addClass('d-none');
           $('#anbc1').removeClass('d-none');
        });
    });
</script>
