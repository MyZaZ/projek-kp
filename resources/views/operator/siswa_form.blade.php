@extends('layouts.app_sneat')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{$title}}</h5>
                <div class="card-body">

                    {!! Form::model($model, ['route' => $route,'method' => $method , 'files' => true]) !!}
                        <div class="form-grup mt-3">
                            <label for="wali_id">Wali Murid (optional)</label>
                            {!! Form::select('wali_id', $wali, null, [
                                'class' => 'form-control select2', 
                                'placeholder' => 'Pilih Wali Murid']) !!}
                            <span class="text-danger">{{ $errors->first('wali_id') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="nama">Nama</label>
                            {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="nisn">NISN</label>
                            {!! Form::text('nisn', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nisn') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="jurusan">Jurusan</label>
                            {!! Form::select('jurusan', [
                                'RPL' => 'Rekayasa Perangkat Lunak',
                                'TKJ' => 'Teknik Komputer dan Jaringan',
                            ], null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('jurusan') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="kelas">Kelas</label>
                            {!! Form::select('kelas', [
                                '10' => 'X',
                                '11' => 'XI',
                                '12' => 'XII',

                            ], null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('kelas') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="angkatan">Wali Murid</label>
                            {!! Form::selectRange('angkatan', 2023, date('Y') + 1, null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="foto">Foto <b>(Format: jpg, jpeg, png, Ukuruan Maks: 5MB)</b></label>
                            {!! Form::file('foto', ['class' => 'form-control','accept' => 'image/*']) !!}
                            <span class="text-danger">{{ $errors->first('foto') }}</span>
                        </div>
                        
    
                    {!! Form::submit($button, ['class' => 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection
