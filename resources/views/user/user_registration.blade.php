<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-4 px-6 bg-white">
        <!-- Breadcrumb -->
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('user') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-red-600">
                        <i class="ri-account-circle-2-fill me-1"></i> Daftar Pengguna
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
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
        <form class="mx-auto w-full md:w-1/2 bg-white p-6 rounded-lg border border-gray-200 shadow-sm"
              action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label for="name" class="mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="off"
                       class="bg-gray-50 border border-gray-300 placeholder-gray-400 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5"
                       placeholder="Nama Lengkap" required />
                @error('name')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label for="username" class="mb-2 text-sm font-medium text-gray-700">Nama Pengguna</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" autocomplete="off"
                       class="bg-gray-50 border border-gray-300 placeholder-gray-400 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5"
                       placeholder="Nama Pengguna" required />
                @error('username')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Telepon -->
            <div class="mb-4">
                <label for="phone" class="mb-2 text-sm font-medium text-gray-700">Telepon</label>
                <input type="number" id="phone" name="phone" value="{{ old('phone') }}" autocomplete="off"
                       class="bg-gray-50 border border-gray-300 placeholder-gray-400 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5"
                       placeholder="Telepon" required />
                @error('phone')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="mb-2 text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" autocomplete="off"
                       class="bg-gray-50 border border-gray-300 placeholder-gray-400 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5"
                       placeholder="Email" />
                @error('email')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="mb-2 text-sm font-medium text-gray-700">Posisi</label>
                <select name="role" id="role"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5">
                    <option value="">Pilih Posisi</option>
                    <option value="salesman">Penjual</option>
                    <option value="supervisor">Admin</option>
                    <option value="manager">Manajer</option>
                </select>
                @error('role')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Password hidden -->
            <input type="password" name="password" id="password" value="KKJweb#123" hidden>

            <!-- Submit -->
            <button type="submit"
                    class="w-full mt-3 bg-red-800 hover:bg-red-600 font-medium text-white rounded-lg text-sm px-5 py-2.5 text-center">
                <i class="ri-user-add-fill"></i> Daftarkan Pengguna Baru
            </button>
        </form>
    </div>
</x-layout>
