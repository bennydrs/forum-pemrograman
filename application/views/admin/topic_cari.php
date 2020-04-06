<div class="page-header">
    <h3>Semua topic</h3>
</div>
    
    <script>
    $(function() {
        $('#modalConfirm').modal({
            keyboard: true,
            backdrop: true,
            show: false
        });

        var cat_id;

        $('.del').click(function() {
            topic_id = $(this).attr('id').replace("topic_id_", "");
            $('#modalConfirm').modal('show');
            return false;
        });

        $('#btn-delete').click(function() {
            window.location = '<?php echo site_url('admin/topic_delete'); ?>/'+topic_id;
        });
    })
    </script>
    
    <div class="modal fade" id="modalConfirm">
      <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Hapus topic</h3>
        </div>
        <div class="modal-body">
        <p style="text-align: center;">
            Apakah anda yakin ingin menghapus topic ini ?
            <br/>
            <span style="font-weight: bold;color:#ff0000;font-size: 14px;">Semua post di topic ini akan dihapus<span>
        </p>
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
        <h4 class="alert-heading">topic berhasil di update!</h4>
    </div>
    <?php endif; ?>
    <?php if (isset($tmp_success_del)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">topic berhasil di hapus!</h4>
    </div>
    <?php endif; ?>
    <style>table td {padding:7px !important;vertical-align: middle !important;}</style>
    <script>
    $(function() {
        $('.linkviewtip').tooltip();
    });
    </script>


    <div class="row">
        <div class="col-lg-6">
            <form method="get" action="<?php echo site_url('admin/cari_topic'); ?>">
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

    <?php $no=1; ?>
    
    <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="5%" style="text-align:center;">No</th>
            <th width="75%">topics</th>
            <th width="75%">Kategori</th>
            <th width="10%">Penulis</th>
            <th width="10%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cari as $topic): ?>
        <tr>
        <td><?php echo $no++; ?></td>
        <td>
            <a class="linkviewtip" title="Go to: <?php echo $topic->title; ?>" href="<?php echo site_url('topic/talk/'.$topic->th_slug); ?>"><?php echo $topic->title; ?></a>
        </td>
        <td>
            <?php echo $topic->category_name; ?>
        </td>
        <td>
            <a href="<?php echo site_url ('chat/profil/'. $topic->user_id); ?>"><?php echo $topic->username; ?></a>
        </td>
        <!-- <td style="text-align: center;"><a title="edit" class="btn btn-primary btn-sm" href="<?php echo site_url('admin/topic_edit').'/'.$topic->topic_id; ?>">Edit</a> </td> -->
        <td style="text-align: center;"><a title="delete" class="del btn btn-danger btn-sm" id="topic_id_<?php echo $topic->topic_id; ?>" href="<?php echo site_url('admin/topic_delete').'/'.$topic->topic_id;?>">Hapus</a></td>
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


