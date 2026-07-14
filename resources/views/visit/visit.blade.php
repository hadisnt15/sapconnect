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
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-passport-fill text-red-800"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
        {{-- search --}}
        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4 items-center pb-4 w-full">
            <div>
                <form action="" method="get">
                    <label for="search" class="sr-only">Search Order</label>
                    <div class="relative">
                        <input type="text" id="search" name="search"
                            class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-50 border-gray-300 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200"
                            placeholder="Cari Kunjungan" />
                        <button type="submit"
                            class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto flex items-center gap-2">
                @can('visit.create')
                    <a href="{{ route('visit.create') }}"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-add-box-fill"></i> Buat Kunjungan Baru
                    </a>
                @endcan
            </div>
        </div>
        <form method="GET" action="{{ route('visit') }}" class="flex flex-col md:flex-row md:justify-start md:items-center gap-2 md:gap-3 mb-3">
            <div class="flex flex-col sm:flex-row gap-1 md:gap-1 items-start md:items-center">
                <!-- 🔹 Date Range -->
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">
                <!-- 🔹 Filter Button -->
                <button type="submit" class="px-3 py-1 bg-red-800 hover:bg-red-500 text-white text-xs rounded-md shadow font-semibold w-full sm:w-auto">
                    Filter
                </button>
            </div>
        </form>
        {{-- Desktop --}}
        <div class="md:block hidden">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600 border">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                        <tr>
                            <th class="px-4 py-3 w-16">No</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Penjual</th>
                            <th class="px-4 py-3">Pelanggan</th>
                            <th class="px-4 py-3 w-28 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visits as $visit)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    {{ $visits->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($visit->visit_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $visit->salesman?->SlpName }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium">
                                        {{ $visit->ocrd_card?->card_name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $visit->ocrd_card?->card_code }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 space-y-1">
                                    <a href="{{ route('visit.detail', $visit->id) }}"
                                        class="block px-2 py-1 text-xs rounded bg-red-800 hover:bg-red-500 text-white w-full text-center">
                                        <i class="ri-eye-fill"></i> Detail
                                    </a>
                                    <a href="{{ route('visit.edit', $visit->id) }}"
                                        class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                        <i class="ri-file-edit-fill"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">
                                    Tidak ada data kunjungan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile --}}
        <div class="space-y-3 md:hidden">
            <div class="relative overflow-x-auto shadow-md rounded-lg">
                <table class="w-full text-sm text-left text-gray-600 border">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                        <tr>
                            <th class="px-4 py-3 w-10/12">Kunjungan</th>
                            <th class="px-4 py-3 w-2/12 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visits as $visit)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($visit->visit_date)->format('d/m/Y') }}
                                    <div class="font-medium">
                                        {{ $visit->ocrd_card?->card_name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $visit->ocrd_card?->card_code }}
                                    </div>
                                    {{ $visit->salesman?->SlpName }}
                                </td>
                                <td class="px-4 py-3 space-y-1">
                                    <a href="{{ route('visit.detail', $visit->id) }}"
                                        class="block px-2 py-1 text-xs rounded bg-red-800 hover:bg-red-500 text-white w-full text-center">
                                        <i class="ri-eye-fill"></i> 
                                    </a>
                                    <a href="{{ route('visit.edit', $visit->id) }}"
                                        class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                        <i class="ri-file-edit-fill"></i> 
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">
                                    Tidak ada data kunjungan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Pagination --}}
        <div class="mt-5">
            {{ $visits->links() }}
        </div>
 
    </div>

</x-layout>
