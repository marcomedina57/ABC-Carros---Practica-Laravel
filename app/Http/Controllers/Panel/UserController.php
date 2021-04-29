<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(){

        return view('users.index')
        ->with([
            'users' => User::all()
        ]);


    }

    public function toggleAdmin(User $user){
        if($user->isAdmin()){
            $user->admin_since = null;
        } else {
            $user->admin_since = now()->subYear();
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->withSuccess('Admin status changed');
    }
}
