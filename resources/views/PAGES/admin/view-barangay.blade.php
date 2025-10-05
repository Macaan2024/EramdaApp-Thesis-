<x-layout.layout>
    <x-partials.toast-messages />

    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column: Barangay Info -->
        <div class="bg-gray-200 dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col justify-center items-center">
            <h4 class="mb-6 text-center font-[Poppins] text-[16px] font-semibold text-gray-800 dark:text-gray-200">
                Barangay Details
            </h4>

            <div class="space-y-4">
                <!-- Logo -->
                @if($barangay->logo)
                    <div class="flex flex-col items-center my-5">
                        <img src="{{ asset('storage/'.$barangay->logo) }}"
                             alt="Logo of {{ $barangay->barangayNames }}"
                             class="w-28 h-28 object-cover rounded-full border border-gray-300 shadow-md dark:border-gray-700">
                    </div>
                @else
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 flex items-center justify-center rounded-full bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                            No Logo
                        </div>
                        <span class="mt-2 text-[12px] font-[Poppins] text-gray-500 dark:text-gray-300">
                            Barangay Logo
                        </span>
                    </div>
                @endif

                <!-- Barangay Name -->
                <div class="flex flex-row items-center gap-2">
                    <label class="block text-[12px] font-[Poppins] text-gray-500 dark:text-gray-300">Barangay Name</label>
                    <p class="mt-1 text-[14px] font-[Poppins] font-medium text-gray-800 dark:text-white">
                        {{ $barangay->barangayNames }}
                    </p>
                </div>

                <!-- City -->
                <div class="flex flex-row items-center gap-2">
                    <label class="block text-[12px] font-[Poppins] text-gray-500 dark:text-gray-300">City</label>
                    <p class="mt-1 text-[14px] font-[Poppins] font-medium text-gray-800 dark:text-white">
                        {{ $barangay->city }}
                    </p>
                </div>

                <!-- Longitude -->
                <div class="flex flex-row items-center gap-2">
                    <label class="block text-[12px] font-[Poppins] text-gray-500 dark:text-gray-300">Longitude</label>
                    <p class="mt-1 text-[14px] font-[Poppins] font-medium text-gray-800 dark:text-white">
                        {{ $barangay->longitude ?? '—' }}
                    </p>
                </div>

                <!-- Latitude -->
                <div>
                    <label class="block text-[12px] font-[Poppins] text-gray-500 dark:text-gray-300">Latitude</label>
                    <p class="mt-1 text-[14px] font-[Poppins] font-medium text-gray-800 dark:text-white">
                        {{ $barangay->latitude ?? '—' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Column: Map -->
        <div class="bg-gray-200 dark:bg-gray-800 rounded-lg shadow p-6">
            <h4 class="mb-4 font-[Poppins] text-[14px] font-semibold text-gray-800 dark:text-gray-200">
                Map Location
            </h4>
            <div id="map" class="w-full h-[500px] rounded-lg shadow border border-gray-300"></div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Default coordinates: fallback to Iligan if no coords
        let lat = {{ $barangay->latitude ?? 8.228 }};
        let lon = {{ $barangay->longitude ?? 124.245 }};

        let map = L.map('map').setView([lat, lon], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Marker with popup
        let marker = L.marker([lat, lon]).addTo(map)
            .bindPopup(`<b>{{ $barangay->barangayNames }}</b><br>{{ $barangay->city }}`)
            .openPopup();
    </script>

    <x-partials.stack-js />
</x-layout.layout>
