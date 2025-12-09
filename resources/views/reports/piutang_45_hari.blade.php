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
            <form action="{{ route('report.piutang-45-hari') }}" method="get" class="flex items-center gap-2 w-full md:w-auto">
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
                <div class="flex items-center">
                    <a href="{{ route('report.refresh.piutang-45-hari') }}"
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
        <div class="">
            <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
                <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Data Rekap Piutang 45 Hari</h5></div>
                 {{-- LOOP KET3 --}}
                @foreach($groupedSum as $ket3Value => $keys)
                    <h2 class="text-sm font-bold text-red-800 border-t pb-1 mt-4 mb-2">
                        @if($ket3Value == '<= 45 Hari') 
                            45 Hari ke Bawah
                        @else
                            Di Atas 45 Hari
                        @endif
                    </h2>

                    <div class="grid md:grid-cols-3 gap-2">

                        {{-- LOOP KEY DI DALAM KET3 --}}
                        @foreach($keys as $key)
                            <div class="border rounded-lg shadow-sm bg-white mb-4">
                                <div class="bg-gray-100 rounded-t-lg border-b">
                                    <h3 class="font-bold text-red-800 px-4 py-2">
                                        {{ $key['headerkey'] }}
                                    </h3>
                                </div>

                                <div class="px-2 py-2">
                                    {{-- KET2 --}}
                                    @foreach($key['ket2'] as $ket2Key => $ket2)
                                        <ul class="py-1">
                                            <li class="text-sm">
                                                {{ $ket2Key }} :
                                                <strong>{{ number_format($ket2['total'], 1, '.', ',') }}</strong>
                                            </li>
                                        </ul>
                                    @endforeach

                                    <hr class="my-2">

                                    <div class="text-right font-bold text-sm">
                                        Total keseluruhan:
                                        <strong>{{ number_format($key['total_all'], 1, '.', ',') }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                @endforeach
            </div>
            <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
                <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Data Detail Piutang 45 Hari</h5></div>
                <div class="grid md:grid-cols-1 gap-4">
                    @foreach ($grouped as $ket3 => $keys)
                        {{-- HEADER KET3 --}}
                        <h2 class="text-sm font-bold text-red-800 border-t pb-1 mt-4 mb-2">
                            @if($ket3Value == '<= 45 Hari') 
                                45 Hari ke Bawah
                            @else
                                Di Atas 45 Hari
                            @endif
                        </h2>

                        <div class="grid md:grid-cols-2 gap-2">
                        @foreach ($keys as $key => $custs)
                            <div class="mb-2 border border-gray-200 rounded-lg overflow-x-auto bg-white">
                                <div class="relative overflow-x-auto shadow-sm sm:rounded-lg max-h-96">
                                    <table class="table-auto w-full text-sm text-left text-gray-600">
                                        <thead class="text-xs font-bold text-white uppercase bg-red-800 sticky top-0 z-20">
                                            <tr>
                                                <td colspan="3" class="text-center py-2">{{ $key }}</td>
                                            </tr>
                                            <tr>
                                                <th class="px-2 py-2 text-center w-8/12">PELANGGAN</th>
                                                <th class="px-2 py-2 text-center w-2/12">LEWAT HARI</th>
                                                <th class="px-2 py-2 text-center w-2/12">PIUTANG</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            {{-- LOOP KET2 --}}
                                            @foreach ($custs['ket2'] as $ket2Name => $cust)
                                                <tr class="text-center bg-gray-100 text-gray-800 font-semibold border-b">
                                                    <td colspan="3" class="py-2">{{ $ket2Name }}</td>
                                                </tr>

                                                {{-- ROWS --}}
                                                @foreach ($cust['rows'] as $row)
                                                    <tr class="hover:bg-gray-50 border-t">
                                                        <td class="px-2 py-2 font-medium text-gray-700">
                                                            {{ $row->NAMACUST }} - {{ $row->KODECUST }} - {{ $row->CABANG }}
                                                        </td>
                                                        <td class="px-2 py-2 font-medium text-center text-gray-700">
                                                            {{ $row->LEWATHARI }} hari
                                                        </td>
                                                        <td class="px-2 py-2 text-right font-medium text-gray-700">
                                                            {{ number_format($row->PIUTANG) }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                {{-- TOTAL PER KET2 --}}
                                                <tr class="bg-gray-50 font-bold text-gray-800">
                                                    <td class="px-4 py-2 border-t" colspan="2">Total {{ $ket2Name }}</td>
                                                    <td class="px-2 py-2 border-t text-right">
                                                        {{ number_format($cust['total_ket2']) }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                            {{-- TOTAL PER KEY --}}
                                            <tr class="bg-red-800 font-bold text-white">
                                                <td class="px-2 py-2 border-t" colspan="2">TOTAL {{ $key }}</td>
                                                <td class="px-2 py-2 border-t text-right">
                                                    {{ number_format($custs['total_key']) }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-layout>
