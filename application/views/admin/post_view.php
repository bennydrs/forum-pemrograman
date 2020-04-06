<ol class="breadcrumb">
   <li>
        <i class="fa fa-dashboard"></i> <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
   </li>
   <li class="active">
        Kelola Post
   </li>
</ol>

<div class="page-header">
    <h3>Semua Post</h3>
</div>
<h4>Jumlah Post: <?php echo $jumlah?></h4></br>



<!-- modal hapus -->
    <div class="modal fade" id="modalConfirm">
      <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Hapus Post</h3>
        </div>
        <div class="modal-body">
        <p style="text-align: center;">
            Apakah anda yakin ingin menghapus post ini ?
        </p>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <a href="#" class="btn btn-primary" data-dismiss="modal">Batal</a>
            <a href="#" class="btn btn-danger" id="btn-delete">Hapus</a>
        </div>
      </div>
    </div>
    </div>
<!-- akhir modal hapus     -->

    <?php if (isset($tmp_success)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">Post berhasil di update!</h4>
    </div>
    <?php endif; ?>
    <?php if (isset($tmp_success_del)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">POst berhasil di hapus!</h4>
    </div>
    <?php endif; ?>


    <script>
        $(function() {
            $('.linkviewtip').tooltip();
        });
    </script>
    
<div class="row">
  <div class="col-lg-6">
    <form method="POST" action="<?php echo site_url('admin/cari_post'); ?>">
        <div class="input-group">
        <input type="text" name="cari_post" class="form-control" id="cari" placeholder="Search" required>
        <span class="input-group-btn">
            <button class="btn btn-primary">Cari</button>
        </span>
        </div>
    </form>
    </div>
    </div>

    <br>
    <div class="table-responsive">
    
    
        <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="50%">Post</th>
                <th width="20%">topic</th>
                <th>Oleh</th>
                <th width="10%">Aksi</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($topics as $key => $post): ?>
            <tr>
                <td style="text-align:center;">
                    <?php echo $key + 1 + $start; ?>
                </td>
                <td>
                    <a class="page-scroll link" href="<?php echo site_url('topic/talk/'.$post->th_slug); ?>#<?php echo $post->post_id;?>"><?php echo $post->post; ?></a>
                </td>
                <td>
                    <a class="linkviewtip link" title="Go to: <?php echo $post->title; ?>" href="<?php echo site_url('topic/talk/'.$post->th_slug); ?>"><?php echo $post->title; ?></a>
                </td>
                <td>
                    <a class="link" href="<?php echo site_url('profil_member/profil/'.$post->user_id); ?>"> <?php echo $post->username; ?></a>
                </td>
                <!-- <td style="text-align: center;"><a title="edit" class="btn btn-primary btn-sm" href="<?php echo site_url('admin/post_edit').'/'.$post->post_id; ?>">Edit</a> </td> -->
                <td style="text-align: center;">
                    <a title="delete" class="del btn btn-danger btn-sm" data-target="#modalConfirm" id="post_id_<?php echo $post->post_id; ?>" href="<?php echo site_url('admin/post_delete').'/'.$post->post_id;?>">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
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
   

<script>
    $(function() {
        $('#modalConfirm').modal({
            keyboard: true,
            backdrop: true,
            show: false
        });

        var cat_id;

        $('.del').click(function() {
            post_id = $(this).attr('id').replace("post_id_", "");
            $('#modalConfirm').modal('show');
            return false;
        });

        $('#btn-delete').click(function() {
            window.location = '<?php echo site_url('admin/post_delete'); ?>/'+post_id;
        });
    })
</script>

    <style>
        .link{
            color: black;
        }
    </style>