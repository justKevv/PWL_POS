<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // Added
use PhpOffice\PhpSpreadsheet\IOFactory; // Added
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
                $btn = '<button onclick="modalAction(\'' . url('/level/' . $levels->id_level . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $levels->id_level . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $levels->id_level . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';

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

    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    public function show_ajax(LevelModel $level)
    {
        return view('level.show_ajax', compact('level'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'code_level' =>'required|string|max:3|unique:m_level,code_level',
                'name_level' =>'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            LevelModel::create($request->all());

            return response()->json([
               'status' => true,
               'message' => 'Level created successfully',
            ]);
        }

        redirect('/');
    }

    public function edit_ajax(LevelModel $level)
    {
        return view('level.edit_ajax', compact('level'));
    }

    public function update_ajax(Request $request, LevelModel $level)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'code_level' => 'required|string|max:3|unique:m_level,code_level,' . $level->id_level . ',id_level',
                'name_level' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            if ($level) {
                $level->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Level updated successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Level not found',
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(LevelModel $level)
    {
        return view('level.confirm_ajax', compact('level'));
    }

    public function delete_ajax(Request $request, LevelModel $level)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if ($level) {
                $level->delete();
                return response()->json([
                   'status' => true,
                   'message' => 'Level deleted successfully',
                ]);
            } else {
                return response()->json([
                   'status' => false,
                   'message' => 'Level not found',
                ]);
            }
        }
        return redirect('/');
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
            'code_level' => 'required|string|max:3|unique:m_level,code_level',  // levelsname must be filled, string type, minimum 3 characters, and unique in m_levels table levelsname column
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
    /**
     * Show the form for importing levels via AJAX.
     */
    public function import_ajax()
    {
        // Simple view return for the modal content
        return view('level.import_ajax');
    }

    /**
     * Handle the AJAX request for importing levels from a file.
     */
    public function store_import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if (!$request->hasFile('file_level')) {
                return response()->json([
                    'status' => false,
                    'message' => 'No file uploaded',
                    'msgField' => ['file_level' => ['Please select a file']]
                ]);
            }

            $rules = [
                'file_level' => ['required', 'mimes:xlsx,xls', 'max:2048']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Failed',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $file = $request->file('file_level');
                $reader = IOFactory::createReaderForFile($file->getRealPath());
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true);

                $insert = [];
                $errors = [];
                $rowCount = 0;

                if (count($data) > 1) {
                    foreach ($data as $row => $value) {
                        if ($row > 1) {
                            $rowCount++;
                            $rowData = [
                                'code_level' => $value['A'] ?? null,
                                'name_level' => $value['B'] ?? null,
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                            $rowValidator = Validator::make($rowData, [
                                'code_level' => 'required|string|max:3',
                                'name_level' => 'required|string|max:100',
                            ]);

                            if ($rowValidator->fails()) {
                                $errors[] = "Row " . $row . ": " . implode(', ', $rowValidator->errors()->all());
                            } else {
                                $insert[] = $rowData;
                            }
                        }
                    }
                } else {
                     return response()->json([
                        'status' => false,
                        'message' => 'The uploaded file is empty or has only a header row.'
                    ]);
                }

                if (!empty($errors)) {
                     return response()->json([
                        'status' => false,
                        'message' => 'Errors found in file data: ' . implode('; ', $errors)
                    ]);
                }

                if (count($insert) > 0) {
                    try {
                        // LevelModel::insertOrIgnore($insert); // Might be too simple if complex validation needed

                        // More robust: Check existence or use upsert
                        $insertedCount = 0;
                        foreach ($insert as $levelData) {
                            $exists = LevelModel::where('code_level', $levelData['code_level'])->exists();
                            if (!$exists) {
                                LevelModel::create($levelData);
                                $insertedCount++;
                            }
                            // Optionally: Update existing records if needed (upsert logic)
                        }

                        if ($insertedCount > 0) {
                            return response()->json([
                                'status' => true,
                                'message' => $insertedCount . ' level(s) imported successfully out of ' . $rowCount . ' rows processed.'
                            ]);
                        } else {
                             return response()->json([
                                'status' => false,
                                'message' => 'No new levels were imported. Duplicates might exist or file was empty after header.'
                            ]);
                        }

                    } catch (\Illuminate\Database\QueryException $e) {
                         return response()->json([
                            'status' => false,
                            'message' => 'Database error during import: ' . $e->getMessage()
                        ]);
                    }

                } else {
                     return response()->json([
                        'status' => false,
                        'message' => 'No valid data found to import after the header row.'
                    ]);
                }

            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                 return response()->json([
                    'status' => false,
                    'message' => 'Failed to read the file: ' . $e->getMessage(),
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Import failed: ' . $e->getMessage(),
                ]);
            }
        }
        return redirect('/level');
    }


    public function destroy(LevelModel $level)
    {
        $level->delete();
        return redirect('/level')->with('success', 'Level data has been deleted successfully');
    }
}
