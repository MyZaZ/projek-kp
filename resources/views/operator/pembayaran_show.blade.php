@extends('layouts.app_sneat')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">DATA PEMBAYARAN</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI TAGIHAN</td>
                            </tr>
                            <tr>
                                <td width="12%">No</td>
                                <td>: {{ $model->id }}</td>
                            </tr>
                            <tr>
                                <td>ID Tagihan</td>
                                <td>: {{ $model->tagihan_id }}</td>
                            </tr>
                            <tr>
                                <td>Item Tagihan</td>
                                <td> 
                                    <table class="table table-sm">
                                        <thead>
                                        <th>No</th>
                                        <th>Nama Biaya</th>
                                        <th>Jumlah</th>
                                        </thead>
                                        <tbody>
                                    @foreach ($model->tagihan->tagihanDetails as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->nama_biaya}}</td>
                                            <td>{{formatRupiah($item->jumlah_biaya)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>Total Tagihan</td>
                                <td>: {{ formatRupiah($model->tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                            </tr>
                             <tr>
                                <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI SISWA</td>
                            </tr>
                            <tr>
                                <td>Nama Siswa</td>
                                <td>: {{ $model->tagihan->siswa->nama }}</td>
                            </tr>
                            <tr>
                                <td>Nama Wali</td>
                                <td>: {{ $model->wali->name }}</td>
                            </tr>
                            @if ($model->metode_pembayaran != "manual")
                            <tr>
                                <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI BANK PENGIRIM</td>
                            </tr>
                            <tr>
                                <td>Bank Pengirim</td>
                                <td>: {{ $model->waliBank->nama_bank }}</td>
                            </tr>
                             <tr>
                                <td>Nomor Rekening</td>
                                <td>: {{ $model->waliBank->nomor_rekening }}</td>
                            </tr>
                            <tr>
                                <td>Atas Nama</td>
                                <td>: {{ $model->waliBank->nama_rekening }}</td>
                            </tr>
                             </tr>
                              <tr>
                                <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI BANK TUJUAN TRANSFER</td>
                            </tr>
                             <tr>
                                <td>Bank Tujuan Transfer</td>
                                <td>: {{ $model->PembayaranRekening->nama_bank }}</td>
                            </tr>
                             <tr>
                                <td>Nomor Rekening</td>
                                <td>: {{ $model->PembayaranRekening->nomor_rekening }}</td>
                            </tr>
                            <tr>
                                <td>Atas Nama</td>
                                <td>: {{ $model->PembayaranRekening->atas_nama }}</td>
                            </tr>
                              <tr>
                                <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI PEMBAYARAN</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Metode Pembayaran</td>
                                <td>: {{ $model->metode_pembayaran }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembayaran</td>
                                <td>: {{ \Carbon\Carbon::parse($model->tanggal_bayar)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Total Tagihan </td>
                                <td>: {{ formatRupiah($model->tagihan->tagihanDetails->sum('jumlah_biaya'))}}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Yang Dibayar</td>
                                <td>: {{ formatRupiah($model->jumlah_dibayar) }}</td>
                            </tr>
                            <tr>
                                <td>Sisa Total Tagihan</td>
                               <td>:
                                        @php
                                            $totalPembayaran = 0; // Inisialisasi variabel total pembayaran
                                            $totalTagihan = $model->tagihan->tagihanDetails->sum('jumlah_biaya'); // Menghitung total tagihan

                                            // Menghitung total pembayaran
                                            foreach ($model->tagihan->pembayaran as $pembayaran) {
                                                $totalPembayaran += $pembayaran->jumlah_dibayar;
                                            }

                                            $sisaTagihan = max(0, $totalTagihan - $totalPembayaran); // Menghitung sisa tagihan aktual
                                        @endphp
                                        {{ formatRupiah($sisaTagihan) }}
                                </td>
                            </tr>
                            @if ($model->metode_pembayaran != "manual")
                            <tr>
                                <td>Bukti Pembayaran</td>
                                <td>: 
                                    <a href="javascript:void[0]" onclick="popupCenter({url: '{{\Storage::url($model->bukti_bayar)}}', title: 'xtf', w: 900, h: 500}); " >Lihat Bukti Bayar</a>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td>Status Konfirmasi</td>
                                <td>: 
                                    @php
                                        $buttonClass = '';
                                        switch ($model->status_konfirmasi) {
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
                                    <button class="btn {{ $buttonClass }} btn-sm">{{ $model->status_konfirmasi }}</button>
                                </td>
                            </tr>
                             <tr>
                                <td>Status Pembayaran</td>
                                <td>:
                                    @php
                                        $status = $model->tagihan->getStatusTagihanWali();
                                    @endphp
                                    <span class="badge {{ $status['buttonClass'] }}">{{ $status['statusText'] }}</span>
                                </td>
                            </tr>
                             <tr>
                                <td>Tanggal Konfirmasi</td>
                                <td>: {{ \Carbon\Carbon::parse($model->tanggal_konfirmasi)->translatedFormat('d F Y H:i') }}</td>
                            </tr>
                        </thead>
                    </table>
                    @if ($model->tanggal_konfirmasi == null)
    {!! Form::open([
        'route' => $route, 
        'method' => 'PUT',
        'onsubmit' => 'return confirm("Apakah anda yakin??")',
    ]) !!}
    {!! Form::hidden('pembayaran_id', $model->id, []) !!}
    {!! Form::submit('Konfirmasi Pembayaran', ['class' => 'btn btn-primary mt-3']) !!}
    {!! Form::close() !!}
@else
    @if ($model->tagihan->status == 'lunas')
        <div class="alert alert-primary mt-3" role="alert">
            <h2>TAGIHAN INI SUDAH LUNAS</h2>
        </div>
    @elseif ($model->tagihan->status == 'angsur')
        <div class="alert alert-warning mt-3" role="alert">
            <h2>Pembayaran masih dalam tahap angsuran</h2>
        </div>
    @else
        <!-- Tambahkan logika atau pesan sesuai kebutuhan jika status tidak valid -->
    @endif
@endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
