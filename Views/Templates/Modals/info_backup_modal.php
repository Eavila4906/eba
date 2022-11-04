<div class="modal fade" id="ModalInfoBackup" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-infoBackup">
        <h5 class="modal-title" id="title-modal"></i>Backup / <spam id="getTitleBackup"></spam></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td style="width: 200px"><b>ID</b></td>
              <td id="getIdBackup"></td>
            </tr>
            <tr>
              <td style="width: 200px"><b>Nombre del archivo</b></td>
              <td id="getNameFile"></td>
            </tr>
            <tr>
              <td style="width: 200px"><b>Creado por</b></td>
              <td id="getCreateBy"></td>
            </tr>
            <tr>
              <td style="width: 200px"><b>Fecha de creacion</b></td>
              <td id="getCreationDate"></td>
            </tr>
            <tr id="tr-file">
              <td style="width: 200px"><b>Archivo</b></td>
              <td id="file"></td>
            </tr>
            <tr id="tr-getEliminatedBy">
              <td style="width: 150px"><b>Eliminado por</b></td>
              <td id="getEliminatedBy"></td>
            </tr>
            <tr id="tr-getRemovalDate">
              <td style="width: 150px"><b>Fecha de eliminacion</b></td>
              <td id="getRemovalDate"></td>
            </tr>
            <tr>
              <td style="width: 150px"><b>Estado</b></td>
              <td id="getStatus"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>