<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User as Model;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Model::where('akses','<>', 'wali')->latest()->paginate(50);
        $data['models'] = $models;
        return view('operator.user_index', $data);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'model'     => new \App\Models\User(),
            'method'    => 'POST',
            'route'     => 'user.store',
            'button'    => 'SIMPAN'
        ];
        return view('operator.user_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $requestData = $request->validate([
        'name' => 'required|regex:/^[a-zA-Z\s]*$/',
        'email' => 'required|email|unique:users',
        'nohp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users',
        'akses' => 'required|in:operator,admin',
        'password'=> 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
    ], [
        'name.regex' => 'Format nama tidak valid. Nama hanya boleh berisi huruf dan spasi.',
        'nohp.regex' => 'Format nomor telepon tidak valid.',
        'password.regex' => 'Kata sandi harus terdiri dari setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus (@$!%*?&).',
        'password.min' => 'Kata sandi harus terdiri dari setidaknya 8 karakter.'
    ]);

    $requestData['password'] = bcrypt($requestData['password']);
    Model::create($requestData);
    flash('Data Berhasil di Simpan!');
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
        $data = [
            'model'     => \App\Models\User::findOrFail($id),
            'method'    => 'PUT',
            'route'     => ['user.update', $id],
            'button'    => 'UPDATE'
        ];
        return view('operator.user_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestData = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:users,email,' . $id,
            'nohp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,nohp,' . $id,
            'akses' => 'required|in:operator,admin',
            'password' => 'nullable|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
        ], [
            'name.regex' => 'Format nama tidak valid. Nama hanya boleh berisi huruf dan spasi.',
            'nohp.regex' => 'Format nomor telepon tidak valid.',
            'password.regex' => 'Kata sandi harus terdiri dari setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus (@$!%*?&).',
            'password.min' => 'Kata sandi harus terdiri dari setidaknya 8 karakter.'
        ]);
        
        $model = Model::findOrFail($id);
        
        // Jika password kosong, unset dari array $requestData
        if ($requestData['password'] === null) {
            unset($requestData['password']);
        } else {
            // Jika password tidak kosong, hash password
            $requestData['password'] = bcrypt($requestData['password']);
        }
        
        $model->fill($requestData);
        $model->save();
        
        flash('Data Berhasil di Ubah!');
        return redirect()->route('user.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
