@extends('layouts.app_sneat_blank')
@section('content')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row p-5">
                            <div class="col-md-6">
                                <img src="{{ asset('sneat')}}/assets/img/favicon/logo.png">
                                <p class="font-weight-bold mt-3">SMK Pasundan 2 Cianjur</p>
                                <p>Jl. Pasundan No. 123, Cianjur</p>
                            </div>

                            <div class="col-md-6 text-right">
                                <p class="text-muted">Nama Siswa: {{ $siswa->nama }}</p>
                                <p class="text-muted">Tanggal: {{ date('d F Y') }}</p>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="row pb-5 px-5">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                         <tr>
                                            <th>No</th>
                                            <th>Bulan Tagihan</th>
                                            <th>Nama Biaya</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Paraf</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $tagihan as $item )                                            
                                        <tr>
                                           <td>{{$loop->iteration}}</td>
                                           <td>{{$item->tanggal_tagihan->translatedFormat('F Y')}}</td>
                                           <td>
                                                <ul>
                                                @foreach ($item->tagihanDetails as $itemDetails )
                                                    <li>
                                                        {{$itemDetails->nama_biaya}}
                                                    </li>
                                                @endforeach
                                                </ul>
                                           </td>
                                           <td>
                                                <ul>
                                                @foreach ($item->tagihanDetails as $itemDetails )
                                                    <li>
                                                        {{formatRupiah($itemDetails->jumlah_biaya)}}
                                                    </li>
                                                @endforeach
                                                </ul>
                                           </td>
                                           <td>{{formatRupiah($item->tagihanDetails->sum('jumlah_biaya'))}}</td>
                                           <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row mt-5">
                                    <div class="col-md-6">
                                        <p class="font-weight-bold kepala-sekolah">Mengetahui Kepala Sekolah</p>
                                    </div>
                                    <div class="row mt-5">
                                    <div class="col-md-6">
                                        <p class="kepala-sekolah2">(................................)</p>
                                        <!-- Tambahkan tanda tangan kepala sekolah di sini -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
