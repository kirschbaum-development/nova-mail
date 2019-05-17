<?php

namespace KirschbaumDevelopment\NovaMail;

use Laravel\Nova\ResourceTool;

class NovaMail extends ResourceTool
{
    public function __construct()
    {
        parent::__construct();

        $this->withMeta([
            'model' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[1]['class']::$model,
            'from' => config('nova_mail.default_from'),
            'subject' => config('nova_mail.default_subject'),
        ]);
    }

    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Nova Mail';
    }

    /**
     * The default from placeholder.
     *
     * @param string $from
     *
     * @return $this
     */
    public function withFrom(string $from)
    {
        return $this->withMeta([
            'from' => $from,
        ]);
    }

    /**
     * The default subject placeholder.
     *
     * @param string $from
     *
     * @return $this
     */
    public function withSubject(string $subject)
    {
        return $this->withMeta([
            'subject' => $subject,
        ]);
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'nova-mail';
    }
}
