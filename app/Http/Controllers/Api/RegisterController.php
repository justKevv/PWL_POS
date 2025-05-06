<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'name' => ['required'],
            'password' => ['required', 'min:5', 'confirmed'],
            'id_level' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = UserModel::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'id_level' => $request->id_level,
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Register Success',
                'data' => $user,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }
}
