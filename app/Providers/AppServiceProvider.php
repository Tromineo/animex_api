<?php

namespace App\Providers;

use App\Models\Anime;
use App\Models\Favoritos;
use App\Policies\AnimePolicy;
use App\Policies\FavoritosPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
        // Rate limiter para login: 5 tentativas por minuto por IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'Too many login attempts. Please try again in a minute.'
                ], 429);
            });
        });

        // Rate limiter para register: 10 tentativas por minuto por IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'Too many registration attempts. Please try again in a minute.'
                ], 429);
            });
        });

        // Rate limiter geral para rotas autenticadas: 60 requisições por minuto por usuário
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip())->response(function () {
                return response()->json([
                    'message' => 'Too many requests. Please slow down.'
                ], 429);
            });
        });
    }
}
