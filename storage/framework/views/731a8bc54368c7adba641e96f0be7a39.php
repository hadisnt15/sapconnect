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
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

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
                        <option value="">Periode Tersedia</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availablePeriods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($p); ?>" <?php echo e($selectedPeriod == $p ? 'selected' : ''); ?>>
                                <?php echo e($p); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastSync): ?>
                Terakhir Disinkronkan: 
                <?php echo e(\Carbon\Carbon::parse($lastSync->last_sync)->timezone('Asia/Makassar')->format('d-m-Y H:i:s')); ?> WITA 
                (<?php echo e($lastSync->desc); ?>)
            <?php else: ?>
                Belum pernah disinkronkan
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div> 
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array(auth()->user()->role, ['developer', 'supervisor', 'manager'])): ?>
        <div class="p-2 border border-gray-200 mt-4 rounded-lg bg-white">
            <div>
                <h5 class="text-gray-800 font-bold ms-4 mb-4">
                    Penjualan Industri per Grup Periode <?php echo e($namaPeriode); ?>

                </h5>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->count() > 0): ?>
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $typeTotal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="border rounded-lg shadow-sm">
                            <div class="bg-gray-100 rounded-t-lg border-b px-4 py-2"><span class="font-bold text-red-800"><?php echo e($row->TYPECUST); ?></span></div>    
                            <div class="grid md:grid-cols-2 items-center px-4 py-2 text-md font-bold text-gray-700">
                                <span class="">
                                    RP <?php echo e(number_format($row->TOTALRP, 2)); ?>

                                </span>
                                <span class="text-right">
                                    <?php echo e(number_format($row->TOTALKL, 2)); ?> KL
                                </span>
                            </div>
                            
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="mb-6 border rounded-lg shadow-sm bg-white">
                            <div class="bg-gray-100 rounded-t-lg border-b px-4 py-2">
                                <span class="font-bold text-red-800"><?php echo e($type); ?> </span>
                                <span class="font-semibold text-red-800"><?php echo e($group); ?></span>
                            </div>
                            <div class="px-4 pb-4 mt-4 overflow-y-auto max-h-80 relative z-10">
                                <table class="w-full text-xs border border-gray-300">
                                    <thead class="bg-gray-200 text-gray-700 text-center sticky top-0 z-20">
                                        <tr>
                                            <th class="border px-2 py-1">#</th>
                                            <th class="border px-2 py-1 w-5/12">PELANGGAN</th>
                                            <th class="border px-2 py-1 w-1/12">KL</th>
                                            <th class="border px-2 py-1 w-3/12">PIUTANG</th>
                                            <th class="border px-2 py-1 w-3/12">PIUTANG JT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rows['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr>
                                            <td class="border px-2 py-1"><?php echo e($loop->iteration); ?></td>
                                            <td class="border px-2 py-1"><?php echo e($row->CARDNAME); ?> <br> <span class="font-semibold"><?php echo e($row->CARDCODE); ?></span></td>
                                            <td class="border px-2 py-1 text-right"><?php echo e(number_format($row->KILOLITER,2)); ?></td>
                                            <td class="border px-2 py-1 text-right"><?php echo e(number_format($row->PIUTANG,2)); ?></td>
                                            <td class="border px-2 py-1 text-right"><?php echo e(number_format($row->PIUTANGJT,2)); ?></td>
                                        </tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </tbody>
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700">
                                            <th colspan="2" class="border px-2 py-1 text-left">TOTAL <?php echo e($type); ?> <?php echo e($group); ?></th>
                                            <th class="border px-2 py-1 text-right"><?php echo e(number_format($rows['total'], 2)); ?></th>
                                            <th class="border px-2 py-1 text-right"><?php echo e(number_format($rows['total3'], 2)); ?></th>
                                            <th class="border px-2 py-1 text-right"><?php echo e(number_format($rows['total2'], 2)); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                                
                                <!-- GRAFIK 12 BULAN -->
                                <div class="px-4 pt-2 mt-4 font-base text-red-800 text-xs">
                                    GRAFIK PENJUALAN<span class="font-semibold "> <?php echo e($type); ?> <?php echo e($group); ?> </span>SELAMA 12 BULAN TERAKHIR DALAM BENTUK KL
                                </div>
                                <div class="px-4 pb-4 mt-4">
                                    <canvas id="chart_<?php echo e(Str::slug($type)); ?>_<?php echo e(Str::slug($group)); ?>"></canvas>
                                </div>

                                <?php
                                    $grafikRows = $grafik[$type][$group] ?? collect();
                                    $labels = $grafikRows->map(fn($g) => (int)$g->TAHUN . '-' . (int)$g->BULAN);
                                    $values = $grafikRows->map(fn($g) => number_format($g->KILOLITER, 2, '.', ','));
                                ?>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        new Chart(
                                            document.getElementById("chart_<?php echo e(Str::slug($type)); ?>_<?php echo e(Str::slug($group)); ?>"),
                                            {
                                                type: 'line',
                                                data: {
                                                    labels: <?php echo json_encode($labels); ?>,
                                                    datasets: [{
                                                        label: "KL / 12 Bulan",
                                                        data: <?php echo json_encode($values); ?>,
                                                        borderWidth: 2,
                                                        borderColor: "rgba(100,100,100,0.8)",
                                                        backgroundColor: "rgba(150,150,150,0.2)",
                                                        tension: 0.2,
                                                        fill: true
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    },
                                                    plugins: {
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    let value = context.raw;

                                                                    // format angka menjadi 1,000.00
                                                                    let formatted = Number(value).toLocaleString("en-US", {
                                                                        minimumFractionDigits: 2,
                                                                        maximumFractionDigits: 2
                                                                    });

                                                                    return "KL / 12 Bulan: " + formatted;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        );
                                    });
                                </script>

                                <div class="px-4 pt-2 mt-4 font-base text-red-800 text-xs">
                                    TOP 5 RATA-RATA PER ITEM
                                    <span class="font-semibold"><?php echo e($type); ?> <?php echo e($group); ?></span>
                                </div>

                                <table class="w-full text-xs border border-gray-300 mt-2">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="border px-2 py-1">1</th>
                                            <th class="border px-2 py-1">Barang</th>
                                            <th class="border px-2 py-1">AVG (KL)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $avgklRows = $avgkl[$type][$group] ?? collect();
                                        ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $avgklRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <tr>
                                                <td class="border px-2 py-1"><?php echo e($item->RANK); ?></td>
                                                <td class="border px-2 py-1"><?php echo e($item->FRGNNAME); ?> - <?php echo e($item->ORIGINCODE); ?></td>
                                                <td class="border px-2 py-1 text-right"><?php echo e($item->AVGKL); ?></td>
                                            </tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            <tr>
                                                <td colspan="3" class="border px-2 py-1 text-center">
                                                    Data tidak ada
                                                </td>
                                            </tr>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
              
            <?php else: ?>
                <p class="text-gray-500 text-center py-4">Tidak ada data ditemukan</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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