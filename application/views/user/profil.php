<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css') ?>">

<!-- CHAT -->
<div id="wgt-container-template" style="display: none">
   <div class="msg-wgt-container">
      <div class="msg-wgt-header">
         <a href="javascript:;" class="online"></a>
         <a href="javascript:;" class="name"></a>
         <a href="javascript:;" class="close">x</a>
      </div>
      <div class="msg-wgt-message-container">
         <table width="100%" class="msg-wgt-message-list">
         </table>
      </div>
      <div class="msg-wgt-message-form">
         <textarea name="message" placeholder="Tulis pesanmu. Press Shift + Enter for newline"></textarea>
      </div>
   </div>
</div>

<script type="text/x-template" id="msg-template" style="display: none">
   <tbody>
      <tr class="msg-wgt-message-list-header">
         <!-- <td rowspan="2"><img src="<?= base_url('assets/avatar.png') ?>"></td> -->
         <td class="name"></td>
         <td class="time"></td>
      </tr>
      <tr class="msg-wgt-message-list-body">
         <td colspan="2"></td>
      </tr>
      <tr class="msg-wgt-message-list-separator"><td colspan="3"></td></tr>
   </tbody>
</script>

<script type="text/javascript">
   jQuery(document).ready(function($) {
      var chatPosition = [
         false, // 1
         false, // 2
         false, // 3
         false, // 4
         false, // 5
         false, // 6
         false, // 7
         false, // 8
         false, // 9
         false // 10
      ];

   // New chat
   $(document).on('click', 'a[data-friend]', function(e) {
      var $data = $(this).data();
      if ($data.friend !== undefined && chatPosition.indexOf($data.friend) < 0) {
         var posRight = 0;
         var position;
         for(var i in chatPosition) {
               if (chatPosition[i] == false) {
                  posRight = (i * 270) + 20;
                  chatPosition[i] = $data.friend;
                  position = i;
                  break;
               }
         }
         var tpl = $('#wgt-container-template').html();
         var tplBody = $('<div/>').append(tpl);
         tplBody.find('.msg-wgt-container').addClass('msg-wgt-active');
         tplBody.find('.msg-wgt-container').css('right', posRight + 'px');
         tplBody.find('.msg-wgt-container').attr('data-chat-position', position);
         tplBody.find('.msg-wgt-container').attr('data-chat-with', $data.friend);
         $('body').append(tplBody.html());
         initializeChat();
      }
   });

   // Minimize Maximize
   $(document).on('click', '.msg-wgt-header > a.name', function() {
      var parent = $(this).parent().parent();
      if (parent.hasClass('minimize')) {
         parent.removeClass('minimize')
      } else {
         parent.addClass('minimize');
      }
   });

   // Close
   $(document).on('click', '.msg-wgt-header > a.close', function() {
      var parent = $(this).parent().parent();
      var $data = parent.data();
      parent.remove();
      chatPosition[$data.chatPosition] = false;
      setTimeout(function() {
         initializeChat();
      }, 1000)
   });

   var chatInterval = [];

   var initializeChat = function() {
      $.each(chatInterval, function(index, val) {
         clearInterval(chatInterval[index]);   
      });

      $('.msg-wgt-active').each(function(index, el) {
         var $data = $(this).data();
         var $that = $(this);
         var $container = $that.find('.msg-wgt-message-container');

         chatInterval.push(setInterval(function() {

               var oldscrollHeight = $container[0].scrollHeight;
               var oldLength = 0;
               $.post('<?php echo site_url('profil_member/getChats') ?>', {chatWith: $data.chatWith}, function(data, textStatus, xhr) {
                  $that.find('a.name').text(data.name);
                  // from last
                  var chatLength = data.chats.length;
                  var newIndex = data.chats.length;
                  $.each(data.chats, function(index, el) {
                     newIndex--;
                     var val = data.chats[newIndex];

                     var tpl = $('#msg-template').html();
                     var tplBody = $('<div/>').append(tpl);
                     var id = (val.chat_id +'_'+ val.send_by +'_'+ val.send_to).toString();
                     

                     if ($that.find('#'+ id).length == 0) {
                           tplBody.find('tbody').attr('id', id); // set class
                           tplBody.find('td.name').text(val.name); // set name
                           tplBody.find('td.time').text(val.time); // set time
                           tplBody.find('.msg-wgt-message-list-body > td').html(nl2br(val.message)); // set message
                           $that.find('.msg-wgt-message-list').append(tplBody.html()); // append message

                           //Auto-scroll
                           var newscrollHeight = $container[0].scrollHeight - 20; //Scroll height after the request
                           if (newIndex === 0) {
                              $container.animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                           }
                     }
                  });
               });
         }, 1000));

         $that.find('textarea').on('keydown', function(e) {
               var $textArea = $(this);
               if (e.keyCode === 13 && e.shiftKey === false) {
                  $.post('<?php echo site_url('profil_member/sendMessage') ?>', {message: $textArea.val(), chatWith: $data.chatWith}, function(data, textStatus, xhr) {
                  });
                  $textArea.val(''); // clear input

                  e.preventDefault(); // stop 
                  return false;
               }
         });
      });
   }
   var nl2br = function(str, is_xhtml) {
      var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
      return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
   }

   // on load
   initializeChat();
});
</script>
<!-- End chat -->



<?php foreach ($users as $user): ?>

<div class="jumbotron mb-0">
<div class="text-center">
   <?php 
      if (empty($user->foto)){
         echo "<img class='rounded-circle img-thumbnail img-fluid' src='".base_url("uploads/kosong.jpg")."'/>";
      } else {
         echo "<img class='rounded-circle img-thumbnail' src='".base_url("uploads/" .$user->foto)."' />";
      }
   ?>

   <h4 class="display-5"><?php echo $user->name; ?></h4>
   <p class="lead"><?php echo $user->username; ?> <span class="badge badge-secondary" style="font-size:12px"><?php echo $user->level; ?></span></p>
   
      <?php if($this->session->userdata('bds_user_id')==$user->user_id){ ?>
         <a title="Ganti" class="ganti btn btn-danger btn-sm" id="user_id_<?php echo $user->user_id; ?>" href="<?php echo site_url('user/foto_edit').'/'.$user->user_id;?>">Ubah Foto Profil</a>             
      <?php } ?>
      <!-- pesan -->
      <?php foreach ($teman->result() as $item) { ?>               
         <?php if($this->session->userdata('bds_user_id')!=$user->user_id && $this->session->userdata('bds_logged_in')){ ?>   
               <a title="Kirim Pesan" class="btn btn-primary btn-sm" href="javascript:;" data-friend="<?php echo $item->user_id ?>">Kirim Pesan</a>
               
         <?php } ?>
      <?php } ?>
</div>
</div>


<?php if (isset($error)): ?>
   <div class="alert alert-danger">
      <a class="close" data-dismiss="alert" href="#">&times;</a>
      <h5 class="alert-heading">Error!</h5>
      <?php if (isset($error['foto'])): ?>
         <div> <?php echo $error['foto']; ?></div>
      <?php endif; ?>
      <?php if (isset($error['th_slug'])): ?>
         <div>- <?php echo $error['th_slug']; ?></div>
      <?php endif; ?>
   </div>
<?php endif; ?>

<?php if($this->session->flashdata('pass_alert')) { ?>
   <div class="alert alert-danger">
   <a class="close" data-dismiss="alert" href="#">&times;</a>
   <?php echo "$this->session->flashdata('pass_alert')" ?>
   </div>
<?php }?>

<!-- ganti foto -->
   <script>
      $(function() {
         $('#modalConfirm2').modal({
               keyboard: true,
               backdrop: true,
               show: false
         });

         var cat_id;

         $('.ganti').click(function() {
               user_id = $(this).attr('id').replace("user_id_", "");
               $('#modalConfirm2').modal('show');
               return false;
         });
      })
   </script>

   <!-- modal ubah foto -->
   <div class="modal fade" id="modalConfirm2">
      <div class="modal-dialog">
         <div class="modal-content">
               <div class="modal-header">
                  <h3>Ubah Foto Profil</h3>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <p style="text-align: center;">
                     
                     <br/>
                     <?php foreach ($users as $user): ?>
                           <form action="<?php echo site_url('user/foto_edit'); ?>" method="post" class="needs-validation"  enctype="multipart/form-data" novalidate>
                           <!-- <?php echo form_open_multipart('user/foto_edit');?> -->
                           <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>"/>
                           <input type="hidden" name="lama" value="<?php echo $user->foto; ?>">
                           <div class="form-group">
                              <input type="file" name="userfile" class="btn btn-default btn-sm form-control" id="validatedCustomFile" required>
                              <div class="invalid-feedback">foto kosong</div>
                           </div>
                           
                           
                           <!-- <div class="custom-file">
                              <input type="file" name="userfile" class="custom-file-input" id="validatedCustomFile" required>
                              <br>
                              <label class="custom-file-label" for="validatedCustomFile"></label>
                              Foto: <?php echo $user->foto?>
                              <div class="invalid-feedback">foto kosong</div>
                           </div> -->
               
                     <?php endforeach; ?>
                  </p>
               </div>
               <div class="modal-footer" style="text-align: center;">
                  
                  <input type="submit" name="btn-ganti" class="btn btn-primary" id="btn-ganti" value="Simpan"/>
                  <a href="#" class="btn btn-warning" data-dismiss="modal">Batal</a>
                  </form>
               </div>
         </div>
      </div>
   </div>

      
<!-- TAB   -->
   <ul class="nav nav-pills nav-fill border border-secondary rounded mb-0 tab-profil" id="pills-tab" role="tablist">
      <li class="nav-item border-right">
         <a class="nav-link active" data-toggle="pill" href="#profil" role="tab" aria-controls="pills-profil" aria-selected="true">Profil</a>
      </li>
      <li class="nav-item border-right">
         <a class="nav-link" data-toggle="pill" href="#topic" role="tab" aria-controls="pills-topic" aria-selected="false">Topik</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-toggle="pill" href="#post" role="tab" aria-controls="pills-post" aria-selected="false">Post</a>
      </li>
   </ul>

   <div class="tab-content card" id="pills-tabContent">
      <div class="tab-pane fade show active card-body" id="profil" role="tabpanel" aria-labelledby="pills-profil-tab">
      <?php if (isset($tmp_success)): ?>
         <div class="alert alert-info">
               <a class="close" data-dismiss="alert" href="#">&times;</a>
               <h4 class="alert-heading">Profil berhasil diupdate!</h4>
         </div>
      <?php endif; ?>
      <?php if (isset($tmp_success_pass)): ?>
         <div class="alert alert-info">
               <a class="close" data-dismiss="alert" href="#">&times;</a>
               <h4 class="alert-heading">Password Berhasil Diganti!</h4>
         </div>
      <?php endif; ?>
      
         <table class="table table-borderless table-hover">
               <tr>
                  <td width="180px">Username</td>
                  <td><?php echo $user->username; ?></td>
               </tr>
               <tr>
                  <td>Nama</td>
                  <td><?php echo $user->name; ?></td>
               </tr>
               <tr>
                  <td>Email</td>
                  <td><?php echo $user->email;?></td>
               </tr>
               <tr>
                  <td>Jenis Kelamin</td>
                  <td><?php echo $user->jenis_kelamin;?></td>
               </tr>
               <tr>
                  <td>Bergabung pada</td>
                  <td><?php echo tgl_indo(($user->tgl_join))?></td>
               </tr>
               <tr>
                  <td>Terakhir Login</td>
                  <td><?php echo time_ago($user->last_login);?></td>
               </tr>
               <tr>
                  <td>Biografi</td>
                  <td><?php echo $user->bio;?></td>
               </tr>

               <div class="row profil mb-3">
                  <div class="col">
                     <div class="card text-white bg-success ">
                           <div class="card-body text-center tab-profil">
                              <h5 class="card-title"><?php echo $jlh_topik?></h5>
                              <p class="card-text">Topik</p>
                           </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="card text-white bg-info">
                     <div class="card-body text-center tab-profil">
                           <h5 class="card-title"><?php echo $jlh_post?></h5>
                           <p class="card-text">Post Balas</p>
                     </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="card text-white bg-danger">
                           <div class="card-body text-center tab-profil">
                              <h5 class="card-title"><?php echo $jlh_love?></h5>
                              <p class="card-text">Mendapat Love</p>
                           </div>
                     </div>
                  </div>
               </div>

               
               
               <?php endforeach; ?>
         </table>

         <?php if($this->session->userdata('bds_user_id')==$user->user_id){ ?>
                           
               <a title="edit" class="btn btn-outline-success btn-sm" href="<?php echo site_url('user/profil_edit').'/'.$user->user_id; ?>">Edit</a>
               <a title="edit" class="btn btn-outline-info btn-sm" href="<?php echo site_url('user/password_edit').'/'.$user->user_id; ?>">Ganti Password</a>        
            
         <?php } ?>
      </div>

      <!-- tab topic -->
      <div class="tab-pane fade" role="tabpanel" id="topic" aria-labelledby="pills-topic-tab">
         <?php if (isset($tmp_success_edit_th)): ?>
               <div class="alert alert-success">
                  <a class="close" data-dismiss="alert" href="#">&times;</a>
                  topic berhasil diedit!
               </div>
         <?php endif; ?>
         <?php if (isset($tmp_success_del)): ?>
         <div class="alert alert-info">
               <a class="close" data-dismiss="alert" href="#">&times;</a>
               <h4 class="alert-heading">topic berhasil di hapus!</h4>
         </div>
         <?php endif; ?>
         

         <script>
               $(function() {
                  $('.linkviewtip').tooltip();
               });
         </script>

         <table class="table table-striped table-bordered table-condensed table-hover">
               <thead>
                  <tr>
                     <th scope="col" width="1%">No</th>
                     <th scope="col">topics</th>                  
                  </tr>
               </thead>

               <tbody>
               <?php foreach ($topics as $key => $topic): ?>
                  <tr>
                     <td scope="row" class="text-center"><?php echo $key + 1 +$this->uri->segment(4); ?></td>
                     <td>
                           <a class="linkviewtip" title="Go to: <?php echo $topic->title; ?>" href="<?php echo site_url('topic/talk/'.$topic->th_slug); ?>"><?php echo $topic->title; ?></a>
                           <span style="display:block;font-size: 10px;font-style: italic;"><?php echo $topic->cat_name; ?></span>
                     </td>
                     
                     <!-- edit hapus -->
                     <?php
                           $tgl_sekarang=date("Y-m-d H:i:s");//tanggal sekarang
                           $tgl_mulai=$topic->date_add;// tanggal launching aplikasi
                           $jangka_waktu = strtotime('+30 minutes', strtotime($tgl_mulai));// jangka waktu + 365 hari
                           $tgl_exp=date("Y-m-d H:i:s",$jangka_waktu);//tanggal expired
                           if($this->session->userdata('bds_user_id')==$topic->user_id){ ?>
                              <div class="btn-group talk" role="group">
                                 <?php if ($tgl_sekarang >=$tgl_exp ) {                    
                                       echo "";
                                 } else { ?>
                                 <td width="1%">
                                       <a title="Edit topic" data-toggle="modal" data-target="#edit-data<?php echo $topic->topic_id; ?>" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-edit"></i></a>
                                 </td>
                                 <td width="1%">
                                       <a title="Hapus topic" class="del btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" id="topic_id_<?php echo $topic->topic_id; ?>" href="<?php echo site_url('user/topic_delete').'/'.$topic->topic_id;?>"><i class="glyphicon glyphicon-trash"></i></a>
                                 </td>  
                                 <?php } ?>                   
                              </div>
                           <?php } ?>
                     <!-- akhir edit --> 
                  </tr>
                  <?php endforeach; ?>
               </tbody>
         </table>

         <!-- tooltip -->
         <script>
               $(function () {
                  $('[data-toggle="tooltip"]').tooltip()
               })
         </script>

         <nav aria-label="..." class="mt-2 pl-2">
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
      </div>

   <!-- tab post -->
      <div class="tab-pane fade" role="tabpanel" id="post" aria-labelledby="pills-topic-tab">
         <ul class="list-group list-group-flush">
               <?php if (isset($tmp_success_edit)): ?>
               <div class="alert alert-success">
                  <a class="close" data-dismiss="alert" href="#">&times;</a>
                  <h4 class="alert-heading">edit post balas berhasil!</h4>
               </div>
               <?php endif; ?>


               <?php foreach ($posts as $post): ?>
               <li class="list-group-item px-2 record">
                  <!-- edit dan hapus post option vertical-->

                  <?php   
                  $tgl_sekarang=date("Y-m-d H:i:s");//tanggal sekarang
                  $tgl_mulai=$post->date_add;// tanggal launching aplikasi
                  $jangka_waktu = strtotime('+30 minutes', strtotime($tgl_mulai));// jangka waktu + 365 hari
                  $tgl_exp=date("Y-m-d H:i:s",$jangka_waktu);//tanggal expired
                  if($this->session->userdata('bds_user_id')==$post->user_id){ 
                  ?>
                     <div class="btn-group talk" role="group">
                           <?php if ($tgl_sekarang >=$tgl_exp ) {                    
                              echo "";
                           } else { ?>
                              <div class="dropdown float-right">
                              <a href="#" class="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-option-vertical"></i></a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                       <a class="dropdown-item"  title="edit" data-toggle="modal" href="#edit-data<?php echo $post->post_id; ?>" > Edit</a>
                                       <a class="dropdown-item" href="<?php echo site_url('topic/post_delete_p')?>/<?php echo $post->post_id; ?>" onclick= "return confirm('Apakah anda yakin menghapus data ini?')"> Hapus</a>
                                 </div>
                              </div>
                           <?php } ?>                   
                     </div>
                  <?php } ?>

                  <!-- akhir edit dan hps -->

                  <div class="pl-0 ml-0 " style="font-size:12px;">
                     <?php 
                           if (empty($user->foto)){
                              echo "<img class='rounded-circle' src='".base_url("uploads/kosong.jpg")."' width='35px' />";
                           }else{
                              echo "<img class='rounded-circle' src='".base_url("uploads/" .$user->foto)."' width='35px' />";
                           }
                     ?>
                     
                     &nbsp;<?php echo $user->username; ?>, <?php echo time_ago($post->date_add); ?>
                  </div>

                  <div class="post-left py-1 mr-3">
                                             
                     <?php echo $post->post; ?> 
                           
                     <span style="font-size: 12px;">
                           topic : <a href="<?php echo site_url('topic/talk/'.$post->th_slug); ?>"><?php echo $post->title; ?></a>
                     </span>
                     <div class="btn-group float-right" role="group">                   
                           <?php if($post->love > 0) { ?>
                              <i data-toggle="tooltip" title="love dari penanya" class="glyphicon glyphicon-heart love"></i>
                           <?php } ?>
                     </div>    
                  </div>     

                  <?php endforeach; ?>
               </li>
         </ul>

         <nav aria-label="..." class="mt-3 pl-2">
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

      </div>
            
   </div>

</div>     

<!-- Modal Ubah post-->
<?php foreach ($posts as $post): ?>
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="edit-data<?php echo $post->post_id; ?>" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Edit Post Balas</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form class="form-horizontal needs-validation" action="" method="post" enctype="multipart/form-data" role="form" style="margin: 5px 10px; padding: 5px 10px;" novalidate>
                  <div class="modal-body">
                     <input type="hidden" name="row[post_id]" value="<?php echo $post->post_id; ?>"/>
                     <div class="form-group">
                           <label>Post</label>
                              <textarea name="row[post]" rows="70" style="height:180px;" id="post" class="form-control edit" required><?php echo $post->post; ?></textarea>
                              <div class="invalid-feedback">
                                 post balas kosong.
                              </div>    
                     </div>
                     </div>
                     <div class="modal-footer">
                           <input type="submit" name="btn-edit-post" class="btn btn-primary btn-sm" value="Simpan"/>
                           <button type="button" class="btn btn-warning bt-sm" data-dismiss="modal"> Batal</button>
                     </div>
                  </form>
               </div>
         </div>
      </div>
   </div>
<?php endforeach; ?>
<!-- end modal post edit -->

<!-- Modal Ubah topic-->
<?php foreach ($topics as $topic): ?>
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="edit-data<?php echo $topic->topic_id; ?>" class="modal fade bd-example-modal-lg">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Edit topic</h4>
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
                     <input type="hidden" name="topic_id" value="<?php echo $topic->topic_id; ?>"/>
                     <input type="hidden" name="th_slug_old" value="<?php echo $topic->th_slug; ?>"/>
                     <div class="form-group">
                           <label for="title">Judul</label>
                           <input type="text" class="form-control" id="title" name="title" value="<?php echo $topic->title;?>" required/>
                           <div class="invalid-feedback">
                              judul kosong.
                           </div> 
                     </div>
                     <div class="form-group">
                           <label>Slug (url friendly)</label>
                           <input type="text" id="slug" name="th_slug"  value="<?php echo $topic->th_slug; ?>" class="form-control" required>
                           <div class="invalid-feedback">
                              slug kosong.
                           </div>
                     </div> 
                     <div class="form-group">  
                           <label>Kategori</label>
                           <select class="form-control" name="category_id" required>
                              <option value="">-- none --</option>
                              <?php foreach ($categories as $cat): ?>
                              <?php if ($cat['id'] == $topic->category_id): ?>
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
                              <option value="">-- none --</option>
                              <option value="Tanya" <?php if($topic->jenis_topic == "Tanya") {echo "SELECTED";}?>>Tanya</option>
                              <option value="Diskusi" <?php if($topic->jenis_topic == "Diskusi") {echo "SELECTED";}?>>Diskusi</option>
                              <option value="Berbagi" <?php if($topic->jenis_topic == "Berbagi") {echo "SELECTED";}?>>Berbagi</option>
                              
                           </select>
                           <div class="invalid-feedback">
                                 Pilih jenis topik.
                              </div> 
                           </div>
                     </div>
                     <div class="form-group">
                           <label>Post pertama</label>
                              <textarea name="f_post" rows="70" style="height:180px;" id="post" class="form-control edit" required><?php echo $topic->f_post; ?></textarea>
                              <div class="invalid-feedback">
                                 post balas kosong.
                              </div> 
                     </div>
                     </div>
                     <div class="modal-footer">
                           <input type="submit" name="btn-edit-th" class="btn btn-primary btn-sm" value="Simpan"/>
                           <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"> Batal</button>
                     </div>
                  </form>
               </div>
         </div>
      </div>
   </div>
<?php endforeach; ?>

<!-- modal hapus topic -->
<div class="modal fade" id="modalConfirm">
   <div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-header">
         <h3>Hapus topic</h3>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <p style="text-align: center;">
         Apakah anda yakin ingin menghapus topic ini ?
         <br/>
         <span style="font-weight: bold;color:#ff0000;font-size: 14px;">Semua post di topic ini akan dihapus<span>
      </p>
      </div>
      <div class="modal-footer" style="text-align: center;">
         <a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Batal</a>
         <a href="#" class="btn btn-danger btn-sm" id="btn-delete">Hapus</a>
      </div>
   </div>
   </div>
</div>

   <!-- texteditor -->
   <script type="text/javascript" src="<?php echo base_url(); ?>resources/tinymce/js/tinymce/tinymce.min.js"></script>
   
   <script>
      tinymce.init({
         selector: ".edit",
         theme: 'modern',
         plugins: [
               "advlist autolink lists link image charmap print preview anchor",
               "searchreplace visualblocks code fullscreen",
               "insertdatetime media table contextmenu paste jbimages", "emoticons", "codesample"
         ],

         codesample_languages: [
               {text: 'HTML/XML', value: 'markup'},
               {text: 'JavaScript', value: 'javascript'},
               {text: 'CSS', value: 'css'},
               {text: 'PHP', value: 'php'},
               {text: 'Ruby', value: 'ruby'},
               {text: 'Python', value: 'python'},
               {text: 'Java', value: 'java'},
               {text: 'C', value: 'c'},
               {text: 'C#', value: 'csharp'},
               {text: 'C++', value: 'cpp'}
         ],

         toolbar: "insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages | emoticons | codesample",
         
         codesample_dialog_height: 400,
         codesample_dialog_width: 600
      });
   </script>
   <!-- end texteditor -->

<!-- nav-pill -->
   <script>
      $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
         var id = $(e.target).attr("href");
         localStorage.setItem('selectedTab', id)
      });

      var selectedTab = localStorage.getItem('selectedTab');
      if(selectedTab != null){
         $('a[data-toggle="pill"][href="' + selectedTab + '"]').tab('show');
      }
   </script>
<!-- end -->

<!-- modal hapus topic-->
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
               window.location = '<?php echo site_url('user/topic_delete'); ?>/'+topic_id;
         });
      })
   </script>
<!-- end -->

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