<?php

namespace Tassili\Crud;

use Illuminate\Support\ServiceProvider;

class TassiliServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
      $this->publishes([
            __DIR__.'/../config/tassili.php' => config_path('tassili.php'),
        ], 'tassili-config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/tassili.php', 'tassili'
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

         $this->commands([
            \Tassili\Crud\Commands\CreateUser::class,
            \Tassili\Crud\Commands\CrudCommand::class,
            \Tassili\Crud\Commands\TassiliCreator::class,
            \Tassili\Crud\Commands\WizardCommand::class,
        ]);

    }
}