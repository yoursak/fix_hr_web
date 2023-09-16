@extends('admin.setting.setting')
@section('subtitle')
    Attendance
@endsection
@section('css')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 35px;
            height: 15px;
        }

        .switch input {
            opacity: 0;
            width: 1px;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 9px;
            width: 7px;
            left: 1px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 50px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection
@section('settings')
    <div class="row row-sm d-flex justify-content-center">
        <div class="col-xl-12">
            <div class="page-header d-md-flex d-block">
                <div class="page-leftheader">
                    <div class="page-title">Settings    </div>
                    <div aria-label="breadcrumb ">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                            {{-- <li >/</li> --}}
                            <li class="breadcrumb-item" aria-current="page"><a href="">Notification </a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="card custom-card">
                <div class="card-body">
                    <h4>Notification
                    </h4>
                    <div class="card-body">
                        <ul class="list-group ">
                            <li class="list-group-item d-flex justify-content-between ">
                                <b class="my-auto">Employee</b>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round d-flex justify-content-between"></span>
                                </label>
                            </li>
                            <li class="list-group-item d-flex justify-content-between"><b class="my-auto">Leave Request
                                </b><label class="switch my-auto">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label></li>
                            <li class="list-group-item d-flex justify-content-between"><b class="my-auto">Holiday </b><label
                                    class="switch my-auto">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label></li>
                            <li class="list-group-item d-flex justify-content-between"><b class="my-auto">Mis-Punch Request
                                </b> <label class="switch my-auto">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label></li>
                            <li class="list-group-item d-flex justify-content-between"><b class="my-auto">Gate-Pass Request
                                </b><label class="switch my-auto">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label></li>
                            <li class="list-group-item d-flex justify-content-between"><b class="my-auto">Attendance
                                </b><label class="switch my-auto">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label></li>
                            <li class="list-group-item d-flex justify-content-between"><b class="my-auto">Notice Board
                                </b><label class="switch  my-auto">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label></li>
                            <li class="list-group-item d-flex justify-content-between"><b class="my-auto">Alarm </b><label
                                    class="switch  my-auto">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label></li>
                            <li class="list-group-item d-flex justify-content-between"><b class="my-auto">Birthday
                                </b><label class="switch my-auto">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label></li>
                        </ul>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
