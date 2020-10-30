<?php

namespace Legalworks\IsbnTools;

use Illuminate\Support\ServiceProvider;
use Legalworks\IsbnTools\Services\BookDataManager;

class IsbnToolsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'legalworks');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'legalworks');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/legalworks-isbntools.php', 'legalworks-isbntools');

        // Register the service the package provides.
        $this->app->singleton('laravel-isbn-tools', function ($app) {
            return new IsbnTools;
        });

        $this->app->singleton('book-api', function ($app) {
            return new BookDataManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-isbn-tools', 'book-api'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/legalworks-isbntools.php' => config_path('legalworks-isbntools.php'),
        ], 'laravel-isbn-tools.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/legalworks'),
        ], 'laravelisbntools.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/legalworks'),
        ], 'laravelisbntools.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/legalworks'),
        ], 'laravelisbntools.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
