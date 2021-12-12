<div class="modal fade" id="patientForm" tabindex="-1" role="dialog" aria-labelledby="patientForm" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientFormLabel">Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="patient" method="POST" action="{{ route('patients.store') }}">
                    @csrf
                    <input id="method" type="hidden" name="_method" value="POST">

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Apellido paterno') }}</label>
                        <div class="col-md-6">
                            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="postlastname" class="col-md-4 col-form-label text-md-right">{{ __('Apellido materno') }}</label>
                        <div class="col-md-6">
                            <input id="postlastname" type="text" class="form-control @error('postlastname') is-invalid @enderror" name="postlastname" value="{{ old('postlastname') }}" required autocomplete="postlastname" autofocus>
                            @error('postlastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="size" class="col-md-4 col-form-label text-md-right">{{ __('Estatura (en centimetros)') }}</label>

                        <div class="col-md-6">
                            <input id="size" onchange="setImc()" type="number" class="form-control" name="size" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="weight" class="col-md-4 col-form-label text-md-right">{{ __('Peso (en Kilogramos)') }}</label>

                        <div class="col-md-6">
                            <input id="weight" onchange="setImc()" step="any" type="number" class="form-control" name="weight" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Genero') }}</label>

                        <div class="col-md-6">
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="null">Seleccione el genero</option>
                                <option>Femenino</option>
                                <option>Masculino</option>
                            </select>

                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Edad') }}</label>

                        <div class="col-md-6">
                            <input id="age" type="number" class="form-control @error('age') is-invalid @enderror" name="age" required>

                            @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>

                        <div class="col-md-6">
                            <input id="address" type="text" class="form-control" name="address" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="imc" step="any" class="col-md-4 col-form-label text-md-right">{{ __('IMC') }}</label>

                        <div class="col-md-6">
                            <input id="imc" step="any" readonly type="number" class="form-control" name="imc" required>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="patient" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.body.onload = function() {
    $('#patientForm').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('title') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text(recipient + ' paciente')
    });
}
</script>
@endpush