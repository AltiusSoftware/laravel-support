<?php

namespace Altius\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $expire;
    public function __construct(public $url, public $minutes)
    {
        $this->expire = now()->addSeconds($minutes * 60 +1)->diffForHumans();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('altius::emails.password.reset');
    }
}
