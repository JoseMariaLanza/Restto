@extends('layouts.app')

@section('content')

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
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @include('Ventas.Caja.partials.formCerrar')
                    @yield('formularioCerrar')
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>

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

@endsection