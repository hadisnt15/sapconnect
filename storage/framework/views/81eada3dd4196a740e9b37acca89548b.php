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
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-300 py-2 px-2 bg-white">
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('customer')); ?>"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-800">
                        <i class="ri-account-circle-2-fill me-1"></i> Daftar Pelanggan 
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">
                    &rsaquo;&rsaquo;
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-group-2-fill"></i> <?php echo e($titleHeader); ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        
        <form class="mx-auto" action="<?php echo e(route('customer.store')); ?>" method="POST"> <?php echo csrf_field(); ?>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="mb-2">
                    <label for="CardCode" class="mb-2 text-sm font-medium text-gray-700">Kode Pelanggan</label>
                    <input type="text" id="CardCode" name="CardCode" value="<?php echo e(old('CardCode')); ?>" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Kode Pelanggan" required />
                    <?php $__errorArgs = ['CardCode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-2">
                    <label for="CardName" class="mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" id="CardName" name="CardName" value="<?php echo e(old('CardName')); ?>" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Nama Pelanggan" required />
                    <?php $__errorArgs = ['CardName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="mb-2">
                    <label for="Contact" class="mb-2 text-sm font-medium text-gray-700">Kontak</label>
                    <input type="text" id="Contact" name="Contact" value="<?php echo e(old('Contact')); ?>" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Kontak" required />
                    <?php $__errorArgs = ['Contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-2">
                    <label for="Phone" class="mb-2 text-sm font-medium text-gray-700">Telepon</label>
                    <input type="number" id="Phone" name="Phone" value="<?php echo e(old('Phone')); ?>" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Telepon" required />
                    <?php $__errorArgs = ['Phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="mb-2">
                    <label for="State" class="mb-2 text-sm font-medium text-gray-700">Provinsi</label>
                    <input type="text" id="State" name="State" value="<?php echo e(old('State')); ?>" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Provinsi" required />
                    <?php $__errorArgs = ['State'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-2">
                    <label for="City" class="mb-2 text-sm font-medium text-gray-700">Kota/Kab</label>
                    <input type="text" id="City" name="City" value="<?php echo e(old('City')); ?>" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Kota/Kab" required />
                    <?php $__errorArgs = ['City'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="mb-2">
                    <label for="NIK" class="mb-2 text-sm font-medium text-gray-700">NIK</label>
                    <input type="number" id="NIK" name="NIK" value="<?php echo e(old('NIK')); ?>" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="NIK" />
                    <?php $__errorArgs = ['NIK'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-2">
                    <label for="JenisBayar" class="mb-2 text-sm font-medium text-gray-700">Jenis Pembayaran</label>
                    <input type="text" id="JenisBayar" name="JenisBayar" value="CASH" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Jenis Pembayaran" readonly />
                </div>
            </div>

            <div>
                <label for="Address" class="block mb-2 text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="Address" name="Address" rows="3" autocomplete="off"
                    class="block p-2.5 w-full text-sm rounded-lg border bg-gray-100 border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600"
                    placeholder="Alamat"><?php echo e(old('Address')); ?></textarea>
                <?php $__errorArgs = ['Address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <input type="hidden" value="PELANGGAN BARU" id="Type1" name="Type1">
            <input type="number" value="<?php echo e(auth()->user()->id); ?>" id="created_by" name="created_by" class="hidden">
            <button type="submit"
                class="mt-3 w-full bg-red-800 hover:bg-red-500 text-white py-2 rounded-lg text-sm font-medium">
                Daftarkan Pelanggan Baru
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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/ocrd/ocrd_registration.blade.php ENDPATH**/ ?>