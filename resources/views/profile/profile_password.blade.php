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
            <form action="{{ route('password.update') }}" method="post">
                @csrf

                <!-- Password Lama -->
                <div class="mb-4">
                    <label for="current_password" class="block mb-2 text-sm font-medium text-gray-700">Kata Sandi Lama</label>
                    <input type="password" name="current_password" id="current_password" placeholder="Kata Sandi Lama"
                        class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring focus:ring-indigo-200 w-full p-2.5" required>
                    @error('current_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Baru -->
                <div class="mb-4">
                    <label for="new_password" class="block mb-2 text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                    <input type="password" name="new_password" id="new_password" placeholder="Kata Sandi Baru"
                        class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring focus:ring-indigo-200 w-full p-2.5" required>
                    @error('new_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="mb-4">
                    <label for="new_password_confirmation" class="block mb-2 text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Konfirmasi Kata Sandi Baru"
                        class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring focus:ring-indigo-200 w-full p-2.5" required>
                    @error('new_password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="mt-3 w-full bg-red-800 hover:bg-red-600 font-medium text-white rounded-lg text-sm px-5 py-2.5 text-center">
                    <i class="ri-lock-password-fill"></i> Perbarui Kata Sandi
                </button>
            </form>
        </div>
    </div>
</x-layout>
