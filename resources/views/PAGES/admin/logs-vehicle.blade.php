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
                        <form action="{{ route('admin.logs-vehicle-delete', $log->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-red-600 text-white shadow-sm hover:bg-red-700 hover:shadow-md transition-all duration-200">
                                Delete
                            </button>
                        </form>
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

    <!-- Pagination -->
    <div class="mt-6 flex justify-center space-x-2 font-[Poppins] text-[12px] sm:text-[13px]">
        @if ($logs->hasPages())
            @if ($logs->onFirstPage())
                <span class="px-3 py-1 bg-gray-300 text-white rounded-[10px] cursor-not-allowed">Previous</span>
            @else
                <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-1 bg-blue-600 text-white rounded-[10px] hover:bg-blue-700 transition">Previous</a>
            @endif

            @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                @if ($page == $logs->currentPage())
                    <span class="px-3 py-1 bg-green-600 text-white rounded-[10px]">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-[10px] hover:bg-green-600 hover:text-white transition">{{ $page }}</a>
                @endif
            @endforeach

            @if ($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-1 bg-blue-600 text-white rounded-[10px] hover:bg-blue-700 transition">Next</a>
            @else
                <span class="px-3 py-1 bg-gray-300 text-white rounded-[10px] cursor-not-allowed">Next</span>
            @endif
        @endif
    </div>

    <x-partials.stack-js />
</x-layout.layout>
