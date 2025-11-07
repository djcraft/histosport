<?php
namespace App\Rules;
class DisciplineRules
{
    public static function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
