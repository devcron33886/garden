<?php

namespace App\Http\Controllers;

use App\Notifications\InfoSlackNotification;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class UsersController extends Controller
{

    public function index()
    {
        return view('admins.users');
    }

    public function all(Request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'email',
            2 => 'role'
        );

        $totalData = User::whereNotIn('role', ['Client', Role::SUPER_ADMIN])->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))
        {
            $users = User::whereNotIn('role', ['Client', Role::SUPER_ADMIN])->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else
        {
            $search = $request->input('search.value');

            $users = User::whereNotIn('role', ['Client', Role::SUPER_ADMIN])
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('role', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = User::whereNotIn('role', ['Client', Role::SUPER_ADMIN])
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($users))
        {
            foreach ($users as $user)
            {
                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['role'] = $user->role;
                $nestedData['created_at'] = date('j M Y h:i a', strtotime($user->created_at));
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
            'name' => 'required',
//            'user_name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'role' => 'required',
            'password' => 'required|min:4'
        ]);

        $user = new User();
        $user->name = $request['name'];
        $user->user_name = $request['email'];
        $user->email = $request['email'];
        $user->role = $request['role'];
        $user->password = bcrypt($request['password']);
        $user->save();
        return response()->json($user, 201);
    }


    public function show($id)
    {
        //
        $obj = User::find($id);
        if (!$obj)
        {
            return \response()->json(["message" => "Not found"], 404);
        }
        return \response()->json($obj, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
//            'user_name' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);

        $email = $request['email'];
        $password = $request->input('password');
        $id = $request->input('id');

        $obj = User::find($id);
        if (!$obj) return response()->json(['message' => 'Not found'], 404);

        $obj->name = $request['name'];
        $obj->user_name = $email;
        $obj->email = $email;

        if (!empty($password))
        {
            $obj->password = bcrypt($password);
        }

        $obj->role = $request['role'];
        $obj->update();
        return response()->json($obj, 200);
    }

    public function destroy($id)
    {
        $obj = User::find($id);
        if (!$obj)
        {
            return \response()->json(["message" => "Not found"], 404);
        }
        $obj->delete();
        return \response()->json(["message" => "Data deleted"], 200);
    }


    public function login()
    {
        return view("auth.login");
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required',
            'password' => 'required|min:4'
        ]);

        $credentials = $request->only('user_name', 'password');

        $attempt = \auth()->attempt($credentials, \request('remember') ? true : false);
        if ($attempt)
        {
            $user = \auth()->user();

            Notification::route('slack', config('app.LOG_SLACK_WEBHOOK_URL'))
                ->notify(new InfoSlackNotification($user->name . " Logged in on " . $request->userAgent() . " ,with IP=" . $request->ip()));


            if (in_array($user->role, Role::roles()))
            {
                return redirect()->route('dashboard');
            }
            return redirect()->home();
        }
        return redirect()->back()
            ->with('message', 'Incorrect email or password')
            ->withErrors(['password' => 'Incorrect email or password'])
            ->withInput(['user_name' => $request->input('user_name')]);
    }

    public function logOut()
    {
        $user = Auth::user();
        if ($user->role === 'Client')
        {
            Auth::logout();
            return redirect()->route('home');
        }
        Notification::route('slack', config('app.LOG_SLACK_WEBHOOK_URL'))
            ->notify(new InfoSlackNotification($user->name . " Logged out"));
        Auth::logout();
        return view('auth.login');
    }

}
