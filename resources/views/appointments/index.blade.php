@extends('layouts.app')
<?php use Carbon\Carbon; ?>
@section('content')
@include('appointments.form')
@include('appointments.delete')
@include('appointments.date')

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

    <div class="form-group">
      <a class="btn btn-primary btn-sm" href="#" onclick="dateForm('pdf')" role="button" data-toggle="modal" data-target="#confirmAppoiment"><i class="far fa-file-pdf"></i> Generar PDF</a>
      <a class="btn btn-sm btn-default" href="#" onclick="dateForm('excel')" role="button" data-toggle="modal" data-target="#confirmAppoiment"><i class="far fa-file-excel"></i> Generar Excel</a>
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

    <div class="accordion mb-5 shadow" id="statisticAccordion">
      <div class="card">
        <div class="card-header" id="chartArea">
          <h2 class="mb-0">
            <a class="btn btn-link btn-block text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#statistic" aria-expanded="true" aria-controls="collapseOne">
              Estadísticas
            </a>
          </h2>
        </div>
    
        <div id="statistic" class="collapse show" aria-labelledby="chartArea" data-parent="#statisticAccordion">
          <div class="card">
            <div class="card-body p-3">
              <form action="{{route('appointments.index')}}" method="GET" id="updateChar">
                @csrf
                @method('GET')
                <div class="form-group">
                    <label for="dateState">Ver citas por</label>
                    <select class="form-control" id="dateState" name="dateState">
                        <option selected>Seleccione el tipo</option>
                        <option>Dia</option>
                        <option>Mes</option>
                        <option>Año</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="inputDate">Fecha</label>
                  <input type="date" class="form-control" id="inputDate" name="statisticDate" aria-describedby="dateHelp" readonly>
                  <input type="number" id="statisticYear" name="statisticYear" class="form-control" min="1900" max="2099" step="1" value="{{now()->format('Y')}}" readonly/>
                </div>
              </form>
              <button type="submit" class="btn btn-sm btn-primary" form="updateChar">Generar</button>
              <div>
                <canvas id="chart-line" height="400"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
                        <td>{{$appointment->datetime->format('d-m-Y g:i A')}}</td>
                        <td>
                          <div class="dropdown">
                              <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @if($appointment->consultation)
                                <a href="/consultations/{{$appointment->consultation->id}}" class="text-decoration-none"><button class="dropdown-item"><i class="fas fa-notes-medical"></i> Ver</button></a>
                                @elseif (Auth::user()->admin)
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
  let appointmentsChart = null;

  window.onload = function() {
    // Array of days of month
    const days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
    const hours = ['12:00am-2:59am', '3:00am-5:59am', '6:00am-8:59am', '9:00am-11:59am', '12:00pm-2:59pm', '3:00pm-5:59pm', '6:00pm-8:59pm', '9:00pm-11:59pm'];
    const labels = "{{$dateState??'null'}}" == "null" || "{{$dateState??'null'}}" == 'Año'? _.range({{$statisticYear}}-2,{{$statisticYear}}+3) :
          "{{$dateState??'null'}}" == 'Mes'? days : hours;
    const data = {{ json_encode($data) }};

    /**
     * Making chart
     */
    const ctx = document.getElementById('chart-line');
    appointmentsChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: "{{$dateState??'Año'}} "+ ("{{$dateState??'null'}}" == 'Año'? "{{$statisticYear}}": "{{$statisticDate}}"),
          data,
          backgroundColor: 'rgba(157, 36, 73, 0.2)',
          borderColor: 'rgba(157, 36, 73, 1)',
          borderWidth: 2
        }]
      },
      options: {
        maintainAspectRatio: false,
        responsive: true
      }
    });

    /**
     * Creacion de la funcio del formulario
     */
     $("#inputDate").hide();
     $("#inputDate").attr("readonly",false);
     $("#statisticYear").hide();
     $("#statisticYear").attr("readonly",false);
     $('#dateState').change(function() {
          $("#inputDate").hide('fast');
          $("#statisticYear").hide('fast');
          $("#inputDate").val("");
          $("#statisticYear").val("");
          if (this.value==='Dia') {
              $("#inputDate").attr("type","date");
              $("#inputDate").show('fast');
          } else if(this.value==='Mes'){
              $("#inputDate").attr("type","month");
              $("#inputDate").show('fast');
          } else if(this.value==='Año'){
              $("#statisticYear").show('fast');
          }
      })
  };
</script>
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
  function dateForm(file) {
    $("#confirmModal").attr("action","{{URL::to('/')}}/appointments/"+file+"/report");
  }
</script>
@endpush