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
    use Queueable;
    use SerializesModels;
    use InteractsWithQueue;

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
        $novaMailTemplateOption = data_get($mailOptions, 'selectedTemplate.id');
        $novaMailTemplate = $novaMailTemplateOption ? NovaMailTemplate::find($novaMailTemplateOption) : null;

        $models->each(function ($model) use ($mailOptions, $novaMailTemplate) {
            $mailable = new Send(
                $model,
                $novaMailTemplate,
                $mailOptions['body'],
                $model->{$model->getEmailField()},
                $mailOptions['subject'],
                null,
                $mailOptions['send_delay_in_minutes']
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
