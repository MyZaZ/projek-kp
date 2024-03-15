<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \App\Models\Siswa as Model;
use App\Models\User;


class SiswaController extends Controller
{
    private $viewIndex = 'siswa_index';
    private $viewCreate = 'siswa_form';
    private $viewEdit = 'siswa_form';
    private $viewShow = 'siswa_show';
    private $routePrefix = 'siswa';
    /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index()
    {
        return view('operator.' . $this->viewIndex, [
        'models' => Model::latest()
            ->latest()
            ->paginate(50),
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Siswa',
            
        
        ]);
        
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'model'     => new Model(),
            'method'    => 'POST',
            'route'     => $this->routePrefix . 'store',
            'button'    => 'SIMPAN',
            'title' => 'Form Data Siswa',
            'wali' => User::where('akses','wali')->pluck('name','id')
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $requestData = $request->validate([
        'wali_id' => 'nullable',
        'nama' => 'required|regex:/^[a-zA-Z\s]*$/',
        'nisn' => 'required|unique:siswas',
        'jurusan' => 'required',
        'kelas' => 'required',
        'angkatan' => 'required',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
    ], [
        'name.regex' => 'Format nama tidak valid. Nama hanya boleh berisi huruf dan spasi.'
    ]);
    if ($request->hasFile('foto')) {
        $requestData['foto'] = $request->file('foto')->store('public');
    }
    if ($request->filled('wali_id')) {
        $requestData['wali_status'] = 'ok';
    }
    $requestData['user_id'] = auth()->user()->id;
    Model::create($requestData);
    flash('Data Berhasil di Simpan!');
    return redirect()->route($this->routePrefix . '.index');
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
        $data = [
            'model'     => Model::findOrFail($id),
            'method'    => 'PUT',
            'route'     => [ $this->routePrefix . '.update', $id],
            'button'    => 'UPDATE',
            'title'     => 'Edit Data Siswa',
            'wali' => User::where('akses','wali')->pluck('name','id')
        ];
        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestData = $request->validate([
        'wali_id' => 'nullable',
        'nama' => 'required|regex:/^[a-zA-Z\s]*$/',
        'nisn' => 'required|unique:siswas,nisn,' . $id,
        'jurusan' => 'required',
        'kelas' => 'required',
        'angkatan' => 'required',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
        ], [
            'name.regex' => 'Format nama tidak valid. Nama hanya boleh berisi huruf dan spasi.',
        ]);
        
        $model = Model::findOrFail($id);

        if ($request->hasFile('foto')) {
            Storage::delete($model -> foto);
            $requestData['foto'] = $request->file('foto')->store('public');
        }
        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'ok';
        }

        $requestData['user_id'] = auth()->user()->id;
        $model->fill($requestData);
        $model->save();
        
        flash('Data Berhasil di Ubah!');
        return redirect()->route($this->routePrefix . '.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $model = Model::firstOrFail();
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
