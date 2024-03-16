@extends('layouts.app_sneat')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{$title}}</h5>
                <div class="card-body">
                     <div class="table-responsive">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ \Storage::url($model->foto ?? 'images/no-image.png')}}" width="200" class="mx-auto d-block" />
                            </div>
                            <div class="col-md-9">
                                <table class="table table-striped table-sm">
                                    <tbody>
                                        <tr>
                                            <td width="15%">ID</td>
                                            <td>{{ $model->id }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>{{ $model->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>No.Hp</td>
                                            <td>{{ $model->nohp }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $model->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tgl Buat</td>
                                            <td>{{ $model->created_at->format('d/m/y H:i')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Tgl Diubah</td>
                                            <td>{{ $model->updated_at->format('d/m/y H:i')}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h4 class="my-3">DATA ANAK</h4>
                                <table class="table table-light">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nisn</th>
                                            <th>Nama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($model->siswa as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nisn }}</td>
                                                <td>{{ $item->nama }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
