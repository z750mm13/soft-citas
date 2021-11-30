<div class="modal fade" id="appointmentForm" tabindex="-1" role="dialog" aria-labelledby="appointmentForm" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentFormLabel">Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="appointment" method="POST" action="{{ route('appointments.store') }}">
                    @csrf
                    <input id="method" type="hidden" name="_method" value="POST">

                    <div class="form-group row">
                        <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de consulta') }}</label>
                        <div class="col-md-6">
                            <input id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required autocomplete="type" autofocus>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion de consulta') }}</label>
                        <div class="col-md-6">
                            <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row" id="patient">
                        <label for="patient_id" class="col-md-4 col-form-label text-md-right">{{ __('Paciente') }}</label>
                        <div class="col-md-6">

                            <select class="form-control @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id">
                                <option value="">Seleccione al paciente</option>
                                @foreach($patients as $patient)
                                <option value="{{$patient->id}}">{{$patient->name.' '.$patient->lastname}}</option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row" id="user">
                        <label for="user_id" class="col-md-4 col-form-label text-md-right">{{ __('Encargada(o)') }}</label>
                        <div class="col-md-6">
                            
                            <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                                <option value="">Seleccione al encargada(o)</option>
                                @foreach($doctors as $doctor)
                                <option value="{{$doctor->id}}">{{$doctor->name.' '.$doctor->lastname}}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="datetime" class="col-md-4 col-form-label text-md-right">{{ __('Hora y fecha') }}</label>

                        <div class="col-md-6">
                            <input id="datetime" type="datetime-local" class="form-control @error('datetime') is-invalid @enderror" name="datetime" required>

                            @error('datetime')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="appointment" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.body.onload = function() {
    $('#spatient_id').val('{{$patient_id}}');
    $('#suser_id').val('{{$user_id}}');
    $('#sdate').val('{{$date}}');
    $('#appointmentForm').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('title') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text(recipient + ' cita')
    });
}
</script>
@endpush