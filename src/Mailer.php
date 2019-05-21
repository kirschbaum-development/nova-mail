<?php

namespace KirschbaumDevelopment\NovaMail;

use Laravel\Nova\ResourceTool;

class Mailer extends ResourceTool
{
    public function __construct()
    {
        parent::__construct();

        $this->withMeta([
            'model' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[1]['class']::$model,
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
