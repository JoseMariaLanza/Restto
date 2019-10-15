@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Editar Caja</span>
                        <a href="{{ route('cajas.index') }}" class="btn btn-primary btn-sm">Volver...</a>
                    </div>
                    <div class="card-body">     
                        @if (session('mensaje'))
                            <div class="alert alert-success">
                                {{ session('mensaje') }}
                            </div>
                        @endif

                        {!! Form::model($caja, ['route' => ['cajas.update', $caja->id], 'method' => 'PUT']) !!}

                            @csrf
                    
                            @if (count($errors)>0)

                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endforeach

                            @endif

                            @include('Ventas.Caja.partials.form')
                            @yield('formularioCaja')

                        {!! Form::close() !!}

                        <!-- <form action="{{ route('cajas.update', $caja->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                    
                            @if (count($errors)>0)

                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                         </button>
                                    </div>
                                @endforeach

                            @endif
                    
                            <input type="text" name="nombreCaja" placeholder="Nombre. Ej.: Caja 001" class="form-control mb-2" value="{{ $caja->Nombre_Caja, old('nombreCaja') }}">
                            <input type="text" name="formaCobro" placeholder="Forma de Cobro" class="form-control mb-2" value="{{ $caja->Forma_Cobro, old('formaCobro') }}">
                            <input type="text" name="estado" placeholder="Estado" class="form-control mb-2" value="{{ $caja->Estado, old('estado') }}">
                            <input type="text" name="descripcion" placeholder="Descripción" class="form-control mb-2" value="{{ $caja->Descripcion, old('descripcion') }}">
                            <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection