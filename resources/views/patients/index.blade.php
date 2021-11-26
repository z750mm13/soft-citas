@extends('layouts.app')

@section('content')
@include('patients.form')
@include('patients.delete')

<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="icon icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pacientes</li>
    </ol>
    <div class="vertical-buffer mb-5">
        <h1>San Juan Teponaxtla</h1>
        <h2 id="bienvenida">Pacientes</h2>
        <hr class="red">
        <p>Apartado de control de pacientes. En este apartado usted puede dar de alta a los pacientes de la unidad rural ademas de modificarlos o eliminarlos.</p>
    </div>

    <div class="card mb-5 shadow">
        <div class="card-body p-0">
            <div class="row m-4 align-items-center">
                <div class="col-7">
                    <h5 class="card-title mb-0">Pacientes</h5>
                </div>
                <div class="col-5 text-right">
                    <button type="button" data-toggle="modal" data-target="#patientForm" data-title="Agregar" onclick="clear()" class="btn btn-sm btn-primary">Agregar paciente</button>
                </div>
            </div>

            @if($patients->count())
            <?php $index = 0; ?>
            <div class="table-responsive">
              <table class="table table-hover p-0 mb-0">
                  <thead class="thead-light">
                      <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido paterno</th>
                        <th scope="col">Apellido materno</th>
                        <th scope="col">Sexo</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($patients as $patient)
                      <tr>
                        <th>{{$patient->name}}</th>
                        <td>{{$patient->lastname}}</td>
                        <td>{{$patient->postlastname}}</td>
                        <td>{{$patient->gender}}</td>
                        <td>
                          <div class="dropdown">
                              <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button data-toggle="modal" data-target="#patientForm" data-title="Editar" onclick="setValues({{$index}})" class="dropdown-item"><i class="fas fa-pen"></i> Editar</button>
                                <button data-toggle="modal" data-target="#deletePatient" class="dropdown-item" onclick="deleteElement({{$index}})"><i class="fas fa-trash-alt"></i> Eliminar</button>
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
                <h4>No se han registrado pacientes</h4>
              </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
  let patients = [
      @foreach($patients as $patient){
        "id":{{$patient->id}},
        "name":"{{$patient->name}}",
        "lastname":"{{$patient->lastname}}",
        "postlastname":"{{$patient->postlastname}}",
        "gender":"{{$patient->gender}}",
        "age":{{$patient->age}},
        "address":"{{$patient->address}}",
        "weight":{{$patient->weight}},
        "size":{{$patient->size}},
        "imc":{{$patient->imc}},
      },
      @endforeach
  ];
  function setValues(id){
        $("#patient").attr("action","{{ route('patients.update',[0]) }}".slice(0, -1)+patients[id].id);
        $("#name").val(patients[id].name);
        $("#lastname").val(patients[id].lastname);
        $("#postlastname").val(patients[id].postlastname);
        $("#gender").val(patients[id].gender);
        $("#age").val(patients[id].age);
        $("#address").val(patients[id].address);
        $("#weight").val(patients[id].weight);
        $("#size").val(patients[id].size);
        $("#imc").val(patients[id].imc);
        $("#method").val("PUT");
  }
  function clear(){
        $("#patient").attr("action","{{ route('patients.store') }}");
        $("#name").val("");
        $("#lastname").val("");
        $("#postlastname").val("");
        $("#gender").val("");
        $("#age").val("");
        $("#address").val("");
        $("#weight").val("");
        $("#size").val("");
        $("#imc").val("");
        $("#method").val("POST");
  }
  function deleteElement(id) {
    $("#formDelete").attr("action","{{ route('patients.destroy',[0]) }}".slice(0, -1)+patients[id].id);
  }
</script>
@endpush