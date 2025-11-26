<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> <?php echo e($title); ?> <?php $__env->endSlot(); ?>
     <?php $__env->slot('titleHeader', null, []); ?> <?php echo e($titleHeader); ?> <?php $__env->endSlot(); ?>

    <?php if(session()->has('success')): ?>
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('order')); ?>"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-800">
                        <i class="ri-bill-fill"></i> Daftar Pesanan
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-add-box-fill text-red-800"></i> <?php echo e($titleHeader); ?>

                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Form -->
        <form class="mx-auto" action="<?php echo e(route('order.store')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="">
                <!-- Customer Info -->
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrCrdCode" class="mb-2 text-sm font-medium text-gray-700">Kode Pelanggan</label>
                        <input type="text" id="OdrCrdCode" name="OdrCrdCode"
                            value="<?php echo e(old('OdrCrdCode', $dataOrder['OdrCrdCode'])); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        <?php $__errorArgs = ['OdrCrdCode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <input type="text" value="<?php echo e(old('CstName', $cust->CardName)); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        <?php $__errorArgs = ['CstName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrRefNum" class="mb-2 text-sm font-medium text-gray-700">No Ref SO</label>
                        <input type="text" id="OdrRefNum" name="OdrRefNum"
                            value="<?php echo e(old('OdrRefNum', $dataOrder['OdrRefNum'])); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        <?php $__errorArgs = ['OdrRefNum'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Tanggal SO</label>
                        <input type="date" name="OdrDocDate"
                            value="<?php echo e(old('OdrDocDate', $dataOrder['OdrDocDate'])); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        <?php $__errorArgs = ['OdrDocDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="branch" class="mb-2 text-sm font-medium text-gray-700">Cabang</label>
                        <select id="branch" name="branch" required
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Pilih Cabang</option>
                            <?php $__currentLoopData = $userBranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch); ?>" <?php echo e(old('branch') == $branch ? 'selected' : ''); ?>>
                                    <?php echo e($branch); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['branch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Piutang JT</label>
                        <?php
                            $piutangJT = $dataOrder['PiutangJT'] ?? 0;
                            $piutangClass = $piutangJT > 0
                                ? 'border-red-500 bg-red-100 text-red-700 font-semibold'
                                : 'border-gray-300 text-gray-700';
                        ?>
                        <input type="text"
                            value="<?php echo e(number_format($piutangJT, 0, '.', ',')); ?>"
                            autocomplete="off"
                            class="bg-gray-50 <?php echo e($piutangClass); ?> border rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                        <?php $__errorArgs = ['CstName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="mb-2 text-sm font-medium text-gray-700">Catatan</label>
                    <input type="text" name="note" autocomplete="off" value="<?php echo e(old('note')); ?>" 
                        class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <input type="hidden" name="OdrSlpCode" value="<?php echo e($dataOrder['OdrSlpCode']); ?>">
                <input type="hidden" name="OdrNum" value="<?php echo e($dataOrder['OdrNum']); ?>">

                <!-- Detail Barang -->
                <h3 class="text-base font-semibold mb-2 text-gray-800">Detail Barang</h3>

                <div 
                    x-data="{
                        items: [{
                            RdrItemCode: '', ItemName: '', RdrItemQuantity: 1, RdrItemPrice: 0,
                            RdrItemSatuan: '', RdrItemProfitCenter: '', RdrItemKetHKN: '', RdrItemKetFG: '', open: true
                        }]
                    }" 
                    class="space-y-3"
                >
                    <template x-for="(item, index) in items" :key="index">
                        
                        <!-- ADD: Border merah jika belum lengkap -->
                        <div 
                            class="border bg-white rounded-lg shadow-sm"
                            :class="(!item.RdrItemCode || !item.RdrItemQuantity || !item.RdrItemPrice) 
                                        ? 'border-red-500' 
                                        : 'border-gray-200'"
                        >

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
                                        x-model="item.RdrItemCode" 
                                        @change="
                                            let exists = items.some((i, idx) => i.RdrItemCode === item.RdrItemCode && idx !== index);
                                            if (exists) {
                                                alert('Barang sudah dipilih di baris lain!');
                                                item.RdrItemCode = '';
                                                $nextTick(() => initSelect(index, ''));
                                            }
                                        "
                                    ></select>
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
                                            x-model="item.RdrItemQuantity" required
                                            class="w-full border border-gray-300 bg-gray-50 rounded-md p-2 md:text-sm text-xs">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Harga</label>
                                        <input type="number" step="0.01" :name="'items[' + index + '][RdrItemPrice]'"
                                            x-model="item.RdrItemPrice" required
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
                        @click="
                            items.push({
                                RdrItemCode:'', ItemName:'', RdrItemQuantity:1, RdrItemPrice:0,
                                RdrItemSatuan:'', RdrItemProfitCenter:'', RdrItemKetHKN:'', RdrItemKetFG:'', open:true
                            });

                            $nextTick(() => initSelect(items.length - 1));

                            // Alert ketika kelipatan 3
                            if (items.length % 10 === 0) {
                                alert(
                                    `Pengingat: Anda sudah memilih ${items.length} barang.\n\n` + 
                                    `Simpan pesanan terlebih dahulu untuk menghindari logout otomatis.`
                                );
                            }
                        "
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>

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

                /* ADD: Cek duplikasi item */
                let alpineRoot = document.querySelector('#itemSelect' + index).closest('[x-data]');
                let items = Alpine.$data(alpineRoot).items;

                let duplicate = items.some((i, idx) => i.RdrItemCode === value && idx !== index);
                if (duplicate) {
                    alert('Barang tidak boleh duplikat!');
                    this.clear();
                    return;
                }

                let selected = this.options[value];
                if (selected) {

                    document.querySelector(`[name="items[${index}][ItemName]"]`).value = selected.FrgnName;
                    document.querySelector(`[name="items[${index}][RdrItemPrice]"]`).value = selected.HET;
                    document.querySelector(`[name="items[${index}][RdrItemProfitCenter]"]`).value = selected.ProfitCenter;
                    document.querySelector(`[name="items[${index}][RdrItemSatuan]"]`).value = selected.Satuan;
                    document.querySelector(`[name="items[${index}][RdrItemKetHKN]"]`).value = selected.KetHKN;
                    document.querySelector(`[name="items[${index}][RdrItemKetFG]"]`).value = selected.KetFG;

                    let alpineScope = Alpine.$data(alpineRoot).items[index];
                    alpineScope.ItemName = selected.FrgnName;
                    alpineScope.RdrItemPrice = selected.HET;
                    alpineScope.RdrItemProfitCenter = selected.ProfitCenter;
                    alpineScope.RdrItemSatuan = selected.Satuan;
                    alpineScope.RdrItemKetHKN = selected.KetHKN;
                    alpineScope.RdrItemKetFG = selected.KetFG;

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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/ordr/ordr_create.blade.php ENDPATH**/ ?>