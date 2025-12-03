<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Company</title>
    @include('layout.head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- end sidenav -->
    <main class="w-4/5 mx-auto">
        <!-- Navbar -->
        @include('layout.navbar')
        <!-- end Navbar -->
        <div class="p-5">
            <div class="w-full bg-white rounded-lg h-fit mx-auto">
                <div class="p-3 text-center">
                    <h1 class="font-extrabold text-3xl">Add company</h1>
                </div>
                <div class="p-6">
                     @if ($errors->any())
                        <div class="bg-red-200 text-red-800 p-4 rounded-lg mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="companyForm" class="space-y-3" method="post" action="{{ route('postcompany') }}"
                        enctype="multipart/form-data">
                        @csrf @method('post')
                        <!-- Penanggung Jawab Section -->
                        <div class="space-y-4">
                            <h1 class="text-2xl font-bold">Penanggung Jawab</h1>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="space-y-2">
                                    <label class="font-semibold text-black">Name:</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded-lg w-full"
                                        id="name" name="name" value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="font-semibold text-black">Nomor Whatsapp:</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded-lg w-full"
                                        id="no_telpon" name="no_telpon" value="{{ old('no_telpon') }}" required />
                                    @error('no_telpon')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="font-semibold text-black">Foto KTP:</label>
                                    <input type="file"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded-lg w-full"
                                        id="ktp" name="ktp" required>
                                    @error('ktp')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Rekening Bank Section -->
                        <div class="space-y-4">
                            <h1 class="text-2xl font-bold">Rekening Bank</h1>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="space-y-2">
                                    <label class="font-semibold text-black">Atas Nama:</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded-lg w-full"
                                        id="atas_nama" name="atas_nama" value="{{ old('atas_nama') }}" required />
                                    @error('atas_nama')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="font-semibold text-black">Bank:</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded-lg w-full"
                                        id="bank" name="bank" value="{{ old('bank') }}" required />
                                    @error('bank')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="font-semibold text-black">No Rekening:</label>
                                    <input type="number"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded-lg w-full"
                                        id="no_rek" name="no_rek" value="{{ old('no_rek') }}" required>
                                    @error('no_rek')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Event Section -->
                        <div class="space-y-4">
                            <h1 class="text-2xl font-bold">Company</h1>
                            <div class="grid">
                                <div class="space-y-2">
                                    <label class="font-semibold text-black">Name:</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded-lg w-full"
                                        id="company" name="company" value="{{ old('company') }}" required />
                                    @error('event')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Location Section -->
                            <div class="space-y-2">
                                <label class="font-semibold text-black">Location:</label>
                                <input type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded-lg w-full"
                                    id="location" name="location" value="{{ old('location') }}" required readonly />
                                <input type="text" id="searchLocation"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded-lg w-full" />
                                <div class="flex gap-2">
                                    <button type="button" id="searchBtn"
                                        class="bg-blue-500 text-white p-2 rounded-lg w-full">Search</button>
                                    <button type="button" id="locateBtn"
                                        class="bg-green-500 text-white p-2 rounded-lg w-full">Use My Location</button>
                                </div>
                                <div id="map"></div>
                                @error('location')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button id="submitBtn" type="submit"
                            class="bg-blue-500 text-white p-4 w-full hover:text-black rounded-lg">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        var map = L.map('map').setView([-6.21462, 106.84513], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Add a marker
        var marker = L.marker([-6.21462, 106.84513]).addTo(map);
        marker.bindPopup('Your Company Location').openPopup();

        // Handle the search button click to get coordinates from the geocoding service
        document.getElementById('searchBtn').onclick = function() {
            var searchInput = document.getElementById('searchLocation').value;
            if (searchInput) {
                var url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchInput)}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            var location = data[0];
                            map.setView([location.lat, location.lon], 15);
                            marker.setLatLng([location.lat, location.lon]);
                            document.getElementById('location').value = location
                                .display_name; // Set descriptive location
                        } else {
                            alert('Location not found');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching location:', error);
                    });
            }
        };

        document.getElementById('locateBtn').onclick = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;

                    // Update the map view
                    map.setView([lat, lon], 15);
                    marker.setLatLng([lat, lon]);

                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.display_name) {
                                // Set the input value to the location name
                                document.getElementById('location').value = data.display_name;
                            } else {
                                document.getElementById('location').value = "Location name not found";
                            }
                        })
                        .catch(error => {
                            console.error("Error with reverse geocoding:", error);
                            document.getElementById('location').value = "Error fetching location name";
                        });
                }, function(error) {
                    // Handle geolocation errors
                    alert("Error fetching your location: " + error.message);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        };

        const form = document.getElementById('companyForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', () => {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
        });
    </script>
    
    @include('layout.loading')

</body>

</html>