<?php

namespace KirschbaumDevelopment\NovaMail\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
    ];

    /**
     * Get the mail template's mails.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mails()
    {
        return $this->hasMany(Mail::class);
    }
}
