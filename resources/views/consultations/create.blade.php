@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="icon icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('consultations.index') }}">Consultas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Crear consulta</li>
    </ol>
    <div class="vertical-buffer mb-5">
        <h1>San Juan Teponaxtla</h1>
        <h2>Realizar consulta</h2>
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
                    <p class="card-text">{{$appointment->user->name. ' ' .$appointment->user->lastname}}</p>
                </div>
                <div>
                    <h5 class="card-title mt-1">Paciente</h5>
                    <p class="card-text">{{$appointment->patient->name. ' ' .$appointment->patient->lastname}}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('consultations.store') }}">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="appointment_id" value="{{$appointment_id}}">

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus rows="3"></textarea>
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
  
                <div id="peligros">
                    <div class="form-group" id="card0">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <label for="nf">Peligro:</label>
                                    </div>
                                    <div>
                                        <button type="button" class="close" onclick="deleteCard(0)">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <input type="text" name="peligros[]" class="form-control" placeholder="Peligro">
                                <label for="nf">Tipo:</label>
                                <br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="tipo0" name="pregunta0" class="custom-control-input" value="Seguridad">
                                    <label type="rlabel" class="custom-control-label" for="tipo0">Seguridad</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="tipo1" name="pregunta0" class="custom-control-input" value="Salud">
                                    <label type="rlabel" class="custom-control-label label0" for="tipo1">Salud</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="form-group col-12">
                    <a class="col-md-12 btn btn-light btn-lg" id="clone" role="button"><i class="fas fa-plus"></i></a>
                </div>
                <br>
                <div class="form-group col-12">
                  <input type="submit"  class="btn btn-primary " name="submit"  value="Guardar">
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
  var card = 1;
  document.body.onload = function() {
    $("#clone").click(function () {
      // Clona peligos
      var $clone = $('#peligros .form-group').last().clone();
      // Borra los valores de los inputs clonados
      $clone.find(':input').each(function () {
        if (this.type == 'radio'){
          this.id = 'tipo'+tipoid;
          this.name = 'pregunta'+preguntaid;
          tipoid++;
        } else 
        this.value = '';
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

      // Añade el clon
      preguntaid++;
      $clone.appendTo('#peligros');
    });
  }
function deleteCard(card) {
    if(card != 0)
    $('#card'+card).remove();
}
</script>
@endpush