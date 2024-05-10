@extends('layouts.app_sneat')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h4 class="card-header">Form Laporan</h4>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                    <h5>Laporan Tagihan</h5>
                        {!! Form::open(['url' =>'','method' => 'GET']) !!}
                            <div class="row gx-2">
                            <div class="col-md-2 col-sm-12">
                            {!! Form::select(
                                'status',
                                [
                                    '' => 'Pilih Satatus',
                                    'lunas' => 'Lunas',
                                    'baru' => 'Baru',
                                    'angsur' => 'Angsur',
                                ],
                                request('status'),
                             ['class' => 'form-control'],
                             ) !!}
                             </div>
                            <div class="col-md-2 col-sm-12">
                                {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control','placeholder' => 'Pilih Bulan']) !!}
                            </div>
                            <div class="col-md-2 col-sm-12">
                                {!! Form::selectRange('tahun', 2024, date('Y')+1, request('tahun'), ['class' => 'form-control','placeholder' => 'Pilih Tahun']) !!}
                            </div>
                            <div class="col">
                            <button type="submit"  class="btn btn-primary">Tampil</button>
                            </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
