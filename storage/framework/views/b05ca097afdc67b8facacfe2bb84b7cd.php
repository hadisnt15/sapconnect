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
    
    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('report')); ?>"
                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-red-600">
                        <i class="ri-folder-6-fill"></i> Daftar Laporan
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-folder-open-fill"></i> <?php echo e($titleHeader); ?>

                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard.refresh')): ?>
        <!-- Filter Bulan -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-end mb-4 gap-2">
            <form method="POST" action="<?php echo e(route('report.refresh.penjualan-lub-retail')); ?>" 
                class="mb-4 flex flex-col md:flex-row items-stretch md:items-center gap-2 w-full md:w-auto">
                <?php echo csrf_field(); ?>
                <div class="flex flex-col md:flex-row md:items-center gap-2 w-full md:w-auto">
                    <label for="month" class="text-xs font-medium text-gray-600">Pilih Bulan:</label>
                    <input 
                        type="month" 
                        id="month" 
                        name="month" 
                        value="<?php echo e(request('month', now()->format('Y-m'))); ?>"
                        class="border rounded-lg p-2 text-xs font-medium text-gray-700 border-gray-300 focus:ring focus:ring-red-200 w-full md:w-auto"
                    >
                </div>
                <button type="submit" 
                    class="text-xs w-full md:w-auto flex-shrink-0 rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-refresh-fill"></i> Sinkron
                </button>
            </form>
        </div>
        <?php endif; ?>
        <div class="text-sm font-bold text-gray-500 mb-2">
            <?php if($lastSync): ?>
                Terakhir Disinkronkan: 
                <?php echo e(\Carbon\Carbon::parse($lastSync->last_sync)->timezone('Asia/Makassar')->format('d-m-Y H:i:s')); ?> WITA 
                (<?php echo e($lastSync->desc); ?>)
            <?php else: ?>
                Belum pernah disinkronkan
            <?php endif; ?>
        </div> 
        
        <?php if(in_array(auth()->user()->role, ['developer', 'supervisor', 'manager'])): ?>
        <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <?php $__currentLoopData = $data->groupBy('TYPE'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-4">
                    <h5 class="text-gray-800 font-bold ms-4 mb-2">
                        Laporan Penjualan Lub Retail per <?php echo e(ucwords(strtolower($type))); ?> Periode <?php echo e($namaPeriode); ?>

                    </h5>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <?php $__currentLoopData = $items->groupBy('TYPE2'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type2 => $subitems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="hover:bg-gray-50 border border-gray-200 rounded-lg shadow-sm bg-white transition">

                            
                            <div class="mb-2 text-white font-bold border-b p-2 bg-red-800 rounded-t-lg">
                                <?php echo e($type2); ?>

                            </div>

                            
                            <div class="py-2 px-3">
                                <?php $__currentLoopData = $subitems->groupBy('TYPE3'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type3 => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span><?php echo e($type3); ?></span>
                                    <span class="font-semibold text-red-900">
                                        <?php echo e(number_format($rows->sum('LITER'))); ?> L
                                    </span>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            
                            <div class="py-2 px-3">
                                <div class="border-t mt-2 pt-1 text-sm font-bold text-gray-700 text-right">
                                    TOTAL <?php echo e($type2); ?>:
                                    <?php echo e(number_format($subitems->sum('LITER'))); ?> L
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <div class="mt-2 font-bold text-gray-800">
                TOTAL KESELURUHAN:
                <?php echo e(number_format($data->sum('LITER'))); ?> L
            </div>
        </div>
        <?php endif; ?>
        
        <?php if(in_array(auth()->user()->role, ['developer', 'supervisor', 'manager'])): ?>
        <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div>
                <h5 class="text-gray-800 font-bold ms-4 mb-4">
                    Top 10 Penjualan Cluster dan Non Cluster Periode <?php echo e($namaPeriode); ?>

                </h5>
            </div>

            <?php if($data2->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $data2->groupBy('type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg overflow-x-auto bg-white shadow-sm">
                            <div class="relative overflow-x-auto sm:rounded-lg">
                                <table class="table w-full text-xs text-left rtl:text-right text-gray-600">
                                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                                        <tr>
                                            <td colspan="4" class="text-center py-2"><?php echo e($type); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="px-2 py-2 text-center">No</th>
                                            <th class="px-2 py-2 text-center">Kode Pelanggan</th>
                                            <th class="px-2 py-2 text-center">Nama Pelanggan</th>
                                            <th class="px-2 py-2 text-center">Capaian Liter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-gray-50 border-t">
                                                <td class="px-2 py-2 text-center"><?php echo e($loop->iteration); ?></td>
                                                <td class="px-2 py-2 text-center"><?php echo e($row->cardcode ?? '-'); ?></td>
                                                <td class="px-2 py-2"><?php echo e($row->cardname ?? '-'); ?></td>
                                                <td class="px-2 py-2 text-right"><?php echo e(number_format($row->liter ?? 0)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-4">Tidak ada data ditemukan</p>
            <?php endif; ?>

        </div>
        <?php endif; ?>
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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/reports/penjualan_lub_retail.blade.php ENDPATH**/ ?>