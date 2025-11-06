<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class BaseCrudComponent extends Component
{
    // Propriétés communes
    public $entity;
    public $form = [];
    public $successMessage = '';

    // Règles de validation à définir dans le composant enfant
    protected $rules = [];

    // Méthode de validation générique
    public function validateForm()
    {
        $validated = Validator::make($this->form, $this->rules)->validate();
        $this->form = $validated;
    }

    // Méthode de notification générique
    public function notify($message, $type = 'success')
    {
        Session::flash('notification', ['message' => $message, 'type' => $type]);
        $this->successMessage = $message;
    }

    // Méthode d’enregistrement à surcharger
    public function save()
    {
        // À implémenter dans le composant enfant
    }

    // Méthode de suppression à surcharger
    public function delete()
    {
        // À implémenter dans le composant enfant
    }
}
