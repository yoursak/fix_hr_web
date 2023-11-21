<!DOCTYPE html>
<html>

<head>
    <title>Geocoding Map Example</title>
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

        .pac-container {
            z-index: 10000 !important;
            /* Set a high z-index for the autocomplete dropdown */
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>

    <!-- Modal -->
    <div class="modal" id="mapModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Map View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Display the search input -->
                    <input id="searchInput" type="text" placeholder="Enter a location">
                    <!-- Display the map -->
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mapModal">
        Open Map Modal
    </button>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

    <script>
        let map;

        function initMap() {
            // Create a map centered on a default location (you can change this)
            const defaultLocation = { lat: 40.7128, lng: -74.006 };

            // Initialize the map
            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 12 // Set the initial zoom level
            });

            // Create a search box and link it to the UI element
            const input = document.getElementById("searchInput");
            const searchBox = new google.maps.places.SearchBox(input);

            // Bias the SearchBox results towards current map's viewport
            map.addListener("bounds_changed", function () {
                searchBox.setBounds(map.getBounds());
            });

            // Listen for the event fired when the user selects a prediction and retrieve more details
            searchBox.addListener("places_changed", function () {
                const places = searchBox.getPlaces();

                if (places.length === 0) {
                    return;
                }

                // For each place, get the location and display it on the map
                const bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
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
                    console.log("Latitude:", latitude);
                    console.log("Longitude:", longitude);
                }
            });
        }

        // Trigger the initMap function when the modal is fully shown
        const mapModal = document.getElementById('mapModal');
        mapModal.addEventListener('shown.bs.modal', function () {
            // Call the initMap function when the modal is fully visible
            initMap();
        });
    </script>

    <!-- Load the Google Maps JavaScript API with your API key -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi_j48DCOW5d01QuTn21cHi-R932VJCi0&libraries=places&callback=initMap"
        async defer></script>

</body>

</html>