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
            background-color: #1877f2;
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
        /* .breadcrumb-arrow li a:after {
            border-left: 25px rgb(10, 4, 4);
        } */
        .breadcrumb-arrow li a{
            border-left: 20px rgb(123, 255, 0);
        }

    </style>
@endsection
@section('settings')

<div class=" p-0 mt-3 mb-5">
    <ol class="breadcrumb breadcrumb-arrow  m-0 p-0" style="background: none; color:red">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/settings/notification')}}">Settings</a></li>
        <li class="active"><span><b>Notification Setting</b></span></li>
    </ol>
</div>
    <div class="row row-sm d-flex justify-content-center">
        <div class="col-xl-12">
            
            <div class="card custom-card">
                <div class="card-body">
                    <h4>Basic Notification Settings
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
