<x-layout.layout>
    <x-partials.toast-messages />

    {{-- Validation Errors --}}
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
                Edit Agency
            </h4>

            <form action="{{ route('admin.update-agency', $agency->id) }}" method="POST" class="space-y-5" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Agency Type -->
                <div>
                    <label for="agencyTypes" class="block mb-2 text-[12px] font-[Poppins]">Types of Agencies</label>
                    <select name="agencyTypes" id="agencyTypes"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                        <option disabled>Choose Agencies</option>
                        <option value="BFP" {{ old('agencyTypes',$agency->agencyTypes)=='BFP'?'selected':'' }}>BFP</option>
                        <option value="BDRRMC" {{ old('agencyTypes',$agency->agencyTypes)=='BDRRMC'?'selected':'' }}>BDRRMC</option>
                        <option value="Hospital" {{ old('agencyTypes',$agency->agencyTypes)=='Hospital'?'selected':'' }}>Hospital</option>
                        <option value="CDRRMO" {{ old('agencyTypes',$agency->agencyTypes)=='CDRRMO'?'selected':'' }}>CDRRMO</option>
                    </select>
                </div>

                <!-- Agency Name -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Agency Name</label>
                    <input type="text" name="agencyNames" id="agencyNames"
                        value="{{ old('agencyNames',$agency->agencyNames) }}"
                        class="font-[Poppins] text-[12px] bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required />
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Email Address</label>
                    <input type="email" name="email"
                        value="{{ old('email',$agency->email) }}"
                        class="bg-gray-50 w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Address -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Address</label>
                    <input type="text" name="address" id="address"
                        value="{{ old('address',$agency->address) }}"
                        class="bg-gray-50 w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- City -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">City</label>
                    <input type="text" name="city" id="city"
                        value="{{ old('city',$agency->city) }}"
                        class="bg-gray-50 w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Barangay -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Barangay</label>
                    <input type="text" name="barangay" id="barangayField"
                        value="{{ old('barangay',$agency->barangay) }}"
                        class="bg-gray-50 w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Zip Code -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Zip Code</label>
                    <input type="text" name="zipcode" id="zipcode"
                        value="{{ old('zipcode',$agency->zipcode) }}"
                        class="bg-gray-50 w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Region -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Region</label>
                    <input type="text" name="region"
                        value="{{ old('region',$agency->region) }}"
                        class="bg-gray-50 w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Province -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Province</label>
                    <input type="text" name="province"
                        value="{{ old('province',$agency->province) }}"
                        class="bg-gray-50 w-full p-2.5 border rounded-lg text-[12px]" />
                </div>

                <!-- Longitude -->
                <div>
                    <label for="longitude" class="block mb-2 font-[Poppins] text-[12px]">Longitude</label>
                    <input type="text" id="longitude" name="longitude"
                        value="{{ old('longitude',$agency->longitude) }}"
                        class="bg-gray-50 font-[Poppins] text-[12px] border border-gray-300 rounded-lg block w-full p-2.5" />
                </div>

                <!-- Latitude -->
                <div>
                    <label for="latitude" class="block mb-2 font-[Poppins] text-[12px]">Latitude</label>
                    <input type="text" id="latitude" name="latitude"
                        value="{{ old('latitude',$agency->latitude) }}"
                        class="bg-gray-50 font-[Poppins] text-[12px] border border-gray-300 rounded-lg block w-full p-2.5" />
                </div>

                <!-- Upload Logo -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Upload Agency Logo</label>
                    <input type="file" name="logo"
                        class="w-full border @error('logo') border-red-500 @else border-gray-300 @enderror
                    rounded-lg cursor-pointer text-[12px] font-[Poppins]">
                    @error('logo')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                    @enderror

                    <div class="mt-3 flex justify-start">
                        <img id="photoPreview"
                            src="{{ $agency->logo ? asset('storage/'.$agency->logo) : asset('images/default-logo.png') }}"
                            alt="Current logo"
                            class="w-28 h-28 object-cover rounded-sm border-2 border-gray-200 shadow-md">
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block mb-2 text-[12px] font-[Poppins]">Status</label>
                    <select name="activeStatus"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                        <option value="Active" {{ old('activeStatus',$agency->activeStatus)=='Active'?'selected':'' }}>Active</option>
                        <option value="Inactive" {{ old('activeStatus',$agency->activeStatus)=='Inactive'?'selected':'' }}>Inactive</option>
                        <option value="Unavailable" {{ old('activeStatus',$agency->activeStatus)=='Unavailable'?'selected':'' }}>Unavailable</option>
                    </select>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 font-[Poppins] rounded-lg text-[13px] px-5 py-2.5 shadow-md transition">
                    Update
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

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <div id="location-error" class="hidden text-red-600 text-sm mt-2"></div>

    <script>
        // Default Iligan coords
        let lat = 8.228,
            lon = 124.245;
        let map = L.map('map').setView([lat, lon], 13);
        let marker = L.marker([lat, lon]).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        async function fetchCoordinatesAndAddress() {
            const agency = document.getElementById('agencyNames').value.trim();
            const errorBox = document.getElementById('location-error');

            const lonField = document.getElementById('longitude');
            const latField = document.getElementById('latitude');
            const cityField = document.getElementById('city');
            const barangayField = document.getElementById('barangayField');
            const zipField = document.getElementById('zipcode');
            const addressField = document.getElementById('address');

            // reset fields
            errorBox.classList.add('hidden');
            errorBox.innerHTML = "";
            lonField.value = "";
            latField.value = "";
            cityField.value = "";
            barangayField.value = "";
            zipField.value = "";
            addressField.value = "";

            if (!agency) return;

            const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(agency)}&format=json&limit=1`;

            try {
                const response = await fetch(url);
                const data = await response.json();

                if (data.length > 0) {
                    const lon = data[0].lon;
                    const lat = data[0].lat;
                    lonField.value = lon;
                    latField.value = lat;
                    addressField.value = data[0].display_name; // full address

                    // Update map
                    map.setView([lat, lon], 15);
                    marker.setLatLng([lat, lon]);

                    // reverse geocode
                    const reverseUrl = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`;
                    const reverseRes = await fetch(reverseUrl);
                    const reverseData = await reverseRes.json();

                    if (reverseData.address) {
                        const addr = reverseData.address;

                        // city
                        if (addr.city) cityField.value = addr.city;
                        else if (addr.town) cityField.value = addr.town;
                        else if (addr.municipality) cityField.value = addr.municipality;

                        if (addr.suburb) barangayField.value = addr.suburb;
                        else if (addr.village) barangayField.value = addr.village;
                        else if (addr.neighbourhood) barangayField.value = addr.neighbourhood;
                        else if (addr.hamlet) barangayField.value = addr.hamlet;
                        else if (addr.quarter) barangayField.value = addr.quarter;

                        // zip
                        if (addr.postcode) zipField.value = addr.postcode;
                    }
                } else {
                    errorBox.innerHTML = `❌ No coordinates found for "<b>${agency}</b>".`;
                    errorBox.classList.remove('hidden');
                }
            } catch (error) {
                errorBox.innerHTML = "⚠️ Failed to fetch coordinates. Please try again.";
                errorBox.classList.remove('hidden');
            }
        }

        document.getElementById('agencyNames').addEventListener('blur', fetchCoordinatesAndAddress);
    </script>
    <x-partials.stack-js />
</x-layout.layout>