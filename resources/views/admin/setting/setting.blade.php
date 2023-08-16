@extends('admin.layout.master')
@section('title')
    Settings
@endsection

@section('contents')
    <!-- ROW -->
    <div class="row ">
        <div class="col-lg-12 col-xl-12">
            @yield('settings')
        </div>
    </div>
    <!-- END ROW -->
@endsection
