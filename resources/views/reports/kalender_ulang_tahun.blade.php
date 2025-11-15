<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">

        <nav class="flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('report') }}"
                       class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-red-600">
                        <i class="ri-folder-6-fill"></i> Daftar Laporan
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                        <i class="ri-folder-open-fill"></i> {{ $titleHeader }}
                    </span>
                </li>
            </ol>
        </nav>

        <div class="text-sm font-bold text-gray-500 mb-2">
            @if ($lastSync)
                Terakhir Disinkronkan:
                {{ \Carbon\Carbon::parse($lastSync->last_sync)->timezone('Asia/Makassar')->format('d-m-Y H:i:s') }} WITA
                ({{ $lastSync->desc }})
            @else
                Belum pernah disinkronkan
            @endif
        </div>

        <div class="p-6">
            <h5 class="text-gray-800 font-bold ms-4 mb-4">Kalender Ulang Tahun</h5>
            <div id="calendar" class="bg-white p-4 rounded-lg shadow"></div>
        </div>

    </div>

    <!-- Popup Modal -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white w-11/12 max-w-md p-5 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-3">Detail Ulang Tahun</h2>

            <div class="space-y-2 text-sm">
                <p><strong>Pemilik:</strong> <span id="d_pemilik"></span></p>
                <p><strong>Toko:</strong> <span id="d_cust_name"></span> (<span id="d_cust_code"></span>)</p>
                <p><strong>Tanggal Lahir:</strong> <span id="d_tanggal"></span></p>
                <p><strong>Ultah ke:</strong> <span id="d_usia"></span> tahun</p>
            </div>

            <div class="mt-4 text-right">
                <button onclick="closeModal()" class="px-4 py-2 bg-red-600 text-white rounded">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>


    {{-- FullCalendar --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    {{-- Custom Mobile Responsive Style --}}
    <style>
        /* FullCalendar Responsive Adjustments */

        /* Kalender font lebih kecil di mobile */
        @media (max-width: 640px) {
            #calendar .fc-toolbar-title {
                font-size: 1rem !important;
            }
            #calendar .fc-col-header-cell-cushion {
                font-size: 0.65rem !important;
                padding: 4px !important;
            }
            #calendar .fc-daygrid-day-number {
                font-size: 0.7rem !important;
                padding: 2px !important;
            }
            #calendar .fc-event {
                font-size: 0.65rem !important;
                padding: 1px 3px !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis;
            }
        }

        /* Hapus shadow besar di mobile */
        @media (max-width: 640px) {
            #calendar {
                box-shadow: none !important;
                padding: 0 !important;
            }
        }

        /* Toolbar lebih compact di mobile */
        @media (max-width: 640px) {
            .fc-header-toolbar {
                flex-wrap: wrap !important;
                gap: 4px !important;
            }
            .fc-toolbar-chunk {
                display: flex;
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            function getInitialView() {
                return window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth';
            }

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: getInitialView(),
                locale: 'id',
                height: "auto",

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 768 ? '' : 'dayGridMonth,listMonth'
                },

                events: @json($ultah),

                eventDidMount(info) {
                    info.el.title = info.event.title;
                },

                // 🔥 EVENT CLICK → buka popup
                eventClick(info) {
                    const e = info.event.extendedProps;

                    document.getElementById("d_pemilik").innerText = e.pemilik;
                    document.getElementById("d_cust_name").innerText = e.cust_name;
                    document.getElementById("d_cust_code").innerText = e.cust_code;
                    document.getElementById("d_tanggal").innerText = e.tanggal_asli;
                    document.getElementById("d_usia").innerText = e.usia;

                    document.getElementById("detailModal").classList.remove('hidden');
                }
            });

            calendar.render();

            // 🔁 Auto ganti tampilan ketika screen berubah
            window.addEventListener('resize', function () {
                const newView = getInitialView();
                if (calendar.view.type !== newView) {
                    calendar.changeView(newView);
                }
            });
        });
    </script>


</x-layout>
