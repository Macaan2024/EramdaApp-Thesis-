<x-layout.layout>
    <x-partials.toast-messages />
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column: Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h4 class="mb-6 text-center font-[Poppins] text-[16px] font-semibold text-gray-800 dark:text-gray-200">
                Add Barangay
            </h4>

            <form action="{{ route('admin.submit-barangay') }}" method="POST" class="space-y-5" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <!-- Barangay Name -->
                <div>
                    <label for="barangayNames" class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">
                        Barangay Name
                    </label>
                    <input
                        type="text"
                        id="barangayNames"
                        name="barangayNames"
                        class="font-[Poppins] text-[12px] bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Mahayahay"
                        required />
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">
                        City
                    </label>
                    <input
                        type="text"
                        id="city"
                        name="city"
                        class="font-[Poppins] text-[12px] bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Iligan City"
                        required />
                </div>

                <!-- Error Message -->
                <div id="location-error" class="hidden text-red-600 text-[12px] font-[Poppins] bg-red-50 px-3 py-2 rounded-lg border border-red-300"></div>

                <!-- Longitude -->
                <div>
                    <label for="longitude" class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">
                        Longitude
                    </label>
                    <input
                        type="text"
                        id="longitude"
                        name="longitude"
                        readonly
                        class="bg-gray-100 cursor-not-allowed font-[Poppins] text-[12px] border border-gray-300 rounded-lg block w-full p-2.5 shadow-inner" />
                </div>

                <!-- Latitude -->
                <div>
                    <label for="latitude" class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">
                        Latitude
                    </label>
                    <input
                        type="text"
                        id="latitude"
                        name="latitude"
                        readonly
                        class="bg-gray-100 cursor-not-allowed font-[Poppins] text-[12px] border border-gray-300 rounded-lg block w-full p-2.5 shadow-inner" />
                </div>
                <!-- Upload photo -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Upload Barangay Logo</label>
                    <input type="file" name="logo"
                        class="w-full border @error('logo') border-red-500 @else border-gray-300 @enderror
                    rounded-lg cursor-pointer text-[12px] font-[Poppins]">
                    @error('logo')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                    @enderror

                    <div class="mt-3 flex justify-center">
                        <img id="photoPreview" src="" alt="Preview will appear here"
                            class="hidden w-24 h-24 object-cover rounded-full border-2 border-blue-400 shadow-md">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 font-[Poppins] rounded-lg text-[13px] px-5 py-2.5 shadow-md transition">
                    Submit
                </button>
            </form>
        </div>

        <!-- Right Column: Map -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h4 class="mb-4 font-[Poppins] text-[14px] font-semibold text-gray-800 dark:text-gray-200">
                Map Preview
            </h4>
            <div id="map" class="w-full h-[500px] rounded-lg shadow border border-gray-300"></div>
        </div>
    </div>


    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        let map = L.map('map').setView([8.228, 124.245], 13); // default view (Iligan)
        let marker;

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        async function fetchCoordinates() {
            let barangay = document.getElementById('barangayNames').value.trim();
            let city = document.getElementById('city').value.trim();
            let errorBox = document.getElementById('location-error');
            let longitudeField = document.getElementById('longitude');
            let latitudeField = document.getElementById('latitude');

            // Reset
            errorBox.classList.add('hidden');
            errorBox.innerHTML = "";
            longitudeField.value = "";
            latitudeField.value = "";

            if (barangay && city) {
                let query = `Barangay ${barangay}, ${city}`;
                let url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1`;

                try {
                    let response = await fetch(url, {
                        headers: {
                            'Accept-Language': 'en'
                        }
                    });
                    let data = await response.json();

                    if (data.length > 0) {
                        let lon = data[0].lon;
                        let lat = data[0].lat;

                        longitudeField.value = lon;
                        latitudeField.value = lat;

                        // Update map and marker
                        map.setView([lat, lon], 15);
                        if (marker) {
                            marker.setLatLng([lat, lon]);
                        } else {
                            marker = L.marker([lat, lon]).addTo(map);
                        }
                    } else {
                        errorBox.innerHTML = `❌ No coordinates found for "<b>${barangay}</b>, <b>${city}</b>". Please check spelling.`;
                        errorBox.classList.remove('hidden');
                    }
                } catch (error) {
                    errorBox.innerHTML = "⚠️ Failed to fetch coordinates. Please try again.";
                    errorBox.classList.remove('hidden');
                }
            }
        }

        // Trigger fetch when typing finished
        document.getElementById('barangayNames').addEventListener('blur', fetchCoordinates);
        document.getElementById('city').addEventListener('blur', fetchCoordinates);
    </script>

    <x-partials.stack-js />
</x-layout.layout>