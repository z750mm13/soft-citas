@extends('layouts.app')

@section('content')
@include('medicines.form')
@include('medicines.delete')

<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="icon icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Medicamentos</li>
    </ol>
    <div class="vertical-buffer mb-5">
        <h1>San Juan Teponaxtla</h1>
        <h2 id="bienvenida">Medicamentos</h2>
        <hr class="red">
        <p>Apartado de control de medicamentos. En este apartado usted puede dar de alta a los medicamentos de la unidad rural ademas de modificarlos o eliminarlos.</p>
    </div>

    <div class="card mb-5 shadow">
        <div class="card-body p-0">
            <div class="row m-4 align-items-center">
                <div class="col-7">
                    <h5 class="card-title mb-0">Medicamentos</h5>
                </div>
                <div class="col-5 text-right">
                    <button type="button" data-toggle="modal" data-target="#medicineForm" data-title="Agregar" onclick="clearFields()" class="btn btn-sm btn-primary">Agregar medicamento</button>
                </div>
            </div>

            @if($medicines->count())
            <?php $index = 0; ?>
            <div class="table-responsive">
              <table class="table table-hover p-0 mb-0">
                  <thead class="thead-light">
                      <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Caducidad</th>
                        <th scope="col">Codigo de barras</th>
                        <th scope="col">Stock</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($medicines as $medicine)
                      <tr>
                        <th>{{$medicine->name}}</th>
                        <td>{{$medicine->expiration}}</td>
                        <td>{{$medicine->barcode}}</td>
                        <td>{{$medicine->stock}}</td>
                        <td>
                          <div class="dropdown">
                              <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button data-toggle="modal" data-target="#medicineForm" data-title="Editar" onclick="setValues({{$index}})" class="dropdown-item"><i class="fas fa-pen"></i> Editar</button>
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
                <h4>No se han registrado medicamentos</h4>
              </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
  let medicines = [
      @foreach($medicines as $medicine){
        "id":{{$medicine->id}},
        "name":"{{$medicine->name}}",
        "expiration":"{{$medicine->expiration}}",
        "barcode":"{{$medicine->barcode}}",
        "stock":{{$medicine->stock}}
      },
      @endforeach
  ];
  function setValues(id){
        $("#medicine").attr("action","{{ route('medicines.update',[0]) }}".slice(0, -1)+medicines[id].id);
        $("#name").val(medicines[id].name);
        $("#expiration").val(medicines[id].expiration);
        $("#barcode").val(medicines[id].barcode);
        $("#stock").val(medicines[id].stock);
        $("#method").val("PUT");
  }
  function clearFields(){
        $("#medicine").attr("action","{{ route('medicines.store') }}");
        $("#name").val("");
        $("#expiration").val("");
        $("#barcode").val("");
        $("#stock").val("");
        $("#method").val("POST");
  }
  function deleteElement(id) {
    $("#formDelete").attr("action","{{ route('medicines.destroy',[0]) }}".slice(0, -1)+medicines[id].id);
  }
</script>
@endpush