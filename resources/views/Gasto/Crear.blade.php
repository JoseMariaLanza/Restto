@section('agregarGasto')
    <h1>Agragar un gasto</h1>

    {!! Form::open(['route' => ['gastos.create']]) !!}

        @csrf

        @include('Gasto.partials.form')
        @yield('formularioGasto')

    {!! Form::close() !!}
@endsection