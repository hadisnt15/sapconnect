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
        <form class="mx-auto" action="{{ route('card.save', $ocrdMaster->CardCode) }}" method="POST">
            @csrf @method('put')
            <input type="hidden" id="card_code" name="card_code" value="{{ $ocrdMaster->CardCode }}"/>
            <span class="text-md font-bold text-gray-600 px-2">Kode Pelanggan {{ $ocrdMaster->CardCode }} - {{ $ocrdMaster->CardName }}</span>
            <div class="grid md:grid-cols-2 md:gap-6 rounded-lg shadow-md m-4 p-2 shadow-gray-300">
                <div class="mb-2">
                    <label for="card_name" class="mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" id="card_name" name="card_name"
                        value="{{ $ocrdCard->card_name }}" autocomplete="off"
                        class="bg-gray-200 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Nama Pelanggan"  />
                    @error('card_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="segment" class="mb-2 text-sm font-medium text-gray-700">Segment</label>
                    <input type="text" id="segment" name="segment"
                        value="{{ $ocrdCard->segment }}" autocomplete="off"
                        class="bg-gray-200 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                        placeholder="Segment"  />
                    @error('segment')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- <div x-data="{ items: [{}] }">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="mb-4">
                            <label :for="'salesmanSelect' + index" class="mb-2 text-sm font-medium text-gray-700">Sales</label>
                            <select :id="'salesmanSelect' + index" name="slp_code" class="bg-gray-200 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"></select>
                        </div>
                    </template>
                </div> --}}
            </div>
            <div x-data="{ open: false }" class=" rounded-lg shadow-md mx-4 my-8 p-2 shadow-gray-300">
                <div @click="open = !open" class="bg-gray-200 rounded-lg border px-4 py-2 flex justify-between items-center cursor-pointer text-sm font-medium text-gray-700">
                    Kantor Pusat {{$ocrdCard->address}}
                </div>
                <div x-show="open" x-collapse class="grid grid grid-cols-1 md:grid-cols-6 gap-2 p-2">
                    <div class="mb-2 md:col-span-6">
                        <label for="office_address" class="mb-2 text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="office_address" name="office_address" rows="3" autocomplete="off" class="block p-2.5 w-full text-sm rounded-lg border bg-gray-50 border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600" placeholder="Alamat">{{ $ocrdCard->office_address }}</textarea>
                        @error('office_address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-3">
                        <label for="office_lat" class="mb-2 text-sm font-medium text-gray-700">Titik Latitude</label>
                        <input type="text" id="office_lat" name="office_lat"
                            value="{{ $ocrdCard->office_lat }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Titik Latitude"   />
                        @error('office_lat')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-3">
                        <label for="office_lng" class="mb-2 text-sm font-medium text-gray-700">Titik Longitude</label>
                        <input type="text" id="office_lng" name="office_lng"
                            value="{{ $ocrdCard->office_lng }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Titik Longitude"   />
                        @error('office_lng')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-2">
                        <label for="office_phone" class="mb-2 text-sm font-medium text-gray-700">Telepon</label>
                        <input type="text" id="office_phone" name="office_phone"
                            value="{{ $ocrdCard->office_phone }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Telepon"   />
                        @error('office_phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-2">
                        <label for="office_mail" class="mb-2 text-sm font-medium text-gray-700">Email</label>
                        <input type="text" id="office_mail" name="office_mail"
                            value="{{ $ocrdCard->office_mail }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Email"   />
                        @error('office_mail')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-2">
                        <label for="office_fax" class="mb-2 text-sm font-medium text-gray-700">Fax</label>
                        <input type="text" id="office_fax" name="office_fax"
                            value="{{ $ocrdCard->office_fax }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Fax"   />
                        @error('office_fax')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }" class=" rounded-lg shadow-md mx-4 my-8 p-2 shadow-gray-300">
                <div @click="open = !open" class="bg-gray-200 rounded-lg border px-4 py-2 flex justify-between items-center cursor-pointer text-sm font-medium text-gray-700">
                    Pabrik/Site
                </div>
                <div x-show="open" x-collapse class="grid grid grid-cols-1 md:grid-cols-6 gap-2 p-2">
                    <div class="mb-2 md:col-span-6">
                        <label for="site_address" class="mb-2 text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="site_address" name="site_address" rows="3" autocomplete="off" class="block p-2.5 w-full text-sm rounded-lg border bg-gray-50 border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600" placeholder="Alamat">{{ $ocrdCard->site_address }}</textarea>
                        @error('site_address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-3">
                        <label for="site_lat" class="mb-2 text-sm font-medium text-gray-700">Titik Latitude</label>
                        <input type="text" id="site_lat" name="site_lat"
                            value="{{ $ocrdCard->site_lat }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Titik Latitude"   />
                        @error('site_lat')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-3">
                        <label for="site_lng" class="mb-2 text-sm font-medium text-gray-700">Titik Longitude</label>
                        <input type="text" id="site_lng" name="site_lng"
                            value="{{ $ocrdCard->site_lng }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Titik Longitude"   />
                        @error('site_lng')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-2">
                        <label for="site_phone" class="mb-2 text-sm font-medium text-gray-700">Telepon</label>
                        <input type="text" id="site_phone" name="site_phone"
                            value="{{ $ocrdCard->site_phone }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Telepon"   />
                        @error('site_phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-2">
                        <label for="site_mail" class="mb-2 text-sm font-medium text-gray-700">Email</label>
                        <input type="text" id="site_mail" name="site_mail"
                            value="{{ $ocrdCard->site_mail }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Email"   />
                        @error('site_mail')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-2">
                        <label for="site_fax" class="mb-2 text-sm font-medium text-gray-700">Fax</label>
                        <input type="text" id="site_fax" name="site_fax"
                            value="{{ $ocrdCard->site_fax }}" autocomplete="off"
                            class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5"
                            placeholder="Fax"   />
                        @error('site_fax')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }" class=" rounded-lg shadow-md mx-4 my-8 p-2 shadow-gray-300">
                <div @click="open = !open" class="bg-gray-200 rounded-lg border px-4 py-2 flex justify-between items-center cursor-pointer text-sm font-medium text-gray-700">
                    Uraian
                </div>
                <div x-show="open" x-collapse class="grid grid grid-cols-1 md:grid-cols-6 gap-2 p-2">
                    <div class="mb-2 md:col-span-6">
                        <label for="customer_desc" class="mb-2 text-sm font-medium text-gray-700">Tentang Pelanggan</label>
                        <textarea id="customer_desc" name="customer_desc" rows="8" autocomplete="off" class="block p-2.5 w-full text-sm rounded-lg border bg-gray-50 border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600" placeholder="Tentang Pelanggan">{{ $ocrdCard->customer_desc }}</textarea>
                        @error('customer_desc')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-6">
                        <label for="service_desc" class="mb-2 text-sm font-medium text-gray-700">Pelayanan yang Diberikan</label>
                        <textarea id="service_desc" name="service_desc" rows="3" autocomplete="off" class="block p-2.5 w-full text-sm rounded-lg border bg-gray-50 border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600" placeholder="Pelayanan yang Diberikan">{{ $ocrdCard->service_desc }}</textarea>
                        @error('service_desc')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 md:col-span-6">
                        <label for="competitor_desc" class="mb-2 text-sm font-medium text-gray-700">Pelayanan Kompetitor yang Diberikan</label>
                        <textarea id="competitor_desc" name="competitor_desc" rows="3" autocomplete="off" class="block p-2.5 w-full text-sm rounded-lg border bg-gray-50 border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600" placeholder="Pelayanan Kompetitor yang Diberikan">{{ $ocrdCard->competitor_desc }}</textarea>
                        @error('competitor_desc')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }" class=" rounded-lg shadow-md mx-4 my-8 p-2 shadow-gray-300">
                <div @click="open = !open" class="bg-gray-200 rounded-lg border px-4 py-2 flex justify-between items-center cursor-pointer text-sm font-medium text-gray-700">
                    Penanggung Jawab
                </div>
                <div x-show="open" x-collapse class="">
                    <div x-data="{
                                persons: @js(
                                    count($persons)
                                        ? $persons
                                        : [[
                                            'id' => null,
                                            'name' => '',
                                            'position' => '',
                                            'phone' => '',
                                            'email' => '',
                                            'gender' => '',
                                            'date_of_birth' => '',
                                            'hobby' => '',
                                            'religion' => '',
                                            'open' => true,
                                        ]]
                                ),
                                openSection: true
                            }" class="rounded-lg shadow-md my-8 p-2 shadow-gray-300">
                        <div x-show="openSection" x-collapse class="space-y-4 mt-4">
                            <template x-for="(person,index) in persons" :key="index">
                                <div class="border rounded-lg overflow-hidden shadow-sm">
                                    <!-- CARD HEADER -->
                                    <div class="bg-gray-50 px-4 py-3 flex justify-between items-center cursor-pointer" @click="person.open=!person.open">
                                        <div>
                                            <div class="font-semibold">
                                                <span x-text="'#'+(index+1)"></span>
                                                <span x-show="person.name" x-text="' - '+person.name"></span>
                                                <span x-show="!person.name" class="text-gray-500">Penanggung Jawab</span>
                                            </div>
                                            <div class="text-sm text-gray-500" x-text="person.position"></div>
                                        </div>
                                        <i class="text-xl" :class="person.open ? 'ri-arrow-up-s-line':'ri-arrow-down-s-line'"></i>
                                    </div>
                                    <!-- BODY -->
                                    <div x-show="person.open" x-collapse class="p-4">
                                        <input type="hidden" :name="'persons[' + index + '][id]'" :value="person.id">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4"> 
                                            <div>
                                                <label class="mb-2 text-sm font-medium text-gray-700">Nama</label>
                                                <input type="text" x-model="person.name" :name="'persons['+index+'][name]'" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                                            </div>
                                            <div>
                                                <label class="mb-2 text-sm font-medium text-gray-700">Jabatan</label>
                                                <input type="text" x-model="person.position" :name="'persons['+index+'][position]'" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                                            </div>
                                            <div>
                                                <label class="mb-2 text-sm font-medium text-gray-700">No. HP</label>
                                                <input type="text" x-model="person.phone" :name="'persons['+index+'][phone]'" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                                            </div>
                                            <div>
                                                <label class="mb-2 text-sm font-medium text-gray-700">Email</label>
                                                <input type="email" x-model="person.email" :name="'persons['+index+'][email]'" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                                            </div>
                                            <div>
                                                <label class="mb-2 text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                                <select x-model="person.gender" :name="'persons['+index+'][gender]'"
                                                    class="bg-gray-50 border border-gray-300 text-gray-800 placeholder-gray-500 focus:ring-indigo-600 focus:border-indigo-600 text-sm rounded-lg w-full p-2.5">
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="mb-2 text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                                <input type="date" x-model="person.date_of_birth" :name="'persons['+index+'][date_of_birth]'" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                                            </div>
                                            <div>
                                                <label class="mb-2 text-sm font-medium text-gray-700">Hobi</label>
                                                <input type="text" x-model="person.hobby" :name="'persons['+index+'][hobby]'" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                                            </div>
                                            <div>
                                                <label class="mb-2 text-sm font-medium text-gray-700">Agama</label>
                                                <input type="text" x-model="person.religion" :name="'persons['+index+'][religion]'" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-4">
                                            <button type="button" @click="
                                                    if(persons.length>1){
                                                        persons.splice(index,1)
                                                    }else{
                                                        alert('Minimal harus ada 1 penanggung jawab');
                                                    }
                                                "
                                                class="px-3 py-1.5 bg-gray-500 hover:bg-gray-400 text-white text-sm rounded-lg flex items-center gap-1">
                                                <i class="ri-close-circle-fill"></i> Hapus Penanggung Jawab
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <!-- BUTTON TAMBAH -->
                            <button type="button" class="w-fit p-2 bg-green-600 hover:bg-green-400 text-white py-2 rounded-lg text-sm"
                                @click="
                                    persons.push({
                                        id: null,
                                        name:'',
                                        position:'',
                                        phone:'',
                                        email:'',
                                        gender:'',
                                        date_of_birth:'',
                                        hobby:'',
                                        religion:'',
                                        open:true
                                    })
                                ">
                                <i class="ri-add-circle-fill"></i> Tambah Penanggung Jawab
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="mt-3 w-full bg-red-800 hover:bg-red-500 text-white py-2 rounded-lg text-sm font-medium">
                Simpan Kartu Pelanggan
            </button>
        </form>
        {{-- END DESKTOP --}}
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
            placeholder: 'Pilih Sales',
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initSelect(0);
    });
</script>