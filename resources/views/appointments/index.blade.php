@extends('layouts.app')
<?php use Carbon\Carbon; ?>
@section('content')
@include('appointments.form')
@include('appointments.delete')

<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="icon icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="ppatient_id">Citas</li>
    </ol>
    <div class="vertical-buffer mb-5">
        <h1>San Juan Teponaxtla</h1>
        <h2 id="bienvenida">Citas</h2>
        <hr class="red">
        <p>Apartado de control de citas. En este apartado usted puede dar de alta las citas ademas de modificarlas o eliminarlas.</p>
    </div>

    <form>
      <div class="row">
        <div class="col-md-4 col-sm-12 mb-4">
          <select class="form-control @error('patient_id') is-invalid @enderror" id="spatient_id" name="patient_id">
            <option value="">Seleccione al paciente</option>
            @foreach($patients as $patient)
            <option value="{{$patient->id}}">{{$patient->name.' '.$patient->lastname}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4 col-sm-12 mb-4">
          <select class="form-control @error('user_id') is-invalid @enderror" id="suser_id" name="user_id">
            <option value="">Seleccione al encargada(o)</option>
            @foreach($doctors as $doctor)
            <option value="{{$doctor->id}}">{{$doctor->name.' '.$doctor->lastname}}</option>
            @endforeach
        </select>
        </div>
        <div class="col-md-3 col-sm-12 mb-4">
          <input type="date" class="form-control" placeholder="Fecha" name="date" id="sdate">
        </div>
        <div class="col-md-1 col-sm-12 mb-4 text-right">
          <button type="submint" class="btn btn-sm btn-primary">Filtrar</button>
        </div>
      </div>
    </form>

    <div class="card mb-5 shadow">
        <div class="card-body p-0">
            <div class="row m-4 align-items-center">
                <div class="col-7">
                    <h5 class="card-title mb-0">Citas</h5>
                </div>
                <div class="col-5 text-right">
                    <button type="button" data-toggle="modal" data-target="#appointmentForm" data-title="Agregar" onclick="clearFields()" class="btn btn-sm btn-primary">Agregar cita</button>
                </div>
            </div>

            @if($appointments->count())
            <?php $index = 0; ?>
            <div class="table-responsive">
              <table class="table table-hover p-0 mb-0">
                  <thead class="thead-light">
                      <tr>
                        <th scope="col">Asunto</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Medico</th>
                        <th scope="col">Fecha/Hora</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($appointments as $appointment)
                      <tr>
                        <th>
                          @if($appointment->consultation)
                          <i class="fas fa-check"></i>
                          @elseif(Carbon::now()->lte($appointment->datetime))
                          <i class="far fa-clock"></i>
                          @else
                          <i class="fas fa-times"></i>
                          @endif
                          {{$appointment->type}}
                        </th>
                        <td>{{$appointment->patient->name.' '.$appointment->patient->lastname}}</td>
                        <td>{{$appointment->user->name.' '.$appointment->user->lastname}}</td>
                        <td>{{$appointment->datetime->format('d-m-Y H:i')}}</td>
                        <td>
                          <div class="dropdown">
                              <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                {{-- TODO: hacer el acceos a la receta --}}
                                @if($appointment->consultation)
                                <a href="/consultations/{{$appointment->consultation->id}}" class="text-decoration-none"><button class="dropdown-item"><i class="fas fa-notes-medical"></i> Ver</button></a>
                                @else
                                <a href="/consultations/{{$appointment->id}}/create" class="text-decoration-none"><button class="dropdown-item"><i class="far fa-edit"></i> Realizar</button></a>
                                @endif
                                @if(!$appointment->consultation)
                                <button data-toggle="modal" data-target="#appointmentForm" data-title="Editar" onclick="setValues({{$index}})" class="dropdown-item"><i class="fas fa-pen"></i> Editar</button>
                                <button data-toggle="modal" data-target="#deleteAppointment" class="dropdown-item" onclick="deleteElement({{$index}})"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                @endif
                              </div>
                            </div>
                        </td>
                      </tr>
                      <?php $index++; ?>
                      @endforeach
                    </tbody>
              </table>
            </div>
            @else
            <div class="card mb-3"> <!-- Borde primario primary danger warning -->
              <div class="card-body text-center"> <!-- Texto primario -->
                <h4>No se han registrado citas</h4>
              </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
  let appointments = [
      @foreach($appointments as $appointment){
        "id":{{$appointment->id}},
        "type":"{{$appointment->type}}",
        "description":"{{$appointment->description}}",
        "datetime":"{{$appointment->datetime}}".replace(' ','T'),
        "user_id":"{{$appointment->user_id}}",
        "patient_id":{{$appointment->patient_id}}
      },
      @endforeach
  ];
  function setValues(id){
        $("#appointment").attr("action","{{ route('appointments.update',[0]) }}".slice(0, -1)+appointments[id].id);
        $("#type").val(appointments[id].type);
        $("#description").val(appointments[id].description);
        $("#datetime").val(appointments[id].datetime);
        $("#user_id").val(appointments[id].user_id);
        $("#patient_id").val(appointments[id].patient_id);
        $("#user").hide();
        $("#patient").hide();
        $("#method").val("PUT");
  }
  function clearFields(){
        $("#appointment").attr("action","{{ route('appointments.store') }}");
        $("#type").val("");
        $("#description").val("");
        $("#datetime").val("");
        $("#user_id").val("");
        $("#user").show();
        $("#patient").show();
        $("#patient_id").val("");
        $("#method").val("POST");
  }
  function deleteElement(id) {
    $("#formDelete").attr("action","{{ route('appointments.destroy',[0]) }}".slice(0, -1)+appointments[id].id);
  }
</script>
@endpush