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
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Tanggal Tagihan</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->siswa->nisn }}</td>
                                    <td>{{ $item->siswa->nama }}</td>
                                    <td>{{ $item->tanggal_tagihan->format('d-M-Y')}}</td>
                                    <td>
                                        @php
                                            $buttonClass = '';
                                            switch ($item->status) {
                                                case 'lunas':
                                                    $buttonClass = 'badge bg-label-success me-1';
                                                    break;
                                                case 'angsur':
                                                    $buttonClass = 'badge bg-label-warning me-1';
                                                    break;
                                                case 'baru':
                                                    $buttonClass = 'badge bg-label-danger me-1';
                                                    break;
                                                default:
                                                    $buttonClass = 'btn-secondary'; // Or any other color you want for default case
                                            }
                                        @endphp
                                        <button class="btn {{ $buttonClass }} btn-sm">{{ $item->status }}</button>
                                    </td>
                                    <td>{{ formatRupiah($item->tagihanDetails->sum('jumlah_biaya'))}}</td>
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
</div>

@endsection
