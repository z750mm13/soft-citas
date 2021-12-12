<div class="modal fade" id="confirmAppoiment" tabindex="-1" role="dialog" aria-labelledby="fileAppoimentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileAppoimentLabel">Confirmar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('appointments.report',['pdf'])}}" method="GET" id="confirmModal">
                    @csrf
                    @method('GET')

                    <div class="form-group">
                        <label for="datatype">Tipo de consulta</label>
                        <select class="form-control" id="datatype">
                            <option selected>Seleccione el tipo</option>
                            <option>Dia</option>
                            <option>Semana</option>
                            <option>Mes</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="dataDate">Fecha</label>
                      <input type="date" class="form-control" id="dataDate" name="date" aria-describedby="dateHelp">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" form="confirmModal" class="btn btn-primary" >Aceptar</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.body.onload = function() {
    $('#datatype').change(function() {
        $("#dataDate").hide('fast');
        $("#dataDate").val("");
        if (this.value==='Dia') {
            $("#dataDate").attr("type","date");
            $("#dataDate").show('fast');
        } else if(this.value==='Semana'){
            $("#dataDate").attr("type","week");
            $("#dataDate").show('fast');
        } else if(this.value==='Mes'){
            $("#dataDate").attr("type","month");
            $("#dataDate").show('fast');
        }
    })
}
</script>
@endpush