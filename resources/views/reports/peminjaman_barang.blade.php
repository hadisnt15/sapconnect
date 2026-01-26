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
            <a href="{{ route('report.refresh.peminjaman-barang') }}"
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
            <div class="p-4 border border-gray-200 mt-4 rounded-lg bg-white">
                <h5 class="text-gray-800 font-bold mb-4">
                    Rekap Data Peminjaman Barang per Tanggal {{ $date }}
                </h5>

                {{-- Grouping per TYPE --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    @forelse ($data as $tipe => $rows)
                        <div class="border rounded-lg bg-white shadow-sm overflow-hidden">
                            
                            {{-- Header Tipe --}}
                            <div class="px-4 py-2 bg-gray-100 font-bold text-gray-700 text-sm">
                                {{ $tipe }}
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50 border-b">
                                        <tr>
                                            <th class="px-3 py-2 text-left">Barang</th>
                                            <th class="px-3 py-2 text-right">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rows as $row)
                                            <tr class="border-b last:border-0 hover:bg-gray-50">
                                                <td class="px-3 py-2">
                                                    <div class="font-semibold">{{ $row->FRGNNAME }}</div>
                                                    <div class="text-xs text-gray-500">{{ $row->ORIGINCODE }}</div>
                                                </td>
                                                <td class="px-3 py-2 text-right font-medium">
                                                    {{ number_format($row->QTY) }} {{ $row->UOM }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center text-gray-500 py-10 border border-dashed rounded-lg bg-gray-50">
                                Tidak ada data peminjaman barang untuk cutoff per tanggal ini.
                            </div>
                        </div>
                    @endforelse

                </div>
            </div>
        @endif

    </div>
</x-layout>
