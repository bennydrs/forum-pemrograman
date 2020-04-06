<div class="page-header">
    <h3 style="text-align:center;">Edit Thread</h3>
</div>
      <?php if (isset($tmp_success)): ?>
      <div class="alert alert-success">
          <a class="close" data-dismiss="alert" href="#">&times;</a>
          <h4 class="alert-heading">Berhasil!</h4>
      </div>
      <?php endif; ?>
      <?php if (isset($error)): ?>
      <div class="alert alert-error">
          <a class="close" data-dismiss="alert" href="#">&times;</a>
          <h4 class="alert-heading">Error!</h4>
          <?php if (isset($error['title'])): ?>
              <div>- <?php echo $error['title']; ?></div>
          <?php endif; ?>
          <?php if (isset($error['slug'])): ?>
              <div>- <?php echo $error['slug']; ?></div>
          <?php endif; ?>
          <?php if (isset($error['category'])): ?>
              <div>- <?php echo $error['category']; ?></div>
          <?php endif; ?>
          <?php if (isset($error['post'])): ?>
              <div>- <?php echo $error['post']; ?></div>
          <?php endif; ?>
      </div>
      <?php endif; ?>

    <script type="text/javascript" src="<?php echo base_url(); ?>resources/tinymce/js/tinymce/tinymce.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/tinymce/prism.css">
    <script src="<?php echo base_url(); ?>resources/tinymce/prism.js"></script>
    

    <script>
        tinymce.init({
        selector: "textarea",
        plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste jbimages", "emoticons", "codesample"
        ],

        toolbar: "insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages | emoticons | codesample",

        });
    </script>


      <form class="well" action="" method="post" style="margin: 5px 10px;">
      <input type="hidden" name="row[thread_id]" value="<?php echo $thread->thread_id; ?>"/>

      <script>
      $(function() {
          $('#title').change(function() {
              var title = $('#title').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
              $('#slug').val(title);
          });
      });
      </script>

      

        <div class="form-group">
            <label>Title</label>
            <input type="text" id="title" name="row[title]" value="<?php echo $thread->title; ?>" class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label>Slug (url friendly)</label>
            <input type="text" id="slug" name="row[slug]"  value="<?php echo $thread->th_slug; ?>" disabled="disabled" class="form-control disabled" >
        </div> 
        <div class="form-group">  
            <label>Category</label>
            <select class="form-control" name="row[category_id]">
                <option value="0">-- none --</option>
                <?php foreach ($categories as $cat): ?>
                <?php if ($cat['id'] == $thread->category_id): ?>
                    <option selected="selected" value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                <?php endif; ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
        <label>Post Pertama</label>
        <textarea name="row[f_post]" id="isiartikel"  rows="10"  class="form-control"><?php echo $thread->f_post; ?></textarea>
        <input type="submit" style="margin-top:15px;font-weight: bold;" name="btn-save" class="btn btn-primary btn-large" value="Simpan Thread"/>
    </div>
      
      </form>
  </div>

