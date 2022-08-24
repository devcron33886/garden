<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrder;
use App\MyFunc;
use App\Order;
use App\OrderItem;
use App\Payment;
use App\Product;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Throwable;

class CartController extends Controller
{

    public function getAddToCart(Request $request, $id)
    {
        $product = Product::find($id);
        if (is_null($product) || $product->status !== 'Available') {
            return redirect()->back();
        }

        $qty = $request->input('qty');
        if (!$qty) {
            $qty = 1;
        }

        $cartItem = Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => $qty,
            'price' => $product->getRealPrice()
        ]);
        $cartItem->associate($product);

        return redirect()->back();
    }

    public function getShoppingCart()
    {
        return view('clients.carts');
    }

    public function getIncrement(Request $request, $id)
    {
        $qty = $request->input('qty');
        if (!$qty) {
            $qty = 1;
        }

        $product = Product::findOrFail($id);
        Cart::remove($id);
        $cartItem = Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => $qty,
            'price' => $product->getRealPrice()
        ]);
        $cartItem->associate($product);

        return redirect()->route('cart.shoppingCart');
    }

    public function getDecrement($id)
    {
        // you may also want to update a product by reducing its quantity, you do this like so:
        Cart::update($id, array(
            'quantity' => -1, // so if the current product has a quantity of 4, it will subtract 1 and will result to 3
        ));

        return redirect()->route('cart.shoppingCart');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function getRemoveItem($id)
    {
        Cart::remove($id);
        return redirect()->route('cart.shoppingCart');
    }

    public function getRemoveAll()
    {
        Cart::clear();
        return redirect()->route('cart.shoppingCart');
    }

    public function checkOut()
    {
        if (Cart::isEmpty()) {
            return redirect()->route('cart.shoppingCart');
        }
        $cart = Cart::getContent();
        return view('clients.check-out', ['cart' => $cart]);
    }

    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function postCheckOut(Request $request)
    {
        $this->validate($request, [
            'clientName' => 'required',
            'email' => 'required|email',
            'shipping_address' => 'required',
            'phoneNumber' => 'required| min:10'
        ]);

        if (Cart::isEmpty()) {
            return redirect()->back();
        }
        DB::beginTransaction();
        $order = new Order();
        $order->clientPhone = $request->input('phoneNumber');
        $order->email = $request->input('email');
        $order->clientName = $request->input('clientName');
        $order->shipping_address = $request->input('shipping_address');
        $order->payment_type = Payment::Cash;
        $order->notes = $request->input('notes');
        $order->shipping_amount = MyFunc::getDefaultSetting()->shipping_amount;
        $order->status = "Pending";
        $order->save();

        $cart = Cart::getContent();
        foreach ($cart as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $cartItem->id;
            $orderItem->price = $cartItem->price;
            $orderItem->qty = $cartItem->quantity;
            $orderItem->sub_total = $cartItem->getPriceSum();
            $order->orderItems()->save($orderItem);
        }

        $order->setOrderNo('ORD');
        DB::commit();

        ProcessOrder::dispatch($order);
        Cart::clear();
        if ($request->input('payment_type') == Payment::CARD_MOBILE_MONEY) {
            return redirect()->route('order.pay.card', ['id' => encryptId($order->id)]);
        } else {
            return redirect()->route('order.success', ['id' => encryptId($order->id)]);
        }
    }
}
