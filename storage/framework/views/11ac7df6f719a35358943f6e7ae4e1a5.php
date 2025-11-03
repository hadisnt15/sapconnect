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
                    <label for="search" class="sr-only">Cari Pengguna</label>
                    <div class="relative">
                        <input type="text" id="search" name="search"
                            class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-50 border-gray-300 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200"
                            placeholder="Cari Pengguna" />
                        <button type="submit"
                            class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="flex items-center gap-2 md:ml-auto">
                <a href="<?php echo e(route('user.register')); ?>"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-user-add-fill"></i> Daftarkan Pengguna Baru
                </a>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.active')): ?>
                <a href="<?php echo e(route('user.active')); ?>"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-user-add-fill"></i> Pengguna Aktif
                </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.device')): ?>
                <a href="<?php echo e(route('user.device')); ?>"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-user-add-fill"></i> Perangkat Pengguna
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Table -->
        <div class="md:block hidden relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="text-xs font-bold text-white uppercase bg-red-800">
                    <tr>
                        <th class="px-2 py-2 text-center w-4/12">Nama Lengkap / Nama Pengguna</th>
                        <th class="px-2 py-2 text-center w-2/12">Email / Telepon</th>
                        <th class="px-2 py-2 text-center w-2/12">Posisi / Divisi / Cabang</th>
                        <th class="px-2 py-2 text-center w-2/12">Dibuat Tanggal</th>
                        <th class="px-2 py-2 text-center w-1/12">Keaktifan</th>
                        <th class="px-2 py-2 text-center w-2/12">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-2 py-2 font-medium text-gray-800">
                                <?php echo e($u->name); ?> <br> <?php echo e($u->username); ?>

                            </td>
                            <td class="px-2 py-2 font-medium text-gray-800">
                                <?php echo e($u->email ?? '---'); ?> <br> <?php echo e($u->phone); ?>

                            </td>
                            <td class="px-2 py-2 font-medium text-gray-800">
                                <?php if($u->role === 'salesman'): ?>
                                    Penjual
                                <?php elseif($u->role === 'supervisor'): ?>
                                    Admin
                                <?php elseif($u->role === 'manager'): ?>
                                    Manajer
                                <?php elseif($u->role === 'developer'): ?>
                                    IT
                                <?php endif; ?>
                                <br> 
                                Divisi: <?php echo e($u->divisions->pluck('div_name')->implode(', ')); ?>

                                <br>
                                Cabang: <?php echo e($u->branches->pluck('branch_name')->implode(', ')); ?>

                            </td>
                            <td class="px-2 py-2 font-medium text-gray-800">
                                <?php echo e($u->created_at); ?>

                            </td>
                            <td class="px-2 py-2 font-medium text-gray-800">
                                <?php if($u->is_active == '1'): ?>
                                    Aktif
                                <?php else: ?>
                                    Tidak Aktif
                                <?php endif; ?>
                            </td>
                            <td class="px-2 py-2 space-y-2">
                                <a href="<?php echo e(route('user.edit', $u->id)); ?>"
                                    class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                    <i class="ri-file-edit-fill"></i> Edit
                                </a>
                                <a href="<?php echo e(route('user.editDivision', $u->id)); ?>"
                                    class="block px-2 py-1 text-xs rounded bg-green-500 hover:bg-green-400 text-white w-full text-center">
                                    <i class="ri-flag-fill"></i> Divisi
                                </a>
                                <a href="<?php echo e(route('user.editReport', $u->id)); ?>"
                                    class="block px-2 py-1 text-xs rounded bg-blue-500 hover:bg-blue-400 text-white w-full text-center">
                                    <i class="ri-folder-6-fill"></i> Laporan
                                </a>
                                <a href="<?php echo e(route('user.editBranch', $u->id)); ?>"
                                    class="block px-2 py-1 text-xs rounded bg-gray-500 hover:bg-gray-400 text-white w-full text-center">
                                    <i class="ri-map-pin-fill"></i> Cabang
                                </a>
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
                        <th class="px-6 py-3 w-11/12">Pengguna</th>
                        <th class="px-6 py-3 w-1/12">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-800">
                                <span class="font-bold mb-3"><?php echo e($u->name); ?> / <?php echo e($u->username); ?></span><br>
                                Kontak: <br>
                                <span class="font-medium mb-3 ms-3"><?php echo e($u->email ?? '---'); ?> /
                                    <?php echo e($u->phone); ?></span><br>
                                Posisi: <br>
                                <span class="font-medium mb-3 ms-3">
                                    <?php if($u->role === 'salesman'): ?>
                                        Penjual
                                    <?php elseif($u->role === 'supervisor'): ?>
                                        Admin
                                    <?php elseif($u->role === 'manager'): ?>
                                        Manajer
                                    <?php elseif($u->role === 'developer'): ?>
                                        IT
                                    <?php endif; ?>
                                </span><br>
                                Divisi: <br>
                                <span class="font-medium mb-3 ms-3"><?php echo e($u->divisions->pluck('div_name')->implode(', ')); ?></span> <br>
                                Cabang: <br>
                                <span class="font-medium mb-3 ms-3"><?php echo e($u->branches->pluck('branch_name')->implode(', ')); ?></span> <br>
                                Keaktifan: <br>
                                <span class="font-medium mb-3 ms-3">
                                    <?php if($u->is_active == '1'): ?>
                                        Aktif
                                    <?php else: ?>
                                        Tidak Aktif
                                    <?php endif; ?>
                                </span><br>
                                Terdaftar Sejak: <br>
                                <span class="font-medium ms-3"><?php echo e($u->created_at); ?></span>
                            </td>
                            <td class="px-6 py-4 space-y-1">
                                <a href="<?php echo e(route('user.edit', $u->id)); ?>"
                                    class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                    <i class="ri-file-edit-fill"></i>
                                </a>
                                <a href="<?php echo e(route('user.editDivision', $u->id)); ?>"
                                    class="block px-2 py-1 text-xs rounded bg-green-500 hover:bg-green-400 text-white w-full text-center">
                                    <i class="ri-flag-fill"></i> 
                                </a>
                                <a href="<?php echo e(route('user.editReport', $u->id)); ?>"
                                    class="block px-2 py-1 text-xs rounded bg-blue-500 hover:bg-blue-400 text-white w-full text-center">
                                    <i class="ri-folder-6-fill"></i> 
                                </a>
                                <a href="<?php echo e(route('user.editBranch', $u->id)); ?>"
                                    class="block px-2 py-1 text-xs rounded bg-gray-500 hover:bg-gray-400 text-white w-full text-center">
                                    <i class="ri-map-pin-fill"></i> 
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5 text-gray-600">
            <?php echo e($user->links()); ?> 
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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/user/user.blade.php ENDPATH**/ ?>