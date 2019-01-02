<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function username()
    {
        return 'name';
    }
    public function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $res = Response::create();
        $res->setStatusCode(204)->withCookie('sso_token', Auth::id(), 360, null, null, false, false);
        return $res;
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return Response::create(null,204);
    }
}
