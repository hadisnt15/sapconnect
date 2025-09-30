<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>
    
    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-layout-grid-fill"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        @can('dashboard.refresh')
        <!-- Filter Bulan -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-2">
            <form method="POST" action="{{ route('dashboard.refresh') }}" 
                class="mb-4 flex flex-col md:flex-row items-stretch md:items-center gap-2 w-full md:w-auto">
                @csrf
                <div class="flex flex-col md:flex-row md:items-center gap-2 w-full md:w-auto">
                    <label for="month" class="text-xs font-medium text-gray-600">Pilih Bulan:</label>
                    <input 
                        type="month" 
                        id="month" 
                        name="month" 
                        value="{{ request('month', now()->format('Y-m')) }}"
                        class="border rounded-lg p-2 text-xs font-medium text-gray-700 border-gray-300 focus:ring focus:ring-red-200 w-full md:w-auto"
                    >
                </div>
                <button type="submit" 
                    class="text-xs w-full md:w-auto flex-shrink-0 rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                </button>
            </form>
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
        <!-- <div class="grid md:grid-cols-4 gap-3">
            <article class="p-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 transition">
                <h5 class="font-bold tracking-tight text-gray-800">
                    LAPORAN
                </h5>
                <div class="ml-auto w-full">
                    <div class="flex items-center justify-end">
                        <a href="" class="mt-1">
                            <span
                                class="border text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg bg-red-800 hover:bg-red-500 text-white transition">
                                <i class="ri-folder-6-fill"></i> Lihat Laporan
                            </span>
                        </a>
                    </div>
                </div>
            </article>
        </div> -->

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

        <!-- Dashboard per Sales -->
        <div class="md:block hidden p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Pencapaian Penjualan per Penjual periode {{ $namaPeriode }}</h5></div>
            <div class="grid md:grid-cols-2 gap-3">
                @foreach ($grouped as $salesName => $segments)
                    <div class="mb-2 border border-gray-200 rounded-lg overflow-x-auto bg-white">
                        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg">
                            <table class="table-auto w-full text-sm text-left rtl:text-right text-gray-600">
                                <thead class="text-xs font-bold text-white uppercase bg-red-800">
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
                                            <td class="px-2 py-2 text-right border-t">{{ number_format($segment['sum_target'], 0, ',', '.') }}</td>
                                            <td class="px-2 py-2 text-right border-t">{{ number_format($segment['sum_capai'], 0, ',', '.') }}</td>
                                            <td class="px-2 py-2 border-t"></td>
                                        </tr>
                                    @endforeach
                                    @php
                                        $firstRow = $segments->flatten()->first();
                                    @endphp
                                    <tr class="bg-indigo-50 font-bold text-red-900">
                                        <td class="px-2 py-2 border-t">TOTAL SEMUA</td>
                                        <td class="px-2 py-2 text-right border-t">{{ number_format($firstRow->SUMTARGETSPR ?? 0, 0, ',', '.') }}</td>
                                        <td class="px-2 py-2 text-right border-t">{{ number_format($firstRow->SUMCAPAISPR ?? 0, 0, ',', '.') }}</td>
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
                        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg">
                            <table class="table w-full text-xs text-left rtl:text-right text-gray-600">
                                <thead class="text-xs font-bold text-white uppercase bg-red-800">
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
