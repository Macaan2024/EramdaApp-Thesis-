<x-layout.layout>
    <form
        class="max-w-sm mx-auto"
        action="{{ route('admin.update-incident-types', $incident_types->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        <h4 class="my-5 text-center font-[Poppins] text-[14px] font-medium">Edit Incident Type</h4>

        <!-- Category Select -->
        <div class="mb-5">
            <label for="category" class="block mb-2 font-[Poppins] text-[12px] text-gray-900">Category</label>
            <select
                id="category"
                name="category"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5"
                required>
                <option value="">-- Select Category --</option>
                <option value="Disaster Incident" {{ $incident_types->category == 'Disaster Incident' ? 'selected' : '' }}>Disaster Incident</option>
                <option value="Road Accident" {{ $incident_types->category == 'Road Accident' ? 'selected' : '' }}>Road Accident</option>
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
        function updateIncidentOptions(selectedCategory, selectedIncident = null) {
            incidentSelect.innerHTML = "<option value=''>-- Select Incident --</option>";
            if (incidents[selectedCategory]) {
                incidents[selectedCategory].forEach(incident => {
                    let option = document.createElement('option');
                    option.value = incident;
                    option.text = incident;
                    if (incident === selectedIncident) option.selected = true;
                    incidentSelect.appendChild(option);
                });
            }
        }

        // Update incidents when category changes
        categorySelect.addEventListener('change', function () {
            updateIncidentOptions(this.value);
        });

        // Auto-select current values when editing
        document.addEventListener("DOMContentLoaded", function () {
            let oldCategory = @json($incident_types->category);
            let oldIncident = @json($incident_types->incident_name);

            if (oldCategory) {
                categorySelect.value = oldCategory; // auto select category
                updateIncidentOptions(oldCategory, oldIncident); // auto select incident
            }
        });
    </script>
</x-layout.layout>
