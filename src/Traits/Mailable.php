<?php

namespace KirschbaumDevelopment\NovaMail\Traits;

use KirschbaumDevelopment\NovaMail\Mail\Send;
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
        NovaMailTemplate::whereRaw(self::whereClause())
            ->each(function (NovaMailTemplate $novaMailTemplate) {
                $modelEvents = json_decode($novaMailTemplate->model_events);

                collect($modelEvents)->each(function ($modelEvent) use ($novaMailTemplate) {
                    if (collect(resolve($modelEvent->model)->getObservableEvents())->contains($modelEvent->event)) {
                        $modelEvent->model::{$modelEvent->event}(function ($model) use ($novaMailTemplate) {
                            $model->sendMailTemplate($novaMailTemplate);
                        });
                    } else {
                        $modelEvent->model::updated(function ($model) use ($novaMailTemplate, $modelEvent) {
                            if ($model->isDirty($modelEvent->event)) {
                                $model->sendMailTemplate($novaMailTemplate);
                            }
                        });
                    }
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
     * Get the model's trackable model events and columns.
     *
     * @return \Illuminate\Support\Collection
     */
    public function mailableTrackables()
    {
        return $this->mailableEvents()->merge($this->mailableColumns());
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
     * Get the name of the email field.
     *
     * @return string
     */
    abstract public function getEmailField(): string;

    /**
     * Get the model's table columns.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function mailableColumns()
    {
        return collect(
            $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable())
        )->reject(function ($column) {
            return $this->rejectableColumn($column);
        })->map(function ($column) {
            return ['label' => $column, 'value' => $column, 'group' => 'Columns'];
        });
    }

    /**
     * Get the model's observable events.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function mailableEvents()
    {
        return collect(
            $this->getObservableEvents()
        )->reject(function ($event) {
            return $this->rejectableEvent($event);
        })->map(function ($event) {
            return ['label' => ucfirst($event), 'value' => $event, 'group' => 'Events'];
        });
    }

    /**
     * Check if the event should be rejected.
     *
     * @param mixed $event
     *
     * @return bool
     */
    protected function rejectableEvent($event)
    {
        return in_array($event, ['retrieved', 'creating', 'saving', 'replicating', 'deleted', 'forceDeleted']);
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

    /**
     * Raw where clause for listener registration.
     *
     * @return string
     */
    protected static function whereClause()
    {
        return sprintf('JSON_CONTAINS(model_events->"$[*].model", JSON_QUOTE("%s"))', addslashes(get_called_class()));
    }
}
