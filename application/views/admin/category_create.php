<ol class="breadcrumb">
   <li>
        <i class="fa fa-dashboard"></i> <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
   </li>
   <li class="active">
        Tambah Kategori
   </li>
</ol>

<div class="page-header">
    <h2>Tambah Kategori Baru</h2>
</div>

<form method="post" action="">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Error!</h4>
            <?php if (isset($error['name'])): ?>
                <div>- <?php echo $error['name']; ?></div>
            <?php endif; ?>
            <?php if (isset($error['slug'])): ?>
                <div>- <?php echo $error['slug']; ?></div>
            <?php endif; ?>
        </div>

        <?php endif; ?>

        <?php if (isset($tmp_success)): ?>
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Kategori berhasil ditambah!</h4>
        </div>

        <?php endif; ?>

        <script>
        $(function() {
            $('#name').change(function() {
                var name = $('#name').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                $('#slug').val(name);
            });
        });
        </script>


  <div class="form-group">
      <label for="name">Nama Kategori</label>
      <input type="text" class="form-control" name="row[name]" id="name">
  </div>
  <div class="form-group">
      <label class="control-label" for="slug">Slug</label>
      <input type="text" class="form-control" name="row[slug]" id="slug">
      <p class="help-block">untuk url</p>
  </div>
  <div class="form-group">
      <label class="control-label" for="select01">Parent</label>
          <select id="select01" name="row[parent_id]" class="form-control">
            <option value="0">-- none --</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
            <?php endforeach; ?>
          </select>
  </div>
  <div class="form-group">
    <br>
    <input type="submit" name="btn-create" class="btn btn-primary" value="Buat Kategori"/>
  </div>
</form>

</div>
