<x-layout.layout>
    <x-partials.toast-messages />
    <form
        class="max-w-sm mx-auto"
        action="{{ route('submit-incident-types.admin') }}"
        method="POST">

        @csrf

        <h4 class="my-5 text-center font-[Poppins] text-[14px] font-medium">Add Incident Type</h4>

        <!-- Category Select -->
        <div class="mb-5">
            <label for="category" class="block mb-2 font-[Poppins] text-[12px] text-gray-900">Category</label>
            <select
                id="category"
                name="category"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5"
                required>
                <option value="">-- Select Category --</option>
                <option value="Disaster Incident">Disaster Incident</option>
                <option value="Road Accident">Road Accident</option>
            </select>
        </div>

        <!-- Incident Name Select -->
        <div class="mb-5">
            <label for="incident_name" class="block mb-2 font-[Poppins] text-[12px] text-gray-900">Incident Name</label>
            <select
                id="incident_name"
                name="incident_name"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5"
                required>
                <option value="">-- Select Incident --</option>
                <!-- Options will be inserted via JS -->
            </select>
        </div>

        <button
            type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 font-[Poppins] rounded-lg text-[12px] font-semibold px-5 py-2.5 w-full">
            Submit
        </button>
    </form>

    <script>
        // Incident lists
        const incidents = {
            "Disaster Incident": [
                "Fire",
                "Flood",
                "Earthquake",
                "Landslide",
                "Typhoon"
            ],
            "Road Accident": [
                "Car Collision",
                "Motorcycle Accident",
                "Truck Accident",
                "Pedestrian Accident",
                "Highway Crash"
            ]
        };

        const categorySelect = document.getElementById('category');
        const incidentSelect = document.getElementById('incident_name');

        // Populate incidents based on category
        function updateIncidentOptions(selectedCategory) {
            incidentSelect.innerHTML = "<option value=''>-- Select Incident --</option>";
            if (incidents[selectedCategory]) {
                incidents[selectedCategory].forEach(incident => {
                    let option = document.createElement('option');
                    option.value = incident;
                    option.text = incident;
                    incidentSelect.appendChild(option);
                });
            }
        }

        // Update incidents when category changes
        categorySelect.addEventListener('change', function () {
            updateIncidentOptions(this.value);
        });
    </script>
    <x-partials.stack-js />
</x-layout.layout>
