<div class="modal fade" id="ModalLoginForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Iniciar Sesión - <?= NAME_PROJECT; ?></h5>
        
      </div>
      <div class="modal-body">
        <form action="" id="formLogin" name="formLogin">
            <div id="notificationLogin"></div>
            <br>
            <div class="text-center mb-4">
                <center>
                    <img src="<?= MEDIA(); ?>images/icons/icon.ico" alt="" width="72" height="72">
                </center>
            </div><br>

            <div class="form">
                <div class="form-label-group mb-4">
                    <input type="text" id="InputUsername-email" name="InputUsername-email" class="btn-lg form-control login" placeholder="Username / email" required>
                </div><br>

                <div class="form-label-group mb-2">
                    <input type="password" id="InputPassword" name="InputPassword" class="btn-lg form-control login" placeholder="Password" required>
                </div><br>

                <center><a class="text-green" href="">¿Olvidaste tu contraseña?</a></center>
                <p class="mt-3 mb-5 text-muted text-center">&copy; <?= NAME_PROJECT ?> - 2021</p>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-green">Iniciar Sesión</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>