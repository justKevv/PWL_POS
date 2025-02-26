<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // DB::insert('insert into m_level (code_level, name_level, created_at) values (?, ?, ?)', ['CUS', 'Customer', now()]);
        // return 'Insert data baru berhasil!';

        // $row = DB::update('update m_level set name_level = ? where code_level = ?', ['Pelanggan', 'CUS']);
        // return 'Update data berhasil. Jumlah data yang diubah: ' . $row. ' baris' ;

        // $row = DB::delete("delete from m_level where code_level = ?", ['CUS']);
        // return 'Delete data berhasil. Jumlah data yang dihapus: '. $row.' baris';

        $data = DB::select('select * from m_level');
        return view('level', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
