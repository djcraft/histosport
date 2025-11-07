<?php
namespace App\Rules;
class LieuRules
{
    public static function rules(): array
    {
        return [
            'nom' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:20',
            'commune' => 'nullable|string|max:100',
            'departement' => 'nullable|string|max:100',
            'pays' => 'nullable|string|max:100',
        ];
    }
}
