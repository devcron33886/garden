<?php

namespace App\Observers;

use App\Notifications\OrderUpdatedNotification;
use App\Order;
use App\User;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        User::all()->except($order->updated_by)->each(function (User $user) use ($order) {
            $user->notify(new OrderUpdatedNotification($order));
        });
    }

}
