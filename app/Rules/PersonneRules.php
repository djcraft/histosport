<?php
namespace App\Rules;
class PersonneRules
{
    public static function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|string|max:10',
            'date_naissance_precision' => 'nullable|string|max:20',
            'lieu_naissance_id' => 'nullable|exists:lieu,lieu_id',
            'date_deces' => 'nullable|string|max:10',
            'date_deces_precision' => 'nullable|string|max:20',
            'lieu_deces_id' => 'nullable|exists:lieu,lieu_id',
        ];
    }
}
