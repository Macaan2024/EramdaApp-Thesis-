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

    <form
        class="max-w-sm mx-auto"
        action="{{ route('admin.submit-barangay') }}"
        method="POST">

        @csrf
        @method('POST')

        <h4 class="my-5 text-center font-[Poppins] text-[14px] font-medium">Add Barangay</h4>

        <!-- Barangay Name -->
        <div class="mb-5">
            <label for="barangayNames" class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">
                Barangay Name
            </label>
            <input
                type="text"
                id="barangayNames"
                name="barangayNames"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5"
                placeholder="Mahayahay"
                required />
        </div>

        <!-- City -->
        <div class="mb-5">
            <label for="city" class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">
                City
            </label>
            <input
                type="text"
                id="city"
                name="city"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5"
                placeholder="Iligan City"
                required />
        </div>

        <!-- Error message container -->
        <div id="location-error" class="hidden mb-5 text-red-600 text-[12px] font-[Poppins]"></div>

        <!-- Auto-filled Longitude -->
        <div class="mb-5">
            <label for="longitude" class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">
                Longitude
            </label>
            <input
                type="text"
                id="longitude"
                name="longitude"
                readonly
                class="bg-gray-100 cursor-not-allowed font-[Poppins] text-[12px] border border-gray-300 rounded-lg block w-full p-2.5" />
        </div>

        <!-- Auto-filled Latitude -->
        <div class="mb-5">
            <label for="latitude" class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">
                Latitude
            </label>
            <input
                type="text"
                id="latitude"
                name="latitude"
                readonly
                class="bg-gray-100 cursor-not-allowed font-[Poppins] text-[12px] border border-gray-300 rounded-lg block w-full p-2.5" />
        </div>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 font-[Poppins] rounded-lg text-[12px] px-5 py-2.5 w-full">
            Submit
        </button>
    </form>

    <script>
        async function fetchCoordinates() {
            let barangay = document.getElementById('barangayNames').value.trim();
            let city = document.getElementById('city').value.trim();
            let errorBox = document.getElementById('location-error');
            let longitudeField = document.getElementById('longitude');
            let latitudeField = document.getElementById('latitude');

            // Clear previous error
            errorBox.classList.add('hidden');
            errorBox.innerHTML = "";
            longitudeField.value = "";
            latitudeField.value = "";

            if (barangay && city) {
                let query = 'Barangay ' + barangay + ', ' + city;
                let url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1`;

                try {
                    let response = await fetch(url, {
                        headers: { 'Accept-Language': 'en' }
                    });

                    let data = await response.json();

                    if (data.length > 0) {
                        longitudeField.value = data[0].lon;
                        latitudeField.value = data[0].lat;
                    } else {
                        errorBox.innerHTML = `❌ No coordinates found for "<b>${barangay}</b>, <b>${municipal}</b>". Please check spelling.`;
                        errorBox.classList.remove('hidden');
                    }
                } catch (error) {
                    errorBox.innerHTML = "⚠️ Failed to fetch coordinates. Please try again.";
                    errorBox.classList.remove('hidden');
                }
            }
        }

        // Trigger fetch when typing is finished (blur)
        document.getElementById('barangayNames').addEventListener('blur', fetchCoordinates);
        document.getElementById('city').addEventListener('blur', fetchCoordinates);
    </script>

    <x-partials.stack-js />
</x-layout.layout>
