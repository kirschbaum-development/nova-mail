<?php

namespace KirschbaumDevelopment\NovaMail\Support;

use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;
use Illuminate\Database\Eloquent\Model;
use KirschbaumDevelopment\NovaMail\Traits\Mailable;

class Eventable
{
    /**
     * Default auto-discover paths.
     * 
     * @var array
     */
    private static $defaultPaths = [
        'app',
        'app/Models',
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
        self::getFiles(self::directories())
            ->each(function($model) {
                $model = self::getFullyQualifiedNamespace($model->getContents());

                if (is_subclass_of($model, Model::class)
                    && in_array(Mailable::class, class_uses_recursive($model))
                    && ! in_array($model, config('nova_mail.excluded_models'))
                ) {
                    self::$models[] = $model;
                }
            });
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

    /**
     * Get a files from specified directories.
     *
     * @param array $directories
     *
     * @return Collection
     */
    private static function getFiles(array $directories): Collection
    {
        if (! empty($directories)) {
            $files = (new Finder)->in($directories)
                ->depth(0)
                ->name('*.php')
                ->files();
        }

        return collect($files ?? []);
    }

    /**
     * Extract the fully qualified namespace from the file.
     *
     * @param $contents
     *
     * @return string|null
     */
    private static function getFullyQualifiedNamespace($contents)
    {
        $namespace = preg_match('#^namespace\s+(.+?);$#sm', $contents, $matches)
            ? $matches[1]
            : null;

        $className = preg_match('#^class\s+(\w+)#sm', $contents, $matches)
            ? $matches[1]
            : null;

        return $namespace && $className
            ? "{$namespace}\\{$className}"
            : null;
    }

    /**
     * Directories for auto-discovering eventable models.
     *
     * @return array
     */
    private static function directories(): array
    {
        return collect(self::$defaultPaths)
            ->merge(config('nova_mail.model_paths'))
            ->diff(config('nova_mail.excluded_paths'))
            ->transform(
                function ($model) {
                    return base_path($model);
                }
            )
            ->filter(
                function ($directory) {
                    return is_dir($directory);
                }
            )
            ->toArray();
    }
}
