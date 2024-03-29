<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login()
    {
        if (auth()->user()) {
            return redirect(url('/panel/account'));
        }
        return view('auth.login');
    }

    public function sendCode(Request $request)
    {
        $randNumber = rand(10000, 99999);

        session()->put('login_code', $randNumber);

        return response()->json($randNumber);
    }

    public function checkCode(Request $request)
    {
        if ($request['code'] == session()->get('login_code')) {
            $userId = User::where('mobile', $request['mobile'])->pluck('id')->first();
            if (!empty($userId)) {
                Auth::loginUsingId($userId);
                return response()->json(['status' => 1]);
            } else {
                $user = User::create([
                    'mobile' => $request['mobile'],
                ]);
                $user->shamsi_c = Verta::instance($user->created_at)->format('Y/n/j');
                $user->save();

                Auth::login($user);

                return response()->json(['status' => 1]);
            }
        } else {
            return response()->json(['status' => 0]);
        }

    }

    public function loginValidation(Request $request)
    {
        $rules = [
            'mobile' => ['required', 'size:11'],
        ];

        $customMessages = [
            'mobile.required' => 'شماره همراه خود را وارد کنید.',
            'mobile.size' => 'شماره همراه را بطور صحیح وارد کنید.',
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
