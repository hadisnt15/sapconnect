<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>
    
    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('report') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-red-600">
                        <i class="ri-folder-6-fill"></i> Daftar Laporan
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-folder-open-fill"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
        <!-- Dashboard 2 -->
        @if(in_array(auth()->user()->role, ['developer', 'supervisor', 'manager']))
        <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Pencapaian Penjualan per Segmen periode {{ $namaPeriode }}</h5></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 ">
                @foreach($dashboard2 as $db2)
                    <article class="p-3 hover:bg-gray-50 border border-gray-200 rounded-lg shadow-sm bg-white transition">
                        <div class="mb-1 text-gray-500">
                            <span
                                class="text-sm font-semibold border border-gray-300 me-2 px-2.5 py-0.5 rounded-lg bg-gray-50 text-gray-700">
                                {{ $db2->KEYPROFITCENTER }}
                            </span>
                        </div>
                        <h1 class="text-2xl font-bold text-red-900 text-right">
                            {{ number_format($db2->VALUE) }}
                        </h1>
                    </article>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-layout>
