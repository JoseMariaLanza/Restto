@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Perfil</span>
                        <a href="/editar/ {{ $empleado->id }}" class="btn btn-primary btn-sm">Editar datos personales...</a>
                    </div>
                    <div class="card-body">
                        <h1>{{ $empleado->nombre }}</h1>
                        <h4>Apellidos: {{ $empleado->apellido }}</h4>
                        <h4>Nombres: {{ $empleado->nombre }}</h4>
                        <h4>Teléfono: {{ $empleado->telefono }}</h4>
                        <h4>Domicilio: {{ $empleado->domicilio }}</h4>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Datos de la cuenta</span>
                            <a href="{{ url('/usuario/editar', $usuarioEmpleado->id) }}" class="btn btn-primary btn-sm">Editar datos de la cuenta...</a>
                    </div>
                    <div class="card-body">     
                        <h1>{{ $usuarioEmpleado->name }}</h1>
                        <h4>Nombre de usuario: {{ $usuarioEmpleado->name }}</h4>
                        <h4>E-mail: {{ $usuarioEmpleado->email }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection