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
        
         @can('dashboard.refresh')
            <!-- Filter Bulan -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-end mb-4 gap-2">
                
                <!-- 🔴 Sinkronisasi SAP -->
                <a href="{{ route('report.refresh.jadwal-isi-ibc') }}"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                </a>
            </div>
        @endcan
        <div class="text-sm font-bold text-gray-500 mb-2">
            @if ($lastSync)
                Terakhir Disinkronkan: 
                {{ \Carbon\Carbon::parse($lastSync->last_sync)->timezone('Asia/Makassar')->format('d-m-Y H:i:s') }} WITA 
                ({{ $lastSync->desc }})
            @else
                Belum pernah disinkronkan
            @endif
        </div> 
        
        @if(in_array(auth()->user()->role, ['developer', 'supervisor', 'manager']))
        <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div>
                <h5 class="text-gray-800 font-bold ms-4 mb-4">
                    Jadwal Pengisian IBC
                </h5>
            </div>
            <div class="grid grid-cols-2 gap-2">
                @if ($data->count() > 0)
                    @foreach($data as $fillingDate => $items)
                        <div x-data="{ open: false }" class="mb-2 border rounded-lg shadow bg-white">
                                <!-- Header Gudang -->
                            <div @click="open = !open" class="bg-gray-100 rounded-t-lg border-b px-4 py-2 flex justify-between items-center cursor-pointer">
                                <span class="font-bold text-red-800 text-sm">
                                    {{ $fillingDate }}
                                </span>
                                <!-- Icon -->
                                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>

                                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                            <div x-show="open" x-collapse>
                                <!-- desktop -->
                                <div class="hidden md:block px-4 pb-4 mt-4 overflow-y-auto max-h-80 relative z-10">
                                    <table class="w-full text-xs border border-gray-300">

                                        <thead class="bg-gray-200 text-gray-700 text-center sticky top-0 z-20">
                                            <tr>
                                                <th class="border px-2 py-1">No</th>
                                                <th class="border px-2 py-1">Kode Barang</th>
                                                <th class="border px-2 py-1">Nama Barang</th>
                                                <th class="border px-2 py-1">Satuan</th>
                                                <th class="border px-2 py-1">Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            @foreach($items as $item)
                                            <!-- BARIS JUDUL ITEM -->
                                            <tr class="bg-white">
                                                <td class="border px-2 py-1 font-semibold bg-white">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="border px-2 py-1 font-semibold bg-white">
                                                    {{ $item->ORIGINCODE }} 
                                                </td>
                                                <td class="border px-2 py-1 font-semibold bg-white">
                                                    {{ $item->FRGNNAME }}
                                                </td>
                                                <td class="border px-2 py-1 font-semibold bg-white">
                                                    {{ $item->UOM }}
                                                </td>
                                                <td class="border px-2 py-1 font-semibold bg-white">
                                                    {{ number_format($item->QTY,0) }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-center py-4">Tidak ada data ditemukan</p>
                @endif

            </div>
        </div>
        @endif
    </div>
</x-layout>
