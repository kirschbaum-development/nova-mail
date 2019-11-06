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
use KirschbaumDevelopment\NovaMail\Models\NovaSentMail as NovaSentMailModel;

class NovaSentMail extends Resource
{
    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;
    
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
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Sent Mails');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Sent Mail');
    }

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
     * Get the logical group associated with the resource.
     *
     * @return string
     */
    public static function group()
    {
        return __('System');
    }

    /**
     * Show the sub-group.
     *
     * @return bool
     */
    public static $showSubGroup = true;

    /**
     * Get the logical sub-group associated with the resource.
     *
     * @return string
     */
    public static function subGroup()
    {
        return __('Mail');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            MorphTo::make('mailable')->hideFromIndex(),
            BelongsTo::make(__('Sender'), 'sender', User::class),
            Text::make(__('Subject'), 'subject'),
            BelongsTo::make(__('Template'), 'mailTemplate', NovaMailTemplate::class),
            Textarea::make(__('Content'), 'content')
                ->displayUsing(function ($content) {
                    return trim(strip_tags($content));
                })
                ->alwaysShow(),
            DateTime::make(__('Sent At'), 'created_at')->format('DD/MM/YYYY HH:mm:ss'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return config('nova_mail.show_resources.nova_sent_mail');
    }
}
