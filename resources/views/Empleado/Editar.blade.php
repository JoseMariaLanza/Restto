@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Editar Perfil</span>
                        <a href="/detalles/ {{ $empleado->id }}" class="btn btn-primary btn-sm">Volver a detalles</a>
                    </div>
                    <div class="card-body">     
                        @if (session('mensaje'))
                            <div class="alert alert-success">
                                {{ session('mensaje') }}
                            </div>
                        @endif
                        <form action="{{ route('Empleado.Actualizar', $empleado->id) }}" method="POST">
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
                    
                            <input type="text" name="Apellido" placeholder="Apellidos" class="form-control mb-2" value="{{ $empleado->Apellido }}">
                            <input type="text" name="Nombre" placeholder="Nombres" class="form-control mb-2" value="{{ $empleado->Nombre }}">
                            <input type="text" name="FechaNacimiento" placeholder="Fecha de Nacimiento" class="form-control mb-2" value="{{ $empleado->FechaNacimiento }}">
                            <input type="text" name="Telefono" placeholder="Teléfono" class="form-control mb-2" value="{{ $empleado->Telefono }}">
                            <input type="text" name="Domicilio" placeholder="Domicilio" class="form-control mb-2" value="{{ $empleado->Domicilio }}">
                            <input type="text" name="Descripcion" placeholder="Descripcion" class="form-control mb-2" value="{{ $empleado->Descripcion }}">
                            <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection