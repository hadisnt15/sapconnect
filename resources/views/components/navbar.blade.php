<nav class="bg-red-900" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="hidden md:block">
            <div class="grid grid-cols-[1fr_2fr_1fr] h-16 items-center">
                <div class="hidden md:block">
                    <div class="shrink-0 flex">
                        <img class="size-8 bg-indigo-50 rounded-full w-10 h-10 p-1" src="/img/kkj.png" alt="PT Kapuas Kencana Jaya" />
                        <div class="rounded-md px-3 py-2 text-sm font-medium text-white">
                            PT. KAPUAS KENCANA JAYA
                        </div>
                    </div>
                </div>
                <div class="hidden md:block mx-auto">
                    <div class="flex items-baseline space-x-1">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        @auth
                        <x-nav-link href="/" :active="request()->is('/')"><i class="ri-layout-grid-fill"></i> Dasbor</x-nav-link>
                        <x-nav-link href="{{ route('order') }}"
                            class="{{ Route::is('order', 'order.create', 'order.edit', 'order.delete') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"><i
                                class="ri-bill-fill"></i> Pesanan</x-nav-link>
                        <x-nav-link href="{{ route('item') }}" class="{{ Route::is('item') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"><i class="ri-settings-4-fill"></i> Barang</x-nav-link>
                        <x-nav-link href="{{ route('customer') }}"
                            class="{{ Route::is('customer', 'customer.create', 'customer.edit', 'customer.delete') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">
                            <i class="ri-account-circle-2-fill"></i> Pelanggan
                        </x-nav-link>
                        @if(in_array(auth()->user()->role, ['developer', 'manager', 'supervisor']))
                        <x-nav-link href="{{ route('salesman') }}"
                            class="{{ Route::is('salesman', 'salesman.registration') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"><i
                                class="ri-group-2-fill"></i> Penjual</x-nav-link>
                        <x-nav-link href="{{ route('user') }}"
                            class="{{ Route::is('user', 'user.register', 'user.edit', 'user.delete') ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"><i
                                class="ri-user-follow-fill"></i> Pengguna</x-nav-link>
                        @endif
                        @endauth
                    </div>
                </div>
                <div class="hidden md:block ml-auto">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="rounded-md px-3 py-2 text-sm font-medium text-white">
                            @auth
                                {{ auth()->user()->name }}
                            @else
                                Anda Belum Login
                            @endauth
                        </div>
                        <!-- Profile dropdown -->
                        @auth
                            <div class="relative ml-3">
                                <div>
                                    <button type="button" @click="isOpen = !isOpen"
                                        class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-hidden focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-gray-800"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="absolute -inset-1.5"></span>
                                        <span class="sr-only">Open user menu</span>
                                        <img class="size-8 rounded-full"
                                            src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profile-default.png') }}"
                                            alt="Profile" />

                                    </button>
                                </div>


                                <!--
                            Dropdown menu, show/hide based on menu state.

                            Entering: "transition ease-out duration-100"
                            From: "transform opacity-0 scale-95"
                            To: "transform opacity-100 scale-100"
                            Leaving: "transition ease-in duration-75"
                            From: "transform opacity-100 scale-100"
                            To: "transform opacity-0 scale-95"
                        -->
                                <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75 transform"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1">
                                    <!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                        tabindex="-1" id="user-menu-item-0">Profil Saya</a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700"
                                        role="menuitem" tabindex="-1" id="user-menu-item-1">Edit Profil</a>
                                    <a href="{{ route('password.edit') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                        tabindex="-1" id="user-menu-item-1">Ubah Kata Sandi</a>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit"
                                            class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="md:hidden">
            <!-- Mobile menu button -->
            <div class="grid grid-cols-[3fr_1fr] h-16 items-center">
                <div class="shrink-0 flex">
                    <img class="size-8 bg-indigo-50 rounded-full w-10 h-10 p-1" src="/img/kkj.png" alt="PT Kapuas Kencana Jaya" />
                    <div class="rounded-md px-3 py-2 text-sm font-medium text-white">
                        PT. KAPUAS KENCANA JAYA
                    </div>
                </div>
                <div class="ml-auto">
                    <button @click="isOpen = !isOpen" type="button"
                        class="relative inline-flex items-center justify-center rounded-md bg-red-700 p-2 text-white hover:bg-red-600 hover:text-white focus:ring-2"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <!-- Menu open: "hidden", Menu closed: "block" -->
                        <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                            data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!-- Menu open: "block", Menu closed: "hidden" -->
                        <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden size-6" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                            data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div>
            <div class="flex justify-between space-y-1 px-2 py-2">
                <x-nav-link href="/"
                    class="{{ Route::is('dashboard') ? 'bg-red-600 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-1 py-2 text-sm mt-1 font-medium">Dasbor</x-nav-link>
                <x-nav-link href="{{ route('order') }}"
                    class="{{ Route::is('order', 'order.create', 'order.edit') ? 'bg-red-600 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-1 py-2 text-sm font-medium">Pesanan</x-nav-link>
                <x-nav-link href="{{ route('item') }}"
                    class="{{ Route::is('item') ? 'bg-red-600 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-1 py-2 text-sm font-medium">Barang</x-nav-link>
                <x-nav-link href="{{ route('customer') }}"
                    class="{{ Route::is('customer', 'customer.create', 'customer.edit') ? 'bg-red-600 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-1 py-2 text-sm font-medium">
                    Pelanggan
                </x-nav-link>
                <x-nav-link href="{{ route('salesman') }}"
                    class="{{ Route::is('salesman', 'salesman.registration') ? 'bg-red-600 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-1 py-2 text-sm font-medium">Penjual</x-nav-link>
                <x-nav-link href="{{ route('user') }}"
                    class="{{ Route::is('user') ? 'bg-red-600 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-1 py-2 text-sm font-medium">Pengguna</x-nav-link>
            </div>
        </div>
        @auth
            <div class="border-t border-red-200 pt-4 pb-3">
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img class="size-10 rounded-full" src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profile-default.png') }}" alt="Profile" />
                    </div>
                    <div class="ml-3">
                        <div class="text-base/5 font-medium text-white">{{ auth()->user()->name }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ route('profile') }}"
                        class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-red-700 hover:text-white">Profil
                        Saya</a>
                    <a href="{{ route('profile.edit') }}"
                        class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-red-700 hover:text-white">Edit
                        Profil</a>
                    <a href="{{ route('password.edit') }}"
                        class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-red-700 hover:text-white">Ubah Kata Sandi</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit"
                            class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-red-700 hover:text-white">Logout</button>
                    </form>
                </div>
            </div>
        @else
            <div class="rounded-md px-3 py-2 text-sm font-medium text-white">Anda Belum Login</div>
        @endauth
    </div>
</nav>
