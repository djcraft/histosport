<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Statistiques globales -->
        <div class="flex flex-wrap gap-6 mb-2">
            <a href="{{ route('clubs.index') }}" class="flex-1 min-w-[180px] bg-white dark:bg-gray-800 shadow rounded-lg px-6 py-4 flex flex-row items-center transition hover:ring-2 hover:ring-blue-400 cursor-pointer" style="text-decoration:none; min-height:100px; height:100px;">
                <span class="inline-flex items-center justify-center w-16 h-16 aspect-square rounded-full bg-blue-500 text-white" style="margin-right:14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9-4 9 4" />
                    </svg>
                </span>
                <div class="flex flex-row items-center justify-center">
                    <div class="text-5xl font-extrabold text-blue-700 dark:text-blue-200 mr-2">{{ $clubCount }}</div>
                    <div class="text-lg font-semibold text-gray-500 dark:text-gray-400">Clubs</div>
                </div>
            </a>
            <a href="{{ route('personnes.index') }}" class="flex-1 min-w-[180px] bg-white dark:bg-gray-800 shadow rounded-lg px-6 py-4 flex flex-row items-center transition hover:ring-2 hover:ring-pink-400 cursor-pointer" style="text-decoration:none; min-height:100px; height:100px;">
                <span class="inline-flex items-center justify-center w-16 h-16 aspect-square rounded-full bg-pink-500 text-white" style="margin-right:14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9.001 9.001 0 0112 15c2.21 0 4.21.805 5.879 2.146M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <div class="flex flex-row items-center justify-center">
                    <div class="text-5xl font-extrabold text-pink-700 dark:text-pink-200 mr-2">{{ $personneCount }}</div>
                    <div class="text-lg font-semibold text-gray-500 dark:text-gray-400">Personnes</div>
                </div>
            </a>
            <a href="{{ route('competitions.index') }}" class="flex-1 min-w-[180px] bg-white dark:bg-gray-800 shadow rounded-lg px-6 py-4 flex flex-row items-center transition hover:ring-2 hover:ring-green-400 cursor-pointer" style="text-decoration:none; min-height:100px; height:100px;">
                <span class="inline-flex items-center justify-center w-16 h-16 aspect-square rounded-full bg-green-500 text-white" style="margin-right:14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                    </svg>
                </span>
                <div class="flex flex-row items-center justify-center">
                    <div class="text-5xl font-extrabold text-green-700 dark:text-green-200 mr-2">{{ $competitionCount }}</div>
                    <div class="text-lg font-semibold text-gray-500 dark:text-gray-400">Compétitions</div>
                </div>
            </a>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-8">
            <h2 class="text-xl font-bold mb-4 text-center">Évolution mensuelle des créations</h2>
            <canvas id="dashboardChart" height="120"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            const ctx = document.getElementById('dashboardChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [
                        {
                            label: 'Clubs',
                            data: {!! json_encode($clubsData) !!},
                            backgroundColor: 'rgba(59,130,246,0.7)',
                            borderRadius: 6,
                        },
                        {
                            label: 'Personnes',
                            data: {!! json_encode($personnesData) !!},
                            backgroundColor: 'rgba(236,72,153,0.7)',
                            borderRadius: 6,
                        },
                        {
                            label: 'Compétitions',
                            data: {!! json_encode($competitionsData) !!},
                            backgroundColor: 'rgba(34,197,94,0.7)',
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#e5e7eb' },
                        }
                    }
                }
            });
            </script>
        </div>
    </div>
</x-layouts.app>
