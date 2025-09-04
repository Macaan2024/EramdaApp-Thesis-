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
        action="{{ route('submit-barangay.admin') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('POST')

        <h4 class="my-5 text-center font-[Poppins] text-[14px] font-medium">Add Barangay</h4>

        <!--  Baranay Names -->
        <div class="mb-5">
            <label
                for="barangayNames"
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Barangay Name</label>
            <input
                type="text"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                name="barangayNames"
                placeholder="Mahayahay"
                required />
        </div>
        <!-- Barangay Municipals -->
        <div class="mb-5">
            <label
                for="municipals"
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Municipals</label>
            <input
                type="text"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                name="municipals"
                placeholder="Iligan City"

                required />
        </div>
        <!-- Barangay Longitude -->
        <div class="mb-5">
            <label
                for="longitude"
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Longitude</label>
            <input
                type="text"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                name="longitude"
                required />
        </div>
        <!-- Barangay Latitude -->
        <div class="mb-5">
            <label
                for="latitude"
                class="block mb-2 font-[Poppins] text-[12px] text-gray-900 dark:text-white">Latitude</label>
            <input
                type="text"
                class="font-[Poppins] text-[12px] shadow-xs bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                name="latitude"
                required />
        </div>
        <button
            type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-[Poppins] rounded-lg text-[12px] font-semibold px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Submit
        </button>
    </form>
    <x-partials.stack-js />
</x-layout.layout>