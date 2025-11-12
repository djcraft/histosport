
@props([
    'label' => '',
    'mandats' => [],
    'type' => 'club', // 'club' ou 'personne'
])
<div class="mb-4">
    <span class="block text-gray-700 dark:text-gray-300 font-semibold">{{ $label }}</span>
    <div class="mt-1 space-y-2">
        @forelse($mandats as $mandat)
            <div class="flex items-center space-x-2">
                @if($type === 'personne')
                    <a href="{{ route('clubs.show', $mandat->club) }}" class="inline-block align-middle">
                        <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">{{ $mandat->club->nom ?? '' }}</x-badges.badge>
                    </a>
                @else
                    <a href="{{ route('personnes.show', $mandat->personne) }}" class="inline-block align-middle">
                        <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">{{ $mandat->personne->nom ?? '' }} {{ $mandat->personne->prenom ?? '' }}</x-badges.badge>
                    </a>
                @endif
                @if(!empty($mandat->role))
                    <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100 font-semibold">{{ $mandat->role }}</x-badges.badge>
                @endif
                <span class="text-xs text-gray-700 dark:text-gray-300">
                    @php
                        $precisions = ['année','year','mois','month','jour','day'];
                        $debut = $mandat->date_debut;
                        $debutPrecision = $mandat->date_debut_precision;
                        $fin = $mandat->date_fin;
                        $finPrecision = $mandat->date_fin_precision;
                        $debutAff = ($debut && in_array($debutPrecision, $precisions)) ? formatMandatDate($debut, $debutPrecision) : ($debut ?? null);
                        $finAff = ($fin && in_array($finPrecision, $precisions)) ? formatMandatDate($fin, $finPrecision) : ($fin ?? null);
                    @endphp
                    @if($debutAff && $finAff)
                        {{ $debutAff }} – {{ $finAff }}
                    @elseif($debutAff)
                        {{ $debutAff }}
                    @elseif($finAff)
                        Jusqu'à {{ $finAff }}
                    @elseif(empty($debutAff) && empty($finAff))
                        <span class="italic text-gray-400">Période inconnue</span>
                    @endif
                </span>
            </div>
        @empty
            <span class="block text-gray-900 dark:text-gray-100">Aucun mandat enregistré</span>
        @endforelse
    </div>
</div>
