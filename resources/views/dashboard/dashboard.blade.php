<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>
    
    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-home-office-fill"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
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
                    
                    <div class="px-2 pb-4 text-gray-800 text-xs md:text-sm font-semibold pt-1">
                        <p>Platform terintegrasi untuk menghubungkan pengguna internal perusahaan dengan SAP Business One.</p>
                    </div>
                    
                    <div id="accordion-collapse" data-accordion="collapse"
                        class="rounded-xl overflow-hidden shadow-md border border-gray-300">
            
                        <!-- ITEM 1: Pemberitahuan -->
                        <h2 id="accordion-heading-1">
                            <button type="button"
                                class="accordion-btn flex items-center justify-between w-full p-5 font-semibold text-red-800 bg-gray-50 border-b border-gray-300 hover:bg-red-800 hover:text-white transition-colors duration-200"
                                data-target="#accordion-body-1" aria-expanded="false">
                                <span class="text-xs md:text-sm"><i class="ri-notification-4-fill"></i> Pemberitahuan</span>
                                <svg class="w-4 h-4 rotate-0 shrink-0 transition-transform duration-200"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-body-1" class="hidden bg-white">
                            <div class="p-5 border-t border-gray-300 text-gray-600 font-medium text-xs md:text-sm">
                                @if( $user->role === 'salesman')
                                    <h2 class="mb-2 text-md font-semibold">Aktivitas Harian</h2>
                                    <ul class="ms-2 space-y-1 list-inside">
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Hari ini Anda telah membuat sebanyak {{ $dailyOrder }} pesanan.
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Sebanyak {{ $dailyOrderSynced }} pesanan sudah berhasil dikirim ke SAP hari ini.
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Terdapat {{ $dailyOrderNotSyncedUncheck }} pesanan hari ini yang belum diceklis, mohon diperiksa terlebih dahulu.
                                        </li>
                                    </ul>
                                    <h2 class="mt-4 mb-2 text-md font-semibold">Aktivitas Bulanan</h2>
                                    <ul class="ms-2 space-y-1 list-none list-inside">
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Bulan ini Anda telah membuat sebanyak {{ $monthlyOrder }} pesanan.
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Sebanyak {{ $monthlyOrderSynced }} pesanan sudah berhasil dikirim ke SAP bulan ini.
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Terdapat {{ $monthlyOrderNotSyncedUncheck }} pesanan bulan ini yang belum diceklis, mohon diperiksa terlebih dahulu.
                                        </li>
                                    </ul>
                                @else
                                    <h2 class="mb-2 text-md font-semibold">Aktivitas Harian</h2>
                                    <ul class="ms-2 space-y-1 list-inside">
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Hari ini terdapat total {{ $dailyOrder }} pesanan dari cabang dan divisi Anda.
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Sebanyak {{ $dailyOrderSynced }} pesanan sudah berhasil dikirim ke SAP hari ini.
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Terdapat {{ $dailyOrderNotSyncedUncheck }} pesanan hari ini yang belum diceklis, masih menunggu pemeriksaan dari Sales terlebih dahulu.
                                        </li>
                                    </ul>
                                    <h2 class="mt-4 mb-2 text-md font-semibold">Aktivitas Bulanan</h2>
                                    <ul class="ms-2 space-y-1 list-none list-inside">
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Hari ini terdapat total {{ $monthlyOrder }} pesanan dari cabang dan divisi anda.
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Sebanyak {{ $monthlyOrderSynced }} pesanan sudah berhasil dikirim ke SAP bulan ini.
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-multiple-blank-fill"></i> Terdapat {{ $monthlyOrderNotSyncedUncheck }} pesanan bulan ini yang belum diceklis, masih menunggu pemeriksaan dari Sales terlebih dahulu.
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
            
                        <!-- ITEM 2: Tentang SAP Business One -->
                        <h2 id="accordion-heading-2">
                            <button type="button"
                                class="accordion-btn flex items-center justify-between w-full p-5 font-semibold text-red-800 bg-gray-50 border-t border-b border-gray-300 hover:bg-red-800 hover:text-white transition-colors duration-200"
                                data-target="#accordion-body-2" aria-expanded="false">
                                <span class="text-xs md:text-sm"><i class="ri-database-2-fill"></i> Tentang SAP Business One</span>
                                <svg class="w-4 h-4 rotate-0 shrink-0 transition-transform duration-200"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-body-2" class="hidden bg-white">
                            <div class="p-5 border-t border-gray-300 text-gray-600 font-medium text-xs md:text-sm">
                                <p class="mb-3">
                                    SAP Business One adalah sistem yang membantu perusahaan mengelola berbagai kegiatan bisnis — seperti penjualan, pembelian, keuangan, dan persediaan — dalam satu aplikasi terpadu.
                                </p>
                                <p>
                                    Dengan SAP Business One, setiap bagian perusahaan dapat bekerja lebih teratur dan efisien. Data dari berbagai departemen diolah menjadi informasi yang jelas dan mudah dipahami, sehingga memudahkan manajemen dalam mengambil keputusan yang tepat dan cepat.
                                </p>
                            </div>
                        </div>
            
                        <!-- ITEM 3: Hubungan dengan SAP Connect -->
                        <h2 id="accordion-heading-3">
                            <button type="button"
                                class="accordion-btn flex items-center justify-between w-full p-5 font-semibold text-red-800 bg-gray-50 border-t border-b border-gray-300 hover:bg-red-800 hover:text-white transition-colors duration-200"
                                data-target="#accordion-body-3" aria-expanded="false">
                                <span class="text-xs md:text-sm"><i class="ri-code-box-fill"></i> Hubungan dengan SAP Connect</span>
                                <svg class="w-4 h-4 rotate-0 shrink-0 transition-transform duration-200"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-body-3" class="hidden bg-white">
                            <div class="p-5 border-t border-gray-300 text-gray-600 font-medium text-xs md:text-sm">
                                <p class="mb-3">
                                    SAP Connect PT Kapuas Kencana Jaya dikembangkan sebagai jembatan antara sistem SAP Business One dan pengguna internal perusahaan. Website ini menyajikan data dan laporan penting yang telah diproses dari sistem SAP, agar bisa diakses dengan lebih mudah, cepat, dan terjadwal.
                                </p>
                                <p>
                                    Dengan demikian, setiap pengguna dapat memperoleh informasi penting tanpa harus langsung masuk ke dalam sistem SAP, membuat proses kerja menjadi lebih efisien dan praktis.
                                </p>
                            </div>
                        </div>
            
                        <!-- ITEM 4: Panduan Menggunakan SAP Connect -->
                        <h2 id="accordion-heading-4">
                            <button type="button"
                                class="accordion-btn flex items-center justify-between w-full p-5 font-semibold text-red-800 bg-gray-50 border-t border-gray-300 hover:bg-red-800 hover:text-white rounded-b-xl transition-colors duration-200"
                                data-target="#accordion-body-4" aria-expanded="false">
                                <span class="text-xs md:text-sm"><i class="ri-book-open-fill"></i> Panduan Menggunakan SAP Connect</span>
                                <svg class="w-4 h-4 rotate-0 shrink-0 transition-transform duration-200"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-body-4" class="hidden bg-white rounded-b-xl">
                            <div class="p-5 border-t border-gray-300 text-gray-600 font-medium text-xs md:text-sm">
                                <p class="mb-3">Silakan unduh dan pelajari dokumen di bawah ini untuk panduan penggunaan website SAP Connect.</p>
                                <p>
                                    <a href="{{ asset('storage/panduan/SAPConnect-Untuk-Sales.pdf') }}" target="_blank">
                                        <i class="ri-folder-download-fill"></i> Panduan untuk Sales
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-layout>
<script>
    document.querySelectorAll('.accordion-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.querySelector(btn.dataset.target);
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            // Tutup semua item lain
            document.querySelectorAll('.accordion-btn').forEach(b => {
                b.classList.remove('bg-white');
                b.classList.add('bg-gray-50', 'text-red-800');
                b.setAttribute('aria-expanded', 'false');
                document.querySelector(b.dataset.target).classList.add('hidden');
            });

            // Jika belum terbuka, buka item ini
            if (!expanded) {
                btn.classList.remove('bg-gray-50');
                btn.classList.add('bg-white', 'text-red-800');
                btn.setAttribute('aria-expanded', 'true');
                target.classList.remove('hidden');
            }
        });
    });
</script>
