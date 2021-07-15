<div class="modal fade" id="ModalSubirFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-modal">Actualizar foto de perfil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="tile-body">
              <form id="formActualizarFoto" name="formActualizarFoto">
                <input type="hidden" id="id_userSession" name="id_userSession" value="<?=$_SESSION['dataUser']['id_usuario'];?>">
                <input type="hidden" id="photo_actual" name="photo_actual" value="">
                <input type="hidden" id="photo_remove" name="photo_remove" value="0">
                <div class="photo">
                  <div class="prevPhotoProfile" title="Subir foto">
                    <span class="delPhotoProfile notBlock" title="Eliminar foto">
                      <i class="fas fa-trash-alt"></i>
                    </span>
                    <label for="image"></label>
                    <div>
                      <img id="img" src="">
                    </div>
                    <div class="upimg">
                      <input type="file" name="image" id="image">
                    </div>
                  </div>
                  <br>
                  <div id="form_alert"></div>
                </div>
                

                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="btn-action-form">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i> 
                    <samp id="text-btn">Guardar</samp> 
                  </button>&nbsp;&nbsp;&nbsp;

                  <a class="btn btn-secondary" href="#" data-dismiss="modal">
                    <i class="fa fa-fw fa-lg fa-times-circle"></i>
                    Cerrar
                  </a>
                </div>
              </form>
            </div>
            
          </div>
        </div>
    </div>
  </div>
</div>