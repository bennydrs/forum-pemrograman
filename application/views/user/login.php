
  <?php if($this->session->flashdata('msg')){ ?>
      <div class="alert alert-danger">
          <a class="close" data-dismiss="alert" href="#">&times;</a>
      
          <?php echo $this->session->flashdata('msg'); ?>
      </div>
  <?php } ?>


  <div class="row">
  <!-- Article main content -->
    <br>
    <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2">
      <div class="card">
        <div class="card-body">
          <h3 class="thin text-center">Login Akun</h3>
          <p class="text-center text-muted">Anda belum punya akun? <a href="<?php echo site_url('user/join'); ?>">Daftar disini</a></p>
          <hr>

          <form class="needs-validation" method="post" novalidate>
            <div class="form-group">
              <label for="username">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" id="username" value="<?php echo set_value('username');?>" class="form-control" required>
              <div class="invalid-feedback">
                username kosong.
              </div>
            </div>
            <div class="form-group">
              <label for="name">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" id="name"  class="form-control" required>
              <div class="invalid-feedback">
                password kosong.
              </div>
            </div>

            <hr>         
              <div class="text-right">
                <input type="submit" id="sendMessageButton"  name="btn-login" class="btn btn-primary btn-large" value="Login"/>
              </div>
            
          </form>
        </div>
      </div>
    </div>

</div>



<style>
  body{
    background-color:#eee;
    margin-top: 100px;
  }
</style>
