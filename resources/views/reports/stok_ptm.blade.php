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

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
            <!-- 🔍 Form Pencarian (Kiri) -->
            <form action="{{ route('report.stok-pertamina') }}" method="get" class="flex items-center gap-2 w-full md:w-auto">
                <label for="search" class="sr-only">Cari Barang</label>
                <div class="relative w-full md:w-96">
                    <input type="text" id="search" name="search"
                        value="{{ request('search') }}"
                        class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-50 border-gray-300 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200"
                        placeholder="Cari Gudang/Barang/Satuan..." />
                    <button type="submit"
                        class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                        <i class="ri-search-eye-fill"></i>
                    </button>
                </div>
            </form>

            <!-- 🔧 Form Filter & Sinkronisasi (Kanan) -->
            <div class="flex flex-col sm:flex-col md:flex-row md:items-center md:justify-end gap-3 w-full md:w-auto">
                @can('dashboard.refresh')
                <!-- 🔴 Sinkronisasi SAP -->
                <div class="flex items-center">
                    <a href="{{ route('report.refresh.stok-pertamina') }}"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                    </a>
                </div>
                @endcan
            </div>
        </div>
        
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
                    Laporan Stok Pertamina
                </h5>
            </div>
            @if ($data->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @php
                        function colorLevel($value) {
                            if ($value >= 1) return 'bg-green-200 text-green-800 font-bold';
                            if ($value >= 0.5) return 'bg-yellow-200 text-yellow-800 font-bold';
                            return 'bg-red-200 text-red-800 font-bold';
                        }
                    @endphp
                   @foreach($data as $gudang => $rows)
                    <div x-data="{ open: false }" class="mb-2 border rounded-lg shadow bg-white">
    
                        <!-- Header Gudang -->
                        <div @click="open = !open"
                            class="bg-gray-100 rounded-t-lg border-b px-4 py-2 flex justify-between items-center cursor-pointer">
                            <div>
                                <span class="font-bold text-red-800 text-sm">
                                    {{ $gudang }}
                                </span><br>
                                <span class="font-semibold text-gray-700 text-xs px-2">
                                    Total Stok: {{ number_format($rows['TSTOK'],2) }} <br>
                                </span>
                                <span class="font-semibold text-gray-700 text-xs px-2">
                                    Total Oust: {{ number_format($rows['TOPENQTYAP'],2) }} <br>
                                </span>
                                <span class="font-semibold text-gray-700 text-xs px-2">
                                    Jumlah Barang: {{ number_format($rows['JBARANG']) }} <br>
                                </span>
                                <span class="font-bold text-gray-700 text-xs px-2">
                                    Total Semua: {{ number_format($rows['TSTOKPLUSOPENQTY'],2) }} 
                                </span>
                            </div>

                            <!-- Icon -->
                            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>

                            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>

                        </div>

                        <!-- WRAPPER: tampil hanya ketika open -->
                        <div x-show="open" x-collapse>
                            <!-- desktop -->
                            <div class="hidden md:block px-4 pb-4 mt-4 overflow-y-auto max-h-80 relative z-10">
                                <table class="w-full text-xs border border-gray-300">

                                    <thead class="bg-gray-200 text-gray-700 text-center sticky top-0 z-20">
                                        <tr>
                                            <th class="border px-2 py-1 w-2/12">Stok</th>
                                            <th class="border px-2 py-1 w-2/12">Est. Habis (Bln)</th>
                                            <th class="border px-2 py-1 w-2/12">Avg. 3 Bln</th>
                                            <th class="border px-2 py-1 w-2/12">Oust</th>
                                            <th class="border px-2 py-1 w-2/12">Total (Stok+Oust)</th>
                                            <th class="border px-2 py-1 w-2/12">Est. Habis Total (Bln)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach($rows['rows'] as $row)
                                        <!-- BARIS JUDUL ITEM -->
                                        <tr class="bg-white">
                                            <td class="border px-2 py-1 font-semibold bg-white" colspan="6">
                                                {{ $loop->iteration }}.
                                                {{ $row->ORIGINCODE }} - {{ $row->FRGNNAME }}
                                                ({{ $row->SATUAN }})
                                            </td>
                                        </tr>

                                        <!-- BARIS NILAI -->
                                        <tr class="bg-white">
                                            <td class="border px-2 py-1 text-right">{{ number_format($row->STOK,2) }}</td>
                                            <td class="border px-2 py-1 text-right {{ colorLevel($row->ESTHABISSTOKBULAN) }}">{{ number_format($row->ESTHABISSTOKBULAN,2) }}</td>
                                            <td class="border px-2 py-1 text-right">{{ number_format($row->AVG3BULAN,2) }}</td>
                                            <td class="border px-2 py-1 text-right">{{ number_format($row->OPENQTYAP,2) }}</td>
                                            <td class="border px-2 py-1 text-right">{{ number_format($row->STOKPLUSOPENQTY,2) }}</td>
                                            <td class="border px-2 py-1 text-right {{ colorLevel($row->ESTHABISSTOKPLUSOPENBULAN) }}">{{ number_format($row->ESTHABISSTOKPLUSOPENBULAN,2) }}</td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- mobile -->
                            <div class="block md:hidden space-y-2">
                                @foreach($rows['rows'] as $row)
                                <div class="border rounded-md shadow-sm">
                                    <div class="font-semibold text-gray-800 text-sm mb-1 bg-gray-50 border-b">
                                        <div class="p-2">
                                            {{ $loop->iteration }}.
                                            {{ $row->ORIGINCODE }} - {{ $row->FRGNNAME }} ({{ $row->SATUAN }})
                                        </div>
                                    </div>

                                    <div class="text-xs text-gray-600 space-y-1 bg-white">
                                        <div class="px-3 py-2">
                                            <div class="flex justify-between">
                                                <span>Stok:</span>
                                                <span class="font-semibold">{{ number_format($row->STOK,2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Est. Habis (Bln):</span>
                                                <span class="font-semibold {{ colorLevel($row->ESTHABISSTOKBULAN) }}">{{ number_format($row->ESTHABISSTOKBULAN,2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Avg. 3 Bln:</span>
                                                <span class="font-semibold">{{ number_format($row->AVG3BULAN,2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Oust:</span>
                                                <span class="font-semibold">{{ number_format($row->OPENQTYAP,2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Total (Stok+Oust):</span>
                                                <span class="font-semibold">{{ number_format($row->STOKPLUSOPENQTY,2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Est Habis Total (Bln):</span>
                                                <span class="font-semibold {{ colorLevel($row->ESTHABISSTOKPLUSOPENBULAN) }}">{{ number_format($row->ESTHABISSTOKPLUSOPENBULAN,2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada data ditemukan</p>
            @endif
        </div>
        @endif
    </div>
</x-layout>
