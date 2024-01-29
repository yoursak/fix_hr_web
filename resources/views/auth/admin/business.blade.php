@extends('auth/admin/authlayout.master_simple')
@section('title', 'Business Create')
@section('css')
<style>
    /* Adjust the OK button size */
/* .swal-button {
    padding: 10px 20px;
    font-size: 16px;
} */

.swal2-actions .swal2-confirm {
  border: none !important;
  box-shadow: none !important;
  font-size: 12px !important;
}

</style>
@endsection
@section('js')

@endsection
@section('content')
    <style>
        .btn-primary:hover {
            color: white;
        }
    </style>
    <div class="row d-flex justify-content-center">
        <div class="col-sm-12 col-md-8 col-sm-6">
            <div class="card p-0">
                <img src="{{ url('assets/logo/FixHR.png') }}"   t="" class="img-fluid mb-4 mx-auto"
                    style="display: block; width: 35%;">

                <div class="card-header border-bottom-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="display-7 mb-0 card-title"><b>Register Your Business Details</b></h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('businessVerify') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><b>Business Category</b></label>
                                    <select style="" class="form-control text-muted " name="businessCategory"
                                        data-placeholder="Select Business Category" required>
                                        <option label="Select Business Category"></option>
                                        @foreach ($businessCat as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><b>Business Type</b></label>
                                    <select class="form-control text-muted" name="businessType"
                                        data-placeholder="Select Business Type" required>
                                        <option label="Select Business Type"></option>
                                        @foreach ($businessType as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><b>Name</b></label>
                                    <input autocapitalize="true" type="text" name="name" class="form-control"
                                        placeholder="Enter Your Name" required>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><b>Business Name</b></label>
                                    <input type="text" autocapitalize name="bname" class="form-control"
                                        placeholder="Enter Business Name" required>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><b>Email Address</b></label>
                                    <input type="email" name="bemail" class="form-control" placeholder="Enter Email"
                                        value="{{ Session()->get('firstEmail') }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><b>Phone Number</b></label>
                                    <input type="tel" name="phone" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);" placeholder="Enter Mobile No."
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><b>Country</b></label>
                                    <select class="form-control" aria-label="Type" name="country"  onchange="getState(this.value)" required>
                                        <option value="" label="Select Country Name">Select Country Name</option>
                                        @foreach ($country as $item)
                                            <option value="{{ $item->id }}" label="{{ $item->name }}">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><b>State</b></label>
                                    <select id="getStateId"
                                        name="state" class="form-control" onchange="getCity(this.value)"  required>
                                        <option value="">Select State Name</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><b>City/District</b></label>
                                    <select id="getCityId" name="city" class="form-control state1"  required>
                                        <option value="">Select City Name</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div class="row">

                                    <div class="col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"><b>Zip Code</b></label>
                                            {{-- <input type="text" name="pin" class="form-control"
                                                placeholder="Zip Code"> --}}
                                                {{-- <input type="text" maxlength="6" name="pin" class="form-control" pattern="^[0-9]*$" inputmode="numeric" placeholder="Zip Code"> --}}
                                                <input type="text" maxlength="6" name="pin" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);" placeholder="Zip Code" required>
                                        </div>
                                    </div>
                                    <livewire:business-registration.gst-validation />
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">

                                    <!-- <div class="col-sm-6 col-md-6">
                                                            <input type="file" name="image" class="dropify" data-height="100" data-width="400" />
                                                        </div> -->
                                    {{-- <div class="col-sm-6 col-md-6"> --}}
                                    <div class="form-group">
                                        <label class="form-label"><b>Address</b></label>
                                        <textarea rows="6" name="address" class="form-control" placeholder="Enter Business Address" required></textarea>
                                    </div>
                                    {{--
                                </div> --}}
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label" style="text-align: center;"><b>Upload Your Business
                                            Logo</b></label>

                                    <input type="file" name="image" class="dropify dropifyset " data-height="100"
                                        data-width="300" required />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn  btn-primary mt-3 mb-4 rounded"
                                style="background-color:#1877F2;text-color:white;" type="submit">Save & Continue</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <svg width="100%" height="250px" version="1.1" xmlns="http://www.w3.org/2000/svg" class="wave bg-wave">
        <title>Wave</title>
        <defs></defs>
        <path id="feel-the-wave" d="" />
    </svg>
    <svg width="100%" height="250px" version="1.1" xmlns="http://www.w3.org/2000/svg" class="wave bg-wave">
        <title>Wave</title>
        <defs></defs>
        <path id="feel-the-wave-two" d="" />
    </svg>
    <svg width="100%" height="250px" version="1.1" xmlns="http://www.w3.org/2000/svg" class="wave bg-wave">
        <title>Wave</title>
        <defs></defs>
        <path id="feel-the-wave-three" d="" />
    </svg>

    <script src="{{ asset('wavetemplate/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('wavetemplate/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('wavetemplate/js/waves.min.js') }}"></script>
    <script src="{{ asset('wavetemplate/js/pages/TweenMax.min.js') }}"></script>
    <script src="{{ asset('wavetemplate/js/pages/jquery.wavify.js') }}"></script>
    <script src="{{ asset('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>

    <script>
        function getState(countryValue) {
            console.log("countryValue ", countryValue);
            var $stateId = $('#getStateId'); // Assuming you have an element with id "getStateId"
            $.ajax({
                url: "{{ route('getstate') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    state: null,
                    country: countryValue
                },
                dataType: 'json',
                cache: true,
                success: function(result) {
                    console.log("result ", result);
                    var state = result.states;

                    $stateId.html('');

                    var defaultOption = $('<option>').val('').text('Select State Name').attr('selected', true);
                    $stateId.append(defaultOption);

                    state.forEach(function(element) {
                        var option = $('<option>').val(element.id).text(element.name);
                        $stateId.append(option);
                    });
                },
                error: function(error) {
                    console.error('Error fetching states:', error);
                }
            });
        }

        function getCity(stateValue) {
            // console.log('Hello');
            $cityId = $('#getCityId');
            $.ajax({
                url: "{{ route('getCity') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    state: stateValue
                },
                dataType: 'json',
                cache: true,
                success: function(result) {
                    console.log("city ", result);
                    var city = result.city;
                    var defaultOptioncity = $('<option>').val('').text('Select City Name').attr('selected', true);
                    $cityId.html('');
                    $cityId.append(defaultOptioncity);

                    city.forEach(function(element) {
                        var option = $('<option>').val(element.id).text(element.name);
                        $cityId.append(option);
                    });
                }
            });
        }
    </script>

    <script>
        $('#feel-the-wave').wavify({
            height: 100,
            bones: 3,
            amplitude: 90,
            color: 'rgba(72, 134, 255, 4)',
            speed: .25
        });
        $('#feel-the-wave-two').wavify({
            height: 70,
            bones: 5,
            amplitude: 60,
            color: 'rgba(72, 134, 255, .3)',
            speed: .35
        });
        $('#feel-the-wave-three').wavify({
            height: 50,
            bones: 4,
            amplitude: 50,
            color: 'rgba(72, 134, 255, .2)',
            speed: .45
        });
    </script>


@endsection
