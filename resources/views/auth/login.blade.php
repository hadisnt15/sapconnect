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
                            <i class="ri-login-circle-fill"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Login Form -->
        <section class="rounded-lg">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
                <div class="w-full rounded-lg shadow bg-white border border-gray-200 sm:max-w-md">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight md:text-2xl text-gray-700">
                            Masuk
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="{{ route('login') }}" method="post">
                            @csrf
                            <div>
                                <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Nama Pengguna</label>
                                <input type="text" name="username" id="username"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200 focus:border-indigo-300"
                                    placeholder="Nama Pengguna" required autocomplete="off">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Kata Sandi</label>
                                <input type="password" name="password" id="password"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200 focus:border-indigo-300"
                                    placeholder="••••••••" required autocomplete="off">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit"
                                class="w-full mt-3 bg-red-800 hover:bg-red-600 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Masuk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layout>
