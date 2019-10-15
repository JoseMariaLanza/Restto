@section('formularioCaja')
    <div class="form-group">
        {{ Form::text('Nombre_Caja', null, [ 'class' => 'form-control mb-2', 'placeholder' => 'Nombre de la Caja. Ej.: Caja 001', 'value' => "old('nombreCaja')" ]) }}
        {{ Form::text('Forma_Cobro', null, [ 'class' => 'form-control mb-2', 'placeholder' => 'Forma de cobro', 'value' => "old('formaCobro')" ]) }}
        {{ Form::text('Estado', null, [ 'class' => 'form-control mb-2', 'placeholder' => 'Estado', 'value' => "old('estado')" ]) }}
        {{ Form::text('Descripcion', null, [ 'class' => 'form-control mb-2', 'placeholder' => 'Descripción', 'value' => "old('descripcion')" ]) }}
        {{ Form::submit('Guardar', [ 'class' => 'btn btn-primary btn-block', 'type' => 'submit' ]) }}

        <!-- <form method="POST" action="{{ route('cajas.store') }}">
            @csrf
            
            <input type="text" name="nombreCaja" placeholder="Nombre. Ej.: Caja 001" class="form-control mb-2" value="{{ old('nombreCaja') }}">
            <input type="text" name="formaCobro" placeholder="Forma de Cobro" class="form-control mb-2" value="{{ old('formaCobro') }}">
            <input type="text" name="estado" placeholder="Estado" class="form-control mb-2" value="{{ old('estado') }}">
            <input type="text" name="descripcion" placeholder="Descripción" class="form-control mb-2" value="{{ old('descripcion') }}">
            <button class="btn btn-primary btn-block" type="submit">Agregar Caja</button>
        </form> -->
    </div>
@endsection