<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('admins.products', compact('categories'));
    }

    public function all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'category',
            5 => 'qty',
            4 => 'price',
            3 => 'measure',
            6 => 'minStock',
            7 => 'status'
        );

        $totalData = Product::query()->withoutGlobalScope('active')->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = 'id';
        $dir = 'desc';

        if (empty($request->input('search.value'))) {
            $products = Product::with('category')
                ->withoutGlobalScope('active')
                
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $products = Product::with('category')
                ->withoutGlobalScope('active')
                
                ->where('price', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Product::with('category')->withoutGlobalScope('active')
                
                ->where('price', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }
//return $products;
        $data = array();
        if (!empty($products)) {
            foreach ($products as $product) {
                if (is_null($product->category)) continue;
                $nestedData['id'] = $product->id;
                $nestedData['name'] = $product->name;
                $nestedData['measure'] = $product->measure;
                $nestedData['price'] = number_format($product->price);
                $nestedData['qty'] = $product->qty;
                $nestedData['minStock'] = $product->minStock;
                $nestedData['discount'] = $product->discount;
                $nestedData['status'] = $product->status;
                $nestedData['category'] = $product->category->name;
                $nestedData['image'] = asset("uploads/products/" . $product->image);
                $nestedData['description'] = substr(strip_tags($product->description), 0, 50) . "...";
                $nestedData['created_at'] = date('j M Y h:i a', strtotime($product->created_at));
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|file',
            'name' => 'required',
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'qty' => 'required|numeric',
            'measure' => 'required',
            'minStock' => 'required',
            'status' => 'required'
        ]);

        $category = Category::query()->withoutGlobalScopes()->find($request->input('category'));
        if (!$category) return response()->json(["message" => "Not found"], 404);

        $product = new Product();
        $product->name = $request['name'];
        $product->price = $request['price'];
        $product->discount = $request['discount'];
        $product->qty = $request['qty'];
        $product->measure = $request['measure'];
        $product->minStock = $request['minStock'];
        $product->description = $request['description'];
        $product->status = $request['status'];

        $photoName = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('uploads/products'), $photoName);
        $product->image = $photoName;

        $category->products()->save($product);
        return response()->json($product, 201);
    }


    public function show($id)
    {
        //
        $obj = Product::with('category')->withoutGlobalScope('active')->find($id);
        if (!$obj) {
            return \response()->json(["message" => "Not found"], 404);
        }
        return \response()->json($obj, 200);
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'qty' => 'required|numeric',
            'measure' => 'required',
            'minStock' => 'required',
            'status' => 'required'
        ]);


        $obj = Product::query()->withoutGlobalScopes()->find($request->input('id'));
        if (!$obj) return \response()->json(["message" => "Product Not found"], 404);

        $obj->name = $request['name'];
        $obj->price = $request['price'];
        $obj->discount = $request['discount'];
        $obj->qty = $request['qty'];
        $obj->measure = $request['measure'];
        $obj->minStock = $request['minStock'];
        $obj->description = $request['description'];
        $obj->status = $request['status'];
        $image = $obj->image;
        if ($request->image != null) {
            $photoName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/products'), $photoName);
            $obj->image = $photoName;

            $path = public_path() . '/uploads/products/' . $image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $obj->category_id = $request->input('category');
        $obj->update();
        return response()->json($obj, 204);
    }

    public function destroy($id)
    {
        $obj = Product::query()->withoutGlobalScopes()->find($id);
        if (!$obj) {
            return \response()->json(["message" => "Not found"], 404);
        }
        $path = public_path() . '/uploads/products/' . $obj->image;

        $obj->delete();

        $obj = Product::query()->withoutGlobalScopes()->find($id);
        if (!$obj) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        return \response()->json(["message" => "Data deleted"], 200);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids');
        foreach ($ids as $id) {
            try {
                $this->destroy($id);
            } catch (Exception $exception) {
//                echo $exception->getMessage().'<br>';
            }
        }
        return \response()->json(["message" => "Data deleted"], 200);
    }
}
