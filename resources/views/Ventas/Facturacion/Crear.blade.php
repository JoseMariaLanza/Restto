@section('facturar')
<!-- {!! Form::open(['action' => ['SalesController@create', $detallesFactura], 'method' => 'POST']) !!}
    @csrf -->
    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <!-- Factura -->
        <div class="col-md-4">
                <div class="card" style="margin-bottom:30px">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1>Factura</h1>
                    </div>
                    <div class="card-body">
                    </div>
                </div>
        </div>
        <!-- Detalles de la factura -->
        <div class="col-md-8">
            <div class="table-responsive-sm">
                <table class="table">
                <thead>
                    <tr>
                        <th>{{ Form::text('Descripcion', null, [ 'class' => 'form-control mb-2', 'placeholder' => 'Orden, mozo, mesa, etc.', 'value' => "old('Descripcion')" ]) }}</th>
                        <th>{{ Form::number('Precio_Unitario', null, [ 'class' => 'form-control mb-2', 'step' => '0.1', 'placeholder' => 'Precio por unidad', 'value' => "old('Precio_Unitario')" ]) }}</th>
                        <th>{{ Form::number('Cantidad', null, [ 'class' => 'form-control mb-2', 'step' => '0.1', 'placeholder' => 'Cantidad vendida', 'value' => "old('Cantidad')" ]) }}</th>
                        <th>{{ Form::submit('Agregar', [ 'class' => 'btn btn-primary btn-block', 'type' => 'submit' ]) }}</th>
                    </tr>
                    
                    <tr>
                        <th>Descripcion del pedido, mozo y mesa</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detallesFactura as $detalleFactura)
                        <tr>
                            <td>{{ $detalleFactura->Descripcion }}</td>
                            <td>{{ $detalleFactura->Precio_Unitario }}</td>
                            <td>{{ $detalleFactura->Cantidad }}</td>
                            <td>{{ $detalleFactura->Subtotal }}</td>
                            <td>
                            <!-- @can('factura.edit') -->
                                <a href="{{ route('ventas.create', $detalleFactura) }}" class="btn btn-primary btn-sm btn-block">Quitar</a>
                            <!-- @endcan -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- {!! Form::close() !!} -->
@endsection