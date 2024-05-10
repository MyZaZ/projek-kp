@extends('layouts.app_sneat')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">DATA PEMBAYARAN</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        {!! Form::open(['route' => 'pembayaran.index','method' => 'GET', 'class' => 'form-inline float-right']) !!}
                            <div class="row gx-2">
                            <div class="col-md-2 col-sm-12">
                            {!! Form::select(
                                'status_konfirmasi',
                                [
                                    '' => 'Pilih Satatus',
                                    'sudah_dikonfirmasi' => 'Sudah Dikonfirmasi',
                                    'belum_dikonfirmasi' => 'Belum Dikonfirmasi',
                                ],
                                request('status_konfirmasi'),
                             ['class' => 'form-control'],
                             ) !!}
                             </div>
                            <div class="col-md-2 col-sm-12">
                                {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control','placeholder' => 'Pilih Bulan']) !!}
                            </div>
                            <div class="col-md-2 col-sm-12">
                                {!! Form::selectRange('tahun', 2024, date('Y')+1, request('tahun'), ['class' => 'form-control','placeholder' => 'Pilih Tahun']) !!}
                            </div>
                            <div class="col">
                            <button type="submit"  class="btn btn-primary">Tampil</button>
                            </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th width="1%">No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Nama Wali</th>
                                <th>Metode Pembayaran</th>
                                <th>Status Konfirmasi</th>
                                <th>Tanggal Konfirmasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($models as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tagihan->siswa->nisn }}</td>
                                <td>{{ $item->tagihan->siswa->nama }}</td>
                                <td>{{ $item->wali->name}}</td>
                                <td>{{ $item->metode_pembayaran}}</td>
                                <td>
                                    @php
                                        $buttonClass = '';
                                        switch ($item->status_konfirmasi) {
                                            case 'Belum Dikonfirmasi':
                                                $buttonClass = 'badge bg-label-danger me-1';
                                                break;
                                            case 'Sudah Dikonfirmasi':
                                                $buttonClass = 'badge bg-label-success me-1';
                                                break;
                                            default:
                                                $buttonClass = 'btn-secondary'; // Or any other color you want for default case
                                        }
                                    @endphp
                                    <button class="btn {{ $buttonClass }} btn-sm">{{ $item->status_konfirmasi }}</button>
                                </td>
                                <td>
                                    @if ($item->tanggal_konfirmasi)
                                        {{ \Carbon\Carbon::parse($item->tanggal_konfirmasi)->translatedFormat('d F Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {!! Form::open([
                                    'route' => ['pembayaran.destroy', $item->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")',

                                    ]) !!}
                                    <a href="{{route('pembayaran.show',$item->id) }}"
                                        class="btn btn-info btn-sm mx-3">
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
