<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h6 class="text-[16px] sm:text-[18px] font-[Poppins] font-semibold text-gray-800 mb-2 sm:mb-0">
            Submitted Incident Reports
        </h6>
        <a href="{{ route('admin.add-incident-reports') }}"
            class="text-white bg-blue-800 py-2 px-4 rounded-sm hover:bg-blue-600 font-[Poppins] text-[14px]">
            Add Reports
        </a>
    </div>


    <!-- Search + Filters -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 my-6 font-[Poppins]">
        <!-- Search -->
        <form class="w-full md:max-w-md flex" action="" method="GET">
            <div class="relative w-full">
                <input type="search" id="search-reports"
                    class="block w-full p-3 ps-10 text-[12px] sm:text-[13px] text-gray-800 border border-gray-300 rounded-[10px] bg-white shadow-sm 
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="Search reports..." name="search" value="{{ request('search') }}" />
                <button type="submit"
                    class="absolute end-2.5 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-[10px] text-[12px] sm:text-[13px] font-medium px-4 py-2 transition">
                    Search
                </button>
            </div>
        </form>

        <!-- Agency Filter -->
        <form class="w-full md:w-auto">
            <select
                onchange="
                if (this.value) {
                    window.location.href = '/admin/logs/reports/{{ $status }}/' + this.value;
                } else {
                    window.location.href = '/admin/logs/reports/All';
                }"
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

    <!-- Status Buttons -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
        <div class="flex flex-wrap gap-3 text-[12px] sm:text-[13px] font-[Poppins]">
            <a href="/admin/logs/reports/All/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'All' ? 'bg-gray-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">All</a>
            <a href="/admin/logs/reports/Pending/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Pending' ? 'bg-yellow-500 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Pending</a>
            <a href="/admin/logs/reports/Ongoing/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Ongoing' ? 'bg-blue-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Ongoing</a>
            <a href="/admin/logs/reports/Resolved/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Resolved' ? 'bg-green-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Resolved</a>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="overflow-x-auto shadow-lg rounded-[10px] border border-gray-200 bg-white font-[Poppins]">
        <table class="min-w-full text-[12px] sm:text-[13px] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white uppercase">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left">No</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Category</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Type</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Barangay</th>
                    <th class="px-4 sm:px-6 py-3 text-left">City</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Reported By</th>
                    <th class="px-4 sm:px-6 py-3 text-left">From Agency</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Status</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($reports as $report)
                <tr class="hover:bg-blue-50 transition duration-200">
                    <td class="px-4 sm:px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $report->incident_category }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $report->incident_type }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $report->barangay_name }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $report->city_name }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $report->reported_by ?? 'N/A' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $report->from_agency ?? 'N/A' }}</td>
                    <td class="px-4 sm:px-6 py-3 font-semibold">
                        @php
                        $statusColor = match($report->report_status) {
                        'Pending' => 'text-yellow-600',
                        'Ongoing' => 'text-blue-600',
                        'Resolved' => 'text-green-600',
                        default => 'text-gray-700'
                        };
                        @endphp
                        <span class="{{ $statusColor }}">{{ $report->report_status }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-3">
                        <a href="#"
                            class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-blue-600 text-white shadow-sm hover:bg-blue-700 hover:shadow-md transition-all duration-200">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-500 text-[12px]">
                        No submitted reports found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        {{ $reports->links() }}
    </div>

    <hr>

    <h6>Agency Incident Report Actions</h6>


    <x-partials.stack-js />
</x-layout.layout>