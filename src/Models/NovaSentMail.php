<?php

namespace KirschbaumDevelopment\NovaMail\Models;

use Illuminate\Database\Eloquent\Model;

class NovaSentMail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mail_template_id',
        'subject',
        'content',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'mailable',
        'mailTemplate',
    ];



    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($mail) {
            $mail->sender_id = auth()->id();
        });
    }

    /**
     * Get the mail's mailable.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function mailable()
    {
        return $this->morphTo();
    }

    /**
     * Get the mail's mail template.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mailTemplate()
    {
        return $this->belongsTo(NovaMailTemplate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /**
     * Set the mail's mail template attribute.
     *
     * @param NovaMailTemplate|int $value
     *
     * @return void
     */
    public function setMailTemplateAttribute($value)
    {
        $value = $value instanceof NovaMailTemplate ? $value->id : $value;
        $this->attributes['mail_template_id'] = $value;
    }
}
