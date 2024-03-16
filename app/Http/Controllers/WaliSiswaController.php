<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;



class WaliSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'wali_id' => 'required|exists:users,id',
            'siswa_id' => 'required'
        ]);

        $siswa = \App\Models\Siswa::find($request->siswa_id);
        $siswa->wali_id = $request->wali_id;
        $siswa->wali_status = 'ok';
        $siswa->save();
        flash('Data sudah ditambahkan')->success();
        return back();
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
        
        $siswa = \App\Models\Siswa::findorFail($id);
        $siswa->wali_id = null;
        $siswa->wali_status = null;
        $siswa->save();
        flash('Data berhasil dihapus')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
