<?php

namespace KirschbaumDevelopment\NovaMail\Support;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Illuminate\Database\Eloquent\Model;
use KirschbaumDevelopment\NovaMail\Traits\Mailable;

class Eventable
{
    private static $defaultPaths = [
        '',
        'Models',
    ];

    /**
     * Eloquent models that events should be listened on.
     *
     * @var array
     */
    private static $models = [];

    /**
     * Register all of the resource classes in the given directory.
     *
     * @return void
     */
    public static function discoverModels()
    {
        $namespace = app()->getNamespace();

        $directories = collect(self::$defaultPaths)
            ->merge(config('nova_mail.model_paths'))
            ->transform(function($model) {
                return app_path($model);
            })
            ->filter(function ($directory) {
                return is_dir($directory);
            })
            ->toArray();

        if (empty($directories)) {
            return;
        }

        foreach ((new Finder)->in($directories)->depth(0)->files() as $resource) {
            $resource = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($resource->getPathname(), app_path() . DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($resource, Model::class)
                && in_array(Mailable::class, class_uses_recursive($resource))
            ) {
                self::$models[] = $resource;
            }
        }
    }

    /**
     * Check to see if given model has been set.
     *
     * @param string $model
     *
     * @return bool
     */
    public static function hasModel(string $model): bool
    {
        return in_array($model, self::$models);
    }

    /**
     * Get all eventable models.
     *
     * @return array
     */
    public static function models(): array
    {
        return self::$models;
    }
}
