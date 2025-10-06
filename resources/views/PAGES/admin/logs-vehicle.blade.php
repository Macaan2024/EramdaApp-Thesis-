<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h6 class="text-[16px] sm:text-[18px] font-[Poppins] font-semibold text-gray-800 mb-2 sm:mb-0">
            Emergency Vehicles Logs
        </h6>
    </div>

    @php
    $addCount = 0;
    $editCount = 0;
    $deleteCount = 0;

    foreach ($logs as $log) {
    if ($log->emergencyVehicle) {
    switch ($log->interaction_type) {
    case 'Add': $addCount++; break;
    case 'Update': $editCount++; break;
    case 'Delete': $deleteCount++; break;
    }
    }
    }
    @endphp

    <!-- Stats Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start gap-6 font-[Poppins] mb-6">
        <div class="w-full lg:w-1/2 flex flex-wrap gap-4 justify-start">
            <!-- Add -->
            <div class="bg-blue-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Added</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $addCount }}</p>
            </div>
            <!-- Edit -->
            <div class="bg-green-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Edited</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $editCount }}</p>
            </div>
            <!-- Delete -->
            <div class="bg-red-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Deleted</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $deleteCount }}</p>
            </div>
        </div>
    </div>

    <!-- Search + Filters -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 my-6 font-[Poppins]">
        <!-- Search -->
        <form class="w-full md:max-w-md flex" action="" method="GET">
            <div class="relative w-full">
                <input type="search" id="search-vehicles"
                    class="block w-full p-3 ps-10 text-[12px] sm:text-[13px] text-gray-800 border border-gray-300 rounded-[10px] bg-white shadow-sm 
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="Search vehicles..." name="search" value="{{ request('search') }}" />
                <button type="submit"
                    class="absolute end-2.5 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-[10px] text-[12px] sm:text-[13px] font-medium px-4 py-2 transition">
                    Search
                </button>
            </div>
        </form>

        <!-- Agency Filter -->
        <form class="w-full md:w-auto">
            <select onchange="if (this.value) window.location.href='/admin/logs-vehicles/{{ $status }}/' + this.value"
                class="block w-full p-3 text-[12px] sm:text-[13px] text-gray-800 border border-gray-300 rounded-[10px] bg-white shadow-sm 
                focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">Select Agency</option>
                @forelse ($agencies as $agency)
                <option value="{{ $agency->id }}" {{ $id == $agency->id ? 'selected' : '' }}>
                    {{ $agency->agencyNames }}
                </option>
                @empty
                <option disabled>No agencies found</option>
                @endforelse
            </select>
        </form>
    </div>

    <!-- Status Buttons + Add Vehicle -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
        <div class="flex flex-wrap gap-3 text-[12px] sm:text-[13px] font-[Poppins]">
            <a href="/admin/logs-vehicles/All/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'All' ? 'bg-gray-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">All</a>
            <a href="/admin/logs-vehicles/Add/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Add' ? 'bg-blue-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Added</a>
            <a href="/admin/logs-vehicles/Update/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Update' ? 'bg-green-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Edited</a>
            <a href="/admin/logs-vehicles/Delete/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Delete' ? 'bg-red-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Deleted</a>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="overflow-x-auto shadow-lg rounded-[10px] border border-gray-200 bg-white font-[Poppins]">
        <table class="min-w-full text-[12px] sm:text-[13px] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white uppercase">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left">No</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Image</th>
                    <th class="px-4 sm:px-6 py-3 text-left">By</th>
                    <th class="px-4 sm:px-6 py-3 text-left">From</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Interaction</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Vehicle</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Plate #</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Created</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Updated</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Deleted</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($logs as $log)
                <tr class="hover:bg-blue-50 transition duration-200">
                    <td class="px-4 sm:px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        @if ($log->emergencyVehicle && $log->emergencyVehicle->vehicle_photo)
                        <img src="{{ asset('storage/' . $log->emergencyVehicle->vehicle_photo) }}"
                            alt="Vehicle Image" class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-[10px] border shadow-sm">
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->modified_by }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->agency->agencyTypes }}</td>
                    <td class="px-4 sm:px-6 py-3 font-semibold">
                        @php
                        $type = $log->interaction_type;
                        $textColor = match($type) {
                        'Add' => 'text-blue-600',
                        'Update' => 'text-green-600',
                        'Delete' => 'text-red-600',
                        default => 'text-gray-700',
                        };
                        @endphp
                        <span class="{{ $textColor }}">{{ $log->interaction_type }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->emergencyVehicle->vehicleTypes ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->emergencyVehicle->plateNumber ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->created_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->updated_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->emergencyVehicle?->deleted_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        <div class="flex flex-row gap-4 items-center">
                            <button
                                type="button"
                                class="track-btn px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-blue-600 text-white shadow-sm hover:bg-blue-700 hover:shadow-md transition-all duration-200"
                                data-vehicle-id="{{ $log->emergencyVehicle->id ?? '' }}">
                                Track
                            </button>

                            <form action="{{ route('admin.logs-vehicle-delete', $log->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-red-600 text-white shadow-sm hover:bg-red-700 hover:shadow-md transition-all duration-200">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-6 py-4 text-center text-gray-500 text-[12px]">
                        No vehicle logs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 font-[Poppins] text-[12px] sm:text-[13px]">
        @if ($logs->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            {{-- Pagination Controls --}}
            <div class="flex items-center space-x-1 sm:space-x-2">
                {{-- Previous --}}
                @if ($logs->onFirstPage())
                <span class="px-3 py-2 bg-gray-300 text-white rounded-[10px] cursor-not-allowed flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="hidden sm:inline">Previous</span>
                </span>
                @else
                <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-[10px] hover:bg-blue-700 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="hidden sm:inline">Previous</span>
                </a>
                @endif

                {{-- Page Numbers --}}
                <div class="flex items-center space-x-1">
                    @php
                    $start = max($logs->currentPage() - 2, 1);
                    $end = min($logs->currentPage() + 2, $logs->lastPage());
                    @endphp

                    @if ($start > 1)
                    <a href="{{ $logs->url(1) }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-[10px] hover:bg-green-600 hover:text-white transition">1</a>
                    @if ($start > 2)
                    <span class="px-2 text-gray-500">...</span>
                    @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page==$logs->currentPage())
                        <span class="px-3 py-2 bg-green-600 text-white rounded-[10px] font-semibold">{{ $page }}</span>
                        @else
                        <a href="{{ $logs->url($page) }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-[10px] hover:bg-green-600 hover:text-white transition">{{ $page }}</a>
                        @endif
                        @endfor

                        @if ($end < $logs->lastPage())
                            @if ($end < $logs->lastPage() - 1)
                                <span class="px-2 text-gray-500">...</span>
                                @endif
                                <a href="{{ $logs->url($logs->lastPage()) }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-[10px] hover:bg-green-600 hover:text-white transition">{{ $logs->lastPage() }}</a>
                                @endif
                </div>

                {{-- Next --}}
                @if ($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-[10px] hover:bg-blue-700 transition flex items-center gap-1">
                    <span class="hidden sm:inline">Next</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                @else
                <span class="px-3 py-2 bg-gray-300 text-white rounded-[10px] cursor-not-allowed flex items-center gap-1">
                    <span class="hidden sm:inline">Next</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
                @endif
            </div>
        </div>
        @endif
    </div>


    <!-- Second Table ======================================= -->

    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
    <h6 class="text-[14px] sm:text-[16px] font-[Poppins] font-semibold text-gray-800 my-6">Emergency Vehicles Table Data</h6>

    <!-- Status Buttons + Add Vehicle -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
        <div class="flex flex-wrap gap-3 text-[12px] sm:text-[13px] font-[Poppins]">
            <a href="/admin/logs-vehicles/All/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'All' ? 'bg-gray-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">All</a>
            <a href="/admin/logs-vehicles/Add/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Add' ? 'bg-blue-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Police Car</a>
            <a href="/admin/logs-vehicles/Update/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Update' ? 'bg-green-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Fire Truck</a>
            <a href="/admin/logs-vehicles/Delete/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Delete' ? 'bg-red-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Ambulance</a>
        </div>

        <div class="w-full sm:w-auto">
            <a class="bg-gray-600 text-white py-3 px-6 rounded-[10px] hover:bg-gray-900 transition text-[12px] sm:text-[13px] font-[Poppins] font-medium block text-center sm:inline-block"
                href="{{ route('admin.logs-vehicles-add') }}">
                Add Vehicle
            </a>
        </div>
    </div>
    <!-- Logs Table -->
    <div class="overflow-x-auto shadow-lg rounded-[10px] border border-gray-200 bg-white font-[Poppins]">
        <table class="min-w-full text-[12px] sm:text-[13px] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white uppercase">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left">No</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Image</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Agency</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Vehicle</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Plate #</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Availability</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($vehicles as $vehicle)
                <tr id="vehicle-{{ $vehicle->id }}" class="hover:bg-blue-50 transition duration-200">
                    <td class="px-4 sm:px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        @if ($vehicle->vehicle_photo)
                        <img src="{{ asset('storage/' . $vehicle->vehicle_photo) }}"
                            alt="Vehicle Image" class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-[10px] border shadow-sm">
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->agency->agencyNames }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->vehicleTypes ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->plateNumber ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->availabilityStatus ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        <button type="submit"
                            class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-red-600 text-white shadow-sm hover:bg-red-700 hover:shadow-md transition-all duration-200">
                            View
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-red-600 text-white shadow-sm hover:bg-red-700 hover:shadow-md transition-all duration-200">
                            Edit
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-red-600 text-white shadow-sm hover:bg-red-700 hover:shadow-md transition-all duration-200">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-6 py-4 text-center text-gray-500 text-[12px]">
                        No vehicle logs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 font-[Poppins] text-[12px] sm:text-[13px]">
        @if ($vehicles->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">

            {{-- Pagination Controls --}}
            <div class="flex items-center space-x-1 sm:space-x-2">
                {{-- Previous --}}
                @if ($vehicles->onFirstPage())
                <span class="px-3 py-2 bg-gray-300 text-white rounded-[10px] cursor-not-allowed flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="hidden sm:inline">Previous</span>
                </span>
                @else
                <a href="{{ $vehicles->previousPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-[10px] hover:bg-blue-700 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="hidden sm:inline">Previous</span>
                </a>
                @endif

                {{-- Page Numbers --}}
                <div class="flex items-center space-x-1">
                    @php
                    $vStart = max($vehicles->currentPage() - 2, 1);
                    $vEnd = min($vehicles->currentPage() + 2, $vehicles->lastPage());
                    @endphp

                    @if ($vStart > 1)
                    <a href="{{ $vehicles->url(1) }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-[10px] hover:bg-green-600 hover:text-white transition">1</a>
                    @if ($vStart > 2)
                    <span class="px-2 text-gray-500">...</span>
                    @endif
                    @endif

                    @for ($page = $vStart; $page <= $vEnd; $page++)
                        @if ($page==$vehicles->currentPage())
                        <span class="px-3 py-2 bg-green-600 text-white rounded-[10px] font-semibold">{{ $page }}</span>
                        @else
                        <a href="{{ $vehicles->url($page) }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-[10px] hover:bg-green-600 hover:text-white transition">{{ $page }}</a>
                        @endif
                        @endfor

                        @if ($vEnd < $vehicles->lastPage())
                            @if ($vEnd < $vehicles->lastPage() - 1)
                                <span class="px-2 text-gray-500">...</span>
                                @endif
                                <a href="{{ $vehicles->url($vehicles->lastPage()) }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-[10px] hover:bg-green-600 hover:text-white transition">{{ $vehicles->lastPage() }}</a>
                                @endif
                </div>

                {{-- Next --}}
                @if ($vehicles->hasMorePages())
                <a href="{{ $vehicles->nextPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-[10px] hover:bg-blue-700 transition flex items-center gap-1">
                    <span class="hidden sm:inline">Next</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                @else
                <span class="px-3 py-2 bg-gray-300 text-white rounded-[10px] cursor-not-allowed flex items-center gap-1">
                    <span class="hidden sm:inline">Next</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
                @endif
            </div>
        </div>
        @endif
    </div>

    <x-partials.stack-js />
    <!-- Track JS -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const trackButtons = document.querySelectorAll(".track-btn");

            // When a Track button is clicked
            trackButtons.forEach(button => {
                button.addEventListener("click", () => {
                    const vehicleId = button.dataset.vehicleId;
                    if (!vehicleId) return;

                    // Add vehicleId to URL and reload the page
                    const url = new URL(window.location.href);
                    url.searchParams.set("track_vehicle_id", vehicleId);
                    window.location.href = url.toString();
                });
            });

            // After reload, check if there's a tracked vehicle
            const params = new URLSearchParams(window.location.search);
            const trackId = params.get("track_vehicle_id");

            if (trackId) {
                const targetRow = document.getElementById(`vehicle-${trackId}`);
                if (targetRow) {
                    // Highlight and scroll to the tracked vehicle
                    targetRow.classList.add("bg-yellow-200");
                    targetRow.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });

                    // Temporary highlight flash effect
                    setTimeout(() => targetRow.classList.remove("bg-yellow-200"), 2000);
                } else {
                    // If not on this page, show a message
                    alert("The vehicle is not on this page. Please go to the next/previous page.");
                }
            }
        });
    </script>

    <style>
        @keyframes flashHighlight {
            0% {
                background-color: #fef08a;
            }

            50% {
                background-color: #fde047;
            }

            100% {
                background-color: #fef08a;
            }
        }

        .bg-yellow-200 {
            animation: flashHighlight 1s ease-in-out;
        }
    </style>

</x-layout.layout>