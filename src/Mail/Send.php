<?php

namespace KirschbaumDevelopment\NovaMail\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use KirschbaumDevelopment\NovaMail\Models\NovaMailEvent;
use KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate;

class Send extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * @var \KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate
     */
    public $mailTemplate;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $timestamp;

    /**
     * @var NovaMailEvent|null
     */
    public $mailEvent;

    /**
     * @var int
     */
    public $sendDelayInMinutes = 0;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        Model $model,
        NovaMailTemplate $mailTemplate,
        string $content,
        string $to,
        string $subject,
        $mailEvent = null,
        $sendDelayInMinutes = 0
    ) {
        $this->model = $model;
        $this->mailTemplate = $mailTemplate;
        $this->content = $content;
        $this->to($to);
        $this->from(config('mail.from.address'), config('mail.from.name'));
        $this->subject($subject);
        $this->mailEvent = $mailEvent;
        $this->timestamp = now()->format('Y_m_d_His');
        $this->sendDelayInMinutes = $sendDelayInMinutes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('nova-mail::' . $this->filename(), $this->model->toArray());
    }

    /**
     * Execute delivery.
     *
     * @return $this
     */
    public function deliver()
    {
        $this->precompile()->disseminate()->record()->cleanup();

        return $this;
    }

    /**
     *  Save the compiled blade file.
     *
     * @return $this
     */
    private function precompile()
    {
        Storage::disk($this->disk())->put($this->path(), $this->content);

        Storage::disk($this->disk())->put($this->path('subject'), $this->subject);
        $this->subject(view('nova-mail::' . $this->filename('subject'), $this->model->toArray())->render());

        return $this;
    }

    /**
     * Send the mail.
     *
     * @return $this
     */
    private function disseminate()
    {
        Mail::later(now()->addMinutes($this->sendDelayInMinutes), $this);

        return $this;
    }

    /**
     * Persist the content to the mail.
     *
     * @return $this
     */
    private function record()
    {
        $this->model->mails()->create([
            'mail_template_id' => $this->mailTemplate->id,
            'subject' => $this->subject,
            'content' => $this->render(),
            'mail_event_id' => $this->mailEvent ? $this->mailEvent->id : null,
            'send_delay_in_minutes' => $this->sendDelayInMinutes,
        ]);

        return $this;
    }

    /**
     * Cleanup the compiled blade file.
     *
     * @return $this
     */
    private function cleanup()
    {
        if (! config('nova_mail.keep_compiled_file')) {
            Storage::disk($this->disk())->delete($this->path());
        }

        Storage::disk($this->disk())->delete($this->path('subject'));

        return $this;
    }

    /**
     * The disk for the compiled blade file.
     *
     * @return string
     */
    private function disk()
    {
        return config('nova_mail.compiled_mail_disk');
    }

    /**
     * The path of the compiled blade file.
     *
     * @param string|null $append
     *
     * @return string
     */
    private function path(string $append = null)
    {
        return sprintf('%s/%s.blade.php', config('nova_mail.compiled_mail_path'), $this->filename($append));
    }

    /**
     * The filename of the compiled blade file.
     *
     * @param string|null $append
     *
     * @return string
     */
    private function filename(string $append = null)
    {
        return sprintf(
            '%s_%d_%s%s',
            $this->timestamp,
            $this->model->id,
            strtolower(class_basename($this->model)),
            $append ? '_' . $append : ''
        );
    }
}
