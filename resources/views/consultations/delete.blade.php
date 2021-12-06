<div class="modal fade" id="deleteConsultation" tabindex="-1" role="dialog" aria-labelledby="deleteConsultationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConsultationLabel">Eliminar cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Desea eliminar la cita seleccionada?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" data-dismiss="modal" onclick="$('#confirmConsultation').modal('show')" data-target="#confirmConsultation" class="btn btn-primary" >Eliminar</button>
            </div>
        </div>
    </div>
</div>
<form id="formDelete" action="{{ route('appointments.destroy',[0]) }}" id="delete-form" method="post" style="display:none">
    @csrf
    <input type="hidden" name="_method" value="delete">
</form>