<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelModel; // Added use statement for LevelModel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LevelModel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_level' => ['required','string','unique:m_level,code_level'],
            'name_level' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $level = LevelModel::create($request->all());
        return response()->json($level, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LevelModel $level)
    {
        return response()->json($level, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LevelModel $level)
    {
        $validator = Validator::make($request->all(), [
            'code_level' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('m_level', 'code_level')->ignore($level->id_level, 'id_level')
            ],
            'name_level' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $level->update($request->all());
        return response()->json($level, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LevelModel $level)
    {
        $level->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Deleted Successfully'
        ]);
    }
}
