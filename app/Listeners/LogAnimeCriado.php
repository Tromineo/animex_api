<?php

namespace App\Listeners;

use App\Events\AnimeCriado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogAnimeCriado
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AnimeCriado $event): void
    {
        \Log::info('Anime criado: ' . $event->anime->titulo . ' (ID: ' . $event->anime->id . ')');
    }
}
