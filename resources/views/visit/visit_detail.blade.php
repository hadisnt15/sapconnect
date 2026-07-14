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
                <li class="inline-flex items-center">
                    <a href="{{ route('visit') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-800">
                        <i class="ri-bill-fill"></i> Daftar Kunjungan
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-add-box-fill text-red-800"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="border rounded-lg bg-gray-50 border-gray-200 shadow-md p-2 space-y-3">
            <div class="relative py-4">
                <span class="absolute top-0 left-0 text-[10px] md:text-xs border border-red-200 font-medium text-red-800 bg-gray-100 rounded-full px-2 py-1">
                    Kartu Pelanggan
                </span>
                <img src="{{ Storage::url('pertamina.png') }}" alt="Pertamina Lubricants" class="absolute -top-7 md:-top-10 right-0 h-20 md:h-32 w-auto">
                <div class="flex justify-center mt-2">
                    <h1 class="text-2xl md:text-3xl font-bold md:tracking-widest text-gray-700">
                        REGION VI
                    </h1>
                </div>
            </div>
            <div class="relative py-4 border border-gray-100 rounded-lg shadow-lg shadow-gray-300">
                <div class="text-sm font-bold text-gray-800 border-b border-gray-300">
                    <span class="px-4">Distributor</span>
                </div>
                <div class="text-md px-2 font-bold text-gray-800">
                    PT. KAPUAS KENCANA JAYA
                </div> 
                <div class="text-sm px-2 font-semibold text-gray-600">
                    Sales: {{ $visit->salesman->SlpName }}
                </div>
                <div class="text-sm px-2 font-semibold text-gray-600">
                    Tanggal Kunjungan: {{ \Carbon\Carbon::parse($visit->visit_date)->format('d/m/Y') }}
                </div>
            </div>
            <div class="grid md:grid-cols-[2fr_1fr] gap-4">
                <div class="relative py-4 border border-gray-100 rounded-lg shadow-lg shadow-gray-300">
                    <div class="text-sm font-bold text-gray-800 border-b border-gray-300">
                        <span class="px-4">Pelanggan</span>
                    </div>
                    <div class="py-2">
                        <div class="text-md font-semibold text-gray-600 px-2">
                            Nama Pelanggan: <span class="font-bold text-gray-800">{{ $visit->ocrd_card->card_name }}</span>
                        </div>
                        <div class="text-md font-semibold text-gray-600 px-2">
                            Kode Pelanggan: {{ $visit->ocrd_card->card_code }}
                        </div> 
                        <div class="text-md font-semibold text-gray-600 px-2">
                            Segment: {{ $visit->ocrd_card->segment }}
                        </div>
                    </div>
                    <div class="py-2">
                        <span class="px-4 text-sm font-bold text-gray-800">Kantor Pusat</span>
                        <div class="">
                            <div class="px-6">
                                <span class="font-semibold text-gray-600">Alamat:</span>
                                <span class="text-gray-600">{{ $visit->ocrd_card->office_address ?? '-' }}</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 px-6">
                                <div>
                                    <span class="font-semibold text-gray-600">Latitude:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->office_lat ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-600">Longitude:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->office_lng ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-600">Telepon:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->office_phone ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-600">Email:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->office_email ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-600">Fax:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->office_fax ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-2">
                        <span class="px-4 text-sm font-bold text-gray-800">Site/Pabrik</span>
                        <div class="">
                            <div class="px-6">
                                <span class="font-semibold text-gray-600">Alamat:</span>
                                <span class="text-gray-600">{{ $visit->ocrd_card->site_address ?? '-' }}</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 px-6">
                                <div>
                                    <span class="font-semibold text-gray-600">Latitude:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->site_lat ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-600">Longitude:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->site_lng ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-600">Telepon:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->site_phone ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-600">Email:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->site_email ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-600">Fax:</span>
                                    <span class="text-gray-600">{{ $visit->ocrd_card->site_fax ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative py-4 border border-gray-100 rounded-lg shadow-lg shadow-gray-300">
                    <div class="text-sm font-bold text-gray-800 border-b border-gray-300">
                        <span class="px-4">Penanggung Jawab</span>
                    </div>
                    @forelse($visit->persons as $person)
                        <div class="mt-2 p-3">
                            <div class="font-medium">Nama: {{ $person->name ?? '-' }}</div>
                            <div class="text-sm text-gray-500">Jabatan: {{ $person->position ?? '-' }}</div>
                            <div class="px-2">
                                <div class="text-sm">Telepon: {{ $person->phone ?? '-' }}</div>
                                <div class="text-sm">Email: {{ $person->email ?? '-' }}</div>
                                <div class="text-sm">Tanggal Lahir: {{ $person->date_of_birth ? \Carbon\Carbon::parse($person->date_of_birth)->format('d/m/Y') : '-' }}</div>
                                <div class="text-sm">Agama: {{ $person->religion ?? '-' }}</div>
                                <div class="text-sm">Hobi: {{ $person->hobby ?? '-' }}</div>
                            </div>
                        </div>
                    @empty
                        <span class="text-gray-500">Tidak ada penanggung jawab.</span>
                    @endforelse
                </div>
            </div>
            <div class="relative py-4 border border-gray-100 rounded-lg shadow-lg shadow-gray-300">
                <div class="text-sm font-bold text-gray-800 border-b border-gray-300">
                    <span class="px-4">Uraian Tentang Pelanggan</span>
                </div>
                <div class="text-sm px-4 text-justify text-gray-600 whitespace-pre-line">
                    {!! $visit->ocrd_card->customer_desc !!}
                </div>
            </div>
            <div class="relative py-4 border border-gray-100 rounded-lg shadow-lg shadow-gray-300">
                <div class="text-sm font-bold text-gray-800 border-b border-gray-300">
                    <span class="px-4">Uraian Pelayanan yang Diberikan</span>
                </div>
                <div class="text-sm px-4 text-justify text-gray-600 whitespace-pre-line">
                    {!! $visit->ocrd_card->service_desc !!}
                </div>
            </div>
            <div class="relative py-4 border border-gray-100 rounded-lg shadow-lg shadow-gray-300">
                <div class="text-sm font-bold text-gray-800 border-b border-gray-300">
                    <span class="px-4">Uraian Pelayanan yang Diberikan Kompetitor</span>
                </div>
                <div class="text-sm px-4 text-justify text-gray-600 whitespace-pre-line">
                    {!! $visit->ocrd_card->competitor_desc !!}
                </div>
            </div>
        </div>
        
        
        

        

    </div>
</x-layout>
