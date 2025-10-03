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

        <div class="mx-auto w-full md:w-1/2 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
            <h2 class="text-sm font-medium text-gray-700 mb-3">Kelola Divisi untuk {{ $user->name }}</h2>
            <!-- Form -->
            <form action="{{ route('user.updateDivision', $user->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Divisi:</label>
                    @foreach ($divisions as $division)
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="divisions[]" value="{{ $division->id }}"
                                {{ $user->divisions->contains($division->id) ? 'checked' : '' }}
                                class="w-4 h-4 text-red-800 rounded border-gray-300 focus:ring-red-500">
                            <label class="ml-2 text-sm text-gray-700">{{ $division->div_name }} - {{ $division->div_desc }}</label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="w-full mt-3 bg-red-800 hover:bg-red-600 font-medium text-white rounded-lg text-sm px-5 py-2.5 text-center">
                    <i class="ri-save-3-fill"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</x-layout>

<script>
    async function initSelect(index) {
        let response = await fetch('/pengguna/apiDiv');
        let data = await response.json();

        let select = document.getElementById('penggunaSelect' + index);

        new TomSelect(select, {
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            options: data,
            placeholder: 'Pilih Pengguna',
        });
    }

    async function initUserSelect(index) {
        let response = await fetch('/divisi/apiDiv');
        let data = await response.json();
        console.log("DATA DIVISI API:", data);
        let select = document.getElementById('divisiSelect' + index);
        console.log("SELECT ELEM:", select);

        new TomSelect(select, {
            valueField: 'id',
            labelField: 'div_name',
            searchField: ['div_name'],
            options: data,
            placeholder: 'Pilih Divisi',
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initSelect(0);
        initUserSelect(0);
    });
</script>