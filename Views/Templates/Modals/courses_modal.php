<!-- Modal -->
<div class="modal fade" id="ModalFormCourse" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header header-register" id="modal-header-course">
        <h5 class="modal-title" id="title-modal-course">Nuevo Curso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formCourse" name="formCourse">
                <input type="hidden" id="id_course" name="id_course" value="">
                <p class="text-primary">
                  Los campos con asterisco (<span class="required">*</span>) son obligatorios.
                </p>
                
                <div class="row mb-4">
                  <div class="col-md-8">
                    <label id="labelNombreCourse" class="labelForm">Curso <span class="required">*</span></label>
                    <input class="form-control inputForm" name="InputCourse" id="InputCourse" type="text" placeholder="Ingresar Nombre del curso">
                    <p class="leyenda none-block text-danger" id="leyenda-nameCourse">
                      <small> 
                        El nombre debe tener 1 o 25 caracteres, solo letras!
                      </small>
                    </p>
                  </div>
                  <div class="col-md-4">
                    <label>Categoria <span class="required">*</span></label>
                    <select class="form-control category-register category-update" name="InputCategory" id="InputCategory" required>
                    </select>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-4">
                    <label id="labelNewPass" class="">Fecha Inicio curso <span class="required">*</span></label>
                    <input class="form-control" type="date" name="InputDateStart" id="InputDateStart" required>
                  </div>
                  <div class="col-md-4">
                    <label id="labelConfirmPass" class="">Fecha final curso <span class="required">*</span></label>
                    <input class="form-control" type="date" name="InputDateFinal" id="InputDateFinal" required>
                  </div>
                  <div class="col-md-4">
                    <label id="labelValorCourse" class="labelForm">Valor del curso <span class="required">*</span></label>
                    <input class="form-control inputForm" name="InputValueCourse" id="InputValueCourse" type="text" placeholder="Ingresar valor del curso" required>
                    <p class="leyenda none-block text-danger" id="leyenda-Valor-Course">
                      <small> 
                        Ingresar un valor numerico valido.
                      </small>
                    </p>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-8">
                    <label id="labelDescripcionCourse" class="labelForm">Descripción <span class="required">*</span></label>
                    <textarea class="form-control inputForm" name="InputDescription" id="InputDescription" cols="30" rows="2" placeholder="Ingresar Descripción"></textarea>
                    <p class="leyenda none-block text-danger" id="leyenda-descripcionCourse">
                      <small> 
                        La descripcion debe tener 1 o 45 caracteres!
                      </small>
                    </p>
                  </div>
                  <div class="col-md-4">
                    <label class="control-label">Estado <span class="required">*</span></label>
                    <select class="form-control" name="InputStatus" id="InputStatus">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                  </div>
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