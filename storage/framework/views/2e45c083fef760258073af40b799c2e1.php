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
                            <i class="ri-delete-back-2-fill text-red-800"></i> <?php echo e($titleHeader); ?>

                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <form class="mx-auto" action="<?php echo e(route('order.destroy', $head->id)); ?>" method="post">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="md:block hidden">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrCrdCode" class="mb-2 text-sm font-medium text-gray-700">Kode Pelanggan</label>
                        <input type="text" id="OdrCrdCode" name="OdrCrdCode"
                            value="<?php echo e(old('OdrCrdCode', $head['OdrCrdCode'])); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <input type="text" value="<?php echo e(old('CstName', $cust->CardName)); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrRefNum" class="mb-2 text-sm font-medium text-gray-700">No Ref SO</label>
                        <input type="text" id="OdrRefNum" name="OdrRefNum"
                            value="<?php echo e(old('OdrRefNum', $head['OdrRefNum'])); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Tanggal SO</label>
                        <input type="text" name="OdrDocDate" value="<?php echo e($OdrDocDate); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly />
                    </div>
                </div>

                <input type="hidden" name="OdrSlpCode" value="<?php echo e($head['OdrSlpCode']); ?>">
                <input type="hidden" name="OdrNum" value="<?php echo e($head['OdrNum']); ?>">

                <!-- Detail Barang -->
                <h3 class="text-base font-semibold mb-2 text-gray-800">Detail Barang</h3>
                <div class="border border-gray-200 rounded-lg overflow-x-auto bg-white">
                    <table class="table w-full text-xs text-left rtl:text-right text-gray-600">
                        <thead class="text-xs font-bold text-white uppercase bg-red-800">
                            <tr>
                                <th class="px-2 py-2 text-center w-1/12">No</th>
                                <th class="px-2 py-2 text-center w-3/12">Kode Barang</th>
                                <th class="px-2 py-2 text-center w-5/12">Nama Barang</th>
                                <th class="px-2 py-2 text-center w-1/12">Kuantitas</th>
                                <th class="px-2 py-2 text-center w-1/12">Harga</th>
                                <th class="px-2 py-2 text-center w-1/12">Diskon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-2 py-2 text-center"><?php echo e($loop->iteration); ?></td>
                                    <td class="px-2 py-2"><?php echo e($r['RdrItemCode']); ?></td>
                                    <td class="px-2 py-2"><?php echo e($r['ItemName']); ?></td>
                                    <td class="px-2 py-2 text-right"><?php echo e($r['RdrItemQuantity']); ?></td>
                                    <td class="px-2 py-2 text-right"><?php echo e($r['RdrItemPrice']); ?></td>
                                    <td class="px-2 py-2 text-right"><?php echo e($r['RdrItemDisc']); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="block md:hidden">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrCrdCode" class="mb-2 text-sm font-medium text-gray-700">Kode Pelanggan</label>
                        <input type="text" id="OdrCrdCode" name="OdrCrdCode"
                            value="<?php echo e(old('OdrCrdCode', $head['OdrCrdCode'])); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly disabled/>
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <input type="text" value="<?php echo e(old('CstName', $cust->CardName)); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly disabled/>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="mb-2">
                        <label for="OdrRefNum" class="mb-2 text-sm font-medium text-gray-700">No Ref SO</label>
                        <input type="text" id="OdrRefNum" name="OdrRefNum"
                            value="<?php echo e(old('OdrRefNum', $head['OdrRefNum'])); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly disabled/>
                    </div>
                    <div class="mb-2">
                        <label class="mb-2 text-sm font-medium text-gray-700">Tanggal SO</label>
                        <input type="text" name="OdrDocDate" value="<?php echo e($OdrDocDate); ?>" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            readonly disabled/>
                    </div>
                </div>

                <input type="hidden" name="OdrSlpCode" value="<?php echo e($head['OdrSlpCode']); ?>">
                <input type="hidden" name="OdrNum" value="<?php echo e($head['OdrNum']); ?>">

                <!-- Detail Barang -->
                <h3 class="text-base font-semibold mb-2 text-gray-800">Detail Barang Pesanan</h3>
                <div class="border border-gray-200 rounded-lg overflow-x-auto bg-white">
                    <table class="table w-full text-xs text-left rtl:text-right text-gray-600">
                        <thead class="text-xs font-bold text-white uppercase bg-red-800">
                            <tr>
                                <th class="px-2 py-2 text-center w-1/12">No</th>
                                <th class="px-2 py-2 text-center w-11/12">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-2 py-2 text-center">
                                        <?php echo e($loop->iteration); ?>

                                    </td>
                                    <td class="px-2 py-2">
                                        Kode: <span class="font-bold"><?php echo e($r['RdrItemCode']); ?></span> <br> 
                                        Nama: <?php echo e($r['ItemName']); ?> <br>
                                        Kuantitas: <?php echo e($r['RdrItemQuantity']); ?> <?php echo e($r['RdrItemSatuan']); ?> <br>
                                        Harga: <?php echo e($r['RdrItemPrice']); ?> <br>
                                        Diskon: <?php echo e($r['RdrItemDisc']); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit"
                class="w-full bg-red-800 hover:bg-red-500 text-white py-2 mt-2 rounded-lg text-sm font-medium">
                Hapus Pesanan
            </button>
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
    async function initSelect(index, selectedValue = null) {
        let response = await fetch('/barang/api');
        let data = await response.json();

        let select = document.getElementById('itemSelect' + index);

        let ts = new TomSelect(select, {
            valueField: 'ItemCode',
            labelField: 'ItemLabel',
            searchField: ['ItemCode', 'ItemName'],
            options: data,
            placeholder: 'Pilih item...',
            onChange: function(value) {
                let selected = this.options[value];
                if (selected) {
                    document.querySelector(`[name="items[${index}][RdrItemCode]"]`).value = selected
                        .ItemCode;
                    document.querySelector(`[name="items[${index}][ItemName]"]`).value = selected
                        .ItemName;
                    document.querySelector(`[name="items[${index}][RdrItemPrice]"]`).value = selected
                        .HET;
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
            let selected = <?php echo json_encode(array_column($rows, 'RdrItemCode'), 512) ?>;
            initSelect(idx, selected[idx] ?? null);
        });
    });
</script>
<?php /**PATH C:\laragon\www\sapconnect\resources\views/ordr/ordr_delete.blade.php ENDPATH**/ ?>