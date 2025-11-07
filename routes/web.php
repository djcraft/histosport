<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');



use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

Route::get('dashboard', function () {
    $clubCount = \App\Models\Club::count();
    $personneCount = \App\Models\Personne::count();
    $competitionCount = \App\Models\Competition::count();

    // Préparer les labels des 12 derniers mois
    $labels = collect(range(0, 11))->map(function ($i) {
        return Carbon::now()->subMonths(11 - $i)->format('M Y');
    })->toArray();

    // Récupérer les données mensuelles
    $clubsData = [];
    $personnesData = [];
    $competitionsData = [];
    foreach (range(0, 11) as $i) {
        $start = Carbon::now()->subMonths(11 - $i)->startOfMonth();
        $end = Carbon::now()->subMonths(11 - $i)->endOfMonth();
        $clubsData[] = \App\Models\Club::whereBetween('created_at', [$start, $end])->count();
        $personnesData[] = \App\Models\Personne::whereBetween('created_at', [$start, $end])->count();
        $competitionsData[] = \App\Models\Competition::whereBetween('created_at', [$start, $end])->count();
    }

    return view('dashboard', [
        'clubCount' => $clubCount,
        'personneCount' => $personneCount,
        'competitionCount' => $competitionCount,
        'labels' => $labels,
        'clubsData' => $clubsData,
        'personnesData' => $personnesData,
        'competitionsData' => $competitionsData,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware(['auth'])->group(function () {
    $livewireFolders = [
        'clubs' => 'Clubs',
        'personnes' => 'Personnes',
        'disciplines' => 'Disciplines',
        'competitions' => 'Competitions',
        'sources' => 'Sources',
        'lieux' => 'Lieux',
    ];
    $entities = [
        'clubs' => 'Club',
        'personnes' => 'Personne',
        'disciplines' => 'Discipline',
        'competitions' => 'Competition',
        'sources' => 'Source',
        'lieux' => 'Lieu',
    ];

    foreach ($entities as $route => $entity) {
        $folder = $livewireFolders[$route];
        $param = strtolower($entity);
        // CRUD Livewire
        Route::get("$route", "App\\Livewire\\{$folder}\\Index")->name("$route.index");
        Route::get("$route/create", "App\\Livewire\\{$folder}\\Create")->name("$route.create");
        Route::get("$route/{{$param}}/edit", "App\\Livewire\\{$folder}\\Edit")->name("$route.edit");
        Route::get("$route/{{$param}}", "App\\Livewire\\{$folder}\\Show")->name("$route.show");

        // Import/Export
        Route::post("$route/import", "App\\Http\\Controllers\\{$entity}ImportExportController@import")->name("$route.import");
        Route::post("$route/export", "App\\Http\\Controllers\\{$entity}ImportExportController@export")->name("$route.export");

        // Suppression
        Route::delete("$route/{{$param}}", "App\\Http\\Controllers\\{$entity}Controller@destroy")->name("$route.destroy");
    }

    // Routes settings, historisations, etc. (à garder à part)
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    // Historisations
    Route::get('historisations', function() {
        $query = \App\Models\Historisation::query()->with('utilisateur');
        if (request('entity_type')) {
            $query->where('entity_type', request('entity_type'));
        }
        if (request('entity_id')) {
            $query->where('entity_id', request('entity_id'));
        }
        $historisations = $query->orderByDesc('date')->paginate(20);
        return view('historisations.index', compact('historisations'));
    })->name('historisations.index');

    Route::post('historisations/{id}/restore', [\App\Http\Controllers\HistorisationRestoreController::class, 'restore'])
        ->name('historisations.restore')
        ->middleware(['auth']);
});
