<?php

namespace KirschbaumDevelopment\NovaMail;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use KirschbaumDevelopment\NovaMail\Nova\NovaSentMail;
use KirschbaumDevelopment\NovaMail\Nova\NovaMailTemplate;
use KirschbaumDevelopment\NovaMail\Policies\NovaSentMailPolicy;
use KirschbaumDevelopment\NovaMail\Models\NovaSentMail as NovaSentMailModel;

class NovaMailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->config();
        $this->migrations();
        $this->policies();
        $this->nova();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova_mail.php', 'nova_mail');
    }

    protected function config()
    {
        $this->publishes([
            __DIR__ . '/../config/nova_mail.php' => config_path('nova_mail.php'),
        ]);

        $this->loadViewsFrom(Storage::disk(config('nova_mail.compiled_mail_disk'))->path(config('nova_mail.compiled_mail_path')), 'nova-mail');
    }

    protected function migrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    protected function policies()
    {
        Gate::policy(NovaSentMailModel::class, NovaSentMailPolicy::class);
    }

    protected function nova()
    {
        Nova::resources([
            NovaSentMail::class,
            NovaMailTemplate::class,
        ]);

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('send-mail', __DIR__ . '/../dist/js/fields.js');
            Nova::style('send-mail', __DIR__ . '/../dist/css/fields.css');
        });
    }

    /**
     * Register the package's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->prefix('nova-mail')
            ->group(__DIR__ . '/../routes/api.php');
    }
}
