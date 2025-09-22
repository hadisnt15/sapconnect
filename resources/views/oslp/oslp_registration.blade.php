<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-4 px-6 bg-white">
        <!-- Breadcrumb -->
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('salesman') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-red-600">
                        <i class="ri-account-circle-2-fill me-1"></i> Daftar Penjual
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

        <!-- Form -->
        <div>
            <form class="mx-auto w-full md:w-1/2 bg-white p-6 rounded-lg border border-gray-200 shadow-sm"
                action="{{ route('salesman.store') }}" method="post">
                @csrf

                <!-- Kode Penjual -->
                <div x-data="{ items: [{}] }">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="mb-4">
                            <label :for="'salesmanSelect' + index"
                                class="mb-2 text-sm font-medium text-gray-700">Kode Penjual</label>
                            <select :id="'salesmanSelect' + index" name="RegSlpCode"
                                class="border rounded-lg p-2 w-full bg-gray-50 border-gray-300 text-gray-700 focus:ring focus:ring-indigo-200"></select>
                        </div>
                    </template>
                </div>

                <!-- Kode Pengguna -->
                <div x-data="{ items: [{}] }" x-init="$nextTick(() => initUserSelect(0))">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="mb-4">
                            <label :for="'userSelect' + index"
                                class="mb-2 text-sm font-medium text-gray-700">Kode Pengguna</label>
                            <select :id="'userSelect' + index" name="RegUserId"
                                class="border rounded-lg p-2 w-full bg-gray-50 border-gray-300 text-gray-700 focus:ring focus:ring-indigo-200"></select>
                        </div>
                    </template>
                </div>

                <!-- Alias -->
                <div class="mb-4">
                    <label class="mb-2 text-sm font-medium text-gray-700" for="Alias">Alias</label>
                    <input type="text" name="Alias" value="{{ old('Alias') }}" autocomplete="off"
                        class="bg-gray-50 border border-gray-300 placeholder-gray-400 text-sm rounded-lg text-gray-700 focus:ring focus:ring-indigo-200 w-full p-2.5"
                        placeholder="Inisial Penjual / Alias" required />
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="mt-3 w-full bg-red-800 hover:bg-red-600 font-medium text-white rounded-lg text-sm px-5 py-2.5 text-center">
                    <i class="ri-user-add-fill"></i> Daftarkan Salesman
                </button>
            </form>
        </div>
    </div>
</x-layout>

<script>
    async function initSelect(index) {
        let response = await fetch('/penjual/api');
        let data = await response.json();

        let select = document.getElementById('salesmanSelect' + index);

        new TomSelect(select, {
            valueField: 'SlpCode',
            labelField: 'SlpName',
            searchField: ['SlpCode', 'SlpName'],
            options: data,
            placeholder: 'Pilih Penjual',
        });
    }

    async function initUserSelect(index) {
        let response = await fetch('/pengguna/api');
        let data = await response.json();
        console.log("DATA USER API:", data);
        let select = document.getElementById('userSelect' + index);
        console.log("SELECT ELEM:", select);

        new TomSelect(select, {
            valueField: 'id',
            labelField: 'name',
            searchField: ['id', 'name'],
            options: data,
            placeholder: 'Pilih Pengguna',
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initSelect(0);
        initUserSelect(0);
    });
</script>
