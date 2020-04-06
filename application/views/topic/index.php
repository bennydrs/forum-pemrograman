<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <?php if ($type == 'category') : ?>
      <li class="breadcrumb-item">
        <a href="<?php echo site_url('topic'); ?>">Home</a>
        <span class="divider"></span>
      </li>
      <?php $cat_total = count($cat);
      foreach ($cat as $key => $c) : ?>
        <li class="breadcrumb-item">
          <a href="<?php echo site_url('topic/category/' . $c['slug']); ?>"><?php echo $c['name']; ?></a>
          <?php if ($key + 1 != $cat_total) : ?>
            <span class="divider">/</span>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    <?php else : ?>
      <li class="breadcrumb-item active">
        <a href="<?php echo site_url('topic'); ?>">Home</a>
      </li>
    <?php endif; ?>
  </ol>
</nav>
<br>

<?php
function time_ago($date)
{

  if (empty($date)) {
    return "No date provided";
  }

  $periods = array("Detik", "Minggu", "Jam", "Hari", "Minggu", "Bulan", "Tahun", "dekade");
  $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
  $now = time();
  $unix_date = strtotime($date);

  // check validity of date

  if (empty($unix_date)) {
    return "Bad date";
  }

  // is it future date or past date
  if ($now > $unix_date) {
    $difference = $now - $unix_date;
    $tense = "lalu";
  } else {
    $difference = $unix_date - $now;
    $tense = "from now";
  }
  for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
    $difference /= $lengths[$j];
  }
  $difference = round($difference);


  return "$difference $periods[$j] {$tense}";
}
?>


<div class="row">
  <div class="col-xs-12 col-md-9">
    <form method="get" action="<?php echo site_url('topic/cari'); ?>" class="needs-validation" novalidate>
      <div class="input-group">
        <input type="text" name="cari" class="form-control" placeholder="Cari Topik" required>
        <div class="input-group-append">
          <button class="btn btn-primary" style="margin:0;">Cari</button>
        </div>
        <div class="invalid-feedback">
          form pencarian kosong.
        </div>
      </div>
    </form>
    <br>


    <!-- topic -->
    <div class="card depan">
      <!-- List group -->
      <ul class="list-group list-group-flush">
        <?php foreach ($topics as $topic) : ?>
          <li class="list-group-item">

            <div class="media">
              <?php
              if (empty($topic->foto)) {
                echo "<img class='mr-3 rounded-circle float-left' src='" . base_url("uploads/kosong.jpg") . "'/>";
              } else {
                echo "<img class='mr-3 rounded-circle float-left' src='" . base_url("uploads/" . $topic->foto) . "'/>";
              }
              ?>

              <div class="media-body">
                <h5 class="mt-0"><a href="<?php echo site_url('topic/talk/' . $topic->th_slug); ?>"><?php echo $topic->title; ?></a></h5>
                <div class="info">
                  <div class="kat">
                    <a class="badge badge-pill badge-success" data-toggle="tooltip" title="Kategori" href="<?php echo site_url('topic/category/' . $topic->category_slug); ?>"><?php echo $topic->category_name; ?></a>
                    <span class="badge badge-info" data-toggle="tooltip" title="jenis topic"><?php echo $topic->jenis_topic ?></span>

                    <span>
                      &nbsp;
                      <i data-toggle="tooltip" title="jumlah post balas" class="glyphicon glyphicon-comment"></i>
                      <?php $query = $this->db->query("SELECT * 
                                       FROM tb_post WHERE topic_id = '$topic->topic_id'");
                      echo $query->num_rows();
                      ?>


                      &nbsp;
                      <i class="glyphicon glyphicon-eye-open"></i> <?php echo $topic->hit_count; ?>
                    </span>
                    <br>
                    <span class="penulis">
                      <a href="<?php echo site_url('profil_member/profil/' . $topic->user_id); ?>"><?php echo $topic->username; ?>,</a>
                      <span data-toggle="tooltip" title="<?php echo tgl_indo(($topic->date_add)); ?>">
                        <?php echo time_ago($topic->date_add); ?>
                      </span>
                    </span>
                  </div>

                </div>
              </div>
            </div>

          </li>
        <?php endforeach; ?>
      </ul>

    </div>
    <!-- akhir topic -->
    <br />

    <nav aria-label="...">
      <ul class="pagination pagination-sm">
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


  <div class="col-xs-12 col-md-3">
    <div class="card kategori">
      <div class="card-header text-white bg-primary">
        <b data-toggle="tooltip" title="menampilkan topik sesuai kategori">Kategori</b>
      </div>
      <ul class="list-group">
        <?php foreach ($categories as $cat) : ?>
          <li class="list-group-item">

            <a href="<?php echo site_url('topic/category/' . $cat['slug']); ?>"><?php echo $cat['name']; ?></a>
          </li>
        <?php endforeach; ?>

      </ul>
    </div>
  </div>

</div>

<script>
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>