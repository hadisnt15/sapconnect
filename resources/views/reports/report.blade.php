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
                            <i class="ri-folder-6-fill"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4 items-center pb-4 w-full">
            <div>
                <form action="" method="get">
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <input type="text" id="search" name="search"
                            class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-100 border-gray-400 placeholder-gray-500 text-gray-900 focus:ring-indigo-600 focus:border-indigo-600"
                            placeholder="Cari Laporan" required />
                        <button type="submit"
                            class="absolute end-2 bottom-1.5 text-white font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500 focus:ring-2 focus:ring-indigo-600">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto">
                <div class="flex items-center">
                    @can('report.create')
                    <div class="me-2">
                        <a href="{{ route('report.create') }}"
                            class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                            <i class="ri-folder-add-fill"></i> Buat Laporan Baru
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-3 p-3">
            @foreach($report as $r)
            <article class="p-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 transition">
                <h5 class="font-medium tracking-tight text-gray-800">
                    {{ strtoupper($r->name) }}
                </h5>
                <div class="ml-auto w-full">
                    <div class="items-center justify-end">
                        <p class="text-sm p-3">{{ $r->description }}</p>
                        <a href="{{ route($r->route) }}" class="mt-2">
                            <span
                                class="border text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg bg-red-800 hover:bg-red-500 text-white transition">
                                <i class="ri-folder-open-fill"></i> Lihat Laporan
                            </span>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</x-layout>
