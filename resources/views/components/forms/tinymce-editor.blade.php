{{-- Komponen ini menerima props 'name', 'id', dan 'value' --}}
<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    {{ $attributes }} {{-- Meneruskan atribut tambahan seperti @error atau required --}}
>{{ $value }}</textarea>