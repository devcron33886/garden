<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Subscribed extends Mailable
{
    use Queueable, SerializesModels;

    public $topic;
    /**
     * @var string
     */
    public $email;

    /**
     * Create a new message instance.
     *
     * @param string $topic
     * @param string $email
     */
    public function __construct(string $topic,string $email)
    {
        $this->topic = $topic;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.subscribed')
            ->subject("Garden of Eden Newsletter");
    }
}
