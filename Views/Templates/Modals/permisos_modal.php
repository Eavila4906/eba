<div class="modal fade " id="ModalPermisosRoles" tabindex="-1" role="dialog" 
  aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Permisos del rol de usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form name="formPermisos" id="formPermisos">
          <input type="hidden" id="id_rol" name="id_rol" value="<?= $data['id_rol']; ?>">
          <div class="col-md-12">
            <div class="tile">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Modulo</th>
                      <th>Ver</th>
                      <th>Crear</th>
                      <th>Actualizar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $n = 1;
                      $modulos = $data['modulos'];

                      for ($i=0; $i < count($modulos); $i++) { 
                        $permisos = $modulos[$i]['permisos'];
                        $rChecks = $permisos['r'] == 1 ? " checked " : "";
                        $wChecks = $permisos['w'] == 1 ? " checked " : "";
                        $uChecks = $permisos['u'] == 1 ? " checked " : "";
                        $dChecks = $permisos['d'] == 1 ? " checked " : "";

                        $id_modulo = $modulos[$i]['id_modulo'];
                      
                    ?>
                    <tr>
                      <td>
                        <?= $n; ?>
                        <input type="hidden" name="modulos[<?= $i; ?>][id_modulo]" value="<?= $id_modulo; ?>">
                      </td>
                      <td>
                        <?= $modulos[$i]['nombreModulo']; ?>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?= $i; ?>][r]" <?= $rChecks; ?> ><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?= $i; ?>][w]" <?= $wChecks; ?> ><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?= $i; ?>][u]" <?= $uChecks; ?> ><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?= $i; ?>][d]" <?= $dChecks; ?> ><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                    </tr>
                    <?php
                        $n++;
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="text-center">
            <button class="btn btn-success" type="submit" id="btn-action-form">
              <i class="fa fa-fw fa-lg fa-check-circle"></i> 
              <samp>Guardar</samp> 
            </button>&nbsp;&nbsp;&nbsp;
            <a class="btn btn-warning" href="#" data-dismiss="modal">
              <i class="fa fa-fw fa-lg fas fa-arrow-alt-circle-left"></i>
              Salir
            </a>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>