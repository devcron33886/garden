<?php

namespace App\Jobs;

use App\Mail\Subscribed;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EmailSubscription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $text;

    /**
     * Create a new job instance.
     *
     * @param $email
     * @param $text
     */
    public function __construct($email, $text)
    {
        $this->email = $email;
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)
            ->send(new  Subscribed($this->text, $this->email));
    }
}
