<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    <div class="relative overflow-x-auto shadow-md rounded-lg border border-zinc-600 py-2 px-2">
        <nav class="opacity-75 flex mb-4 px-5 py-3 border rounded-lg bg-red-700 border-red-800" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-white text-shadow-red-950 md:ms-2 ">
                            <i class="ri-bill-fill"></i> {{ $titleHeader }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex flex-col items-center w-full h-screen p-6">
            <!-- Header -->
            <span id="clock"
                class="text-xs font-bold border border-red-950 me-2 px-2.5 py-0.5 rounded-lg bg-white hover:bg-red-300 hover:text-red-900 text-red-900">
            </span>

            <!-- Main Content (bigger box) -->
            <div id="my_camera"></div>

            <!-- Buttons Section -->
            <div class="flex flex-col items-center space-y-4 w-full max-w-xs">
                <button class="bg-blue-500 text-white p-4 rounded-lg w-full">
                    Tombol
                </button>
                <button class="bg-blue-500 text-white p-4 rounded-lg w-full">
                    Tombol
                </button>
            </div>
        </div>

    </div>

</x-layout>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
    integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>


<script>
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jped',
        jpeg_quality: 90
    });

    Webcam.attach('#my_camera');
</script>

<script>
    var myVar = setInterval(function() {
        myTimer();
    }, 1000);

    function myTimer() {
        var d = new Date();
        var time = d.toLocaleTimeString();
        var date = d.toLocaleDateString('id-GB')
        document.getElementById("clock").innerHTML = date + ' ' + time;
    }
</script>
