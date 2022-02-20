@extends('layouts.app')

@section('content')
<section class="section section-intro flag-banner" style="background: transparent url({{ asset('resources/img/background_2.jpg')}}) no-repeat center top; background-size: cover; top:0;">
<div class="container">
  <div class="section-intro__content" style="color: transparent;">
    <h1></h1>
    <p class="text-border">-</p>
    <p class="text-border">-</p>
    <p class="text-border">-</p>
    <p class="text-border">-</p>
    <p class="text-border">-</p>
    <p class="text-border">-</p>
    <p class="text-border">-</p>
    <p class="text-border">-</p>
  </div>
</div>
</section>

<div class="container">
    <div class="vertical-buffer">
        <h1>Unidad médica rural IMSS bienestar<br>San Juan Teponaxtla</h1>
        <p>Portal para el control de información sobre citas, consultas y medicamentos de la unidad médica rural IMSS bienestar San Juan Teponaxtla.</p>
    </div>
    <div class="card-deck mb-5">
      @if(Auth::user())
      @if(Auth::user()->rol != 'Encargado de la unidad')
      <div class="col-md-4 col-sm-6 col-xm-12 mb-4">
        <div class="card shadow p-5">
          <div class="box-part text-center">
            <i class="fas fa-pills mt-3 mb-3 fa-3x"></i>
            <div class="title">
              <h4>Medicamentos</h4>
            </div>
            <div class="text">
              <span>Apartado de control para medicamentos</span>
            </div>
            <a class="btn btn-primary stretched-link" href="{{ route('medicines.index') }}">Ver</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xm-12 mb-4">
        <div class="card shadow p-5">
          <div class="box-part text-center">
            <i class="fas fa-hospital-user mt-3 mb-3 fa-3x"></i>
            <div class="title">
              <h4>Pacientes</h4>
            </div>
            <div class="text">
              <span>Apartado de control para pacientes</span>
            </div>
            <a class="btn btn-primary stretched-link" href="{{ route('patients.index') }}">Ver</a>
          </div>
        </div>
      </div>
      @endif
      <div class="col-md-4 col-sm-6 col-xm-12 mb-4">
        <div class="card shadow p-5">
          <div class="box-part text-center">
            <i class="far fa-calendar-check mt-3 mb-3 fa-3x"></i>
            <div class="title">
              <h4>Citas</h4>
            </div>
            <div class="text">
              <span>Apartado de control para citas</span>
            </div>
            <a class="btn btn-primary stretched-link" href="{{ route('appointments.index') }}">Ver</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xm-12 mb-4">
        <div class="card shadow p-5">
          <div class="box-part text-center">
            <i class="fas fa-notes-medical mt-3 mb-3 fa-3x"></i>
            <div class="title">
              <h4>Consultas</h4>
            </div>
            <div class="text">
              <span>Apartado de control para consultas</span>
            </div>
            <a class="btn btn-primary stretched-link" href="{{ route('consultations.index') }}">Ver</a>
          </div>
        </div>
      </div>
      @endif
    </div>
</div>
@endsection