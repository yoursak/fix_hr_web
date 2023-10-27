@extends('admin.setupLayout.master')
@section('title')
    Settings
@endsection

@section('content')
    <!-- ROW -->
    <div class="row ">
        <div class="col-lg-12 col-xl-12">
            
            @yield('settings')
        </div>
    </div>
    <!-- END ROW -->
@endsection
