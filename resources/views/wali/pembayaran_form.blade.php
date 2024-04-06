@extends('layouts.app_sneat_wali')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">KONFIRMASI PEMBAYARAN</h5>
            <div class="card-body">
                {!! Form::model($model, ['route' => $route,'method' => $method]) !!}
                    <div class="form-grup mt-3">
                            <label for="bank_id">Bank Tujuan</label>
                           {!! Form::select('bank_id', $listBank, request('bank_sekolah_id'), ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                    </div>
                    <div class="form-grup mt-3">
                            <label for="tanggal_bayar">Tanggal Bayar</label>
                           {!! Form::date('tanggal_bayar',$model->tanggal_bayar ?? date('Y-m-d'), ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-grup mt-3">
                            <label for="jumlah_dibayar">Jumlah Yang dibayarkan</label>
                           {!! Form::text('jumlah_dibayar', null, ['class' => 'form-control rupiah']) !!}
                            <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-grup mt-3">
                            <label for="bukti_bayar">Upload Bukti Pembayaran</label>
                           {!! Form::file('bukti_bayar', ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection