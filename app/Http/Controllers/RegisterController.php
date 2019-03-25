<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|min:1|unique:users',
            'password' => 'required|min:6|max:16',
            'email' => 'required|email|unique:users',
        ]);
        $name = request('name');
        $email = request('email');
        $password = bcrypt(request('password'));
         User::create(compact(['name', 'email', 'password']));

        return response('', 204);
    }
}
