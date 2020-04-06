<ol class="breadcrumb">
   <li>
        <i class="fa fa-dashboard"></i> <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
   </li>
   <li class="active">
        Kelola Member
   </li>
</ol>

<div class="page-header">
    <h3>Daftar Member</h3>
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
                    <p style="text-align: center;"> Apakah Anda yakin ingin menghapus memeber ini ?</p>
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
        <h4 class="alert-heading">Level Member berhasil diubah!</h4>
    </div>
    <?php endif; ?>
    <?php if (isset($tmp_success_del)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">Member berhasil dihapus!</h4>
    </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('msg')){ ?>
      <div class="alert alert-success">
          <a class="close" data-dismiss="alert" href="#">&times;</a>
      
          <?php echo $this->session->flashdata('msg'); ?>
      </div>
    <?php } ?>

    <div class="row">
        <div class="col-lg-6">
            <form method="get" action="<?php echo site_url('admin/cari_member'); ?>">
                <div class="input-group">
                <input type="text" name="cari" class="form-control" id="cari" placeholder="Search" required>
                <span class="input-group-btn">
                    <button class="btn btn-primary">Cari</button>
                </span>
                </div>
            </form>
        </div>
    </div>

    <br>
    
    <?php $no=1 + $this->uri->segment(3); ?>
    <div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Username</th>
                <th width="20%">Email</th>
                <th width="15%">Last Login</th>
                <th width="15%">Status</th>
                <th width="5%">Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><a href="<?php echo site_url ('profil_member/profil/'. $user->user_id); ?>"><?php echo $user->username; ?></a></td>
                <td><?php echo $user->email ?></td>
                <td>
                    <?php echo time_ago($user->last_login) ?>
                </td>
                <td>
                    <?php if ($user->aktif) { ?>
                        <a data-toggle="tooltip" title="klik untuk non-aktifkan member ini" href='<?php echo site_url ('admin/n_aktif/'. $user->user_id)?>' onclick= "return confirm('Apakah anda yakin menonaktifkan member ini?')"><b>Aktif</b></a>
                    <?php } else { ?>
                        <a data-toggle="tooltip" title="klik untuk aktifkan member ini" href='<?php echo site_url ('admin/aktif/'. $user->user_id)?>'><b>Non-Aktif</b></a>
                    <?php } ?>
                </td>
            
                <td style="text-align: center;"><a title="delete" class="del btn btn-danger btn-sm" id="user_id_<?php echo $user->user_id; ?>" href="<?php echo site_url('admin/user_delete').'/'.$user->user_id; ?>"><i class ="glyphicon glyphicon-trash"></i> Hapus</a> </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

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

<!-- waktu -->
<?php
        function time_ago($date) {
            if(empty($date)) {
                return "No date provided";
            }

            $periods = array("detik", "menit", "jam", "hari", "minggu", "bulan", "tahun", "dekade");
            $lengths = array("60","60","24","7","4.35","12","10");
            $now = time();
            $unix_date = strtotime($date);

            // cek validasi tanggal
            if(empty($unix_date)) {
                return "Bad date";
            }
            
            if($now > $unix_date) {
                $difference = $now - $unix_date;
                $tense = "lalu";
            } else {
                $difference = $unix_date - $now;
                $tense = "dari sekarang";
            }
            for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
                $difference /= $lengths[$j];
            }
            $difference = round($difference);

            return "$difference $periods[$j] {$tense}";
        }
    ?>