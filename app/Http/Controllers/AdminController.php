<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view("admin.dashboard");
    }

    public function users(Request $request){

        $perPage = $request->input('perPage', 20);
        $sortField = $request->input('sortField', 'created_at');
        $sortOrder = $request->input('sortOrder', 'desc');

        $data['title_page'] = 'Users';

        $users = User::with('detail')
            ->orderBy($sortField, $sortOrder)
            ->paginate($perPage);

        $data['users'] = $users;


        return view("admin.users", [
            'data' => $data,
            'perPage' => $perPage,
            'sortOrder' => $sortOrder,
        ]);
    }

    public function block($id)
    {
        $user = User::find($id);
        $user->is_blocked = true;
        $user->save();

        return redirect()->back()->with('success', 'User has been blocked.');
    }

    public function unblock($id)
    {
        $user = User::find($id);
        $user->is_blocked = false;
        $user->save();

        return redirect()->back()->with('success', 'User has been unblocked.');
    }


}
