@if($value)
    <div class="mb-4">
        <span class="block text-gray-700 dark:text-gray-300 font-semibold">{{ $label }}</span>
        @if(isset($route) && $route && isset($routeParam))
            <a href="{{ route($route, $routeParam) }}" class="block text-blue-600 dark:text-blue-400 underline">{{ $value }}</a>
        @else
            <span class="block text-gray-900 dark:text-gray-100">{{ $value }}</span>
        @endif
    </div>
@else
    <div class="mb-4">
        <span class="block text-gray-700 dark:text-gray-300 font-semibold">{{ $label }}</span>
        <span class="block text-gray-900 dark:text-gray-100">-</span>
    </div>
@endif