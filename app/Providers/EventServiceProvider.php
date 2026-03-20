<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\AnimeCriado;
use App\Listeners\LogAnimeCriado;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AnimeCriado::class => [
            LogAnimeCriado::class,
        ],
        \App\Events\ComentarioCriado::class => [
            \App\Listeners\ComentarioCriadoLogger::class,
        ],
        \App\Events\FavoritoAdicionado::class => [
            \App\Listeners\FavoritoAdicionadoLogger::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
