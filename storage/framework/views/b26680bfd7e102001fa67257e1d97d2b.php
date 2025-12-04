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
            <form action="<?php echo e(route('report.piutang-45-hari')); ?>" method="get" class="flex items-center gap-2 w-full md:w-auto">
                <label for="search" class="sr-only">Cari Pelanggan</label>
                <div class="relative w-full md:w-96">
                    <input type="text" id="search" name="search"
                        value="<?php echo e(request('search')); ?>"
                        class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-50 border-gray-300 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200"
                        placeholder="Cari Pelanggan..." />
                    <button type="submit"
                        class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                        <i class="ri-search-eye-fill"></i>
                    </button>
                </div>
            </form>

            <!-- 🔧 Form Filter & Sinkronisasi (Kanan) -->
            <div class="flex flex-col sm:flex-col md:flex-row md:items-center md:justify-end gap-3 w-full md:w-auto">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard.refresh')): ?>
                <!-- 🔴 Sinkronisasi SAP -->
                <div class="flex items-center">
                    <a href="<?php echo e(route('report.refresh.piutang-45-hari')); ?>"
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
                Belum pernah disinkronkan
            <?php endif; ?>
        </div> 
        <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Pencapaian Penjualan per Penjual periode</h5></div>
            <div class="grid md:grid-cols-3 gap-2">
                <?php $__currentLoopData = $groupedSum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border rounded-lg shadow-sm bg-white mb-4">
                        <div class="bg-gray-100 rounded-t-lg border-b">
                            <h3 class="font-bold text-red-800 px-4 py-2">
                                <?php echo e($key['headerkey']); ?>

                            </h3>
                        </div>

                        <div class="px-2 py-2">
                            <?php $__currentLoopData = $key['ket2']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ket2Key => $ket2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <ul class="py-1">
                                    <li class="text-sm">
                                        <?php echo e($ket2Key); ?> :
                                        <strong><?php echo e(number_format($ket2['total'], 1, '.', ',')); ?></strong>
                                    </li>
                                </ul>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <hr class="my-2">

                            <div class="text-right font-bold text-sm">
                                Total keseluruhan:
                                <strong><?php echo e(number_format($key['total_all'], 1, '.', ',')); ?></strong>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="grid md:grid-cols-2 gap-2">
                <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $custs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-2 border border-gray-200 rounded-lg overflow-x-auto bg-white">
                        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg max-h-96">
                            <table class="table-auto w-full text-sm text-left rtl:text-right text-gray-600">
                                <thead class="text-xs font-bold text-white uppercase bg-red-800 sticky top-0 z-20">
                                    <tr>
                                        <td colspan="3" class="text-center py-2"><?php echo e($key); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="px-2 py-2 text-center w-8/12">PELANGGAN</th>
                                        <th class="px-2 py-2 text-center w-2/12">LEWAT HARI</th>
                                        <th class="px-2 py-2 text-center w-2/12">PIUTANG</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    
                                    <?php $__currentLoopData = $custs['ket2']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ket2Name => $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="text-center bg-gray-100 text-gray-800 font-semibold">
                                            <td colspan="3"><?php echo e($ket2Name); ?></td>
                                        </tr>

                                        
                                        <?php $__currentLoopData = $cust['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-gray-50 border-t">
                                                <td class="px-2 py-2 font-medium text-gray-700"><?php echo e($row->NAMACUST); ?> - <?php echo e($row->KODECUST); ?> - <?php echo e($row->CABANG); ?></td>
                                                <td class="px-2 py-2 font-medium text-gray-700"><?php echo e($row->LEWATHARI); ?> hari</td>
                                                <td class="px-2 py-2 text-right font-medium text-gray-700">
                                                    <?php echo e(number_format($row->PIUTANG)); ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        
                                        <tr class="bg-gray-50 font-bold text-gray-800">
                                            <td class="px-4 py-2 border-t" colspan="2">Total <?php echo e($ket2Name); ?></td>
                                            <td class="px-2 py-2 border-t text-right">
                                                <?php echo e(number_format($cust['total_ket2'])); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <tr class="bg-red-800 font-bold text-white">
                                        <td class="px-2 py-2 border-t" colspan="2">TOTAL <?php echo e($key); ?></td>
                                        <td class="px-2 py-2 border-t text-right">
                                            <?php echo e(number_format($custs['total_key'])); ?>

                                        </td>
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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/reports/piutang_45_hari.blade.php ENDPATH**/ ?>