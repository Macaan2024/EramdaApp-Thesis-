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

        <h4 class="my-5 text-center font-[Poppins] text-[14px] font-medium">Add Agency</h4>

        <!-- Agency Type -->
        <div class="mb-5">
            <label for="agencyTypes" class="block mb-2 text-[12px] font-[Poppins]">Select Agencies</label>
            <select name="agencyTypes"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option selected disabled>Choose Agencies</option>
                <option value="BFP">Bureau of Fire Protection (BFP)</option>
                <option value="BDRRMC">Barangay Disaster Risk Reduction and Management Committee (BDRRMC)</option>
                <option value="Hospital">Hospitals</option>
                <option value="CDRRMO">City Disaster Risk Reduction and Management Office</option>
            </select>
        </div>

        <!-- Agency Name -->
        <div class="mb-5">
            <label class="block mb-2 text-[12px] font-[Poppins]">Agency Name</label>
            <input type="text" name="agencyNames" placeholder="Bureau of Fire Station 4" required
                class="w-full p-2.5 border rounded-lg text-[12px]" />
        </div>

        <!-- Agency Email -->
        <div class="mb-5">
            <label class="block mb-2 text-[12px] font-[Poppins]">Agency Email</label>
            <input type="email" name="email" placeholder="bfpplazastation1@gmail.com" required
                class="w-full p-2.5 border rounded-lg text-[12px]" />
        </div>

        <!-- Regions -->
        <div class="mb-5">
            <label for="region" class="block mb-2 text-[12px] font-[Poppins]">Regions</label>
            <select name="region" id="regions"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option selected disabled> Select Regions</option>
                <option value="Luzon">Luzon</option>
                <option value="Visayas">Visayas</option>
                <option value="Mindanao">Mindanao</option>
            </select>
        </div>

        <!-- Province of Luzon -->
        <div class="mb-5 province-group" id="luzon-province" style="display: none;">
            <label for="province" class="block mb-2 text-[12px] font-[Poppins]">Province</label>
            <select name="province"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option selected disabled>Select Province</option>
                <option value="Abra">Abra</option>
                <option value="Albay">Albay</option>
                <option value="Apayao">Apayao</option>
                <option value="Aurora">Aurora</option>
                <option value="Bataan">Bataan</option>
                <option value="Batangas">Batangas</option>
                <option value="Benguet">Benguet</option>
                <option value="Bulacan">Bulacan</option>
                <option value="Cagayan">Cagayan</option>
                <option value="Camarines Norte">Camarines Norte</option>
                <option value="Camarines Sur">Camarines Sur</option>
                <option value="Catanduanes">Catanduanes</option>
                <option value="Cavite">Cavite</option>
                <option value="Ifugao">Ifugao</option>
                <option value="Ilocos Norte">Ilocos Norte</option>
                <option value="Ilocos Sur">Ilocos Sur</option>
                <option value="Isabela">Isabela</option>
                <option value="Kalinga">Kalinga</option>
                <option value="La Union">La Union</option>
                <option value="Laguna">Laguna</option>
                <option value="Marinduque">Marinduque</option>
                <option value="Masbate">Masbate</option>
                <option value="Metro Manila">Metro Manila</option>
                <option value="Mountain Province">Mountain Province</option>
                <option value="Nueva Ecija">Nueva Ecija</option>
                <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                <option value="Occidental Mindoro">Occidental Mindoro</option>
                <option value="Oriental Mindoro">Oriental Mindoro</option>
                <option value="Palawan">Palawan</option>
                <option value="Pampanga">Pampanga</option>
                <option value="Pangasinan">Pangasinan</option>
                <option value="Quezon">Quezon</option>
                <option value="Quirino">Quirino</option>
                <option value="Rizal">Rizal</option>
                <option value="Romblon">Romblon</option>
                <option value="Sorsogon">Sorsogon</option>
                <option value="Tarlac">Tarlac</option>
                <option value="Zambales">Zambales</option>
            </select>
        </div>

        <!-- Province of Visayas -->
        <div class="mb-5 province-group" id="visayas-province" style="display: none;">
            <label for="province" class="block mb-2 text-[12px] font-[Poppins]">Province</label>
            <select name="province"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option selected disabled>Select Province</option>
                <option value="Aklan">Aklan</option>
                <option value="Antique">Antique</option>
                <option value="Biliran">Biliran</option>
                <option value="Bohol">Bohol</option>
                <option value="Capiz">Capiz</option>
                <option value="Cebu">Cebu</option>
                <option value="Eastern Samar">Eastern Samar</option>
                <option value="Guimaras">Guimaras</option>
                <option value="Iloilo">Iloilo</option>
                <option value="Leyte">Leyte</option>
                <option value="Negros Occidental">Negros Occidental</option>
                <option value="Negros Oriental">Negros Oriental</option>
                <option value="Northern Samar">Northern Samar</option>
                <option value="Samar">Samar</option>
                <option value="Southern Leyte">Southern Leyte</option>
            </select>
        </div>
        <!-- Provinces of Mindanao -->
        <div class="mb-5 province-group" id="mindanao-province" style="display: none;">
            <label for="province" class="block mb-2 text-[12px] font-[Poppins]">Province</label>
            <select name="province"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option selected disabled>Select Province</option>
                <option value="Agusan del Norte">Agusan del Norte</option>
                <option value="Agusan del Sur">Agusan del Sur</option>
                <option value="Basilan">Basilan</option>
                <option value="Bukidnon">Bukidnon</option>
                <option value="Camiguin">Camiguin</option>
                <option value="Compostela Valley">Compostela Valley</option>
                <option value="Cotabato">Cotabato</option>
                <option value="Davao de Oro">Davao de Oro</option>
                <option value="Davao del Norte">Davao del Norte</option>
                <option value="Davao del Sur">Davao del Sur</option>
                <option value="Davao Occidental">Davao Occidental</option>
                <option value="Davao Oriental">Davao Oriental</option>
                <option value="Dinagat Islands">Dinagat Islands</option>
                <option value="Lanao del Norte">Lanao del Norte</option>
                <option value="Lanao del Sur">Lanao del Sur</option>
                <option value="Maguindanao del Norte">Maguindanao del Norte</option>
                <option value="Maguindanao del Sur">Maguindanao del Sur</option>
                <option value="Misamis Occidental">Misamis Occidental</option>
                <option value="Misamis Oriental">Misamis Oriental</option>
                <option value="Sarangani">Sarangani</option>
                <option value="South Cotabato">South Cotabato</option>
                <option value="Sultan Kudarat">Sultan Kudarat</option>
                <option value="Sulu">Sulu</option>
                <option value="Surigao del Norte">Surigao del Norte</option>
                <option value="Surigao del Sur">Surigao del Sur</option>
                <option value="Tawi-Tawi">Tawi-Tawi</option>
                <option value="Zamboanga del Norte">Zamboanga del Norte</option>
                <option value="Zamboanga del Sur">Zamboanga del Sur</option>
                <option value="Zamboanga Sibugay">Zamboanga Sibugay</option>
            </select>
        </div>

        <div class="mb-5" id="city-group" style="display: none;">
            <label for="city" class="block mb-2 text-[12px] font-[Poppins]">City</label>
            <select name="city" id="city"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option selected disabled>Select City</option>
                <option value="Bacolod">Bacolod</option>
                <option value="Baloi">Baloi</option>
                <option value="Baroy">Baroy</option>
                <option value="Iligan City">Iligan City</option>
                <option value="Kapatagan">Kapatagan</option>
                <option value="Kauswagan">Kauswagan</option>
                <option value="Kolambugan">Kolambugan</option>
                <option value="Lala">Lala</option>
                <option value="Linamon">Linamon</option>
                <option value="Magsaysay">Magsaysay</option>
                <option value="Maigo">Maigo</option>
                <option value="Matungao">Matungao</option>
                <option value="Munai">Munai</option>
                <option value="Nunungan">Nunungan</option>
                <option value="Pantao Ragat">Pantao Ragat</option>
                <option value="Pantar">Pantar</option>
                <option value="Poona Piagapo">Poona Piagapo</option>
                <option value="Salvador">Salvador</option>
                <option value="Sapad">Sapad</option>
                <option value="Sultan Naga Dimaporo">Sultan Naga Dimaporo</option>
                <option value="Tagoloan">Tagoloan</option>
                <option value="Tangcal">Tangcal</option>
                <option value="Tubod">Tubod (Capital)</option>
            </select>
        </div>
        <!-- Iligan City Barangays -->
        <div class="mb-5" id="barangay-group" style="display: none;">
            <label for="barangay" class="block mb-2 text-[12px] font-[Poppins]">Barangay</label>
            <select name="barangay" id="barangay"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg w-full p-2.5">
                <option selected disabled>Select Barangay</option>
                @forelse ($barangays as $barangay)
                <option value="{{ $barangay->barangayNames }}">{{ $barangay->barangayNames }}</option>
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
                class="w-full p-2.5 border rounded-lg text-[12px]" />
        </div>

        <!-- Latitude -->
        <div class="mb-5">
            <label class="block mb-2 text-[12px]">Latitude</label>
            <input type="text" name="latitude" required
                class="w-full p-2.5 border rounded-lg text-[12px]" />
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-[12px]">Zip Code</label>
            <input type="text" name="zipcode" required
                class="w-full p-2.5 border rounded-lg text-[12px]" />
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
            const regionSelect = document.getElementById("regions");
            const provinceGroups = document.querySelectorAll(".province-group");
            const cityGroup = document.getElementById("city-group");
            const citySelect = document.getElementById("city");
            const barangayGroup = document.getElementById("barangay-group");
            const barangaySelect = document.getElementById("barangay");
            const addressInput = document.querySelector("input[name='address']");

            function updateAddress() {
                let province = "";
                provinceGroups.forEach(group => {
                    if (group.style.display === "block") {
                        const selected = group.querySelector("select").value;
                        if (selected && selected !== "Select Province") {
                            province = selected;
                        }
                    }
                });

                let city = cityGroup.style.display === "block" && citySelect.value !== "Select City" ?
                    citySelect.value :
                    "";

                let barangay = barangayGroup.style.display === "block" && barangaySelect.value !== "Select Barangay" ?
                    barangaySelect.value :
                    "";

                // combine values
                let fullAddress = [province, city, barangay].filter(Boolean).join(", ");

                // update both display + hidden input
                document.getElementById("address_display").value = fullAddress;
                document.getElementById("address").value = fullAddress;
            }

            // --- REGION LOGIC ---
            regionSelect.addEventListener("change", function() {
                provinceGroups.forEach(group => group.style.display = "none");

                if (this.value === "Luzon") {
                    document.getElementById("luzon-province").style.display = "block";
                } else if (this.value === "Visayas") {
                    document.getElementById("visayas-province").style.display = "block";
                } else if (this.value === "Mindanao") {
                    document.getElementById("mindanao-province").style.display = "block";
                }

                updateAddress();
            });

            // --- PROVINCE → CITY LOGIC ---
            const provinceSelects = document.querySelectorAll(".province-group select");

            provinceSelects.forEach(provinceSelect => {
                provinceSelect.addEventListener("change", function() {
                    if (this.value === "Lanao del Norte") {
                        cityGroup.style.display = "block";
                    } else {
                        cityGroup.style.display = "none";
                        barangayGroup.style.display = "none"; // hide barangay if not Iligan
                    }
                    updateAddress();
                });
            });

            // --- CITY → BARANGAY LOGIC ---
            citySelect.addEventListener("change", function() {
                if (this.value === "Iligan City") {
                    barangayGroup.style.display = "block";
                } else {
                    barangayGroup.style.display = "none";
                }
                updateAddress();
            });

            // --- BARANGAY LOGIC ---
            barangaySelect.addEventListener("change", function() {
                updateAddress();
            });
        });
    </script>
</x-layout.layout>