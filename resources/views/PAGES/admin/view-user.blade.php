<x-layout.layout>

    <x-partials.toast-messages />

    <div class="max-w-4xl mx-auto bg-gray-200 dark:bg-gray-800 rounded-2xl shadow-lg p-6 sm:p-10">
        <!-- Title -->
        <h4 class="mb-6 text-center font-[Poppins] text-xl sm:text-2xl font-semibold text-gray-800 dark:text-gray-200">
            User Profile
        </h4>

        <!-- Profile Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-8">
            <!-- Profile Picture -->
            <div class="flex justify-center mb-6 sm:mb-0">
                <img src="{{ asset('storage/' . $user->photo) }}"
                    alt="Profile Photo"
                    class="w-28 h-28 sm:w-36 sm:h-36 rounded-full object-cover shadow-md border-4 border-gray-200 dark:border-gray-700">
            </div>

            <!-- User Basic Info -->
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm sm:text-[13px] font-[Poppins]">
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Lastname</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $user->lastname }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Firstname</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $user->firstname }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Email</p>
                    <p class="font-semibold text-gray-800 dark:text-white break-words">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Contact Number</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $user->contact_number }}</p>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="my-6 border-t border-gray-200 dark:border-gray-700"></div>

        <!-- More Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm sm:text-[13px] font-[Poppins]">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Agency</p>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $user->agency?->agencyTypes ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Role</p>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $user->user_type }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Position</p>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $user->position }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Gender</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $user->gender === 'm' ? 'Male' : 'Female' }}
                </p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Account Status</p>
                <p class="font-semibold {{ $user->account_status === 'Approved' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $user->account_status }}
                </p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Availability</p>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $user->availability_status ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-center gap-4 mt-8 flex-wrap">
            <a href="{{ route('admin.edit-user', $user->id) }}"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md text-sm font-[Poppins]">
                Edit
            </a>
            <a href="{{ route('admin.user') }}"
                class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow-md text-sm font-[Poppins]">
                Back
            </a>
        </div>
    </div>
    <x-partials.stack-js />
</x-layout.layout>