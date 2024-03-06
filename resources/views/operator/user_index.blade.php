@extends('layouts.app_sneat')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Data User</h5>

                <div class="card-body">
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
                                <th>{{ $loop->iteration }}</th>
                                <th>{{ $item->name }}</th>
                                <th>{{ $item->nohp }}</th>
                                <th>{{ $item->email }}</th>
                                <th>{{ $item->akses }}</th>
                            </tr>
                            
                        @empty

                            <tr>
                                <td colspan="4">Data Tidak Ada !</td>
                            </tr>
                            
                        @endforelse
                    
                    </tbody>
                </table>
                {!! $Models->links()!!}
                </div>
                </div>
            </div>
        </div>
    </div>

@endsection
