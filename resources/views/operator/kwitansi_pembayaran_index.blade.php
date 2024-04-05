@extends('layouts.app_sneat_blank')
@section('content')
<script type="text/javascript">
    window.print();
</script>
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
                                <p class="font-weight-bold mb-1">Kwitansi #{{$pembayaran->id}}</p>
                                <p class="text-muted">Tanggal: {{ date('d F Y') }}</p>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="row pb-5 px-5">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                         <tr>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Jumlah Yang Dibayarkan</th>
                                            <th>Metode Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d F Y') }}</td>
                                            <td>{{ formatRupiah($pembayaran->jumlah_dibayar) }}</td>
                                            <td>{{ $pembayaran->metode_pembayaran }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex flex-row-reverse bg-dark text-white p-4">
                            <div class="py-3 px-5 text-right">
                                <div class="mb-2">Total</div>
                                <div class="h2 font-weight-light">{{ formatRupiah($total_pembayaran) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
