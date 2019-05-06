<?php

namespace KirschbaumDevelopment\NovaMail;

use Laravel\Nova\ResourceTool;

class NovaMail extends ResourceTool
{
    /**
     * @var string
     */
    protected $defaultFrom;

    /**
     * @var string
     */
    protected $defaultSubject;

    public function __construct()
    {
        parent::__construct();

        $this->defaultFrom = config('nova_mail.default_from');
        $this->defaultSubject = config('nova_mail.default_subject');

        $this->withMeta([
            'model' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[1]['class']::$model,
            'from' => $this->defaultFrom,
            'subject' => $this->defaultSubject,
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
            'model' => $subject,
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
