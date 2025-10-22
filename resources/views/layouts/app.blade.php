@props(['title' => ''])
<!DOCTYPE html>
<html lang="fr" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" x-bind:class="darkMode ? 'dark' : ''" x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title . ' | Histosport' : 'Histosport' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex">
    <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
            <span class="font-bold text-lg text-gray-800 dark:text-gray-100">Histosport</span>
        </div>
        <nav class="flex-1 py-4 px-2 space-y-2">
            <a href="{{ route('lieux.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Lieux</a>
            <a href="{{ route('clubs.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Clubs</a>
            <a href="{{ route('personnes.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Personnes</a>
            <a href="{{ route('disciplines.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Disciplines</a>
            <a href="{{ route('competitions.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Compétitions</a>
            <a href="{{ route('sources.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Sources</a>
        </nav>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <button x-on:click="darkMode = !darkMode" class="w-full flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded text-gray-700 dark:text-gray-200">
                <span x-show="!darkMode">🌙 Mode sombre</span>
                <span x-show="darkMode">☀️ Mode clair</span>
            </button>
        </div>
    </aside>
    <main class="flex-1 p-6">
        {{ $slot }}
    </main>
    @livewireScripts
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
