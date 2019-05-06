<?php

namespace KirschbaumDevelopment\NovaMail\Models;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mail_template_id',
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
        return $this->belongsTo(MailTemplate::class);
    }

    /**
     * Set the mail's mail template attribute.
     *
     * @param MailTemplate|int $value
     *
     * @return void
     */
    public function setMailTemplateAttribute($value)
    {
        $value = $value instanceof MailTemplate ? $value->id : $value;
        $this->attributes['mail_template_id'] = $value;
    }
}
