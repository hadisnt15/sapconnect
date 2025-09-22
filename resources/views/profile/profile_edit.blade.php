<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-4 px-6 bg-white">
        <!-- Breadcrumb -->
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-group-2-fill"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Form -->
        <div class="max-w-md mx-auto bg-white border border-gray-200 p-6 rounded-lg shadow-sm">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Foto Profil -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Foto Profil</label>
                    <img src="{{ $profile->profile_photo ? asset('storage/'.$profile->profile_photo) : asset('profile-default.png') }}" 
                        alt="Foto Profil" class="w-24 h-24 rounded-full mb-3 object-cover border border-gray-300 shadow-sm">
                    <input type="file" name="profile_photo" accept="image/*"
                        class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring focus:ring-indigo-200">
                    @error('profile_photo')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $profile->name) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring focus:ring-indigo-200 w-full p-2.5">
                    @error('name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Pengguna -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Pengguna</label>
                    <input type="text" name="username" value="{{ old('username', $profile->username) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring focus:ring-indigo-200 w-full p-2.5">
                    @error('username')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Telepon -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring focus:ring-indigo-200 w-full p-2.5">
                    @error('phone')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring focus:ring-indigo-200 w-full p-2.5">
                    @error('email')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="mt-3 w-full bg-red-800 hover:bg-red-600 font-medium text-white rounded-lg text-sm px-5 py-2.5 text-center">
                    <i class="ri-user-settings-fill"></i> Perbarui Profil
                </button>
            </form>
        </div>
    </div>
</x-layout>
