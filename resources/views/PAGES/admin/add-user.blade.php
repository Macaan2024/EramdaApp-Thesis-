<x-layout.layout>
    <form class="max-w-3xl mx-auto bg-gray-100 shadow-lg rounded-2xl p-8 space-y-6"
        action="{{ route('admin.submit-user') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <input type="hidden" name="account_status" value="Pending">
        <input type="hidden" name="availability_status" value="N/A">

        <!-- Heading -->
        <div class="text-center">
            <h2 class="text-lg font-semibold text-gray-800 font-[Poppins]">Add User</h2>
            <p class="text-gray-500 text-[12px] font-[Poppins]">Fill in the details to register a new user</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 text-[12px] font-[Poppins] px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Grid fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Agency -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Select Agency</label>
                <select name="agency_id"
                    class="w-full rounded-lg border @error('agency_id') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500">
                    <option selected disabled>Choose Agency</option>
                    @forelse($agencies as $agency)
                        <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>
                            {{ $agency->agencyNames }}
                        </option>
                    @empty
                        <option disabled>No agencies available</option>
                    @endforelse
                </select>
                @error('agency_id')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Select Role</label>
                <select name="user_type"
                    class="w-full rounded-lg border @error('user_type') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500">
                    <option selected disabled>Choose Role</option>
                    <option value="Operation Officer" {{ old('user_type') == 'Operation Officer' ? 'selected' : '' }}>
                        Operation Officer
                    </option>
                    <option value="Nurse Chief" {{ old('user_type') == 'Nurse Chief' ? 'selected' : '' }}>
                        Nurse Chief
                    </option>
                </select>
                @error('user_type')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full rounded-lg border @error('email') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500"
                    placeholder="name@domain.com" required>
                @error('email')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Password</label>
                <input type="password" name="password"
                    class="w-full rounded-lg border @error('password') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter Password" required>
                @error('password')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full rounded-lg border border-gray-300
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Confirm Password" required>
            </div>

            <!-- Lastname -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Lastname</label>
                <input type="text" name="lastname" value="{{ old('lastname') }}"
                    class="w-full rounded-lg border @error('lastname') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Macaan" required>
                @error('lastname')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Firstname -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Firstname</label>
                <input type="text" name="firstname" value="{{ old('firstname') }}"
                    class="w-full rounded-lg border @error('firstname') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Casan" required>
                @error('firstname')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div class="md:col-span-2">
                <span class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Gender</span>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 text-[12px] font-[Poppins]">
                        <input type="radio" value="m" name="gender" {{ old('gender') === 'm' ? 'checked' : '' }}
                            class="text-blue-600 focus:ring-blue-500">
                        Male
                    </label>
                    <label class="flex items-center gap-2 text-[12px] font-[Poppins]">
                        <input type="radio" value="f" name="gender" {{ old('gender') === 'f' ? 'checked' : '' }}
                            class="text-blue-600 focus:ring-blue-500">
                        Female
                    </label>
                </div>
                @error('gender')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Position</label>
                <input type="text" name="position" value="{{ old('position') }}"
                    class="w-full rounded-lg border @error('position') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('position')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                    class="w-full rounded-lg border @error('contact_number') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500"
                    placeholder="+63923456789" required>
                @error('contact_number')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload photo -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Upload Photo</label>
                <input type="file" name="photo"
                    class="w-full border @error('photo') border-red-500 @else border-gray-300 @enderror
                    rounded-lg cursor-pointer text-[12px] font-[Poppins]">
                @error('photo')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror

                <div class="mt-3 flex justify-center">
                    <img id="photoPreview" src="" alt="Preview will appear here"
                        class="hidden w-24 h-24 object-cover rounded-full border-2 border-blue-400 shadow-md">
                </div>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full mt-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300
               font-medium rounded-lg px-5 py-2.5 transition text-[12px] font-[Poppins]">
            Register Account
        </button>

        <div class="my-5 text-center">
            <a href="{{ url('/') }}" class="font-[Poppins] text-[12px] font-semibold text-indigo-600">
                Already have an account?
            </a>
        </div>
    </form>
</x-layout.layout>
