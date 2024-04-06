<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePembayaranRekeningRequest;
use App\Http\Requests\UpdatePembayaranRekeningRequest;
use App\Models\PembayaranRekening as Model;

class PembayaranRekeningController extends Controller
{
    private $viewIndex = 'rekening_index';
    private $viewCreate = 'rekening_form';
    private $viewEdit = 'rekening_form';
    private $viewShow = 'rekening_show';
    private $routePrefix = 'rekening';

    public function index(Request $request)
    {
        if ($request->filled('q')) {
            $models = Model::search($request->q)->paginate(50);
        } else {
            $models = Model::with('user')->latest()->paginate(50);
        }
        return view('operator.' . $this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Rekening'
        ]);
    }

    public function create()
    {
        $data = [
            'model'     => new Model(),
            'method'    => 'POST',
            'route'     => $this->routePrefix . 'store',
            'button'    => 'SIMPAN',
            'title' => 'Form Data Rekening',
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    public function store(StorePembayaranRekeningRequest $request)
    {
        Model::create($request->validated());
        flash('Data Berhasil di Simpan!');
        return redirect()->route($this->routePrefix . '.index');
    }

    public function show(string $id)
    {
        return view('operator.' . $this->viewShow, [
            'model' => Model::findOrFail($id),
            'title' => 'Detail Siswa'
        ]);
    }

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

    public function update(UpdatePembayaranRekeningRequest $request, string $id)
    {
        $model = Model::findOrFail($id);
        $model->fill($request->validated());
        $model->save();
        
        flash('Data Berhasil di Ubah!');
        return redirect()->route($this->routePrefix . '.index');
    }

    public function destroy(string $id)
    {
        $model = Model::findorFail($id);
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
