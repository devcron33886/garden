<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function shopProducts(Request $request)
    {
        $cat = $request->input('cat');
        $search = $request->input('search');

        $products = Product::with('category')
            ->when($cat, function (Builder $builder, $cat) {
                $builder->whereHas('category', function (Builder $builder) use ($cat) {
                    $builder->where('name', '=', $cat);
                });
            })
            ->when($search, function (Builder $builder, $search) {
                $builder->where('name', 'LIKE', "%$search%")
                    ->orWhere('price', 'LIKE', "%$search%")
                    ->orWhereHas('category', function (Builder $builder) use ($search) {
                        $builder->where('name', 'LIKE', "%$search%");
                    });
            })
            ->latest()
            ->paginate(10);

        $products->appends(['search' => $search, 'cat' => $cat]);

        return view('clients.products', compact('products'));
    }


    public function register()
    {
        return view('auth.register');
    }

    public function createAccount(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'user_name' => 'required|unique:users',
            'password' => 'required|min:4|confirmed'
        ]);

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->user_name = $request['user_name'];
        $user->role = 'Client';
        $user->password = bcrypt($request['password']);
        $user->save();

        $credentials = $request->only('user_name', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('home');
        }
        return redirect()->route('login')->with('message', 'Please login to continue.');
    }

    public function profile()
    {
        return view('clients.profile');
    }

    public function orders()
    {
        return view('clients.my-orders');
    }

    public function myOrders(Request $request)
    {

        $totalData = Order::with('user')
            ->where('user_id', Auth::user()->id)
            ->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = 'id';
        $dir = 'desc';

        if (empty($request->input('search.value'))) {
            $orders = Order::with('user')
                ->where('user_id', Auth::user()->id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $orders = Order::with('user')
                ->where('user_id', Auth::user()->id)
                ->where('status', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Order::with('user')
                ->where('user_id', Auth::user()->id)
                ->where('status', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $nestedData['id'] = $order->id;
                $nestedData['status'] = $order->status;
                $nestedData['shipping_address'] = $order->shipping_address;
                $nestedData['created_at'] = date('j M Y h:i a', strtotime($order->created_at));
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function productDetails(Product $product)
    {
        $onOder = OrderItem::query()->where('product_id', $product->id)->limit(20)->get();
        $alsoBoughtProducts = collect([]);
        if ($onOder) {
            $alsoBoughtProducts = Product::with('category')
                ->whereHas('orderItems', function (Builder $builder) use ($onOder, $product) {
                    $builder->whereIn('order_id', $onOder->pluck('order_id'))
                        ->where('product_id', '!=', $product->id);
                })->inRandomOrder()->limit(8)->get();
        }
        if ($alsoBoughtProducts->isEmpty()) {
            $alsoBoughtProducts = Product::with('category')
                ->where('category_id', $product->category_id)->inRandomOrder()
                ->limit(8)->get();
        }

        return view('clients.product_detail', compact('product', 'alsoBoughtProducts'));
    }
}
