<?php

namespace App\Listeners;

use App\Events\ComentarioCriado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ComentarioCriadoLogger
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
    public function handle(ComentarioCriado $event): void
    {
        \Log::info('Comentário criado: ' . $event->comentario->content . ' (ID: ' . $event->comentario->id . ')');
    }
}
