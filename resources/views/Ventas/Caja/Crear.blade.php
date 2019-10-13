@section('agregarCaja')
    <h1>Nueva Caja</h1>
    <form method="POST" action="{{ route('Caja.Crear') }}">
        @csrf
        
        <input type="text" name="nombreCaja" placeholder="Nombre. Ej.: Caja 001" class="form-control mb-2" value="{{ old('nombreCaja') }}">
        <input type="text" name="formaCobro" placeholder="Forma de Cobro" class="form-control mb-2" value="{{ old('formaCobro') }}">
        <input type="text" name="estado" placeholder="Estado" class="form-control mb-2" value="{{ old('estado') }}">
        <input type="text" name="descripcion" placeholder="Descripción" class="form-control mb-2" value="{{ old('descripcion') }}">
        <button class="btn btn-primary btn-block" type="submit">Agregar Caja</button>
    </form>
@endsection