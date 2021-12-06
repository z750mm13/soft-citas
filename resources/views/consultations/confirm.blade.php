<div class="modal fade" id="confirmConsultation" tabindex="-1" role="dialog" aria-labelledby="deleteConsultationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConsultationLabel">Confirmar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ingrese la contraseña de la / (del) encargada(o)
                <form action="{{ route('appointments.destroy',[0]) }}" method="post" id="confirmModal">
                    @csrf
                    <input id="delForm" type="hidden" name="_method" value="DELETE">

                    <div class="form-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
                      </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" form="formDelete" class="btn btn-primary" >Aceptar</button>
            </div>
        </div>
    </div>
</div>