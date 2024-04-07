@extends('layouts.app_sneat_wali')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $("#checkboxtoggle").click(function () {
                if ($(this).is(":checked")) {
                    $("#form_bank_pengirim").show();
                    $("#pilihan_bank").fadeOut();
                } else {
                    $("#pilihan_bank").fadeIn();
                    $("#form_bank_pengirim").hide(); // Perbaikan di sini
                }
            });
        });
        $(document).ready(function () {
            $("#form_bank_pengirim").hide();
            $('#pilih_bank').change(function(e) {
                var bankId = $(this).find(":selected").val();
                window.location.href = "{!! $url !!}&bank_sekolah_id" + bankId;
            });
        });
    </script>
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">KONFIRMASI PEMBAYARAN</h5>
            <div class="card-body">
                {!! Form::model($model, ['route' => $route,'method' => $method]) !!}
                    <div class="divider text">
                        <div class ="divider-text"><i class="fa fa-info-circle"></i> INFORMASI REKENING PENGIRIM</div>
                    </div>
                    <div class="form-group" id="pilihan_bank">
                        <label for="wali_bank_id">Bank Pengirim</label>
                        {!! Form::select('wali_bank_id', $walibank, null, ['class' => 'form-control form-select', 'placeholder' => 'Pilih Nomor Rekening Pengirim']) !!}
                        <span class="text-danger">{{ $errors->first('wali_bank_id') }}</span>
                    </div>
                    <div class="form-group mt-3">
                    <div class="form-check">
                            {!! Form::checkbox('pilihan_bank', 1, false, ['class' => 'form-check-input', 'id' => 'checkboxtoggle']) !!} <!-- Checkbox dengan nama pilihan_bank -->
                            <label class="form-check-label" for="checkboxtoggle">Saya punya rekening baru</label>
                        </div>
                    </div>
                    <div class="alert alert-secondary mt-4" role="alert" id="form_bank_pengirim">
                        Informasi ini dibutuhkan agar operator sekolah dapat memverifikasi pembayaran yang dilakukan oleh wali murid melalui transfer.
                    <div class="form-group mt-2">
                        <label for="bank_id_pengirim">Bank Pengirim</label>
                        {!! Form::select('bank_id_pengirim', $listBankWali, null, ['class' => 'form-control form-select']) !!}
                        <span class="text-danger">{{ $errors->first('bank_id_pengirim') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nama_rekening_pengirim">Atas Nama</label>
                        {!! Form::text('nama_rekening_pengirim', null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('nama_rekening_pengirim') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nomor_rekening_pengirim">Nomor Rekening</label>
                        {!! Form::text('nomor_rekening_pengirim', null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('nomor_rekening_pengirim') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check">
                            {!! Form::checkbox('simpan_data_rekening', 1, false, ['class' => 'form-check-input', 'id' => 'defaultCheck3']) !!}
                            <label class="form-check-label" for="defaultCheck3">Simpan data ini untuk memudahkan pembayaran selanjutnya.</label>
                        </div>
                    </div>
                    </div>
                    <hr>

                    <div class="divider text">
                        <div class ="divider-text"><i class="fa fa-info-circle"></i> INFORMASI REKENING TUJUAN</div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="bank_id">Bank Tujuan</label>
                        {!! Form::select('bank_id', $listBank, request('bank_sekolah_id'), ['class' => 'form-control','placeholder' => 'Pilih Bank Tujuan Transfer']) !!}
                        <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                    </div>
                    @if (request('bank_sekolah_id') != '')
                        <div class="alert alert-primary mt-2 mb-2" role="alert">
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td width="20%">Bank Tujuan</td>
                                        <td>: {{ $bankYangDipilih->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $bankYangDipilih->nomor_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Atas Nama</td>
                                        <td>: {{ $bankYangDipilih->atas_nama }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <hr>

                    <div class="form-group mt-3">
                        <label for="tanggal_bayar">Tanggal Bayar</label>
                        {!! Form::date('tanggal_bayar',$model->tanggal_bayar ?? date('Y-m-d'), ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="jumlah_dibayar">Jumlah Yang dibayarkan</label>
                        {!! Form::text('jumlah_dibayar', null, ['class' => 'form-control rupiah']) !!}
                        <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="bukti_bayar">Upload Bukti Pembayaran</label>
                        {!! Form::file('bukti_bayar', ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                    </div>
                    <div class="mt-3">
                        {!! Form::submit('Konfirmasi Pembayaran', ['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
