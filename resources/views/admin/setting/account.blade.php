@extends('admin.setting.setting')
@section('subtitle')
Account
@endsection
@section('settings')
<div class="row row-sm">
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i class="nav-icon las la-cog"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Genral</h5>
                        </a>
                        <p>General settings such as, site title, logo, other general and
                            advanced settings.</p>
                        <a href="#">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span
                                class="settings-icon bg-secondary-transparent text-secondary border-secondary"><i class="nav-icon las la-envelope"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Email</h5>
                        </a>
                        <p>In this settings we can change sidemenu and main page can be
                            Controlled System.</p>
                        <a href="#">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-danger-transparent text-danger border-danger"><i class="nav-icon lar la-credit-card"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Payment</h5>
                        </a>
                        <p>Notifications settings we can control the notifications privacy and
                            security settings.</p>
                        <a href="#">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-warning-transparent text-warning border-warning"><i class="nav-icon las la-lock"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Security</h5>
                        </a>
                        <p>Web apps settings such as Apps,Elements & Mail related to web apps
                            can be Controlled.</p>
                        <a href="#">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-warning-transparent text-warning border-warning"><i class="nav-icon las la-share-alt"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Social</h5>
                        </a>
                        <p>Web apps settings such as Apps,Elements & Mail related to web apps
                            can be Controlled.</p>
                        <a href="#">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
