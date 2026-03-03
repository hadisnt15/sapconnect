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
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-login-circle-fill"></i> <?php echo e($titleHeader); ?>

                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Login Form -->
        
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-4">
            <div class="px-2 py-6 text-center">
                <p class="text-sm sm:text-base text-gray-600 font-medium">
                    Selamat Datang di
                </p>

                <h1 class="mt-1 font-extrabold text-gray-900
                        text-3xl sm:text-4xl md:text-5xl lg:text-6xl leading-tight">
                    SAP Connect
                </h1>

                <h2 class="mt-1 font-bold text-red-800
                        text-xl sm:text-2xl md:text-3xl lg:text-4xl tracking-wide">
                    PT Kapuas Kencana Jaya
                </h2>

                <!-- Accent line -->
                <div class="mx-auto mt-4 w-16 h-1 bg-red-800 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
                <div class="hidden md:flex relative overflow-hidden rounded-xl">

                    <!-- Decorative vertical line -->
                    <div class="absolute right-8 top-0 h-full w-px bg-gradient-to-b from-transparent via-red-700/30 to-transparent"></div>

                    <!-- Content -->
                    <div class="relative z-10 p-10 flex flex-col justify-center">
                        
                        <h2 class="text-2xl font-bold text-gray-800 leading-snug">
                            Integrasi Data Bisnis dalam Satu Platform
                        </h2>

                        <p class="mt-4 text-sm text-gray-600 max-w-sm leading-relaxed">
                            SAP Connect membantu pengguna internal mengakses informasi bisnis
                            secara cepat, terstruktur, dan terpercaya tanpa harus masuk langsung
                            ke sistem SAP.
                        </p>

                        <!-- Divider -->
                        <div class="mt-6 w-16 h-1 bg-red-700 rounded-full"></div>

                        <!-- Keywords -->
                        <div class="mt-6 flex flex-wrap gap-2 text-xs font-semibold text-gray-500">
                            <span class="px-3 py-1 border border-gray-300 rounded-full">Integrated</span>
                            <span class="px-3 py-1 border border-gray-300 rounded-full">Reliable</span>
                            <span class="px-3 py-1 border border-gray-300 rounded-full">Efficient</span>
                        </div>

                    </div>

                    <!-- Subtle background shape -->
                    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-red-700/5 rounded-full"></div>
                </div>
                <div>
                    
                    
                    <div id="accordion-collapse" data-accordion="collapse"
                        class="rounded-xl overflow-hidden shadow-md ">
            
                        
                            
                                
                                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                                        <form class="space-y-4 md:space-y-6" action="<?php echo e(route('login')); ?>" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div>
                                                <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Nama Pengguna</label>
                                                <input type="text" name="username" id="username"
                                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200 focus:border-indigo-300"
                                                    placeholder="Nama Pengguna" required autocomplete="off" autofocus>
                                                <?php $__errorArgs = ['phone'];
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
                                                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Kata Sandi</label>
                                                <input type="password" name="password" id="password"
                                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200 focus:border-indigo-300"
                                                    placeholder="••••••••" required autocomplete="off">
                                                <?php $__errorArgs = ['password'];
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
                                                class="w-full mt-3 bg-red-800 hover:bg-red-600 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                Masuk
                                            </button>
                                        </form>
                                    </div>
                                
                            
                        
                    </div>
                </div>
                
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
<?php /**PATH C:\laragon\www\sapconnect\resources\views/auth/login.blade.php ENDPATH**/ ?>