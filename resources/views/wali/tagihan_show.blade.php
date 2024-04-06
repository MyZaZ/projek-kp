@extends('layouts.app_sneat_wali')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">TAGIHAN SPP {{ strtoupper($siswa->nama) }}</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr>
                                    <td rowspan="4" width="100" class="align-top">
                                        <img src="{{ \Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}" width="100">
                                    </td>
                                    <td><b>NIS</b></td>
                                    <td>: {{ $siswa->nisn }}</td>
                                </tr>
                                <tr>
                                    <td><b>Nama</b></td>
                                    <td>: {{ $siswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td><b>Jurusan</b></td>
                                    <td>: {{ $siswa->jurusan }}</td>
                                </tr>
                                <tr>
                                    <td><b>Kelas</b></td>
                                    <td>: {{ $siswa->kelas }}</td>
                                </tr>
                                <tr>
                                    <td><b>Tgl. Tagihan</b></td>
                                    <td colspan="2">: {{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Tgl. Akhir Pembayaran</b></td>
                                    <td colspan="2">: {{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Status</b></td>
                                    <td colspan="2">: {{$tagihan->getStatusTagihanWali()}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <td width="1%">No</td>
                                <td>Nama Tagihan</td>
                                <td class="text-end">Jumlah Tagihan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->tagihanDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_biaya }}</td>
                                    <td class="text-end">{{ formatRupiah($item->jumlah_biaya) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center fw-bold">Total yang harus dibayar</td>
                                <td class="text-end fw-bold">{{ formatRupiah($tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="alert alert-secondary mt-4" role="alert">
                        Pembayaran bisa dilakukan dengan cara langsung ke Tata Usaha atau melalui transfer bank, milik sekolah berikut:
                        <br>
                        Setelah melakukan transfer, silahkan upload bukti pembayaran melalui tombol konfirmasi..! sesuai bank tujuan.
                        <br>
                        Hubungi Tata Usaha:
                        <a href="whatsapp://send?phone=+6281380107447&text=Hallo, saya {{ $wali->name }} dengan Nama Siswa {{ $siswa->nama }} dan NISN {{ $siswa->nisn }} dari Jurusan {{ $siswa->jurusan }} Kelas {{ $siswa->kelas }} Ingin melakukan pembayaran Terima kasih.">Klik disini untuk Melakukan Konfirmasi Melalui WhatsApp</a>
                    </div>
                    <div class="row">
                        @foreach ($bankSekolah as $itemBank)
                            <div class="col-md-4 mb-3">
                                <div class="alert alert-primary" role="alert">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td width="40%">Bank Tujuan</td>
                                                <td>: {{ $itemBank->nama_bank }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Rekening</td>
                                                <td>: {{ $itemBank->nomor_rekening }}</td>
                                            </tr>
                                            <tr>
                                                <td>Atas Nama</td>
                                                <td>: {{ $itemBank->atas_nama }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="{{ route('wali.pembayaran.create',[
                                        'tagihan_id' => $tagihan->id,
                                        'bank_sekolah_id' =>  $itemBank->id,
                                        ]) }}" class="btn btn-primary btn-sm mt-3">Konfirmasi Pembayaran</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <table class="table table-striped table-bordered mt-3">
                        <thead class="table-dark">
                            <tr>
                                <td width="1%">NO</td>
                                <td>TANGGAL</td>
                                <td>JUMLAH DIBAYAR</td>
                                <td>METODE</td>
                                <td>SISA</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalTagihan = $tagihan->tagihanDetails->sum('jumlah_biaya');
                                $totalPembayaran = 0; // Mulai dengan total pembayaran 0
                            @endphp
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
</div>

@endsection
