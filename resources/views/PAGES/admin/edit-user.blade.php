<x-layout.layout>
    <x-partials.toast-messages />

    <form class="max-w-3xl mx-auto bg-gray-100 shadow-lg rounded-2xl p-8 space-y-6"
        action="{{ route('admin.update-user', $user->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <!-- Heading -->
        <div class="text-center">
            <h2 class="text-lg font-semibold text-gray-800 font-[Poppins]">Edit User</h2>
            <p class="text-gray-500 text-[12px] font-[Poppins]">Update the details of this user</p>
        </div>

        <!-- Grid fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Agency -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Select Agency</label>
                <select name="agency_id"
                    class="w-full rounded-lg border @error('agency_id') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500">
                    <option disabled>Choose Agencies</option>
                    @foreach($agencies as $agency)
                        <option value="{{ $agency->id }}" @selected(old('agency_id', $user->agency_id) == $agency->id)>
                            {{ $agency->agencyNames }}
                        </option>
                    @endforeach
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
                    <option disabled>Choose Role</option>
                    <option value="Operation Officer" @selected(old('user_type', $user->user_type) === 'Operation Officer')>
                        Operation Officer
                    </option>
                    <option value="Nurse Chief" @selected(old('user_type', $user->user_type) === 'Nurse Chief')>
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
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full rounded-lg border @error('email') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('email')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lastname -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Lastname</label>
                <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}"
                    class="w-full rounded-lg border @error('lastname') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('lastname')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Firstname -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Firstname</label>
                <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}"
                    class="w-full rounded-lg border @error('firstname') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('firstname')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div class="md:col-span-2">
                <span class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Gender</span>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 text-[12px] font-[Poppins]">
                        <input type="radio" value="m" name="gender"
                            {{ old('gender', $user->gender) === 'm' ? 'checked' : '' }}
                            class="text-blue-600 focus:ring-blue-500"> Male
                    </label>
                    <label class="flex items-center gap-2 text-[12px] font-[Poppins]">
                        <input type="radio" value="f" name="gender"
                            {{ old('gender', $user->gender) === 'f' ? 'checked' : '' }}
                            class="text-blue-600 focus:ring-blue-500"> Female
                    </label>
                </div>
                @error('gender')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Position</label>
                <input type="text" name="position" value="{{ old('position', $user->position) }}"
                    class="w-full rounded-lg border @error('position') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('position')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}"
                    class="w-full rounded-lg border @error('contact_number') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('contact_number')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload photo -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Upload Photo</label>
                <input type="file" name="photo" id="photoUpload"
                    class="w-full border @error('photo') border-red-500 @else border-gray-300 @enderror
                    rounded-lg cursor-pointer text-[12px] font-[Poppins]">

                <div class="mt-3 flex justify-start">
                    <img id="photoPreview"
                        src="{{ $user->photo ? asset('storage/' . $user->photo) : '' }}"
                        alt="Current Photo"
                        class="w-24 h-24 object-cover rounded-sm border-2 border-blue-400 shadow-md {{ $user->photo ? '' : 'hidden' }}">
                </div>

                @error('photo')
                    <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full mt-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300
               font-medium rounded-lg px-5 py-2.5 transition text-[12px] font-[Poppins]">
            Update User
        </button>
    </form>

    <x-partials.stack-js />
</x-layout.layout>
