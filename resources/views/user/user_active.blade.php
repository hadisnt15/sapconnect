<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('user') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-red-600">
                        <i class="ri-account-circle-2-fill me-1"></i> Daftar Pengguna
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-group-2-fill"></i> {{ $titleHeader }}
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

            </div>
        </div>

        <!-- Table -->
        <div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600 border">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                        <tr>
                            <th class="px-6 py-3">Nama Lengkap / Username</th>
                            <th class="px-6 py-3">Email / Telepon</th>
                            <th class="px-6 py-3">Posisi</th>
                            <th class="px-6 py-3">Alamat IP</th>
                            <th class="px-6 py-3">Aktivitas Terakhir</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $u)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $u['user']->name ?? 'Tidak Diketahui' }} <br> {{ $u['user']->username ?? '-' }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $u['user']->email }} <br> {{ $u['user']->phone }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    @if ($u['user']->role === 'salesman')
                                        Penjual
                                    @elseif ($u['user']->role === 'supervisor')
                                        Admin
                                    @elseif ($u['user']->role === 'manager')
                                        Manajer
                                    @elseif ($u['user']->role === 'developer')
                                        IT
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $u['ip'] }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $u['last_activity'] }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('user.kick', $u['user']->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menendang user ini?')"> @csrf
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-xs rounded-lg px-3 py-1 bg-amber-600 hover:bg-amber-700 text-white">
                                            <i class="ri-file-edit-fill"></i> Tendang
                                        </button>
                                    </form>
                                    {{-- 
                                    <form action="{{ route('user.delete', $u->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus pengguna ini?');" class="inline">
                                        @csrf @method('patch')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-xs rounded-lg px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white">
                                            <i class="ri-delete-back-2-fill"></i> Hapus
                                        </button>
                                    </form> 
                                    --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5 text-gray-600">
            {{-- {{ $user->links() }} --}}
        </div>
    </div>
</x-layout>
