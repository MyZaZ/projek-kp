@extends('layouts.app_sneat')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <h5 class="card-header text-center bg-primary text-white">{{$title}}</h5>
            <div class="card-body mt-3">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="{{ \Storage::url($model->foto ?? 'images/no-image.png')}}" width="150" class="mx-auto d-block" />
                    </div>
                    <div class="col-md-8">
                        <table class="table table-striped table-sm">
                            <tbody>
                                <tr>
                                    <td width="23%">ID</td>
                                    <td>: {{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{ $model->nama }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>: {{ $model->nisn }}</td>
                                </tr>
                                <tr>
                                    <td>Jurusan</td>
                                    <td>: {{ $model->jurusan }}</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>: {{ $model->kelas }}</td>
                                </tr>
                                <tr>
                                    <td>Angkatan</td>
                                    <td>: {{ $model->angkatan }}</td>
                                </tr>
                                <tr>
                                    <td>Wali Murid</td>
                                    <td>: {{ $model->wali->name }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl Buat</td>
                                    <td>: {{ $model->created_at->format('d/m/y H:i')}}</td>
                                </tr>
                                <tr>
                                    <td>Tgl Diubah</td>
                                    <td>: {{ $model->updated_at->format('d/m/y H:i')}}</td>
                                </tr>
                                <tr>
                                    <td>Dibuat oleh</td>
                                    <td>: {{ $model->user->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
