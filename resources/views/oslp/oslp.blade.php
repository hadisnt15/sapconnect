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
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-group-2-fill text-red-800"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Search & Action -->
        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4 items-center pb-4 w-full">
            <div>
                <form action="" method="get">
                    <label for="search" class="sr-only">Cari Penjual</label>
                    <div class="relative">
                        <input type="text" id="search" name="search"
                            class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-50 border-gray-300 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200"
                            placeholder="Cari Penjual" />
                        <button type="submit"
                            class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto flex items-center gap-2">
                <a href="{{ route('salesman.registration') }}"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-add-box-fill"></i> Daftarkan Penjual
                </a>
                <a href="{{ route('salesman.refresh') }}"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="md:block hidden relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="text-xs font-bold text-white uppercase bg-red-800">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Nama/Alias</th>
                        <th class="px-6 py-3">Telepon</th>
                        <th class="px-6 py-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($slps as $s)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $s->RegSlpCode }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $s->oslpLocal->SlpName }}/{{ $s->Alias }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $s->oslpLocal->Phone }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                Pesanan Pertama:
                                {{ \Carbon\Carbon::parse($s->oslpLocal->FirstOdrDate)->format('d-m-Y') }} <br>
                                Pesanan Terbaru:
                                {{ \Carbon\Carbon::parse($s->oslpLocal->LastOdrDate)->format('d-m-Y') }}

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="md:hidden block relative overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="text-xs font-bold text-white uppercase bg-red-800">
                    <tr>
                        <th class="px-6 py-3">Penjual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($slps as $s)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <span class="font-bold">{{ $s->RegSlpCode }}</span> <br>
                                <span class="font-bold">{{ $s->oslpLocal->SlpName }}/{{ $s->Alias }}</span> <br>
                                {{ $s->oslpLocal->Phone }} <br>
                                Pesanan Pertama:
                                {{ \Carbon\Carbon::parse($s->oslpLocal->FirstOdrDate)->format('d-m-Y') }} <br>
                                Pesanan Terbaru:
                                {{ \Carbon\Carbon::parse($s->oslpLocal->LastOdrDate)->format('d-m-Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-5 text-gray-600">
            {{ $slps->links() }}
        </div>
    </div>
</x-layout>
