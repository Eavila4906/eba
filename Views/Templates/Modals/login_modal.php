<div class="modal fade" id="ModalLoginForm" tabindex="-1" role="dialog" 
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Log in - <?= NAME_PROJECT; ?></h5>
        
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
                    <input type="text" id="InputUsername-email" name="InputUsername-email" class="btn-lg form-control login" placeholder="Username / email" required="required field">
                </div><br>

                <div class="form-label-group mb-2">
                    <input type="password" id="InputPassword" name="InputPassword" class="btn-lg form-control login" placeholder="Password" required="required field">
                </div><br>

                <center><a class="text-green" href="<?=BASE_URL();?>login/reset_password">Did you forget your password?</a></center>
                <p class="mt-3 mb-5 text-muted text-center">&copy; <?= NAME_PROJECT ?> - 2021</p>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-green">Log in</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>