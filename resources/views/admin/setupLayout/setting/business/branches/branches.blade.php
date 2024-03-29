@extends('admin.setupLayout.master')
@section('title')
    Branch Setting
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
        // dd($permissions);
        $root = new App\Helpers\Central_unit();
        $branch = $root->BranchList();
        $branchCount = $root->CountersValue();

        $i = 0;
        foreach ($branch as $item) {
            $i++;
        }
    @endphp
    @if (in_array('Branch Settings.View', $permissions) || in_array('Branch Settings.All', $permissions))
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h3 class="card-title">Branch List</h3>
                </div>
                <div class="d-flex btn-list">
                    @if (in_array('Branch Settings.Create', $permissions) || in_array('Branch Settings.All', $permissions))
                        <a id="addNewBranch" class="btn btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#branchName">Create Branch</a>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="">
                        <thead>
                            <tr>
                                <th style="text-align: left;" class="border-bottom-0">S. No.</th>
                                <th style="text-align: left;" class="border-bottom-0">Branch Name</th>
                                <th style="text-align: left;" class="border-bottom-0">Branch Email</th>
                                <th style="text-align: left;" class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @if (!$branch->isEmpty())
                                @foreach ($branch as $item)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $item->branch_name }}</td>
                                        <td>{{ $item->branch_email }}</td>

                                        <td>
                                            <div class="d-flex">

                                                @if (in_array('Branch Settings.Update', $permissions))
                                                    <a class="btn action-btns  btn-sm btn-primary"
                                                        data-bs-target="#editBranchName" onclick="openEditDesignation(this)"
                                                        data-id='<?= $item->id ?>'
                                                        data-branch_name='<?= $item->branch_name ?>'
                                                        data-branch_email='<?= $item->branch_email ?>'
                                                        data-address='<?= $item->address ?>'
                                                        data-logitude='<?= $item->logitude ?>'
                                                        data-latitude='<?= $item->latitude ?>' data-bs-toggle="modal"
                                                        href="#">
                                                        <i class='feather feather-edit'></i></a>
                                                @endif
                                                @if (in_array('Branch Settings.Delete', $permissions))
                                                    <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                                        onclick="ItemDeleteModel(this)"
                                                        data-branch_id='<?= $item->branch_id ?>'
                                                        data-branch_name='<?= $item->branch_name ?>'
                                                        data-bs-target="#branchDeletebtn" id="BranchEditbtn" title="Edit">
                                                        <i class="feather feather-trash "></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">No data available</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- @foreach ($branch as $item) --}}
        {{-- Edit Branch Name {{ $item->id }} --}}
        <div class="modal fade" id="editBranchName" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Update Branch</h4><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST" action="{{ route('admin.branchupdate') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="col-lg">
                                <input type="text" id="editId" name="editBranchId" hidden>
                                <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Name</p>
                                <input class="form-control" id="editbranchNameId" placeholder="Branch Name" type="text"
                                    name="editbranch" required>
                                <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Email</p>
                                <input class="form-control" id="editbranchEmailId" placeholder="Branch Email" type="email"
                                    name="editemail" required>
                                <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Address Name</p>
                                <input class="form-control " id="editaddressNameId" type="text"
                                    placeholder="Address Name" name="editaddress" required>
                                <input type="text" id="logituder2" name="logitudeedit" placeholder="Logitude" readonly
                                    required>
                                <input type="text" id="latituder2" name="latitudeedit" placeholder="Latitude" readonly
                                    required>
                                <div class="m-1" id="mapeditload"></div>
                                <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                        class="text-primary">Terms & Conditions</a></p>
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
        {{-- @endforeach --}}
        {{-- Branch Name --}}
        <div class="modal fade" id="branchName" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Branch</h4><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST" action="{{ route('add.branch') }}">
                        <div class="modal-body">
                            <div class="col-lg">
                                <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Name</p>
                                <input class="form-control" name="branch" placeholder="Branch Name" type="text"
                                    required>
                                <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Email</p>
                                <input class="form-control" name="email" placeholder="Branch Email" type="email"
                                    required>

                                <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Address Name</p>


                                <input class="form-control" type="text" id="searchInput" name="location"
                                    placeholder="Search Your location" required>
                                <input type="text" id="logituder1" name="logitude" value=""
                                    placeholder="Logitude" readonly>
                                <input type="text" id="latituder1" name="latitude" value=""
                                    placeholder="Latitude" readonly>
                                <!-- Display the map -->
                                <div class="m-1" id="map"></div>

                                <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                        class="text-primary">Terms & Conditions</a></p>
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
        {{-- modal for delete confirmation --}}
        <div>
            <div class="modal fade" id="branchDeletebtn" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{ route('delete.branch') }}" method="POST">
                            @csrf
                            <input type="text" id="branch_id" name="branch_id" hidden>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body text-center">
                                <h4 class="mt-5">Are you sure want to Delete, <span class="text-primary"
                                        id="assign_branch">{{ $item->branch_id ?? 0 }}</span> ?</h4>
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
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ url('/setup/business-settings') }}" class="btn btn-primary">Back</a>
            </div>

            <div class="d-flex">
                {{-- <a href="{{ url('setup/attendance-settings') }}" id="saveButton"  class="btn btn-primary">Save & Continue</a> --}}
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
                // setTimeout(function() {
                //     $('#edit_state').val(depart_id);
                // }, 500);
                // $('#editbranch-dd,#edit_state').trigger('change');

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

        <!-- Load the Google Maps JavaScript API with your API key -->
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi_j48DCOW5d01QuTn21cHi-R932VJCi0&libraries=places&callback=initMap"
            async defer></script>
    @endif
@endsection
