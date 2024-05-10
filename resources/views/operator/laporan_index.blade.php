@extends('layouts.app_sneat')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h4 class="card-header">Form Laporan</h4>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Laporan Tagihan</h5>
                        {!! Form::open(['route' => 'laporantagihan.index','method' => 'GET','target' => 'blank']) !!}
                            <div class="row gx-2 align-items-end">
                                <div class="col-md-2 col-sm-12">
                                    <label for="angkatan">Angkatan</label>
                                    {!! Form::selectRange('angkatan', 2021, date('Y') + 1, null, ['class' => 'form-control', 'placeholder' => 'Pilih Angkatan']) !!}
                                    <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                                </div>
                                  <div class="col-md-2 col-sm-12">
                                    <label for="jurusan">Jurusan</label>
                                    {!! Form::select('jurusan', [
                                        'RPL' => 'Rekayasa Perangkat Lunak',
                                        'TKJ' => 'Teknik Komputer dan Jaringan',
                                    ], null, ['class' => 'form-control','placeholder' => 'Pilih Jurusan']) !!}
                                    <span class="text-danger">{{ $errors->first('jurusan') }}</span>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="status">Status Tagihan</label>
                                    {!! Form::select(
                                        'status',
                                        [
                                            '' => 'Pilih Status',
                                            'lunas' => 'Lunas',
                                            'baru' => 'Baru',
                                            'angsur' => 'Angsur',
                                        ],
                                        request('status'),
                                        ['class' => 'form-control'],
                                    ) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="bulan">Bulan</label>
                                    {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control','placeholder' => 'Pilih Bulan']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="tahun">Tahun</label>
                                    {!! Form::selectRange('tahun', 2024, date('Y')+1, request('tahun'), ['class' => 'form-control','placeholder' => 'Pilih Tahun']) !!}
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Tampil</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>Laporan Pembayaran</h5>
                        {!! Form::open(['url' => '','method' => 'GET']) !!}
                            <div class="row gx-2 align-items-end">
                                <div class="col-md-2 col-sm-12">
                                    <label for="status_konfirmasi">Status Pembayaran</label>
                                    {!! Form::select(
                                        'status_konfirmasi',
                                        [
                                            '' => 'Pilih Status',
                                            'sudah_dikonfirmasi' => 'Sudah Dikonfirmasi',
                                            'belum_dikonfirmasi' => 'Belum Dikonfirmasi',
                                        ],
                                        request('status_konfirmasi'),
                                        ['class' => 'form-control'],
                                    ) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="bulan">Bulan</label>
                                    {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control','placeholder' => 'Pilih Bulan']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="tahun">Tahun</label>
                                    {!! Form::selectRange('tahun', 2024, date('Y')+1, request('tahun'), ['class' => 'form-control','placeholder' => 'Pilih Tahun']) !!}
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Tampil</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
