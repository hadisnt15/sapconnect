<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-300"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-300 py-2 px-2 bg-white">
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

        <!-- Profile Card -->
        <div class="w-full max-w-sm border border-gray-300 rounded-lg shadow-sm bg-gray-50 mx-auto">
            <div class="flex flex-col items-center pb-5 border-b border-gray-200">
                <img class="w-24 h-24 mb-3 rounded-full shadow-md mt-5 border border-gray-300 bg-white object-cover" 
                     src="{{ $profile->profile_photo ? asset('storage/'.$profile->profile_photo) : asset('profile-default.png') }}" 
                     alt="{{ $profile->name }}"/>
                <h5 class="mb-1 text-xl font-bold text-gray-800">{{ $profile->name }}</h5>
                <span class="text-sm text-red-800 font-medium capitalize">Pengguna</span>
            </div>
            <div class="divide-y divide-gray-200 text-gray-700 text-sm">
                <div class="px-4 py-3">
                    <p class="font-medium">Nama Pengguna:</p>
                    <p>{{ $profile->username }}</p>
                </div>
                <div class="px-4 py-3">
                    <p class="font-medium">Email:</p>
                    <p>{{ $profile->email }}</p>
                </div>
                <div class="px-4 py-3">
                    <p class="font-medium">Telepon:</p>
                    <p>{{ $profile->phone }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>

