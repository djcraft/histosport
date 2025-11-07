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

    public function store(StoreCompetitionRequest $request)
    {
        $competition = Competition::create($request->validated());
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

    public function update(UpdateCompetitionRequest $request, $id)
    {
        $competition = Competition::findOrFail($id);
        $competition->update($request->validated());
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
