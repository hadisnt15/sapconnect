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
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-group-2-fill text-red-800"></i> <?php echo e($titleHeader); ?>

                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Search & Action -->
        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4 items-center pb-4 w-full">
            <div>
                <form action="" method="get">
                    <label for="search" class="sr-only">Cari Penjual</label>
                    <div class="relative">
                        <input type="text" id="search" name="search"
                            class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-50 border-gray-300 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200"
                            placeholder="Cari Penjual" />
                        <button type="submit"
                            class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto flex items-center gap-2">
                <a href="<?php echo e(route('salesman.registration')); ?>"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-add-box-fill"></i> Daftarkan Penjual
                </a>
                <a href="<?php echo e(route('salesman.refresh')); ?>"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="md:block hidden relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="text-xs font-bold text-white uppercase bg-red-800">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Nama/Alias</th>
                        <th class="px-6 py-3">Telepon</th>
                        <th class="px-6 py-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $slps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?php echo e($s->RegSlpCode); ?>

                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?php echo e($s->oslpLocal->SlpName); ?>/<?php echo e($s->Alias); ?>

                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?php echo e($s->oslpLocal->Phone); ?>

                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                Pesanan Pertama:
                                <?php echo e(\Carbon\Carbon::parse($s->oslpLocal->FirstOdrDate)->format('d-m-Y')); ?> <br>
                                Pesanan Terbaru:
                                <?php echo e(\Carbon\Carbon::parse($s->oslpLocal->LastOdrDate)->format('d-m-Y')); ?>


                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="md:hidden block relative overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="text-xs font-bold text-white uppercase bg-red-800">
                    <tr>
                        <th class="px-6 py-3">Penjual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $slps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <span class="font-bold"><?php echo e($s->RegSlpCode); ?></span> <br>
                                <span class="font-bold"><?php echo e($s->oslpLocal->SlpName); ?>/<?php echo e($s->Alias); ?></span> <br>
                                <?php echo e($s->oslpLocal->Phone); ?> <br>
                                Pesanan Pertama:
                                <?php echo e(\Carbon\Carbon::parse($s->oslpLocal->FirstOdrDate)->format('d-m-Y')); ?> <br>
                                Pesanan Terbaru:
                                <?php echo e(\Carbon\Carbon::parse($s->oslpLocal->LastOdrDate)->format('d-m-Y')); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5 text-gray-600">
            <?php echo e($slps->links()); ?>

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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/oslp/oslp.blade.php ENDPATH**/ ?>