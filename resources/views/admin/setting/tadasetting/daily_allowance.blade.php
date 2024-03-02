{{-- <?php dd('aaya new data'); ?> --}}
@extends('admin.pagelayout.master')
@section('title')
    Lodging
@endsection
@section('css')

@endsection
@section('content')
{{-- </livewire:travel-and-daily-allowance.lodging /> --}}
<livewire:travel-and-daily-allowance.daily-allowance />
@endsection
@section('js')
<script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.min.js') }}"></script>
    <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.js') }}"></script>
@endsection


