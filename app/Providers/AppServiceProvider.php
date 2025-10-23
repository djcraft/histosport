<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    \App\Models\ClubPersonne::observe(\App\Observers\HistorisationPivotObserver::class);
    \App\Models\ClubDiscipline::observe(\App\Observers\HistorisationPivotObserver::class);
    \App\Models\DisciplinePersonne::observe(\App\Observers\HistorisationPivotObserver::class);
    \App\Models\EntitySource::observe(\App\Observers\HistorisationPivotObserver::class);
    \App\Models\CompetitionParticipant::observe(\App\Observers\HistorisationPivotObserver::class);
    \App\Models\CompetitionDiscipline::observe(\App\Observers\HistorisationPivotObserver::class);

        \App\Models\Personne::observe(\App\Observers\HistorisationObserver::class);
        \App\Models\Club::observe(\App\Observers\HistorisationObserver::class);
        \App\Models\Competition::observe(\App\Observers\HistorisationObserver::class);
        \App\Models\Lieu::observe(\App\Observers\HistorisationObserver::class);
        \App\Models\Discipline::observe(\App\Observers\HistorisationObserver::class);
        \App\Models\Source::observe(\App\Observers\HistorisationObserver::class);
    }
}
