<div class="mb-4">
    <span class="block text-gray-700 dark:text-gray-300 font-semibold">{{ $label }}</span>
    <div class="mt-1">
        @forelse($items as $item)
            @if(isset($route) && $route)
                <a href="{{ route($route, $item) }}">
                    <x-badge class="mr-1">{{ $item->nom ?? $item->titre ?? $item->prenom ?? $item }}</x-badge>
                </a>
            @else
                <span class="block"><x-badge class="mr-1">{{ $item->nom ?? $item->titre ?? $item->prenom ?? $item }}</x-badge></span>
            @endif
        @empty
            <span class="block text-gray-900 dark:text-gray-100">-</span>
        @endforelse
    </div>
</div>