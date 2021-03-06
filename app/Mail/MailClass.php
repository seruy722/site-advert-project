<?php

namespace Advert\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailClass extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $message;
    protected $advertTitle;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($advertTitle, $name, $message)
    {
        $this->name = $name;
        $this->message = $message;
        $this->advertTitle = $advertTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact-mail')->with([
            'name' => $this->name,
            'msg' => $this->message,
            'advert_title' => $this->advertTitle,
        ])->subject('Новое сообщение с сайта Advert.net');
    }
}
