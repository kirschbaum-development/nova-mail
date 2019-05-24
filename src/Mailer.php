<?php

namespace KirschbaumDevelopment\NovaMail;

use Laravel\Nova\ResourceTool;

class Mailer extends ResourceTool
{
    public function __construct($resource)
    {
        parent::__construct();

        throw_if(
            ! $resource || ! property_exists($resource, 'model'),
            \Exception::class,
            'This Mailer resource requires a valid Nova ResourceTool instance as it\'s first argument.'
        );

        $this->withMeta([
            'model' => $resource::$model,
        ]);
    }

    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Mailer';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'mailer';
    }
}
