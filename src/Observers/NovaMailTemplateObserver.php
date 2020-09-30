<?php

namespace KirschbaumDevelopment\NovaMail\Observers;

use KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate;

class NovaMailTemplateObserver
{
    /**
     * Observer for model deleted event
     *
     * @param \KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate $novaMailTemplate
     */
    public function deleted(NovaMailTemplate $novaMailTemplate)
    {
        $novaMailTemplate->events->each->delete();
    }
}
