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
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-group-2-fill text-red-800"></i> {{ $titleHeader }}
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
                <a href="{{ route('user.register') }}"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-user-add-fill"></i> Daftarkan Pengguna Baru
                </a>
                @can('user.active')
                <a href="{{ route('user.active') }}"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-user-add-fill"></i> Pengguna Aktif
                </a>
                @endcan
                @can('user.device')
                <a href="{{ route('user.device') }}"
                    class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                    <i class="ri-user-add-fill"></i> Perangkat Pengguna
                </a>
                @endcan
            </div>
        </div>

        <!-- Table -->
        <div class="md:block hidden relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="text-xs font-bold text-white uppercase bg-red-800">
                    <tr>
                        <th class="px-2 py-2 text-center w-4/12">Nama Lengkap / Nama Pengguna</th>
                        <th class="px-2 py-2 text-center w-2/12">Email / Telepon</th>
                        <th class="px-2 py-2 text-center w-2/12">Posisi / Divisi</th>
                        <th class="px-2 py-2 text-center w-2/12">Dibuat Tanggal</th>
                        <th class="px-2 py-2 text-center w-1/12">Keaktifan</th>
                        <th class="px-2 py-2 text-center w-2/12">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $u)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-2 py-2 font-medium text-gray-800">
                                {{ $u->name }} <br> {{ $u->username }}
                            </td>
                            <td class="px-2 py-2 font-medium text-gray-800">
                                {{ $u->email ?? '---' }} <br> {{ $u->phone }}
                            </td>
                            <td class="px-2 py-2 font-medium text-gray-800">
                                @if ($u->role === 'salesman')
                                    Penjual
                                @elseif ($u->role === 'supervisor')
                                    Admin
                                @elseif ($u->role === 'manager')
                                    Manajer
                                @elseif ($u->role === 'developer')
                                    IT
                                @endif
                                <br> 
                                {{ $u->divisions->pluck('div_name')->implode(', ') }}
                            </td>
                            <td class="px-2 py-2 font-medium text-gray-800">
                                {{ $u->created_at }}
                            </td>
                            <td class="px-2 py-2 font-medium text-gray-800">
                                @if ($u->is_active == '1')
                                    Aktif
                                @else
                                    Tidak Aktif
                                @endif
                            </td>
                            <td class="px-2 py-2 space-y-2">
                                <a href="{{ route('user.edit', $u->id) }}"
                                    class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                    <i class="ri-file-edit-fill"></i> Edit
                                </a>
                                <a href="{{ route('user.editDivision', $u->id) }}"
                                    class="block px-2 py-1 text-xs rounded bg-green-500 hover:bg-green-400 text-white w-full text-center">
                                    <i class="ri-file-edit-fill"></i> Divisi
                                </a>
                            </td>
                        </tr>
                    @endforeach
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
                    @foreach ($user as $u)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-800">
                                <span class="font-bold mb-3">{{ $u->name }} / {{ $u->username }}</span><br>
                                Kontak: <br>
                                <span class="font-medium mb-3 ms-3">{{ $u->email ?? '---' }} /
                                    {{ $u->phone }}</span><br>
                                Posisi: <br>
                                <span class="font-medium mb-3 ms-3">
                                    @if ($u->role === 'salesman')
                                        Penjual
                                    @elseif ($u->role === 'supervisor')
                                        Admin
                                    @elseif ($u->role === 'manager')
                                        Manajer
                                    @elseif ($u->role === 'developer')
                                        IT
                                    @endif
                                </span><br>
                                Divisi: <br>
                                <span class="font-medium mb-3 ms-3">{{ $u->divisions->pluck('div_name')->implode(', ') }}</span> <br>
                                Keaktifan: <br>
                                <span class="font-medium mb-3 ms-3">
                                    @if ($u->is_active == '1')
                                        Aktif
                                    @else
                                        Tidak Aktif
                                    @endif
                                </span><br>
                                Terdaftar Sejak: <br>
                                <span class="font-medium ms-3">{{ $u->created_at }}</span>
                            </td>
                            <td class="px-6 py-4 space-y-1">
                                <a href="{{ route('user.edit', $u->id) }}"
                                    class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                    <i class="ri-file-edit-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-5 text-gray-600">
            {{ $user->links() }} 
        </div>
    </div>
</x-layout>
