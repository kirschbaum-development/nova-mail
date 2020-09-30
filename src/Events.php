<?php

namespace KirschbaumDevelopment\NovaMail;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Events extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'events';

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

        $this->addEventablesToMeta();
        $this->setFillCallback();
    }

    /**
     * Add eventables to field meta data.
     *
     * @return void
     */
    protected function addEventablesToMeta()
    {
        $eventables = collect(config('nova_mail.eventables'))
            ->map(function ($class) {
                return [
                    'label' => $class,
                    'value' => $class,
                    'events' => $this->getModelEvents($class),
                    'columns' => $this->getModelColumns($class),
                ];
            });

        $this->withMeta([
            'eventables' => $eventables->values()->all(),
        ]);
    }

    /**
     * Setup custom fill logic for saving event data.
     *
     * @return void
     */
    protected function setFillCallback()
    {
        $this->fillUsing(function (NovaRequest $request, $requestAttribute, $model) {
            $events = collect(json_decode($request->events, true))
                ->map(function ($event) use ($requestAttribute, $model, $request) {
                    return $requestAttribute->{$model}()->updateOrCreate([
                        'id' => data_get($event, 'id'),
                    ], [
                        'model' => data_get($event, 'model'),
                        'name' => data_get($event, 'name'),
                        'column' => data_get($event, 'column'),
                        'value' => data_get($event, 'anyValue') ? null : $event['value'],
                        'user_id' => $request->user()->id,
                    ]);
                });

            $requestAttribute->{$model}()->whereNotIn('id', $events->pluck('id'))->get()->each->delete();
        });
    }

    /**
     * Get the model's trackable events.
     *
     * @param string $class
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getModelEvents($class)
    {
        return resolve($class)->mailableEvents();
    }

    /**
     * Get the model's trackable columns.
     *
     * @param string $class
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getModelColumns($class)
    {
        return resolve($class)->mailableColumns();
    }
}
