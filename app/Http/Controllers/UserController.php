<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function validateUser()
    {
        return response('', 204);
    }

    public function getAuth(){
        $res = Auth::user();
        $res->avatar = env('APP_URL') . $res->avatar;
        return $res;
    }
    public function check(){
        if (Auth::check()) {
            return Auth::user();
        }else{
            return 'false';
        }
    }

    public function uploadAvatar(Request $request)
    {
        $user = Auth::user();
        $avatar = $request->file('avatar')->store('/public/' . date('Y-m-d') . '/avatars');
//      上传的头像字段avatar是文件类型
        $avatar = Storage::url($avatar);
        $user->avatar = $avatar;
        $user->save();
    }
    public function changeAuth(Request $request){
        $res = $request->all();
        $this->validate(request(), [
            'nickname' => 'required|min:1',
//            'birthday' => 'required|data',
            'remark' => 'required|string',
            'email' => 'required|email',
        ]);
        $auth = Auth::user();
        $auth->name = $res['nickname'];
        $auth->birthday = date('Y-m-d H:i:s', strtotime($res['birthday']) / 1000);
        $auth->introduction = $res['remark'];
        $auth->email = $res['email'];
        $auth->save();
    }

}
