<x-layout.layout>
    <x-partials.toast-messages />

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column: Agency Info -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex flex-col items-center mb-6">
                <img
                    src="{{ $agency->logo ? asset('storage/'.$agency->logo) : asset('images/default-logo.png') }}"
                    alt="Agency Logo"
                    class="w-24 h-24 object-cover rounded-full border-2 border-blue-400 shadow-md mb-3">
                <h4 class="text-center font-[Poppins] text-[18px] font-semibold text-gray-800 dark:text-gray-200">
                    {{ $agency->agencyNames }}
                </h4>
                <p class="text-[13px] text-gray-500 dark:text-gray-400">{{ $agency->agencyTypes }}</p>
            </div>

            <div class="space-y-4">
                <!-- Email -->
                <div>
                    <label class="block text-[12px] text-gray-500 dark:text-gray-300">Email</label>
                    <p class="mt-1 text-[14px] font-medium text-gray-800 dark:text-white">
                        {{ $agency->email }}
                    </p>
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-[12px] text-gray-500 dark:text-gray-300">Address</label>
                    <p class="mt-1 text-[14px] font-medium text-gray-800 dark:text-white">
                        {{ $agency->address }}, {{ $agency->city }}, {{ $agency->province }}, {{ $agency->region }}
                    </p>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-[12px] text-gray-500 dark:text-gray-300">Status</label>
                    <span class="inline-block px-2 py-1 text-xs rounded-lg 
                        @if($agency->activeStatus == 'Active') bg-green-200 text-green-800 
                        @elseif($agency->activeStatus == 'Inactive') bg-yellow-200 text-yellow-800 
                        @else bg-red-200 text-red-800 @endif">
                        {{ $agency->activeStatus }}
                    </span>
                </div>

                <!-- Zipcode -->
                <div>
                    <label class="block text-[12px] text-gray-500 dark:text-gray-300">Zip Code</label>
                    <p class="mt-1 text-[14px] font-medium text-gray-800 dark:text-white">
                        {{ $agency->zipcode }}
                    </p>
                </div>
                <!-- Region -->
                <div>
                    <label class="block text-[12px] text-gray-500 dark:text-gray-300">Region</label>
                    <p class="mt-1 text-[14px] font-medium text-gray-800 dark:text-white">
                        {{ $agency->region }}
                    </p>
                </div>
                <!-- Province -->
                <div>
                    <label class="block text-[12px] text-gray-500 dark:text-gray-300">Province</label>
                    <p class="mt-1 text-[14px] font-medium text-gray-800 dark:text-white">
                        {{ $agency->province }}
                    </p>
                </div>

                <!-- Coordinates -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[12px] text-gray-500 dark:text-gray-300">Longitude</label>
                        <p class="mt-1 text-[14px] font-medium text-gray-800 dark:text-white">
                            {{ $agency->longitude }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-[12px] text-gray-500 dark:text-gray-300">Latitude</label>
                        <p class="mt-1 text-[14px] font-medium text-gray-800 dark:text-white">
                            {{ $agency->latitude }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Map -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h4 class="mb-4 font-[Poppins] text-[14px] font-semibold text-gray-800 dark:text-gray-200">
                Agency Location
            </h4>
            <div id="map" class="w-full h-[500px] rounded-lg shadow border border-gray-300"></div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Fallback to Iligan if no coords
        let lat = {
            {
                $agency - > latitude ?? 8.228
            }
        };
        let lon = {
            {
                $agency - > longitude ?? 124.245
            }
        };

        let map = L.map('map').setView([lat, lon], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Marker with popup
        let marker = L.marker([lat, lon]).addTo(map)
            .bindPopup(`<b>{{ $agency->agencyNames }}</b><br>{{ $agency->address }}`)
            .openPopup();
    </script>

    <x-partials.stack-js />
</x-layout.layout>