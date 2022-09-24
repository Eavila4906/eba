<!-- Modal -->
<div class="modal fade" id="ModalFormCurses" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header header-register" id="modal-header-curses">
        <h5 class="modal-title" id="title-modal-curses">Nuevo Curso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formCurses" name="formCurses">
                <input type="hidden" id="id_curses" name="id_curses" value="">
                <p class="text-primary">
                  Los campos con asterisco (<span class="required">*</span>) son obligatorios.
                </p>
                
                <div class="form-group">
                  <label id="labelNombreCurses" class="labelForm">Curso <span class="required">*</span></label>
                  <input class="form-control inputForm" name="InputCurses" id="InputCurses" type="text" placeholder="Ingresar Nombre del curso">
                  <p class="leyenda none-block text-danger" id="leyenda-nombreCurses">
                    <small> 
                      El nombre debe tener 1 o 25 caracteres, solo letras!
                    </small>
                  </p>
                </div>

                <div class="form-group">
                  <label id="labelCategoryCurses" class="labelForm">Categoria <span class="required">*</span></label>
                  <textarea class="form-control inputForm" name="InputCategory" id="InputCategory" cols="30" rows="2" placeholder="Ingrese categoria"></textarea>
                  <p class="leyenda none-block text-danger" id="leyenda-categorycurses">
                    <small> 
                      La descripcion debe tener 1 o 45 caracteres!
                    </small>
                  </p>
                </div>

                <div class="form-group">
                  <label id="labelDescripcionCurses" class="labelForm">Descripción <span class="required">*</span></label>
                  <textarea class="form-control inputForm" name="InputDescription" id="InputDescription" cols="30" rows="2" placeholder="Ingresar Descripción"></textarea>
                  <p class="leyenda none-block text-danger" id="leyenda-descripcionCurses">
                    <small> 
                      La descripcion debe tener 1 o 45 caracteres!
                    </small>
                  </p>
                </div>

                <div class="form-group">
                  <div class="form-group">
                    <label id="labelNewPass" class="">Fecha Inicio curso <span class="required">*</span></label>
                    <input class="form-control" type="date" name="InputFechaInicio" id="InputFechaInicio" required>
                    </div>
                  <div class="form-group">
                    <label id="labelConfirmPass" class="">Fecha final curso <span class="required">*</span></label>
                    <input class="form-control" type="date" name="InputFechaFinal" id="InputFechaFinal" required>
                  </div>
                </div><br>

                <div class="form-group">
                    <label id="labelValorCurses" class="labelForm">Valor del curso <span class="required">*</span></label>
                    <input class="form-control inputForm" name="InputValorCurses" id="InputValorCurses" type="number" placeholder="Ingresar valor del curso" required>
                    <p class="leyenda none-block text-danger" id="leyenda-Valor-TP">
                      <small> 
                        Ingresar un valor numerico valido.
                      </small>
                    </p>
                  </div>

                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn">Guardar</samp> 
                  </button>&nbsp;&nbsp;&nbsp;

                  <a class="btn btn-secondary" href="#" data-dismiss="modal">
                    <i class="fa fa-fw fa-lg fa-times-circle"></i>
                    Cancelar
                  </a>
                </div>
              </form>
            </div>
            
          </div>
        </div>
    </div>
  </div>
</div>