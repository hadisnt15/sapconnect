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
            <form action="<?php echo e(route('report.bulanan-dan-average')); ?>" method="get" class="flex items-center gap-2 w-full md:w-auto">
                <div>
                    <select name="segment" onchange="this.form.submit()" 
                        class="bg-gray-50 border border-gray-300 text-xs rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 py-2 px-2 w-full">
                        <!--  -->
                        <option value="">Semua Segment</option>
                        <?php $__currentLoopData = $segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($segment->SEGMENT); ?>" <?php echo e($segmentFilter == $segment->SEGMENT ? 'selected' : ''); ?>>
                                <?php echo e($segment->SEGMENT); ?>

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
                <form method="POST" action="<?php echo e(route('report.refresh.bulanan-dan-average')); ?>" 
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
        
        <!-- DESKTOP -->
        <div class="hidden md:block p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Laporan Pencapaian Pelanggan Periode <?php echo e($namaPeriode); ?> dan Rata-rata 3 Bulan Terakhir</h5></div>
            <div class="border border-gray-200 rounded-lg overflow-x-auto max-h-[600px] bg-white shadow-sm mb-8 sm:rounded-lg">
                <table class="table w-full text-xs text-gray-600">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800 sticky top-0 z-20">
                        <tr>
                            <th class="px-2 py-2">SEGMENT</th>
                            <th class="px-2 py-2">PELANGGAN</th>
                            <th class="px-2 py-2">PENJUAL</th>
                            <th class="px-2 py-2">KOTA / PROVINSI</th>
                            <?php $__currentLoopData = $bulanHeaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="px-2 py-2 text-center"><?php echo e($bulan); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="border-b px-2 py-2"><?php echo e($row['SEGMENT']); ?></td>
                            <td class="border-b px-2 py-2"><?php echo e($row['KODECUSTOMER']); ?> <br> <?php echo e($row['NAMACUSTOMER']); ?></td>
                            <td class="border-b px-2 py-2"><?php echo e($row['NAMASALES']); ?></td>
                            <td class="border-b px-2 py-2"><?php echo e($row['KOTA']); ?> <br> <?php echo e($row['PROVINSI']); ?></td>
                            <?php $__currentLoopData = $bulanHeaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="border-b px-2 py-2 text-right">
                                    <?php echo e(number_format((float) str_replace(',', '', $row[$bulan]), 2)); ?>

                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <?php if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                    <?php echo e($customers->appends(request()->query())->links('pagination::tailwind')); ?>

                <?php endif; ?>
            </div>
        </div>
        
        <!-- MOBILE -->
        <div class="md:hidden block p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Laporan Pencapaian Pelanggan Periode <?php echo e($namaPeriode); ?> dan Rata-rata 3 Bulan Terakhir</h5></div>
            <div class="border border-gray-200 rounded-lg overflow-x-auto max-h-[600px] bg-white shadow-sm mb-8 sm:rounded-lg">
                <table class="table w-full text-xs text-gray-600">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800 sticky top-0 z-20">
                        <tr>
                            <th class="px-2 py-2">SEGMENT / PELANGGAN / PENJUAL / ALAMAT</th>
                            <th class="px-2 py-2 text-center">
                                PENCAPAIAN
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="border-b px-2 py-2">
                                <?php echo e($row['SEGMENT']); ?> <br><br> 
                                Pelanggan: <br> <?php echo e($row['KODECUSTOMER']); ?> <br> <?php echo e($row['NAMACUSTOMER']); ?> <br><br> 
                                Penjual: <br> <?php echo e($row['NAMASALES']); ?> <br><br>
                                Alamat: <br> <?php echo e($row['KOTA']); ?> <br> <?php echo e($row['PROVINSI']); ?>

                            </td>
                            <td class="border-b px-2 py-2">
                                <?php $__currentLoopData = $bulanHeaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($bulan); ?>: <?php echo e(number_format((float) str_replace(',', '', $row[$bulan]), 2)); ?> <br><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <?php if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                    <?php echo e($customers->appends(request()->query())->links('pagination::tailwind')); ?>

                <?php endif; ?>
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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/reports/bulanan_dan_average.blade.php ENDPATH**/ ?>