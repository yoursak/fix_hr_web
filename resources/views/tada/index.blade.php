@extends('admin.pagelayout.master2')
@section('subtitle')
    Business
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="nav-icon fa fa-sitemap"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">Contry amd State </h5>
                                </a>
                                <p class="my-auto">&nbsp;Travel

                                </p>
                            </div>
                            <div class="my-auto"> <a href="{{ url('admin/settings/tada/city') }}"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="nav-icon fa fa-sitemap"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">Travel type</h5>
                                </a>
                                <p class="my-auto">&nbsp;Travel
                                </p>
                            </div>
                            <div class="my-auto"> <a href="{{ url('admin/settings/tada/travel_country') }}"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary">
                                <i class="fa fa-car fs-20 my-auto"></i>
                            </span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">TA</h5>
                                </a>
                                <p class="my-auto">
                                    &nbsp;Travel allowance
                                </p>
                            </div>
                            <div class="my-auto"> <a href="{{ url('admin/settings/tada/ta') }}"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary">
                                <i class="fa fa-credit-card fs-20 my-auto"></i>
                            </span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">DA</h5>
                                </a>
                                <p class="my-auto">&nbsp;Daily Allowance
                                    {{-- | assign to 25/50
                                            employees --}}
                                </p>
                            </div>
                            <div class="my-auto"> <a href="{{ url('admin/settings/tada/daily') }}"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="fa fa-bed fs-20 my-auto"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">Lodging</h5>
                                </a>
                                <p class="my-auto">&nbsp;Hotel

                                </p>
                            </div>
                            <div class="my-auto"> <a href="{{ url('admin/settings/tada/lodging') }}"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary">
                                <i class="fe fe-sliders"></i>
                            </span>
                            {{-- <i class="zmdi zmdi-city-alt"></i> --}}
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">Toll Tax</h5>
                                </a>
                                <p class="my-auto">&nbsp;Toll Tax</p>
                            </div>
                            <div class="my-auto"><a href="{{ url('admin/settings/tada/toll') }}"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="fa fa-random"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"> <a href="#">
                                    <h5 class="my-auto text-dark">Other miscellaneous</h5>
                                </a>
                                <p class="my-auto">&nbsp;Other miscellaneous</p>
                            </div>
                            <div class="my-auto"> <a href="{{ url('admin/settings/tada/other') }}"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="mdi mdi-airplane"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">Travel Mode</h5>
                                </a>
                                <p class="my-auto">&nbsp;Travel Mode</p>
                            </div>
                            <div class="my-auto"> <a href="{{ url('admin/settings/tada/travel_mode') }}"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="mdi mdi-airplane"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">Promotional Category</h5>
                                </a>
                                <p class="my-auto">&nbsp;Promotaional</p>
                            </div>
                            <div class="my-auto"> <a href="{{ url('admin/settings/tada/promotional_category') }}"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
