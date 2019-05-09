<?php

namespace KirschbaumDevelopment\NovaMail\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use KirschbaumDevelopment\NovaMail\Models\NovaSentMail;

class NovaSentMailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the mail.
     *
     * @param  \App\User  $user
     * @param  \KirschbaumDevelopment\NovaMail\Models\NovaSentMail  $mail
     *
     * @return mixed
     */
    public function view(User $user, NovaSentMail $mail)
    {
        return true;
    }

    /**
     * Determine whether the user can create mails.
     *
     * @param  \App\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the mail.
     *
     * @param  \App\User  $user
     * @param  \KirschbaumDevelopment\NovaMail\Models\NovaSentMail  $mail
     *
     * @return mixed
     */
    public function update(User $user, NovaSentMail $mail)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the mail.
     *
     * @param  \App\User  $user
     * @param  \KirschbaumDevelopment\NovaMail\Models\NovaSentMail  $mail
     *
     * @return mixed
     */
    public function delete(User $user, NovaSentMail $mail)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the mail.
     *
     * @param  \App\User  $user
     * @param  \KirschbaumDevelopment\NovaMail\Models\NovaSentMail  $mail
     *
     * @return mixed
     */
    public function restore(User $user, NovaSentMail $mail)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the mail.
     *
     * @param  \App\User  $user
     * @param  \KirschbaumDevelopment\NovaMail\Models\NovaSentMail  $mail
     *
     * @return mixed
     */
    public function forceDelete(User $user, NovaSentMail $mail)
    {
        return true;
    }
}
