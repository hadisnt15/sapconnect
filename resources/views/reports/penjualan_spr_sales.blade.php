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
            <form action="{{ route('report.pencapaian-penjualan-sparepart-per-sales') }}" method="get" class="flex items-center gap-2 w-full md:w-auto">
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
            </form>

            <!-- 🔧 Form Filter & Sinkronisasi (Kanan) -->
            <div class="flex flex-col sm:flex-col md:flex-row md:items-center md:justify-end gap-3 w-full md:w-auto">
                @can('dashboard.refresh')
                <!-- 🔴 Sinkronisasi SAP -->
                <form method="POST" action="{{ route('report.refresh.pencapaian-penjualan-sparepart-per-sales') }}" 
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
        <div class="md:block hidden p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Pencapaian Penjualan per Penjual periode {{ $namaPeriode }}</h5></div>
            <div class="grid md:grid-cols-2 gap-3">
                @foreach ($grouped as $salesName => $segments)
                    <div class="mb-2 border border-gray-200 rounded-lg overflow-x-auto bg-white">
                        <div class="relative overflow-x-auto max-h-[600px] shadow-sm sm:rounded-lg">
                            <table class="table-auto w-full text-sm text-left rtl:text-right text-gray-600">
                                <thead class="text-xs font-bold text-white uppercase bg-red-800 sticky top-0 z-20">
                                    <tr>
                                        <td colspan="4" class="text-center py-2">{{ $salesName }}</td>
                                    </tr>
                                    <tr>
                                        <th class="px-2 py-2 text-center">TIPE</th>
                                        <th class="px-2 py-2 text-center">TARGET</th>
                                        <th class="px-2 py-2 text-center">CAPAI</th>
                                        <th class="px-2 py-2 text-center">PERSENTASE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($segments as $segmentName => $segment)
                                        <tr class="text-center bg-gray-100 text-gray-800 font-semibold">
                                            <td colspan="4">{{ $segmentName }}</td>
                                        </tr>
                                        @foreach ($segment['rows'] as $row)
                                            <tr class="hover:bg-gray-50 border-t">
                                                <td class="px-2 py-2 font-medium text-gray-700">{{ $row->TYPE }}</td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700">{{ number_format($row->TARGET) }}</td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700">{{ number_format($row->CAPAI) }}</td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700">{{ $row->PERSENTASE }}%</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-gray-50 font-bold text-gray-800">
                                            <td class="px-2 py-2 border-t">Total {{ $segmentName }}</td>
                                            <td class="px-2 py-2 text-right border-t">{{ number_format($segment['sum_target'], 0, '.', ',') }}</td>
                                            <td class="px-2 py-2 text-right border-t">{{ number_format($segment['sum_capai'], 0, '.', ',') }}</td>
                                            <td class="px-2 py-2 border-t"></td>
                                        </tr>
                                    @endforeach
                                    @php
                                        $firstRow = $segments->flatten()->first();
                                    @endphp
                                    <tr class="bg-indigo-50 font-bold text-red-900">
                                        <td class="px-2 py-2 border-t">TOTAL SEMUA</td>
                                        <td class="px-2 py-2 text-right border-t">{{ number_format($firstRow->SUMTARGETSPR ?? 0, 0, '.', ',') }}</td>
                                        <td class="px-2 py-2 text-right border-t">{{ number_format($firstRow->SUMCAPAISPR ?? 0, 0, '.', ',') }}</td>
                                        <td class="px-2 py-2 text-right border-t">{{ $firstRow->SUMPERSENTASE }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="block md:hidden p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Pencapaian Penjualan per Penjual periode {{ $namaPeriode }}</h5></div>
            <div class="">
                @foreach ($grouped as $salesName => $segments)
                    <div class=" mb-2 border border-gray-200 rounded-lg overflow-x-auto bg-white">
                        <div class="relative overflow-x-auto max-h-[600px] shadow-sm sm:rounded-lg">
                            <table class="table w-full text-xs text-left rtl:text-right text-gray-600">
                                <thead class="text-xs font-bold text-white uppercase bg-red-800 sticky top-0 z-20">
                                    <tr>
                                        <td colspan="3" class="text-center py-2">{{ $salesName }}</td>
                                    </tr>
                                    <tr>
                                        <th class="px-2 py-2 text-center">KET</th>
                                        <th class="px-2 py-2 text-center">CAPAI/TARGET</th>
                                        <th class="px-2 py-2 text-center">PERSENTASE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($segments as $segmentName => $segment)
                                        <tr class="text-center bg-gray-100 text-gray-800 font-semibold">
                                            <td colspan="3">{{ $segmentName }}</td>
                                        </tr>
                                        @foreach ($segment['rows'] as $row)
                                            <tr class=" bg-gray-100 text-gray-800 font-semibold">
                                                <td colspan="3" class="font-medium text-gray-700">TIPE: {{ $row->TYPE }}</td>
                                            </tr>
                                            <tr class="hover:bg-gray-50 border-t">
                                                <td class="px-2 py-2 font-medium text-gray-700">CAPAI <br> TARGET</td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700">{{ number_format($row->CAPAI) }} <br> {{ number_format($row->TARGET) }}</td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700">{{ $row->PERSENTASE }}%</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-gray-50 font-bold text-gray-800">
                                            <td class="px-2 py-2 border-t">Total {{ $segmentName }}</td>
                                            <td class="px-2 py-2 text-right border-t">{{ number_format($segment['sum_capai'], 0, ',', '.') }}<br>{{ number_format($segment['sum_target'], 0, ',', '.') }}</td>
                                            
                                            <td class="px-2 py-2 border-t"></td>
                                        </tr>
                                    @endforeach
                                    @php
                                        $firstRow = $segments->flatten()->first();
                                    @endphp
                                    <tr class="bg-indigo-50 font-bold text-red-900">
                                        <td class="px-2 py-2 border-t">TOTAL SEMUA</td>
                                        <td class="px-2 py-2 text-right border-t">{{ number_format($firstRow->SUMCAPAISPR ?? 0, 0, ',', '.') }}<br>{{ number_format($firstRow->SUMTARGETSPR ?? 0, 0, ',', '.') }}</td>
                                        
                                        <td class="px-2 py-2 text-right border-t">{{ $firstRow->SUMPERSENTASE }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
