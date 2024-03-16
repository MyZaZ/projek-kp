@extends('layouts.app_sneat')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">{{$title}}</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <a href="{{ route($routePrefix .'.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data</a>
                    </div>
                    <div class="col">
                        {!! Form::open(['route' => $routePrefix . '.index','method' => 'GET', 'class' => 'form-inline float-right']) !!}
                            <div class="input-group">
                                <input name="q" type="text" class="form-control" placeholder="Cari Data" aria-label="cari data" value="{{ request('q') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Biaya</th>
                                <th>Jumlah</th>
                                <th>Created By</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($models as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ formatRupiah($item->jumlah) }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>

                                    {!! Form::open([
                                    'route' => [$routePrefix .'.destroy', $item->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")',

                                    ]) !!}
                                    <a href="{{route($routePrefix .'.edit',$item->id)}}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>Edit
                                    </a>
                                    <a href="{{route($routePrefix .'.show',$item->id)}}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>Detail
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>

                            @empty

                            <tr>
                                <td colspan="4">Data Tidak Ada !</td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                    {!! $models->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
