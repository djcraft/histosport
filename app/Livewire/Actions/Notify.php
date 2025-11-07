<?php

namespace App\Livewire\Actions;

use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Session;

class Notify extends Action implements ActionInterface
{
    /**
     * Envoie une notification à la session Livewire.
     * @param string $message
     * @param string $type
     * @return void
     */
    public function handle(...$params)
    {
        $message = $params[0] ?? '';
        $type = $params[1] ?? 'success';
        Session::flash('notification', ['message' => $message, 'type' => $type]);
    }
}
