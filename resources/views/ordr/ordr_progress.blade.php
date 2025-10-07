<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('order') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-800">
                        <i class="ri-bill-fill"></i> Daftar Pesanan
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-file-edit-fill text-red-800"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="mb-2">
                <label for="OdrCrdCode" class="mb-2 text-sm font-medium text-gray-700">Kode Pelanggan</label>
                <input type="text" id="OdrCrdCode" name="OdrCrdCode"
                    value="{{ $progress[0]->WEB_CARDCODE }}" autocomplete="off"
                    class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                    disabled />
            </div>
            <div class="mb-2">
                <label class="mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                <input type="text" value="{{ $progress[0]->WEB_CARDNAME }}" autocomplete="off"
                    class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                    disabled />
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="mb-2">
                <label for="OdrRefNum" class="mb-2 text-sm font-medium text-gray-700">No Referensi SO</label>
                <input type="text" id="OdrRefNum" name="OdrRefNum"
                    value="{{ $progress[0]->WEB_REF_NUM }}" autocomplete="off"
                    class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                    disabled />
            </div>
            <div class="mb-2">
                <label class="mb-2 text-sm font-medium text-gray-700">Tanggal SO</label>
                <input type="text" name="OdrDocDate" value="{{ $progress[0]->WEB_DOCDATE }}" autocomplete="off"
                    class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                    disabled />
            </div>
        </div>
        <div class="md:block hidden mt-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600 border">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                        <tr>
                            <th class="px-2 py-2 w-1/12">NO</th>
                            <th class="px-2 py-2 w-3/12">BARANG</th>
                            <th class="px-2 py-2 w-7/12">PROSES PENJUALAN</th>
                            <th class="px-2 py-2 w-1/12">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($progress as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2 text-gray-800 text-sm">
                                {{ $row->NO_URUT }}
                            </td>
                            <td class="px-2 py-2 text-gray-800 text-sm">
                                <span class="font-bold">{{ $row->WEB_ITEMCODE }}</span> <br> <span class="font-base">{{ $row->WEB_ITEMNAME }}</span>
                            </td>
                            <td class="px-2 py-2 text-gray-800 text-sm">
                                {{ $row->PROSES }}
                            </td>
                            <td class="px-2 py-2 text-gray-800 text-sm">
                                {{ $row->KETERANGAN }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="block md:hidden mt-4">
            <div class="relative overflow-x-auto shadow-md rounded-lg">
                <table class="w-full text-xs text-left text-gray-600 border">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                        <tr>
                            <th class="px-1 py-1 w-1/12 text-center">NO</th>
                            <th class="px-1 py-1 w-10/12 text-center">PESANAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($progress as $row)
                        <tr class="hover:bg-gray-50 border-b border-gray-400">
                            <td class="px-1 py-1 text-gray-800 text-xs">
                                {{ $row->NO_URUT }}
                            </td>
                            <td class="px-1 py-1 text-gray-800 text-xs whitespace-normal break-words">
                                <div class="font-base mb-1">Kode Barang: <br> <span class="font-bold">{{ $row->WEB_ITEMCODE }}</span></div>
                                <div class="font-base mb-1">Nama Barang: <br> <span class="font-medium">{{ $row->WEB_ITEMNAME }}</span></div>
                                <div class="font-base mb-1">Proses Penjualan: <br> <span class="font-medium">{{ $row->PROSES }}</span></div> 
                                <div class="font-base">Keterangan: <br> <span class="font-medium">{{ $row->KETERANGAN }}</span></div> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</x-layout>

