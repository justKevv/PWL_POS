<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Create a new user
        $user = UserModel::create([
            'username' => 'manager21',
            'name' => 'manager21',
            'password' => Hash::make('12345'),
            'id_level' => 2,
        ]);

        // Update username
        $user->username = 'manager12';

        // Save changes
        $user->save();

        // wasChanged() checks
        $user->wasChanged(); // true
        $user->wasChanged('username'); // true
        $user->wasChanged(['username', 'id_level']); // true
        $user->wasChanged('name'); // false
        $user->wasChanged(['name', 'username']); // true
        dd($user->wasChanged(['name', 'username']));
        return view("user", compact("user"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserModel $userModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserModel $userModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserModel $userModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserModel $userModel)
    {
        //
    }
}
