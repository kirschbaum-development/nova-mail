<?php

namespace KirschbaumDevelopment\NovaMail\Nova;

use App\Nova\User;
use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use KirschbaumDevelopment\NovaMail\Models\NovaSentMail as NovaSentMailModel;

class NovaSentMail extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = NovaSentMailModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'subject',
        'content',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            MorphTo::make('mailable')->hideFromIndex(),
            BelongsTo::make('Sender', 'sender', User::class),
            Text::make('Subject'),
            BelongsTo::make('Template', 'mailTemplate', config('nova_mail.default_resources.nova_mail_template')),
            Textarea::make('Content')
                ->displayUsing(function ($content) {
                    return trim(strip_tags($content));
                })
                ->alwaysShow(),
            DateTime::make('Sent At', 'created_at'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Sent Mail';
    }

    /**
     * Determine if this resource is available for navigation.
     *
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return config('nova_mail.show_resources.nova_sent_mail');
    }
}
