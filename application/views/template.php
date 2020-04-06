<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">

	<title><?php echo $title; ?></title>


	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">

	<!-- Custom styles for our template -->

  	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/icon/bootstrap4-glyphicons/css/bootstrap-glyphicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/main.css">
	<!-- Custom styles for our template -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/tinymce/prism.css">
    <script src="<?php echo base_url(); ?>resources/tinymce/prism.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.easing.js"></script>	
	<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	
</head>

<body>
	<!-- Fixed navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
   <div class="container bar">
      <a class="navbar-brand" href="<?php echo site_url('topic'); ?>">Forum Pemrograman</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
         <div class="navbar-nav">
            <a class="nav-item nav-link" href="<?php echo site_url('topic'); ?>">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="<?php echo site_url('topic/create'); ?>">Buat Topik</a>
         
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Kategori
               </a>
               <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                     <?php foreach($categories as $cat): ?>
                        <a class="dropdown-item" href="<?php echo site_url('topic/category/'.$cat['slug']); ?>"><?php echo $cat['name']; ?></a>
                     <?php endforeach; ?>
               </div>
            </li>
            <a class="nav-item nav-link" href="<?php echo site_url('topic/bantuan'); ?>">Bantuan</a>
			<a class="nav-item nav-link" href="<?php echo site_url('topic/about'); ?>">About</a>
         </div>
         <div class="navbar-nav ml-auto">
            <?php if ($this->session->userdata('bds_logged_in') != 1): ?>
               <a class="nav-item nav-link" href="<?php echo site_url('user/login'); ?>">Login</a>
               <a class="nav-item btn btn-outline-primary tombol" href="<?php echo site_url('user/join'); ?>">DAFTAR</a>
            <?php else: ?> 

               <?php if ($this->session->userdata('bds_user_level')=='admin' || $this->session->userdata('bds_user_level')=='super_admin'): ?>
                  <a class="nav-item nav-link" href="<?php echo site_url('admin'); ?>"><i class="glyphicon glyphicon-user"></i> Admin</a>
               <?php else: ?> 
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-user"></i>
                        <?php echo $this->session->userdata('bds_username'); ?>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
                        <a class="dropdown-item" href="<?php echo site_url('profil_member/profil/'.$this->session->userdata('bds_user_id'));?>"><i class="glyphicon glyphicon-user"></i> Profil</a>			
                        <a class="dropdown-item" href="<?php echo site_url('profil_member/pesan/'.$this->session->userdata('bds_user_id'));?>"><i class="glyphicon glyphicon-envelope"></i> Pesan</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('user/logout'); ?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
                     </div>
                  </li>

               <?php endif; ?>                 
            <?php endif; ?>
         </div>
      </div>
   </div>
</nav>

	<!-- container -->
	<div class="container" id="container">

    	<?php echo $contents;?>

	</div>	<!-- /container -->

	<!-- Social links. @TODO: replace by link/instructions in template -->
	<section id="social">
		<div class="container">
			<div class="wrapper clearfix">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_linkedin_counter"></a>
				<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
				</div>
				<!-- AddThis Button END -->
			</div>
		</div>
	</section>
	<!-- /social links -->


	<footer id="footer" class="top-space">

		<div class="footer1">
			<div class="container">
				<div class="row">

					<div class="col-md-3 widget">
						<h3 class="widget-title">Kontak</h3>
						<div class="widget-body">

								<a href="mailto:#">bedaaja2@gmail.com</a><br>
								<br>

						</div>
					</div>

					<!-- <div class="col-md-3 widget">
						<h3 class="widget-title">Follow Us</h3>
						<div class="widget-body">
							<p class="follow-me-icons">
								<a href="http://www.twitter.com/bendama"><i class="fa fa-twitter fa-2"></i></a>


								<a href=""><i class="fa fa-facebook fa-2"></i></a>
							</p>
						</div>
					</div> -->

					<div class="col-md-6 widget">
						<h3 class="widget-title"></h3>
						<div class="widget-body">

						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

		<div class="footer2">
			<div class="container">
				
				<div class="widget-body">
					<p class="text-right">
						Copyright &copy; 2018, Benny Drs
					</p>
				</div>
					
			</div>
		</div>
	</footer>

	<script src="<?php echo base_url(); ?>assets/js/script.js"></script>
</body>
</html>
