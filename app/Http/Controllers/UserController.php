<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = (object) [
            'title' => 'User List',
            'list' => ['Home', 'User'],
        ];

        $page = (object) [
            'title' => 'list of users registered in the system',
        ];

        $activeMenu = 'user';

        return view('user.index', [
            'breadcrumbs' => $breadcrumbs,
            'page' => $page,
            'activeMenu' => $activeMenu,
        ]);
    }

    /**
     * Fetch user data in json form for datatables
     */
    public function list(Request $request)
    {
        $users = UserModel::select('id_user', 'username', 'name', 'id_level')
            ->with('level');

        return DataTables::of($users)
            ->addIndexColumn() // add auto sort column (default column name: DT_RowIndex)
            ->addColumn('action', function ($user) { // add action column
                $btn = '<a href="' . url('/user/' . $user->id_user) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->id_user . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->id_user) . '">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Did you delete this data?\');">Delete</button></form>';

                return $btn;
            })
            ->rawColumns(['action']) // tells you that the action column is html
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = (object) [
            'title' => 'Add User',
            'list' => ['Home', 'User', 'Add'],
        ];

        $page = (object) [
            'title' => 'Add New User',
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', [
            'breadcrumbs' => $breadcrumbs,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',  // username must be filled, string type, minimum 3 characters, and unique in m_user table username column
            'name' => 'required|string|max:100',  // name must be filled, string type, and maximum 100 characters
            'password' => 'required|string|min:3',  // password must be filled and minimum 3 characters
            'id_level' => 'required|integer'  // level_id must be filled and numeric type
        ]);

        UserModel::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => bcrypt($request->password),  // password is encrypted before saving
            'id_level' => $request->id_level
        ]);

        return redirect('/user')->with('success', 'User data has been saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserModel $user)
    {
        $breadcrumbs = (object) [
            'title' => 'User Detail',
            'list' => ['Home', 'User', 'Detail'],
        ];

        $page = (object) [
            'title' => 'User Detail',
        ];

        $user->load('level');

        $activeMenu = 'user';

        return view('user.show', compact('breadcrumbs', 'page', 'user', 'activeMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserModel $user)
    {
        $level = LevelModel::all();

        $breadcrumbs = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit User',
        ];

        $user->load('level');

        $activeMenu = 'user';
        return view('user.edit', compact('breadcrumbs', 'page', 'user', 'level', 'activeMenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserModel $user)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $user->id_user . ',id_user',
            'name' => 'required|string|max:100',
            'password' => 'nullable|string|min:3',
            'id_level' => 'required|integer'
        ]);

        $user->username = $request->username;
        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->id_level = $request->id_level;

        $user->save();
        return redirect('/user')->with('success', 'User data has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserModel $user)
    {
        if (!$user) {
            return redirect('/user')->with('error', 'User not found');
        }

        try {
            $user->delete();
            return redirect('/user')->with('success', 'User data has been deleted successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', $e->getMessage());
        }

    }
}
