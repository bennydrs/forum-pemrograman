
  

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
  

  <h3>Tambah Admin</h3>
  <hr>
  <form method="post" >
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" class="form-control" aria-describedby="username" required pattern="[a-zA-Z0-9-_.]{5,12}$">
      <small id="username" class="form-text text-muted">
        username minimal 5 karakter tanpa spasi.
      </small>
    </div>
    <div class="form-group">
      <label for="nama">Nama</label>
      <input type="text" name="nama" id="nama" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" class="form-control" required>
   
    </div>
    <div class="form-group">
      <label for="pass">Password</label>
      <input type="password" name="password" id="pass" class="form-control" aria-describedby="password" required>
      <small id="password" class="form-text text-muted">
        password minimal 5 karakter.
      </small>
    </div>
    <div class="form-group">
      <label for="pass2">Konfirmasi Password</label>
      <input type="password" name="password2" id="pass2" class="form-control" required>

    </div>
    <div class="form-group">
      <label>Jenis Kelamin</label>
      <div class="form-group">
        
          <input class="form-check-input" type="radio" name="jenkel" value="Laki-laki" id="laki" required> 
          <label class="form-check-label" for="laki">Laki-laki</label>
       
            <input class="form-check-input" type="radio" name="jenkel" value="Wanita" id="wanita"> 
            <label class="form-check-label" for="wanita">Wanita</label> 
          
 
       
      </div>
    </div>
      <input type="hidden" name="date_join" value="<?php echo date('Y-m-d'); ?>"/>  
      <input type="submit" style="margin-top:15px;" name="btn-admin" class="btn btn-primary btn-md" value="Simpan"/>
  </form>


 

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


