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

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-4 px-6 bg-white">
        <!-- Breadcrumb -->
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('user')); ?>"
                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-red-600">
                        <i class="ri-account-circle-2-fill me-1"></i> Daftar Pengguna
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-group-2-fill"></i> <?php echo e($titleHeader); ?>

                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Form -->
        <form class="mx-auto w-full md:w-1/2 bg-white p-6 rounded-lg border border-gray-200 shadow-sm"
              action="<?php echo e(route('register')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label for="name" class="mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" autocomplete="off"
                       class="bg-gray-50 border border-gray-300 placeholder-gray-400 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5"
                       placeholder="Nama Lengkap" required />
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"><?php echo e($message); ?></span></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label for="username" class="mb-2 text-sm font-medium text-gray-700">Nama Pengguna</label>
                <input type="text" id="username" name="username" value="<?php echo e(old('username')); ?>" autocomplete="off"
                       class="bg-gray-50 border border-gray-300 placeholder-gray-400 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5"
                       placeholder="Nama Pengguna" required />
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"><?php echo e($message); ?></span></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Telepon -->
            <div class="mb-4">
                <label for="phone" class="mb-2 text-sm font-medium text-gray-700">Telepon</label>
                <input type="number" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" autocomplete="off"
                       class="bg-gray-50 border border-gray-300 placeholder-gray-400 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5"
                       placeholder="Telepon" required />
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"><?php echo e($message); ?></span></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="mb-2 text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="email" name="email" value="<?php echo e(old('email')); ?>" autocomplete="off"
                       class="bg-gray-50 border border-gray-300 placeholder-gray-400 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5"
                       placeholder="Email" />
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"><?php echo e($message); ?></span></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="mb-2 text-sm font-medium text-gray-700">Posisi</label>
                <select name="role" id="role"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5">
                    <option value="">Pilih Posisi</option>
                    <option value="salesman">Penjual</option>
                    <option value="supervisor">Admin</option>
                    <option value="manager">Manajer</option>
                </select>
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"><?php echo e($message); ?></span></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password hidden -->
            <input type="password" name="password" id="password" value="KKJweb#123" hidden>

            <!-- Submit -->
            <button type="submit"
                    class="w-full mt-3 bg-red-800 hover:bg-red-600 font-medium text-white rounded-lg text-sm px-5 py-2.5 text-center">
                <i class="ri-user-add-fill"></i> Daftarkan Pengguna Baru
            </button>
        </form>
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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/user/user_registration.blade.php ENDPATH**/ ?>