<div class="page-header">
  <h3>Ubah Level Member</h3>
</div>

    <form method="post" action="">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Error!</h4>
            <?php if (isset($error['password'])): ?>
                <div>- <?php echo $error['password']; ?></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if (isset($tmp_success)): ?>
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Berhasil!</h4>
        </div>
        <?php endif; ?>

          <div class="form-group">
            <input type="hidden" name="row[user_id]" value="<?php echo $user->user_id; ?>"/>
            <label class="control-label" for="input01">Username</label>
            <div class="controls">
                <input type="text" class="form-control" disabled="disabled" value="<?php echo $user->username; ?>" id="name">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="select01">Level</label>
            <div class="controls">
              <select id="select01" name="row[level]" class="form-control">
                <option value="admin"  <?php if($user->level == "admin") {echo "SELECTED";}?>>Admin</option>
                <option value="member"  <?php if($user->level == "member") {echo "SELECTED";}?>>Member</option>
              </select>
            </div>
          </div>
          <div class="form-actions">
            <br>
            <input type="submit" name="btn-save" class="btn btn-primary" value="Simpan"/>
          </div>
      </form>
