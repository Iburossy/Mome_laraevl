<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\AdminMiddleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Enregistrer les services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap des services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Enregistrer le middleware
        $router->aliasMiddleware('admin', AdminMiddleware::class);
    }
}