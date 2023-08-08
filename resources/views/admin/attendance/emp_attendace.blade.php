@extends('admin.layout.master')
@section('title')
    Employee Attendance Detail
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
            font-weight: 600;
            font-size: 1em;
        }

        .tl-time {
            font-size: 0.7em;
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
    </style>
@endsection

@section('contents')
    <div class="row">
        <div class="card">
            <div class="card">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="my-5">
                            <h4 class="my-5">Timesheet<span class="fs-14 mx-3 text-muted">Tue, 08th Aug 2023</span></h4>
                        </div>
                        <div class="row mb-5 mt-5">
                            <div class="col-md-4">
                                <div class="pt-5 text-center">
                                    <h6 class="mb-1 fs-16 font-weight-semibold">09:30 AM</h6>
                                    <small class="text-muted fs-14">Punch In</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-circle chart-circle-md" data-value="100" data-thickness="6"
                                    data-color="#0dcd94">
                                    <div class="chart-circle-value text-muted">09:00 hrs</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="pt-5 text-center">
                                    <h6 class="mb-1 fs-16 font-weight-semibold"> 06:30 PM</h6>
                                    <small class="text-muted fs-14">Punch Out</small>
                                </div>
                            </div>
                        </div>
                        <div class="my-5">
                            <div class="row">
                                <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                    <small class="text-muted fs-13">Break Time</small>
                                    <p class="mb-1 fs-14 font-weight-semibold">09:30 AM</p>
                                </div>
                                <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                    <small class="text-muted fs-13">Overtime</small>
                                    <p class="mb-1 fs-14 font-weight-semibold">09:30 AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="">
                            <h4 class="my-5">Statistics</h4>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6>Today</h6>
                                <div class="progress progress-md mb-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-teal"
                                        style="width: 15%">15%</div>
                                </div>
                                <h6>This Week</h6>
                                <div class="progress progress-md mb-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                        style="width: 25%">25%</div>
                                </div>
                                <h6>This Month</h6>
                                <div class="progress progress-md mb-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-yellow"
                                        style="width: 50%">50%</div>
                                </div>
                                <h6>Remaining</h6>
                                <div class="progress progress-md mb-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                        style="width: 70%">40%</div>
                                </div>
                                <h6>Overtime</h6>
                                <div class="progress progress-md">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-green"
                                        style="width: 70%">40%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="">
                            <h4 class="my-5">Timeline</h4>
                        </div>
                        <div class="timeline">
                            <div class="tl-content tl-content-active">
                                <div class="tl-header">
                                    <span class="tl-marker"></span>
                                    <p class="tl-title">Punch In at <br><span class="text-muted fs-14 fw-light">09:59
                                            AM</span>
                                    <p>
                                </div>
                                <div class="tl-header">
                                    <span class="tl-marker"></span>
                                    <p class="tl-title">Punch In at <br><span class="text-muted fs-14 fw-light">09:59
                                            AM</span>
                                    <p>
                                </div>
                                <div class="tl-header">
                                    <span class="tl-marker"></span>
                                    <p class="tl-title">Punch In at <br><span class="text-muted fs-14 fw-light">09:59
                                            AM</span>
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Search by Date:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                                type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="hr-table">
                            <thead>
                                <tr class="text-center">
                                    <th class="border-bottom-0 w-5">Date</th>
                                    <th class="border-bottom-0">Punch In</th>
                                    <th class="border-bottom-0">Punch Out</th>
                                    <th class="border-bottom-0">Production</th>
                                    <th class="border-bottom-0">Break</th>
                                    <th class="border-bottom-0">Overtime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>Aug 08, 2023</td>
                                    <td>09:30 AM</td>
                                    <td>06:30 AM</td>
                                    <td>06:30 Hr</td>
                                    <td>01:30 Hr</td>
                                    <td>04:30 Hr</td>
                                </tr>
                                <tr class="text-center">
                                    <td>Aug 08, 2023</td>
                                    <td>09:30 AM</td>
                                    <td>06:30 AM</td>
                                    <td>06:30 Hr</td>
                                    <td>01:30 Hr</td>
                                    <td>04:30 Hr</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
