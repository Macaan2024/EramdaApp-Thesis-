{{-- resources/views/PAGES/admin/logs-view-vehicle.blade.php --}}
<x-layout.layout>

    <x-partials.toast-messages />

    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

        <!-- Header Image Section -->
        <div class="relative">
            @if($log->emergencyVehicle && $log->emergencyVehicle->vehicle_photo)
                <img src="{{ asset('storage/' . $log->emergencyVehicle->vehicle_photo) }}" 
                     alt="Vehicle Photo"
                     class="w-full h-64 object-cover">
            @else
                <div class="w-full h-64 bg-gray-100 flex items-center justify-center">
                    <span class="text-gray-500 text-sm font-[Poppins]">No photo available</span>
                </div>
            @endif

            <!-- Back Button -->
            <div class="absolute top-4 left-4">
                <a href="{{ url()->previous() }}" 
                   class="bg-white/90 backdrop-blur px-3 py-1.5 rounded-lg text-xs font-[Poppins] text-gray-700 hover:bg-gray-200 shadow-md transition">
                    ← Back
                </a>
            </div>

            <!-- Overlay Label -->
            @if($log->emergencyVehicle)
                <div class="absolute bottom-4 left-4 bg-black/60 text-white px-4 py-2 rounded-lg">
                    <h2 class="text-xl font-semibold font-[Poppins]">{{ $log->emergencyVehicle->vehicleTypes }}</h2>
                    <p class="text-sm text-gray-200 font-[Poppins]">Plate No: {{ $log->emergencyVehicle->plateNumber }}</p>
                </div>
            @endif
        </div>

        <!-- Vehicle Info -->
        <div class="p-8 space-y-6">
            <div class="border-b border-gray-200 pb-3">
                <h3 class="text-lg font-semibold text-gray-800 font-[Poppins]">Vehicle Information</h3>
                <p class="text-gray-500 text-sm font-[Poppins]">Detailed information about this emergency vehicle</p>
            </div>

            @if($log->emergencyVehicle)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-[14px] font-[Poppins]">
                    <div>
                        <h4 class="text-gray-600 font-medium mb-1">Vehicle Type</h4>
                        <p class="text-gray-800 font-semibold">{{ $log->emergencyVehicle->vehicleTypes }}</p>
                    </div>

                    <div>
                        <h4 class="text-gray-600 font-medium mb-1">Plate Number</h4>
                        <p class="text-gray-800 font-semibold">{{ $log->emergencyVehicle->plateNumber }}</p>
                    </div>

                    <div>
                        <h4 class="text-gray-600 font-medium mb-1">Availability</h4>
                        <span class="inline-block px-3 py-1 text-xs rounded-full text-white font-semibold
                            {{ ($log->emergencyVehicle->availabilityStatus) === 'Available' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ ucfirst($log->emergencyVehicle->availabilityStatus) }}
                        </span>
                    </div>

                    <div>
                        <h4 class="text-gray-600 font-medium mb-1">Last Updated</h4>
                        <p class="text-gray-800 font-semibold">{{ $log->emergencyVehicle->updated_at?->format('F d, Y h:i A') ?? '—' }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="#"
                       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg shadow transition">
                        Edit Vehicle
                    </a>
                    <form action="#" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg shadow transition">
                            Delete Vehicle
                        </button>
                    </form>
                </div>
            @else
                <p class="text-center text-gray-500 font-[Poppins] py-6">No emergency vehicle details found for this log.</p>
            @endif
        </div>
    </div>

</x-layout.layout>
