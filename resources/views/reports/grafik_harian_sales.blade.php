<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>
    
    <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200 py-2 px-2 bg-white">
        <!-- Breadcrumb -->
        <nav class=" flex mb-4 px-5 py-3 border rounded-lg bg-gray-50 border-gray-200" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('report') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-red-600">
                        <i class="ri-folder-6-fill"></i> Daftar Laporan
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-folder-open-fill"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <!-- Filter Tahun & Bulan -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-end mb-4 gap-2">
            <form method="GET" action="{{ route('report.grafik-penjualan-harian-sales') }}" 
                class="mb-4 flex flex-col md:flex-row items-stretch md:items-center gap-2 w-full md:w-auto">
                <div class="flex flex-col md:flex-row md:items-center gap-2 w-full md:w-auto">
                    <label for="month" class="text-xs font-medium text-gray-600">Pilih Bulan:</label>
                    <input 
                        type="month" 
                        id="month" 
                        name="month" 
                        value="{{ request('month', now()->format('Y-m')) }}"
                        class="border rounded-lg p-2 text-xs font-medium text-gray-700 border-gray-300 focus:ring focus:ring-red-200 w-full md:w-auto"
                    >
                </div>
                <button type="submit" class="bg-red-800 text-white px-4 py-2 rounded-md text-xs hover:bg-red-600">Tampilkan</button>
            </form>
        </div>
        <div><h5 class="text-gray-800 font-bold ms-4 mb-2">Grafik Jumlah Pesanan Harian</h5></div>
        <div class="p-5 bg-white rounded-lg shadow">
            <div id="chart"></div>
        </div>
    </div>
</x-layout>
<script>
    var options = {
        chart: {
            type: 'line',
            height: 400,
            toolbar: { show: false }
        },
        series: @json($chartData),
        xaxis: {
            categories: @json($tanggalList),
            title: { text: 'Tanggal' }
        },
        yaxis: {
            title: { text: 'Jumlah Pesanan' },
            min: 0
        },
        dataLabels: { enabled: true },
        stroke: { curve: 'smooth' },
        tooltip: { shared: true, intersect: false },
        legend: { position: 'top' }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>