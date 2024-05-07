@extends('layouts.app_sneat_wali')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">DATA SISWA</h5>
            <div class="card-body">
                <div class="row">
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th width="1%">No</th>
                                <th>Nama Wali</th>
                                <th>Nama</th>
                                <th>NISN</th>
                                <th>Jurusan</th>
                                <th>Kelas</th>
                                <th>Angkatan</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($models as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->wali->name }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->jurusan }}</td>
                                <td>{{ $item->kelas }}</td>
                                <td>{{ $item->angkatan }}</td>
                            </tr>

                            @empty

                            <tr>
                                <td colspan="4">Data Tidak Ada !</td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
