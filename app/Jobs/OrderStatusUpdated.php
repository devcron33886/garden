<?php

namespace App\Jobs;

use App\Mail\OrderPlaced;
use App\Mail\OrderStatusChanged;
use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OrderStatusUpdated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;
    protected $user;
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     * @param User $user
     */
    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;

        $users = collect([]);

        $client = new User();
        $client->name = $order->clientName;
        $client->email = $order->email;
        $users->push($client);

        $users = $users->each(function ($user) {
            return $user->email;
        });

        Mail::to($users)->send(new OrderStatusChanged($order, $this->user));
    }
}
