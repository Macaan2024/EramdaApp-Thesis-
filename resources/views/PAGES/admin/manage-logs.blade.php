<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <h6 class="font-medium font-[Poppins] text-[16px] mb-6">Logs Management</h6>

    <!-- Navigation Links -->
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.logs-responder', 'All') }}" class="px-4 py-2 bg-blue-600 shadow rounded-[10px] text-sm font-[Poppins] font-medium text-white hover:bg-blue-700 transition">Personnel Responders</a>
        <a href="{{ route('admin.logs-vehicles', 'All') }}" class="px-4 py-2 bg-green-600 shadow rounded-[10px] text-sm font-[Poppins] font-medium text-white hover:bg-green-700 transition">Emergency Vehicles</a>
        <a href="#" class="px-4 py-2 bg-red-600 shadow rounded-[10px] text-sm font-[Poppins] font-medium text-white hover:bg-red-700 transition">Injuries</a>
        <a href="#" class="px-4 py-2 bg-purple-600 shadow rounded-[10px] text-sm font-[Poppins] font-medium text-white hover:bg-purple-700 transition">Attendance</a>
        <!-- Add other links similarly -->
    </div>

    <div class="flex flex-row justify-between items-center mb-4">
        <h6 class="text-[16px] font-[Poppins] font-medium">User Table Data</h6>
    </div>

    <!-- Logs Table -->
    <div class="overflow-x-auto shadow-lg rounded-[10px] border border-gray-200 bg-white">
        <table class="min-w-full text-[13px] font-[Poppins] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white uppercase">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left">No</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Image</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Vehicle</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Plate #</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Created</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($vehicles as $vehicle)
                <tr class="hover:bg-blue-100 transition duration-200">
                    <td class="px-4 sm:px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        @if ($vehicle->vehicle_photo)
                        <img src="{{ asset('storage/' . $vehicle->vehicle_photo) }}"
                            alt="Vehicle Image"
                            class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-[10px] border border-gray-300 shadow-sm">
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->vehicleTypes ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->plateNumber ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->created_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3 flex space-x-2">
                        <a href="#"
                            class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-green-600 text-white shadow-sm hover:bg-red-700 hover:shadow-md transition-all duration-200">Edit</a>
                        <form action="#" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-red-600 text-white shadow-sm hover:bg-red-700 hover:shadow-md transition-all duration-200">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 text-[12px]">
                        No vehicle logs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-row justify-between items-center mb-4">
        <h6 class="text-[16px] font-[Poppins] font-medium">Emergency Vehicles Table Data</h6>
    </div>

    <!-- Logs Table -->
    <div class="overflow-x-auto shadow-lg rounded-[10px] border border-gray-200 bg-white">
        <table class="min-w-full text-[13px] font-[Poppins] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white uppercase">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left">No</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Image</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Vehicle</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Plate #</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Created</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($vehicles as $vehicle)
                <tr class="hover:bg-blue-100 transition duration-200">
                    <td class="px-4 sm:px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        @if ($vehicle->vehicle_photo)
                        <img src="{{ asset('storage/' . $vehicle->vehicle_photo) }}"
                            alt="Vehicle Image"
                            class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-[10px] border border-gray-300 shadow-sm">
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->vehicleTypes ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->plateNumber ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $vehicle->created_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3 flex space-x-2">
                        <a href="#"
                            class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-green-600 text-white shadow-sm hover:bg-red-700 hover:shadow-md transition-all duration-200">Edit</a>
                        <form action="#" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-red-600 text-white shadow-sm hover:bg-red-700 hover:shadow-md transition-all duration-200">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 text-[12px]">
                        No vehicle logs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center space-x-2">
        @if ($vehicles->hasPages())
        {{-- Previous Page Link --}}
        @if ($vehicles->onFirstPage())
        <span class="px-3 py-1 bg-gray-300 text-white rounded-[10px] cursor-not-allowed">Previous</span>
        @else
        <a href="{{ $vehicles->previousPageUrl() }}" class="px-3 py-1 bg-blue-600 text-white rounded-[10px] hover:bg-blue-700 transition">Previous</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($vehicles->getUrlRange(1, $vehicles->lastPage()) as $page => $url)
        @if ($page == $vehicles->currentPage())
        <span class="px-3 py-1 bg-green-600 text-white rounded-[10px]">{{ $page }}</span>
        @else
        <a href="{{ $url }}" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-[10px] hover:bg-green-600 hover:text-white transition">{{ $page }}</a>
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($vehicles->hasMorePages())
        <a href="{{ $vehicles->nextPageUrl() }}" class="px-3 py-1 bg-blue-600 text-white rounded-[10px] hover:bg-blue-700 transition">Next</a>
        @else
        <span class="px-3 py-1 bg-gray-300 text-white rounded-[10px] cursor-not-allowed">Next</span>
        @endif
        @endif
    </div>

    <x-partials.stack-js />
</x-layout.layout>