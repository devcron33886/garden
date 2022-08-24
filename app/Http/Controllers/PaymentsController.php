<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrder;
use App\MyFunc;
use App\Order;
use App\OrderItem;
use App\Payment;
use Cart;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class PaymentsController extends Controller
{
    /**
     * @throws Throwable
     */
    public function paymentSuccess(Request $request, $orderId): JsonResponse
    {
        DB::beginTransaction();

        $order = Order::find(decryptId($orderId));
        $order->payment_type = Payment::CARD_MOBILE_MONEY;
        $order->save();

        $payment = new Payment();
        $payment->transaction_id = $request->input('transaction_id');
        $payment->tx_ref = $request->input('tx_ref');
        $payment->flw_ref = $request->input('flw_ref');
        $payment->amount = $request->input('amount');
        $payment->currency = $request->input('currency') ?? 'RWF';
        $payment->status = $request->input('status');
        $order->payments()->save($payment);

        DB::commit();
        return response()->json(['url' => route('order.success', ['id' => encryptId($order->id)])]);
    }

    public function payWithCard($id)
    {
        $order = Order::find(decryptId($id));
        return view('clients.pay_card', compact('order'));

    }
}
