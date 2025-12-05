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
            <form action="{{ route('report.penjualan-industri-per-grup') }}" method="get" class="flex items-center gap-2 w-full md:w-auto">
                <div>
                    <select name="period" onchange="this.form.submit()" 
                        class="bg-gray-50 border border-gray-300 text-xs rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 py-2 px-2 w-full">
                        <!--  -->
                        <option value="">Periode Tersedia</option>
                        @foreach($availablePeriods as $p)
                            <option value="{{ $p }}" {{ $selectedPeriod == $p ? 'selected' : '' }}>
                                {{ $p }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label for="search" class="sr-only">Cari Pelanggan</label>
                <div class="relative w-full md:w-96">
                    <input type="text" id="search" name="search"
                        value="{{ request('search') }}"
                        class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-50 border-gray-300 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200"
                        placeholder="Cari Pelanggan..." />
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
                <form method="POST" action="{{ route('report.refresh.penjualan-industri-per-grup') }}" 
                    class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    @csrf
                    <input 
                        type="month" 
                        id="month" 
                        name="month" 
                        value="{{ request('month', now()->format('Y-m')) }}"
                        class="border rounded-lg p-2 text-xs font-medium text-gray-700 border-gray-300 focus:ring focus:ring-red-200 w-full"
                    >

                    <button type="submit" 
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white flex items-center justify-center gap-1 w-full md:w-auto">
                        <i class="ri-refresh-fill"></i> Sinkron
                    </button>
                </form>
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
                    Penjualan Industri per Grup Periode {{ $namaPeriode }}
                </h5>
            </div>

            @if ($data->count() > 0)
                <div class="grid md:grid-cols-3 gap-4 mb-6">
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
                                <span class="font-bold text-red-800">{{ $type }} </span>
                                <span class="font-semibold text-red-800">{{ $group }}</span>
                            </div>
                            <div class="px-4 pb-4 mt-4 overflow-y-auto max-h-80 relative z-10">
                                <table class="w-full text-xs border border-gray-300">
                                    <thead class="bg-gray-200 text-gray-700 text-center sticky top-0 z-20">
                                        <tr>
                                            <th class="border px-2 py-1">#</th>
                                            {{-- <th class="border px-2 py-1 w-1/6">KODE</th> --}}
                                            <th class="border px-2 py-1 w-5/12">PELANGGAN</th>
                                            <th class="border px-2 py-1 w-1/12">KL</th>
                                            <th class="border px-2 py-1 w-3/12">PIUTANG</th>
                                            <th class="border px-2 py-1 w-3/12">PIUTANG JT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rows['rows'] as $row)
                                        <tr>
                                            <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                                            {{-- <td class="border px-2 py-1">{{ $row->CARDCODE }}</td> --}}
                                            <td class="border px-2 py-1">{{ $row->CARDNAME }} <br> <span class="font-semibold">{{ $row->CARDCODE }}</span></td>
                                            <td class="border px-2 py-1 text-right">{{ number_format($row->KILOLITER,2) }}</td>
                                            <td class="border px-2 py-1 text-right">{{ number_format($row->PIUTANG,2) }}</td>
                                            <td class="border px-2 py-1 text-right">{{ number_format($row->PIUTANGJT,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700">
                                            <th colspan="2" class="border px-2 py-1 text-left">TOTAL {{ $type }} {{ $group }}</th>
                                            <th class="border px-2 py-1 text-right">{{ number_format($rows['total'], 2) }}</th>
                                            <th class="border px-2 py-1 text-right">{{ number_format($rows['total3'], 2) }}</th>
                                            <th class="border px-2 py-1 text-right">{{ number_format($rows['total2'], 2) }}</th>
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
