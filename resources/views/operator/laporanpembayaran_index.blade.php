@extends('layouts.app_sneat_blank')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="bg-white"> <!-- Tambahkan kelas bg-white di sini -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="2%">NISN</th>
                                    <th>Nama</th>
                                    <th>Nama Wali</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pembayaran as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tagihan->siswa->nisn }}</td>
                                    <td>{{ $item->tagihan->siswa->nama }}</td>
                                    <td>{{ $item->wali->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d F Y') }}</td>
                                    <td>{{ formatRupiah($item->jumlah_dibayar) }}</td>
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
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">Data Tidak Ada !</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" align="right"><strong>Total Pembayaran</strong></td>
                                <td><strong>{{ formatRupiah($pembayaran->sum('jumlah_dibayar')) }}</strong></td>
                                <td></td> <!-- Kolom kosong untuk menjaga konsistensi dengan jumlah kolom lain -->
                            </tr>
                        </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
