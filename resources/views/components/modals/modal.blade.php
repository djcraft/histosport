@props([
    'show' => false,
    'title' => null,
])
@if($show)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-xl w-full">
            @if($title)
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">{{ $title }}</h2>
            @endif
            <div class="mb-4">
                {{ $slot }}
            </div>
            @if(isset($actions))
                <div class="flex justify-end gap-2 mt-4">
                    {{ $actions }}
                </div>
            @endif
        </div>
    </div>
@endif
