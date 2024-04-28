<?php

namespace App\Http\Controllers;
use \App\Http\Requests\StoreSiswaRequest;
use \App\Http\Requests\UpdateSiswaRequest;
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
    public function index(Request $request)
    {
        
        if ($request->filled('q')) {
            $models = Model::search($request->q)->paginate(50);
        }else{
            $models = Model::with('wali','user')->Latest()->paginate(50);
        }
        return view('operator.' . $this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Siswa'
            
        
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
    public function store(StoreSiswaRequest $request)
{
    $requestData = $request->validated();

    if ($request->hasFile('foto')) {
        $requestData['foto'] = $request->file('foto')->store('public/fotos');
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
        return view('operator.' . $this->viewShow, [

            'model' => Model::findorFail($id),
            'title' => 'DETAIL SISWA'

        ]);
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
    public function update(UpdateSiswaRequest $request, string $id)
    {
    $requestData = $request->validated();
    
    $model = Model::findOrFail($id);

    // Periksa apakah request memiliki file foto
    if ($request->hasFile('foto')) {
        // Jika foto sebelumnya ada, hapus
        if ($model->foto && Storage::exists($model->foto)) {
            Storage::delete($model->foto);
        }

        // Simpan foto yang baru
        $requestData['foto'] = $request->file('foto')->store('public/fotos');
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

        $model = Model::findorFail($id);
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
