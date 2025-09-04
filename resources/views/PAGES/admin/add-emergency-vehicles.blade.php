<x-layout.layout>

    <x-partials.toast-messages />
    

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 text-[12px] font-[Poppins] px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form
        class="max-w-sm mx-auto"
        action="{{ ('/submit-user') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <h4 class="my-5 text-center font-[Poppins] text-[14px] font-medium">Add Emergency Vehicles</h4>
        <!-- Selections of Agencies -->
        <div class="mb-5">
            <label
                for="agencies"
                class="block mb-2 text-[12px] font-[Poppins] text-gray-900 dark:text-white">Select Agencies</label>
            <select
                class="bg-gray-50 border border-gray-300 text-gray-900 text-[12px] rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 font-[Poppins]"
                name="agencies">
                <option selected>Choose Agencies</option>
                <option value="BFP">Bureau of Fire Protection (BFP)</option>
                <option value="BDRRMC">Barangay Disaster Risk Reduction and Management Committe (BDRRMC) </option>
                <option value="Hospital">Hospitals</option>
                <option value="CDRRMO">City Disaster Risk Reduction and Management Office</option>
            </select>
        </div>
        <!-- Selections of Roles -->
        <div class="mb-5">
            <label for="user_type" class="font-[Poppins] text-[12px] block mb-2 text-gray-900 dark:text-white">Select Roles</label>
            <select
                class="font-[Poppins] text-[12px] bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="user_type">
                <option selected>Choose Roles</option>
                <option value="Operation Officer">Operation Officer</option>
                <option value="Nurse Chief">Nurse Chief</option>
            </select>
        </div>
        <!-- Email -->
        <div class="mb-5">
            <label
                for="email"
                class="font-[Poppins] text-[12px] block mb-2 text-gray-900 dark:text-white">Email</label>
            <input
                type="email"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                placeholder="name@flowbite.com"
                name="email"
                required />
        </div>
        <!-- password -->
        <div class="mb-5">
            <label
                for="password"
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Password</label>
            <input
                type="password"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                placeholder="Enter Password"
                name="password"
                required />
        </div>
        <!-- Confirm Password -->
        <div class="mb-5">
            <label for="password_confirmation" class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Confirm password</label>
            <input
                type="password"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                name="password_confirmation"
                placeholder="Confirm Password"
                required />
        </div>
        <!-- user lastname -->
        <div class="mb-5">
            <label
                for="lastname"
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Lastname</label>
            <input
                type="text"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                name="lastname"
                placeholder="Macaan"
                required />
        </div>
        <!-- user firstname -->
        <div class="mb-5">
            <label
                for="firstname"
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Firstname</label>
            <input
                type="text"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                name="firstname"
                placeholder="Casan"
                required />
        </div>
        <!-- user gender -->
        <div class="mb-5">
            <div class="flex">
                <div class="flex items-center me-4">
                    <input
                        type="radio"
                        value="m"
                        name="gender"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label
                        for="inline-radio"
                        class="ms-2 font-[Poppins] text-[12px] text-gray-900 dark:text-gray-300">Male</label>
                </div>
                <div class="flex items-center me-4">
                    <input
                        type="radio"
                        value="f"
                        name="gender"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label
                        for="inline-2-radio"
                        class="ms-2 font-[Poppins] text-[12px] text-gray-900 dark:text-gray-300">Female</label>
                </div>
            </div>
        </div>
        <!-- user position information -->
        <div class="mb-5">
            <label
                for="position"
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Position</label>
            <input
                type="text"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                name="position"
                required />
        </div>
        <!-- user contact number -->
        <div class="mb-5">
            <label
                for="contact_number"
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Contact Number</label>
            <input
                type="text"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                name="contact_number"
                placeholder="+63923456789"
                required />
        </div>
        <!-- upload picture -->
        <div class="mb-5">
            <label
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white"
                for="photo">Upload file</label>
            <input
                class="block w-full text-[12px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                type="file"
                name="photo">
        </div>
        <button
            type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-[Poppins] rounded-lg text-[12px] font-semibold px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Register Account</button>
        <div class="my-5 text-center">
            <a href="{{ url('/')}}" class="font-[Poppins] text-[12px] font-semibold text-indigo-600">Already have an account?</a>
        </div>
    </form>
    <x-partials.stack-js />
</x-layout.layout>