<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function postLogin(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $credentials = $request->validate([
                    'username' => ['required', 'string'],
                    'password' => ['required', 'string']
                ]);

                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();

                    return response()->json([
                        'status' => true,
                        'message' => 'Login Successful',
                        'redirect' => url('/'),
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid username or password.',
                ], 422);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Login error: ' . $e->getMessage(),
                ], 500);
            }
        }

        return redirect('login');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
