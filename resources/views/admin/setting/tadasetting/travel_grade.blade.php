@extends('admin.pagelayout.master')
@section('title')
    Travel Grade
@endsection
@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/jayant-sumoselect/sumoselect.css') }}" media="screen"
        wire:ignore />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/jayant-sumoselect/sumoselect.min.css') }}" media="screen"
        wire:ignore /> --}}
@endsection
@section('content')
    <livewire:travel-and-daily-allowance.travelgrade />
@endsection
@section('js')

    {{-- start attechment uses jquery.sumo-select-package --}}
    <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.min.js') }}"></script>
    <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.js') }}"></script>
    {{-- end  --}}
@endsection
