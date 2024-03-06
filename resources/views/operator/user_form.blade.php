@extends('layouts.app_sneat')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Form User</h5>
                <div class="card-body">

                    {!! Form::model($model, ['route' => $route,'method' => $method]) !!}
                        <div class="form-grup mt-3">
                            <label for="name">Nama</label>
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="email">Email</label>
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="password">Password</label>
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="nohp">No.HP</label>
                            {!! Form::text('nohp', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nohp') }}</span>
                        </div>
                        <div class="form-grup mt-3">
                            <label for="akses">Hak Akses</label>
                            {!! Form::select(
                             'akses', // Nama field
                                [ // Array pilihan
                                'operator' => 'Operator Sekolah',
                                'admin'    => 'Administrator'
                                ],
                                 null, // Nilai default (optional)
                                ['class' => 'form-control'] // Atribut tambahan untuk select (optional)
                            ) !!}

                            <span class="text-danger">{{ $errors->first('akses') }}</span>
                        </div>
                    {!! Form::submit($button, ['class' => 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection
