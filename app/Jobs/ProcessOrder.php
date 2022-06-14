<?php

namespace App\Jobs;

use App\Mail\OrderPlaced;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;
    public $tries = 5;

    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;

        $users = User::where('role', 'Admin')->get();
        //client email send as user
        $client = new User();
        $client->name = $order->clientName;
        $client->email = $order->email;
        $users->push($client);

        $users = $users->each(function ($user) {
            return $user->email;
        });
        Mail::to($users)->send(new OrderPlaced($order));
    }
}
