<?php

namespace App\Listeners;

use App\Events\FavoritoAdicionado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FavoritoAdicionadoLogger
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
    public function handle(FavoritoAdicionado $event): void
    {
        \Log::info('Favorito adicionado: usuário ' . $event->favorito->user_id . ' favoritou anime ' . $event->favorito->anime_id . ' (ID favorito: ' . $event->favorito->id . ')');
    }
}
