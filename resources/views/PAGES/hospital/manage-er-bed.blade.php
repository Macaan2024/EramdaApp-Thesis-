<x-layout.layout>

    <x-partials.toast-messages />

    <!-- Title -->
    <h6 class="font-[Poppins] text-[16px] mb-3 text-gray-800">Agencies Management</h6>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-900 text-white rounded-xl shadow-sm p-4 flex flex-col items-center">
            <h4 class="font-[Poppins] text-[14px] font-medium">Total Beds</h4>
            <p class="text-2xl font-bold mt-1">{{ $beds->count() }}</p>
        </div>

        <div class="bg-green-800 text-white rounded-xl shadow-sm p-4 flex flex-col items-center">
            <h4 class="font-[Poppins] text-[14px] font-medium">Total Available Beds</h4>
            <p class="text-2xl font-bold mt-1">{{ $bedsAvailable }}</p>
        </div>

        <div class="bg-red-800 text-white rounded-xl shadow-sm p-4 flex flex-col items-center">
            <h4 class="font-[Poppins] text-[14px] font-medium">Total Unavailable Beds</h4>
            <p class="text-2xl font-bold mt-1">{{ $bedsUnavailable }}</p>
        </div>
    </div>

    <!-- Search & Add Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
        <!-- Search Form -->
        <form class="w-full md:max-w-md" action="{{ route('nurse-chief.bed') }}" method="GET">
            <div class="relative">
                <!-- Search Icon -->
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>

                <!-- Search Input -->
                <input type="search" id="search-bed"
                    class="block w-full p-3 ps-10 text-[12px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search Beds..." name="search" value="{{ request('search') }}" />

                <!-- Search Button -->
                <button type="submit"
                    class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-[12px] font-[Poppins] px-4 py-2">
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Filter & Add -->
    <div class="flex flex-col sm:flex-row justify-between items-center sm:items-center gap-3">
        <div class="flex flex-wrap gap-3 py-2">
            <button
                class="px-4 py-2 rounded-lg text-sm font-[Poppins] font-semibold bg-gray-700 text-white hover:bg-gray-800 transition">
                All
            </button>
            <button
                class="px-4 py-2 rounded-lg text-sm font-[Poppins] font-semibold bg-green-600 text-white hover:bg-green-700 transition">
                Available
            </button>
            <button
                class="px-4 py-2 rounded-lg text-sm font-[Poppins] font-semibold bg-red-600 text-white hover:bg-red-700 transition">
                Unavailable
            </button>
        </div>

        <div>
            <x-partials.modality-add-bed />
        </div>
    </div>

    <!-- Beds Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
        <table class="w-full text-[12px] font-[Roboto] text-gray-700">
            <thead class="bg-blue-600 text-white font-[Poppins] text-[14px] uppercase">
                <tr class="text-left">
                    <th class="px-3 py-2">#</th>
                    <th class="px-3 py-2">Room Number</th>
                    <th class="px-3 py-2">Bed Type</th>
                    <th class="px-3 py-2">Bed Number</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Created At</th>
                    <th class="px-3 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($beds as $bed)
                <tr class="bg-white hover:bg-gray-100 border-b border-gray-200 text-gray-800">
                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2">{{ $bed->room_number }}</td>
                    <td class="px-3 py-2">{{ $bed->bed_type }}</td>
                    <td class="px-3 py-2">{{ $bed->bed_number }}</td>
                    <td class="px-3 py-2">
                        <span
                            class="px-3 py-1 rounded-full text-white text-[12px] font-[Poppins]
                                {{ $bed->availabilityStatus === 'Available' ? 'bg-green-600' : 'bg-red-600' }}">
                            {{ $bed->availabilityStatus }}
                        </span>
                    </td>
                    <td class="px-3 py-2">{{ $bed->created_at->format('M d, Y') }}</td>
                    <td class="px-3 py-2 text-center">
                        <x-partials.modality-edit-bed :bed="$bed" />
                        <form action="{{ route('nurse-chief.delete-bed', $bed->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this bed?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-4 py-2 rounded-lg text-[12px] font-[Poppins] font-semibold bg-red-600 text-white hover:bg-red-700 shadow-md transition">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500 font-[Poppins]">
                        No beds found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-center">
        {{ $beds->appends(request()->except('users_page'))->links() }}
    </div>

</x-layout.layout>