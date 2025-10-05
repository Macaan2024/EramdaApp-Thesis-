<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <div class="flex justify-between items-center mb-6">
        <h6 class="text-xl font-[Poppins] font-semibold text-gray-800">
            Personnel Responders Logs
        </h6>
    </div>


    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-6">
        <!-- Total -->
        <div
            class="p-6 bg-gradient-to-r from-gray-100 to-gray-200 rounded-2xl shadow hover:shadow-lg transition-all duration-300 text-center">
            <p class="text-gray-600 text-sm font-medium">Total Logs</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalCount }}</p>
        </div>

        <!-- Added -->
        <div
            class="p-6 bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-2xl shadow hover:shadow-lg transition-all duration-300 text-center">
            <p class="text-yellow-700 text-sm font-medium">Added</p>
            <p class="text-3xl font-bold text-yellow-800 mt-2">{{ $addCount }}</p>
        </div>

        <!-- Edited -->
        <div
            class="p-6 bg-gradient-to-r from-blue-100 to-blue-200 rounded-2xl shadow hover:shadow-lg transition-all duration-300 text-center">
            <p class="text-blue-700 text-sm font-medium">Edited</p>
            <p class="text-3xl font-bold text-blue-800 mt-2">{{ $editCount }}</p>
        </div>

        <!-- Deleted -->
        <div
            class="p-6 bg-gradient-to-r from-red-100 to-red-200 rounded-2xl shadow hover:shadow-lg transition-all duration-300 text-center">
            <p class="text-red-700 text-sm font-medium">Deleted</p>
            <p class="text-3xl font-bold text-red-800 mt-2">{{ $deleteCount }}</p>
        </div>
    </div>


    <!-- Search + Filters -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <!-- Search Form -->
        <form class="w-full md:max-w-md flex" action="{{ route('admin.logs-responder', ['status' => $status]) }}" method="GET">
            <div class="relative w-full">
                <input type="search" id="search-responders"
                    class="block w-full p-3 ps-10 text-sm font-[Poppins] text-gray-800 border border-gray-300 rounded-xl bg-white shadow-sm 
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="🔍 Search responders..." name="search" value="{{ request('search') }}" />
                <input type="hidden" name="agency" value="{{ $selectedAgency }}">
                <button type="submit"
                    class="absolute end-2.5 top-1/2 -translate-y-1/2 
                           bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium px-4 py-2 transition">
                    Search
                </button>
            </div>
        </form>

        <!-- Agency Filter -->
        <form method="GET"
            action="{{ route('admin.logs-responder', ['status' => $status, 'agency' => $selectedAgency ?: null]) }}"
            class="w-full md:w-auto">
            <select name="agency" onchange="this.form.submit()"
                class="block w-auto p-3 text-sm font-[Poppins] text-gray-800 border border-gray-300 rounded-xl bg-white shadow-sm 
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">🏢 Select Agency</option>
                @foreach ($agencies as $agency)
                <option value="{{ $agency->id }}" {{ $selectedAgency == $agency->id ? 'selected' : '' }}>
                    {{ $agency->agencyNames }}
                </option>
                @endforeach
            </select>
            <input type="hidden" name="search" value="{{ request('search') }}">
        </form>
    </div>

    @php
    $currentStatus = $status ?? 'All';
    @endphp

    <!-- Status Filter Buttons -->
    <div class="flex flex-wrap justify-start gap-3 text-sm font-[Poppins] my-5">
        @php
        $statuses = [
        'All' => 'bg-gray-800 text-white',
        'Add Responder' => 'bg-yellow-500 text-white',
        'Update Responder' => 'bg-red-500 text-white',
        'Delete Responder' => 'bg-green-500 text-white',
        ];
        @endphp

        @foreach ($statuses as $statusKey => $activeClass)
        <a href="{{ route('admin.logs-responder', ['status' => $statusKey, 'agency' => $selectedAgency ?: null, 'search' => request('search')]) }}"
            class="px-5 py-2 rounded-full border text-sm shadow-sm transition
                       {{ $currentStatus === $statusKey ? $activeClass : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">
            {{ $statusKey }}
        </a>
        @endforeach
    </div>

    <!-- Logs Table -->
    <div class="overflow-x-auto shadow-lg rounded-xl border border-gray-200 bg-white">
        <table class="w-full text-sm font-[Poppins] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-100 to-blue-200 text-gray-700 uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Interaction Type</th>
                    <th class="px-6 py-3 text-left">Responder</th>
                    <th class="px-6 py-3 text-left">Created At</th>
                    <th class="px-6 py-3 text-left">Updated At</th>
                    <th class="px-6 py-3 text-left">Deleted At</th>
                    <th class="px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                <tr class="bg-white border-b hover:bg-blue-50 transition">
                    <td class="px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3 font-medium">{{ $log->interaction_type }}</td>
                    <td class="px-6 py-3">{{ $log->user->firstname }} {{ $log->user->lastname }}</td>
                    <td class="px-6 py-3">{{ $log->created_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-6 py-3">{{ $log->updated_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-6 py-3">{{ $log->deleted_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.logs-track', ['user' => $log->user->id, 'id' => $log->id]) }}"
                            class="inline-block px-4 py-2 text-sm font-medium rounded-lg 
          bg-blue-600 text-white shadow-md transition-all duration-200
          hover:bg-blue-700 hover:shadow-lg active:bg-blue-800">
                            Track
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No responders found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $logs->appends(request()->query())->links() }}
    </div>

    <x-partials.stack-js />
</x-layout.layout>