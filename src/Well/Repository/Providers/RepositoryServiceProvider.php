<?php

namespace Well\Repository\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../resources/config/repository.php' => config_path('repository.php')
        ]);

	    $this->mergeConfigFrom(__DIR__ . '/../resources/config/repository.php', 'repository');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Well\Repository\Commands\RepositoryCommand');
    }
}
