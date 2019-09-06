<?php

namespace KirschbaumDevelopment\NovaMail\Exceptions;

use Exception;
use KirschbaumDevelopment\NovaMail\Traits\Mailable;

class EventableMissingTrait extends Exception
{
    /**
     * @param mixed $eventable
     *
     * @return self
     */
    public function setEventable($eventable)
    {
        $this->message = sprintf('Class %s must use trait: %s.', $eventable, Mailable::class);

        return $this;
    }
}
