<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function run(LoginRequest $request)
    {
        if (User::where('username', $request->username)->first()) {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->intended('beranda');
            }
        }

        return back()->with([
            'loginError' => 'Nama pengguna atau kata sandi salah',
        ])->withInput();
    }
}
