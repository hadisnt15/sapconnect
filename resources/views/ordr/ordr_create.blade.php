<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200">
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
                            <i class="ri-add-box-fill text-red-800"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Form -->
        <form class="mx-auto" action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="">
                <!-- Customer Info -->
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrCrdCode" class="mb-2 text-sm font-medium text-gray-700">Kode Pelanggan</label>
                        <input type="text" id="OdrCrdCode" name="OdrCrdCode"
                            value="{{ old('OdrCrdCode', $dataOrder['OdrCrdCode']) }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        @error('OdrCrdCode')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <input type="text" value="{{ old('CstName', $cust->CardName) }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        @error('CstName')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrRefNum" class="mb-2 text-sm font-medium text-gray-700">No Ref SO</label>
                        <input type="text" id="OdrRefNum" name="OdrRefNum"
                            value="{{ old('OdrRefNum', $dataOrder['OdrRefNum']) }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        @error('OdrRefNum')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Tanggal SO</label>
                        <input type="date" name="OdrDocDate"
                            value="{{ old('OdrDocDate', $dataOrder['OdrDocDate']) }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        @error('OdrDocDate')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="branch" class="mb-2 text-sm font-medium text-gray-700">Cabang</label>
                        <select id="branch" name="branch" required
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Pilih Cabang</option>
                            @foreach ($userBranches as $branch)
                                <option value="{{ $branch }}" {{ old('branch') == $branch ? 'selected' : '' }}>
                                    {{ $branch }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Piutang JT</label>
                        @php
                            $piutangJT = $dataOrder['PiutangJT'] ?? 0;
                            $piutangClass = $piutangJT > 0
                                ? 'border-red-500 bg-red-100 text-red-700 font-semibold'
                                : 'border-gray-300 text-gray-700';
                        @endphp
                        <input type="text"
                            value="{{ number_format($piutangJT, 0, '.', ',') }}"
                            autocomplete="off"
                            class="bg-gray-50 {{ $piutangClass }} border rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        @error('CstName')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    <label class="mb-2 text-sm font-medium text-gray-700">Catatan</label>
                    <input type="text" name="note" autocomplete="off" value="{{ old('note') }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    @error('note')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="OdrSlpCode" value="{{ $dataOrder['OdrSlpCode'] }}">
                <input type="hidden" name="OdrNum" value="{{ $dataOrder['OdrNum'] }}">

                <!-- Detail Barang -->
                <h3 class="text-base font-semibold mb-2 text-gray-800">Detail Barang</h3>

                <div x-data="{
                        items: [{
                            RdrItemCode: '', ItemName: '', RdrItemQuantity: 1, RdrItemPrice: 0,
                            RdrItemSatuan: '', RdrItemProfitCenter: '', RdrItemKetHKN: '', RdrItemKetFG: '', open: true
                        }]
                    }" class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="border border-gray-200 bg-white rounded-lg shadow-sm">
                            <!-- Header item -->
                            <div class="flex justify-between items-center p-3 bg-gray-100 rounded-t-lg cursor-pointer"
                                @click="item.open = !item.open">
                                <div>
                                    <span class="font-semibold text-gray-800 text-sm mr-2" x-text="'#' + (index + 1)"></span>
                                    <span class="text-xs text-gray-500">
                                        <span x-text="'Kode: ' + (item.RdrItemCode || 'Kode Barang')"></span>
                                    </span> <br>
                                    <span class="text-xs text-gray-500">
                                        <span x-text="'Qty: ' + (item.RdrItemQuantity || 0) + ' - Harga: ' + (item.RdrItemPrice || 0) + ' - Disc: ' + (item.RdrItemDisc || 0)"></span>
                                    </span> <br>
                                    <span class="text-sm font-semibold text-gray-700" x-show="item.ItemName">
                                        (<span x-text="item.ItemName"></span>)
                                    </span>
                                </div>
                                <button type="button" class="text-gray-600 hover:text-red-800 text-lg">
                                    <i :class="item.open ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line'"></i>
                                </button>
                            </div>

                            <!-- Isi form item -->
                            <div x-show="item.open" x-collapse class="p-3 space-y-2">
                                <!-- Pilih kode barang -->
                                <div>
                                    <label class="text-xs text-gray-600">Kode Barang</label>
                                    <select :id="'itemSelect' + index" :name="'items[' + index + '][RdrItemCode]'" required
                                        class="border border-gray-300 bg-gray-50 rounded-md w-full md:text-sm text-xs p-2"
                                        x-model="item.RdrItemCode" @change="
                                            let exists = items.some((i, idx) => i.RdrItemCode === item.RdrItemCode && idx !== index);
                                            if (exists) {
                                                alert('Barang sudah dipilih di baris lain!');
                                                item.RdrItemCode = '';
                                                $nextTick(() => initSelect(index, ''));
                                            }
                                        "></select>
                                </div>

                                <!-- Input lainnya -->
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="text-xs text-gray-600">Deskripsi</label>
                                        <input type="text" :name="'items[' + index + '][ItemName]'" x-model="item.ItemName"
                                            class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 md:text-sm text-xs" readonly>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Qty</label>
                                        <input type="number" :name="'items[' + index + '][RdrItemQuantity]'"
                                            x-model="item.RdrItemQuantity"
                                            class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 md:text-sm text-xs">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Harga</label>
                                        <input type="number" step="0.01" :name="'items[' + index + '][RdrItemPrice]'"
                                            x-model="item.RdrItemPrice"
                                            class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 md:text-sm text-xs">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Diskon</label>
                                        <input type="number" step="0.01" :name="'items[' + index + '][RdrItemDisc]'"
                                            x-model="item.RdrItemDisc" value="0"
                                            class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 md:text-sm text-xs">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Satuan</label>
                                        <input type="text" :name="'items[' + index + '][RdrItemSatuan]'"
                                            x-model="item.RdrItemSatuan"
                                            class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 md:text-sm text-xs" readonly>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Profit Center</label>
                                        <input type="text" :name="'items[' + index + '][RdrItemProfitCenter]'"
                                            x-model="item.RdrItemProfitCenter"
                                            class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 md:text-sm text-xs" readonly>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs text-gray-600">Ket HKN</label>
                                    <input type="text" :name="'items[' + index + '][RdrItemKetHKN]'"
                                        x-model="item.RdrItemKetHKN"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 md:text-sm text-xs" readonly>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Ket FG</label>
                                    <input type="text" :name="'items[' + index + '][RdrItemKetFG]'"
                                        x-model="item.RdrItemKetFG"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 md:text-sm text-xs" readonly>
                                </div>

                                <!-- Tombol hapus -->
                                <div class="flex justify-end mt-2">
                                    <div class="text-right border rounded-lg bg-gray-500 hover:bg-gray-400 text-white w-fit">
                                        <button type="button" @click="
                                            if (items.length > 1) {
                                                items.splice(index, 1);
                                            } else {
                                                alert('Minimal harus ada 1 barang dalam pesanan!');
                                            }"
                                            class="text-sm px-3 py-1.5 rounded flex items-center gap-1">
                                            <i class="ri-close-circle-fill"></i> Hapus Barang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>


                    <!-- Tombol tambah item -->
                    <button type="button"
                        @click="items.push({
                            RdrItemCode:'', ItemName:'', RdrItemQuantity:1, RdrItemPrice:0,
                            RdrItemSatuan:'', RdrItemProfitCenter:'', RdrItemKetHKN:'', RdrItemKetFG:'', open:true
                        });
                        $nextTick(() => initSelect(items.length-1))"
                        class="w-fit p-2 bg-green-600 hover:bg-green-400 text-white py-2 rounded-lg text-sm">
                        <i class="ri-add-circle-fill"></i> Tambah Barang
                    </button>

                    <!-- Tombol submit -->
                    <button type="submit"
                        class="w-full bg-red-800 hover:bg-red-500 text-white py-2 rounded-lg text-sm font-medium">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layout>
<script>
    async function initSelect(index) {
        let response = await fetch('/barang/api');
        let data = await response.json();

        let select = document.getElementById('itemSelect' + index);

        new TomSelect(select, {
            valueField: 'ItemCode',
            labelField: 'ItemLabel',
            searchField: ['ItemCode', 'FrgnName'],
            options: data,
            placeholder: 'Pilih item...',
            onChange: function(value) {
                let selected = this.options[value];
                if (selected) {
                    document.querySelector(`[name="items[${index}][ItemName]"]`).value = selected.FrgnName;
                    document.querySelector(`[name="items[${index}][RdrItemPrice]"]`).value = selected.HET;
                    document.querySelector(`[name="items[${index}][RdrItemProfitCenter]"]`).value = selected.ProfitCenter;
                    document.querySelector(`[name="items[${index}][RdrItemSatuan]"]`).value = selected.Satuan;
                    document.querySelector(`[name="items[${index}][RdrItemKetHKN]"]`).value = selected.KetHKN;
                    document.querySelector(`[name="items[${index}][RdrItemKetFG]"]`).value = selected.KetFG;

                    // 🔁 Tambahkan sinkronisasi ke Alpine reaktif
                    let alpineScope = document.querySelector(`#itemSelect${index}`).closest('[x-data]');
                    let item = Alpine.$data(alpineScope).items[index];
                    item.ItemName = selected.FrgnName;
                    item.RdrItemPrice = selected.HET;
                    item.RdrItemProfitCenter = selected.ProfitCenter;
                    item.RdrItemSatuan = selected.Satuan;
                    item.RdrItemKetHKN = selected.KetHKN;
                    item.RdrItemKetFG = selected.KetFG;

                    // Trigger update untuk input
                    let el = document.querySelector(`#itemSelect${index}`);
                    el.dispatchEvent(new Event('input'));
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initSelect(0);
    });
</script>
