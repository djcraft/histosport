@props([
    'headers' => [],
])
<div class="bg-white dark:bg-gray-800 shadow rounded-lg" style="width:100%;overflow-x:auto;">
    <table {{ $attributes->merge(['class' => 'min-w-max divide-y divide-gray-200 dark:divide-gray-700']) }}>
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                @foreach($headers as $header)
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            {{ $slot }}
        </tbody>
    </table>
</div>
