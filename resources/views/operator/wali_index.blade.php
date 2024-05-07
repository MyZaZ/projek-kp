@extends('layouts.app_sneat')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{$title}}</h5>
                <div class="card-body">
                <a href="{{ route($routePrefix .'.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Tambah Data</a>
               <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <th width="1%">No</th>
                            <th>Nama</th>
                            <th>No.HP</th>
                            <th>Email</th>
                            <th>Akses</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbodY>

                        @forelse ($models as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->nohp }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->akses }}</td>
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
