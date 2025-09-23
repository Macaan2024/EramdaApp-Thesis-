<x-layout.layout>

    <x-partials.toast-messages />

    <h6 class="font-medium font-[Poppins] text-[14px] mb-3">Incident Types Management</h6>
    <div class="flex flex-row justify-between items-center">
        <!-- Search Form -->
        <form class="max-w-md w-full" action="{{ route('admin.search-incident-types') }}" method="GET">
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
                    placeholder="Search Incident Types" name="search" value="{{ request('search') }}" required />

                <!-- Search Button -->
                <button type="submit"
                    class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 
               bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
               focus:ring-blue-300 rounded-lg text-[12px] font-[Poppins] px-4 py-2">
                    Search
                </button>
            </div>
        </form>
        <a href="{{ route('admin.add-incident-types') }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-[Poppins] rounded-lg text-[12px] px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Incident Types</a>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400 font-[Poppins] text-[12px]">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Incident Names
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($incident_types as $incident_type)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 text-[12px] font-[Roboto] text-black">
                    <td class="px-6 py-4">{{ $incident_type->incident_name }}</td>
                    <td class="px-6 py-4">{{ $incident_type->category }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-row gap-1 items-center">
                            <a type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-[Poppins] rounded-lg text-[12px] px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 flex flex-row justify-center items-center gap-2" href="{{ route('admin.edit-incident-types', $incident_type->id) }}"><span class="material-symbols-outlined">
                                    eyeglasses_2
                                </span>View</a>
                            <a type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg  px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 flex items-center justify-center" href="{{ route('admin.edit-incident-types', $incident_type->id) }}"><span class="material-symbols-outlined">
                                    edit
                                </span>Edit</a>
                            <form action="{{ route('admin.delete-incident-types', $incident_type->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 flex items-center">
                                    <span class="material-symbols-outlined text-[12px] font-[Poppins]">delete</span>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 p-4">
                        🚫 No Incidents found.
                    </td>
                </tr>

                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-10 flex justify-center">
        {{ $incident_types->appends(request()->query())->links('vendor.pagination.tailwind') }}
    </div>
    <x-partials.stack-js />
</x-layout.layout>