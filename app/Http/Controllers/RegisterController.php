<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class RegisterController extends Controller
{
    public function register(Request $request)
    {
//        array:5 [
//        "Nickname" => "root"
//  "password" => "123456"
//  "confirm" => "123456"
//  "email" => "123456@qq.com"
//  "captcha" => "的撒打算"
////]
//        'title' => 'required|string|min:1',
//            'column_id' => 'required|integer',
//            'tag_ids' => 'required|array'
        $this->validate(request(),[
            'name' => 'required|min:1|unique:users',
            'password' => 'required|min:6|max:16',
            'email' => 'required|email|unique:users',
        ]);
        $name = request('name');
        $email = request('email');
        $password = bcrypt(request('password'));
//        $password = bcrypt(request('password'));
//        $name = request('Nickname');
//        $email = request('email');
         User::create(compact(['name', 'email', 'password']));

        return response('', 204);
    }
}
