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

    <form class="max-w-sm mx-auto"
        action="{{ route('submit-agencies.admin') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf

        <h4 class="my-5 text-center font-[Poppins] text-[14px] font-medium">Edit Agency</h4>

        <!-- Agency Type -->
        <div class="mb-5">
            <label for="agencyTypes" class="block mb-2 text-[12px] font-[Poppins]">Select Agencies</label>
            <select name="agencyTypes"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option disabled>Choose Agencies</option>
                <option value="BFP" {{ $agencies->agencyTypes == 'BFP' ? 'selected' : '' }}>Bureau of Fire Protection (BFP)</option>
                <option value="BDRRMC" {{ $agencies->agencyTypes == 'BDRRMC' ? 'selected' : '' }}>Barangay Disaster Risk Reduction and Management Committee (BDRRMC)</option>
                <option value="Hospital" {{ $agencies->agencyTypes == 'Hospital' ? 'selected' : '' }}>Hospitals</option>
                <option value="CDRRMO" {{ $agencies->agencyTypes == 'CDRRMO' ? 'selected' : '' }}>City Disaster Risk Reduction and Management Office</option>
            </select>
        </div>

        <!-- Agency Name -->
        <div class="mb-5">
            <label class="block mb-2 text-[12px] font-[Poppins]">Agency Name</label>
            <input type="text" name="agencyNames" placeholder="Bureau of Fire Station 4" required
                class="w-full p-2.5 border rounded-lg text-[12px]" value="{{ $agencies->agencyNames }}" />
        </div>

        <!-- Agency Email -->
        <div class="mb-5">
            <label class="block mb-2 text-[12px] font-[Poppins]">Agency Email</label>
            <input type="email" name="email" placeholder="bfpplazastation1@gmail.com" required
                class="w-full p-2.5 border rounded-lg text-[12px]" value="{{ $agencies->email }}" />
        </div>

        <!-- Regions -->
        <div class="mb-5">
            <label for="region" class="block mb-2 text-[12px] font-[Poppins]">Regions</label>
            <select name="region" id="regions"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option disabled>Select Regions</option>
                <option value="Luzon" {{ $agencies->region == 'Luzon' ? 'selected' : '' }}>Luzon</option>
                <option value="Visayas" {{ $agencies->region == 'Visayas' ? 'selected' : '' }}>Visayas</option>
                <option value="Mindanao" {{ $agencies->region == 'Mindanao' ? 'selected' : '' }}>Mindanao</option>
            </select>
        </div>

        <!-- if luzon region is selected or current data -->
        <div class="mb-5" id="province-luzon" style="display: {{ $agencies->region == 'Luzon' ? 'block' : 'none' }};">
            <label for="province" class="block mb-2 text-[12px] font-[Poppins]">Province</label>
            <select name="province"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option disabled>Select Province</option>
                <option value="Abra" {{ $agencies->province == 'Abra' ? 'selected' : '' }}>Abra</option>
                <option value="Albay" {{ $agencies->province == 'Albay' ? 'selected' : '' }}>Albay</option>
                <option value="Apayao" {{ $agencies->province == 'Apayao' ? 'selected' : '' }}>Apayao</option>
                <option value="Aurora" {{ $agencies->province == 'Aurora' ? 'selected' : '' }}>Aurora</option>
                <option value="Bataan" {{ $agencies->province == 'Bataan' ? 'selected' : '' }}>Bataan</option>
                <option value="Batangas" {{ $agencies->province == 'Batangas' ? 'selected' : '' }}>Batangas</option>
                <option value="Benguet" {{ $agencies->province == 'Benguet' ? 'selected' : '' }}>Benguet</option>
                <option value="Bulacan" {{ $agencies->province == 'Bulacan' ? 'selected' : '' }}>Bulacan</option>
                <option value="Cagayan" {{ $agencies->province == 'Cagayan' ? 'selected' : '' }}>Cagayan</option>
                <option value="Camarines Norte" {{ $agencies->province == 'Camarines Norte' ? 'selected' : '' }}>Camarines Norte</option>
                <option value="Camarines Sur" {{ $agencies->province == 'Camarines Sur' ? 'selected' : '' }}>Camarines Sur</option>
                <option value="Catanduanes" {{ $agencies->province == 'Catanduanes' ? 'selected' : '' }}>Catanduanes</option>
                <option value="Cavite" {{ $agencies->province == 'Cavite' ? 'selected' : '' }}>Cavite</option>
                <option value="Ifugao" {{ $agencies->province == 'Ifugao' ? 'selected' : '' }}>Ifugao</option>
                <option value="Ilocos Norte" {{ $agencies->province == 'Ilocos Norte' ? 'selected' : '' }}>Ilocos Norte</option>
                <option value="Ilocos Sur" {{ $agencies->province == 'Ilocos Sur' ? 'selected' : '' }}>Ilocos Sur</option>
                <option value="Isabela" {{ $agencies->province == 'Isabela' ? 'selected' : '' }}>Isabela</option>
                <option value="Kalinga" {{ $agencies->province == 'Kalinga' ? 'selected' : '' }}>Kalinga</option>
                <option value="La Union" {{ $agencies->province == 'La Union' ? 'selected' : '' }}>La Union</option>
                <option value="Laguna" {{ $agencies->province == 'Laguna' ? 'selected' : '' }}>Laguna</option>
                <option value="Marinduque" {{ $agencies->province == 'Marinduque' ? 'selected' : '' }}>Marinduque</option>
                <option value="Masbate" {{ $agencies->province == 'Masbate' ? 'selected' : '' }}>Masbate</option>
                <option value="Metro Manila" {{ $agencies->province == 'Metro Manila' ? 'selected' : '' }}>Metro Manila</option>
                <option value="Mountain Province" {{ $agencies->province == 'Mountain Province' ? 'selected' : '' }}>Mountain Province</option>
                <option value="Nueva Ecija" {{ $agencies->province == 'Nueva Ecija' ? 'selected' : '' }}>Nueva Ecija</option>
                <option value="Nueva Vizcaya" {{ $agencies->province == 'Nueva Vizcaya' ? 'selected' : '' }}>Nueva Vizcaya</option>
                <option value="Occidental Mindoro" {{ $agencies->province == 'Occidental Mindoro' ? 'selected' : '' }}>Occidental Mindoro</option>
                <option value="Oriental Mindoro" {{ $agencies->province == 'Oriental Mindoro' ? 'selected' : '' }}>Oriental Mindoro</option>
                <option value="Palawan" {{ $agencies->province == 'Palawan' ? 'selected' : '' }}>Palawan</option>
                <option value="Pampanga" {{ $agencies->province == 'Pampanga' ? 'selected' : '' }}>Pampanga</option>
                <option value="Pangasinan" {{ $agencies->province == 'Pangasinan' ? 'selected' : '' }}>Pangasinan</option>
                <option value="Quezon" {{ $agencies->province == 'Quezon' ? 'selected' : '' }}>Quezon</option>
                <option value="Quirino" {{ $agencies->province == 'Quirino' ? 'selected' : '' }}>Quirino</option>
                <option value="Rizal" {{ $agencies->province == 'Rizal' ? 'selected' : '' }}>Rizal</option>
                <option value="Romblon" {{ $agencies->province == 'Romblon' ? 'selected' : '' }}>Romblon</option>
                <option value="Sorsogon" {{ $agencies->province == 'Sorsogon' ? 'selected' : '' }}>Sorsogon</option>
                <option value="Tarlac" {{ $agencies->province == 'Tarlac' ? 'selected' : '' }}>Tarlac</option>
                <option value="Zambales" {{ $agencies->province == 'Zambales' ? 'selected' : '' }}>Zambales</option>
            </select>
        </div>

        <!-- if visayas region is selected or current data -->
        <div class="mb-5" id="province-visayas" style="display: {{ $agencies->region == 'Visayas' ? 'block' : 'none' }};">
            <label for="province" class="block mb-2 text-[12px] font-[Poppins]">Province</label>
            <select name="province"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option disabled>Select Province</option>
                <option value="Aklan" {{ $agencies->province == 'Aklan' ? 'selected' : '' }}>Aklan</option>
                <option value="Antique" {{ $agencies->province == 'Antique' ? 'selected' : '' }}>Antique</option>
                <option value="Biliran" {{ $agencies->province == 'Biliran' ? 'selected' : '' }}>Biliran</option>
                <option value="Bohol" {{ $agencies->province == 'Bohol' ? 'selected' : '' }}>Bohol</option>
                <option value="Capiz" {{ $agencies->province == 'Capiz' ? 'selected' : '' }}>Capiz</option>
                <option value="Cebu" {{ $agencies->province == 'Cebu' ? 'selected' : '' }}>Cebu</option>
                <option value="Eastern Samar" {{ $agencies->province == 'Eastern Samar' ? 'selected' : '' }}>Eastern Samar</option>
                <option value="Guimaras" {{ $agencies->province == 'Guimaras' ? 'selected' : '' }}>Guimaras</option>
                <option value="Iloilo" {{ $agencies->province == 'Iloilo' ? 'selected' : '' }}>Iloilo</option>
                <option value="Leyte" {{ $agencies->province == 'Leyte' ? 'selected' : '' }}>Leyte</option>
                <option value="Negros Occidental" {{ $agencies->province == 'Negros Occidental' ? 'selected' : '' }}>Negros Occidental</option>
                <option value="Negros Oriental" {{ $agencies->province == 'Negros Oriental' ? 'selected' : '' }}>Negros Oriental</option>
                <option value="Northern Samar" {{ $agencies->province == 'Northern Samar' ? 'selected' : '' }}>Northern Samar</option>
                <option value="Samar" {{ $agencies->province == 'Samar' ? 'selected' : '' }}>Samar</option>
                <option value="Southern Leyte" {{ $agencies->province == 'Southern Leyte' ? 'selected' : '' }}>Southern Leyte</option>
            </select>
        </div>
        <!-- if mindanao region is selected or current data -->
        <div class="mb-5" id="province-mindanao" style="display: {{ $agencies->region == 'Mindanao' ? 'block' : 'none' }};">
            <label for="province" class="block mb-2 text-[12px] font-[Poppins]">Province</label>
            <select name="province"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option disabled>Select Province</option>
                <option value="Agusan del Norte" {{ $agencies->province == 'Agusan del Norte' ? 'selected' : '' }}>Agusan del Norte</option>
                <option value="Agusan del Sur" {{ $agencies->province == 'Agusan del Sur' ? 'selected' : '' }}>Agusan del Sur</option>
                <option value="Basilan" {{ $agencies->province == 'Basilan' ? 'selected' : '' }}>Basilan</option>
                <option value="Bukidnon" {{ $agencies->province == 'Bukidnon' ? 'selected' : '' }}>Bukidnon</option>
                <option value="Camiguin" {{ $agencies->province == 'Camiguin' ? 'selected' : '' }}>Camiguin</option>
                <option value="Compostela Valley" {{ $agencies->province == 'Compostela Valley' ? 'selected' : '' }}>Compostela Valley</option>
                <option value="Cotabato" {{ $agencies->province == 'Cotabato' ? 'selected' : '' }}>Cotabato</option>
                <option value="Davao de Oro" {{ $agencies->province == 'Davao de Oro' ? 'selected' : '' }}>Davao de Oro</option>
                <option value="Davao del Norte" {{ $agencies->province == 'Davao del Norte' ? 'selected' : '' }}>Davao del Norte</option>
                <option value="Davao del Sur" {{ $agencies->province == 'Davao del Sur' ? 'selected' : '' }}>Davao del Sur</option>
                <option value="Davao Occidental" {{ $agencies->province == 'Davao Occidental' ? 'selected' : '' }}>Davao Occidental</option>
                <option value="Davao Oriental" {{ $agencies->province == 'Davao Oriental' ? 'selected' : '' }}>Davao Oriental</option>
                <option value="Dinagat Islands" {{ $agencies->province == 'Dinagat Islands' ? 'selected' : '' }}>Dinagat Islands</option>
                <option value="Lanao del Norte" {{ $agencies->province == 'Lanao del Norte' ? 'selected' : '' }}>Lanao del Norte</option>
                <option value="Lanao del Sur" {{ $agencies->province == 'Lanao del Sur' ? 'selected' : '' }}>Lanao del Sur</option>
                <option value="Maguindanao del Norte" {{ $agencies->province == 'Maguindanao del Norte' ? 'selected' : '' }}>Maguindanao del Norte</option>
                <option value="Maguindanao del Sur" {{ $agencies->province == 'Maguindanao del Sur' ? 'selected' : '' }}>Maguindanao del Sur</option>
                <option value="Misamis Occidental" {{ $agencies->province == 'Misamis Occidental' ? 'selected' : '' }}>Misamis Occidental</option>
                <option value="Misamis Oriental" {{ $agencies->province == 'Misamis Oriental' ? 'selected' : '' }}>Misamis Oriental</option>
                <option value="Sarangani" {{ $agencies->province == 'Sarangani' ? 'selected' : '' }}>Sarangani</option>
                <option value="South Cotabato" {{ $agencies->province == 'South Cotabato' ? 'selected' : '' }}>South Cotabato</option>
                <option value="Sultan Kudarat" {{ $agencies->province == 'Sultan Kudarat' ? 'selected' : '' }}>Sultan Kudarat</option>
                <option value="Sulu" {{ $agencies->province == 'Sulu' ? 'selected' : '' }}>Sulu</option>
                <option value="Surigao del Norte" {{ $agencies->province == 'Surigao del Norte' ? 'selected' : '' }}>Surigao del Norte</option>
                <option value="Surigao del Sur" {{ $agencies->province == 'Surigao del Sur' ? 'selected' : '' }}>Surigao del Sur</option>
                <option value="Tawi-Tawi" {{ $agencies->province == 'Tawi-Tawi' ? 'selected' : '' }}>Tawi-Tawi</option>
                <option value="Zamboanga del Norte" {{ $agencies->province == 'Zamboanga del Norte' ? 'selected' : '' }}>Zamboanga del Norte</option>
                <option value="Zamboanga del Sur" {{ $agencies->province == 'Zamboanga del Sur' ? 'selected' : '' }}>Zamboanga del Sur</option>
                <option value="Zamboanga Sibugay" {{ $agencies->province == 'Zamboanga Sibugay' ? 'selected' : '' }}>Zamboanga Sibugay</option>
            </select>
        </div>

        <!-- if lanao del norte provinces is selected or current data -->
        <div class="mb-5" id="city-lanao-del-norte" style="display: {{ $agencies->province == 'Lanao del Norte' ? 'block' : 'none' }};">
            <label for="city" class="block mb-2 text-[12px] font-[Poppins]">City</label>
            <select name="city" id="city"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option disabled>Select City / Municipality</option>
                <option value="Bacolod" {{ $agencies->city == 'Bacolod' ? 'selected' : '' }}>Bacolod</option>
                <option value="Baloi" {{ $agencies->city == 'Baloi' ? 'selected' : '' }}>Baloi</option>
                <option value="Baroy" {{ $agencies->city == 'Baroy' ? 'selected' : '' }}>Baroy</option>
                <option value="Iligan City" {{ $agencies->city == 'Iligan City' ? 'selected' : '' }}>Iligan City</option>
                <option value="Kapatagan" {{ $agencies->city == 'Kapatagan' ? 'selected' : '' }}>Kapatagan</option>
                <option value="Kauswagan" {{ $agencies->city == 'Kauswagan' ? 'selected' : '' }}>Kauswagan</option>
                <option value="Kolambugan" {{ $agencies->city == 'Kolambugan' ? 'selected' : '' }}>Kolambugan</option>
                <option value="Lala" {{ $agencies->city == 'Lala' ? 'selected' : '' }}>Lala</option>
                <option value="Linamon" {{ $agencies->city == 'Linamon' ? 'selected' : '' }}>Linamon</option>
                <option value="Magsaysay" {{ $agencies->city == 'Magsaysay' ? 'selected' : '' }}>Magsaysay</option>
                <option value="Maigo" {{ $agencies->city == 'Maigo' ? 'selected' : '' }}>Maigo</option>
                <option value="Matungao" {{ $agencies->city == 'Matungao' ? 'selected' : '' }}>Matungao</option>
                <option value="Munai" {{ $agencies->city == 'Munai' ? 'selected' : '' }}>Munai</option>
                <option value="Nunungan" {{ $agencies->city == 'Nunungan' ? 'selected' : '' }}>Nunungan</option>
                <option value="Pantao Ragat" {{ $agencies->city == 'Pantao Ragat' ? 'selected' : '' }}>Pantao Ragat</option>
                <option value="Pantar" {{ $agencies->city == 'Pantar' ? 'selected' : '' }}>Pantar</option>
                <option value="Poona Piagapo" {{ $agencies->city == 'Poona Piagapo' ? 'selected' : '' }}>Poona Piagapo</option>
                <option value="Salvador" {{ $agencies->city == 'Salvador' ? 'selected' : '' }}>Salvador</option>
                <option value="Sapad" {{ $agencies->city == 'Sapad' ? 'selected' : '' }}>Sapad</option>
                <option value="Sultan Naga Dimaporo" {{ $agencies->city == 'Sultan Naga Dimaporo' ? 'selected' : '' }}>Sultan Naga Dimaporo</option>
                <option value="Tagoloan" {{ $agencies->city == 'Tagoloan' ? 'selected' : '' }}>Tagoloan</option>
                <option value="Tangcal" {{ $agencies->city == 'Tangcal' ? 'selected' : '' }}>Tangcal</option>
                <option value="Tubod" {{ $agencies->city == 'Tubod' ? 'selected' : '' }}>Tubod (Capital)</option>
            </select>
        </div>
        <!-- if city Iligan City is selected or current data -->
        <div class="mb-5" id="barangay-iligan-city" style="display: {{ $agencies->city == 'Iligan City' ? 'block' : 'none' }};">
            <label for="barangay" class="block mb-2 text-[12px] font-[Poppins]">Barangay</label>
            <select name="barangay" id="barangay"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option disabled>Select Barangay</option>
                @forelse ($barangays as $barangay)
                <option value="{{ $barangay->barangayNames }}"
                    {{ $agencies->barangay == $barangay->barangayNames ? 'selected' : '' }}>
                    {{ $barangay->barangayNames }}
                </option>
                @empty
                <option disabled>No Barangay Found</option>
                @endforelse
            </select>
        </div>
        <div class="mb-5">
            <label class="block mb-2 text-[12px]">Address</label>
            <!-- visible but readonly (user cannot edit, still shows address) -->
            <input type="text" id="address_display"
                class="w-full p-2.5 border rounded-lg text-[12px] bg-gray-300"
                readonly />

            <!-- hidden input that actually submits -->
            <input type="hidden" name="address" id="address" />
        </div>


        <!-- Longitude -->
        <div class="mb-5">
            <label class="block mb-2 text-[12px]">Longitude</label>
            <input type="text" name="longitude" required
                class="w-full p-2.5 border rounded-lg text-[12px]" value="{{ $agencies->longitude }}" />
        </div>

        <!-- Latitude -->
        <div class="mb-5">
            <label class="block mb-2 text-[12px]">Latitude</label>
            <input type="text" name="latitude" required
                class="w-full p-2.5 border rounded-lg text-[12px]" value="{{ $agencies->latitude }}" />
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-[12px]">Zip Code</label>
            <input type="text" name="zipcode" required
                class="w-full p-2.5 border rounded-lg text-[12px]" value="{{ $agencies->zipcode }}" />
        </div>

        <input type="hidden" name="activeStatus" value="Active">

        <!-- Submit -->
        <button type="submit"
            class="bg-blue-700 hover:bg-blue-800 text-white w-full px-5 py-2.5 rounded-lg">
            Submit
        </button>
    </form>
    <x-partials.stack-js />

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const regionSelect = document.querySelector("select[name='region']");
            const provinceLuzon = document.getElementById("province-luzon");
            const provinceVisayas = document.getElementById("province-visayas");
            const provinceMindanao = document.getElementById("province-mindanao");

            const cityLanaoDelNorte = document.getElementById("city-lanao-del-norte");
            const barangayIligan = document.getElementById("barangay-iligan-city");

            const provinceSelects = document.querySelectorAll("select[name='province']");
            const citySelect = document.querySelector("select[name='city']");
            const barangaySelect = document.querySelector("select[name='barangay']");

            const addressInput = document.getElementById("address");
            const addressDisplay = document.getElementById("address_display");

            // Hide/Show province fields based on region
            regionSelect.addEventListener("change", function() {
                provinceLuzon.style.display = this.value === "Luzon" ? "block" : "none";
                provinceVisayas.style.display = this.value === "Visayas" ? "block" : "none";
                provinceMindanao.style.display = this.value === "Mindanao" ? "block" : "none";
                updateAddress();
            });

            // Province change
            provinceSelects.forEach(province => {
                province.addEventListener("change", function() {
                    cityLanaoDelNorte.style.display = this.value === "Lanao del Norte" ? "block" : "none";
                    updateAddress();
                });
            });

            // City change
            if (citySelect) {
                citySelect.addEventListener("change", function() {
                    barangayIligan.style.display = this.value === "Iligan City" ? "block" : "none";
                    updateAddress();
                });
            }

            // Barangay change
            if (barangaySelect) {
                barangaySelect.addEventListener("change", updateAddress);
            }

            // Update Address Field (auto generate full address)
            function updateAddress() {
                const region = regionSelect.value || "";
                let province = "";
                provinceSelects.forEach(provinceEl => {
                    if (provinceEl.value) province = provinceEl.value;
                });
                const city = citySelect?.value || "";
                const barangay = barangaySelect?.value || "";

                const fullAddress = [barangay, city, province, region].filter(Boolean).join(", ");
                addressDisplay.value = fullAddress;
                addressInput.value = fullAddress;
            }

            // Initialize on load
            updateAddress();
        });
    </script>
</x-layout.layout>