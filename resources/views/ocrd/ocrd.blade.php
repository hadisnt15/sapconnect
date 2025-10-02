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
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-account-circle-2-fill"></i> {{ $titleHeader }}
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
                            placeholder="Cari Pelanggan" required />
                        <button type="submit"
                            class="absolute end-2 bottom-1.5 text-white font-medium rounded-lg text-sm px-4 py-1 bg-red-800 hover:bg-red-500 focus:ring-2 focus:ring-indigo-600">
                            <i class="ri-search-eye-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="md:ml-auto">
                <div class="flex items-center">
                    @can('customer.create')
                    <div class="me-2">
                        <a href="{{ route('customer.create') }}"
                            class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                            <i class="ri-user-add-fill"></i> Buat Pelanggan Baru
                        </a>
                    </div>
                    @endcan
                    @if(in_array(auth()->user()->role, ['developer', 'manager', 'supervisor']))
                    <div>
                        <a href="{{ route('customer.refresh') }}"
                            class="text-xs rounded-lg px-3 py-2 bg-red-800 hover:bg-red-500 font-medium text-white">
                            <i class="ri-refresh-fill"></i> Sinkronkan dengan SAP
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="text-sm font-bold text-gray-500 mb-2">
            @if ($lastSync)
                Terakhir Disinkronkan:{{ \Carbon\Carbon::parse($lastSync->last_sync)->timezone('Asia/Makassar')->format('d-m-Y H:i:s') }} WITA ({{ $lastSync->desc }})
            @else
                Belum Pernah Disinkronkan
            @endif
        </div>

        {{-- DESKTOP --}}
        <div class="grid md:grid-cols-4 gap-3">
            @foreach ($custs as $c)
                <article class="p-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 transition">
                    <div class="flex justify-between items-center mb-1 text-gray-500">
                        <span
                            class="text-xs font-bold border border-gray-400 me-2 px-2.5 py-0.5 rounded-lg bg-white text-red-800">
                            @if ($c->Type1 === 'PELANGGAN BARU')
                                {{ $c->Type1 }}
                            @else
                                {{ $c->Type1 }} - {{ $c->Type2 }} - {{ $c->Group }}
                            @endif
                        </span>
                    </div>
                    <h5 class="font-bold tracking-tight text-gray-800">
                        {{ $c->CardCode }}
                    </h5>
                    <div class="mb-2 border-b border-gray-300">
                        <p class="text-sm font-medium text-gray-600">{{ Str::limit($c->CardName, 30) }}</p>
                    </div>
                    <div class="text-xs font-medium text-gray-700">
                        <p>{{ strtoupper($c->Contact) }}: {{ strtoupper($c->Phone) }}</p>
                        <p>{{ Str::limit(strtoupper($c->Address), 30) }}</p>
                        <p>{{ strtoupper($c->City) }}, {{ strtoupper($c->State) }}</p>
                    </div>
                    <div class="ml-auto w-full">
                        <div class="flex items-center justify-end">
                            @if ($c->Type1 === 'PELANGGAN BARU')
                                <a href="{{ route('customer.edit', $c->CardCode) }}" class="mt-1">
                                    <span
                                        class="border text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg bg-red-800 hover:bg-red-500 text-white transition">
                                        <i class="ri-edit-2-fill"></i> Edit
                                    </span>
                                </a>
                            @endif
                            <a href="{{ route('order.create', $c->CardCode) }}" class="mt-1">
                                <span
                                    class="border text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg bg-red-800 hover:bg-red-500 text-white transition">
                                    <i class="ri-bill-fill"></i> Pesanan
                                </span>
                            </a>
                            <button data-modal-target="ocrd-view" data-modal-toggle="ocrd-view" type="button"
                                class="open-modal-ocrd-btn mt-1"
                                data-cardcode="{{ $c->CardCode }}"
                                data-cardname="{{ $c->CardName }}"
                                data-address="{{ $c->Address }}"
                                data-city="{{ $c->City }}"
                                data-state="{{ $c->State }}"
                                data-contact="{{ strtoupper($c->Contact) }}"
                                data-phone="{{ $c->Phone }}"
                                data-group="{{ $c->Group }}"
                                data-type1="{{ $c->Type1 }}"
                                data-type2="{{ $c->Type2 }}"
                                data-createdate="{{ $c->CreateDate }}"
                                data-lastodrdate="{{ $c->LastOdrDate }}"
                                data-termin="{{ $c->Termin }}"
                                data-limit="{{ number_format($c->Limit, 0, ',', '.') }}"
                                data-actbal="{{ number_format($c->ActBal, 0, ',', '.') }}"
                                data-dlvbal="{{ number_format($c->DlvBal, 0, ',', '.') }}"
                                data-odrbal="{{ number_format($c->OdrBal, 0, ',', '.') }}"
                                data-piutangjt="{{ number_format($c->piutang_jt, 0, ',', '.') }}">
                                <span
                                    class="border text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg bg-red-800 hover:bg-red-500 text-white transition">
                                    <i class="ri-eye-fill"></i> Detail
                                </span>
                            </button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        {{-- END DESKTOP --}}

        <div class="mt-5 text-gray-700">
            {{ $custs->links() }}
        </div>
    </div>

    <!-- Modal View -->
    <div id="ocrd-view" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <div class="relative rounded-lg shadow-md bg-gray-50 border border-gray-300">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                    <h3 class="text-lg font-medium text-gray-800">
                        <span id="modalType1" class="text-xs font-bold"></span> -
                        <span id="modalType2" class="text-xs font-bold"></span> -
                        <span id="modalGroup" class="text-xs font-bold"></span><br>
                        <span id="modalCardCode"></span> - <span id="modalCardName"></span>
                    </h3>
                    <button type="button"
                        class="text-gray-500 hover:text-indigo-600 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                        data-modal-hide="ocrd-view">✕</button>
                </div>

                <div class="px-4 md:px-5 py-3 space-y-2 text-sm text-gray-700">
                    <p>Lama Kredit: <span class="font-medium" id="modalTermin"></span></p>
                    <p>Batas Kredit: <span class="font-medium" id="modalLimit"></span></p>
                </div>
                <div class="px-4 md:px-5 py-3 space-y-2 text-sm text-gray-700">
                    <p>Saldo Piutang JT: <span class="font-medium" id="modalPiutangJT"></span></p>
                    <p>Saldo Piutang: <span class="font-medium" id="modalActBal"></span></p>
                    <p>Saldo Kiriman: <span class="font-medium" id="modalDlvBal"></span></p>
                    <p>Saldo Pesanan: <span class="font-medium" id="modalOdrBal"></span></p>
                </div>
                <div class="px-4 md:px-5 py-3 space-y-2 text-sm text-gray-700">
                    <p>Kontak: <span class="font-medium" id="modalContact"></span></p>
                    <p>Telpon: <span class="font-medium" id="modalPhone"></span></p>
                    <p>Alamat: <span class="font-medium" id="modalAddress"></span></p>
                    <p>Kota/Kab: <span class="font-medium" id="modalCity"></span></p>
                    <p>Provinsi: <span class="font-medium" id="modalState"></span></p>
                </div>
            </div>
        </div>
    </div>
</x-layout>


<script>
    // Helper untuk set text ke element
    function setModalText(id, value) {
        const el = document.getElementById(id);
        if (el) {
            el.innerText = value ?? "";
        }
    }

    // Fungsi buka modal
    function openModalView(CardCode, CardName, Address, City, State, Contact, Phone, Group, Type1, Type2,
        CreateDate, LastOdrDate, Termin, Limit, ActBal, DlvBal, OdrBal, PiutangJT) {
        setModalText("modalCardCode", CardCode);
        setModalText("modalCardName", CardName);
        setModalText("modalAddress", Address);
        setModalText("modalCity", City);
        setModalText("modalState", State);
        setModalText("modalContact", Contact);
        setModalText("modalPhone", Phone);
        setModalText("modalGroup", Group);
        setModalText("modalType1", Type1);
        setModalText("modalType2", Type2);
        setModalText("modalCreateDate", CreateDate);
        setModalText("modalLastOdrDate", LastOdrDate);
        setModalText("modalTermin", Termin);
        setModalText("modalLimit", Limit);
        setModalText("modalActBal", ActBal);
        setModalText("modalDlvBal", DlvBal);
        setModalText("modalOdrBal", OdrBal);
        setModalText("modalPiutangJT", PiutangJT);
        document.getElementById('ocrd-view').classList.remove('hidden');
        document.getElementById('ocrd-view').classList.add('flex');
    }

    // Saat DOM sudah siap
    document.addEventListener('DOMContentLoaded', function() {
        const buttonsView = document.querySelectorAll('.open-modal-ocrd-btn');
        buttonsView.forEach(button => {
            button.addEventListener('click', function() {
                const CardCode = this.getAttribute('data-cardcode');
                const CardName = this.getAttribute('data-cardname');
                const Address = this.getAttribute('data-address');
                const City = this.getAttribute('data-city');
                const State = this.getAttribute('data-state');
                const Contact = this.getAttribute('data-contact');
                const Phone = this.getAttribute('data-phone');
                const Group = this.getAttribute('data-group');
                const Type1 = this.getAttribute('data-type1');
                const Type2 = this.getAttribute('data-type2');
                const CreateDate = this.getAttribute('data-createdate');
                const LastOdrDate = this.getAttribute('data-lastodrdate');
                const Termin = this.getAttribute('data-termin');
                const Limit = this.getAttribute('data-limit');
                const ActBal = this.getAttribute('data-actbal');
                const DlvBal = this.getAttribute('data-dlvbal');
                const OdrBal = this.getAttribute('data-odrbal');
                const PiutangJT = this.getAttribute('data-piutangjt');
                openModalView(CardCode, CardName, Address, City, State, Contact, Phone,
                    Group, Type1, Type2, CreateDate, LastOdrDate, Termin, Limit, ActBal,
                    DlvBal, OdrBal, PiutangJT);
            });
        });
    });
</script>