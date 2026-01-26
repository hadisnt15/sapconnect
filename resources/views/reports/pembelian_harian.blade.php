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
            <form method="get" action="{{ route('report.pembelian-harian') }}" 
                class="flex flex-col md:flex-row items-stretch md:items-center gap-2 w-full md:w-auto">
                @csrf
                <div class="flex flex-col md:flex-row md:items-center gap-2 w-full md:w-auto">
                    <label for="date" class="text-xs font-medium text-gray-600">Pilih Tanggal:</label>
                    <input 
                        type="date" 
                        id="date" 
                        name="date" 
                        value="{{ request('date', now()->format('Y-m-d')) }}" onchange="this.form.submit()"
                        class="border rounded-lg p-2 text-xs font-medium text-gray-700 border-gray-300 focus:ring focus:ring-red-200 w-full md:w-auto"
                    >
                </div>
            </form>
            <!-- 🔴 Sinkronisasi SAP -->
            <a href="{{ route('report.refresh.pembelian-harian') }}"
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
            <div class="mb-4">
                <h5 class="text-gray-800 font-bold ms-4 mb-2">
                    Rekap Data Setoran dan Outstanding Pembelian per Tanggal {{$date}}
                </h5>
            </div>

            {{-- Grouping per TYPE2 --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                @forelse ($data as $tipe => $segments)

                    <div class="mb-6 border rounded-lg bg-white shadow-sm">
                        <!-- Header TIPE -->
                        <div class="px-4 py-2 bg-gray-100 font-bold text-gray-700 text-sm">
                            {{ $tipe }}
                        </div>

                        <div class="overflow-y-auto max-h-[30rem] relative z-10">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2">Segment dan Periode</th>
                                        <th class="px-3 py-2 text-right">KL</th>
                                        <th class="px-3 py-2 text-right">Per Satuan</th>
                                    </tr>
                                </thead>
                                @foreach ($segments as $segment => $dataSeg)
                                    <tbody x-data="{ open: false }">
                                        <tr class="border-t cursor-pointer" @click="open = !open">
                                            <td class="px-3 py-2">
                                                <span class="font-semibold">{{ $segment }}</span> <br>
                                                <span class="text-xs">{{ $dataSeg['ket_periode'] }}</span>
                                            </td>
                                            <td class="px-3 py-2 text-right">
                                                {{ number_format($dataSeg['total_kl'], 2) }}
                                            </td>
                                            <td class="px-3 py-2 text-right">
                                                {{ $dataSeg['ket_uom'] }}
                                            </td>
                                        </tr>
                                        {{-- DETAIL --}}
                                        <template x-if="open">
                                            <tr>
                                                <td colspan="3" class="p-0">
                                                    <table class="w-full text-xs bg-white">
                                                        @foreach ($dataSeg['items'] as $item)
                                                            <tr class="border-t">
                                                                <td class="px-6 py-2 text-gray-700">
                                                                    • {{ $item->FRGNNAME }}
                                                                </td>
                                                                <td class="px-3 py-2 text-right">
                                                                    {{ number_format($item->QTY, 2) }}
                                                                </td>
                                                                <td class="px-3 py-2">
                                                                    {{ $item->UOMCODE }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center text-gray-500 py-10 border border-dashed rounded-lg bg-gray-50">
                            Tidak ada data pembelian untuk cutoff per tanggal ini.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        @endif
    </div>
</x-layout>
