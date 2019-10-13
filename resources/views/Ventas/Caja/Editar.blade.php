@extends('layouts.app')

@section('content')
<!-- @inject('categorias', 'App\Http\Controllers\CategoriaController') -->
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Editar Caja</span>
                        <a href="{{ route('Caja.Detalles') }}" class="btn btn-primary btn-sm">Volver...</a>
                    </div>
                    <div class="card-body">     
                        @if (session('mensaje'))
                            <div class="alert alert-success">
                                {{ session('mensaje') }}
                            </div>
                        @endif
                        <form action="{{ route('Caja.Actualizar', $caja->id) }}" method="POST">
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
                    
                            <input type="text" name="nombreCaja" placeholder="Nombre. Ej.: Caja 001" class="form-control mb-2" value="{{ old('nombreCaja') }}">
                            <input type="text" name="formaCobro" placeholder="Forma de Cobro" class="form-control mb-2" value="{{ old('formaCobro') }}">
                            <input type="text" name="estado" placeholder="Estado" class="form-control mb-2" value="{{ old('estado') }}">
                            <input type="text" name="descripcion" placeholder="Descripción" class="form-control mb-2" value="{{ old('descripcion') }}">
                            <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection