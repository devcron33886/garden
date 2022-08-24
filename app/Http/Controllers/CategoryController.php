<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admins.categories');
    }

    public function newCategories()
    {
        $categories = Category::query()->withoutGlobalScope('active')->get();
        return view('admins.new_categories', compact('categories'));
    }

    public function all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'status',
            3 => 'created_at'
        );

        $totalData = Category::query()->withoutGlobalScope('active')->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $categories = Category::query()->withoutGlobalScope('active')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $categories = Category::query()->withoutGlobalScope('active')->where('created_at', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Category::query()->withoutGlobalScope('active')->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $nestedData['id'] = $category->id;
                $nestedData['name'] = $category->name;
                $nestedData['status'] = $category->status;
                /* $nestedData['body'] = substr(strip_tags($category->body),0,50)."...";*/
                $nestedData['created_at'] = date('j M Y h:i a', strtotime($category->created_at));
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
        $category = new Category();
        $category->name = $request->input('name');
        $category->status = $request->input('status');
        $category->save();
        return \response()->json(["message" => "Data saved"], 201);
    }

    public function show($id)
    {
        $category = Category::query()->withoutGlobalScopes()->find($id);
        if (!$category) {
            return \response()->json(["message" => "Not found"], 404);
        }
        return \response()->json($category, 200);
    }

    public function update(Request $request)
    {
        $category = Category::query()->withoutGlobalScopes()->find($request->input('id'));
        if (!$category) {
            return \response()->json(["message" => "Not found"], 404);
        }
        $category->name = $request->input('name');
        $category->status = $request->input('status');
        $category->update();
        return \response()->json(["message" => "Data updated"], 204);
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $category = new Category();
        } else {
            $category = Category::query()->withoutGlobalScopes()->find($request->input('id'));
        }
        $category->name = $request->input('name');
        $category->status = $request->input('status');
        $category->save();
        return \response()->json(["message" => "Data updated"], 204);
    }


    public function destroy($id)
    {
        $category = Category::query()->withoutGlobalScopes()->find($id);
        if (!$category) {
            return \response()->json(["message" => "Not found"], 404);
        }
        $category->delete();
        return \response()->json(["message" => "Data deleted"], 200);
    }
}
