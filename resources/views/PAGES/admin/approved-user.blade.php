<x-layout.layout>

    <x-partials.toast-messages />

    <h6 class="font-medium font-[Poppins] text-[14px] mb-3">User Management</h6>
    <div class="flex flex-row justify-between items-center">
        <!-- Search Form -->
        <form class="max-w-md w-full" action="{{ route('admin.search-approved-user') }}" method="GET">
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
                    placeholder="Search Users" name="search" value="{{ request('search') }}" required />

                <!-- Search Button -->
                <button type="submit"
                    class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 
               bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
               focus:ring-blue-300 rounded-lg text-[12px] font-[Poppins] px-4 py-2">
                    Search
                </button>
            </div>
        </form>
        <a href="{{ route('admin.add-user') }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-[Poppins] rounded-lg text-[12px] px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add User</a>
    </div>
    <div class="my-5 flex flex-row items-center justify-start gap-2">
        <a type="button" class="hover:bg-blue-800 hover:text-white focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{ route('admin.user') }}">All</a>
        <a type="button" class="hover:bg-blue-800 hover:text-white focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{ route('admin.pending-users') }}">Pending</a>
        <a type="button" class="text-white bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{ route('admin.approved-users') }}">Approved</a>
        <a type="button" class="hover:bg-blue-800 hover:text-white focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{ route('admin.declined-users') }}">Declined</a>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400 font-[Poppins] text-[12px]">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        NO
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Profile
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Agencies
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Roles
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
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
                @forelse ($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 text-[12px] font-[Poppins] text-black">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}"
                            alt="User Photo"
                            class="w-10 h-10 rounded-full object-cover">
                        @else
                        <span class="text-gray-400">No Photo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $user->agency->agencyTypes }}</td>
                    <td class="px-6 py-4">{{ $user->user_type }}</td>
                    <td class="px-6 py-4">{{ $user->firstname }} {{ $user->lastname }}</td>
                    <td class="px-6 py-4">
                        @if ($user->account_status === 'Approved')
                        <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                            {{ $user->account_status }}
                        </span>

                        @elseif ($user->account_status === 'Declined')
                        <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                            {{ $user->account_status }}
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs font-semibold text-orange-700 bg-orange-100 rounded-full">
                            {{ $user->account_status }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-[12px] font-[Poppins]">
                        @if ($user->account_status === 'Approved')
                        <div class="flex flex-row gap-1 items-center">
                            <a type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-[Poppins] rounded-lg text-[12px] px-4 py-2 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                href="{{ route('admin.view-user', $user->id) }}">
                                View
                            </a>

                            <a type="button"
                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg px-4 py-2 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                href="{{ route('admin.edit-user', $user->id) }}">
                                Edit
                            </a>

                            <form action="#" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg px-4 py-2 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                    Delete
                                </button>
                            </form>
                        </div>
                        @endif
                        @if ($user->account_status === 'Pending')
                        <div class="flex flex-row items-centers justify-start">
                            <form action="{{ route('admin.user-approve', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg px-4 py-2 me-2 mb-2">
                                    Approve
                                </button>
                            </form>

                            <form action="{{ route('admin.user-decline', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg px-4 py-2 me-2 mb-2">
                                    Decline
                                </button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 p-4">
                        🚫 No users found.
                    </td>
                </tr>

                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-10 flex justify-center">
        {{ $users->appends(request()->query())->links('vendor.pagination.tailwind') }}
    </div>
    <x-partials.stack-js />
</x-layout.layout>