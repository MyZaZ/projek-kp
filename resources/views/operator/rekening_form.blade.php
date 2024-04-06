@extends('layouts.app_sneat')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <div class="card-body">

                {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
                <div class="form-group mt-3">
                    <label for="nama_bank">Nama Bank</label>
                    {!! Form::text('nama_bank', null, ['class' => 'form-control', 'id' => 'nama_bank']) !!}
                    <span class="text-danger">{{ $errors->first('nama_bank') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="nomor_rekening">Nomor Rekening</label>
                    {!! Form::text('nomor_rekening', null, ['class' => 'form-control', 'id' => 'nomor_rekening']) !!}
                    <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="atas_nama">Atas Nama</label>
                    {!! Form::text('atas_nama', null, ['class' => 'form-control', 'id' => 'atas_nama']) !!}
                    <span class="text-danger">{{ $errors->first('atas_nama') }}</span>
                </div>
                {!! Form::submit($button, ['class' => 'btn btn-primary mt-3']) !!}
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>

@endsection
