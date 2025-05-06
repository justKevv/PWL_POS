<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Consider adding pagination for large datasets: UserModel::paginate();
        return response()->json(UserModel::with('level')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_level' => ['required', 'integer', 'exists:m_level,id_level'],
            'username' => ['required', 'string', 'unique:m_user,username'],
            'name' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:5', 'confirmed'], // Requires password_confirmation field
            'profile_image' => ['nullable', 'string'], // Or 'image' rule if uploading files
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();
        $validatedData['password'] = Hash::make($validatedData['password']); // Hash password

        $user = UserModel::create($validatedData);
        $user->load('level'); // Load the level relationship

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserModel $user)
    {
        return response()->json($user->load('level'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserModel $user)
    {
        $validator = Validator::make($request->all(), [
            'id_level' => ['required', 'integer', 'exists:m_level,id_level'],
            'username' => ['required', 'string', Rule::unique('m_user', 'username')->ignore($user->id_user, 'id_user')],
            'name' => ['required', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:5', 'confirmed'], // Optional password update
            'profile_image' => ['nullable', 'string'], // Or 'image' rule if uploading files
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        // Only update password if provided
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // Don't update password if empty
        }

        $user->update($validatedData);
        $user->load('level'); // Reload relationship if needed

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserModel $user)
    {
        // Consider adding checks (e.g., cannot delete admin user)
        try {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User Deleted Successfully'
            ], 200); // 200 OK or 204 No Content
        } catch (\Exception $e) {
            // Log error $e->getMessage()
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user.'
            ], 500);
        }
    }
}
