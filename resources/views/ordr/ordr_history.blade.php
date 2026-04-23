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
                    <a href="{{ route('order') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-800">
                        <i class="ri-bill-fill"></i> Daftar Pesanan
                    </a>
                </li>
                <li class="inline-flex items-center text-gray-400">&rsaquo;&rsaquo;</li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-red-800 md:ms-2">
                            <i class="ri-file-edit-fill text-red-800"></i> {{ $titleHeader }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="space-y-4">
            <div class="grid grid-cols-3 gap-2">
                @forelse($logs as $log)
                    <div class="flex gap-3 p-4 bg-white border rounded-xl shadow-sm">
    
                        <!-- ICON -->
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-full
                            bg-{{ $log['meta']['color'] }}-100
                            text-{{ $log['meta']['color'] }}-600
                            text-lg"
                        >
                            {{ $log['meta']['icon'] }}
                        </div>
    
                        <!-- CONTENT -->
                        <div class="flex-1">
    
                            <!-- TOP -->
                            <div class="">
                                <div class="font-semibold text-gray-800">
                                    {{ $log['description'] }}
                                </div>
    
                                <div class="text-xs text-gray-400">
                                    {{ $log['user'] }}. {{ $log['created_at'] }}
                                </div>
                            </div>
    
                            <!-- CHANGES -->
                            @if(!empty($log['changes']))
                                <div class="mt-3 space-y-1 text-xs">
    
                                    @foreach($log['changes'] as $change)
    
                                        <!-- UPDATE -->
                                        @if($change['type'] === 'update')
                                            <div class="">
                                                <span class="font-base text-gray-600 w-24">
                                                    {{ ucfirst($change['field']) }}:
                                                </span>
    
                                                <span class="text-red-500">
                                                    {{ $change['before'] }}
                                                </span>
    
                                                <span>→</span>
    
                                                <span class="text-green-600 font-semibold">
                                                    {{ $change['after'] }}
                                                </span>
                                            </div>
                                        @endif
    
                                        <!-- CREATE -->
                                        @if($change['type'] === 'create')
                                            <div class="">
                                                <span class="font-base text-gray-600 w-24">
                                                    {{ ucfirst($change['field']) }}:
                                                </span>
    
                                                <span class="text-green-600 font-semibold">
                                                    {{ $change['after'] }}
                                                </span>
                                            </div>
                                        @endif
    
                                        <!-- DELETE -->
                                        @if($change['type'] === 'delete')
                                            <div class="">
                                                <span class="font-base text-gray-600 w-24">
                                                    {{ ucfirst($change['field']) }}:
                                                </span>
    
                                                <span class="text-red-500 line-through">
                                                    {{ $change['before'] }}
                                                </span>
                                            </div>
                                        @endif
    
                                    @endforeach
    
                                </div>
                            @endif
    
                        </div>
                    </div>
                @empty
    
                    <div class="text-center text-gray-500 py-10">
                        Belum ada aktivitas
                    </div>
    
                @endforelse
            </div>

        </div>
</x-layout>

