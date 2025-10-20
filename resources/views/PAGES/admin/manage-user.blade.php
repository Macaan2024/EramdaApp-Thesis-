<x-layout.layout>
    <!-- Title -->
    <x-partials.toast-messages />
    <h6 class="font-[Poppins] text-[14px] mb-3 text-gray-800">Agencies Management</h6>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-900 text-white rounded-xl shadow-sm p-4 flex flex-col items-center">
            <h4 class="font-[Poppins] text-[14px] font-medium">Total BDRRMC Members</h4>
            <p class="text-2xl font-bold mt-1">{{ $totalBDRRMC }}</p>
        </div>

        <div class="bg-red-900 text-white rounded-xl shadow-sm p-4 flex flex-col items-center">
            <h4 class="font-[Poppins] text-[14px] font-medium">Total BFP Members</h4>
            <p class="text-2xl font-bold mt-1">{{ $totalBFP }}</p>
        </div>

        <div class="bg-green-900 text-white rounded-xl shadow-sm p-4 flex flex-col items-center">
            <h4 class="font-[Poppins] text-[14px] font-medium">Total Hospital Members</h4>
            <p class="text-2xl font-bold mt-1">{{ $totalHOSPITAL }}</p>
        </div>

        <div class="bg-yellow-900 text-white rounded-xl shadow-sm p-4 flex flex-col items-center">
            <h4 class="font-[Poppins] text-[14px] font-medium">Total CDRRMO Members</h4>
            <p class="text-2xl font-bold mt-1">{{ $totalCDRRMO }}</p>
        </div>
    </div>

    <!-- Search & Add Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
        <!-- Search Form -->
        <form class="w-full md:max-w-md" action="{{ route('admin.search-agency') }}" method="POST">
            @csrf
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>

                <input type="search" id="search-responders"
                    class="block w-full p-3 ps-10 text-[12px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search Responders..." name="search" value="{{ request('search') }}" />

                <button type="submit"
                    class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-[12px] font-[Poppins] px-4 py-2">
                    Search
                </button>
            </div>
        </form>

        <div class="flex flex-row gap-4 items-center">
            <!-- Agency Filter -->
            <form class="w-full md:w-auto">
                <select
                    onchange="
            if (this.value) {
                window.location.href = '/admin/user/{{ $status }}/' + this.value;
            } else {
                window.location.href = '/admin/user/All';
            }
        "
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
            <x-partials.modality-add-users :agencies="$agencies" />
        </div>
    </div>


    <!-- Filter Agency Types -->
    <div class="flex flex-wrap gap-3 py-4">

        <a href="{{ route('admin.user', 'All') }}"
            class="px-4 py-2 rounded-lg text-sm font-[Poppins] font-semibold transition 
       {{ $status === 'All' ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            All
        </a>

        <a href="{{ route('admin.user', 'BFP') }}"
            class="px-4 py-2 rounded-lg text-sm font-[Poppins] font-semibold transition
       {{ $status === 'BFP' ? 'bg-red-700 text-white' : 'bg-red-600 text-white hover:bg-red-700' }}">
            BFP
        </a>

        <a href="{{ route('admin.user', 'HOSPITAL') }}"
            class="px-4 py-2 rounded-lg text-sm font-[Poppins] font-semibold transition
       {{ $status === 'HOSPITAL' ? 'bg-blue-700 text-white' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
            HOSPITAL
        </a>

        <a href="{{ route('admin.user', 'CDRRMO') }}"
            class="px-4 py-2 rounded-lg text-sm font-[Poppins] font-semibold transition
       {{ $status === 'CDRRMO' ? 'bg-green-700 text-white' : 'bg-green-600 text-white hover:bg-green-700' }}">
            CDRRMO
        </a>

        <a href="{{ route('admin.user', 'BDRRMC') }}"
            class="px-4 py-2 rounded-lg text-sm font-[Poppins] font-semibold transition
       {{ $status === 'BDRRMC' ? 'bg-yellow-700 text-white' : 'bg-yellow-500 text-white hover:bg-yellow-600' }}">
            BDRRMC
        </a>

    </div>


    <!-- Agencies Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-[12px] font-[Roboto] text-gray-200">
            <thead class="bg-blue-600 text-white font-[Poppins] text-[14px] uppercase">
                <tr class="text-left">
                    <th class="px-3 py-2">No</th>
                    <th class="px-3 py-2">Image</th>
                    <th class="px-3 py-2">Agency</th>
                    <th class="px-3 py-2">Role</th>
                    <th class="px-3 py-2">Name</th>
                    <th class="px-3 py-2">Position</th>
                    <th class="px-3 py-2">Account Status</th>
                    <th class="px-3 py-2">Availability Status</th>
                    <th class="px-3 py-2">Created At</th>
                    <th class="px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="bg-white hover:bg-gray-100 border-b border-gray-200 text-black">
                    <td class="px-3 py-2">{{ $loop->iteration }}</td>

                    <!-- User Photo -->
                    <td class="px-3 py-2">
                        @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="User Image"
                            class="h-8 w-8 object-cover rounded-full">
                        @else
                        <span class="text-gray-400 text-[12px]">No Image</span>
                        @endif
                    </td>

                    <!-- Agency -->
                    <td class="px-3 py-2">{{ $user->agency->agencyNames ?? 'N/A' }}</td>

                    <!-- User Type -->
                    <td class="px-3 py-2">{{ $user->user_type ?? 'N/A' }}</td>

                    <!-- Full Name -->
                    <td class="px-3 py-2">{{ $user->firstname ?? 'N/A' }} {{ $user->lastname ?? 'N/A' }}</td>

                    <!-- Position -->
                    <td class="px-3 py-2">{{ $user->position ?? 'N/A' }}</td>

                    <!-- Account Status -->
                    <td class="px-3 py-2">
                        <span class="px-2 py-1 rounded-sm text-[12px] font-[Poppins]
                {{ $user->account_status === 'Active' ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                            {{ $user->account_status ?? 'N/A' }}
                        </span>
                    </td>

                    <!-- Availability -->
                    <td class="px-3 py-2">
                        <span class="px-2 py-1 rounded-sm text-[12px] font-[Poppins]
                {{ $user->availability_status === 'Available' ? 'bg-yellow-600 text-white' : 'bg-gray-500 text-white' }}">
                            {{ $user->availability_status ?? 'N/A' }}
                        </span>
                    </td>

                    <!-- Created At -->
                    <td class="px-3 py-2">
                        {{ $user->created_at ? $user->created_at->format('F d, Y h:i A') : 'N/A' }}
                    </td>

                    <!-- Actions -->
                    <td class="px-3 py-2 flex gap-2">
                        <x-partials.modality-view-user :user="$user" />
                        <x-partials.modality-edit-user :user="$user" :agencies="$agencies" />
                        <form action="{{ route('admin.logs-delete-users', $user->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins]">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-400">🚫 No Users Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-center">
        {{ $users->appends(request()->except('users_page'))->links() }}
    </div>
</x-layout.layout>