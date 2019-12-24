<?php

namespace KirschbaumDevelopment\NovaMail\Traits;

use KirschbaumDevelopment\NovaMail\Mail\Send;
use KirschbaumDevelopment\NovaMail\Support\Eventable;
use KirschbaumDevelopment\NovaMail\Models\NovaSentMail;
use KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate;

trait Mailable
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootMailable()
    {
        NovaMailTemplate::whereHas('events', function ($query) {
            $query->whereModel(get_called_class());
        })->each(function (NovaMailTemplate $novaMailTemplate) {
            $novaMailTemplate->events
                ->filter(function ($event) {
                    return Eventable::hasModel($event->model);
                })
                ->each(function ($event) use ($novaMailTemplate) {
                    if ($event->column) {
                        $event->model::updated(function ($model) use ($novaMailTemplate, $event) {
                            if ($model->isDirty($event->column)) {
                                $value = is_bool($model->{$event->column})
                                    ? filter_var($event->value, FILTER_VALIDATE_BOOLEAN)
                                    : $event->value;

                                if (is_null($event->value) || $model->{$event->column} === $value) {
                                    $model->sendMailTemplate($novaMailTemplate);
                                }
                            }
                        });

                        return;
                    }

                    $event->model::{$event->name}(function ($model) use ($novaMailTemplate) {
                        $model->sendMailTemplate($novaMailTemplate);
                    });
                });
        });
    }

    /**
     * Get the model's mail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function mails()
    {
        return $this->morphMany(NovaSentMail::class, 'mailable');
    }

    /**
     * Send a mail.
     *
     * @param \KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate $novaMailTemplate
     *
     * @return void
     */
    public function sendMailTemplate($novaMailTemplate)
    {
        $mailable = new Send(
            $this,
            $novaMailTemplate,
            $novaMailTemplate->content,
            $this->{$this->getEmailField()},
            $novaMailTemplate->subject
        );

        $mailable->deliver();
    }

    /**
     * Get the model's table columns.
     *
     * @return \Illuminate\Support\Collection
     */
    public function mailableColumns()
    {
        return collect(
            $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable())
        )->reject(function ($column) {
            return $this->rejectableColumn($column);
        })->map(function ($column) {
            return ['label' => $column, 'value' => $column];
        });
    }

    /**
     * Get the model's observable events.
     *
     * @return \Illuminate\Support\Collection
     */
    public function mailableEvents()
    {
        return collect(
            $this->getObservableEvents()
        )->reject(function ($event) {
            return $this->rejectableEvent($event);
        })->map(function ($event) {
            return ['label' => ucfirst($event), 'value' => $event];
        });
    }

    /**
     * Get the name of the email field.
     *
     * @return string
     */
    abstract public function getEmailField(): string;

    /**
     * Check if the event should be rejected.
     *
     * @param mixed $event
     *
     * @return bool
     */
    protected function rejectableEvent($event)
    {
        return in_array($event, [
            'retrieved',
            'creating',
            'saving',
            'replicating',
            'deleted',
            'forceDeleted'
        ]);
    }

    /**
     * Check if the column should be rejected.
     *
     * @param string $column
     *
     * @return bool
     */
    protected function rejectableColumn($column)
    {
        return
            $column == $this->getKeyName() ||
            in_array($column, [$this->getCreatedAtColumn(), $this->getUpdatedAtColumn()]) ||
            (in_array(SoftDeletes::class, class_uses($this)) && $column == $this->getDeletedAtColumn());
    }
}
