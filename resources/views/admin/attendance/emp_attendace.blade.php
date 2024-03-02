@extends('admin.pagelayout.master')

@section('title')
    Monthly Attendance
@endsection

@section('js')
    <script src="{{ asset('assets/js/hr/hr-attlist.js') }}"></script>
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

        .abc {
            color: #0e501f3e;
        }

        .table-container {
            overflow-x: auto;
        }

        .table thead th:first-child,
        .table tbody td:first-child {
            position: -webkit-sticky;
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 2;
        }

        .table thead th {
            position: -webkit-sticky;
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 2;
        }

        .table thead th {
            z-index: 1;
        }

    </style>
@endsection

@section('content')
    @if (in_array('Monthly Attendance.All', $permissions) || in_array('Monthly Attendance.View', $permissions))
        <div class=" p-0 py-2 mb-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li class="active"><span><b>Monthly Attendance</b></span></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <livewire:attendance.monthly-attendance-livewire exportable>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
