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
            <form action="<?php echo e(route('report.penjualan-industri-per-grup')); ?>" method="get" class="flex items-center gap-2 w-full md:w-auto">
                <div>
                    <select name="period" onchange="this.form.submit()" 
                        class="bg-gray-50 border border-gray-300 text-xs rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 py-2 px-2 w-full">
                        <!--  -->
                        <option value="">Bulan Tersedia</option>
                        <?php $__currentLoopData = $availablePeriods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>" <?php echo e($selectedPeriod == $p ? 'selected' : ''); ?>>
                                <?php echo e($p); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
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
                <form method="POST" action="<?php echo e(route('report.refresh.penjualan-industri-per-grup')); ?>" 
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
        
        <?php if(in_array(auth()->user()->role, ['developer', 'supervisor', 'manager'])): ?>
        <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div>
                <h5 class="text-gray-800 font-bold ms-4 mb-4">
                    Penjualan Industri per Grup Periode <?php echo e($namaPeriode); ?>

                </h5>
            </div>

            <?php if($data->count() > 0): ?>
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <?php $__currentLoopData = $typeTotal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border rounded-lg shadow-sm">
                            <div class="bg-gray-100 rounded-t-lg border-b px-4 py-2"><span class="font-bold text-red-800"><?php echo e($type); ?></span></div>    
                            <div class="text-2xl font-bold text-gray-700 text-right px-4 py-2"><?php echo e(number_format($total,2)); ?> KL</div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-6 border rounded-lg shadow-sm bg-white">
                            <div class="bg-gray-100 rounded-t-lg border-b px-4 py-2">
                                <span class="font-bold text-red-800"><?php echo e($type); ?> </span>
                                <span class="font-semibold text-red-800"><?php echo e($group); ?></span>
                            </div>
                            <div class="p-4 overflow-y-auto max-h-80">
                                <table class="w-full text-xs border border-gray-300">
                                    <thead class="bg-gray-200 text-gray-700 text-center">
                                        <tr>
                                            <th class="border px-2 py-1">#</th>
                                            <th class="border px-2 py-1 w-2/6">KODE PELANGGAN</th>
                                            <th class="border px-2 py-1 w-3/6">NAMA PELANGGAN</th>
                                            <th class="border px-2 py-1 w-1/6">CAPAIAN KL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $rows['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="border px-2 py-1"><?php echo e($loop->iteration); ?></td>
                                            <td class="border px-2 py-1"><?php echo e($row->CARDCODE); ?></td>
                                            <td class="border px-2 py-1"><?php echo e($row->CARDNAME); ?></td>
                                            <td class="border px-2 py-1 text-right"><?php echo e(number_format($row->KILOLITER,2)); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700">
                                            <th colspan="3" class="border px-2 py-1 text-left">TOTAL <?php echo e($type); ?> <?php echo e($group); ?></th>
                                            <th class="border px-2 py-1 text-right"><?php echo e(number_format($rows['total'], 2)); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/reports/ids_grup.blade.php ENDPATH**/ ?>