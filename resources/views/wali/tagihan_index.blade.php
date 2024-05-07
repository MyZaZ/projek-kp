@extends('layouts.app_sneat_wali')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">DATA TAGIHAN</h5>
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th width="1%">No</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Kelas</th>
                                <th>Tanggal Tagihan</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                           @forelse ($tagihan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->siswa->jurusan }}</td>
                                <td>{{ $item->siswa->kelas }}</td>
                                <td>{{ $item->tanggal_tagihan->format('d F Y') }}</td>
                               <td>
                                    @php
                                        $status = $item->getStatusTagihanWali();
                                    @endphp
                                    <span class="badge {{ $status['buttonClass'] }}">{{ $status['statusText'] }}</span>
                                </td>

                                <td>
                                    @if ($item->status == 'baru')
                                        <a href="{{ route('wali.tagihan.show', $item->id) }}" class="btn btn-danger">Lakukan Pembayaran</a>
                                    @elseif ($item->status == 'angsur')
                                        <a href="{{ route('wali.tagihan.show', $item->id) }}" class="btn btn-warning">Bayar Angsuran</a>
                                    @else
                                        <a href="" class="btn btn-success">Pembayaran Sudah Lunas</a>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">Data Tidak Ada !</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
