@props(['active' => false]) <!-- Passing the `active` prop -->

<a 
    {{ $attributes->merge([
        'class' => 'nav-link block px-4 py-2 text-base font-medium transition duration-300 ' . ($active 
            ? 'bg-blue-500 text-white rounded-md' 
            : 'text-gray-700 hover:bg-gray-100 hover:text-blue-500')
    ]) }}
>
    {{ $slot }}
</a>
