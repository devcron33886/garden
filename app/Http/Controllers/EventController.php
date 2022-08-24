<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;


class EventController extends Controller
{

    public function index()
    {
        $event = Event::query()->first();
        return view("admins.events", compact('event'));
    }

    public function all(Request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'date',
            2 => 'description'
        );

        $totalData = Event::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = Event::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = Event::where('name', 'LIKE', "%{$search}%")
                ->orWhere('date', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Event::where('name', 'LIKE', "%{$search}%")
                ->orWhere('date', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($users)) {
            foreach ($users as $user) {
                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->name;
                $nestedData['date'] = $user->date;
                $nestedData['active'] = $user->active;
                $nestedData['description'] = $user->description;
//                $nestedData['created_at'] = date('j M Y h:i a', strtotime($user->created_at));
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


    public function show($id)
    {
        $obj = Event::find($id);
        if (!$obj) {
            return \response()->json(["message" => "Not found"], 404);
        }
        return \response()->json($obj, 200);
    }


    public function update(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);
        $id = $request->input('id');
        if ($id > 0) {
            $obj = Event::find($id);
        } else {
            $obj = new Event();
        }

        $obj->name = $request->input('name');
        $obj->date = $request->input('date');
        $obj->description = $request->input('description');

        if (!empty($request->input('active'))) {
            $obj->active = true;
        } else {
            $obj->active = false;
        }
        $obj->save();
        return redirect()->back();
    }


}
