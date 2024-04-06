@extends('layouts.app_sneat')

@section('content')

<div class="row justify-content-center mt-4">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header text-center bg-primary text-white">DATA TAGIHAN SPP SISWA {{ strtoupper($priode) }}</h5>
            <div class="card-body mt-3">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="{{ \Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}" width="150">
                    </div>
                    <div class="col-md-9">
                        <table class="table table-borderless">
                            <tr>
                                <th width="100">NIS</th>
                                <td>: {{ $siswa->nisn }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>: {{ $siswa->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jurusan</th>
                                <td>: {{ $siswa->jurusan }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>: {{ $siswa->kelas }}</td>
                            </tr>
                            <tr>
                                <th>Angkatan</th>
                                <td>: {{ $siswa->angkatan }}</td>
                            </tr>
                            <tr>
                                <th>Kartu</th>
                                <td>: <a href="{{ route('kartuspp.index',[
                                    'siswa_id' => $siswa->id,
                                    'tahun' => request('tahun'),
                                ]) }}" class="btn btn-primary" target="blank"><i class="fa fa-file"></i> Kartu Tagihan {{ request('tahun') }}</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header bg-success text-white">DATA TAGIHAN {{ strtoupper($priode) }}</h5>
            <div class="card-body mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th>Nama Tagihan</th>
                            <th>Jumlah Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tagihan->tagihanDetails as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_biaya }}</td>
                            <td>{{ formatRupiah($item->jumlah_biaya) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Total Pembayaran</td>
                            <td>{{ formatRupiah($tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@php
    $totalTagihan = $tagihan->tagihanDetails->sum('jumlah_biaya');
    $totalPembayaran = 0; // Mulai dengan total pembayaran 0
@endphp
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header bg-primary text-white">DATA PEMBAYARAN</h5>
            <div class="card-body">
                <table class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th width="1%">NO</th>
                            <th>TANGGAL</th>
                            <th>JUMLAH DIBAYAR</th>
                            <th>METODE</th>
                            <th>SISA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tagihan->pembayaran as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d F Y') }}</td>
                                <td>{{ formatRupiah($item->jumlah_dibayar) }}</td>
                                <td>{{ $item->metode_pembayaran }}</td>
                                <td>
                                    @php
                                        $totalPembayaran += $item->jumlah_dibayar; // Menambahkan jumlah pembayaran saat ini ke total pembayaran
                                        $sisaTagihan = $totalTagihan - $totalPembayaran; // Menghitung sisa tagihan aktual
                                        $sisaTagihan = max(0, $sisaTagihan); // Pastikan sisa tagihan tidak kurang dari 0
                                    @endphp
                                    {{ formatRupiah($sisaTagihan) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h5 class="font-weight-bold mt-3">Status Pembayaran :
                    @if ($tagihan->status == 'lunas')
                        <span class="text-success">{{ strtoupper($tagihan->status) }}</span>
                    @elseif ($tagihan->status == 'angsur')
                        <span class="text-warning">{{ strtoupper($tagihan->status) }}</span>
                    @else
                        <span class="text-danger">{{ strtoupper($tagihan->status) }}</span>
                    @endif
                </h5>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header bg-info text-white">FORM PEMBAYARAN</h5>
            <div class="card-body">
                {!! Form::model($model, ['route' => 'pembayaran.store','method' => 'POST']) !!}
                {!! Form::hidden('tagihan_id', $tagihan->id, []) !!}
                <div class="form-group mt-3">
                    <label for="tanggal_bayar">Tanggal Pembayaran</label>
                    {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                    <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="jumlah_dibayar">Jumlah Yang Dibayarkan</label>
                    {!! Form::text('jumlah_dibayar', null, ['class' => 'form-control rupiah']) !!}
                    <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                </div>
                {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary mt-3']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
