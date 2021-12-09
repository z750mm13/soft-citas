@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="icon icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('consultations.index') }}">Consultas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar consulta</li>
    </ol>
    <div class="vertical-buffer mb-5">
        <h1>San Juan Teponaxtla</h1>
        <h2>Editar consulta</h2>
        <hr class="red">
    </div>

    <div class="card mb-5 shadow">
        <div class="card-header">
          <h4 class="card-title">Consulta</h4>
        </div>
        <div class="card-body mx-4">

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

            <form method="POST" action="{{ route('consultations.update',[$consultation]) }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="appointment_id" value="{{$consultation->appointment_id}}">

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus rows="3">{{$consultation->description}}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <small id="emailHelp" class="form-text text-muted">Redacte la descripcion de la consulta.</small>
                </div>
                
                <div class="vertical-buffer mb-5">
                    <h4 class="mt-0">Receta</h4>
                    <hr class="red">
                </div>
  
                <div id="medicamentos">
                    <?php $id = 0; ?>
                    @forelse($consultation->prescriptions as $prescription)
                    <div class="form-group" id="card{{$id}}">
                        <div class="card">
                            <div class="card-body mx-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <label for="nf">Medicamento</label>
                                    </div>
                                    <div>
                                        <button type="button" class="close" onclick="deleteCard({{$id}})">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 col-sm-12 mb-4">
                                        <label for="inputState">Presentación</label>
                                        <select class="form-control" name="medicamentos[]">
                                            <option value="{{$prescription->medicine->id}}" selected>* {{$prescription->medicine->name}}</option>
                                            <option value="null">Selecicone el medicamento</option>
                                            @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                            @endforeach
                                        </select>                                                                                 
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label for="inputCity">Dosis</label>
                                        <input type="text" id="inputCity" name="dosis[]" class="form-control" value="{{ $prescription->dose }}">
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <label for="inputZip">Indicaciones</label>
                                        <input type="text" id="inputZip" name="indicaciones[]" class="form-control" value="{{ $prescription->description }}">
                                    </div>
                                    <input type="text" name="ids[]" value="{{ $prescription->id }}" class="form-control" style="visibility:hidden;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $id++; ?>
                    @empty
                    <div class="form-group" id="card0">
                        <div class="card">
                            <div class="card-body mx-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <label for="nf">Medicamento</label>
                                    </div>
                                    <div>
                                        <button type="button" class="close" onclick="deleteCard(0)">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 col-sm-12 mb-4">
                                        <label for="inputState">Presentación</label>
                                        <select class="form-control" name="medicamentos[]">
                                            <option value="null" selected>Selecicone el medicamento</option>
                                            @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                            @endforeach
                                        </select>                                                                                 
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label for="inputCity">Dosis</label>
                                        <input type="text" id="inputCity" name="dosis[]" class="form-control">
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <label for="inputZip">Indicaciones</label>
                                        <input type="text" id="inputZip" name="indicaciones[]" class="form-control">
                                    </div>
                                    <input type="text" name="ids[]" class="form-control" style="visibility:hidden;">
                                </div>
                            </div>
                        </div>
                    </div
                    <?php $id++; ?>
                    @endforelse
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <a class="col-md-12 btn btn-light btn-lg" id="clone" role="button"><i class="fas fa-plus"></i></a>
                    </div>

                    <div class="alert alert-info col-12">
                        <strong>Aviso</strong>
                        <p>En caso de dejar el <b>medicamento</b> sin seleccionar la fila <b>no se tomará en cuenta</b>, en caso que haya estado en la receta se <b>eliminará</b>.</p>
                    </div>

                    <div class="form-group col-12">
                      <input type="submit"  class="btn btn-primary" name="submit"  value="Guardar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
  var preguntaid = 1;
  var tipoid = 2;
  var forid = 1;
  var card = {{$id}};
  document.body.onload = function() {
    $("#clone").click(function () {
      // Clona peligos
      var $clone = $('#medicamentos .form-group').last().clone();
      // Borra los valores de los inputs clonados
      $clone.find(':input').each(function () {
        if (this.type == 'radio'){
          this.id = 'tipo'+tipoid;
          this.name = 'pregunta'+preguntaid;
          tipoid++;
        }  else
            this.value = null;
      }).end().find('label').each(function () {
        $(this).attr('for', function (index, old) {
          if(old != 'nf'){
            forid++;
            return 'tipo'+forid;
          }
          return old;
        })
      }).end().find('button').each(function () {
        $(this).attr('onclick', function (index, old) {
          if(old.match(/deleteCard.*/)){
            return 'deleteCard('+card+')';
          }
          return old;
        })
      });
      $clone.attr('id','card'+card);
      card++;
      console.log($clone.find(':input'));

      // Añade el clon
      preguntaid++;
      $clone.hide();
      $clone.appendTo('#medicamentos');
      $clone.show('fast');
    });
  }
function deleteCard(card) {
    if(card != 0)
    $('#card'+card).hide('fast', function(){ $('#card'+card).remove(); });
}
</script>
@endpush
