<div class="modal" id="mdl_enable" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Habilitar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Realmente desea habilitar al usuario <strong id="txt_name_e"></strong>?</p>
            </div>
            <div class="modal-footer">
                <form id="frm_enable" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-success">Habilitar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>