<?php

namespace App\Livewire\Actions;

use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Validator;

class ValidateForm extends Action implements ActionInterface
{
    /**
     * Valide les données du formulaire selon les règles passées.
     * @param array $form Données du formulaire
     * @param array $rules Règles de validation
     * @return array Données validées
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(...$params)
    {
        $form = $params[0] ?? [];
        $rules = $params[1] ?? [];
        return Validator::make($form, $rules)->validate();
    }
}
