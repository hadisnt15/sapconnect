<nav class="bg-red-900" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Desktop Navbar -->
        <div class="hidden md:block">
            <div class="grid grid-cols-[1fr_3fr_1fr] h-16 items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="https://kapuaskencana.com" target="_blank"
                       class="flex items-center gap-2 hover:opacity-90 transition">
                        <img src="<?php echo e(asset('img/kkj.png')); ?>" alt="PT Kapuas Kencana Jaya"
                             class="w-10 h-10 rounded-full bg-white p-1">
                        <span class="text-sm font-semibold text-white">PT. KAPUAS KENCANA JAYA</span>
                    </a>
                </div>

                <!-- Menu Items -->
                <div class="flex justify-center space-x-1">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => '/','active' => request()->is('/')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '/','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->is('/'))]); ?>
                            <i class="ri-home-office-fill"></i> Beranda
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('report')).'','class' => ''.e(Route::is('report', 'report.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('report')).'','class' => ''.e(Route::is('report', 'report.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']); ?>
                            <i class="ri-folder-6-fill"></i> Laporan
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('order')).'','class' => ''.e(Route::is('order', 'order.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('order')).'','class' => ''.e(Route::is('order', 'order.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']); ?>
                            <i class="ri-bill-fill"></i> Pesanan
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('item')).'','class' => ''.e(Route::is('item') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('item')).'','class' => ''.e(Route::is('item') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']); ?>
                            <i class="ri-settings-4-fill"></i> Barang
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('customer')).'','class' => ''.e(Route::is('customer', 'customer.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('customer')).'','class' => ''.e(Route::is('customer', 'customer.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']); ?>
                            <i class="ri-account-circle-2-fill"></i> Pelanggan
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

                        <?php if(in_array(auth()->user()->role, ['developer', 'manager', 'supervisor'])): ?>
                            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('salesman')).'','class' => ''.e(Route::is('salesman', 'salesman.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('salesman')).'','class' => ''.e(Route::is('salesman', 'salesman.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']); ?>
                                <i class="ri-group-2-fill"></i> Penjual
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php endif; ?>

                        <?php if(in_array(auth()->user()->role, ['developer', 'manager'])): ?>
                            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('user')).'','class' => ''.e(Route::is('user','user.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('user')).'','class' => ''.e(Route::is('user','user.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').' px-3 py-2 rounded-md text-sm font-medium']); ?>
                                <i class="ri-user-follow-fill"></i> Pengguna
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Profile Dropdown -->
                <div class="flex justify-end items-center space-x-3">
                    <?php if(auth()->guard()->check()): ?>
                        <span class="text-sm text-white"><?php echo e(auth()->user()->name); ?></span>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center rounded-full bg-red-800 p-1 focus:outline-none focus:ring-2 focus:ring-white">
                                <img class="w-8 h-8 rounded-full"
                                     src="<?php echo e(auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profile-default.png')); ?>"
                                     alt="Profile" />
                            </button>

                            <div x-show="open" @click.outside="open = false" 
                                x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                <a href="<?php echo e(route('profile')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profil</a>
                                <a href="<?php echo e(route('password.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ubah Kata Sandi</a>
                                <form action="<?php echo e(route('logout')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <span class="text-sm text-white">Anda Belum Login</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Mobile Navbar -->
        <div class="md:hidden flex justify-between items-center h-16">
            <div class="flex items-center space-x-2">
                <a href="https://kapuaskencana.com" target="_blank"
                       class="flex items-center gap-2 hover:opacity-90 transition">
                    <img src="<?php echo e(asset('img/kkj.png')); ?>" class="w-10 h-10 rounded-full bg-white p-1" alt="Logo">
                    <span class="text-white font-semibold text-sm">PT. KAPUAS KENCANA JAYA</span>
                </a>
            </div>
            <button @click="isOpen = !isOpen" class="p-2 bg-red-700 rounded-md text-white focus:ring-2 focus:ring-white">
                <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                     d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="isOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                     d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Dropdown -->
    <div x-show="isOpen" x-transition 
         class="md:hidden bg-red-900 text-white space-y-1 px-3 pb-3 rounded-b-lg">
        <?php if(auth()->guard()->check()): ?>
            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => '/','class' => 'block p-2 hover:bg-red-700','active' => request()->is('/')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '/','class' => 'block p-2 hover:bg-red-700','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->is('/'))]); ?><i class="ri-home-office-fill"></i> Beranda <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('report')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('report','report.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('report')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('report','report.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']); ?><i class="ri-folder-6-fill"></i> Laporan <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('order')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('order', 'order.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('order')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('order', 'order.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']); ?><i class="ri-bill-fill"></i> Pesanan <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('item')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('item') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('item')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('item') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']); ?><i class="ri-settings-4-fill"></i> Barang <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('customer')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('customer', 'customer.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('customer')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('customer', 'customer.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']); ?><i class="ri-account-circle-2-fill"></i> Pelanggan <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
            <?php if(in_array(auth()->user()->role, ['developer', 'manager', 'supervisor'])): ?>
                <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('salesman')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('salesman', 'salesman.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('salesman')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('salesman', 'salesman.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']); ?><i class="ri-group-2-fill"></i> Penjual <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if(in_array(auth()->user()->role, ['developer', 'manager'])): ?>
                <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => ''.e(route('user')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('user','user.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('user')).'','class' => 'block p-2 hover:bg-red-700 '.e(Route::is('user','user.*') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700').'']); ?><i class="ri-user-follow-fill"></i> Pengguna <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
            <?php endif; ?>
            <hr class="border-red-700 my-2">
            <div class="px-2 text-sm">
                <div class="flex items-center space-x-2">
                    <img src="<?php echo e(auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profile-default.png')); ?>"
                         class="w-8 h-8 rounded-full" alt="Profile">
                    <span><?php echo e(auth()->user()->name); ?></span>
                </div>
                <div class="mt-2 space-y-1">
                    <a href="<?php echo e(route('profile')); ?>" class="block p-2 hover:bg-red-700">Profil Saya</a>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="block p-2 hover:bg-red-700">Edit Profil</a>
                    <a href="<?php echo e(route('password.edit')); ?>" class="block p-2 hover:bg-red-700">Ubah Kata Sandi</a>
                    <form action="<?php echo e(route('logout')); ?>" method="post"><?php echo csrf_field(); ?>
                        <button type="submit" class="w-full text-left p-2 hover:bg-red-700">Keluar</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="px-3 py-2 text-sm">Anda Belum Login</div>
        <?php endif; ?>
    </div>
</nav>
<?php /**PATH C:\laragon\www\sapconnect\resources\views/components/navbar.blade.php ENDPATH**/ ?>