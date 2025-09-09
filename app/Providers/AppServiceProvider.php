<?php

namespace App\Providers;

use App\Models\Anime;
use App\Models\Favoritos;
use App\Policies\AnimePolicy;
use App\Policies\FavoritosPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Anime::class => AnimePolicy::class,
        Favoritos::class => FavoritosPolicy::class
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
