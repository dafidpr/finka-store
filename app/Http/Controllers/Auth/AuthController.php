<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Login',
            'mods' => 'login'
        ];

        return view('auth.index', $data);
    }

    public function check(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        try {
            $check = User::where('username',  $request->username);

            if ($check->count() > 0) {
                if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                    return response()->json([
                        'message' => 'Login berhasil'
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Invalid username or password',
                        'errors' => [
                            'password' => ['Password tidak sesuai']
                        ]
                    ], 422);
                }
            } else {
                return response()->json([
                    'message' => 'Invalid username or password',
                    'errors' => [
                        'username' => ['Username tidak terdaftar']
                    ]
                ], 422);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth');
    }
}
