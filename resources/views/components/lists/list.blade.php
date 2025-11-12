<div class="mb-4">
    <span class="block text-gray-700 dark:text-gray-300 font-semibold">{{ $label }}</span>
    <div class="mt-1">
        @forelse($items as $item)
            @if(isset($route) && $route)
                <a href="{{ route($route, $item) }}">
                    <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">{{ $item->nom ?? $item->titre ?? $item->prenom ?? $item }}</x-badges.badge>
                </a>
            @else
                <span class="block"><x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">{{ $item->nom ?? $item->titre ?? $item->prenom ?? $item }}</x-badges.badge></span>
            @endif
        @empty
            <span class="block text-gray-900 dark:text-gray-100">-</span>
        @endforelse
    </div>
</div>
