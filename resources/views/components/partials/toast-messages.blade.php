<!-- Start of User Management Toast Messages -->

@if (session('success'))
<div id="toast-simple" class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-gray-500 bg-green-100 divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800" role="alert">
    <svg class="w-5 h-5 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
    </svg>
    <div class="ps-4 text-sm font-normal">{{ session('success') }}.</div>
    <!-- Loading bar -->
    <div class="absolute bottom-0 left-0 h-1 bg-blue-600 animate-toastbar"></div>
</div>
@endif

