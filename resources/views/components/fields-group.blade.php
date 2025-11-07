<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach($fields as $field)
        <div>
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">{{ $field['label'] }}</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $field['value'] ?? '-' }}</span>
        </div>
    @endforeach
</div>