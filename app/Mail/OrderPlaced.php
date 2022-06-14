<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build(): OrderPlaced
    {
        $address = 'frankuwuzuyinema@yahoo.fr';
        $order = $this->order;
        $subject = 'New order! Order# ' . $order->order_no;
        $name = 'Garden Of Eden Produce';

        return $this->markdown('emails.order_placed')
            ->from($address, $name)
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
