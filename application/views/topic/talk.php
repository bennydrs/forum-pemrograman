<nav aria-label="breadcrumb">
   <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="<?php echo site_url('topic'); ?>">Home</a> <span class="divider"></span>
      </li>
      <?php $cat_total = count($cat);
      foreach ($cat as $key => $c) : ?>
         <li class="breadcrumb-item">
            <a href="<?php echo site_url('topic/category/' . $c['slug']); ?>"><?php echo $c['name']; ?></a>
            <?php if ($key + 1 != $cat_total) : ?>
               <span class="divider"></span>
            <?php endif; ?>
         </li>
      <?php endforeach; ?>
   </ol>
</nav>



<?php if ($topic->jenis_topic == 'Tanya') { ?>
   <div class="alert alert-info alert-dismissible fade show" role="alert">
      Klik Like pada post jika jawaban sesuai dengan yang ditanyakan.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
      </button>
   </div>
<?php } ?>

<br>

<!-- alert -->
<?php if (isset($tmp_success_bls)) : ?>
   <div class="alert alert-success">
      <a class="close" data-dismiss="alert" href="#">&times;</a>
      Balasan Berhasil dibuat!
   </div>
<?php endif; ?>

<?php if (isset($tmp_success_new)) : ?>
   <div class="alert alert-success">
      <a class="close" data-dismiss="alert" href="#">&times;</a>
      topic baru berhasil dibuat!
   </div>
<?php endif; ?>

<?php if (isset($tmp_success_edit_th)) : ?>
   <div class="alert alert-success">
      <a class="close" data-dismiss="alert" href="#">&times;</a>
      topic berhasil diedit!
   </div>
<?php endif; ?>

<?php if (isset($tmp_success_edit)) : ?>
   <div class="alert alert-success">
      <a class="close" data-dismiss="alert" href="#">&times;</a>
      Post berhasil diedit!
   </div>
<?php endif; ?>

<!-- end -->

<!-- validasi -->
<?php if (isset($error)) : ?>
   <div class="alert alert-danger">
      <a class="close" data-dismiss="alert" href="#">&times;</a>

      <?php if (isset($error['th_slug'])) : ?>
         <div>- <?php echo $error['th_slug']; ?></div>
      <?php endif; ?>
   </div>
<?php endif; ?>

<!-- waktu -->
<?php
function time_ago($date)
{
   if (empty($date)) {
      return "No date provided";
   }

   $periods = array("detik", "menit", "jam", "hari", "minggu", "bulan", "tahun", "dekade");
   $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
   $now = time();
   $unix_date = strtotime($date);

   // cek validasi tanggal
   if (empty($unix_date)) {
      return "Bad date";
   }

   if ($now > $unix_date) {
      $difference = $now - $unix_date;
      $tense = "lalu";
   } else {
      $difference = $unix_date - $now;
      $tense = "dari sekarang";
   }
   for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
      $difference /= $lengths[$j];
   }
   $difference = round($difference);

   return "$difference $periods[$j] {$tense}";
}
?>

<!-- tynimce -->
<script type="text/javascript" src="<?php echo base_url(); ?>resources/tinymce/js/tinymce/tinymce.min.js"></script>

<script>
   tinymce.init({
      selector: "textarea",
      theme: 'modern',
      plugins: [
         "advlist autolink lists link image charmap print preview anchor",
         "searchreplace visualblocks code fullscreen",
         "insertdatetime media table contextmenu paste jbimages", "emoticons", "codesample"
      ],

      codesample_languages: [{
            text: 'HTML/XML',
            value: 'markup'
         },
         {
            text: 'JavaScript',
            value: 'javascript'
         },
         {
            text: 'CSS',
            value: 'css'
         },
         {
            text: 'PHP',
            value: 'php'
         },
         {
            text: 'Ruby',
            value: 'ruby'
         },
         {
            text: 'Python',
            value: 'python'
         },
         {
            text: 'Java',
            value: 'java'
         },
         {
            text: 'C',
            value: 'c'
         },
         {
            text: 'C#',
            value: 'csharp'
         },
         {
            text: 'C++',
            value: 'cpp'
         }
      ],

      toolbar: "insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image jbimages | link media emoticons codesample",

      codesample_dialog_height: 400,
      codesample_dialog_width: 600
   });
</script>


<!-- topic -->
<?php foreach ($fposts as $topic) : ?>
   <div class="card mb-3">
      <div class="card-header talk px-4">
         <span style="font-size:12px;">

            <div class="media">
               <?php
               if (empty($topic->foto)) {
                  echo "<img class='mr-3 rounded-circle' src='" . base_url("uploads/kosong.jpg") . "'/>";
               } else {
                  echo "<img class='mr-3 rounded-circle' src='" . base_url("uploads/" . $topic->foto) . "' />";
               }
               ?>
               <div class="media-body">
                  <a href="<?php echo site_url('profil_member/profil/' . $topic->user_id); ?>"><?php echo $topic->username; ?></a>
                  <?php
                  $admin = $topic->level == 'admin';
                  if ($topic->user_id == $admin) { ?>
                     <span class="badge badge-secondary"><?php echo $topic->level; ?></span> &nbsp;
                  <?php } ?>
                  <br>
                  <!-- apakah diedit atau bukan -->
                  <span class="date">
                     <?php
                     echo '<i class="glyphicon glyphicon-time"></i>&nbsp;';
                     echo "dibuat &nbsp;",  time_ago($topic->date_add);
                     echo '&nbsp;&nbsp;&nbsp;';
                     if ($topic->date_edit > 0) {
                        echo '<i class="glyphicon glyphicon-time"></i>&nbsp;';
                        echo "diedit &nbsp;", time_ago($topic->date_edit);
                     }

                     ?>
                     &nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i> <?php echo $topic->hit_count; ?>
                  </span>

               </div>
            </div>

         </span>

         <h4 class="pt-2"><?php echo $topic->title; ?></h4>

         <label style="font-size:10px;">Kategori:</label>
         <span class="cat" style="font-size:12px;">
            <a class="badge badge-pill badge-success" href="<?php echo site_url('topic/category/' . $c['slug']); ?>"><?php echo $c['name']; ?></a>
         </span>
         <label style="font-size:10px;">Jenis:</label>
         <span class="badge badge-info" style="font-size:10px;"><?php echo $topic->jenis_topic ?></span>
      </div>

      <div class="card-body px-4 pb-2">
         <p class="mb-0"><?php echo $topic->f_post; ?></p>

         <div class="btn-group" role="group">
            <a title="Balas" class="page_scroll btn btn-primary btn-sm" href="#balas">Balas</a>
         </div>
         <!-- edit -->

         <?php $tgl_sekarang = date("Y-m-d H:i:s"); //tanggal sekarang
         $tgl_mulai = $topic->date_add; // tanggal launching aplikasi
         $jangka_waktu = strtotime('+30 minutes', strtotime($tgl_mulai)); // jangka waktu + 365 hari
         $tgl_exp = date("Y-m-d H:i:s", $jangka_waktu); //tanggal expired
         if ($this->session->userdata('bds_user_id') == $topic->user_id) { ?>
            <div class="btn-group talk" role="group">
               <?php if ($tgl_sekarang >= $tgl_exp) {
                  echo "";
               } else { ?>
                  <a title="edit" data-toggle="modal" data-target="#edit-data<?php echo $topic->topic_id; ?>" class="btn btn-primary btn-sm"> Edit</a>
               <?php } ?>
            </div>
         <?php } ?>

         <!-- <?php if ($this->session->userdata('bds_user_id') == $topic->user_id) { ?>
            <div class="btn-group talk" role="group">
               <a title="edit" data-toggle="modal" data-target="#edit-data<?php echo $topic->topic_id; ?>" class="btn btn-primary btn-sm" > Edit</a>
            </div>
      <?php } ?> -->
         <!-- akhir edit -->
      </div>
   </div>
<?php endforeach; ?>
<!-- akhir topic -->


<!-- post -->
<?php foreach ($posts as $key => $post) { ?>

   <div class="card record mb-3" id="<?php echo $post->post_id; ?>">
      <div class="card-body">
         <span style="font-size:12px;">
            <?php
            if (empty($post->foto)) {
               echo "<img class='rounded-circle' src='" . base_url("uploads/kosong.jpg") . "' width='34px' />";
            } else {
               echo "<img class='rounded-circle' src='" . base_url("uploads/" . $post->foto) . "' width='34px' />";
            }
            ?>
            <a href="<?php echo site_url('profil_member/profil/' . $post->user_id); ?>"><?php echo $post->username; ?></a>,
            <?php
            $admin = $post->level == 'admin';
            if ($post->user_id == $admin) { ?>
               <span class="badge badge-secondary"><?php echo $post->level; ?></span> &nbsp;
            <?php } ?>


            <!-- apakah diedit atau bukan -->
            <?php
            if ($post->date_edit == 0) {
               echo time_ago($post->date_add);
            } else {
               echo "(diedit) &nbsp;", time_ago($post->date_edit);
            }
            ?>
         </span>

         <!-- titik 3 option vertical-->
         <!-- edit dan hapus post-->
         <?php
         $tgl_sekarang = date("Y-m-d H:i:s"); //tanggal sekarang
         $tgl_mulai = $post->date_add; // tanggal launching aplikasi
         $jangka_waktu = strtotime('+30 minutes', strtotime($tgl_mulai)); // jangka waktu + 365 hari
         $tgl_exp = date("Y-m-d H:i:s", $jangka_waktu); //tanggal expired
         if ($this->session->userdata('bds_user_id') == $post->user_id) {
         ?>
            <div class="btn-group talk" role="group">
               <?php if ($tgl_sekarang >= $tgl_exp) {
                  echo "";
               } else { ?>
                  <div class="dropdown float-right">
                     <a href="#" class="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-option-vertical"></i></a>
                     <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" title="edit" data-toggle="modal" href="#edit-data<?php echo $post->post_id; ?>"> Edit</a>

                        <?php if ($this->session->userdata('bds_user_id') == $post->user_id || $this->session->userdata('bds_user_level') == 'admin' || $this->session->userdata('bds_user_level') == 'super_admin') { ?>
                           <a class="dropdown-item delbutton" id="<?php echo $post->post_id; ?>" href="#"> Hapus</a>
                        <?php } ?>
                     </div>
                  </div>
               <?php } ?>
            </div>
         <?php } ?>
         <!-- akhir edit dan hps -->

      </div>

      <ul class="list-group list-group-flush">
         <li class="list-group-item">
            <p> <?php echo $post->post; ?></p>

            <!-- popover -->
            <script>
               $(function() {
                  $('[data-toggle="popover"]').popover()
               })
            </script>

            <!-- balas/quote -->
            <?php if ($this->session->userdata('bds_logged_in') && $post->reply_to_id == 0) { ?>
               <div class="btn-group" role="group">
                  <button class="btn btn-outline-success btn-sm dropdown-toggle" data-toggle="dropdown" type="button" id="menu<?php echo $post->post_id; ?>" aria-haspopup="true" aria-expanded="true">
                     <i class="glyphicon glyphicon-comment"></i> Quote</button>
                  <div class="dropdown-menu">
                     <form class="px-3 py-2" method="post" style="width: 500px;">
                        <script>
                           $(document).ready(function() {
                              $("#replypost<?php echo $post->post_id; ?>").html();
                           });
                        </script>

                        <input type="hidden" name="row[topic_id]" value="<?php echo $topic->topic_id; ?>" />
                        <input type="hidden" name="row[reply_to_id]" value="<?php echo $post->post_id; ?>" />
                        <input type="hidden" name="row[user_id]" value="<?php echo $this->session->userdata('bds_user_id'); ?>" />
                        <input type="hidden" name="row[date_add]" value="<?php echo date('Y-m-d H:i:s'); ?>" />
                        <textarea name="row[post]" id="replypost<?php echo $post->post_id; ?>" class="form-control" cols="72" style="height:180px;">
                        <div style='font-size:12px; background: #e3e3e3;padding:5px;'>
                           posted by <b>@<?php echo $post->username; ?>
                           </b><?php echo $post->post; ?></div><br/><br/>
                        </textarea>
                        <input type="submit" name="btn-post" class="btn btn-primary btn-sm balas mt-3" value="Post Qoute" />
                     </form>
                  </div>
               </div>
            <?php } ?>

            <!-- like -->
            <div class="btn-group" role="group">
               <?php if ($this->session->userdata('bds_logged_in')) { ?>
                  <?php if ($topic->jenis_topic == 'Tanya') { ?>
                     <a data-toggle="tooltip" title="like untuk top post" data-placement="right" class="btn btn-outline-info btn-sm" onclick="javascript:savelike(<?php echo $post->post_id; ?>);">
                        <i class="glyphicon glyphicon-thumbs-up"></i>
                     <?php } else { ?>
                        <a class="btn btn-outline-info btn-sm" onclick="javascript:savelike(<?php echo $post->post_id; ?>);">
                           <i class="glyphicon glyphicon-thumbs-up"></i>
                        <?php } ?>
                        <span id="like_<?php echo $post->post_id; ?>">
                           <?php if ($post->likes > 0) {
                              echo $post->likes . ' ';
                           } else {
                              echo 'Like';
                           } ?>
                        </span></a>

                     <?php } else { ?>

                        <a tabindex="0" class="btn btn-outline-info btn-sm" role="button" data-toggle="popover" data-trigger="focus" data-content="Anda harus login terlebih dahulu">
                           <i class="glyphicon glyphicon-thumbs-up"></i>
                           <span id="like_<?php echo $post->post_id; ?>">
                              <?php if ($post->likes > 0) {
                                 echo $post->likes . ' ';
                              } else {
                                 echo 'Like';
                              } ?>
                           </span></a>

                     <?php } ?>
            </div>

            <script>
               $(function() {
                  $('[data-toggle="tooltip"]').tooltip()
               })
            </script>

            <!--tekan love -->
            <div class="btn-group float-right" role="group">
               <?php if ($this->session->userdata('bds_user_id') == $topic->user_id && $topic->topic_id && $post->love == 0 && $topic->jenis_topic == 'Tanya') { ?>

                  <form action="" method="post" class="form-inline">
                     <div class="form-check ml-2 mb-2 mr-sm-1">
                        <input type="hidden" name="row[post_id]" value="<?php echo $post->post_id; ?>" />
                        <input type="hidden" name="row[cek]" value="1" class="form-check-input" id="customControlAutosizing">
                     </div>
                     <button data-toggle="tooltip" title="tekan love jika jawaban sesuai dengan pertanyaan anda" type="submit" name="btn-cek" class="tom_love" value="save"> <i class="glyphicon glyphicon-heart tekan"></i> </button>
                  </form>

               <?php } ?>

               <?php if ($this->session->userdata('bds_user_id') == $topic->user_id && $topic->topic_id && $post->love > 0 && $topic->jenis_topic == 'Tanya') { ?>
                  <form action="" method="post" class="form-inline">
                     <div class="form-check ml-2 mb-2 mr-sm-1">
                        <input type="hidden" name="row[post_id]" value="<?php echo $post->post_id; ?>" />
                        <input type="hidden" name="row[cek]" value="0" class="form-check-input" id="customControlAutosizing">
                     </div>
                     <span>
                        <button data-toggle="tooltip" title="hapus love" type="submit" name="btn-hps" class="tom_unlove" value="save"> <i class="glyphicon glyphicon-heart"></i> </button>

                     </span>
                  </form>
               <?php } else if ($post->love > 0) { ?>
                  <i data-toggle="tooltip" title="love dari penanya" class="glyphicon glyphicon-heart love"></i>
               <?php } ?>
               <!-- <?php if ($this->session->userdata('bds_user_id') == $topic->user_id && $topic->topic_id && $post->love > 0 && $topic->jenis_topic == 'Tanya') { ?>
                        <form action="" method="post" class="form-inline udah">
                        <div class="form-check ml-2 mb-2 mr-sm-1">
                              <input type="hidden" name="row[post_id]" value="<?php echo $post->post_id; ?>"/>
                              <input type="hidden" name="row[cek]" value="0" class="form-check-input" id="customControlAutosizing">                     
                        </div>
                        <span>
                              <button data-toggle="tooltip" title="hapus love" type="submit" name="btn-hps" class="btn btn-primary btn-sm mb-2" value="save"> <i class="glyphicon glyphicon-heart"></i> </button>

                        </span>
                        </form>
                        <?php } else if ($post->love > 0) { ?>                   
                              <i data-toggle="tooltip" title="love dari penanya" class="glyphicon glyphicon-heart love"></i>
                     <?php } ?> -->
            </div>

         </li>
      </ul>

   </div>
<?php }  ?>
<!-- akhir post -->



<!-- halaman -->
<nav aria-label="...">
   <ul class="pagination">
      <li class="page-item disabled">
         <span>
            <span aria-hidden="true"></span>
         </span>
      </li>
      <li class="page-item">
         <?php echo $page; ?>
      </li>
   </ul>
</nav>


<!-- Balas -->
<div id="balas">
   <div class="form-group">
      <label for=""><b>Post Balas</b> </label>

      <?php if ($this->session->userdata('bds_logged_in')) { ?>

         <form class="needs-validation" action="" method="post" novalidate>
            <input type="hidden" name="row[topic_id]" value="<?php echo $topic->topic_id; ?>" />
            <input type="hidden" name="row[reply_to_id]" value="0" />
            <input type="hidden" name="row[user_id]" value="<?php echo $this->session->userdata('bds_user_id'); ?>" />
            <input type="hidden" name="row[date_add]" value="<?php echo date('Y-m-d H:i:s'); ?>" />
            <textarea name="row[post]" class="form-control" id="textpost" style="height:180px;" required></textarea>
            <div class="invalid-feedback">
               Post balas kosong.
            </div>

            <input type="submit" name="btn-post" class="btn btn-primary mt-3" value="Post Balas" />
         </form>

   </div>
<?php } else {
         echo "<br>Lakukan"; ?>
   <a href="<?php echo site_url('user/login'); ?>">Login</a> Terlebih dahulu Untuk Membalas topic
   <hr>
<?php } ?>

</div>
<!-- akhir balas -->



<!-- top post -->
<?php if ($topic->jenis_topic == 'Tanya') { ?>
   <div class="card-header mb-2">
      <b>Top Post</b> <i data-toggle="tooltip" data-placement="right" title="Top post diambil dari like terbanyak & Love dari penanya. Top post hanya ada di jenis topic tanya"><i class="glyphicon glyphicon-info-sign"></i></i>
   </div>

<?php } ?>

<?php foreach ($top_post as $top) { ?>
   <?php if ($top->love > 0 && $top->likes > 0 && $topic->jenis_topic == 'Tanya') { ?>
      <div class="card record mb-3">
         <div class="card-body">
            <span style="font-size:12px;">
               <?php
               if (empty($top->foto)) {
                  echo "<img class='rounded-circle' src='" . base_url("uploads/kosong.jpg") . "' width='34px' />";
               } else {
                  echo "<img class='rounded-circle' src='" . base_url("uploads/" . $top->foto) . "' width='34px' />";
               }
               ?>
               <a href="<?php echo site_url('profil_member/profil/' . $top->user_id); ?>"><?php echo $top->username; ?></a>,

               <!-- apakah diedit atau bukan -->
               <?php
               if ($top->date_edit == 0) {
                  echo time_ago($post->date_add);
               } else {
                  echo "(diedit) &nbsp;", time_ago($top->date_edit);
               }
               ?>
            </span>
         </div>

         <ul class="list-group list-group-flush">
            <li class="list-group-item">
               <p> <?php echo $top->post; ?></p>

               <!-- like -->
               <div class="btn-group" role="group">
                  <?php if ($this->session->userdata('bds_user_id')) { ?>
                     <a class="btn btn-outline-info btn-sm" onclick="javascript:savelike(<?php echo $top->post_id; ?>);">
                        <i class="glyphicon glyphicon-thumbs-up"></i>
                        <span id="like_<?php echo $top->post_id; ?>">
                           <?php if ($top->likes > 0) {
                              echo $top->likes . ' ';
                           } else {
                              echo 'Like';
                           } ?>
                        </span>
                     </a>

                  <?php } else { ?>

                     <a tabindex="0" class="btn btn-outline-info btn-sm" role="button" data-toggle="popover" data-trigger="focus" data-content="Anda harus login terlebih dahulu">
                        <span id="like_<?php echo $top->post_id; ?>">
                           <?php if ($top->likes > 0) {
                              echo $top->likes . ' Likes';
                           } else {
                              echo 'Like';
                           } ?>
                        </span>
                     </a>

                  <?php } ?>
               </div>

               <!-- love udah di klik-->
               <div class="btn-group float-right" role="group">

                  <?php if ($this->session->userdata('bds_user_id') == $topic->user_id && $topic->topic_id && $top->love > 0 && $topic->jenis_topic == 'Tanya') { ?>
                     <form action="" method="post" class="form-inline">
                        <div class="form-check ml-2 mb-2 mr-sm-1">
                           <input type="hidden" name="row[post_id]" value="<?php echo $post->post_id; ?>" />
                           <input type="hidden" name="row[cek]" value="0" class="form-check-input" id="customControlAutosizing">
                        </div>
                        <span>
                           <button data-toggle="tooltip" title="hapus love" type="submit" name="btn-hps" class="tom_unlove" value="save"> <i class="glyphicon glyphicon-heart"></i> </button>

                        </span>
                     </form>
                  <?php } else { ?>
                     <i data-toggle="tooltip" title="love dari penanya" class="glyphicon glyphicon-heart love"></i>
                  <?php } ?>
               </div>
            </li>
         </ul>

      </div>
   <?php } ?>
<?php } ?>


<!-- hitung viewers -->
<?php
$this->db->where('topic_id', $topic->topic_id);
$this->db->set('hit_count', 'hit_count+1', FALSE);
$this->db->update('tb_topic');
?>

<!-- Modal Ubah topic-->
<?php foreach ($fposts as $topic) : ?>
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="edit-data<?php echo $topic->topic_id; ?>" class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Ubah topic</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <script>
               $(function() {
                  $('#title').change(function() {
                     var title = $('#title').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                     $('#slug').val(title);
                  });
               });
            </script>

            <form class="form-horizontal needs-validation" action="" method="post" enctype="multipart/form-data" role="form" style="margin: 5px 10px; padding: 5px 10px;" novalidate>
               <div class="modal-body">
                  <input type="hidden" name="topic_id" value="<?php echo $topic->topic_id; ?>" />
                  <input type="hidden" name="th_slug_old" value="<?php echo $topic->th_slug; ?>" />
                  <div class="form-group">
                     <label for="title">Judul</label>
                     <input type="text" class="form-control" id="title" name="title" value="<?php echo $topic->title; ?>" required />
                     <div class="invalid-feedback">
                        judul kosong.
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Slug (url friendly)</label>
                     <input type="text" id="slug" name="th_slug" value="<?php echo $topic->th_slug; ?>" class="form-control" required>
                     <div class="invalid-feedback">
                        slug kosong.
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Kategori</label>
                     <select class="form-control" name="category_id" required>
                        <option value="0">-- none --</option>
                        <?php foreach ($categories as $cat) : ?>
                           <?php if ($cat['id'] == $topic->category_id) : ?>
                              <option selected="selected" value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                           <?php endif; ?>
                           <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                        <?php endforeach; ?>
                     </select>
                     <div class="invalid-feedback">
                        pilih kategori.
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label" for="select01">Jenis</label>
                     <div class="controls">
                        <select id="select01" name="jenis_topic" class="form-control" required>

                           <option value="Tanya" <?php if ($topic->jenis_topic == "Tanya") {
                                                      echo "SELECTED";
                                                   } ?>>Tanya</option>
                           <option value="Diskusi" <?php if ($topic->jenis_topic == "Diskusi") {
                                                      echo "SELECTED";
                                                   } ?>>Diskusi</option>
                           <option value="Berbagi" <?php if ($topic->jenis_topic == "Berbagi") {
                                                      echo "SELECTED";
                                                   } ?>>Berbagi</option>

                        </select>
                     </div>
                     <div class="invalid-feedback">
                        pilih jenis diskusi.
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Post pertama</label>
                     <textarea name="f_post" rows="70" style="height:180px;" id="post" class="form-control" required><?php echo $topic->f_post; ?></textarea>
                     <div class="invalid-feedback">
                        post balas kosong.
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <input type="submit" name="btn-edit-th" class="btn btn-primary btn-large" value="Simpan" />
                  <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   </div>
<?php endforeach; ?>

<!-- Modal Ubah post-->
<?php foreach ($posts as $post) : ?>
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="edit-data<?php echo $post->post_id; ?>" class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Ubah Post</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form class="form-horizontal needs-validation" method="post" enctype="multipart/form-data" role="form" style="margin: 5px 10px; padding: 5px 10px;" novalidate>
               <div class="modal-body">
                  <input type="hidden" name="row[post_id]" value="<?php echo $post->post_id; ?>" />
                  <div class="form-group">
                     <label>Post</label>
                     <textarea name="row[post]" rows="70" style="height:180px;" id="post" class="form-control" required><?php echo $post->post; ?></textarea>
                     <div class="invalid-feedback">
                        post balas kosong.
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <input type="submit" name="btn-edit" class="btn btn-primary btn-large" value="Simpan" />
                  <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   </div>
<?php endforeach; ?>

<!-- hapus post -->
<script>
   $(document).ready(function() {
      $(".delbutton").click(function() {
         var element = $(this);
         var del_id = element.attr("id");

         var info = 'post_id=' + del_id;
         if (confirm("Anda Yakin akan menghapus?")) {
            $.ajax({
               type: "POST",
               url: "<?php echo site_url('topic/post_delete') ?>",
               data: info,
               success: function() {}
            });
            $(this).parents(".record").animate({
               opacity: "hide"
            }, "slow");
         }
         return false;
      });
   });
</script>


<!--script like -->
<script type="text/javascript">
   function savelike(post_id) {
      $.ajax({
         type: "POST",
         url: "<?php echo site_url('topic/savelikes') ?>",
         data: "Post_id=" + post_id,
         success: function(response) {
            $("#like_" + post_id).html(response + " ");

         }
      });
   }
</script>