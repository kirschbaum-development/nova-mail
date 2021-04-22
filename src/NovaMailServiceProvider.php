<?php

namespace KirschbaumDevelopment\NovaMail;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use KirschbaumDevelopment\NovaMail\Traits\Mailable;
use KirschbaumDevelopment\NovaMail\Policies\NovaSentMailPolicy;
use KirschbaumDevelopment\NovaMail\Exceptions\EventableMissingTrait;
use KirschbaumDevelopment\NovaMail\Observers\NovaMailTemplateObserver;
use KirschbaumDevelopment\NovaMail\Models\NovaSentMail as NovaSentMailModel;
use KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate as NovaMailTemplateModel;

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
        $this->observers();
        $this->policies();
        $this->nova();
        $this->ensureEventablesAreMailable();
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

    /**
     * Publish config, load views.
     *
     * @return void
     */
    protected function config()
    {
        $this->publishes([
            __DIR__ . '/../config/nova_mail.php' => config_path('nova_mail.php'),
        ]);

        $this->loadViewsFrom(
            Storage::disk(config('nova_mail.compiled_mail_disk'))->path(config('nova_mail.compiled_mail_path')),
            'nova-mail'
        );
    }

    /**
     * Load migrations.
     *
     * @return void
     */
    protected function migrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    /**
     * Register observers.
     *
     * @return void
     */
    protected function observers()
    {
        NovaMailTemplateModel::observe(NovaMailTemplateObserver::class);
    }

    /**
     * Set up policies.
     *
     * @return void
     */
    protected function policies()
    {
        Gate::policy(NovaSentMailModel::class, NovaSentMailPolicy::class);
    }

    /**
     * Setup resources and routes.
     *
     * @return void
     */
    protected function nova()
    {
        Nova::resources([
            config('nova_mail.default_resources.nova_sent_mail'),
            config('nova_mail.default_resources.nova_mail_template'),
            config('nova_mail.default_resources.nova_mail_event'),
        ]);

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function () {
            Nova::script('send-mail', __DIR__ . '/../dist/js/fields.js');
            Nova::style('send-mail', __DIR__ . '/../dist/css/fields.css');
        });
    }

    /**
     * Ensure configured Eventables use Mailable trait.
     *
     * @return void
     */
    protected function ensureEventablesAreMailable()
    {
        collect(config('nova_mail.eventables'))->each(function ($eventable) {
            throw_unless(
                collect(class_uses_recursive($eventable))->contains(Mailable::class),
                (new EventableMissingTrait)->setEventable($eventable)
            );
        });
    }

    /**
     * Register routes.
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
