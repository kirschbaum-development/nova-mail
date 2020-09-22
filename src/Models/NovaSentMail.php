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
        'mail_event_id',
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
        'mailEvent',
    ];

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
     * Get the sent mail triggering mail event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mailEvent()
    {
        return $this->belongsTo(NovaMailEvent::class);
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

    /**
     * Set the mail's mail event attribute.
     *
     * @param NovaMailEvent|int $value
     *
     * @return void
     */
    public function setMailEventAttribute($value)
    {
        $value = $value instanceof NovaMailEvent ? $value->id : $value;
        $this->attributes['mail_event_id'] = $value;
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::created(function ($mail) {
            dump($mail->mailEvent);
            $mail->sender_id = auth()->id()
                ?? optional($mail->mailEvent)->user_id
                ?? $mail->mailTemplate->user_id;
        });
    }
}
