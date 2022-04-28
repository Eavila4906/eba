<div class="modal fade" id="ModalFormMsc" tabindex="-1" role="dialog" 
  aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-Msc header-register">
        <h5 class="modal-title" id="title-modal-Msc">Administrar estudiantes - <span id="my-content"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
        <div class="col-md-12">
          <div class="btn-group" role="group" aria-label="Basic example">
            <?php if ($_SESSION['permisosModulo']['w'] || $_SESSION['permisosModulo']['u']) { ?>
            <button type="button" class="btn btn-sm btn-success" title="Añadir alumnos" onclick="OpenAsc('.Dsc', '.Asc');">Añadir alumnos <i class="fas fa-user-plus fa-lg"></i></button>
            <?php } ?> 
            <?php if ($_SESSION['permisosModulo']['w'] || $_SESSION['permisosModulo']['u']) { ?>
            <button type="button" class="btn btn-sm btn-danger" title="Eliminar alumnos" onclick="OpenDsc('.Dsc', '.Asc');">Eliminar alumnos <i class="fas fa-user-times fa-lg"></i></button>
            <input type="hidden" id="id-my-content" value="">
            <?php } ?>
          </div>
          <div class="float-right text-right" style="margin-top: 5px;">
            <span><b>Inscritos: </b></span><span id="count-students"></span>
          </div>
        </div>
        

      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 Asc">
            <div class="tile">
              <h3 class="text-primary">Añadir estudiantes</h3>
              <div class="tile-body">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered" id="DataTableAsc" class="display" cellspacing="0" cellpadding="3" width="100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Cedula</th>
                        <th>Nombres</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 Dsc">
            <div class="tile">
              <h3 class="text-primary">Eliminar estudiantes</h3>
              <div class="tile-body">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered" id="DataTableDsc" class="display" cellspacing="0" cellpadding="3" width="100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Cedula</th>
                        <th>Nombres</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>