<x-layout.layout>
    <x-partials.toast-messages />

    <div class="flex flex-row justify-between items-center mb-4">
        <h1 class="text-[20px] font-[Poppins] font-bold text-gray-800">Add Agency</h1>
    </div>
    <hr class="mb-6 border-gray-300">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 font-[Poppins] text-[12px]">
        <!-- 🧾 Left Column: Form -->
        <form action="{{ route('admin.submit-agency') }}" method="POST" id="agencyForm"
            class="space-y-4 bg-white p-6 rounded-2xl shadow-lg border border-gray-200" enctype="multipart/form-data">
            @csrf


            <!-- 📝 Introductory Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                <h2 class="text-[14px] font-semibold text-blue-700 mb-1">About This Form</h2>
                <p class="text-gray-700 text-[12px] leading-relaxed">
                    This form allows you to register or update details of official agencies in Iligan City, including the
                    <span class="font-semibold">Bureau of Fire Protection (BFP)</span>,
                    <span class="font-semibold">City Disaster Risk Reduction and Management Office (CDRRMO)</span>,
                    <span class="font-semibold">Barangay Disaster Risk Reduction and Management Committee (BDRRMC)</span>,
                    and local <span class="font-semibold">Hospitals</span>. <br><br>
                    Please fill out all required information accurately. You can locate the agency by entering its name,
                    or manually input the longitude and latitude if it cannot be found. <br><br>
                    If the agency name retrieved does not match the expected name after manual location input,
                    use the <span class="font-semibold text-blue-700">Edit</span> button to modify the
                    <span class="font-semibold">Agency Name</span> without re-triggering the tracking process.
                </p>
            </div>

            <!-- Agency Name + Edit Button -->
            <div>
                <label for="agencyNames" class="block font-semibold text-[14px] mb-1 text-gray-700">Agency Name</label>
                <div class="flex gap-2">
                    <input
                        type="text"
                        name="agencyNames"
                        id="agencyName"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none"
                        placeholder="Enter agency name or leave blank if unknown" />
                    <button type="button" id="editNameBtn"
                        class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 text-[12px] transition">
                        Edit
                    </button>
                </div>
                <p id="agencyNameError" class="text-[12px] text-red-600 mt-1 hidden">
                    No location found for this name. Try entering coordinates manually.
                </p>
            </div>

            <!-- Agency Type -->
            <div>
                <label for="agencyTypes" class="block font-semibold text-[14px] mb-1 text-gray-700">Agency Type</label>
                <select
                    name="agencyTypes"
                    id="agencyType"
                    class="w-full text-[12px] border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">Select Type</option>
                    <option value="BFP">Bureau of Fire Protection</option>
                    <option value="HOSPITAL">Hospital</option>
                    <option value="BDRRMC">Barangay Disaster Risk Reduction and Management Committee</option>
                    <option value="CDRRMO">City Disaster Risk Reduction and Management Office</option>
                </select>
                <p id="agencyTypeError" class="text-[12px] text-red-600 mt-1 hidden">Please select an agency type.</p>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block font-semibold text-[14px] mb-1 text-gray-700">Agency Email</label>
                <input type="text" id="email" name="email"
                    class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700" />
            </div>

            <!-- Region and Province -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Region</label>
                    <input type="text" name="region" readonly value="REGION-X"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                </div>
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Province</label>
                    <input type="text" name="province" readonly value="Lanao Del Norte"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                </div>
            </div>

            <!-- City and Barangay -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">City</label>
                    <input type="text" value="Iligan City" readonly name="city"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                </div>
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Barangay</label>
                    <input type="text" name="barangay"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700" />
                </div>
            </div>

            <!-- Address and Zip -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Zip Code</label>
                    <input type="text" name="zipcode"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700" />
                </div>
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Address</label>
                    <input type="text" name="address" id="address"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700" />
                </div>
            </div>

            <!-- ✅ Fixed Logo Upload -->
            <div>
                <label class="block font-semibold text-[14px] mb-1 text-gray-700">Agency Logo</label>
                <div class="flex items-center">
                    <input
                        type="file"
                        name="logo"
                        accept="image/*"
                        class="block w-full text-[12px] text-gray-700 
                           border border-gray-300 rounded-lg cursor-pointer 
                           focus:outline-none pl-2
                           file:mr-3 file:py-2 file:px-4 
                           file:rounded-lg file:border-0 
                           file:text-[12px] file:font-semibold 
                           file:bg-blue-600 file:text-white 
                           hover:file:bg-blue-700" />
                </div>
            </div>

            <input type="hidden" value="Available" name="availabilityStatus"
                class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />

            <!-- Coordinates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="longitude" class="block font-semibold text-[14px] mb-1 text-gray-700">Longitude</label>
                    <input type="text" id="longitude" placeholder="Enter longitude"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none"
                        name="longitude" />
                    <p id="longitudeError" class="text-[12px] text-red-600 mt-1 hidden">Invalid longitude value.</p>
                </div>
                <div>
                    <label for="latitude" class="block font-semibold text-[14px] mb-1 text-gray-700">Latitude</label>
                    <input type="text" id="latitude" placeholder="Enter latitude"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none"
                        name="latitude" />
                    <p id="latitudeError" class="text-[12px] text-red-600 mt-1 hidden">Invalid latitude value.</p>
                </div>
            </div>

            <input type="submit"
                class="w-full bg-green-600 py-3 px-2 text-[12px] text-white font-[Poppins] rounded-lg hover:bg-green-700 transition" />
        </form>

        <!-- 🗺️ Map -->
        <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-200">
            <h2 class="text-[14px] font-semibold text-gray-700 mb-2">Track Agency Location</h2>
            <div id="map" class="rounded-lg border border-gray-300" style="height: 520px;"></div>
        </div>
    </div>


    <x-partials.stack-js />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const DEFAULT_COORDS = {
            lat: 8.228,
            lon: 124.245
        }; // Iligan City
        const map = L.map("map").setView([DEFAULT_COORDS.lat, DEFAULT_COORDS.lon], 13);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19
        }).addTo(map);

        let marker = L.marker([DEFAULT_COORDS.lat, DEFAULT_COORDS.lon], {
            draggable: true
        }).addTo(map);
        marker.bindPopup("<b>Iligan City</b>").openPopup();

        const fields = {
            name: document.getElementById("agencyName"),
            nameError: document.getElementById("agencyNameError"),
            latitude: document.getElementById("latitude"),
            latError: document.getElementById("latitudeError"),
            longitude: document.getElementById("longitude"),
            lonError: document.getElementById("longitudeError"),
        };

        const editNameBtn = document.getElementById("editNameBtn");
        let editMode = false;

        async function getCoordinatesByName(query) {
            const url = `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(query)}`;
            const res = await fetch(url);
            const data = await res.json();
            return data.length > 0 ? data[0] : null;
        }

        async function getNameByCoordinates(lat, lon) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;
            const res = await fetch(url);
            const data = await res.json();
            return data.display_name || null;
        }

        async function updateMap(lat, lon, name = null) {
            marker.setLatLng([lat, lon]);
            map.setView([lat, lon], 15);
            fields.latitude.value = lat.toFixed(6);
            fields.longitude.value = lon.toFixed(6);
            marker.bindPopup(`<b>${name || fields.name.value || "Iligan City"}</b>`).openPopup();
        }

        function debounce(fn, delay = 700) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => fn(...args), delay);
            };
        }

        fields.name.addEventListener("input", debounce(async () => {
            if (editMode) return;
            const query = fields.name.value.trim();
            fields.nameError.classList.add("hidden");
            if (!query) return;

            const location = await getCoordinatesByName(query);
            if (location) {
                const lat = parseFloat(location.lat);
                const lon = parseFloat(location.lon);
                const displayName = location.display_name.split(",")[0];
                await updateMap(lat, lon, displayName);
            } else {
                fields.nameError.classList.remove("hidden");
                marker.bindPopup("<b>Location Not Found</b>").openPopup();
            }
        }));

        async function handleManualCoordinates() {
            const lat = parseFloat(fields.latitude.value);
            const lon = parseFloat(fields.longitude.value);
            fields.latError.classList.add("hidden");
            fields.lonError.classList.add("hidden");

            if (isNaN(lat)) fields.latError.classList.remove("hidden");
            if (isNaN(lon)) fields.lonError.classList.remove("hidden");

            if (!isNaN(lat) && !isNaN(lon)) {
                await updateMap(lat, lon);
                const name = await getNameByCoordinates(lat, lon);

                if (name) {
                    fields.name.value = name.split(",")[0];
                    marker.bindPopup(`<b>${fields.name.value}</b>`).openPopup();
                } else {
                    fields.name.value = "";
                    fields.nameError.classList.remove("hidden");
                    fields.nameError.textContent = "No location name found.";
                }
            }
        }

        fields.latitude.addEventListener("input", debounce(handleManualCoordinates));
        fields.longitude.addEventListener("input", debounce(handleManualCoordinates));

        editNameBtn.addEventListener("click", () => {
            if (!editMode) {
                editMode = true;
                fields.name.removeAttribute("readonly");
                fields.name.focus();
                editNameBtn.textContent = "Save";
                editNameBtn.classList.replace("bg-blue-600", "bg-green-600");
            } else {
                editMode = false;
                fields.name.setAttribute("readonly", true);
                editNameBtn.textContent = "Edit";
                editNameBtn.classList.replace("bg-green-600", "bg-blue-600");
                marker.bindPopup(`<b>${fields.name.value || "Iligan City"}</b>`).openPopup();
            }
        });

        marker.on("dragend", async (e) => {
            const {
                lat,
                lng
            } = e.target.getLatLng();
            await updateMap(lat, lng);
            const name = await getNameByCoordinates(lat, lng);
            if (name && !editMode) {
                fields.name.value = name.split(",")[0];
                marker.bindPopup(`<b>${fields.name.value}</b>`).openPopup();
            }
        });

        updateMap(DEFAULT_COORDS.lat, DEFAULT_COORDS.lon);



        // 🏠 Auto-update Address (barangay + city + province + region)
        const barangayInput = document.querySelector('input[name="barangay"]');
        const cityInput = document.querySelector('input[name="city"]');
        const provinceInput = document.querySelector('input[name="province"]');
        const regionInput = document.querySelector('input[name="region"]');
        const addressInput = document.getElementById('address');

        function updateAddress() {
            const barangay = barangayInput.value.trim();
            const city = cityInput.value.trim();
            const province = provinceInput.value.trim();
            const region = regionInput.value.trim();
            addressInput.value = `${barangay}, ${city}, ${province}, ${region}`;
        }

        // Trigger when barangay changes
        barangayInput.addEventListener("input", updateAddress);
        // Set default value on load
        updateAddress();
    </script>
</x-layout.layout>