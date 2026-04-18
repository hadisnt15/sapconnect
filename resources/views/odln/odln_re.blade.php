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
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-bill-fill text-red-800"></i> {{ $titleHeader }}
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
                            placeholder="Cari Surat Jalan" />
                        <button type="submit"
                            class="text-white absolute end-2 bottom-1.5 font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto flex items-center gap-2">
                @can('delivery.push')
                    <a href="{{ route('reDelivery.push') }}"
                        class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                        <i class="ri-upload-cloud-2-fill"></i> Kirim ke SAP
                    </a>
                @endcan
            </div>
        </div>
        <form method="GET" action="{{ route('re.delivery') }}" 
            class="flex flex-col md:flex-row md:justify-start md:items-center gap-2 md:gap-3 mb-3">

            <div class="flex flex-col sm:flex-row gap-1 md:gap-1 items-start md:items-center">

                <!-- 🔹 Select Filter -->
                <select name="checked" onchange="this.form.submit()" 
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">
                    <option value="">Tanpa Filter</option>
                    <option value="1" {{ request('checked') == '1' ? 'selected' : '' }}>Diceklis</option>
                    <option value="0" {{ request('checked') == '0' ? 'selected' : '' }}>Belum Diceklis</option>
                    <option value="2" {{ request('checked') == '2' ? 'selected' : '' }}>Terkirim</option>
                    <option value="3" {{ request('checked') == '3' ? 'selected' : '' }}>Belum Dikirim</option>
                </select>

                <!-- 🔹 Date Range -->
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">

                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="bg-gray-50 border border-gray-300 text-xs rounded-md text-gray-700 focus:ring focus:ring-indigo-200 py-1 px-2 w-full sm:w-auto">

                <!-- 🔹 Filter Button -->
                <button type="submit"
                    class="px-3 py-1 bg-red-800 hover:bg-red-500 text-white text-xs rounded-md shadow font-semibold w-full sm:w-auto">
                    Filter
                </button>
            </div>
        </form>




        <!-- Table -->
        <div class="hidden md:block">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <form action="{{ route('reDelivery.updateChecked') }}" method="POST">
                    @csrf @method('patch')
                    <table class="w-full text-sm text-left text-gray-600 border">
                        <thead class="text-xs font-bold text-white uppercase bg-red-800">
                            <tr>
                                <th class="px-2 py-2 w-3/12">SURAT JALAN</th>
                                <th class="px-2 py-2 w-2/12">PELANGGAN</th>
                                <th class="px-2 py-2 w-5/12">KETERANGAN</th>
                                <th class="px-2 py-2 w-1/12">CEKLIS</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($reDeliveries as $q)
                                <div class="hover:bg-gray-50">
                                    <tr class="bg-white">
                                        <td class="px-2 py-2 font-medium text-gray-800">
                                            No Ref SJ: {{ $q->mainOdln->ref_sj }} | {{ \Carbon\Carbon::parse($q->tgl_sj)->format('d/m/Y') }} <br> 
                                            No Dokumen SJ: {{ $q->no_sj }} <br> 
                                            Pengiriman Ulang ke: {{ $q->kirim_ke }} <br> 
                                            Freegood: {{ $q->mainOdln->freegood }} <br> 
                                            
                                        </td>
                                        <td class="px-2 py-2 font-medium text-gray-800">
                                            {{ $q->mainOdln->nama_customer }} <br> 
                                            {{ $q->mainOdln->kode_customer }} 
                                        </td>
                                        <td class="px-2 py-2 font-medium text-gray-800">
                                            @if ($q->is_synced === 1)
                                                <textarea rows="3" type="text" name="notes[{{ $q->id }}]" autocomplete="off" readonly
                                                    class="bg-gray-300 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ $q->ket }}</textarea>
                                            @else
                                                <textarea rows="3" type="text" name="notes[{{ $q->id }}]" autocomplete="off" 
                                                    class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ $q->ket }}</textarea>
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            @if ($q->is_synced === 1)
                                                <!-- Checkbox hanya untuk tampilan -->
                                                <input type="checkbox" checked disabled
                                                    class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
    
                                                <!-- Hidden input agar value tetap terkirim -->
                                                <input type="hidden" name="is_checked[]" value="{{ $q->id }}">
                                            @else
                                                <input type="checkbox" 
                                                    name="is_checked[]" 
                                                    value="{{ $q->id }}"
                                                    class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500"
                                                    {{ $q->is_checked === 1 ? 'checked' : '' }}>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b ">
                                        <td colspan="4" class="px-2 font-semibold">
                                            @if ($q->is_synced === 1)
                                                <span class="text-green-600 font-semibold">TERKIRIM</span>
                                            @else
                                                <span class="text-yellow-600 font-semibold">BELUM DIKIRIM</span>
                                            @endif. Catatan Sales: {{ $q->mainOdln->note_so }}
                                        </td>
                                    </tr>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                    @if (in_array($user->role, ['developer', 'warehouse']))
                    <div class="fixed bottom-5 right-5 z-50">
                        <button type="submit"
                            class="px-5 py-3 bg-red-800 hover:bg-red-500 text-white text-xs md:text-sm rounded-lg shadow-lg font-bold focus:ring-4 focus:ring-red-300">
                            <i class="ri-check-double-fill mr-1"></i> Perbarui Pengecekan
                        </button>
                    </div>
                    @endif
                </form>
            </div>
            <div class="mt-5 text-gray-600">
                {{ $reDeliveries->links() }}
            </div>
        </div>

        <div class="block md:hidden">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <form action="{{ route('reDelivery.updateChecked') }}" method="POST">
                    @csrf @method('patch')
                    <table class="w-full text-sm text-left text-gray-600 border">
                        <thead class="text-xs font-bold text-white uppercase bg-red-800">
                            <tr>
                                <th class="px-2 py-2 w-11/12">SURAT JALAN</th>
                                {{-- <th class="px-2 py-2 w-5/12">KETERANGAN</th> --}}
                                {{-- <th class="px-2 py-2 w-1/12">CEKLIS</th> --}}
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($reDeliveries as $q)
                                <div class="hover:bg-gray-50">
                                    <tr class="bg-white border-b">
                                        <td class="px-2 py-2 font-medium text-gray-800">
                                            <div class="flex justify-between">
                                                <div>
                                                    <span>No Ref SJ: {{ $q->mainOdln->ref_sj }} | {{ \Carbon\Carbon::parse($q->tgl_sj)->format('d/m/Y') }}</span> <br>
                                                    <span>No Dokumen SJ: {{ $q->no_sj }}</span> <br>
                                                    <span>
                                                        Freegood: {{ $q->mainOdln->freegood }} |
                                                        @if ($q->is_synced === 1)
                                                            <span class="text-green-600 font-semibold">TERKIRIM</span>
                                                        @else
                                                            <span class="text-yellow-600 font-semibold">BELUM DIKIRIM</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div>
                                                    @if(in_array(auth()->user()->role, ['developer', 'manager']))
                                                        @if($q->is_synced)
                                                            <button type="submit"
                                                                form="allow-return-{{ $q->id }}"
                                                                class="px-3 py-1 bg-blue-600 hover:bg-blue-500 text-white text-xs rounded">
                                                                Buka Izin <br> Kirim Kembali
                                                            </button>
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        <span class="text-gray-500 text-xs">
                                                            {{ $q->is_return_allowed ? 'DIIZINKAN' : '-' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                {{ $q->mainOdln->nama_customer }} <br> {{ $q->mainOdln->kode_customer }} 
                                            </div>
                                            <div class="mt-4">
                                                Catatan Sales: {{ $q->mainOdln->note_so }}
                                            </div>
                                            <div class="grid grid-cols-[11fr_1fr] gap-2 mt-2">
                                                <div>
                                                    @if ($q->is_synced === 1)
                                                        <textarea type="text" name="notes[{{ $q->id }}]" autocomplete="off" readonly rows="3"
                                                            class="bg-gray-300 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ $q->ket }}</textarea>
                                                    @else
                                                        <textarea type="text" name="notes[{{ $q->id }}]" autocomplete="off" rows="3"
                                                            class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ $q->ket }}</textarea>
                                                    @endif
                                                </div>
                                                <div class="">
                                                    @if ($q->is_synced === 1)
                                                        <!-- Checkbox hanya untuk tampilan -->
                                                        <input type="checkbox" checked disabled
                                                            class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
            
                                                        <!-- Hidden input agar value tetap terkirim -->
                                                        <input type="hidden" name="is_checked[]" value="{{ $q->id }}">
                                                    @else
                                                        <input type="checkbox" 
                                                            name="is_checked[]" 
                                                            value="{{ $q->id }}"
                                                            class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500"
                                                            {{ $q->is_checked === 1 ? 'checked' : '' }}>
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td class="px-2 py-2 font-medium text-gray-800">
                                            @if ($q->is_synced === 1)
                                                <input type="text" name="notes[{{ $q->id }}]" autocomplete="off" value="{{ $q->ket }}" readonly
                                                    class="bg-gray-300 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            @else
                                                <input type="text" name="notes[{{ $q->id }}]" autocomplete="off" value="{{ $q->ket }}" 
                                                    class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            @endif
                                        </td> --}}
                                        {{-- <td class="px-2 py-2 text-center">
                                            @if ($q->is_synced === 1)
                                                <!-- Checkbox hanya untuk tampilan -->
                                                <input type="checkbox" checked disabled
                                                    class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
    
                                                <!-- Hidden input agar value tetap terkirim -->
                                                <input type="hidden" name="is_checked[]" value="{{ $q->id }}">
                                            @else
                                                <input type="checkbox" 
                                                    name="is_checked[]" 
                                                    value="{{ $q->id }}"
                                                    class="w-4 h-4 text-red-800 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500"
                                                    {{ $q->is_checked === 1 ? 'checked' : '' }}>
                                            @endif
                                        </td> --}}
                                    </tr>
                                    
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                    @if (in_array($user->role, ['developer', 'warehouse']))
                    <div class="fixed bottom-5 right-5 z-50">
                        <button type="submit"
                            class="px-5 py-3 bg-red-800 hover:bg-red-500 text-white text-xs md:text-sm rounded-lg shadow-lg font-bold focus:ring-4 focus:ring-red-300">
                            <i class="ri-check-double-fill mr-1"></i> Perbarui Pengecekan
                        </button>
                    </div>
                    @endif
                </form>
            </div>
            <div class="mt-5 text-gray-600">
                {{ $reDeliveries->links() }}
            </div>
        </div>
    </div>

</x-layout>


<script>
function countdown(startTime) {
    return {
        time: '',
        interval: null,

        start() {
            if (!startTime) return;

            this.updateTime();

            this.interval = setInterval(() => {
                this.updateTime();
            }, 1000);
        },

        updateTime() {
            let start = new Date(startTime);
            let end = new Date(start.getTime() + 5 * 60 * 1000); // +1 jam
            let now = new Date();

            let diff = end - now;

            if (diff <= 0) {
                this.time = 'EXPIRED';
                clearInterval(this.interval);
                return;
            }

            let minutes = Math.floor(diff / 60000);
            let seconds = Math.floor((diff % 60000) / 1000);

            this.time = `${minutes}:${seconds}`;
        }
    }
}
</script>
