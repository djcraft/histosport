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

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth'])->group(function () {
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

    // Lieux
    Route::get('lieux', App\Livewire\Lieux\Index::class)->name('lieux.index');
    Route::get('lieux/create', App\Livewire\Lieux\Create::class)->name('lieux.create');
    Route::get('lieux/{lieu}/edit', App\Livewire\Lieux\Edit::class)->name('lieux.edit');
    Route::get('lieux/{lieu}', App\Livewire\Lieux\Show::class)->name('lieux.show');

    // Clubs
    Route::get('clubs', App\Livewire\Clubs\Index::class)->name('clubs.index');
    Route::get('clubs/create', App\Livewire\Clubs\Create::class)->name('clubs.create');
    Route::get('clubs/{club}/edit', App\Livewire\Clubs\Edit::class)->name('clubs.edit');
    Route::get('clubs/{club}', App\Livewire\Clubs\Show::class)->name('clubs.show');

    // Personnes
    Route::get('personnes', App\Livewire\Personnes\Index::class)->name('personnes.index');
    Route::get('personnes/create', App\Livewire\Personnes\Create::class)->name('personnes.create');
    Route::get('personnes/{personne}/edit', App\Livewire\Personnes\Edit::class)->name('personnes.edit');
    Route::get('personnes/{personne}', App\Livewire\Personnes\Show::class)->name('personnes.show');

    // Disciplines
    Route::get('disciplines', App\Livewire\Disciplines\Index::class)->name('disciplines.index');
    Route::get('disciplines/create', App\Livewire\Disciplines\Create::class)->name('disciplines.create');
    Route::get('disciplines/{discipline}/edit', App\Livewire\Disciplines\Edit::class)->name('disciplines.edit');
    Route::get('disciplines/{discipline}', App\Livewire\Disciplines\Show::class)->name('disciplines.show');

    // Compétitions
    Route::get('competitions', App\Livewire\Competitions\Index::class)->name('competitions.index');
    Route::get('competitions/create', App\Livewire\Competitions\Create::class)->name('competitions.create');
    Route::get('competitions/{competition}/edit', App\Livewire\Competitions\Edit::class)->name('competitions.edit');
    Route::get('competitions/{competition}', App\Livewire\Competitions\Show::class)->name('competitions.show');

    // Sources
    Route::get('sources', App\Livewire\Sources\Index::class)->name('sources.index');
    Route::get('sources/create', App\Livewire\Sources\Create::class)->name('sources.create');
    Route::get('sources/{source}/edit', App\Livewire\Sources\Edit::class)->name('sources.edit');
    Route::get('sources/{source}', App\Livewire\Sources\Show::class)->name('sources.show');
});
