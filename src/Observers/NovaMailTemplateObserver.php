<?php

namespace KirschbaumDevelopment\NovaMail\Observers;

use KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate;

class NovaMailTemplateObserver
{
    /**
     * Observer for model deleted event
     */
    public function deleted(NovaMailTemplate $novaMailTemplate)
    {
        $novaMailTemplate->events->each->delete();
    }
}
