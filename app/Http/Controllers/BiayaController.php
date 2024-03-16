<?php

namespace App\Http\Controllers;
use \App\Http\Requests\StoreBiayaRequest;
use \App\Http\Requests\UpdateBiayaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \App\Models\Biaya as Model;
use App\Models\User;


class BiayaController extends Controller
{
    private $viewIndex = 'biaya_index';
    private $viewCreate = 'biaya_form';
    private $viewEdit = 'biaya_form';
    private $viewShow = 'biaya_show';
    private $routePrefix = 'biaya';
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
            $models = Model::with('user')->Latest()->paginate(50);
        }
        return view('operator.' . $this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Biaya'
            
        
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
            'title' => 'Form Data Biaya',
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBiayaRequest $request)
{
 
    Model::create($request->validated());
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
            'title' => 'Detail Siswa'

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
            'title'     => 'Edit Data Biaya',
        ];
        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBiayaRequest $request, string $id)
    {
        $model = Model::findOrFail($id);
        $model->fill($request->validated());
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
