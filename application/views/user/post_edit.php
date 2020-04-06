
<div class="page-header">
            <h3 style="text-align:center;">Edit Post</h3>
</div>
  
    <form class="well" action="" method="post" style="margin: 5px 10px;">

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
        <input type="hidden" name="row[post_id]" value="<?php echo $post->post_id; ?>"/>
        <label>edit Post</label>
        <textarea name="row[post]" rows="10" class="form-control" ><?php echo $post->post; ?></textarea>
        <input type="submit" style="margin-top:15px;font-weight: bold;" name="btn-edit" class="btn btn-primary btn-large" value="Edit Post"/>
        </form>
