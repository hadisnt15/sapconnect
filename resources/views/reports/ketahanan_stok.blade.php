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
                    Ketahanan Stok KAM
                </h5>
            </div>
            @if ($data->count() > 0)
                <div class="mb-2 border rounded-lg shadow bg-white">
                    <div>
                        <!-- desktop -->
                        <div class="hidden md:block px-4 pb-4 mt-4 relative z-10">
                            <table class="w-full text-xs border border-gray-300">
                                <thead class="bg-gray-200 text-gray-700 text-center sticky top-0 z-20">
                                    <tr>
                                        <th class="border px-2 py-1">No</th>
                                        <th class="border px-2 py-1">Nama Barang</th>
                                        <th class="border px-2 py-1">Stock On Hand</th>
                                        <th class="border px-2 py-1">Stock Outstanding</th>
                                        <th class="border px-2 py-1">Stock Container</th>
                                        <th class="border px-2 py-1">Stock Rencana Isi</th>
                                        <th class="border px-2 py-1">Stock Rencana Jadwal</th>
                                        <th class="border px-2 py-1">Total Stock (A+B+C)</th>
                                        <th class="border px-2 py-1">Stock Pinjam MADHANI</th>
                                        <th class="border px-2 py-1">Stock Pinjam PPA</th>
                                        <th class="border px-2 py-1">Total Stock Pinjam (E+F)</th>
                                        <th class="border px-2 py-1">Sisa Stock (D-G)</th>
                                    </tr>
                                    <tr>
                                        <th class="border px-2 py-1"></th>
                                        <th class="border px-2 py-1"></th>
                                        <th class="border px-2 py-1">A</th>
                                        <th class="border px-2 py-1"></th>
                                        <th class="border px-2 py-1">B</th>
                                        <th class="border px-2 py-1"></th>
                                        <th class="border px-2 py-1">C</th>
                                        <th class="border px-2 py-1">D</th>
                                        <th class="border px-2 py-1">E</th>
                                        <th class="border px-2 py-1">F</th>
                                        <th class="border px-2 py-1">G</th>
                                        <th class="border px-2 py-1">H</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($data as $item)
                                    <!-- BARIS JUDUL ITEM -->
                                    <tr class="bg-white">
                                        <td class="border px-2 py-1 font-semibold bg-white">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-white">
                                            <span>{{ $item->FRGNNAME }} ({{ $item->ORIGINCODE }}) - {{ $item->UOM }}</span>
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-white text-right">
                                            {{ number_format($item->STOCKONHAND,0) }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-white text-right">
                                            {{ number_format($item->STOCKOUTSTANDING,0) }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-white text-right">
                                            {{ number_format($item->STOCKCONTAINER,0) }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-white text-right">
                                            {{ number_format($item->STOCKRENCANAISI,0) }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-white text-right">
                                            {{ number_format($item->STOCKRENCANAJADWAL,0) }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-gray-100 text-right">
                                            {{ number_format($item->TOTALSTOCK,0) }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-white text-right">
                                            {{ number_format($item->STOCKPINJAMMADHANI,0) }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-white text-right">
                                            {{ number_format($item->STOCKPINJAMPPA,0) }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-gray-100 text-right">
                                            {{ number_format($item->TOTALSTOCKPINJAM,0) }}
                                        </td>
                                        <td class="border px-2 py-1 font-semibold bg-gray-200 text-right">
                                            {{ number_format($item->SISASTOCK,0) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-white">
                                        <th class="border px-2 py-1 font-bold bg-white" colspan="2">
                                            Total
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-white text-right">
                                            {{ number_format($data->sum('STOCKONHAND'),0) }}
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-white text-right">
                                            {{ number_format($data->sum('STOCKOUTSTANDING'),0) }}
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-white text-right">
                                            {{ number_format($data->sum('STOCKCONTAINER'),0) }}
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-white text-right">
                                            {{ number_format($data->sum('STOCKRENCANAISI'),0) }}
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-white text-right">
                                            {{ number_format($data->sum('STOCKRENCANAJADWAL'),0) }}
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-gray-100 text-right">
                                            {{ number_format($data->sum('TOTALSTOCK'),0) }}
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-white text-right">
                                            {{ number_format($data->sum('STOCKPINJAMMADHANI'),0) }}
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-white text-right">
                                            {{ number_format($data->sum('STOCKPINJAMPPA'),0) }}
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-gray-100 text-right">
                                            {{ number_format($data->sum('TOTALSTOCKPINJAM'),0) }}
                                        </th>
                                        <th class="border px-2 py-1 font-bold bg-gray-200 text-right">
                                            {{ number_format($data->sum('SISASTOCK'),0) }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada data ditemukan</p>
            @endif
        </div>
        @endif
    </div>
</x-layout>
