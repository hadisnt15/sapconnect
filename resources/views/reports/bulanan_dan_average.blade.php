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
            <form action="" method="get" class="w-full md:w-auto">
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

                <!-- 🟢 Filter Segment -->
                <form method="GET" action="{{ route('report.bulanan-dan-average') }}" 
                    class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    <select name="segment" onchange="this.form.submit()" 
                        class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-2 px-2 w-full">
                        <option value="">Semua Segment</option>
                        @foreach ($segments as $segment)
                            <option value="{{ $segment->SEGMENT }}" {{ $segmentFilter == $segment->SEGMENT ? 'selected' : '' }}>
                                {{ $segment->SEGMENT }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white w-full md:w-auto">
                        Filter
                    </button>
                </form>

                @can('dashboard.refresh')
                <!-- 🔴 Sinkronisasi SAP -->
                <form method="POST" action="{{ route('report.refresh.bulanan-dan-average') }}" 
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
        
        <!-- DESKTOP -->
        <div class="hidden md:block p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Laporan Pencapaian Pelanggan Periode {{ $namaPeriode }} dan Rata-rata 3 Bulan Terakhir</h5></div>
            <div class="border border-gray-200 rounded-lg overflow-x-auto bg-white shadow-sm overflow-x-auto mb-8 sm:rounded-lg">
                <table class="table w-full text-xs text-gray-600">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                        <tr>
                            <th class="px-2 py-2">SEGMENT</th>
                            <th class="px-2 py-2">PELANGGAN</th>
                            <th class="px-2 py-2">PENJUAL</th>
                            <th class="px-2 py-2">KOTA / PROVINSI</th>
                            @foreach ($bulanHeaders as $bulan)
                                <th class="px-2 py-2 text-center">{{ $bulan }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $row)
                        <tr>
                            <td class="border-b px-2 py-2">{{ $row['SEGMENT'] }}</td>
                            <td class="border-b px-2 py-2">{{ $row['KODECUSTOMER'] }} <br> {{ $row['NAMACUSTOMER'] }}</td>
                            <td class="border-b px-2 py-2">{{ $row['NAMASALES'] }}</td>
                            <td class="border-b px-2 py-2">{{ $row['KOTA'] }} <br> {{ $row['PROVINSI'] }}</td>
                            @foreach ($bulanHeaders as $bulan)
                                <td class="border-b px-2 py-2 text-right">
                                    {{ number_format((float) str_replace(',', '', $row[$bulan]), 2) }}
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                @if ($customers instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $customers->appends(request()->query())->links('pagination::tailwind') }}
                @endif
            </div>
        </div>
        
        <!-- MOBILE -->
        <div class="md:hidden block p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div class="border border-gray-200 rounded-lg overflow-x-auto bg-white shadow-sm overflow-x-auto mb-8 sm:rounded-lg">
                <table class="table w-full text-xs text-gray-600">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                        <tr>
                            <th class="px-2 py-2">SEGMENT / PELANGGAN / PENJUAL / ALAMAT</th>
                            <th class="px-2 py-2 text-center">
                                PENCAPAIAN
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $row)
                        <tr>
                            <td class="border-b px-2 py-2">
                                {{ $row['SEGMENT'] }} <br><br> 
                                Pelanggan: <br> {{ $row['KODECUSTOMER'] }} <br> {{ $row['NAMACUSTOMER'] }} <br><br> 
                                Penjual: <br> {{ $row['NAMASALES'] }} <br><br>
                                Alamat: <br> {{ $row['KOTA'] }} <br> {{ $row['PROVINSI'] }}
                            </td>
                            <td class="border-b px-2 py-2">
                                @foreach ($bulanHeaders as $bulan)
                                    {{ $bulan }}: {{ number_format((float) str_replace(',', '', $row[$bulan]), 2) }} <br><br>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                @if ($customers instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $customers->appends(request()->query())->links('pagination::tailwind') }}
                @endif
            </div>
        </div>
    </div>
</x-layout>
