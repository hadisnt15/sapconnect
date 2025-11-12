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
            <form action="<?php echo e(route('report.program-retail')); ?>" method="get" class="flex items-center gap-2 w-full md:w-auto">
                <div>
                    <select name="filter" onchange="this.form.submit()" 
                        class="bg-gray-50 border border-gray-300 text-xs rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 py-2 px-2 w-full">
                        <!--  -->
                        <option value="">SEMUA</option>
                        <option value="TERCAPAI" <?php echo e($filter == 'TERCAPAI' ? 'selected' : ''); ?>>TERCAPAI</option>
                        <option value="TARGET TIDAK ADA" <?php echo e($filter == 'TARGET TIDAK ADA' ? 'selected' : ''); ?>>TARGET TIDAK ADA</option>
                        <option value="BELUM TERCAPAI" <?php echo e($filter == 'BELUM TERCAPAI' ? 'selected' : ''); ?>>BELUM TERCAPAI</option>
                        <option value="BELUM TERDAFTAR" <?php echo e($filter == 'BELUM TERDAFTAR' ? 'selected' : ''); ?>>BELUM TERDAFTAR</option>
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
                <form method="POST" action="<?php echo e(route('report.refresh.program-retail')); ?>" 
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
        <div class="py-2 px-2 border rounded-lg">
            <div>
                <h5 class="text-gray-800 font-bold ms-4 mb-2">Rekap Pencapaian Program Pertamina Retail periode <?php echo e($namaPeriode); ?></h5>
            </div>
            <?php $__currentLoopData = $groupedSum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border rounded-lg shadow-sm bg-white mb-4">
                    <div class="bg-gray-100 rounded-t-lg border-b">
                        <h3 class="font-bold text-gray-700 px-4 py-2">
                            <?php echo e($program['headerProg']); ?>

                        </h3>
                    </div>
                    <?php
                        $data = $countSegment->firstWhere('program', $program['headerProg']);
                        $jumlah = $data['jumlah_segment'] ?? 1;
                        $isGenap = $jumlah % 2 === 0;

                        // Tentukan jumlah kolom grid
                        if ($jumlah >= 4 && $isGenap) {
                            $cols = 4;
                        } elseif ($jumlah >= 3 && !$isGenap) {
                            $cols = 3;
                        } else {
                            $cols = max(1, $jumlah);
                        }
                    ?>
                    <div class="grid md:grid-cols-<?php echo e($cols); ?> gap-3 px-2 py-2">
                        <?php $__currentLoopData = $program['segment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border rounded-lg">
                                <div class="border-b">
                                    <h3 class="font-bold bg-gray-200 text-red-800 px-2 py-1">
                                        <?php echo e($segment['details']->first()['segment']); ?> 
                                    </h3>
                                </div>
                                <ul class="px-4 py-2">
                                    <?php $__currentLoopData = $segment['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="text-sm">
                                            <?php echo e($detail['keterangan']); ?>: <strong><?php echo e(number_format((float) $detail['jumlah'], 1, '.', ',')); ?></strong>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <li class="text-sm font-bold border-t mt-2 pt-1">
                                        Total: <?php echo e(number_format((float) $segment['total'], 1, '.', ',')); ?>

                                    </li>
                                </ul>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <!-- <div class="border-b mt-4 border-red-800"></div> -->
        <div class="py-2 px-2 border rounded-lg mt-4">
            <div class="md:block hidden">
                <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Pencapaian Program Pertamina Retail per Pelanggan periode <?php echo e($namaPeriode); ?></h5></div>
                <div class="grid grid-cols-2 gap-3">
                    <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uuid => $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-6 border rounded-lg shadow-sm bg-white">
                            <div class="bg-gray-100 rounded-t-lg border-b px-4 py-2">
                                <span class="font-bold text-red-800"><?php echo e($cust['header']); ?></span>
                                <span class="font-semibold text-red-800"><?php echo e($cust['header2']); ?></span>
                            </div>
                                <?php $__currentLoopData = $cust['programs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $progName => $prog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="p-4 border-b last:border-none">
                                        <h3 class="text-sm font-semibold text-gray-800 mb-2">
                                            <?php echo e($progName); ?> 
                                            <span class="text-xs px-2 py-1 rounded <?php echo e(strtoupper($prog['status']) === 'TERDAFTAR' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                                <?php echo e(strtoupper($prog['status'])); ?>

                                            </span>
                                        </h3>

                                        
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-xs border border-gray-300">
                                                <thead class="bg-gray-200 text-gray-700 text-center">
                                                    <tr>
                                                        <th class="border px-2 py-1 w-1/6">SEGMENT</th>
                                                        <th class="border px-2 py-1 w-1/6">TARGET</th>
                                                        <th class="border px-2 py-1 w-1/6">CAPAI</th>
                                                        <th class="border px-2 py-1 w-1/6">SISA</th>
                                                        <th class="border px-2 py-1 w-1/6">PERSEN</th>
                                                        <th class="border px-2 py-1 w-1/6">KETERANGAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $prog['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="border px-2 py-1"><?php echo e($detail['segment']); ?></td>
                                                            <td class="border px-2 py-1 text-right"><?php echo e(number_format((float) $detail['target'], 1, '.', ',')); ?></td>
                                                            <td class="border px-2 py-1 text-right"><?php echo e(number_format((float) $detail['liter'] ?? 0, 1, '.', ',')); ?></td>
                                                            <td class="border px-2 py-1 text-right"><?php echo e(number_format((float) $detail['sisa'] ?? 0, 1, '.', ',')); ?></td>
                                                            <td class="border px-2 py-1 text-right"><?php echo e($detail['persentase']); ?>%</td>
                                                            <td class="border px-2 py-1"><?php echo e($detail['keterangan'] ?? '-'); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="md:hidden block">
                <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uuid => $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-6 border rounded-lg shadow-sm bg-white">
                        <div class="bg-gray-100 rounded-t-lg border-b px-4 py-2">
                            <span class="font-bold text-red-800"><?php echo e($cust['header']); ?></span> <br>
                            <span class="font-semibold text-red-800"><?php echo e($cust['header2']); ?></span>
                        </div>
                            <?php $__currentLoopData = $cust['programs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $progName => $prog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-4 border-b last:border-none">
                                    <h3 class="text-sm font-bold text-gray-800 mb-1">
                                        <?php echo e($progName); ?> 
                                        <span class="text-xs font-semibold px-1 py-1 rounded <?php echo e(strtoupper($prog['status']) === 'TERDAFTAR' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                            <?php echo e(strtoupper($prog['status'])); ?>

                                        </span>
                                    </h3>

                                    
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-xs border border-gray-300">
                                            <thead class="bg-gray-200 text-gray-700 text-center">
                                                <tr>
                                                    <th class="border px-2 py-1 w-3/6">KET</th>
                                                    <th class="border px-2 py-1 w-3/6">LITER</th>
                                                    <th class="border px-2 py-1 w-2/6">PERSEN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $prog['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td colspan="3"><span class="px-1 font-semibold"><?php echo e($detail['segment']); ?> (<?php echo e($detail['keterangan'] ?? '-'); ?>)</span></td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="border px-2 py-1">TARGET <br> CAPAI <hr> SISA</td>
                                                        <td class="border px-2 py-1 text-right">
                                                            <?php echo e(number_format((float) $detail['target'], 1, '.', ',')); ?> <br>
                                                            <?php echo e(number_format((float) $detail['liter'], 1, '.', ',')); ?> <hr>
                                                            <?php echo e(number_format((float) $detail['sisa'], 1, '.', ',')); ?> <br>
                                                        </td>
                                                        <td class="border px-2 py-1 text-right"><?php echo e($detail['persentase']); ?>%</td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="mt-4">
                <?php echo e($grouped->links('pagination::tailwind')); ?>

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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/reports/prog_rtl.blade.php ENDPATH**/ ?>