<ol class="breadcrumb">
   <li>
        <i class="fa fa-dashboard"></i> <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
   </li>
   <li class="active">
        Semua Admin
   </li>
</ol>

<div class="page-header">
    <h3>Semua Member</h3>
</div>
    <script>
    $(function() {
        $('#modalConfirm').modal({
            keyboard: true,
            backdrop: true,
            show: false
        });

        var user_id;

        $('.del').click(function() {
            user_id = $(this).attr('id').replace("user_id_", "");
            $('#modalConfirm').modal('show');
            return false;
        });

        $('#btn-delete').click(function() {
            window.location = '<?php echo site_url('admin/user_delete'); ?>/'+user_id;
        });
    })
    </script>

    <div class="modal fade" id="modalConfirm">
      <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Hapus User</h3>
        </div>
        <div class="modal-body">
        <p style="text-align: center;"> Apakah Anda yakin ingin menghapus user ini ?</p>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <a href="#" class="btn btn-primary" data-dismiss="modal">Batal</a>
            <a href="#" class="btn btn-danger" id="btn-delete">Hapus</a>
        </div>
      </div>
    </div>
  </div>

    <?php if (isset($tmp_success)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">User berhasil diupdate!</h4>
    </div>
    <?php endif; ?>
    <?php if (isset($tmp_success_del)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">User berhasil dihapus!</h4>
    </div>
    <?php endif; ?>


    <div class="row">
        <div class="col-lg-6">
            <form method="get" action="<?php echo site_url('admin/cari_admin'); ?>">
                <div class="input-group">
                <input type="text" name="cari" class="form-control" id="cari" placeholder="Search">
                <span class="input-group-btn">
                    <button class="btn btn-primary">Cari</button>
                </span>
                </div>
            </form>
        </div>
    </div>

    <br>
    
    <?php $no=1+$this->uri->segment(3); ?>
    <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">Username</th>
            <th width="30%">Nama</th>
            <th width="10">Email</th>
            <th width="15">Jenis Kelamin</th>
            
            <th width="5%">Edit</th>
            <th width="5%">Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cari as $user): ?>
        <tr>
                <td><?php echo $no++; ?></td>
                <td><a href="<?php echo site_url ('profil_member/profil/'. $user->user_id); ?>"><?php echo $user->username; ?></a></td>
                <td><?php echo $user->name ?></td>
                <td><?php echo $user->email ?></td>
                <td><?php echo $user->jenis_kelamin ?></td>

                <!-- <?php if($this->session->userdata('bds_user_level')!='super_admin'){ ?>
                <td>
                    <?php if ($user->aktif>0) { ?>
                        <b>Aktif</b>
                    <?php } else { ?>
                        <b>Non-Aktif</b>
                    <?php } ?>
                    </td>
                    <?php } else{ ?>
                <td>
                    <?php if ($user->aktif) { ?>
                        <a href='<?php echo site_url ('admin/n_aktif_ad/'. $user->user_id)?>'><b>Aktif</b></a>
                    <?php } else { ?>
                        <a href='<?php echo site_url ('admin/aktif_ad/'. $user->user_id)?>'><b>Non-Aktif</b></a>
                    <?php } ?>
                    </td> -->
                <td style="text-align: center;"><a title="edit" class="btn btn-success btn-sm" href="<?php echo site_url('admin/admin_edit').'/'.$user->user_id; ?>"><i class ="glyphicon glyphicon-edit"></i> Edit</a> </td>
                <td style="text-align: center;"><a title="delete" class="del btn btn-danger btn-sm" id="user_id_<?php echo $user->user_id; ?>" href="<?php echo site_url('admin/user_delete').'/'.$user->user_id; ?>"><i class ="glyphicon glyphicon-trash"></i> Hapus</a> </td>
                <!-- <?php } ?> -->
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>

    <nav aria-label="...">
    <ul class="pagination">
      <li class="disabled">
        <span>
          <span aria-hidden="true">&laquo;</span>
        </span>
      </li>
      <li class="active">
        <?php echo $page; ?>
      </li>
    </ul>
    </nav>
