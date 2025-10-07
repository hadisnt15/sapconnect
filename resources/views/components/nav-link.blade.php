@props(['active' => false])
<a {{ $attributes }}
    class="{{ $active ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700 hover:text-white' }} rounded-md px-2 py-2 text-sm font-medium "
    aria-current="{{ $active ? 'page' : false }}"> {{ $slot }}
</a>
