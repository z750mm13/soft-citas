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

    <div class="card mb-5">
        <div class="card-body p-0">
            <div class="row m-4 align-items-center">
                <div class="col-7">
                    <h5 class="card-title mb-0">Pacientes</h5>
                </div>
                <div class="col-5 text-right">
                    <button type="button" data-toggle="modal" data-target="#patientForm" data-title="Agregar" class="btn btn-sm btn-primary">Agregar paciente</button>
                </div>
            </div>

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
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>
                          <div class="dropdown">
                              <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button data-toggle="modal" data-target="#patientForm" data-title="Editar"class="dropdown-item"><i class="fas fa-pen"></i> Editar</button>
                                <button data-toggle="modal" data-target="#deletePatient" class="dropdown-item"><i class="fas fa-trash-alt"></i> Eliminar</button>
                              </div>
                            </div>
                        </td>
                      </tr>
                    </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
@endsection