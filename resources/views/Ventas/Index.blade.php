@extends('layouts.app')

@section('content')
<div class="container">
    @can('ventas.index')
        <ventas />
    @endcan
</div>
@endsection