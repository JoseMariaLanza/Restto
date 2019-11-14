@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Detalles</span>
                        <a href="/editar/ {{ $menuItem->id }}" class="btn btn-primary btn-sm">Editar Item...</a>
                    </div>
                    <div class="card-body">
                        <h1>{{ $menuItem->Nombre_Plato }}</h1>
                        <h4>Precio: {{ $menuItem->Precio_Venta }}</h4>
                        <h4>Descripción: {{ $menuItem->Descripcion }}</h4>
                    </div>
                    <!-- <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Datos de la cuenta</span>
                            <a href="{{ url('/usuario/editar', $usuarioEmpleado->id) }}" class="btn btn-primary btn-sm">Editar datos de la cuenta...</a>
                    </div>
                    <div class="card-body">     
                        <h1>{{ $usuarioEmpleado->name }}</h1>
                        <h4>Nombre de usuario: {{ $usuarioEmpleado->name }}</h4>
                        <h4>E-mail: {{ $usuarioEmpleado->email }}</h4>
                        <h4>Descripción: {{ $usuarioEmpleado->Descripcion }}</h4>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
@endsection