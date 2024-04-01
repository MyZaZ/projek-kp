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
                            <!-- Tambahkan baris tambahan sesuai dengan data siswa yang ingin ditampilkan -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-5">
        <div class="card">
            <h5 class="card-header bg-success text-white">DATA TAGIHAN {{ strtoupper($priode) }}</h5>
            <div class="card-body mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
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
                <h5 class="font-weight-bold mt-3">Status Pembayaran : 
                    @if($tagihan->status == 'lunas')
                        <span class="text-success">{{ strtoupper($tagihan->status) }}</span>
                    @elseif($tagihan->status == 'belum lunas')
                        <span class="text-danger">{{ strtoupper($tagihan->status) }}</span>
                    @else
                        <span class="text-warning">{{ strtoupper($tagihan->status) }}</span>
                    @endif
                </h5>
            </div>
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
    <div class="col-md-7">
        <div class="card">
            <h5 class="card-header bg-warning text-white">KARTU SPP</h5>
            <div class="card-body">
                <p class="font-weight-bold">Kartu Spp</p>
                <!-- Isi konten kartu SPP sesuai kebutuhan -->
            </div>
        </div>
    </div>
</div>

@endsection
