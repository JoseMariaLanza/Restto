@extends('layouts.app')

@section('content')
<!-- @inject('categorias', 'App\Http\Controllers\CategoriaController') -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
    
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endforeach
            
                    @if (session('mensaje'))
                        <div class="alert alert-success">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                <div class="row justify-content-center" style="margin-bottom:30px">
                    <div class="col-md-5">
                        @include('Caja.Crear')
                        @yield('agregarCaja')
                    </div>
                    <!-- <div class="col-md-5">
                        @include('Categoria.Crear')
                        @yield('agregarCategoria')
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Cajas</h1>
                    <form role="search" class="navban-form navbar-left pull-right" method='GET'>
                        <div class="row justify-content-end" style="margin-bottom:30px">
                            <div class="form-goup">
                                <input type="text" name="texto" class="form-control" placeholder="Búsqueda">
                            </div>
                            <button type="submit" class="btn btn-default">Buscar</button>
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                @foreach($cajas as $item)
                    <div class="col-md-50">
                        <div class="card" style="margin-bottom:30px">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h1>{{ $item->nombreCaja }}</h1>
                                <form action="{{ route('Caja.Eliminar', $item->id) }}" method='POST' class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type="submit">Eliminar...</button>
                                </form>
                            </div>
                            <a href="{{ route('Caja.Editar', $item) }}" class="btn btn-primary btn-sm">Editar...</a>
                            <div class="card-body">
                                <h4>Id: {{ $item->id }}</h4>
                                <h4>Caja: {{ $item->nombreCaja }}</h4>
                                <h4>Forma de Cobro: {{ $item->Forma_Cobro }}</h4>
                                <h4>Estado: {{ $item->Estado }}</h4>
                                <h4>Terminal: {{ $item->Terminal }}</h4>
                                <h4>Descripción: {{ $item->Descripcion }}</h4>
                                <!-- <h4>Categoría: 
                                    @foreach($categorias->getCategorias() as $index => $categoria)
                                        @if ($index == $item->categoria_id)
                                            {{ $categoria }}
                                        @endif
                                    @endforeach    
                                </h4> -->
                            </div>
                        </div>
                    </div>
                @endforeach
                {{$cajas->links()}}
            </div>
        </div>
    </div>
@endsection