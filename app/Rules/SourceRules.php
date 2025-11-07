<?php
namespace App\Rules;
class SourceRules
{
    public static function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'auteur' => 'nullable|string|max:255',
            'annee_reference' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'cote' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'lieu_edition_id' => 'nullable|integer|exists:lieu,lieu_id',
            'lieu_conservation_id' => 'nullable|integer|exists:lieu,lieu_id',
            'lieu_couverture_id' => 'nullable|integer|exists:lieu,lieu_id',
        ];
    }
}
