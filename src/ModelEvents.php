<?php

namespace KirschbaumDevelopment\NovaMail;

use Laravel\Nova\Fields\Field;

class ModelEvents extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'model-events';

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|callable|null  $attribute
     * @param  callable|null  $resolveCallback
     *
     * @return void
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $models = collect(config('nova_mail.eventables'))->map(function ($class) {
            return [
                'label' => $class,
                'value' => $class,
                'events' => $this->getModelTrackables($class),
            ];
        });

        $this->withMeta([
            'models' => $models->values()->all(),
        ]);
    }

    /**
     * Get the model's trackable events and columns.
     *
     * @param string $class
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getModelTrackables($class)
    {
        return resolve($class)->mailableTrackables();
    }
}
