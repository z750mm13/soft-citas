<div class="modal fade" id="medicineForm" tabindex="-1" role="dialog" aria-labelledby="medicineForm" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="medicineFormLabel">Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="medicine" method="POST" action="{{ route('medicines.store') }}">
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
                        <label for="expiration" class="col-md-4 col-form-label text-md-right">{{ __('Caducidad') }}</label>
                        <div class="col-md-6">
                            <input id="expiration" type="date" class="form-control @error('expiration') is-invalid @enderror" name="expiration" value="{{ old('expiration') }}" required autocomplete="expiration" autofocus>
                            @error('expiration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="barcode" class="col-md-4 col-form-label text-md-right">{{ __('Codigo de barras') }}</label>
                        <div class="col-md-6">
                            <input id="barcode" type="number" class="form-control @error('barcode') is-invalid @enderror" name="barcode" value="{{ old('barcode') }}" required autocomplete="barcode" autofocus>
                            @error('barcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="stock" class="col-md-4 col-form-label text-md-right">{{ __('En existencia') }}</label>

                        <div class="col-md-6">
                            <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock') }}" required autocomplete="stock" autofocus>

                            @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="details" class="col-md-4 col-form-label text-md-right">Descripción</label>
                        <div class="col-md-6">
                            <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="3" value="{{ old('details') }}" required autocomplete="details" autofocus></textarea>
                            @error('details')
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
                <button type="submit" form="medicine" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script >
document.body.onload = function() {
    $('#medicineForm').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('title') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text(recipient + ' medicamento')
    });
}
</script>
@endpush