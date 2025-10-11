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
            <form method="POST" action="{{ route('report.refresh.top-10-lub-retail') }}" 
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
        
        @if(in_array(auth()->user()->role, ['developer', 'supervisor', 'manager']))
        <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div>
                <h5 class="text-gray-800 font-bold ms-4 mb-4">
                    Top 10 Penjualan Cluster dan Non Cluster periode {{ $namaPeriode }}
                </h5>
            </div>

            @if ($data->count() > 0)
                <!-- Grid 2 kolom untuk tampilan desktop -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($data->groupBy('type') as $type => $items)
                        <div class="border border-gray-200 rounded-lg overflow-x-auto bg-white shadow-sm">
                            <div class="relative overflow-x-auto sm:rounded-lg">
                                <table class="table w-full text-xs text-left rtl:text-right text-gray-600">
                                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                                        <tr>
                                            <td colspan="4" class="text-center py-2">{{ $type }}</td>
                                        </tr>
                                        <tr>
                                            <th class="px-2 py-2 text-center">No</th>
                                            <th class="px-2 py-2 text-center">Kode Pelanggan</th>
                                            <th class="px-2 py-2 text-center">Nama Pelanggan</th>
                                            <th class="px-2 py-2 text-center">Capaian Liter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $row)
                                            <tr class="hover:bg-gray-50 border-t">
                                                <td class="px-2 py-2 font-medium text-gray-700">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="px-2 py-2 font-medium text-gray-700">
                                                    {{ $row->cardcode }}
                                                </td>
                                                <td class="px-2 py-2 font-medium text-gray-700">
                                                    {{ $row->cardname }}
                                                </td>
                                                <td class="px-2 py-2 font-medium text-gray-700 text-right">
                                                    {{ number_format($row->liter) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
