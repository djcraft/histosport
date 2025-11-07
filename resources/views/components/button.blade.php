@props([
    'type' => 'button',
    'variant' => 'primary',
    'icon' => null,
])

@php
    $base = 'px-4 py-2 rounded font-semibold transition focus:outline-none';
    $linkBase = 'bg-transparent border-none p-0 m-0 font-semibold underline transition cursor-pointer';
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700',
        'secondary' => 'bg-gray-300 text-gray-800 hover:bg-gray-400',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'link-primary' => 'text-blue-600 hover:underline hover:text-blue-700',
        'link-success' => 'text-green-600 hover:underline hover:text-green-700',
        'link-danger' => 'text-red-600 hover:underline hover:text-red-700',
        'link-orange' => 'text-yellow-600 hover:underline hover:text-yellow-800',
    ];
    $classes = in_array($variant, ['link-primary','link-success','link-danger','link-orange'])
        ? $linkBase . ' ' . ($variants[$variant] ?? $variants['link-primary'])
        : $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($attributes->get('as') === 'a')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
    </button>
@endif
