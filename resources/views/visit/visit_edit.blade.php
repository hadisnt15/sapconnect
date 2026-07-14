<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 rounded-lg bg-green-50 border border-green-200">
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

        <form class="mx-auto" action="{{ route('visit.update', $visit->id) }}" method="post">
            @csrf @method('PUT')
            <div class="px-6 py-2">
                <!-- Customer Info -->
                <div class="mb-2">
                    <label for="visit_date" class="mb-2 text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
                    <input type="date" id="visit_date" name="visit_date" value="{{ old('visit_date', optional($visit->visit_date)->format('Y-m-d')) }}" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500"/>
                    @error('visit_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div x-data="{ items: [{}] }">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="mb-4">
                            <label :for="'ocrdCardSelect' + index" class="mb-2 text-sm font-medium text-gray-700">Pelanggan</label>
                            <select :id="'ocrdCardSelect' + index" name="ocrd_card_id" class="bg-gray-200 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"></select>
                        </div>
                    </template>
                </div>
                <div class="mb-2">
                    <label class="mb-2 text-sm font-medium text-gray-700">Catatan</label>
                    <textarea type="text" name="note" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('note', $visit->note) }}</textarea>
                    @error('note')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div x-data="{ open: false }" class=" rounded-lg shadow-md mx-4 my-8 p-2 shadow-gray-300">
                    <div @click="open = !open" class="bg-gray-200 rounded-lg border px-4 py-2 flex justify-between items-center cursor-pointer text-sm font-medium text-gray-700">
                        Penanggung Jawab
                    </div>
                    <div x-show="open" x-collapse class="">
                        <div id="personSection" x-init="loadPersons({{ $visit->ocrd_card_id }})" x-data="{
                                openSection: true,
                                persons: @js(
                                    old(
                                        'persons',
                                        $visit->persons
                                            ->map(fn($person) => [
                                                'ocrd_person_id' => (string) $person->id
                                            ])
                                            ->values()
                                            ->all()
                                    )
                                ),
                                availablePersons: @js(
                                    $visit->ocrd_card
                                        ->person()
                                        ->where('is_active',1)
                                        ->select('id','name','position')
                                        ->orderBy('name')
                                        ->get()
                                ),
                                {{-- init() {
                                    console.log('persons', this.persons);
                                    console.log('availablePersons', this.availablePersons);
                                }, --}}
                                async loadPersons(cardId) {
                                    if (!cardId) {
                                        this.availablePersons = [];
                                        return;
                                    }
                                    const response = await fetch(`/kartu/${cardId}/penanggungJawab`);
                                    this.availablePersons = await response.json();
                                }
                            }" class="">
                            <div x-show="openSection" x-collapse class="space-y-4 mt-4">
                                <template x-for="(person,index) in persons" :key="index">
                                    <div class="space-y-3 border rounded-lg p-3">
                                        <select
                                            x-model="person.ocrd_person_id"
                                            x-effect="
                                                if (availablePersons.length && person.ocrd_person_id) {
                                                    $el.value = person.ocrd_person_id;
                                                }
                                            "
                                            :name="'persons['+index+'][ocrd_person_id]'"
                                            class="bg-gray-200 border border-gray-300 rounded-lg w-full p-2.5">

                                            <option value="">Pilih Penanggung Jawab</option>

                                            <template x-for="item in availablePersons" :key="item.id">
                                                <option
                                                    :value="item.id"
                                                    x-text="item.name + ' - ' + item.position">
                                                </option>
                                            </template>

                                        </select>
                                        <div class="flex justify-end mt-3">
                                            <button type="button" class="px-3 py-2 bg-gray-500 text-white rounded-lg" @click="persons.splice(index,1)" x-show="persons.length>1">
                                                Hapus Penanggung Jawab
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <!-- BUTTON TAMBAH -->
                                <button type="button" class="w-fit p-2 bg-green-600 hover:bg-green-400 text-white rounded-lg text-sm"
                                    @click="
                                        persons.push({
                                            ocrd_person_id:''
                                        })
                                    ">
                                    <i class="ri-add-circle-fill"></i> Tambah Penanggung Jawab
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-red-800 hover:bg-red-500 text-white py-2 rounded-lg text-sm font-medium">
                    Perbarui Kunjungan
                </button>

                {{-- <input type="hidden" name="OdrSlpCode" value="{{ $dataOrder['OdrSlpCode'] }}">
                <input type="hidden" name="OdrNum" value="{{ $dataOrder['OdrNum'] }}"> --}}
            </div>
        </form>
    </div>
</x-layout>
<script>
    async function initSelect(index) {
        let response = await fetch('/kartu/api');
        let data = await response.json();

        let select = document.getElementById('ocrdCardSelect' + index);

        new TomSelect(select, {
            valueField: 'id',
            labelField: 'label',
            searchField: ['card_name', 'card_code', 'segment'],
            options: data,
            placeholder: 'Pilih Pelanggan',
            onChange(value) {
                const alpine = document.getElementById('personSection')._x_dataStack[0];
                alpine.loadPersons(value);
            }
        });
        select.tomselect.setValue(@json($visit->ocrd_card_id));
    }

    document.addEventListener('DOMContentLoaded', () => {
        initSelect(0);
    });
</script>