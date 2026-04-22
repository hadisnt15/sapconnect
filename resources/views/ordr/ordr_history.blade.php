<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('order') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-800">
                        <i class="ri-bill-fill"></i> Daftar Pesanan
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-file-edit-fill text-red-800"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
        
</x-layout>

