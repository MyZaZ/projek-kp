@extends('layouts.app_sneat')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Data User</h5>
                <div class="card-body">
                <a href="{{route('user.create')}}" class="btn btn-primary btn-sm">Tambah Data</a>
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No.HP</th>
                            <th>Email</th>
                            <th>Akses</th>
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
                                    <a href="{{route('user.edit',$item->id)}}">Edit</a>
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
