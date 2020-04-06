
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Error!</h4>
            <?php if (isset($error['username'])): ?>
                <div>- <?php echo $error['username']; ?></div>
            <?php endif; ?>
            <?php if (isset($error['name'])): ?>
                <div>- <?php echo $error['name']; ?></div>
            <?php endif; ?>
            <?php if (isset($error['email'])): ?>
                <div>- <?php echo $error['email']; ?></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (isset($tmp_success)): ?>
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Profil Berhasil diedit!</h4>
        </div>
        <?php endif; ?>


<h3>Edit Admin</h3>
   <br>

        <form method="post" role="form" class="needs-validation" action="" novalidate>
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $user->user_id; ?>"/>
                <label for="username">Username</label>
                <input type="text" class="form-control" value="<?php echo $user->username; ?>" id="username" name="username" required>
  
            </div>
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" value="<?php echo $user->name; ?>" id="name" name="nama" required>
     
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user->email; ?>" required>
       
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label></br>
                <input type="radio" name="jenkel" value="Laki-laki" ; <?php  if ($user->jenis_kelamin=='Laki-laki'){ echo "checked";} ?> >  Laki-laki &nbsp;&nbsp;
                <input type="radio" name="jenkel" value="Wanita"; <?php  if ($user->jenis_kelamin=='Wanita'){ echo "checked";}?> > Wanita
            </div>

            <!-- <div class="form-group">
                <label for="bio">Biografi</label>
                <textarea type="text" class="form-control" id="bio" name="bio" rows="5"><?php echo $user->bio; ?></textarea>
            </div>    -->

            <input type="submit" name="btn-editadmin" class="btn btn-primary btn-sm" value="Simpan"/>
            <a class="btn btn-warning btn-sm" href="<?php echo site_url('admin/admin_view')?>">Batal</a>
        </form>
  
