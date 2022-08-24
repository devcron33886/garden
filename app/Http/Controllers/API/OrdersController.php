<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessOrder;
use App\Order;
use App\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use function GuzzleHttp\Psr7\str;

class OrdersController extends Controller
{
    public function checkOut(Request $request)
    {
        $this->validate($request, [
            'client_name' => 'required',
            'email' => 'required|email',
            'shipping_address' => 'required',
            'phone_number' => 'required| min:10'
        ]);

        $order = new Order();
        $order->clientPhone = $request->input('phone_number');
        $order->email = $request->input('email');
        $order->clientName = $request->input('client_name');
        $order->shipping_address = $request->input('shipping_address');
        $order->notes = $request->input('notes');
        $order->shipping_amount = 1000;
        $order->status = "Pending";
        $order->save();
        $cart = $request->cart;
        foreach ($cart as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $cartItem['product_id'];
            $orderItem->price = $cartItem['price'];
            $orderItem->qty = $cartItem['qty'];
            $orderItem->sub_total = $cartItem['qty'] * $cartItem['price'];
            $order->orderItems()->save($orderItem);
        }
        //Send email to all users in background
        ProcessOrder::dispatch($order);
        return response([
            'data'=>$order->load('orderItems'),
            'message'=>'Thank you for making order! Your order will delivered no later than to day.'
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
