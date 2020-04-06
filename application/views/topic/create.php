
    <?php if (isset($error)): ?>
        <div class="alert alert-danger mt-5">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Error!</h4>
            <?php if (isset($error['title'])): ?>
                <div>- <?php echo $error['title']; ?></div>
            <?php endif; ?>
            <?php if (isset($error['th_slug'])): ?>
                <div>- <?php echo $error['th_slug']; ?></div>
            <?php endif; ?>
            <?php if (isset($error['category'])): ?>
                <div>- <?php echo $error['category']; ?></div>
            <?php endif; ?>
            <?php if (isset($error['post'])): ?>
                <div>- <?php echo $error['post']; ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<div class="page-header mt-5">
    <h3 style="text-align:center;">Buat Topik Baru</h3>
</div>

<div class="card">
    <div class="card-body">
        <form method="post" class="needs-validation" novalidate>
            <script type="text/javascript">
            $(function() {
                $('#title').change(function() {
                    var title = $('#title').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    $('#slug').val(title);
                });
            });
            </script>

            <div class="form-group">
                <label>Judul</label>
                <?php echo form_error('title'); ?>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo set_value('title'); ?>" required> 
                <div class="invalid-feedback">
                    judul kosong.
                </div>
            </div>
            <div class="form-group">   
                <label>Slug (url friendly)</label>
                <input type="text" id="slug" name="th_slug" class="form-control" value="<?php echo set_value('th_slug'); ?>" required>
                <div class="invalid-feedback">
                    slug kosong.
                </div>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select class="custom-select" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    kategori kosong.
                </div>
            </div>

            <div class="form-group">
                <label class="control-label" for="select01">Janis Topik</label>
                <select id="select01" name="jenis_topic" class="custom-select" required>                 
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Tanya">Tanya</option>
                    <option value="Diskusi">Diskusi</option>
                    <option value="Berbagi">Berbagi</option>
                </select>
                <div class="invalid-feedback">
                    jenis topic kosong.
                </div>  
          </div>

            <script type="text/javascript" src="<?php echo base_url(); ?>resources/tinymce/js/tinymce/tinymce.min.js"></script>
        
            <script>
                tinymce.init({
                selector: "#firstpost",
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste jbimages", "emoticons", "media", "codesample"
                    ],

                    toolbar: "insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image jbimages | link media emoticons codesample",

                    });
            </script>

            <div class="form-group">
                <label>Post Pertama</label>
                <textarea name="f_post" id="firstpost"  rows="10" class="form-control" required><?php echo set_value('f_post'); ?></textarea>
                <div class="invalid-feedback">
                    post pertama kosong.
                </div>
                <input type="submit" style="margin-top:15px;font-weight: bold;" name="btn-create" class="btn btn-primary btn-large" value="Buat Topik"/>
            </div>
        </form>
   </div>
</div>

    
