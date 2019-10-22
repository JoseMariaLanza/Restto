@extends('layouts.app')

@section('content')

<!-- Facturar -->
<div class="container">
    <div class="col-md-12">
        <div class="col-md-50">
                <!-- @foreach ($errors->all() as $error)
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
                @endif -->
                @can('ventas.create')
                <div class="row justify-content-center" style="margin-bottom:30px">
                    <div class="col-md-12">
                        
                        <!-- Sin Vue, se hace con include -->
                        <!-- Vue -->
                        <ventas-facturacion />
                        
                    </div>
                </div>  
                @endcan
        </div>
    </div>
</div>
<!-- Ventas del día -->
    <div class="container">
        <div class="row-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Ventas del día</h1>
                    <!-- Búsqueda entre fechas -->
                    <!-- <form role="search" class="navban-form navbar-left pull-right" method='GET'>
                        <div class="row justify-content-end" style="margin-bottom:30px">
                            <div class="form-goup">
                                Buscar entre las fechas:
                                {{ Form::date('fechaInicio', Carbon\Carbon::now(), [ 'class' => 'mb-2 d-inline', 'value' => "old(fechaInicio)" ]) }}
                                y
                                {{ Form::date('fechaFin', Carbon\Carbon::now(), [ 'class' => 'mb-2 d-inline', 'value' => "old(fechaFin)" ]) }}
                            </div>
                            <button type="submit" class="btn btn-default">Buscar</button>
                        </div>
                    </form> -->
                </div>
                <div class="panel-body">
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                @foreach($facturas as $item)
                    <div class="col-md-50">
                        <div class="card" style="margin-bottom:30px">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h1>Factura Nº: {{ $item->id }}</h1>
                                @can('facturas.destroy')
                                {!! Form::open(['route' => ['ventas.destroy', $item->id], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type="submit">Anular venta...</button>
                                {!! Form::close() !!}
                                @endcan
                            </div>
                            
                            <div class="card-body pull-left" style="width:30%;">
                                <h4>Fecha y Hora: {{ $item->Fecha_Emision }}</h4>
                                <h4>Total: {{ $item->Total }}</h4>
                                <h4>Descripción: {{ $item->Descripcion }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{$facturas->links()}}
            </div>
        </div>
    </div>

<!-- Caja abierta -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">            
                    @if (session('mensaje'))
                        <div class="alert alert-success">
                            {{ session('mensaje') }}
                        </div>
                    @endif
                @can('ventas.updateState')
                <div class="row justify-content-center" style="margin-bottom:30px">
                    <div class="col-md-8">
                        @include('Ventas.Caja.partials.formCerrar')
                        @yield('formularioCerrar')
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>

@endsection