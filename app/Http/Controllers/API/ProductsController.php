<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends Controller
{

    public function productsByCategory(Category $category)
    {
        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(\request('page_size') ?? 20);
        return response($products);
    }

    public function allProducts(Request $request)
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(\request('page_size') ?? 20);
        return response($products);
    }


    public function searchProduct(Request $request)
    {
        if (empty($request->input('q'))) {
            $products = Product::with('category')
                ->latest()
                ->paginate(\request('page_size') ?? 20);
        } else {
            $search = $request->input('q');
            $products = Product::with('category')
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('price', 'LIKE', "%{$search}%")
                ->latest()
                ->paginate(20);
            $products->appends(['q' => $search]);
        }
        return response($products, Response::HTTP_OK);
    }


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
