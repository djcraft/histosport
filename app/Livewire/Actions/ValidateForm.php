<?php

namespace App\Livewire\Actions;

use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Validator;

class ValidateForm extends Action
{
    /**
     * Valide les données du formulaire selon les règles passées.
     * @param array $form Données du formulaire
     * @param array $rules Règles de validation
     * @return array Données validées
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(array $form, array $rules)
    {
        $validated = Validator::make($form, $rules)->validate();
        return $validated;
    }
}
