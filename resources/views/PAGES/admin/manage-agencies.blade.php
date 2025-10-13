<x-layout.layout>

    <x-partials.toast-messages />
    <h6 class="font-medium font-[Poppins] text-[14px] mb-3">Agencies Management</h6>

    <div class="flex flex-row justify-between items-center">
        <!-- Search Form -->
        <form class="max-w-md w-full" action="#" method="GET">
            <label for="default-search" class="sr-only">Search</label>
            <div class="relative">
                <!-- Search Icon -->
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>

                <!-- Search Input -->
                <input type="search" id="default-search"
                    class="block w-full p-3 ps-10 text-[12px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
               focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search Agency" name="search" value="{{ request('search') }}" required />

                <!-- Search Button -->
                <button type="submit"
                    class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 
               bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
               focus:ring-blue-300 rounded-lg text-[12px] font-[Poppins] px-4 py-2">
                    Search
                </button>
            </div>
        </form>
        <a href="{{ route('admin.add-agency') }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-[Poppins] rounded-lg text-[12px] px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Agency</a>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400 font-[Poppins] text-[12px]">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Logo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Names
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Agency Types
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Emails
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($agencies as $agency)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 text-[12px] font-[Roboto] text-black">
                    <td class="px-6 py-4">
                        @if ($agency->logo)
                        <img
                            src="{{ asset('storage/' . $agency->logo) }}"
                            alt="Logo"
                            class="h-12 w-12 object-cover rounded-full shadow" />
                        @else
                        <span class="text-gray-500 text-sm">No Logo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $agency->agencyNames }}</td>
                    <td class="px-6 py-4">{{ $agency->agencyTypes }}</td>
                    <td class="px-6 py-4">{{ $agency->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-[12px] font-[Poppins] 
                            {{ $agency->activeStatus === 'Active' ? 'bg-green-100 text-green-700' : ($agency->activeStatus === 'Inactive' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ $agency->activeStatus }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-row gap-1 items-center">

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 p-4">
                        🚫 No Agencies Found
                    </td>
                </tr>

                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-10 flex justify-center">
        {{ $agencies->appends(request()->query())->links('vendor.pagination.tailwind') }}
    </div>
    <x-partials.stack-js />
</x-layout.layout>