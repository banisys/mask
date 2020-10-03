<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        if (auth()->user()) {
            return redirect(url('/panel/account'));
        }
        return view('auth.login');
    }

    public function loginValidation(Request $request)
    {
        $rules = [
            'mobile' => ['required', 'size:11'],
            'password' => ['required'],
        ];

        $customMessages = [
            'mobile.required' => 'شماره همراه خود را وارد کنید.',
            'mobile.size' => 'شماره همراه را بطور صحیح وارد کنید.',
            'password.required' => 'کلمه عبور خود را وارد کنید.',
        ];

        $this->validate($request, $rules, $customMessages);

        if (Auth::attempt(['mobile' => $request['mobile'], 'password' => $request['password']])) {
            return response()->json(['key' => 'value'], 200);
        } else {
            return response()->json(['error' => 'not match'], 200);
        }
    }

    public function loginStore(Request $request)
    {
        return redirect(url('/panel/account'));
    }

}
