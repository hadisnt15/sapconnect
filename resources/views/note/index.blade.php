<x-layout title="Agenda">
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-300 py-2 px-2 bg-white">
        {{-- <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-calendar-schedule-fill"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav> --}}
        <div x-data="noteApp()" x-init="loadNotes()" class="space-y-6">
           <div class="bg-white rounded-lg shadow overflow-hidden">
                <nav class="flex justify-between px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb" @click="showForm = !showForm">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li aria-current="page">
                            <div class="flex items-center">
                                <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                                    <i class="ri-calendar-schedule-fill"></i> {{ $titleHeader }}
                                </span>
                            </div>
                        </li>
                    </ol>
                    <button type="button" class="text-gray-500">
                        <i class="text-xl" :class="showForm ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line'"></i>
                    </button>
                </nav>
                <div x-show="showForm" x-transition class="p-4">
                    <div class="grid md:grid-cols-[5fr_1fr] gap-2 mb-1">
                        <div class="mb-2">
                            <label class="mb-1 text-sm font-medium text-gray-700">Judul</label>
                            <input type="text" x-model="form.title" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                        </div>
                        <div class="mb-1">
                            <label class="mb-1 text-sm font-medium text-gray-700">Batas Waktu</label>
                            <input type="datetime-local" x-model="form.due_date" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="mb-1 text-sm font-medium text-gray-700">Catatan</label>
                        <textarea rows="3" x-model="form.description" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="mb-1 text-sm font-medium text-gray-700">Lampiran</label>
                        <input id="attachment" type="file" accept="image/*" @change="selectFile($event)" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full p-2.5 text-sm">
                        <template x-if="preview">
                            <img :src="preview" class="mt-2 w-32 h-32 rounded-lg border object-cover">
                        </template>
                    </div>
                </div>
            </div>
            <div class="fixed bottom-5 right-5 z-50">
                <button @click="submit()" class="px-5 py-3 bg-red-800 hover:bg-red-500 text-white text-xs md:text-sm rounded-lg shadow-lg font-bold focus:ring-4 focus:ring-red-300">
                    <i class="ri-check-double-fill mr-1"></i> Simpan Agenda
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
                <input type="text" x-model.debounce.500ms="filters.search" @input="loadNotes()" placeholder="Cari judul / catatan..." class="border rounded-lg p-2">
                <input type="date" x-model="filters.date_from" @change="loadNotes()" class="border rounded-lg p-2">
                <input type="date" x-model="filters.date_to" @change="loadNotes()" class="border rounded-lg p-2">
                <select x-model="filters.status" @change="loadNotes()" class="border rounded-lg p-2">
                    <option value="">Semua Status</option>
                    <option value="done">Selesai</option>
                    <option value="running">Berjalan</option>
                    <option value="warning">Mendekati Deadline</option>
                    <option value="late">Terlambat</option>
                    <option value="nodate">Tanpa Deadline</option>
                </select>
            </div>
            <div class="relative overflow-x-auto shadow-md rounded-xl">
                <table class="w-full text-sm text-left text-gray-600 border hidden md:block">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                        <tr class="border-b">
                            <th  width="60" class="p-3 text-center">#</th>
                            <th class="p-3 text-left  w-7/14">Agenda</th>
                            <th class="p-3 text-center  w-2/14">Deadline</th>
                            <th class="p-3 text-center w-2/14">Lampiran</th>
                            <th class="p-3 text-center w-1/14">Status</th>
                            <th class="p-2 text-center w-1/14">Selesai</th>
                            <th class="p-3 text-center w-1/14" width="130">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white border-b hover:bg-gray-50">
                        <template x-if="notes.length == 0">
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-500">Belum ada agenda.</td>
                            </tr>
                        </template>
                        <template x-for="(note, index) in notes" :key="note.id">
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="p-2 text-center" x-text="pagination.from + index"></td>
                                <td class="px-2 py-2 font-medium text-gray-800">
                                    <span x-text="note.title" :class="note.is_done ? 'line-through text-gray-400' : 'font-semibold'"></span> <br>
                                    <span x-text="note.description" :class="note.is_done ? 'line-through text-gray-400' : ''"></span>
                                </td>
                                <td class="px-2 py-2 font-medium text-gray-800 text-center">
                                    <span x-show="note.due_date" x-text="new Date(note.due_date).toLocaleString('id-ID')"></span>
                                    <span x-show="!note.due_date" class="text-gray-400">-</span>
                                </td>
                                <td class="px-2 py-2 font-medium text-gray-800">
                                    <template x-if="note.attachment_url">
                                        <a :href="note.attachment_url" target="_blank">
                                            <img :src="note.attachment_url" class="w-14 h-14 object-cover rounded border mx-auto">
                                        </a>
                                    </template>
                                    <template x-if="!note.attachment_url">
                                        <span class="text-gray-400">-</span>
                                    </template>
                                </td>
                                <td class="p-2 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-semibold" :class="status(note).class" x-text="status(note).text"></span>
                                </td>
                                <td class="px-2 py-2 font-medium text-gray-800 text-center">
                                    <input type="checkbox" :checked="note.is_done" @change="toggleDone(note)" class="w-5 h-5 text-green-600 rounded">
                                </td>
                                <td class="px-2 py-2 space-y-1">
                                    <button @click="edit(note)" class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                        <i class="ri-file-edit-fill"></i> Edit
                                    </button>
                                    <button @click="hapus(note.id)" class="block px-2 py-1 text-xs rounded bg-gray-500 hover:bg-gray-400 text-white w-full text-center">
                                        <i class="ri-delete-back-2-fill"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <table class="w-full text-sm text-left text-gray-600 border md:hidden">
                    <thead class="text-xs font-bold text-white uppercase bg-red-800">
                        <tr class="border-b">
                            <th  width="60" class="p-3 text-center">#</th>
                            <th class="p-3 text-left w-7/10">Agenda</th>
                            <th class="p-3 text-center w-2/10">Lampiran</th>
                            <th class="p-3 text-center w-1/10" width="130">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white border-b hover:bg-gray-50">
                        <template x-if="notes.length == 0">
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-500">Belum ada agenda.</td>
                            </tr>
                        </template>
                        <template x-for="(note, index) in notes" :key="note.id">
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="p-2 text-center" x-text="pagination.from + index"></td>
                                <td class="px-2 py-2 font-medium text-gray-800">
                                    <span x-text="note.title" :class="note.is_done ? 'line-through text-gray-400' : 'font-semibold'"></span> <br>
                                    <span x-text="note.description" :class="note.is_done ? 'line-through text-gray-400' : ''"></span> <br>
                                    <div class="mt-4">
                                        <span class="text-xs">Deadline: </span>
                                        <span x-show="note.due_date" x-text="new Date(note.due_date).toLocaleString('id-ID')"></span>
                                        <span x-show="!note.due_date" class="text-gray-400">-</span> <br>
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold" :class="status(note).class" x-text="status(note).text"></span>
                                    </div>
                                </td>
                                <td class="px-2 py-2 font-medium text-gray-800">
                                    <template x-if="note.attachment_url">
                                        <a :href="note.attachment_url" target="_blank">
                                            <img :src="note.attachment_url" class="w-14 h-14 object-cover rounded border mx-auto">
                                        </a>
                                    </template>
                                    <template x-if="!note.attachment_url">
                                        <span class="text-gray-400">-</span>
                                    </template>
                                </td>
                                <td class="px-2 py-2 space-y-1">
                                    <button @click="edit(note)" class="block px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-400 text-white w-full text-center">
                                        <i class="ri-file-edit-fill"></i>
                                    </button>
                                    <button @click="hapus(note.id)" class="block px-2 py-1 text-xs rounded bg-gray-500 hover:bg-gray-400 text-white w-full text-center">
                                        <i class="ri-delete-back-2-fill"></i>
                                    </button>
                                    <input type="checkbox" :checked="note.is_done" @change="toggleDone(note)" class="w-5 h-5 text-green-600 rounded">
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <div class="flex justify-between items-center mt-4 p-2">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span x-text="pagination.from"></span> - <span x-text="pagination.to"></span> dari <span x-text="pagination.total"></span> data
                    </div>

                    <div class="flex gap-1">
                        <button @click="loadNotes(1)" :disabled="pagination.current_page == 1">«</button>
                        <button @click="loadNotes(pagination.current_page-1)" :disabled="!pagination.prev_page_url">‹</button>
                        <template x-for="page in visiblePages()" :key="page">
                            <button @click="loadNotes(page)" class="px-3 py-1 rounded-md border text-xs" :class="page == pagination.current_page ? 'bg-red-800 text-white' : 'bg-white'">
                                <span x-text="page"></span>
                            </button>
                        </template>
                        <button @click="loadNotes(pagination.current_page+1)" :disabled="!pagination.next_page_url">›</button>
                        <button @click="loadNotes(pagination.last_page)" :disabled="pagination.current_page == pagination.last_page">»</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    window.noteApp = function () {
    return {
        showForm: true,
        notes: [],
        form: {
            id: null,
            title: '',
            description: '',
            due_date: '',
        },
        file: null,
        preview: null,
        pagination: {},
        filters: {
            search: '',
            date_from: '',
            date_to: '',
            status: ''
        },

        async loadNotes(page = 1) {
            const params = new URLSearchParams({
                page: page,
                search: this.filters.search,
                date_from: this.filters.date_from,
                date_to: this.filters.date_to,
                status: this.filters.status,
            });

            const response = await fetch('/agenda/list?' + params);

            if (!response.ok) {
                alert('Gagal mengambil data');
                return;
            }

            const result = await response.json();

            this.notes = result.data;
            this.pagination = result;
        },

        visiblePages() {
            let start = Math.max(1, this.pagination.current_page - 2);
            let end = Math.min(this.pagination.last_page, start + 4);

            if (end - start < 4) {
                start = Math.max(1, end - 4);
            }

            return Array.from(
                { length: end - start + 1 },
                (_, i) => start + i
            );
        },

        selectFile(event) {
            const file = event.target.files[0];

            if (!file) {
                this.file = null;
                this.preview = null;
                return;
            }

            if (file.size > 512 * 1024) {
                alert('Ukuran gambar maksimal 512 KB.');
                event.target.value = '';
                this.file = null;
                this.preview = null;
                return;
            }

            this.file = file;
            this.preview = URL.createObjectURL(file);
        },

        edit(note) {
            this.showForm = true;
            this.form.id = note.id;
            this.form.title = note.title;
            this.form.description = note.description;
            this.form.due_date = note.due_date
                ? note.due_date.substring(0, 16)
                : '';

            this.preview = note.attachment_url;
            this.file = null;
        },

        resetForm() {
            this.form = {
                id: null,
                title: '',
                description: '',
                due_date: '',
            };

            this.file = null;
            this.preview = null;

            const input = document.getElementById('attachment');

            if (input) {
                input.value = '';
            }
        },

        async save() {
            const formData = new FormData();

            formData.append('title', this.form.title);
            formData.append('description', this.form.description);
            formData.append('due_date', this.form.due_date);

            if (this.file) {
                formData.append('attachment', this.file);
            }

            const response = await fetch('/agenda/store', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const result = await response.json();

            if (!response.ok) {
                const err = await response.json();

                if (err.errors) {
                    let pesan = '';

                    Object.values(err.errors).forEach(item => {
                        pesan += item.join('\n') + '\n';
                    });

                    alert(pesan.trim());
                } else {
                    alert(err.message ?? 'Terjadi kesalahan.');
                }

                return;
            }

            alert(result.message);
            this.resetForm();
            this.showForm = false;
            await this.loadNotes();
        },

        async update() {
            const formData = new FormData();

            formData.append('_method', 'PUT');
            formData.append('title', this.form.title);
            formData.append('description', this.form.description);
            formData.append('due_date', this.form.due_date);

            if (this.file) {
                formData.append('attachment', this.file);
            }

            const response = await fetch('/agenda/' + this.form.id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const result = await response.json();

            if (!response.ok) {
                const err = await response.json();

                if (err.errors) {
                    let pesan = '';

                    Object.values(err.errors).forEach(item => {
                        pesan += item.join('\n') + '\n';
                    });

                    alert(pesan.trim());
                } else {
                    alert(err.message ?? 'Terjadi kesalahan.');
                }

                return;
            }
            
            alert(result.message);
            this.resetForm();
            this.showForm = false;
            await this.loadNotes();
        },

        async hapus(id) {
            if (!confirm('Yakin ingin menghapus?')) return;

            const response = await fetch('/agenda/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                alert('Gagal menghapus.');
                return;
            }

            await this.loadNotes();
        },

        async submit() {
            if (!this.form.title.trim()) {
                alert('Judul wajib diisi.');
                return;
            }

            if (this.form.id) {
                await this.update();
            } else {
                await this.save();
            }
        },

        async toggleDone(note) {
            const response = await fetch('/agenda/' + note.id + '/selesai', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                alert('Gagal mengubah status');
                return;
            }

            note.is_done = !note.is_done;

            if (note.is_done) {
                alert('Agenda berhasil diselesaikan.');
            } else {
                alert('Agenda dikembalikan menjadi belum selesai.');
            }
        },

        status(note) {
            if (note.is_done) {
                return {
                    text: 'Selesai',
                    class: 'text-green-800'
                };
            }

            if (!note.due_date) {
                return {
                    text: 'Tanpa Deadline',
                    class: 'text-gray-700'
                };
            }

            const now = new Date();
            const due = new Date(note.due_date);
            if (due < now) {
                return {
                    text: 'Terlambat',
                    class: 'text-red-800'
                };
            }

            const diffHour = (due - now) / 1000 / 60 / 60;
            if (diffHour <= 24) {
                return {
                    text: 'Mendekati Deadline',
                    class: 'text-yellow-800'
                };
            }

            return {
                text: 'Berjalan',
                class: 'text-blue-800'
            };
        },
    };
}
</script>