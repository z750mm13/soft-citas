@extends('layouts.app')

@section('content')
<div class="container">
    <p>Hola mundo</p>
    <ul>
        @foreach($medicamentos as $medicamento)
        <li>{{$medicamento->nombre}}</li>
        @endforeach
    </ul>
</div>
@endsection