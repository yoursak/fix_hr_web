@extends('admin.setting.setting')
@section('subtitle')
    Attendance
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
                            <li class="breadcrumb-item" aria-current="page"><a href="">Localization </a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="card custom-card">

                <div class="card-body">
                    <h4>Basic Settings
                    </h4>
                    <form>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">Default Country</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>India</option>
                                        <option>Japan</option>
                                        <option>US</option>
                                        <option>Pakistan</option>
                                        <option>Shrilanka</option>
                                        <option>Afganistan</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Date Format</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>15/05/2023</option>
                                        <option>15-05-2023</option>
                                        <option>15.05.2023</option>
                                        <option>05/15/2023</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">TimeZone</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>5.00 GMT</option>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAddress2">Default Language</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>English</option>
                                        <option>Hindi</option>
                                    </select>
                                </div>
                                <br>
                                <br>
                                <div class="form-group col-md-12 text-end pt-4">
                                    <button type="submit" class=" text-center btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
