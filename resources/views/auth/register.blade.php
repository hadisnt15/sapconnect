<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:titleHeader>{{ $titleHeader }}</x-slot:titleHeader>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="relative overflow-x-auto shadow-md rounded-lg border border-zinc-600 py-2 px-2">
        <nav class="opacity-75 flex mb-4 px-5 py-3 border rounded-lg bg-red-700 border-red-800" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-white text-shadow-red-950 md:ms-2 ">
                            <i class="ri-survey-fill"></i>{{ $titleHeader }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <section class="rounded-lg opacity-75">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <div class="w-full rounded-lg shadow bg-red-900 md:mt-0 sm:max-w-md xl:p-0">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight  md:text-2xl text-white">
                            Create an account
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="{{ route('register') }}" method="post">@csrf 
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium  text-white">Full
                                    Name</label>
                                <input type="name" name="name" id="name"
                                    class="bg-red-50 border border-gray-300  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 text-red-950"
                                    placeholder="Full Name" required="" value="{{ old('name') }}">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                            class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="username" class="block mb-2 text-sm font-medium  text-white">User
                                    Name</label>
                                <input type="username" name="username" id="username"
                                    class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 text-red-950"
                                    placeholder="User Name" required="" value="{{ old('username') }}">
                                @error('username')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                            class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium  text-white">Phone
                                    Number</label>
                                <input type="phone" name="phone" id="phone"
                                    class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 text-red-950"
                                    placeholder="Phone Number" required="" value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                            class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password"
                                    class="block mb-2 text-sm font-medium  text-white">Password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 text-red-950"
                                    required="">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                            class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create
                                an account</button>
                            <p class="text-sm font-light text-white">
                                Already have an account? <a href="{{ route('login') }}"
                                    class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login
                                    here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-layout>
