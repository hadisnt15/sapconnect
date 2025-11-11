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
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-300 py-2 px-2 bg-white">
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('report')); ?>"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-800">
                        <i class="ri-folder-6-fill"></i> Daftar Laporan 
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">
                    &rsaquo;&rsaquo;
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-folder-add-fill"></i> <?php echo e($titleHeader); ?>

                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <form class="mx-auto md:w-3/4 mb-4" action="<?php echo e(route('report.store')); ?>" method="POST"> <?php echo csrf_field(); ?>
            <div class="mb-2">
                <label for="name" class="mb-2 text-sm font-medium text-gray-700">Nama Laporan</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" autocomplete="off"
                    class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                    placeholder="Nama Laporan" required />
                <?php $__errorArgs = ['name'];
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
            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi Laporan</label>
                <textarea id="description" name="description" rows="3" autocomplete="off"
                    class="block p-2.5 w-full text-sm rounded-lg border bg-gray-100 border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600"
                    placeholder="Deskripsi Laporan"><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
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
            <button type="submit"
                class="mt-3 w-full bg-red-800 hover:bg-red-500 text-white py-2 rounded-lg text-sm font-medium">
                Daftarkan Laporan Baru
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


<?php /**PATH C:\laragon\www\sapconnect\resources\views/reports/report_create.blade.php ENDPATH**/ ?>