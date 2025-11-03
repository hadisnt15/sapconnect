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
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-300 py-2 px-2 bg-white">
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-settings-4-fill"></i> <?php echo e($titleHeader); ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4 items-center pb-4 w-full">
            <div>
                <form action="" method="get">
                    <label for="search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <input type="text" id="search" name="search"
                            class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-100 border-gray-400 placeholder-gray-500 text-gray-900 focus:ring-indigo-600 focus:border-indigo-600"
                            placeholder="Cari Barang" required/>
                        <button type="submit"
                            class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500 focus:ring-2 focus:ring-indigo-500">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto">
                <?php if(in_array(auth()->user()->role, ['developer', 'manager', 'supervisor'])): ?>
                <div class="flex items-center">
                    <a href="<?php echo e(route('item.refresh')); ?>"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-sm font-bold text-gray-500 mb-2">
            <?php if($lastSync): ?>
                Terakhir Disinkronkan: 
                <?php echo e(\Carbon\Carbon::parse($lastSync->last_sync)->timezone('Asia/Makassar')->format('d-m-Y H:i:s')); ?> WITA 
                (<?php echo e($lastSync->desc); ?>)
            <?php else: ?>
                Belum Pernah Disinkronkan
            <?php endif; ?>
        </div>    

        
        <div class="grid md:grid-cols-4 gap-3">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="p-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 transition">
                    <div class="flex justify-between items-center mb-1 text-gray-500">
                        <span
                            class="text-xs font-bold border border-gray-400 me-2 px-2.5 py-0.5 rounded-lg bg-white text-red-800">
                            <?php if($i->div_name === 'SPR'): ?>
                            <?php echo e($i->Segment); ?> - <?php echo e($i->Type); ?> - <?php echo e($i->Series); ?>

                            <?php elseif(Str::contains($i->div_name, 'LUB')): ?>
                            <?php echo e($i->Brand); ?> - <?php echo e($i->Series); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <h5 class="font-bold tracking-tight text-gray-800">
                        <?php echo e($i->ItemCode); ?></h5>
                    <div class="mb-2 border-b border-gray-300">
                        <p class="text-sm font-medium text-gray-600"><?php echo e(Str::limit($i->FrgnName, 30)); ?></p>
                    </div>
                    <div class="grid grid-cols-2 text-gray-700 text-sm">
                        <div>
                            <p>Stok: <?php echo e($i->TotalStock); ?></p>
                            <p>HET: <?php echo e(number_format($i->HET, 0, ',', '.')); ?></p>
                        </div>
                        <div>
                            <p>Status FG: <?php echo e($i->StatusFG); ?></p>
                            <p>Status HKN: <?php echo e($i->StatusHKN); ?></p>
                        </div>
                    </div>
                    <button data-modal-target="oitm-view" data-modal-toggle="oitm-view" type="button"
                        class="open-modal-oitm-btn flex ml-auto mt-2"
                        data-ItemCode="<?php echo e($i->ItemCode); ?>"
                        data-ItemName="<?php echo e($i->FrgnName); ?>"
                        data-ProfitCenter="<?php echo e($i->ProfitCenter); ?>"
                        data-Segment="<?php echo e($i->Segment); ?>"
                        data-Type="<?php echo e($i->Type); ?>"
                        data-Series="<?php echo e($i->Series); ?>"
                        data-KetHKN="<?php echo e(e($i->KetHKN)); ?>"
                        data-KetFG="<?php echo e(e($i->KetFG)); ?>"
                        data-KetStock="<?php echo e(e($i->KetStock)); ?>"
                        data-HET="<?php echo e(number_format($i->HET, 0, ',', '.')); ?>"
                        data-TotalStock="<?php echo e($i->TotalStock); ?>"
                        data-StatusFG="<?php echo e($i->StatusFG); ?>"
                        data-StatusHKN="<?php echo e($i->StatusHKN); ?>">
                        <span
                            class="border text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg bg-red-800 hover:bg-red-500 text-white transition">
                            <i class="ri-eye-fill"></i> Detail
                        </span>
                    </button>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        

        <div class="mt-5 text-gray-700">
            <?php echo e($items->links()); ?>

        </div>
    </div>

    <!-- Item Modal View -->
    <div id="oitm-view" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <div class="relative rounded-lg shadow-md bg-gray-50 border border-gray-300">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                    <h3 class="text-lg font-medium text-gray-800">
                        <span id="modalProfitCenter"></span> - <span id="modalItemCode"></span>
                    </h3>
                    <button type="button"
                        class="text-gray-500 hover:text-indigo-600 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                        data-modal-hide="oitm-view">
                        ✕
                    </button>
                </div>
                <div class="px-4 md:px-5 py-3 space-y-2 text-sm text-gray-700">
                    <p>Deskripsi: <span class="font-medium" id="modalItemName"></span></p>
                    <p>Segmen: <span class="font-medium" id="modalSegment"></span></p>
                    <p>Tipe: <span class="font-medium" id="modalType"></span></p>
                    <p>Seri: <span class="font-medium" id="modalSeries"></span></p>
                    <p>Harga: <span class="font-medium" id="modalHET"></span></p>
                </div>
                <div class="p-4 md:p-5 space-y-2 text-sm text-gray-700">
                    <p>Keterangan FG: <span id="modalStatusFG" class="font-medium"></span></p>
                    <div class="ms-4 font-medium"><span id="modalKetFG"></span></div>

                    <p>Keterangan HKN: <span id="modalStatusHKN" class="font-medium"></span></p>
                    <div class="ms-4 font-medium"><span id="modalKetHKN"></span></div>

                    <p>Keterangan Stok: <span id="modalTotalStock" class="font-medium"></span></p>
                    <div class="ms-4 font-medium"><span id="modalKetStock"></span></div>
                </div>
            </div>
        </div>
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
    // Fungsi buka modal
    function openModalView(ItemCode, ItemName, Segment, Type, Series, ProfitCenter, KetHKN, KetFG, KetStock, HET,
        TotalStock, StatusHKN, StatusFG) {
        document.getElementById('modalItemCode').innerText = ItemCode;
        document.getElementById('modalItemName').innerText = ItemName;
        document.getElementById('modalSegment').innerText = Segment;
        document.getElementById('modalType').innerText = Type;
        document.getElementById('modalSeries').innerText = Series;
        document.getElementById('modalProfitCenter').innerText = ProfitCenter;
        document.getElementById('modalKetHKN').innerText = KetHKN;
        document.getElementById('modalKetFG').innerText = KetFG;
        document.getElementById('modalKetStock').innerText = KetStock;
        document.getElementById('modalHET').innerText = HET;
        document.getElementById('modalTotalStock').innerText = TotalStock;
        document.getElementById('modalStatusHKN').innerText = StatusHKN;
        document.getElementById('modalStatusFG').innerText = StatusFG;
        document.getElementById('oitm-view').classList.remove('hidden');
        document.getElementById('oitm-view').classList.add('flex');
    }

    // Saat DOM sudah siap
    document.addEventListener('DOMContentLoaded', function() {
        const buttonsView = document.querySelectorAll('.open-modal-oitm-btn');
        buttonsView.forEach(button => {
            button.addEventListener('click', function() {
                const ItemCode = this.getAttribute('data-ItemCode');
                const ItemName = this.getAttribute('data-ItemName');
                const Segment = this.getAttribute('data-Segment');
                const Type = this.getAttribute('data-Type');
                const Series = this.getAttribute('data-Series');
                const ProfitCenter = this.getAttribute('data-ProfitCenter');
                const KetHKN = this.getAttribute('data-KetHKN');
                const KetFG = this.getAttribute('data-KetFG');
                const KetStock = this.getAttribute('data-KetStock');
                const HET = this.getAttribute('data-HET');
                const TotalStock = this.getAttribute('data-TotalStock');
                const StatusHKN = this.getAttribute('data-StatusHKN');
                const StatusFG = this.getAttribute('data-StatusFG');
                openModalView(ItemCode, ItemName, Segment, Type, Series, ProfitCenter, KetHKN,
                    KetFG, KetStock, HET, TotalStock, StatusHKN, StatusFG);
            });
        });
    });
</script>
<?php /**PATH C:\laragon\www\sapconnect\resources\views/oitm/oitm.blade.php ENDPATH**/ ?>