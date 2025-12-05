<!doctype html>
<html class="h-full bg-gray-100">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- @vite('resources/css/app.css') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/kkj.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com">
        {{-- DROPDOWN ITEM --}}
            <
            !--Select2 CSS-- >
            <
            link href = "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
        rel = "stylesheet" / >


            <
            !--Select2 JS-- >
            <
            script src = "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" >
    </script>
    {{-- END DROPDOWN ITEM --}}

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <!-- webcam -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <!-- grafik -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</head>

<body class="h-full">
    <div class="min-h-full ">
        <div>

            <div class="fixed top-0 left-0 w-full z-50">
                <x-navbar></x-navbar>
            </div>
            @if (session('error'))
                <script>
                    alert("{{ session('error') }}");
                </script>
            @endif
            <div class="mt-16">
                <main class="min-h-screen">
                    <!-- <main class="md:bg-[url('/img/bg-kkj-salesorder2.jpg')] bg-[url('/img/bg-kkj-salesorder2-mobile.jpg')] bg-cover bg-center bg-fixed min-h-screen"> -->
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-4">
                        {{ $slot }}
                        {{-- {{ $slotSearch }} --}}
                    </div>
                </main>
            </div>
            <div class="bg-red-900">
                <x-footer></x-footer>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>






</body>

</html>
