<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

        $level = LevelModel::all();

        $activeMenu = 'user';

        return view('user.index', compact('page', 'breadcrumbs', 'activeMenu', 'level'));
    }

    /**
     * Fetch user data in json form for datatables
     */
    public function list(Request $request)
    {
        $users = UserModel::select('id_user', 'username', 'name', 'id_level')
            ->with('level');

        if ($request->id_level) {
            $users = $users->where('id_level', $request->id_level);
        }

        return DataTables::of($users)
            ->addIndexColumn() // add auto sort column (default column name: DT_RowIndex)
            ->addColumn('action', function ($user) { // add action column
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->id_user . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->id_user . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->id_user . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';

                return $btn;
            })
            ->rawColumns(['action']) // tells you that the action column is html
            ->make(true);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('id_level', 'name_level')->get();

        return view('user.create_ajax', compact('level'));
    }

    public function show_ajax(UserModel $user)
    {
        $user->load('level');
        return view('user.show_ajax', compact('user'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_level' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'name' => 'required|string|max:100',
                'password' => 'required|string|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            UserModel::create([
                'id_level' => $request->id_level,
                'username' => $request->username,
                'name' => $request->name,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
            ]);
        }

        redirect('/');
    }

    public function edit_ajax(UserModel $user)
    {
        $level = LevelModel::select('id_level', 'name_level')->get();
        return view('user.edit_ajax', compact('user', 'level'));
    }

    public function update_ajax(Request $request, UserModel $user)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_level' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username,' . $user->id_user . ',id_user',
                'name' => 'required|string|max:100',
                'password' => 'nullable|string|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            if ($user) {
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }

                $user->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'User updated successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                ]);
            }
        }
        redirect('/');
    }

    public function confirm_ajax(UserModel $user)
    {
        return view('user.confirm_ajax', compact('user'));
    }

    public function delete_ajax(Request $request, UserModel $user)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if ($user) {
                $user->delete();
                return response()->json([
                   'status' => true,
                   'message' => 'User deleted successfully',
                ]);
            } else {
                return response()->json([
                   'status' => false,
                   'message' => 'User not found',
                ]);
            }
        }
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
