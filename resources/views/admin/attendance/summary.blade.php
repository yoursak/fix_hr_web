@extends('admin.pagelayout.master')
@section('title', 'Attendance Summary')
@if (in_array('Attendance Summary.All', $permissions) || in_array('Attendance Summary.View', $permissions))

    @section('content')
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li class="active"><span><b>Attendance Summary</b></span></li>
            </ol>
        </div>
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Attendance Summary
                        </div>
                    </div>
                    <div class="card-body">
                        <livewire:attendance.attendance-summary-lvewire>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif
