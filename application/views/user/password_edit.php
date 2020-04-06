
<div class="card mt-5">
    <div class="card-header">
        <h5 class="text-center">Ganti Password</h5>
    </div>
    <div class="card-body">
        <form class="needs-validation" method="post" action="" novalidate>
            <!-- <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <a class="close" data-dismiss="alert" href="#">&times;</a>
                <h4 class="alert-heading">Error!</h4>
                <?php if (isset($error['old_password'])): ?>
                    <div>- <?php echo $error['old_password']; ?></div>
                <?php endif; ?>
                <?php if (isset($error['password'])): ?>
                    <div>- <?php echo $error['password']; ?></div>
                <?php endif; ?>
                <?php if (isset($error['password2'])): ?>
                    <div>- <?php echo $error['password2']; ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?> -->
                
            <?php if($this->session->flashdata('error')){ ?>
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert" href="#">&times;</a>
                
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
        
            <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>"/>
                <label class="control-label" for="input01">Username</label>
                <div class="controls">
                    <input type="text" class="form-control" disabled="disabled" value="<?php echo $user->username; ?>" id="name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="pass">Password Lama</label>
                    <input type="password" class="form-control" id="pass" name="old" required>
                    <div class="invalid-feedback">
                        password lama kosong.
                    </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="pass">Password Baru</label>
                    <input type="password" class="form-control" id="pass" name="password" required>
                    <div class="invalid-feedback">
                        password baru kosong.
                    </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="kpass">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="kpas" name="password2" required>
                    <div class="invalid-feedback">
                        konfirmasi password kosong.
                    </div>
            </div>
                <br>
                <input type="submit" name="btn-save" class="btn btn-primary btn-sm" value="Simpan"/>
                <a class="btn btn-warning btn-sm" href="<?php echo site_url('profil_member/profil').'/'.$user->user_id; ?>">Batal</a>
        </form>
    </div>
</div>

    
