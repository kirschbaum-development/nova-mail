<?php

namespace KirschbaumDevelopment\NovaMail\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Access\HandlesAuthorization;
use KirschbaumDevelopment\NovaMail\Models\NovaSentMail;

class NovaSentMailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the mail.
     *
     * @return bool
     */
    public function view(Authenticatable $user, NovaSentMail $mail)
    {
        return true;
    }

    /**
     * Determine whether the user can create mails.
     *
     * @return bool
     */
    public function create(Authenticatable $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the mail.
     *
     * @return bool
     */
    public function update(Authenticatable $user, NovaSentMail $mail)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the mail.
     *
     * @return bool
     */
    public function delete(Authenticatable $user, NovaSentMail $mail)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the mail.
     *
     * @return bool
     */
    public function restore(Authenticatable $user, NovaSentMail $mail)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the mail.
     *
     * @return bool
     */
    public function forceDelete(Authenticatable $user, NovaSentMail $mail)
    {
        return true;
    }
}
