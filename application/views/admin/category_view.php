<ol class="breadcrumb">
   <li>
        <i class="fa fa-dashboard"></i> <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
   </li>
   <li class="active">
        Kelola Kategori
   </li>
</ol>

<div class="page-header">
    <h2>Daftar Kategori</h2>
</div>
<?php if (isset($tmp_success)): ?>
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Kategori berhasil diedit!</h4>
        </div>
        <?php endif; ?>

<script>
    $(function() {
        $('#modalConfirm').modal({
            keyboard: true,
            backdrop: true,
            show: false
        });

        var cat_id;

        $('.del').click(function() {
            cat_id = $(this).attr('id').replace("cat_id_", "");
            $('#modalConfirm').modal('show');
            return false;
        });

        $('#btn-delete').click(function() {
            window.location = '<?php echo site_url('admin/category_delete'); ?>/'+cat_id;
        });
    })
</script>

<div class="modal fade" id="modalConfirm">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3>Hapus Kategori</h3>
        </div>
        <div class="modal-body">
            <p style="text-align: center;">Apakah Anda yakin ingin menghapus Kategori ini ?</p>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <a href="#" class="btn" data-dismiss="modal">Batal</a>
            <a href="#" class="btn btn-primary" id="btn-delete">Hapus</a>
        </div>
      </div>
    </div>
</div>

    <?php if (isset($tmp_success_del)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">Kategori berhasil dihapus!</h4>
    </div>
    <?php endif; ?>

    <p><a class="btn btn-primary btn-sm" href="<?php echo site_url('admin/category_create'); ?>"><i class="glyphicon glyphicon-plus"></i> Tambah Kategori</a></p><br>
    
    <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="38%">Kategori</th>
            <th width="38%">Slug</th>
            <th width="12%">Edit</th>
            <th width="12%">Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cat): ?>
        <tr>
        <td><?php echo $cat['name']; ?></td>
        <td><?php echo $cat['slug']; ?></td>
        <td style="text-align: center;"><a title="edit" class="btn btn-success btn-sm" href="<?php echo site_url('admin/category_edit').'/'.$cat['id']; ?>"><i class ="glyphicon glyphicon-edit"></i> Edit</a> </td>
        <td style="text-align: center;"><a title="hapus" class="del btn btn-danger btn-sm" id="cat_id_<?php echo $cat['id']; ?>" href="<?php echo site_url('admin/category_delete').'/'.$cat['id']; ?>"><i class="glyphicon glyphicon-trash"/></i> Hapus</a> </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
