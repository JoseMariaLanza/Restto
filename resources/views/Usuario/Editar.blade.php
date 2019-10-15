@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Editar Perfil</span>
                        <a href="/Empleado/Detalles/ {{ $empleado->id }}" class="btn btn-primary btn-sm">Volver a detalles</a>
                    </div>
                    <div class="card-body">     
                        @if (session('mensaje'))
                            <div class="alert alert-success">
                                {{ session('mensaje') }}
                            </div>
                        @endif
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
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
                    
                            <input type="text" name="name" placeholder="Nombre de usuario" class="form-control mb-2" value="{{ $user->name }}">
                            <input type="text" name="email" placeholder="E-mail" class="form-control mb-2" value="{{ $user->email }}">
                            <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection