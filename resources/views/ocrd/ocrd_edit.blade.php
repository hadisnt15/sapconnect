<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-300 py-2 px-2 bg-white">
        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('customer') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-800">
                        <i class="ri-account-circle-2-fill me-1"></i> Daftar Pelanggan 
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">
                    &rsaquo;&rsaquo;
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-group-2-fill"></i> {{ $titleHeader }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- DESKTOP --}}
        <form class="mx-auto" action="{{ route('customer.update', $cust->CardCode) }}" method="POST">
            @csrf @method('put')
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="mb-2">
                    <label for="CardCode" class="mb-2 text-sm font-medium text-gray-700">Kode Pelanggan</label>
                    <input type="text" id="CardCode" name="CardCode"
                        value="{{ old('CardCode', $cust->CardCode) }}" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Kode Pelanggan" required disabled />
                    @error('CardCode')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="CardName" class="mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" id="CardName" name="CardName"
                        value="{{ old('CardName', $cust->CardName) }}" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Nama Pelanggan" required />
                    @error('CardName')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="mb-2">
                    <label for="Contact" class="mb-2 text-sm font-medium text-gray-700">Kontak</label>
                    <input type="text" id="Contact" name="Contact"
                        value="{{ old('Contact', $cust->Contact) }}" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Kontak" required />
                    @error('Contact')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="Phone" class="mb-2 text-sm font-medium text-gray-700">Telepon</label>
                    <input type="number" id="Phone" name="Phone"
                        value="{{ old('Phone', $cust->Phone) }}" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Telepon" required />
                    @error('Phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="mb-2">
                    <label for="State" class="mb-2 text-sm font-medium text-gray-700">Provinsi</label>
                    <input type="text" id="State" name="State"
                        value="{{ old('State', $cust->State) }}" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Provinsi" required />
                    @error('State')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="City" class="mb-2 text-sm font-medium text-gray-700">Kota/Kab</label>
                    <input type="text" id="City" name="City"
                        value="{{ old('City', $cust->City) }}" autocomplete="off"
                        class="bg-gray-100 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Kota/Kab" required />
                    @error('City')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="Address" class="block mb-2 text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="Address" name="Address" rows="3" autocomplete="off"
                    class="block p-2.5 w-full text-sm rounded-lg border bg-gray-100 border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600"
                    placeholder="Alamat">{{ old('Address', $cust->Address) }}</textarea>
                @error('Address')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <input type="hidden" value="PELANGGAN BARU" id="Type1" name="Type1">

            <button type="submit"
                class="mt-3 w-full bg-red-800 hover:bg-red-500 text-white py-2 rounded-lg text-sm font-medium">
                Perbarui Data Pelanggan
            </button>
        </form>
        {{-- END DESKTOP --}}
    </div>
</x-layout>
