<?php

namespace KirschbaumDevelopment\NovaMail\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use KirschbaumDevelopment\NovaMail\Mail\Send;
use KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate;
use KirschbaumDevelopment\NovaMail\SendMail as SendMailField;

class SendMail extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return __('Send Mail');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $mailOptions = json_decode($fields['mail'], true);

        $models->each(function ($model) use ($mailOptions) {
            $mailable = new Send(
                $model,
                NovaMailTemplate::findOrFail($mailOptions['selectedTemplate']['id']),
                $mailOptions['body'],
                $model->{$model->getEmailField()},
                $mailOptions['subject']
            );
            $mailable->deliver();
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            SendMailField::make('Mail'),
        ];
    }
}
