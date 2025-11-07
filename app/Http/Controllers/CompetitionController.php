<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreCompetitionRequest;
use App\Http\Requests\UpdateCompetitionRequest;
use App\Models\Competition;
use App\Models\CompetitionParticipant;

class CompetitionController extends BaseCrudController
{
    protected string $model = Competition::class;
    protected array $relations = ['participants', 'sources'];
    protected string $viewIndex = 'livewire.competitions.index';
    protected string $viewShow = 'livewire.competitions.show';
    protected string $viewCreate = 'livewire.competitions.create';
    protected string $viewEdit = 'livewire.competitions.edit';

    public function store(\Illuminate\Http\Request $request)
    {
        if ($request instanceof \App\Http\Requests\StoreCompetitionRequest) {
            $validated = $request->validated();
        } else {
            $validated = $request->validate(\App\Rules\CompetitionRules::rules());
        }
        $competition = Competition::create($validated);
        // Ajout des clubs participants
        foreach ($request->participant_club_ids ?? [] as $club_id) {
            CompetitionParticipant::create([
                'competition_id' => $competition->competition_id,
                'club_id' => $club_id,
                'resultat' => $request->resultats_club[$club_id] ?? null,
            ]);
        }
        // Ajout des personnes participantes
        foreach ($request->participant_personne_ids ?? [] as $personne_id) {
            CompetitionParticipant::create([
                'competition_id' => $competition->competition_id,
                'personne_id' => $personne_id,
                'resultat' => $request->resultats_personne[$personne_id] ?? null,
            ]);
        }
        return redirect()->route('competitions.show', $competition)->with('success', 'Compétition créée avec succès');
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $competition = Competition::findOrFail($id);
            $validated = (new UpdateCompetitionRequest())->rules();
            $request->validate($validated);
            $competition->update($request->all());
        // Suppression des anciens participants
        CompetitionParticipant::where('competition_id', $competition->competition_id)->delete();
        // Ajout des clubs participants
        foreach ($request->participant_club_ids ?? [] as $club_id) {
            CompetitionParticipant::create([
                'competition_id' => $competition->competition_id,
                'club_id' => $club_id,
                'resultat' => $request->resultats_club[$club_id] ?? null,
            ]);
        }
        // Ajout des personnes participantes
        foreach ($request->participant_personne_ids ?? [] as $personne_id) {
            CompetitionParticipant::create([
                'competition_id' => $competition->competition_id,
                'personne_id' => $personne_id,
                'resultat' => $request->resultats_personne[$personne_id] ?? null,
            ]);
        }
        return redirect()->route('competitions.show', $competition)->with('success', 'Compétition modifiée avec succès');
    }

    protected function detachRelations($entity)
    {
        $entity->disciplines()->detach();
        $entity->sources()->detach();
        $entity->participants()->delete();
    }
}
