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
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
            <!-- 🔍 Form Pencarian (Kiri) -->
            <form action="<?php echo e(route('report.pencapaian-penjualan-sparepart-per-sales')); ?>" method="get" class="flex items-center gap-2 w-full md:w-auto">
                <div>
                    <select name="period" onchange="this.form.submit()" 
                        class="bg-gray-50 border border-gray-300 text-xs rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 py-2 px-2 w-full">
                        <!--  -->
                        <option value="">Periode Tersedia</option>
                        <?php $__currentLoopData = $availablePeriods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>" <?php echo e($selectedPeriod == $p ? 'selected' : ''); ?>>
                                <?php echo e($p); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </form>

            <!-- 🔧 Form Filter & Sinkronisasi (Kanan) -->
            <div class="flex flex-col sm:flex-col md:flex-row md:items-center md:justify-end gap-3 w-full md:w-auto">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard.refresh')): ?>
                <!-- 🔴 Sinkronisasi SAP -->
                <form method="POST" action="<?php echo e(route('report.refresh.pencapaian-penjualan-sparepart-per-sales')); ?>" 
                    class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    <?php echo csrf_field(); ?>
                    <input 
                        type="month" 
                        id="month" 
                        name="month" 
                        value="<?php echo e(request('month', now()->format('Y-m'))); ?>"
                        class="border rounded-lg p-2 text-xs font-medium text-gray-700 border-gray-300 focus:ring focus:ring-red-200 w-full"
                    >

                    <button type="submit" 
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white flex items-center justify-center gap-1 w-full md:w-auto">
                        <i class="ri-refresh-fill"></i> Sinkron
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-sm font-bold text-gray-500 mb-2">
            <?php if($lastSync): ?>
                Terakhir Disinkronkan: 
                <?php echo e(\Carbon\Carbon::parse($lastSync->last_sync)->timezone('Asia/Makassar')->format('d-m-Y H:i:s')); ?> WITA 
                (<?php echo e($lastSync->desc); ?>)
            <?php else: ?>
                Belum pernah disinkronkan
            <?php endif; ?>
        </div> 
        <div class="md:block hidden p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Pencapaian Penjualan per Penjual periode <?php echo e($namaPeriode); ?></h5></div>
            <div class="grid md:grid-cols-2 gap-3">
                <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesName => $segments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-2 border border-gray-200 rounded-lg overflow-x-auto bg-white">
                        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg">
                            <table class="table-auto w-full text-sm text-left rtl:text-right text-gray-600">
                                <thead class="text-xs font-bold text-white uppercase bg-red-800">
                                    <tr>
                                        <td colspan="4" class="text-center py-2"><?php echo e($salesName); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="px-2 py-2 text-center">TIPE</th>
                                        <th class="px-2 py-2 text-center">TARGET</th>
                                        <th class="px-2 py-2 text-center">CAPAI</th>
                                        <th class="px-2 py-2 text-center">PERSENTASE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segmentName => $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="text-center bg-gray-100 text-gray-800 font-semibold">
                                            <td colspan="4"><?php echo e($segmentName); ?></td>
                                        </tr>
                                        <?php $__currentLoopData = $segment['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-gray-50 border-t">
                                                <td class="px-2 py-2 font-medium text-gray-700"><?php echo e($row->TYPE); ?></td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700"><?php echo e(number_format($row->TARGET)); ?></td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700"><?php echo e(number_format($row->CAPAI)); ?></td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700"><?php echo e($row->PERSENTASE); ?>%</td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="bg-gray-50 font-bold text-gray-800">
                                            <td class="px-2 py-2 border-t">Total <?php echo e($segmentName); ?></td>
                                            <td class="px-2 py-2 text-right border-t"><?php echo e(number_format($segment['sum_target'], 0, '.', ',')); ?></td>
                                            <td class="px-2 py-2 text-right border-t"><?php echo e(number_format($segment['sum_capai'], 0, '.', ',')); ?></td>
                                            <td class="px-2 py-2 border-t"></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $firstRow = $segments->flatten()->first();
                                    ?>
                                    <tr class="bg-indigo-50 font-bold text-red-900">
                                        <td class="px-2 py-2 border-t">TOTAL SEMUA</td>
                                        <td class="px-2 py-2 text-right border-t"><?php echo e(number_format($firstRow->SUMTARGETSPR ?? 0, 0, '.', ',')); ?></td>
                                        <td class="px-2 py-2 text-right border-t"><?php echo e(number_format($firstRow->SUMCAPAISPR ?? 0, 0, '.', ',')); ?></td>
                                        <td class="px-2 py-2 text-right border-t"><?php echo e($firstRow->SUMPERSENTASE); ?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="block md:hidden p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Pencapaian Penjualan per Penjual periode <?php echo e($namaPeriode); ?></h5></div>
            <div class="">
                <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesName => $segments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class=" mb-2 border border-gray-200 rounded-lg overflow-x-auto bg-white">
                        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg">
                            <table class="table w-full text-xs text-left rtl:text-right text-gray-600">
                                <thead class="text-xs font-bold text-white uppercase bg-red-800">
                                    <tr>
                                        <td colspan="3" class="text-center py-2"><?php echo e($salesName); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="px-2 py-2 text-center">KET</th>
                                        <th class="px-2 py-2 text-center">CAPAI/TARGET</th>
                                        <th class="px-2 py-2 text-center">PERSENTASE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segmentName => $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="text-center bg-gray-100 text-gray-800 font-semibold">
                                            <td colspan="3"><?php echo e($segmentName); ?></td>
                                        </tr>
                                        <?php $__currentLoopData = $segment['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class=" bg-gray-100 text-gray-800 font-semibold">
                                                <td colspan="3" class="font-medium text-gray-700">TIPE: <?php echo e($row->TYPE); ?></td>
                                            </tr>
                                            <tr class="hover:bg-gray-50 border-t">
                                                <td class="px-2 py-2 font-medium text-gray-700">CAPAI <br> TARGET</td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700"><?php echo e(number_format($row->CAPAI)); ?> <br> <?php echo e(number_format($row->TARGET)); ?></td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700"><?php echo e($row->PERSENTASE); ?>%</td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="bg-gray-50 font-bold text-gray-800">
                                            <td class="px-2 py-2 border-t">Total <?php echo e($segmentName); ?></td>
                                            <td class="px-2 py-2 text-right border-t"><?php echo e(number_format($segment['sum_capai'], 0, ',', '.')); ?><br><?php echo e(number_format($segment['sum_target'], 0, ',', '.')); ?></td>
                                            
                                            <td class="px-2 py-2 border-t"></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $firstRow = $segments->flatten()->first();
                                    ?>
                                    <tr class="bg-indigo-50 font-bold text-red-900">
                                        <td class="px-2 py-2 border-t">TOTAL SEMUA</td>
                                        <td class="px-2 py-2 text-right border-t"><?php echo e(number_format($firstRow->SUMCAPAISPR ?? 0, 0, ',', '.')); ?><br><?php echo e(number_format($firstRow->SUMTARGETSPR ?? 0, 0, ',', '.')); ?></td>
                                        
                                        <td class="px-2 py-2 text-right border-t"><?php echo e($firstRow->SUMPERSENTASE); ?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/reports/penjualan_spr_sales.blade.php ENDPATH**/ ?>