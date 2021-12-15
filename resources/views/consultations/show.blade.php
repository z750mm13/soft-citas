@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="icon icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('consultations.index') }}">Consultas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Consulta</li>
    </ol>
    <div class="vertical-buffer mb-5">
        <h1>San Juan Teponaxtla</h1>
        <h2>Consulta</h2>
        <hr class="red">
    </div>

    @if(Auth::user()->rol == 'Encargado de la unidad')
    <div class="form-group">
      <a class="btn btn-primary btn-sm" href="{{route("consultations.prescriptions",[$consultation->id])}}" onclick="dateForm('pdf')" role="button"><i class="far fa-file-pdf"></i> Imprimir</a>
    </div>
    @endif

    <div class="card mb-5 shadow">
        <div class="card-header">
          <h4 class="card-title">Consulta</h4>
        </div>
        <div class="card-body mx-4 pb-5">
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h5 class="card-title mt-1">Medico</h5>
                    <p class="card-text">{{$consultation->appointment->user->name. ' ' .$consultation->appointment->user->lastname}}</p>
                </div>
                <div>
                    <h5 class="card-title mt-1">Paciente</h5>
                    <p class="card-text">{{$consultation->appointment->patient->name. ' ' .$consultation->appointment->patient->lastname}}</p>
                </div>
            </div>
            <p class="card-text text-right text-muted">{{$consultation->created_at->format('d/m/Y')}}</p>
            <p class="card-text text-justify">{{$consultation->description}}</p>
            
            @if(count($consultation->prescriptions))
            <div class="vertical-buffer mb-5 mt-3">
                <h4 class="mt-0">Receta</h4>
                <hr class="red mb-5">
            </div>
            @foreach($consultation->prescriptions as $prescription)
            <p class="card-text text-justify"><b>{{$prescription->medicine->name}}:</b> {{$prescription->dose}}{{$prescription->description?', '.$prescription->description:''}}.</p>
            @endforeach
            @endif
        </div>

    </div>

    <div class="alert alert-info col-12">
        <strong>Aviso</strong>
        <p>La consulta solo podra ser <b>eliminada</b> o <b>editada</b> con la <b>autorización del(a) responsable</b>.</p>
    </div>
</div>
@endsection