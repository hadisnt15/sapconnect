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
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-bill-fill text-red-800"></i> <?php echo e($titleHeader); ?>

                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Search & Action -->
        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4 items-center pb-4 w-full">
            <div>
                <form action="" method="get">
                    <label for="search" class="sr-only">Search Order</label>
                    <div class="relative">
                        <input type="text" id="search" name="search"
                            class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-50 border-gray-300 text-gray-700 placeholder-gray-400 focus:ring focus:ring-indigo-200"
                            placeholder="Cari Pesanan" />
                        <button type="submit"
                            class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto flex items-center gap-2">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('order.create')): ?>
                    <a href="<?php echo e(route('customer')); ?>"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-add-box-fill"></i> Buat Pesanan Baru
                    </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('order.push')): ?>
                    <a href="<?php echo e(route('order.push')); ?>"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-upload-cloud-2-fill"></i> Kirim ke SAP
                    </a>
                    <a href="<?php echo e(route('order.export')); ?>"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white" onclick="setTimeout(() => location.reload(), 1000)">
                        <i class="ri-file-excel-2-fill"></i> Ekspor ke Excel
                    </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('order.refresh')): ?>
                    <a href="<?php echo e(route('order.refresh')); ?>"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-sm font-bold text-gray-500 mb-2">
            <?php if($lastSync): ?>
                Terakhir Disinkronkan:<?php echo e(\Carbon\Carbon::parse($lastSync->last_sync)->timezone('Asia/Makassar')->format('d-m-Y H:i:s')); ?> WITA (<?php echo e($lastSync->desc); ?>)
            <?php else: ?>
                Belum Pernah Disinkronkan
            <?php endif; ?>
        </div>

        <form method="GET" action="<?php echo e(route('order')); ?>" 
            class="flex flex-col md:flex-row md:justify-start md:items-center gap-2 md:gap-3 mb-3">

            <div class="flex flex-col sm:flex-row gap-1 md:gap-1 items-start md:items-center">

                <!-- 🔹 Select Filter -->
                <select name="checked" onchange="this.form.submit()" 
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">
                    <option value="">Tanpa Filter</option>
                    <option value="1" <?php echo e(request('checked') == '1' ? 'selected' : ''); ?>>Ceklis</option>
                    <option value="0" <?php echo e(request('checked') == '0' ? 'selected' : ''); ?>>Non Ceklis</option>
                    <option value="2" <?php echo e(request('checked') == '2' ? 'selected' : ''); ?>>Terkirim (Status Web)</option>
                    <option value="3" <?php echo e(request('checked') == '3' ? 'selected' : ''); ?>>Tertunda (Status Web)</option>
                    <option value="4" <?php echo e(request('checked') == '4' ? 'selected' : ''); ?>>Belum Diproses (Status SAP)</option>
                    <option value="5" <?php echo e(request('checked') == '5' ? 'selected' : ''); ?>>Pesanan Tertunda (Status SAP)</option>
                    <option value="6" <?php echo e(request('checked') == '6' ? 'selected' : ''); ?>>Pesanan Selesai (Status SAP)</option>
                </select>

                <!-- 🔹 Date Range -->
                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">

                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">

                <!-- 🔹 Filter Button -->
                <button type="submit"
                    class="px-3 py-1 bg-red-800 hover:bg-red-500 text-white text-xs rounded-md shadow font-semibold w-full sm:w-auto">
                    Filter
                </button>
            </div>
        </form>




        <!-- Table -->
        <div class="md:block hidden">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <form action="<?php echo e(route('order.updateChecked')); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('patch'); ?>
                    <table class="w-full text-sm text-left text-gray-600 border">
                        <thead class="text-xs font-bold text-white uppercase bg-red-800">
                            <tr>
                                <th class="px-2 py-2 w-1/12">REFERENSI</th>
                                <th class="px-2 py-2 w-3/12">PELANGGAN</th>
                                <th class="px-2 py-2 w-2/12">PENJUAL</th>
                                <th class="px-2 py-2 w-1/24">CEK</th>
                                <th class="px-2 py-2 w-1/24">STATUS WEB</th>
                                <th class="px-2 py-2 w-1/24">STATUS SAP</th>
                                <th class="px-2 py-2 w-1/18">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-2 py-2 font-medium text-gray-800">
                                        <?php echo e($o->OdrRefNum); ?> <br> <?php echo e($o->OdrDocDate->format('d-m-Y')); ?> <br> 
                                        <span class="text-xs"><?php echo e($o->order_row_count); ?> Barang 
                                        <br> Cabang: <?php echo e($o->branch); ?> <br> Divisi: <?php echo e($o->profit_center); ?></span>
                                        <br> Catatan: <?php echo e($o->note); ?></span>
                                    </td>
                                    <td class="px-2 py-2 font-medium text-gray-800">
                                        <?php echo e($o->customer->CardName); ?> <br> <?php echo e($o->OdrCrdCode); ?>

                                    </td>
                                    <td class="px-2 py-2 font-medium text-gray-800">
                                        <?php echo e($o->salesman?->SlpName ?? 'DUMMY'); ?>

                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <?php if($o->is_synced === 1): ?>
                                            <!-- Checkbox hanya untuk tampilan -->
                                            <input type="checkbox" checked disabled
                                                class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">

                                            <!-- Hidden input agar value tetap terkirim -->
                                            <input type="hidden" name="is_checked[]" value="<?php echo e($o->id); ?>">
                                        <?php else: ?>
                                            <input type="checkbox" 
                                                name="is_checked[]" 
                                                value="<?php echo e($o->id); ?>"
                                                data-sales="<?php echo e($o->OdrSlpCode); ?>"
                                                class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500"
                                                <?php echo e($o->is_checked === 1 ? 'checked' : ''); ?>>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-2 py-2 font-medium">
                                        <?php if($o->is_synced === 1): ?>
                                            <span class="text-green-600 font-semibold">TERKIRIM</span>
                                        <?php elseif($o->is_synced === 2): ?>
                                            <span class="text-blue-600 font-semibold">PROSES KIRIM</span>
                                        <?php elseif($o->is_synced === 0): ?>
                                            <span class="text-yellow-600 font-semibold">TERTUNDA</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-2 py-2 font-medium">
                                        <?php if(Str::contains(optional($o->ordrStatus)->pesanan_status, 'PESANAN TERTUNDA')): ?>
                                            <span class="text-yellow-600 font-semibold"><?php echo e(optional($o->ordrStatus)->pesanan_status); ?></span>
                                        <?php elseif(Str::contains(optional($o->ordrStatus)->pesanan_status, 'PESANAN SELESAI')): ?>
                                            <span class="text-green-600 font-semibold"><?php echo e(optional($o->ordrStatus)->pesanan_status); ?></span>
                                        <?php elseif(optional($o->ordrStatus)->pesanan_status === 'BELUM DIPROSES DI SAP'): ?>
                                            <span class="text-gray-600 font-semibold"><?php echo e(optional($o->ordrStatus)->pesanan_status); ?></span>
                                        <?php endif; ?>

                                    </td>
                                    <td class="px-2 py-2 space-y-1">
                                        <button type="button" data-id="<?php echo e($o->id); ?>"
                                            data-OdrRefNum="<?php echo e($o->OdrRefNum); ?>"
                                            data-OdrDocDate="<?php echo e($o->OdrDocDate->format('d-m-Y')); ?>"
                                            data-OdrCardCode="<?php echo e($o->OdrCrdCode); ?>"
                                            data-OdrCardName="<?php echo e($o->customer->CardName); ?>"
                                            data-OdrSlpName="<?php echo e($o->salesman?->SlpName ?? 'DUMMY'); ?>"
                                            data-branch="<?php echo e($o->branch); ?>" data-note="<?php echo e($o->note); ?>"
                                            data-modal-target="detailModal" data-modal-toggle="detailModal"
                                            class="btn-detail open-modal-ordr-btn block px-2 py-1 text-xs rounded bg-red-800 hover:bg-red-500 w-full text-white">
                                            <i class="ri-eye-fill"></i> Detail
                                        </button>
                                        <a href="<?php echo e(route('order.progress', $o->id)); ?>" onclick="return confirm('Melihat Proses Pesanan Akan Memerlukan Waktu, Lanjutkan?')"
                                            class="block px-2 py-1 text-xs rounded bg-blue-500 hover:bg-blue-400 text-white w-full text-center">
                                            <i class="ri-swap-2-fill"></i> Proses
                                        </a>
                                        <?php if(in_array($user->role, ['developer', 'salesman'])): ?>
                                            <a href="<?php echo e(route('order.edit', $o->id)); ?>"
                                                class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                                <i class="ri-file-edit-fill"></i> Edit
                                            </a>
                                            <a href="<?php echo e(route('order.delete', $o->id)); ?>"
                                                class="block px-2 py-1 text-xs rounded bg-gray-500 hover:bg-gray-400 text-white w-full text-center">
                                                <i class="ri-delete-back-2-fill"></i> Hapus
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php if(in_array($user->role, ['developer', 'salesman'])): ?>
                    <div class="fixed bottom-5 right-5 z-50">
                        <button type="submit"
                            class="px-5 py-3 bg-red-800 hover:bg-red-500 text-white text-xs md:text-sm rounded-lg shadow-lg font-bold focus:ring-4 focus:ring-red-300">
                            <i class="ri-check-double-fill mr-1"></i> Perbarui Pengecekan
                        </button>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
            <div class="mt-5 text-gray-600">
                <?php echo e($orders->links()); ?>

            </div>
        </div>

        <div class="block md:hidden">
            <div class="relative overflow-x-auto shadow-md rounded-lg">
                <form action="<?php echo e(route('order.updateChecked')); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('patch'); ?>
                    <table class="w-full text-sm text-left text-gray-600 border">
                        <thead class="text-xs font-bold text-white uppercase bg-red-800">
                            <tr>
                                <th class="px-2 py-2 w-7/12">PESANAN</th>
                                <th class="px-2 py-2 w-1/12">CEK</th>
                                <th class="px-2 py-2 w-4/12">STATUS</th>
                                <th class="px-2 py-2 w-1/12">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="text-xs px-2 py-2 font-medium text-gray-800">
                                        <?php echo e($o->OdrRefNum); ?> <br> <?php echo e($o->OdrDocDate->format('d-m-Y')); ?> <br>
                                        <span class="text-xs"><?php echo e($o->order_row_count); ?> Barang 
                                        <br> Cabang: <?php echo e($o->branch); ?></span>
                                        <br> Catatan: <?php echo e($o->note); ?></span><br><br>
                                        <?php echo e($o->customer->CardName); ?> <br> <?php echo e($o->OdrCrdCode); ?> <br><br>
                                        <?php echo e($o->salesman?->SlpName ?? 'DUMMY'); ?>

                                    </td>
                                    <td class="text-xs px-2 py-2 text-center">
                                        <?php if($o->is_synced === 1): ?>
                                            <!-- Checkbox hanya untuk tampilan -->
                                            <input type="checkbox" checked disabled
                                                class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">

                                            <!-- Hidden input agar value tetap terkirim -->
                                            <input type="hidden" name="is_checked[]" value="<?php echo e($o->id); ?>">
                                        <?php else: ?>
                                            <input type="checkbox" 
                                                name="is_checked[]" 
                                                value="<?php echo e($o->id); ?>"
                                                data-sales="<?php echo e($o->OdrSlpCode); ?>"
                                                class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500"
                                                <?php echo e($o->is_checked === 1 ? 'checked' : ''); ?>>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-xs px-2 py-2 font-medium">
                                        <div class="mt-2">STATUS WEB:</div>
                                        <?php if($o->is_synced === 1): ?>
                                            <span class="text-green-600 font-semibold">TERKIRIM</span>
                                        <?php else: ?>
                                            <span class="text-yellow-600 font-semibold">TERTUNDA</span>
                                        <?php endif; ?>
                                        <div class="mt-2">STATUS SAP:</div>
                                        <?php if(Str::contains(optional($o->ordrStatus)->pesanan_status, 'PESANAN TERTUNDA')): ?> 
                                            <span class="text-yellow-600 font-semibold"><?php echo e($o->ordrStatus->pesanan_status ?? ''); ?></span>
                                        <?php elseif(Str::contains(optional($o->ordrStatus)->pesanan_status, 'PESANAN SELESAI')): ?>
                                            <span class="text-green-600 font-semibold"><?php echo e($o->ordrStatus->pesanan_status ?? ''); ?></span>
                                        <?php elseif($o->ordrStatus->pesanan_status ?? '' === 'BELUM DIPROSES DI SAP'): ?>    
                                            <span class="text-gray-600 font-semibold"><?php echo e($o->ordrStatus->pesanan_status ?? ''); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-2 py-2 space-y-1">
                                        <button type="button" data-id="<?php echo e($o->id); ?>"
                                            data-OdrRefNum="<?php echo e($o->OdrRefNum); ?>"
                                            data-OdrDocDate="<?php echo e($o->OdrDocDate->format('d-m-Y')); ?>"
                                            data-OdrCardCode="<?php echo e($o->OdrCrdCode); ?>"
                                            data-OdrCardName="<?php echo e($o->customer->CardName); ?>"
                                            data-OdrSlpName="<?php echo e($o->salesman?->SlpName ?? 'DUMMY'); ?>"
                                            data-branch="<?php echo e($o->branch); ?>" data-note="<?php echo e($o->note); ?>"
                                            data-modal-target="detailModal" data-modal-toggle="detailModal"
                                            class="btn-detail open-modal-ordr-btn block px-2 py-1 text-xs rounded bg-red-800 hover:bg-red-500 w-full text-white">
                                            <i class="ri-eye-fill"></i>
                                        </button>
                                        <a href="<?php echo e(route('order.progress', $o->id)); ?>" onclick="return confirm('Melihat Proses Pesanan Akan Memerlukan Waktu, Lanjutkan?')"
                                            class="block px-2 py-1 text-xs rounded bg-blue-500 hover:bg-blue-400 text-white w-full text-center">
                                            <i class="ri-swap-2-fill"></i> 
                                        </a>
                                        <?php if(in_array($user->role, ['developer', 'salesman'])): ?>
                                            <a href="<?php echo e(route('order.edit', $o->id)); ?>"
                                                class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                                <i class="ri-file-edit-fill"></i>
                                            </a>
                                            <a href="<?php echo e(route('order.delete', $o->id)); ?>"
                                                class="block px-2 py-1 text-xs rounded bg-gray-500 hover:bg-gray-400 text-white w-full text-center">
                                                <i class="ri-delete-back-2-fill"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php if(in_array($user->role, ['developer', 'salesman'])): ?>
                    <div class="fixed bottom-4 right-4 left-4 md:left-auto flex justify-center md:justify-end z-[9999]">
                        <button type="submit"
                            class="w-full md:w-auto px-5 py-3 bg-red-800 hover:bg-red-600 text-white text-sm font-bold rounded-xl shadow-lg focus:ring-4 focus:ring-red-300 transition-all">
                            <i class="ri-check-double-fill mr-1"></i> Perbarui Pengecekan
                        </button>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
            <div class="mt-5 text-gray-600">
                <?php echo e($orders->links()); ?>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div id="detailModal" tabindex="-1"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="relative w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="relative rounded-lg shadow bg-white border border-gray-200">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <h2 class="text-base font-bold text-gray-700">Detail Pesanan</h2>
                    <button type="button"
                        class="text-gray-500 hover:text-gray-800 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                        data-modal-hide="detailModal">✕</button>
                </div>

                <!-- Modal body -->
                <div class="px-5 py-4 space-y-4 text-sm text-gray-700">

                    <!-- Info Pesanan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <p><span class="font-medium">Nomor Pesanan:</span> <span id="modalOdrRefNum"></span></p>
                        <p><span class="font-medium">Tanggal Pesanan:</span> <span id="modalOdrDocDate"></span></p>
                        <p><span class="font-medium">Kode Pelanggan:</span> <span id="modalOdrCardCode"></span></p>
                        <p><span class="font-medium">Nama Pelanggan:</span> <span id="modalOdrCardName"></span></p>
                        <p><span class="font-medium">Cabang Pelanggan:</span> <span id="modalbranch"></span></p>
                        <p><span class="font-medium">Nama Penjual:</span> <span id="modalOdrSlpName"></span></p>
                        <p class="sm:col-span-2"><span class="font-medium">Catatan:</span> <span id="modalnote"></span></p>
                    </div>

                    <!-- Detail Barang -->
                    <h2 class="text-base font-bold mt-4 text-gray-700">Detail Barang</h2>

                    <!-- Mobile view: list -->
                    <div class="block sm:hidden space-y-3" id="detailRowsMobile"></div>

                    <!-- Desktop view: table -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="w-full border text-sm text-gray-700">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2">No</th>
                                    <th class="border p-2">Kode Barang</th>
                                    <th class="border p-2">Deskripsi Barang</th>
                                    <th class="border p-2">Harga</th>
                                    <th class="border p-2">Diskon</th>
                                    <th class="border p-2">Kuantitas</th>
                                    <th class="border p-2">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detailRows"></tbody>
                        </table>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil role & daftar divisi user dari backend
    const userRole = <?php echo json_encode($user->role ?? '', 15, 512) ?>;
    const userDivisions = <?php echo json_encode($user->divisions->pluck('div_name') ?? [], 15, 512) ?>;

    // Divisi yang tidak boleh lihat kode barang di mobile
    const restrictedDivisions = ['LUB IDS', 'LUB RTL'];

    // Tentukan apakah user termasuk yang dibatasi
    const hideItemCodeMobile = (
        userRole === 'salesman' &&
        userDivisions.some(div => restrictedDivisions.includes(div))
    );

    const buttonsView = document.querySelectorAll('.open-modal-ordr-btn');

    buttonsView.forEach(button => {
        button.addEventListener('click', function() {
            const OdrRefNum = this.getAttribute('data-OdrRefNum');
            const OdrDocDate = this.getAttribute('data-OdrDocDate');
            const OdrCardCode = this.getAttribute('data-OdrCardCode');
            const OdrCardName = this.getAttribute('data-OdrCardName');
            const OdrSlpName = this.getAttribute('data-OdrSlpName');
            const branch = this.getAttribute('data-branch');
            const note = this.getAttribute('data-note');

            // Set data header modal
            document.getElementById("modalOdrRefNum").innerText = OdrRefNum;
            document.getElementById("modalOdrDocDate").innerText = OdrDocDate;
            document.getElementById("modalOdrCardCode").innerText = OdrCardCode;
            document.getElementById("modalOdrCardName").innerText = OdrCardName;
            document.getElementById("modalOdrSlpName").innerText = OdrSlpName;
            document.getElementById("modalbranch").innerText = branch;
            document.getElementById("modalnote").innerText = note;

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Ambil data detail order
            const id = this.getAttribute('data-id');
            fetch(`/pesanan/${id}/detail`)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('detailRows');
                    const mobileList = document.getElementById('detailRowsMobile');
                    tbody.innerHTML = "";
                    mobileList.innerHTML = "";

                    let totalQty = 0;
                    let totalSubtotal = 0;

                    // Fungsi format angka
                    const formatNumber = (num) => Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    data.forEach((item, index) => {
                        const no = index + 1;
                        const qty = parseFloat(item.RdrItemQuantity) || 0;
                        const price = parseFloat(item.RdrItemPrice) || 0;
                        const discPercent = isNaN(parseFloat(item.RdrItemDisc)) ? 0 : parseFloat(item.RdrItemDisc);
                        const subtotal = qty * (price * (1 - discPercent / 100));

                        totalQty += qty;
                        totalSubtotal += subtotal;

                        // ✅ Desktop view (selalu tampil lengkap)
                        tbody.innerHTML += `
                            <tr>
                                <td class="border p-2 text-center">${no}</td>
                                <td class="border p-2">${item.RdrItemCode}</td>
                                <td class="border p-2">${item.ItemName}</td>
                                <td class="border p-2 text-right">${formatNumber(price)}</td>
                                <td class="border p-2 text-right">${discPercent ? discPercent + '%' : '-'}</td>
                                <td class="border p-2 text-right">${formatNumber(qty)}</td>
                                <td class="border p-2 text-right font-semibold">${formatNumber(subtotal)}</td>
                            </tr>
                        `;

                        // ✅ Mobile view (kode barang bisa disembunyikan)
                        mobileList.innerHTML += `
                            <div class="p-3 border rounded-lg bg-gray-50 shadow-sm">
                                <p><b>${no}. ${!hideItemCodeMobile ? item.RdrItemCode + ' - ' : ''}${item.ItemName}</b></p>
                                <p>Harga: ${formatNumber(price)}</p>
                                <p>Diskon: ${discPercent ? discPercent + '%' : '-'}</p>
                                <p>Kuantitas: ${formatNumber(qty)}</p>
                                <p><b>Subtotal: ${formatNumber(subtotal)}</b></p>
                            </div>
                        `;
                    });

                    // ✅ Tambahkan grand total
                    tbody.innerHTML += `
                        <tr class="bg-gray-100 font-bold">
                            <td colspan="5" class="border p-2 text-right">Grand Total</td>
                            <td class="border p-2 text-right">${formatNumber(totalQty)}</td>
                            <td class="border p-2 text-right">${formatNumber(totalSubtotal)}</td>
                        </tr>
                    `;

                    mobileList.innerHTML += `
                        <div class="p-3 mt-3 border-t font-bold text-right bg-gray-100 rounded-lg">
                            Total Kuantitas: ${formatNumber(totalQty)} <br>
                            Total Subtotal: ${formatNumber(totalSubtotal)}
                        </div>
                    `;
                });
        });
    });

    // Tutup modal
    document.querySelectorAll("[data-modal-hide]").forEach(btn => {
        btn.addEventListener("click", function() {
            const modal = document.getElementById(this.getAttribute("data-modal-hide"));
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        });
    });
});
</script>


<?php /**PATH C:\laragon\www\sapconnect\resources\views/ordr/ordr.blade.php ENDPATH**/ ?>