<!-- <aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full 
         bg-blue-900 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800"
    aria-label="Sidebar">

    @php
    $user = Auth::user()->user_type;

    $agency = $user->agency->agencyTypes;
    @endphp
    <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-900">

        <ul class="space-y-2 font-medium">

            <li>
                <a href="{{ url('/' . $usertype . '/dashboard') }}"
                    class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]">
                    <span class="material-symbols-outlined mr-2">dashboard</span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('/' . $usertype . '/usermanagement') }}" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">group</span>User Management</a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">map_pin_review
                    </span>Pin-Point Agencies
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">groups
                    </span>Manage Personnel Responders
                </a>
            </li>
            <li>
                <a href="{{ route('manage-emergency-vehicles.admin') }}" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">fire_truck
                    </span>Manage Emergency Vehicles
                </a>
            </li>
            <li>
                <a href="{{ route(('manage-incident-types.admin')) }}" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">
                        apartment
                    </span>Manage Incident Reports
                </a>
            </li>
            <li>
                <a href="{{ route('manage-agencies.admin') }}" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">
                        apartment
                    </span>Manage Agencies
                </a>
            </li>
            <li>
                <a href="{{ url('/' . $usertype . '/manage-barangay') }}" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">
                        add_location
                    </span>Manage Barangay
                </a>
            </li>
            <li>
                <a href="{{ route('manage-incident-types.admin') }}" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">inventory
                    </span>Manage Incident Types
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">inventory
                    </span>Manage Logs
                </a>
            </li>
        </ul>
    </div>
</aside> -->