<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\OrderItem;
use App\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function randomProducts()
    {
        $products = Product::with('category')
            ->inRandomOrder()
            ->limit(4)
            ->get();
        return response($products, 200);
    }

    public function newProducts()
    {
        $products = Product::with('category')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
        return response($products, 200);
    }

    public function products()
    {
        $arrays = array(
            'random' => $this->randomProducts(),
            'new' => $this->newProducts()
        );
        return response($arrays, 200);
    }

    public function topSoldProducts()
    {
        $products = OrderItem::with('product.category')
            ->join('products', 'products.id', 'order_items.product_id')
            ->select('*','products.id', DB::raw('count(products.id) as sold_count'))
            ->groupBy('products.id')
            ->orderBy('sold_count', 'desc')
            ->limit(20)->with('product')
            ->get();
        return response($products, 200);
    }

}
