@extends('layouts.app_sneat')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">DATA TAGIHAN SPP SISWA {{ strtoupper($priode) }}</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{ \Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}" width="150">
                    </div>
                    <div class="col-md-10">
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

<div class="row mt-2">
    <div class="col-md-5">
        <div class="card">
            <h5 class="card-header">DATA TAGIHAN</h5>
            <div class="card-body">
                <p>Data Tagihan {{ $priode }}</p>
                <table class="table">
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
                </table>
            </div>
            <h5 class="card-header">DATA PEMBAYARAN</h5>              
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <h5 class="card-header">KARTU SPP</h5>
            <div class="card-body">
                <p>Kartu Spp</p>
                <!-- Isi konten kartu SPP sesuai kebutuhan -->
            </div>
        </div>
    </div>
</div>

@endsection
