<div class="page-header">
    <h2>Edit Kategori</h2>
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
        
        <input type="hidden" name="row[category_id]" value="<?php echo $category->category_id; ?>"/>
        <input type="hidden" name="row[name_c]" value="<?php echo $category->name; ?>"/>
        <input type="hidden" name="row[slug_c]" value="<?php echo $category->slug; ?>"/>

        <div class="form-group">
          <label class="control-label" for="input01">Name</label>
          <div class="controls">
            <input type="text" class="form-control" value="<?php echo $category->name; ?>" name="row[name]">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label" for="input01">Slug</label>
          <div class="controls">
            <input type="text" class="form-control" value="<?php echo $category->slug; ?>" name="row[slug]">
            <p class="help-block">untuk url</p>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label" for="select01">Parent</label>
          <div class="controls">
            <select id="select01" name="row[parent_id]" class="form-control">
              <option <?php if ($category->category_id == 0): ?>selected="selected"<?php endif; ?> value="0">-- none --</option>
              <?php foreach ($categories as $cat): ?>
              <?php if ($category->id != $cat['id']): ?>
              <option <?php if ($category->parent_id == $cat['id']): ?>selected="selected"<?php endif; ?> value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
              <?php else: ?>
              <option disabled style="background:#d3d3d3;" value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
              <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <input type="submit" name="btn-edit" class="btn btn-primary" value="Simpan"/>
        </div>

  </form>

</div>
