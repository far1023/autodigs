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

    public function attempt(LoginRequest $request)
    {
        try {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                $request->session()->regenerate();
                return response()->json(
                    [
                        "code" => 200,
                        "message" => "Login berhasil",
                        "redirect" => route('beranda')
                    ],
                    200
                );
            }

            return response()->json(
                [
                    "code" => 401,
                    "message" => "Nama pengguna atau kata sandi salah"
                ],
                401
            );
        } catch (\Throwable $th) {
            return response()->json(
                ["message" => $th->getMessage()],
                500
            );
        }
    }
}
