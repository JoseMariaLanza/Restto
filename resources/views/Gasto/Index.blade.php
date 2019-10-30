@extends('layouts.app')

@section('content')

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
                @can('gastos.create')
                <div class="row justify-content-center" style="margin-bottom:30px">
                    <div class="col-md-8">
                        @include('Gasto.Crear')
                        @yield('agregarGasto')
                    </div>
                    
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Gastos</h1>
                    <form role="search" class="navban-form navbar-left pull-right" method='GET'>
                        <div class="row justify-content-end" style="margin-bottom:30px">
                            <div class="col-md-2">Buscar entre</div>
                            <div class="form-goup">
                                {{ Form::date('fechaInicio', Carbon\Carbon::now(), [ 'class' => 'form-control mb-2', 'value' => "old('fechaInicio')" ]) }}
                            </div>
                            <div class="col-md-1">y</div>
                            <div class="form-goup">
                                {{ Form::date('fechaFin', Carbon\Carbon::now(), [ 'class' => 'form-control mb-2', 'value' => "old('fechaFin')" ]) }}
                            </div>
                            <button type="submit" class="btn btn-default">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                @foreach($gastos as $item)
                    <div class="col-md-50">
                        <div class="card" style="margin-bottom:30px">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h1>{{ $item->Concepto }}</h1>
                                @can('gastos.destroy')
                                {!! Form::open(['route' => ['gastos.destroy', $item->id], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type="submit">Eliminar...</button>
                                {!! Form::close() !!}
                                @endcan
                            </div>
                            <div class="card-body">
                                <h4>Id: {{ $item->id }}</h4>
                                <h4>Concepto: {{ $item->Concepto }}</h4>
                                <h4>Monto del gasto: {{ $item->Monto }}</h4>
                                <h4>Período: {{ $item->Periodo }}</h4>
                                <h4>Fecha del gasto: {{ $item->Fecha }}</h4>
                                <h4>Descripción: {{ $item->Descripcion }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{$gastos->links()}}
            </div>
        </div>
    </div>
@endsection