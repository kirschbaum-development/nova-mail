<?php

namespace KirschbaumDevelopment\NovaMail\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * @var int
     */
    public $template;

    /**
     * @var string
     */
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Model $model, NovaMailTemplate $mailTemplate, string $content, string $to, string $from = null, string $subject = null)
    {
        $this->model = $model;
        $this->mailTemplate = $mailTemplate;
        $this->content = $content;
        $this->to($to);
        $this->from($from ?? config('nova_mail.default_from'));
        $this->subject($subject ?? config('nova_mail.default_subject'));

        $this->timestamp = now()->format('Y_m_d_His');
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
        Mail::send($this);

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
            'subject' => $this->subject,
            'content' => $this->render(),
            'mail_template' => $this->mailTemplate,
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
        return sprintf('%s_%d_%s%s', $this->timestamp, $this->model->id, strtolower(class_basename($this->model)), $append ? '_' . $append : '');
    }
}
