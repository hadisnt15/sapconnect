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
                            <i class="ri-file-edit-fill text-red-800"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <form class="mx-auto" action="{{ route('order.update', $head->id) }}" method="post">
            @csrf @method('PUT')
            <div class="">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrCrdCode" class="mb-2 text-sm font-medium text-gray-700">Kode Pelanggan</label>
                        <input type="text" id="OdrCrdCode" name="OdrCrdCode"
                            value="{{ old('OdrCrdCode', $head['OdrCrdCode']) }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <input type="text" value="{{ old('CstName', $cust->CardName) }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrRefNum" class="mb-2 text-sm font-medium text-gray-700">No Referensi SO</label>
                        <input type="text" id="OdrRefNum" name="OdrRefNum"
                            value="{{ old('OdrRefNum', $head['OdrRefNum']) }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Tanggal SO</label>
                        <input type="text" name="OdrDocDate" value="{{ $OdrDocDate }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="branch" class="mb-2 text-sm font-medium text-gray-700">Cabang</label>
                        <select id="branch" name="branch" required
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @php
                                $branches = ['HO', 'BJN', 'BTL', 'SPT', 'PLB', 'PLK'];
                                $selectedBranch = old('branch', $head['branch'] ?? '');
                            @endphp
                            <option value="">-- Pilih Cabang --</option>
                            @foreach ($branches as $b)
                                <option value="{{ $b }}" {{ $selectedBranch == $b ? 'selected' : '' }}>
                                    {{ $b }}
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
                    <input type="text" name="note" value="{{ old('note', $head['note']) }}" autocomplete="off"
                        class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    @error('note')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="OdrSlpCode" value="{{ $head['OdrSlpCode'] }}">
                <input type="hidden" name="OdrNum" value="{{ $head['OdrNum'] }}">

                <!-- Detail Barang -->
                <h3 class="text-base font-semibold mb-2 text-gray-800">Detail Barang</h3>

                <div x-data="{ items: @js($rows) }" class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="border border-gray-200 bg-white rounded-lg p-3 shadow-sm space-y-2">
                            <div>
                                <label class="text-xs text-gray-600">Kode Barang</label>
                                <select :id="'itemSelect' + index" :name="'items[' + index + '][RdrItemCode]'" requiered
                                    class="border border-gray-300 bg-gray-50 rounded-md w-full text-sm p-2"
                                    x-model="item.RdrItemCode" x-init="$nextTick(() => initSelect(index, item.RdrItemCode))"
                                    @change="
                                        let exists = items.some((i, idx) => i.RdrItemCode === item.RdrItemCode && idx !== index);
                                        if (exists) {
                                            alert('Barang sudah dipilih di baris lain!');
                                            item.RdrItemCode = '';
                                            $nextTick(() => initSelect(index, ''));
                                        }
                                    "></select>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-xs text-gray-600">Deskripsi</label>
                                    <input type="text" :name="'items[' + index + '][ItemName]'"
                                        x-model="item.ItemName"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 text-sm" readonly>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Qty</label>
                                    <input type="number" :name="'items[' + index + '][RdrItemQuantity]'"
                                        x-model="item.RdrItemQuantity"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 text-sm">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Harga</label>
                                    <input type="number" step="0.01" :name="'items[' + index + '][RdrItemPrice]'"
                                        x-model="item.RdrItemPrice"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 text-sm">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Diskon</label>
                                    <input type="number" step="0.01" :name="'items[' + index + '][RdrItemDisc]'"
                                        x-model="item.RdrItemDisc"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 text-sm">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Satuan</label>
                                    <input type="text" :name="'items[' + index + '][RdrItemSatuan]'"
                                        x-model="item.RdrItemSatuan"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 text-sm" readonly>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Profit Center</label>
                                    <input type="text" :name="'items[' + index + '][RdrItemProfitCenter]'"
                                        x-model="item.RdrItemProfitCenter"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 text-sm" readonly>
                                </div>
                            </div>
                                <div>
                                    <label class="text-xs text-gray-600">Ket HKN</label>
                                    <input type="text" :name="'items[' + index + '][RdrItemKetHKN]'"
                                        x-model="item.RdrItemKetHKN"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 text-sm" readonly>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Ket FG</label>
                                    <input type="text" :name="'items[' + index + '][RdrItemKetFG]'"
                                        x-model="item.RdrItemKetFG"
                                        class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 text-sm" readonly>
                                </div>

                                <div class="flex justify-end mt-2">
                                    <div class="text-right border rounded-lg bg-gray-500 hover:bg-gray-400 text-white w-fit">
                                        <button type="button"
                                            @click="
                                                if (items.length > 1) {
                                                    items.splice(index, 1);
                                                } else {
                                                    alert('Minimal harus ada 1 barang dalam pesanan!');
                                                }
                                            "
                                            class="text-sm px-3 py-1.5 rounded flex items-center gap-1">
                                            <i class="ri-close-circle-fill"></i> Hapus Barang
                                        </button>
                                    </div>
                                </div>

                        </div>
                    </template>

                    <button type="button"
                        @click="items.push({RdrItemCode:'', ItemName:'', RdrItemQuantity:1, RdrItemPrice:0, RdrItemSatuan:'', RdrItemProfitCenter:'', RdrItemKetHKN:'', RdrItemKetFG:''});
                $nextTick(() => initSelect(items.length-1))"
                        class="w-fit p-2 bg-green-600 hover:bg-green-400 text-white py-2 rounded-lg text-sm">
                        <i class="ri-add-circle-fill"></i> Tambah Barang
                    </button>

                    <button type="submit"
                        class="w-full bg-red-800 hover:bg-red-500 text-white py-2 rounded-lg text-sm font-medium">
                        Perbarui Pesanan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layout>

<script>
    async function initSelect(index, selectedValue = null) {
        let response = await fetch('/barang/api');
        let data = await response.json();

        let select = document.getElementById('itemSelect' + index);

        let ts = new TomSelect(select, {
            valueField: 'ItemCode',
            labelField: 'ItemLabel',
            searchField: ['ItemCode', 'FrgnName'],
            options: data,
            placeholder: 'Pilih item...',
            onChange: function(value) {
                let selected = this.options[value];
                if (selected) {
                    document.querySelector(`[name="items[${index}][RdrItemCode]"]`).value = selected
                        .ItemCode;
                    document.querySelector(`[name="items[${index}][ItemName]"]`).value = selected
                        .FrgnName;
                    let priceInput = document.querySelector(`[name="items[${index}][RdrItemPrice]"]`);
                    // ✅ hanya set harga HET kalau masih kosong (tambah barang baru)
                    if (!priceInput.value || priceInput.value == "0") {
                        priceInput.value = selected.HET;
                    }
                    document.querySelector(`[name="items[${index}][RdrItemProfitCenter]"]`).value =
                        selected.ProfitCenter;
                    document.querySelector(`[name="items[${index}][RdrItemSatuan]"]`).value = selected
                        .Satuan;
                    document.querySelector(`[name="items[${index}][RdrItemKetHKN]"]`).value = selected
                        .KetHKN;
                    document.querySelector(`[name="items[${index}][RdrItemKetFG]"]`).value = selected
                        .KetFG;
                }
            }
        });

        if (selectedValue) {
            ts.setValue(selectedValue);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // inisialisasi semua select yang sudah ada di rows
        document.querySelectorAll('[id^="itemSelect"]').forEach((el, idx) => {
            let selected = @json(array_column($rows, 'RdrItemCode'));
            initSelect(idx, selected[idx] ?? null);
        });
    });
</script>
