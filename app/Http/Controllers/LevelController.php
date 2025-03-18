<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = (object) [
            'title' => 'Level List',
            'list' => ['Home', 'Level'],
        ];

        $page = (object) [
            'title' => 'list of level registered in the system',
        ];

        $activeMenu = 'level';

        return view('level.index', compact('page', 'breadcrumbs', 'activeMenu'));
    }

    public function list(Request $request) {
        $levels = LevelModel::all();

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('action', function ($levels) { // add action column
                $btn = '<a href="' . url('/level/' . $levels->id_level) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/level/' . $levels->id_level . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $levels->id_level) . '">
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
            'title' => 'Add Level',
            'list' => ['Home', 'Level', 'Add'],
        ];

        $page = (object) [
            'title' => 'Add New Level',
        ];

        $activeMenu = 'level';

        return view('level.create', [
            'breadcrumbs' => $breadcrumbs,
            'page' => $page,
            'activeMenu' => $activeMenu,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code_level' => 'required|string|max:3|unique:m_level,code_level',  // username must be filled, string type, minimum 3 characters, and unique in m_user table username column
            'name_level' => 'required|string|max:100',  // name must be filled, string type, and maximum 100 characters
        ]);

        LevelModel::create([
            'code_level' => $request->code_level,
            'name_level' => $request->name_level,

        ]);

        return redirect('/level')->with('success', 'Level data has been saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(LevelModel $level)
    {
        $breadcrumbs = (object) [
            'title' => 'Level Detail',
            'list' => ['Home', 'Level', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Level Detail',
        ];

        $activeMenu = 'level';

        return view('level.show', [
            'breadcrumbs' => $breadcrumbs,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'level' => $level,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LevelModel $level)
    {
        $breadcrumbs = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Level',
        ];

        $activeMenu = 'level';

        return view('level.edit', [
            'breadcrumbs' => $breadcrumbs,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'level' => $level,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LevelModel $level)
    {
        $request->validate([
            'code_level' => 'required|string|max:3|unique:m_level,code_level',  // username must be filled, string type, minimum 3 characters, and unique in m_user table username column
            'name_level' => 'required|string|max:100',  // name must be filled, string type, and maximum 100 characters
        ]);

        $level->update([
            'code_level' => $request->code_level,
            'name_level' => $request->name_level,
        ]);

        return redirect('/level')->with('success', 'Level data has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LevelModel $level)
    {
        $level->delete();
        return redirect('/level')->with('success', 'Level data has been deleted successfully');
    }
}
