<?php

namespace App\Rules;

class ClubRules
{
    public static function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'nom_origine' => 'nullable|string|max:255',
            'surnoms' => 'nullable|string|max:255',
            'date_fondation' => 'nullable|string|max:10',
            'date_disparition' => 'nullable|string|max:10',
            'date_declaration' => 'nullable|string|max:10',
            'acronyme' => 'nullable|string|max:50',
            'couleurs' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'siege_id' => 'nullable|integer|exists:lieu,lieu_id',
            // Ajoute ici les autres règles selon le modèle Club
        ];
    }
}
