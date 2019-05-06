<?php

namespace KirschbaumDevelopment\NovaMail;

use KirschbaumDevelopment\NovaMail\Models\Mail;

trait Mailable
{
    abstract public function getEmailField(): string;

    /**
     * Get the model's mail.
     */
    public function mails()
    {
        return $this->morphMany(Mail::class, 'mailable');
    }
}
