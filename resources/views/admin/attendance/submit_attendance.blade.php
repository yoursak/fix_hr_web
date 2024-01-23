@extends('admin.pagelayout.master')
@section('title', 'Submit-Attendance')
@section('css')
   
@endsection
@section('content')
    <div class=" p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li class="active"><span><b>Submit Attendance</b></span></li>
        </ol>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Submit Attendance
                    </div>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="row">
                                <div class="col-6">
                                    <select name="dataMonth" class="form-control text-center" id="dataMonth"
                                        onchange="getAttendanceData()" data-placeholder="Select Month"
                                        style="width:100px; border:solid 1px black">
                                        <option label="Month"></option>
                                        <?php
                                        for ($month = 1; $month <= 12; $month++) {
                                            $monthName = date('F', mktime(0, 0, 0, $month, 1));
                                            $selected = $month == date('n') ? 'selected="selected"' : '';
                                            echo '<option value="' . $month . '" ' . $selected . '>' . $monthName . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="dataYear" class="form-control text-center" id="dataYear"
                                        onchange="getAttendanceData()" data-placeholder="Year"
                                        style="width:100px; border:solid 1px black">
                                        <option label="Select Year"></option>
                                        <?php
                                        $currentYear = date('Y');
                                        for ($year = $currentYear; $year >= 1897; $year--) {
                                            $selected = $year == $currentYear ? 'selected="selected"' : '';
                                            echo '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
    <!-- END ROW -->

@endsection

@section('js')
    

@endsection
