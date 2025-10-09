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
                            placeholder="Cari Pesanan" />
                        <button type="submit"
                            class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto flex items-center gap-2">
                @can('order.create')
                    <a href="{{ route('customer') }}"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-add-box-fill"></i> Buat Pesanan Baru
                    </a>
                @endcan
                @can('order.push')
                    <a href="{{ route('order.push') }}"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-upload-cloud-2-fill"></i> Kirim ke SAP
                    </a>
                @endcan
                @can('order.refresh')
                    <a href="{{ route('order.refresh') }}"
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

        <form method="GET" action="{{ route('order') }}" 
            class="flex flex-col md:flex-row md:justify-start md:items-center gap-2 md:gap-3 mb-3">

            <div class="flex flex-col sm:flex-row gap-1 md:gap-1 items-start md:items-center">

                <!-- 🔹 Select Filter -->
                <select name="checked" onchange="this.form.submit()" 
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">
                    <option value="">Tanpa Filter</option>
                    <option value="1" {{ request('checked') == '1' ? 'selected' : '' }}>Ceklis</option>
                    <option value="0" {{ request('checked') == '0' ? 'selected' : '' }}>Non Ceklis</option>
                    <option value="2" {{ request('checked') == '2' ? 'selected' : '' }}>Terkirim</option>
                    <option value="3" {{ request('checked') == '3' ? 'selected' : '' }}>Tertunda</option>
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
        <div class="md:block hidden">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <form action="{{ route('order.updateChecked') }}" method="POST">
                    @csrf @method('patch')
                    <table class="w-full text-sm text-left text-gray-600 border">
                        <thead class="text-xs font-bold text-white uppercase bg-red-800">
                            <tr>
                                <th class="px-2 py-2 w-1/12">REFERENSI</th>
                                <th class="px-2 py-2 w-3/12">PELANGGAN</th>
                                <th class="px-2 py-2 w-2/12">PENJUAL</th>
                                <th class="px-2 py-2 w-1/24">CEK</th>
                                <th class="px-2 py-2 w-1/24">STATUS</th>
                                <th class="px-2 py-2 w-1/24">STATUS SAP</th>
                                <th class="px-2 py-2 w-1/18">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($orders as $o)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-2 py-2 font-medium text-gray-800">
                                        {{ $o->OdrRefNum }} <br> {{ $o->OdrDocDate->format('d-m-Y') }} <br> 
                                        <span class="text-xs">{{ $o->order_row_count }} Barang <br> Catatan: {{ $o->note }}</span>
                                    </td>
                                    <td class="px-2 py-2 font-medium text-gray-800">
                                        {{ $o->customer->CardName }} <br> {{ $o->OdrCrdCode }}
                                    </td>
                                    <td class="px-2 py-2 font-medium text-gray-800">
                                        {{ $o->salesman?->SlpName ?? 'DUMMY' }}
                                    </td>
                                    <td class="px-2 py-2 text-center">
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
                                    <td class="px-2 py-2 font-medium">
                                        @if ($o->is_synced === 1)
                                            <span class="text-green-600 font-semibold">TERKIRIM</span>
                                        @elseif ($o->is_synced === 2)
                                            <span class="text-blue-600 font-semibold">PROSES KIRIM</span>
                                        @elseif ($o->is_synced === 0)
                                            <span class="text-yellow-600 font-semibold">TERTUNDA</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 font-medium">
                                        @if (Str::contains(optional($o->ordrStatus)->pesanan_status, 'PESANAN TERTUNDA'))
                                            <span class="text-yellow-600 font-semibold">{{ optional($o->ordrStatus)->pesanan_status }}</span>
                                        @elseif (Str::contains(optional($o->ordrStatus)->pesanan_status, 'PESANAN SELESAI'))
                                            <span class="text-green-600 font-semibold">{{ optional($o->ordrStatus)->pesanan_status }}</span>
                                        @elseif (optional($o->ordrStatus)->pesanan_status === 'BELUM DIPROSES DI SAP')
                                            <span class="text-gray-600 font-semibold">{{ optional($o->ordrStatus)->pesanan_status }}</span>
                                        @endif

                                    </td>
                                    <td class="px-2 py-2 space-y-1">
                                        <button type="button" data-id="{{ $o->id }}"
                                            data-OdrRefNum="{{ $o->OdrRefNum }}"
                                            data-OdrDocDate="{{ $o->OdrDocDate->format('d-m-Y') }}"
                                            data-OdrCardCode="{{ $o->OdrCrdCode }}"
                                            data-OdrCardName="{{ $o->customer->CardName }}"
                                            data-OdrSlpName="{{ $o->salesman?->SlpName ?? 'DUMMY' }}"
                                            data-modal-target="detailModal" data-modal-toggle="detailModal"
                                            class="btn-detail open-modal-ordr-btn block px-2 py-1 text-xs rounded bg-red-800 hover:bg-red-500 w-full text-white">
                                            <i class="ri-eye-fill"></i> Detail
                                        </button>
                                        <a href="{{ route('order.progress', $o->id) }}" onclick="return confirm('Melihat Proses Pesanan Akan Memerlukan Waktu, Lanjutkan?')"
                                            class="block px-2 py-1 text-xs rounded bg-blue-500 hover:bg-blue-400 text-white w-full text-center">
                                            <i class="ri-swap-2-fill"></i> Proses
                                        </a>
                                        @if (in_array($user->role, ['developer', 'salesman']))
                                            <a href="{{ route('order.edit', $o->id) }}"
                                                class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                                <i class="ri-file-edit-fill"></i> Edit
                                            </a>
                                            <a href="{{ route('order.delete', $o->id) }}"
                                                class="block px-2 py-1 text-xs rounded bg-gray-500 hover:bg-gray-400 text-white w-full text-center">
                                                <i class="ri-delete-back-2-fill"></i> Hapus
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (in_array($user->role, ['developer', 'salesman']))
                    <div class="flex justify-end mt-4 mb-2 ms-2">
                        <button type="submit"
                            class="px-4 py-2 bg-red-800 hover:bg-red-500 text-white text-xs rounded-lg shadow font-bold">
                            Perbarui Pengecekan
                        </button>
                    </div>
                    @endif
                </form>
            </div>
            <div class="mt-5 text-gray-600">
                {{ $orders->links() }}
            </div>
        </div>

        <div class="block md:hidden">
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
                                        <span class="text-xs">{{ $o->order_row_count }} Barang <br> Catatan: {{ $o->note }}</span><br><br>
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
                    <div class="flex justify-end mt-4 mb-2 ms-2">
                        <button type="submit"
                            class="px-4 py-2 bg-red-800 hover:bg-red-500 text-white text-xs rounded-lg shadow font-bold">
                            Perbarui Pengecekan
                        </button>
                    </div>
                    @endif
                </form>
            </div>
            <div class="mt-5 text-gray-600">
                {{ $orders->links() }}
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div id="detailModal" tabindex="-1"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="relative w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="relative rounded-lg shadow bg-white border border-gray-200">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <h2 class="text-base font-bold text-gray-700">Detail Pesanan</h2>
                    <button type="button"
                        class="text-gray-500 hover:text-gray-800 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                        data-modal-hide="detailModal">✕</button>
                </div>

                <!-- Modal body -->
                <div class="px-5 py-4 space-y-4 text-sm text-gray-700">

                    <!-- Info Pesanan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <p><span class="font-medium">Nomor Pesanan:</span> <span id="modalOdrRefNum"></span></p>
                        <p><span class="font-medium">Tanggal Pesanan:</span> <span id="modalOdrDocDate"></span></p>
                        <p><span class="font-medium">Kode Pelanggan:</span> <span id="modalOdrCardCode"></span></p>
                        <p><span class="font-medium">Nama Pelanggan:</span> <span id="modalOdrCardName"></span></p>
                        <p class="sm:col-span-2"><span class="font-medium">Nama Penjual:</span> <span
                                id="modalOdrSlpName"></span></p>
                    </div>

                    <!-- Detail Barang -->
                    <h2 class="text-base font-bold mt-4 text-gray-700">Detail Barang</h2>

                    <!-- Mobile view: list -->
                    <div class="block sm:hidden space-y-3" id="detailRowsMobile"></div>

                    <!-- Desktop view: table -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="w-full border text-sm text-gray-700">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2">No</th>
                                    <th class="border p-2">Kode Barang</th>
                                    <th class="border p-2">Deskripsi Barang</th>
                                    <th class="border p-2">Kuantitas</th>
                                    <th class="border p-2">Harga</th>
                                    <th class="border p-2">Diskon</th>
                                    <th class="border p-2">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detailRows"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttonsView = document.querySelectorAll('.open-modal-ordr-btn');

        buttonsView.forEach(button => {
            button.addEventListener('click', function() {
                const OdrRefNum = this.getAttribute('data-OdrRefNum');
                const OdrDocDate = this.getAttribute('data-OdrDocDate');
                const OdrCardCode = this.getAttribute('data-OdrCardCode');
                const OdrCardName = this.getAttribute('data-OdrCardName');
                const OdrSlpName = this.getAttribute('data-OdrSlpName');

                // set header info
                document.getElementById("modalOdrRefNum").innerText = OdrRefNum;
                document.getElementById("modalOdrDocDate").innerText = OdrDocDate;
                document.getElementById("modalOdrCardCode").innerText = OdrCardCode;
                document.getElementById("modalOdrCardName").innerText = OdrCardName;
                document.getElementById("modalOdrSlpName").innerText = OdrSlpName;

                const modal = document.getElementById('detailModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // fetch detail item
                let id = this.getAttribute('data-id');
                fetch(`/pesanan/${id}/detail`)
                    .then(res => res.json())
                    .then(data => {
                        // isi desktop table
                        let tbody = document.getElementById('detailRows');
                        tbody.innerHTML = "";
                        // isi mobile card
                        let mobileList = document.getElementById('detailRowsMobile');
                        mobileList.innerHTML = "";

                        data.forEach((item, index) => {
                            let no = index + 1; // nomor urut dimulai dari 1

                            // konversi angka dengan fallback 0
                            let qty = parseFloat(item.RdrItemQuantity) || 0;
                            let price = parseFloat(item.RdrItemPrice) || 0;
                            let discPercent = (item.RdrItemDisc === null || item.RdrItemDisc === '' || isNaN(item.RdrItemDisc))
                                ? 0
                                : parseFloat(item.RdrItemDisc);

                            // hitung subtotal dengan diskon persen
                            let subtotal = qty * (price * (1 - discPercent / 100));

                            // Fungsi untuk format angka dengan koma (ribuan)
                            const formatNumber = (num) => {
                                return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            };

                            // desktop
                            tbody.innerHTML += `
                <tr>
                    <td class="border p-2 text-center">${no}</td>
                    <td class="border p-2">${item.RdrItemCode}</td>
                    <td class="border p-2">${item.ItemName}</td>
                    <td class="border p-2 text-right">${formatNumber(qty)}</td>
                    <td class="border p-2 text-right">${formatNumber(price)}</td>
                    <td class="border p-2 text-right">${discPercent ? discPercent + '%' : '-'}</td>
                    <td class="border p-2 text-right font-semibold">${formatNumber(subtotal)}</td>
                </tr>`;

                            // mobile
                            mobileList.innerHTML += `
                <div class="p-3 border rounded-lg bg-gray-50 shadow-sm">
                    <p><b>${no}. ${item.RdrItemCode}</b></p>
                    <p>Deskripsi: ${item.ItemName}</p>
                    <p>Kuantitas: ${formatNumber(qty)}</p>
                    <p>Harga: ${formatNumber(price)}</p>
                    <p>Diskon: ${discPercent ? discPercent + '%' : '-'}</p>
                    <p><b>Subtotal: ${formatNumber(subtotal)}</b></p>
                </div>`;
                        });
                    });

            });
        });

        // tombol close
        document.querySelectorAll("[data-modal-hide]").forEach(btn => {
            btn.addEventListener("click", function() {
                const modal = document.getElementById(this.getAttribute("data-modal-hide"));
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            });
        });
    });
</script>
