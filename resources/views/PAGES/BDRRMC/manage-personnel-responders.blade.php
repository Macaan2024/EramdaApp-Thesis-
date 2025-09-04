<x-layout.layout>
    <x-partials.toast-messages />

    <h6 class="mb-3 text-[14px] font-[Poppins] font-medium">Personnel Responders Management</h6>

    <div class="flex justify-between items-center">
        <form class="w-full max-w-md" action="{{ route('search-user.admin') }}" method="GET">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" name="search" value="{{ request('search') }}"
                    class="block w-full p-3 ps-10 text-[12px] font-[Poppins] border rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search Personnel Responders" required />
                <button type="submit"
                    class="absolute end-2.5 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-[12px] font-[Poppins] px-4 py-2 focus:ring-4 focus:ring-blue-300">
                    Search
                </button>
            </div>
        </form>

        <a href="#"
            class="px-5 py-2.5 text-[12px] font-[Poppins] text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
            Add Personnel Responders
        </a>
    </div>

    <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs uppercase bg-blue-100 font-[Poppins] text-[12px] text-gray-700">
                <tr>
                    <th class="px-6 py-3">NO</th>
                    <th class="px-6 py-3">Agencies</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Position</th>
                    <th class="px-6 py-3">Latitude</th>
                    <th class="px-6 py-3">Longitude</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($responders as $responder)
                    <tr
                        class="bg-white border-b text-[12px] font-[Roboto] text-black hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4">
                            <div class="flex gap-1">
                                <a href="#"
                                    class="flex items-center gap-2 px-4 py-2.5 text-white bg-blue-700 rounded-lg text-[12px] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                                    <span class="material-symbols-outlined">eyeglasses_2</span>View
                                </a>
                                <a href="#"
                                    class="flex items-center gap-2 px-4 py-2.5 text-white bg-green-700 rounded-lg text-[12px] hover:bg-green-800 focus:ring-4 focus:ring-green-300">
                                    <span class="material-symbols-outlined">edit</span>Edit
                                </a>
                                <form action="#" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center gap-2 px-4 py-2.5 text-white bg-red-700 rounded-lg text-[12px] hover:bg-red-800 focus:ring-4 focus:ring-red-300">
                                        <span class="material-symbols-outlined">delete</span>Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">🚫 No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-10 flex justify-center">
        {{ $responders->appends(request()->query())->links('vendor.pagination.tailwind') }}
    </div>

    <x-partials.stack-js />
</x-layout.layout>
