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
                            <i class="ri-bill-fill text-red-800"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Search & Action -->
        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4 items-center pb-4 w-full">
            <div>
                <form action="" method="get">
                    <label for="search" class="sr-only">Search Order</label>
                    <div class="relative">
                        <input type="text" id="search" name="search"
                            class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-50 border-gray-300 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200"
                            placeholder="Cari Surat Jalan" />
                        <button type="submit"
                            class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto flex items-center gap-2">
                @can('delivery.push')
                    <a href="{{ route('delivery.push') }}"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-upload-cloud-2-fill"></i> Kirim ke SAP
                    </a>
                @endcan
                @can('delivery.refresh')
                    <a href="{{ route('delivery.refresh') }}"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                    </a>
                @endcan
            </div>
        </div>
        <div class="text-sm font-bold text-gray-500 mb-2">
            @if ($lastSync)
                Terakhir Disinkronkan:{{ \Carbon\Carbon::parse($lastSync->last_sync)->timezone('Asia/Makassar')->format('d-m-Y H:i:s') }} WITA ({{ $lastSync->desc }})
            @else
                Belum Pernah Disinkronkan
            @endif
        </div>

        <form method="GET" action="{{ route('delivery') }}" 
            class="flex flex-col md:flex-row md:justify-start md:items-center gap-2 md:gap-3 mb-3">

            <div class="flex flex-col sm:flex-row gap-1 md:gap-1 items-start md:items-center">

                <!-- 🔹 Select Filter -->
                <select name="checked" onchange="this.form.submit()" 
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">
                    <option value="">Tanpa Filter</option>
                    <option value="1" {{ request('checked') == '1' ? 'selected' : '' }}>Diceklis</option>
                    <option value="0" {{ request('checked') == '0' ? 'selected' : '' }}>Belum Diceklis</option>
                    <option value="2" {{ request('checked') == '2' ? 'selected' : '' }}>Terkirim</option>
                    <option value="3" {{ request('checked') == '3' ? 'selected' : '' }}>Belum Dikirim</option>
                </select>

                <!-- 🔹 Date Range -->
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">

                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">

                <!-- 🔹 Filter Button -->
                <button type="submit"
                    class="px-3 py-1 bg-red-800 hover:bg-red-500 text-white text-xs rounded-md shadow font-semibold w-full sm:w-auto">
                    Filter
                </button>
            </div>
        </form>




        <!-- Table -->
        <div class="">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <form action="{{ route('delivery.updateChecked') }}" method="POST">
                    @csrf @method('patch')
                    <table class="w-full text-sm text-left text-gray-600 border">
                        <thead class="text-xs font-bold text-white uppercase bg-red-800">
                            <tr>
                                <th class="px-2 py-2 w-3/12">SURAT JALAN</th>
                                <th class="px-2 py-2 w-3/12">PELANGGAN</th>
                                <th class="px-2 py-2 w-5/12">KETERANGAN</th>
                                <th class="px-2 py-2 w-1/12">CEKLIS</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($deliveries as $q)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-2 py-2 font-medium text-gray-800">
                                        No Ref SJ: {{ $q->ref_sj }} | {{ $q->tgl_sj }} <br> 
                                        No Dokumen SJ: {{ $q->no_sj }} <br> 
                                        Freegood: {{ $q->freegood }} <br> 
                                        @if ($q->is_synced === 1)
                                            <span class="text-green-600 font-semibold">TERKIRIM</span>
                                        @else
                                            <span class="text-yellow-600 font-semibold">BELUM DIKIRIM</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 font-medium text-gray-800">
                                        {{ $q->nama_customer }} <br> 
                                        {{ $q->kode_customer }} 
                                    </td>
                                    <td class="px-2 py-2 font-medium text-gray-800">
                                        @if ($q->is_synced === 1)
                                            <input type="text" name="notes[{{ $q->id }}]" autocomplete="off" value="{{ $q->ket }}" readonly
                                                class="bg-gray-300 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                        @else
                                            <input type="text" name="notes[{{ $q->id }}]" autocomplete="off" value="{{ $q->ket }}" 
                                                class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        @if ($q->is_synced === 1)
                                            <!-- Checkbox hanya untuk tampilan -->
                                            <input type="checkbox" checked disabled
                                                class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">

                                            <!-- Hidden input agar value tetap terkirim -->
                                            <input type="hidden" name="is_checked[]" value="{{ $q->id }}">
                                        @else
                                            <input type="checkbox" 
                                                name="is_checked[]" 
                                                value="{{ $q->id }}"
                                                class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500"
                                                {{ $q->is_checked === 1 ? 'checked' : '' }}>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (in_array($user->role, ['developer', 'salesman']))
                    <div class="fixed bottom-5 right-5 z-50">
                        <button type="submit"
                            class="px-5 py-3 bg-red-800 hover:bg-red-500 text-white text-xs md:text-sm rounded-lg shadow-lg font-bold focus:ring-4 focus:ring-red-300">
                            <i class="ri-check-double-fill mr-1"></i> Perbarui Pengecekan
                        </button>
                    </div>
                    @endif
                </form>
            </div>
            <div class="mt-5 text-gray-600">
                {{ $deliveries->links() }}
            </div>
        </div>

        {{-- <div class="block md:hidden">
            <div class="relative overflow-x-auto shadow-md rounded-lg">
                <form action="{{ route('order.updateChecked') }}" method="POST">
                    @csrf @method('patch')
                    <table class="w-full text-sm text-left text-gray-600 border">
                        <thead class="text-xs font-bold text-white uppercase bg-red-800">
                            <tr>
                                <th class="px-2 py-2 w-7/12">PESANAN</th>
                                <th class="px-2 py-2 w-1/12">CEK</th>
                                <th class="px-2 py-2 w-4/12">STATUS</th>
                                <th class="px-2 py-2 w-1/12">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($orders as $o)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="text-xs px-2 py-2 font-medium text-gray-800">
                                        {{ $o->OdrRefNum }} <br> {{ $o->OdrDocDate->format('d-m-Y') }} <br>
                                        <span class="text-xs">{{ $o->order_row_count }} Barang 
                                        <br> Cabang: {{ $o->branch }}</span>
                                        <br> Catatan: {{ $o->note }}</span><br><br>
                                        {{ $o->customer->CardName }} <br> {{ $o->OdrCrdCode }} <br><br>
                                        {{ $o->salesman?->SlpName ?? 'DUMMY' }}
                                    </td>
                                    <td class="text-xs px-2 py-2 text-center">
                                        @if ($o->is_synced === 1)
                                            <!-- Checkbox hanya untuk tampilan -->
                                            <input type="checkbox" checked disabled
                                                class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">

                                            <!-- Hidden input agar value tetap terkirim -->
                                            <input type="hidden" name="is_checked[]" value="{{ $o->id }}">
                                        @else
                                            <input type="checkbox" 
                                                name="is_checked[]" 
                                                value="{{ $o->id }}"
                                                data-sales="{{ $o->OdrSlpCode }}"
                                                class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500"
                                                {{ $o->is_checked === 1 ? 'checked' : '' }}>
                                        @endif
                                    </td>
                                    <td class="text-xs px-2 py-2 font-medium">
                                        <div class="mt-2">STATUS WEB:</div>
                                        @if ($o->is_synced === 1)
                                            <span class="text-green-600 font-semibold">TERKIRIM</span>
                                        @else
                                            <span class="text-yellow-600 font-semibold">TERTUNDA</span>
                                        @endif
                                        <div class="mt-2">STATUS SAP:</div>
                                        @if (Str::contains(optional($o->ordrStatus)->pesanan_status, 'PESANAN TERTUNDA')) 
                                            <span class="text-yellow-600 font-semibold">{{$o->ordrStatus->pesanan_status ?? ''}}</span>
                                        @elseif (Str::contains(optional($o->ordrStatus)->pesanan_status, 'PESANAN SELESAI'))
                                            <span class="text-green-600 font-semibold">{{$o->ordrStatus->pesanan_status ?? ''}}</span>
                                        @elseif ($o->ordrStatus->pesanan_status ?? '' === 'BELUM DIPROSES DI SAP')    
                                            <span class="text-gray-600 font-semibold">{{$o->ordrStatus->pesanan_status ?? ''}}</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 space-y-1">
                                        <button type="button" data-id="{{ $o->id }}"
                                            data-OdrRefNum="{{ $o->OdrRefNum }}"
                                            data-OdrDocDate="{{ $o->OdrDocDate->format('d-m-Y') }}"
                                            data-OdrCardCode="{{ $o->OdrCrdCode }}"
                                            data-OdrCardName="{{ $o->customer->CardName }}"
                                            data-OdrSlpName="{{ $o->salesman?->SlpName ?? 'DUMMY' }}"
                                            data-branch="{{ $o->branch }}" data-note="{{ $o->note }}"
                                            data-modal-target="detailModal" data-modal-toggle="detailModal"
                                            class="btn-detail open-modal-ordr-btn block px-2 py-1 text-xs rounded bg-red-800 hover:bg-red-500 w-full text-white">
                                            <i class="ri-eye-fill"></i>
                                        </button>
                                        <a href="{{ route('order.progress', $o->id) }}" onclick="return confirm('Melihat Proses Pesanan Akan Memerlukan Waktu, Lanjutkan?')"
                                            class="block px-2 py-1 text-xs rounded bg-blue-500 hover:bg-blue-400 text-white w-full text-center">
                                            <i class="ri-swap-2-fill"></i> 
                                        </a>
                                        @if (in_array($user->role, ['developer', 'salesman']))
                                            <a href="{{ route('order.edit', $o->id) }}"
                                                class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                                <i class="ri-file-edit-fill"></i>
                                            </a>
                                            <a href="{{ route('order.delete', $o->id) }}"
                                                class="block px-2 py-1 text-xs rounded bg-gray-500 hover:bg-gray-400 text-white w-full text-center">
                                                <i class="ri-delete-back-2-fill"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (in_array($user->role, ['developer', 'salesman']))
                    <div class="fixed bottom-4 right-4 left-4 md:left-auto flex justify-center md:justify-end z-[9999]">
                        <button type="submit"
                            class="w-full md:w-auto px-5 py-3 bg-red-800 hover:bg-red-600 text-white text-sm font-bold rounded-xl shadow-lg focus:ring-4 focus:ring-red-300 transition-all">
                            <i class="ri-check-double-fill mr-1"></i> Perbarui Pengecekan
                        </button>
                    </div>
                    @endif
                </form>
            </div>
            <div class="mt-5 text-gray-600">
                {{ $query->links() }}
            </div>
        </div> --}}
    </div>

</x-layout>


