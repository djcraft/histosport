<?php

namespace App\Livewire\Actions;

use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Session;

class Notify extends Action
{
    /**
     * Envoie une notification à la session Livewire.
     * @param string $message
     * @param string $type
     * @return void
     */
    public function handle(string $message, string $type = 'success')
    {
        Session::flash('notification', ['message' => $message, 'type' => $type]);
    }
}
