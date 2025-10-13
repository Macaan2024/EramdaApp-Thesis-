<x-layout.layout>
    <x-partials.toast-messages />

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 text-[12px] font-[Poppins] px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column: Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h4 class="mb-6 text-center font-[Poppins] text-[16px] font-semibold text-gray-800 dark:text-gray-200">
                Add Agency
            </h4>

            <form action="{{ route('admin.submit-agency') }}" method="POST" class="space-y-5" enctype="multipart/form-data">
                @csrf

                <!-- Agency Type -->
                <div>
                    <label for="agencyTypes" class="block mb-2 text-[12px] font-[Poppins]">Types of Agencies</label>
                    <select name="agencyTypes" id="agencyTypes"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                        <option selected disabled>Choose Agencies</option>
                        <option value="BFP">Bureau of Fire Protection (BFP)</option>
                        <option value="BDRRMC">Barangay Disaster Risk Reduction and Management Committee (BDRRMC)</option>
                        <option value="Hospital">Hospitals</option>
                        <option value="CDRRMO">City Disaster Risk Reduction and Management Office</option>
                    </select>
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Email Address</label>
                    <input type="email" name="email"
                        class="bg-gray-100 cursor-not-allowed w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Agency Name -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Agency Name</label>
                    <select name="agencyNames" id="agencyNames"
                        class="font-[Poppins] text-[12px] bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option selected disabled>Choose Agency</option>
                        @foreach ($agencies as $agency)
                            <option 
                                value="{{ $agency->agencyNames }}"
                                data-lat="{{ $agency->latitude }}"
                                data-lng="{{ $agency->longitude }}">
                                {{ $agency->agencyNames }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Address -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Address</label>
                    <input type="text" name="address" id="address"
                        readonly
                        class="bg-gray-100 cursor-not-allowed w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- City -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">City</label>
                    <input type="text" name="city" id="city"
                        readonly
                        class="bg-gray-100 cursor-not-allowed w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Barangay -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Barangay</label>
                    <input type="text" name="barangay" id="barangayField"
                        readonly
                        class="bg-gray-100 cursor-not-allowed w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Zip Code -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Zip Code</label>
                    <input type="text" name="zipcode" id="zipcode"
                        readonly
                        class="bg-gray-100 cursor-not-allowed w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Longitude -->
                <div>
                    <label for="longitude" class="block mb-2 font-[Poppins] text-[12px]">Longitude</label>
                    <input type="text" id="longitude" name="longitude"
                        readonly
                        class="bg-gray-100 cursor-not-allowed font-[Poppins] text-[12px] border border-gray-300 rounded-lg block w-full p-2.5" />
                </div>

                <!-- Latitude -->
                <div>
                    <label for="latitude" class="block mb-2 font-[Poppins] text-[12px]">Latitude</label>
                    <input type="text" id="latitude" name="latitude"
                        readonly
                        class="bg-gray-100 cursor-not-allowed font-[Poppins] text-[12px] border border-gray-300 rounded-lg block w-full p-2.5" />
                </div>

                <!-- Upload Logo -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Upload Agency Logo</label>
                    <input type="file" name="logo"
                        class="w-full border @error('logo') border-red-500 @else border-gray-300 @enderror rounded-lg cursor-pointer text-[12px] font-[Poppins]">
                    @error('logo')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                    @enderror

                    <div class="mt-3 flex justify-center">
                        <img id="photoPreview" src="" alt="Preview will appear here"
                            class="hidden w-24 h-24 object-cover rounded-full border-2 border-blue-400 shadow-md">
                    </div>
                </div>

                <input type="hidden" name="activeStatus" value="Available" />

                <!-- Submit -->
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
            <div id="map" class="z-0 w-full h-[500px] rounded-lg shadow border border-gray-300"></div>
        </div>
    </div>

    <x-partials.stack-js />

    <!-- ✅ Leaflet + Dynamic Autofill Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const agencySelect = document.getElementById('agencyNames');
        const longitudeInput = document.getElementById('longitude');
        const latitudeInput = document.getElementById('latitude');
        const addressInput = document.getElementById('address');
        const cityInput = document.getElementById('city');
        const barangayInput = document.getElementById('barangayField');
        const zipcodeInput = document.getElementById('zipcode');

        const map = L.map('map').setView([8.485, 124.657], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker;

        agencySelect.addEventListener('change', function () {
            const selected = agencySelect.options[agencySelect.selectedIndex];
            const lat = selected.getAttribute('data-lat');
            const lng = selected.getAttribute('data-lng');

            if (lat && lng) {
                const latNum = parseFloat(lat);
                const lngNum = parseFloat(lng);

                if (marker) map.removeLayer(marker);
                marker = L.marker([latNum, lngNum]).addTo(map);
                map.setView([latNum, lngNum], 15);

                latitudeInput.value = latNum;
                longitudeInput.value = lngNum;

                // Reverse geocode using OpenStreetMap
                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latNum}&lon=${lngNum}`)
                    .then(response => response.json())
                    .then(data => {
                        addressInput.value = data.display_name || "N/A";
                        cityInput.value = data.address.city || data.address.town || data.address.village || "N/A";
                        barangayInput.value = data.address.suburb || data.address.neighbourhood || "N/A";
                        zipcodeInput.value = data.address.postcode || "N/A";
                    })
                    .catch(() => {
                        addressInput.value = cityInput.value = barangayInput.value = zipcodeInput.value = "N/A";
                    });
            }
        });
    });
    </script>
</x-layout.layout>
