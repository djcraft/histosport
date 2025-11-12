<?php
namespace App\Rules;
class CompetitionRules
{
    public static function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'organisateur_club_id' => 'nullable|integer|exists:clubs,club_id',
            'organisateur_personne_id' => 'nullable|integer|exists:personnes,personne_id',
            'type' => 'nullable|string|max:100',
            'niveau' => 'nullable|string|max:100',
            'duree' => 'nullable|string|max:50',
            'discipline_ids' => 'nullable|array',
            'discipline_ids.*' => 'exists:disciplines,discipline_id',
            'site_ids' => 'nullable|array',
            'site_ids.*' => 'exists:lieu,lieu_id',
            'participant_club_ids' => 'nullable|array',
            'participant_club_ids.*' => 'exists:clubs,club_id',
            'participant_personne_ids' => 'nullable|array',
            'participant_personne_ids.*' => 'exists:personnes,personne_id',
        ];
    }
}
