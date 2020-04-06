
  <?php if (isset($tmp_success)): ?>
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <label class="alert-heading">Akun berhasil dibuat! <a href="<?php echo site_url('user/login'); ?>"> Login disini</a></label>
    </div>
  <?php endif; ?>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger">
      <a class="close" data-dismiss="alert" href="#">&times;</a>
      <h4 class="alert-heading">Error!</h4>
      <?php if (isset($error['username'])): ?>
          <div> <?php echo $error['username']; ?></div>
      <?php endif; ?>
      <?php if (isset($error['nama'])): ?>
          <div> <?php echo $error['nama']; ?></div>
      <?php endif; ?>
      <?php if (isset($error['password'])): ?>
          <div> <?php echo $error['password']; ?></div>
      <?php endif; ?>
      <?php if (isset($error['email'])): ?>
          <div> <?php echo $error['email']; ?></div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

<div class="row">
  <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2">
    <div class="card">
      <div class="card-body">
        <h3 class="thin text-center">Daftar</h3>
        <hr>
        <form class="needs-validation" method="post" novalidate>
          <div class="form-group">
            <label for="username">Username</label>
            <?php echo form_error('username'); ?>
            <input type="text" name="username" id="username" class="form-control" aria-describedby="username" required pattern="[a-zA-Z0-9-_.]{5,12}$" value="<?php echo set_value('username'); ?>">
            <small id="username" class="form-text text-muted">
              username minimal 5 karakter tanpa spasi.
            </small>
            <div class="invalid-feedback">
                username harus diisi dan tanpa spasi.
            </div>
          </div>
          <div class="form-group">
            <label for="nama">Nama</label>
            <?php echo form_error('nama'); ?>
            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo set_value('nama'); ?>" required>
            <div class="invalid-feedback">
                nama harus diisi.
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <?php echo form_error('email'); ?>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>" required>
            <div class="invalid-feedback">
                email salah atau kosong.
            </div>
          </div>
          <div class="form-group">
            <label for="pass">Password</label>
            <input type="password" name="password" id="pass" class="form-control" aria-describedby="password" required>
            <small id="password" class="form-text text-muted">
              password minimal 5 karakter.
            </small>
            <div class="invalid-feedback">
                password harus diisi.
            </div>
          </div>
          <div class="form-group">
            <label for="pass2">Konfirmasi Password</label>
            <input type="password" name="password2" id="pass2" class="form-control" required>
            <div class="invalid-feedback">
                konfirmasi password harus diisi.
            </div>
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
            <div class="form-row">
              <div class="form-check ml-2">
                <input class="form-check-input" type="radio" name="jenkel" value="Laki-laki" id="laki" required> 
                <label class="form-check-label" for="laki">Laki-laki</label>
              </div> 
              <div class="col-auto">
                <div class="form-check ml-2">
                  <input class="form-check-input" type="radio" name="jenkel" value="Wanita" id="wanita"> 
                  <label class="form-check-label" for="wanita">Wanita</label> 
                </div>
                <div class="invalid-feedback">
                  jenis kelamin harus diisi.
                </div>
              </div>
            </div>
          </div>
            <input type="hidden" name="date_join" value="<?php echo date('Y-m-d'); ?>"/>  
            <input type="submit" style="margin-top:15px;" name="btn-reg" class="btn btn-primary btn-md" value="Daftar Akun"/>
        </form>
        <br><p class="text-center text-muted">Sudah punya akun? <a class="brand" href="<?php echo site_url('user/login'); ?>"> Login disini</a></p>
      </div>
    </div>
  </div>
</div>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>


<style>
  body{
    background-color:#eee;
    margin-top: 80px;
  }
</style>
