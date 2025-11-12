<div class="mb-4">
    @if(isset($label))
        <label for="{{ $name }}" class="block text-gray-700 dark:text-gray-300 mb-2">{{ $label }}</label>
    @endif
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type ?? 'text' }}"
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100']) }}
    >
    @error($name)
        <span class="text-red-500 text-xs">{{ $message }}</span>
    @enderror
</div>
