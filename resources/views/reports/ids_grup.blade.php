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

        
        <!-- Filter Bulan -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
            {{-- 🔹 Form Periode Tersedia (kiri) --}}
            <form method="GET" action="{{ route('report.penjualan-industri-per-grup') }}" 
                class="flex flex-col md:flex-row items-stretch md:items-center gap-2 w-full md:w-auto">
                @csrf
                <div class="flex flex-col md:flex-row md:items-center gap-2">
                    <label for="period" class="text-xs font-medium text-gray-600">Periode Tersedia</label>
                    <select name="period" id="period" onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-xs rounded-lg text-gray-700 
                            focus:ring focus:ring-indigo-200 py-2 px-3 w-full md:w-auto">
                        @foreach($availablePeriods as $p)
                            <option value="{{ $p }}" {{ $selectedPeriod == $p ? 'selected' : '' }}>
                                {{ $p }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            @can('dashboard.refresh')
            {{-- 🔹 Form Sinkronisasi SAP (kanan) --}}
            <form method="POST" action="{{ route('report.refresh.penjualan-industri-per-grup') }}" 
                class="flex flex-col md:flex-row items-stretch md:items-center gap-2 w-full md:w-auto">
                @csrf
                <div class="flex flex-col md:flex-row md:items-center gap-2">
                    <label for="month" class="text-xs font-medium text-gray-600"></label>
                    <input 
                        type="month" 
                        id="month" 
                        name="month" 
                        value="{{ request('month', now()->format('Y-m')) }}"
                        class="border rounded-lg py-2 px-3 text-xs font-medium text-gray-700 border-gray-300 
                            focus:ring focus:ring-red-200 w-full md:w-auto"
                    >
                </div>
                <button type="submit" 
                    class="text-xs w-full md:w-auto flex-shrink-0 rounded-lg px-3 py-2 bg-red-800 
                        hover:bg-red-500 font-medium text-white flex items-center gap-1">
                    <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                </button>
            </form>
            @endcan
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
                    Penjualan Industri per Grup Periode {{ $namaPeriode }}
                </h5>
            </div>

            @if ($data->count() > 0)
                <div class="grid grid-cols-3 gap-4 mb-6">
                    @foreach($typeTotal as $type => $total)
                        <div class="border rounded-lg shadow-sm">
                            <div class="bg-gray-100 rounded-t-lg border-b px-4 py-2"><span class="font-bold text-red-800">{{ $type }}</span></div>    
                            <div class="text-2xl font-bold text-gray-700 text-right px-4 py-2">{{ number_format($total,2) }} KL</div>
                        </div>
                    @endforeach
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($data as $type => $groups)
                        @foreach($groups as $group => $rows)
                        <div class="mb-6 border rounded-lg shadow-sm bg-white">
                            <div class="bg-gray-100 rounded-t-lg border-b px-4 py-2">
                                <span class="font-bold text-red-800">{{ $type }} {{ $group }}</span>
                            </div>
                            <div class="p-4 overflow-y-auto max-h-80">
                                <table class="w-full text-xs border border-gray-300">
                                    <thead class="bg-gray-200 text-gray-700 text-center">
                                        <tr>
                                            <th class="border px-2 py-1 w-2/6">KODE PELANGGAN</th>
                                            <th class="border px-2 py-1 w-3/6">NAMA PELANGGAN</th>
                                            <th class="border px-2 py-1 w-1/6">CAPAIAN KL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rows['rows'] as $row)
                                        <tr>
                                            <td class="border px-2 py-1">{{ $row->CARDCODE }}</td>
                                            <td class="border px-2 py-1">{{ $row->CARDNAME }}</td>
                                            <td class="border px-2 py-1 text-right">{{ number_format($row->KILOLITER,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700">
                                            <th colspan="2" class="border px-2 py-1 text-left">TOTAL {{ $type }} {{ $group }}</th>
                                            <th class="border px-2 py-1 text-right">{{ number_format($rows['total'], 2) }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada data ditemukan</p>
            @endif
        </div>
        @endif
    </div>
</x-layout>
