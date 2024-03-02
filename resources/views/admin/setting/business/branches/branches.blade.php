{{-- @extends('admin.setting.setting') --}}
@extends('admin.pagelayout.master')
@section('title')
Branch Settings
@endsection

@section('css')
<style>
    .rotate {
        transition: 500ms;
        transform: rotate(90deg);
        /* Adjust the desired rotation value */
    }

    .bg-inf {
        /* background-color: #a3d5dd; */
        /* Change to your desired color */
    }

    .star-dot {
        color: red;
    }
</style>
@endsection
@section('content')
<style>
    /* Set the map's size */
    #map {
        height: 400px;
        width: 100%;
    }

    /* Adjust the search input style */
    #searchInput {
        width: 100%;
        margin-bottom: 10px;
    }

    #editaddressNameId {
        width: 100%;
        margin-bottom: 10px;

    }

    #mapeditload {
        height: 400px;
        width: 100%;

    }

    .pac-container {
        z-index: 10000 !important;
        /* Set a high z-index for the autocomplete dropdown */
    }
</style>
@php
$root = new App\Helpers\Central_unit();
$branchCount = $root->CountersValue();
$i = 0;
foreach ($branch as $item) {
$i++;
}
@endphp
@if (in_array('Branch Settings.View', $permissions) || in_array('Branch Settings.All', $permissions))
<div class=" p-0 mt-3">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/settings/business') }}">Business Settings</a></li>
        <li class="active"><span><b>Branch Settings</b></span></li>
    </ol>
</div>
<div class="page-header d-md-flex d-block">

    <div class="page-leftheader">
        <div class="page-title">Branch Settings</div>
        <p class="text-muted m-0">
            <?= $branchCount[0] ?> Active Branch
        </p>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block ms-auto">
                <div class="btn-list">
                    @if (in_array('Branch Settings.Create', $permissions) || in_array('Branch Settings.All', $permissions))
                    <a id="addNewBranch" class="btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#branchName">Create Branch</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Branch List</h3>
    </div>
    <div class="card-body p-2">
        <livewire:settings.branch-list>
    </div>
</div>

<div class="modal fade" id="editBranchName" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Update Branch Settings</h4><button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="{{ route('admin.branchupdate') }}">
                @csrf
                <div class="modal-body">
                    <div class="col-lg">
                        <input type="text" id="editId" name="editBranchId" hidden>
                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Name<span class="star-dot">*</span></p>
                        <input class="form-control" id="editbranchNameId" placeholder="Branch Name" type="text" name="editbranch" required>
                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Email<span class="star-dot">*</span></p>
                        <input class="form-control" id="editbranchEmailId" placeholder="Branch Email" type="email" name="editemail" required>
                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Address<span class="star-dot">*</span></p>
                        <input class="form-control " id="editaddressNameId" type="text" placeholder="Address Name" name="editaddress" required>
                        <input type="text" id="logituder2" name="logitudeedit" placeholder="Logitude" readonly>
                        <input type="text" id="latituder2" name="latitudeedit" placeholder="Latitude" readonly>
                        <div class="m-1" id="mapeditload"></div>
                        <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-primary savebtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="branchName" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Branch Settings</h4><button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="{{ route('add.branch') }}" onsubmit="return validateForm()">
                <div class="modal-body">
                    <div class="col-lg">
                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Name<span class="star-dot">*</span></p>
                        <input class="form-control" name="branch" placeholder="Branch Name" type="text" required>
                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Email<span class="star-dot">*</span></p>
                        <input class="form-control" name="email" placeholder="Branch Email" type="email" required>

                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Address<span class="star-dot">*</span></p>
                        {{-- <input class="form-control" placeholder="Address Name" type="text" value=""
                                name="address"> --}}

                        <input class="form-control" type="text" id="searchInput" name="location" placeholder="Search Your location" required>
                        <input type="text" id="logituder1" name="logitude" value="" placeholder="Logitude" readonly required>
                        <input type="text" id="latituder1" name="latitude" value="" placeholder="Latitude" readonly required>
                        <!-- Display the map -->
                        <div class="m-1" id="map"></div>

                        <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    @csrf
                    <button type="reset" class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary savebtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function validateForm() {
        // Get the latitude and longitude values
        var latitude = document.getElementById('latituder1').value;
        var longitude = document.getElementById('logituder1').value;

        // Check if either latitude or longitude is empty
        if (latitude === '' || longitude === '') {
            alert('Please select a location on the map.');
            return false; // Prevent form submission
        }

        // If both latitude and longitude have values, allow the form submission
        return true;
    }
</script>
{{-- modal for delete confirmation --}}
<div>
    <div class="modal fade" id="branchDeletebtn" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('delete.branch') }}" method="POST">
                    @csrf
                    <input type="text" id="branch_id" name="branch_id" hidden>
                    <div class="modal-body text-center">
                        <h4 class="mt-5">Are you sure want to Delete, <span class="text-primary" id="assign_branch">{{ $item->branch_id ?? 0 }}</span> ?</h4>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-danger" id="">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let map;
    let editMap;
    let logitudeEdit;
    let latitudeEdit;
    let addressEdit;

    function ItemDeleteModel(context) {
        var id = $(context).data('branch_id');
        var name = $(context).data('branch_name')
        $('#branch_id').val(id);
        $('#assign_branch').text(name);

    }

    function openEditDesignation(context) {
        var id = $(context).data('id');
        var branch_name = $(context).data('branch_name');
        var branch_email = $(context).data('branch_email');
        var address = $(context).data('address');
        var logitude = $(context).data('logitude');
        var latitude = $(context).data('latitude');
        console.log(id);
        $('#editId').val(id);
        $('#editbranchNameId').val(branch_name);
        $('#editbranchEmailId').val(branch_email);
        $('#editaddressNameId').val(address);
        $('#logituder2').val(logitude);
        $('#latituder2').val(latitude);
        addressEdit = address;
        logitudeEdit = logitude;
        latitudeEdit = latitude;
    }


    function initMap() {
        // Create a map centered on a default location (you can change this)
        //
        const defaultLocation = {
            lat: 40.7128,
            lng: -74.006
        };

        // Initialize the map
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 12 // Set the initial zoom level
        });

        // Create a search box and link it to the UI element
        const input = document.getElementById("searchInput");
        const searchBox = new google.maps.places.SearchBox(input);

        // Bias the SearchBox results towards current map's viewport
        map.addListener("bounds_changed", function() {
            searchBox.setBounds(map.getBounds());
        });

        // Listen for the event fired when the user selects a prediction and retrieve more details
        searchBox.addListener("places_changed", function() {
            const places = searchBox.getPlaces();

            if (places.length === 0) {
                return;
            }

            // For each place, get the location and display it on the map
            const bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                // Create a marker for each place
                const marker = new google.maps.Marker({
                    map,
                    title: place.name,
                    position: place.geometry.location
                });

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });

            // Fit the map to the bounds of the places found
            map.fitBounds(bounds);
            const selectedPlace = places[0]; // Assuming you are interested in the first place
            if (selectedPlace && selectedPlace.geometry && selectedPlace.geometry.location) {
                const latitude = selectedPlace.geometry.location.lat();
                const longitude = selectedPlace.geometry.location.lng();
                document.getElementById('logituder1').value = longitude;
                document.getElementById('latituder1').value = latitude;
                console.log("Latitude:", latitude);
                console.log("Longitude:", longitude);

                // LoadAuto(latitude,longitude);
            }
        });
    }



    const mapModal = document.getElementById('branchName');
    mapModal.addEventListener('shown.bs.modal', function() {
        //     // Call the initMap function when the modal is fully visible
        initMap();
        console.log("set 1");
    });

    // only use edit set

    const mapModalEdit = document.getElementById('editBranchName');
    mapModalEdit.addEventListener('shown.bs.modal', function() {

        // Initialize map after modal is shown
        const defaultLocation = {
            lat: latitudeEdit,
            lng: logitudeEdit
        };

        // Initialize the map
        const map = new google.maps.Map(document.getElementById("mapeditload"), {
            center: defaultLocation,
            zoom: 12 // Set the initial zoom level
        });

        // Create a search box and link it to the UI element
        const input = document.getElementById("editaddressNameId");
        const searchBox = new google.maps.places.SearchBox(input);

        // Bias the SearchBox results towards the map's viewport
        map.addListener("bounds_changed", function() {
            searchBox.setBounds(map.getBounds());
        });

        // Listen for the event fired when the user selects a prediction and retrieve more details
        searchBox.addListener("places_changed", function() {
            const places = searchBox.getPlaces();

            if (places.length === 0) {
                return;
            }

            // For each place, get the location and display it on the map
            const bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                // Create a marker for each place
                const marker = new google.maps.Marker({
                    map,
                    title: place.name,
                    position: place.geometry.location
                });

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });

            // Fit the map to the bounds of the places found
            map.fitBounds(bounds);

            const selectedPlace = places[0]; // Assuming you are interested in the first place
            if (selectedPlace && selectedPlace.geometry && selectedPlace.geometry.location) {
                const latitude = selectedPlace.geometry.location.lat();
                const longitude = selectedPlace.geometry.location.lng();

                // Update input fields with the selected location
                document.getElementById('logituder2').value = longitude;
                document.getElementById('latituder2').value = latitude;

                console.log("Latitude:", latitude);
                console.log("Longitude:", longitude);
            }
        });

        // currentEdit time value getset
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLocation = {
                        lat: latitudeEdit,
                        lng: logitudeEdit
                    };

                    // Place a marker at the user's location
                    const marker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: addressEdit
                    });

                    // Set map center to user's location
                    map.setCenter(userLocation);
                },
                function() {
                    handleLocationError(true, map.getCenter());
                }
            );
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, map.getCenter());
        }

        google.maps.event.addDomListener(window, 'load');
        console.log("set 2 Edit");
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> <!-- Load the Google Maps JavaScript API with your API key -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi_j48DCOW5d01QuTn21cHi-R932VJCi0&libraries=places&callback=initMap" async defer></script>
@endif
@endsection
