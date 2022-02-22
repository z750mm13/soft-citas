@extends('layouts.app')
<?php use Carbon\Carbon; ?>
@include('consultations.delete')
@include('consultations.confirm')
@include('consultations.date')

@section('content')

<div class="container">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/"><i class="icon icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="consultation_id">Consulta</li>
  </ol>
  <div class="vertical-buffer mb-5">
    <h1>San Juan Teponaxtla</h1>
    <h2 id="bienvenida">Recetas</h2>
    <hr class="red">
    <p>Apartado de control de recetas. En este apartado usted puede modificar o eliminar las recetas.</p>
  </div>

  <div class="form-group">
    <a class="btn btn-primary btn-sm" href="#" onclick="dateForm('pdf')" role="button" data-toggle="modal" data-target="#generateDoc"><i class="far fa-file-pdf"></i> Generar PDF</a>
    <a class="btn btn-sm btn-default" href="#" onclick="dateForm('excel')" role="button" data-toggle="modal" data-target="#generateDoc"><i class="far fa-file-excel"></i> Generar Excel</a>
  </div>

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
            <form action="{{route('consultations.index')}}" method="GET" id="updateChar">
              @csrf
              @method('GET')
              <div class="form-group">
                  <label for="dateState">Ver consultas por</label>
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
              <h5 class="card-title mb-0">Consultas</h5>
            </div>

            @if($consultations->count())
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
                      @foreach($consultations as $consultation)
                      <tr>
                        <th>{{$consultation->appointment->type}}</th>
                        <td>{{$consultation->appointment->patient->name.' '.$consultation->appointment->patient->lastname}}</td>
                        <td>{{$consultation->appointment->user->name.' '.$consultation->appointment->user->lastname}}</td>
                        <td>{{$consultation->created_at->format('d-m-Y g:i A')}}</td>
                        <td>
                          <div class="dropdown">
                              <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="/consultations/{{$consultation->id}}" class="text-decoration-none"><button class="dropdown-item"><i class="fas fa-notes-medical"></i> Ver</button></a>
                                <button data-toggle="modal" data-target="#confirmConsultation" data-title="Editar" onclick="editElement({{$index}})" class="dropdown-item"><i class="fas fa-pen"></i> Editar <sup class="text-muted"><i class="fas fa-lock"></i></sup></button>
                                <button data-toggle="modal" data-target="#deleteConsultation" class="dropdown-item" onclick="deleteElement({{$index}})"><i class="fas fa-trash-alt"></i> Eliminar <sup class="text-muted"><i class="fas fa-lock"></i></sup></button>
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
                <h4>No se han registrado consultas</h4>
              </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
  let consultationsChart = null;

  window.onload = function() {
    // Array of days of month
    const days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
    const hours = ['12:00am-2:59am', '3:00am-5:59am', '6:00am-8:59am', '9:00am-11:59am', '12:00pm-2:59pm', '3:00pm-5:59pm', '6:00pm-8:59pm', '9:00pm-11:59pm'];
    const labels = "{{$dateState??'null'}}" == "null" || "{{$dateState??'null'}}" == 'Año'? _.range({{$statisticYear}}-2,{{$statisticYear}}+3) :
          "{{$dateState??'null'}}" == 'Mes'? days : hours;
    const data = {{ json_encode($data) }};

    /**
     * Making chart
     */
    const ctx = document.getElementById('chart-line');
    consultationsChart = new Chart(ctx, {
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
  let consultations = [
      @foreach($consultations as $consultation){
        "id":{{$consultation->id}}
      },
      @endforeach
  ];
  let len = (uri) =>{k=j=0;for(let i=uri.length-1;i>=0;i--){k--;if(uri.charAt(i)=='/')j++;if(j==2)return k+1}};
  function editElement(id) {
    $("#confirmModal").attr("action","{{URL::to('/')}}/consultations/"+consultations[id].id+'/edit');
    $("#confirmModal").attr("method","POST");
    $("#methForm").val('POST');
  }
  function deleteElement(id) {
    $("#confirmModal").attr("action","{{URL::to('/')}}/consultations/"+consultations[id].id);
    $("#confirmModal").attr("method","POST");
    $("#methForm").val('DELETE');
  }
  function dateForm(file) {
    $("#confirmDoc").attr("action","{{URL::to('/')}}/consultations/"+file+"/report");
  }
</script>
@endpush