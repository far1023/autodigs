<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    protected $logging;

    public function __construct()
    {
        $this->logging = Log::channel('file');
    }

    public function run(LoginRequest $request)
    {
        if (User::where('username', $request->username)->first()) {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->intended('beranda');
            }
        }

        $this->logging->info("Failed login attempt", ["username" => $request->username]);

        return back()->with([
            'loginError' => 'Nama pengguna atau kata sandi salah',
        ])->withInput();
    }
}
