<?php

namespace KirschbaumDevelopment\NovaMail\Traits;

use KirschbaumDevelopment\NovaMail\Models\NovaSentMail;

trait Mailable
{
    abstract public function getEmailField(): string;

    /**
     * Get the model's mail.
     */
    public function mails()
    {
        return $this->morphMany(NovaSentMail::class, 'mailable');
    }
}
