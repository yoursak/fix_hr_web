    @extends('admin.pagelayout.master')

    @section('title')
        Daily Attendance
    @endsection

    @section('css')
        <style>
            *,
            *::after,
            *::before {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            time {
                line-height: 1;
            }

            .timeline {
                padding: 3rem 2rem;
                max-width: 460px;
                border-radius: 12px;
                background-color: white;
                box-shadow: 0 4px 25px -20px rgba(0, 0, 0.2);
            }

            .tl-content .tl-header,
            .tl-content .tl-body {
                padding-left: 25.6px;
                border-left: 3px solid gainsboro;
            }

            .tl-body {
                padding-bottom: 10px;
            }

            .tl-content:last-child .tl-body {
                border-left: 3px solid transparent;
            }

            .tl-header {
                position: relative;
                display: grid;
                padding-bottom: 5px;
            }

            .tl-title {
                font-weight: 650;
                font-size: 12px;
            }

            .tl-time {
                font-size: 5px;
            }

            .tl-marker {
                display: block;
                position: absolute;
                width: 16px;
                height: 16px;
                border-radius: 50% / 50%;
                background: gainsboro;
                left: -1.1rem;
                transform: translate(50%, -50%);
            }

            .tl-content-active .tl-marker {
                padding: 1.6px;
                margin-top: 10px;
                left: -1.25rem;
                width: 18px;
                border: 2px solid #8c8c96;
                background-color: #8c8c96;
                background-clip: content-box;
                box-shadow: 0 0 15px -2px #8c8c96;
            }

            tr {
                line-height: 1.5;
            }
        </style>
    @endsection

    @section('css')
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>
        <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
        <script src="{{ asset('assets/js/hr/hr-attlist.js') }}"></script>
    @endsection
    @section('content')
        @php
            $nss = new App\Helpers\Central_unit();
            $so = $nss->misPunchRuleFunction(Session::get('business_id'), date('Y-m-d'));
        @endphp
        @if (in_array('Daily Attendance.All', $permissions) || in_array('Daily Attendance.View', $permissions))
            <div class=" p-0 pb-4">
                <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                    <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li class="active"><span><b>Daily Attendance</b></span></li>
                </ol>
            </div>

            <livewire:attendance.attendance-livewire>

                <script>
                    // Function to check if input field is not empty
                    function checkInputNotEmpty() {
                        var inTime = document.getElementById('punchInTime');
                        var OutTime = document.getElementById('punchOutTime');
                        var inVal = inTime.value.trim();
                        var outVal = OutTime.value.trim();
                        console.log(inVal, outVal);
                        if (outVal === '' || outVal === '---' || outVal === '' || outVal === '---') {
                            alert('Input field cannot be empty!');
                            return false;
                        }
                        return true;
                    }
                    document.querySelector('#CorrectionSubmit').addEventListener('click', function(event) {
                        if (!checkInputNotEmpty()) {
                            event.preventDefault();
                        }
                    });
                </script>

                <script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}"></script>
                <script src="{{ asset('assets/plugins/apexchart/apexcharts.js') }}"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

                <script>
                    function calculateWorkingHours(punchInTime, punchOutTime) {
                        // Split the time values into hours, minutes, and seconds

                        if (punchInTime === null || punchOutTime == null || punchOutTime == '' || punchInTime === '') {
                            return null; // If either parameter is null, return null
                        }
                        var punchInParts = punchInTime.split(":");
                        var punchOutParts = punchOutTime.split(":");

                        // Parse hours, minutes, and seconds
                        var punchInHours = parseInt(punchInParts[0]);
                        var punchInMinutes = parseInt(punchInParts[1]);
                        var punchInSeconds = parseInt(punchInParts[2]);

                        var punchOutHours = parseInt(punchOutParts[0]);
                        var punchOutMinutes = parseInt(punchOutParts[1]);
                        var punchOutSeconds = parseInt(punchOutParts[2]);

                        // Calculate the time difference
                        var totalHours = punchOutHours - punchInHours;
                        var totalMinutes = punchOutMinutes - punchInMinutes;
                        var totalSeconds = punchOutSeconds - punchInSeconds;

                        // Handle carryovers and negative values
                        if (totalSeconds < 0) {
                            totalSeconds += 60;
                            totalMinutes--;
                        }
                        if (totalMinutes < 0) {
                            totalMinutes += 60;
                            totalHours--;
                        }

                        // Check if the result is negative
                        if (totalHours < 0) {
                            return null; // Return null for negative time values
                        }

                        // Format the result as "HH:MM:SS"
                        var workingHours = totalHours.toString().padStart(2, '0') + ":" +
                            totalMinutes.toString().padStart(2, '0') + ":" +
                            totalSeconds.toString().padStart(2, '0');

                        return workingHours;
                    }

                    function checkboxcheck(checked, id) {
                        var new_data = $(checked).data('my_id');


                        var elm = document.getElementById('check_my_data' + id);

                        if (elm) {
                            if (elm.checked) {
                                // $('#hdkfh' + id).val(1);
                                $('#myAttendanceCheck' + id).val("1");


                            } else {

                                $('#myAttendanceCheck' + id).val("0");

                            }
                        } else {

                        }
                    }

                    function checkbox_dd(context) {
                        if ($('.custom-control-input-success').prop('checked')) {
                            $('.checkbox-checkbox').prop('checked', true); // Check the checkboxes

                        } else {
                            $('.checkbox-checkbox').prop('checked', false); // Uncheck the checkboxes

                        }
                    }
                </script>
        @endif
    @endsection
