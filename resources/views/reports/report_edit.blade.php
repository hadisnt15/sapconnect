<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-300 py-2 px-2 bg-white">
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('report') }}"
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
                            <i class="ri-folder-add-fill"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <form class="mx-auto md:w-3/4 mb-4" action="{{ route('report.update', $report->id) }}" method="POST"> @csrf @method('put')
            <div class="mb-2">
                <label for="name" class="mb-2 text-sm font-medium text-gray-700">Nama Laporan</label>
                <input type="text" id="name" name="name" value="{{ old('name', $report->name) }}" autocomplete="off"
                    class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                    placeholder="Nama Laporan" required />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="category" class="mb-2 text-sm font-medium text-gray-700">Kategori Laporan</label>
                <select name="category" id="category"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5">
                    <option value="{{ $report->category }}">{{ $report->category }}</option>
                    <option value="Penjualan Semua">Penjualan Semua</option>
                    <option value="Penjualan IDS">Penjualan IDS</option>
                    <option value="Penjualan RTL">Penjualan RTL</option>
                    <option value="Penjualan IDP">Penjualan IDP</option>
                    <option value="Pembelian">Pembelian</option>
                    <option value="Persediaan">Persediaan</option>
                    <option value="Piutang">Piutang</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
                @error('category')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                @enderror
            </div>
            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi Laporan</label>
                <textarea id="description" name="description" rows="3" autocomplete="off"
                    class="block p-2.5 w-full text-sm rounded-lg border bg-gray-100 border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600"
                    placeholder="Deskripsi Laporan">{{ old('description', $report->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="mt-3 w-full bg-red-800 hover:bg-red-500 text-white py-2 rounded-lg text-sm font-medium">
                Daftarkan Laporan Baru
            </button>
        </form>
        
    </div>


</x-layout>


