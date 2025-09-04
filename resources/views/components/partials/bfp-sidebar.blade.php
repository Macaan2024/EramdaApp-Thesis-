<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full 
         bg-blue-900 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800"
    aria-label="Sidebar">

    <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-900">

        <ul class="space-y-2 font-medium">

            <li>
                <a href="{{ url('/BFP/dashboard') }}"
                    class="flex item-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]">
                    <span class="material-symbols-outlined mr-2">dashboard</span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href=" {{ route('bfp.respondersmanagement') }}" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">groups
                    </span>Manage Personnel Responders
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">fire_truck
                    </span>Manage Emergency Vehicles
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">
                        apartment
                    </span>Manage Incident Reports
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 hover:bg-blue-50 hover:text-black font-[Poppins] text-white text-[14px]"><span class="material-symbols-outlined mr-2">inventory
                    </span>Manage Attendance
                </a>
            </li>
        </ul>
    </div>
</aside>