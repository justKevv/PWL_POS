<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register() {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function postRegister(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $credentials = $request->validate([
                    'username' => ['required', 'string', 'min:4', 'max:20'],
                    'name' => ['required', 'string', 'min:3', 'max:50'],
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                    'terms' => ['required', 'accepted']
                ]);

                $user = UserModel::create([
                    'username' => $credentials['username'],
                    'name' => $credentials['name'],
                    'password' => $credentials['password'],
                    'id_level' => 3
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'User created successfully',
                    'redirect' => url('/login'),
                ]);
            } catch (\Exception $e) {
                return response()->json([
                   'status' => false,
                   'message' => 'Registration error: '. $e->getMessage(),
                ], 500);
            }
        }
        return redirect('register');
    }
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
