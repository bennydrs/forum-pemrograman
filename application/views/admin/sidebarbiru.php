<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">

	<title><?php echo $title; ?></title>

	<!-- <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/"> -->

	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-theme.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
	<!-- Custom styles for our template -->
	<!-- <script src="<//?/php echo base_url(); ?>assets/js/bootstrap.js"></script> -->
  <script src="<?php echo base_url(); ?>assets/js/jquery.1.8.3.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<![endif]-->
</head>

<body class="home">
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="<?php echo site_url('thread'); ?>">Forum Pemrograman</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li class="active"><a href="<?php echo site_url('thread'); ?>">Home</a></li>
					<li><a href="<?php echo site_url('thread/create'); ?> "><span class="glyphicon glyphicon-pencil"></span> Buat Thread</a></li>
					<li><a href="<?php echo site_url('artikel'); ?>">Artikel</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Kategori <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php foreach($categories as $cat): ?>
							<li><a href="<?php echo site_url('thread/category/'.$cat['slug']); ?>"><?php echo $cat['name']; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</li>
                  <?php if ($this->session->userdata('admin_area') != 0): ?>
                    <li><a href="<?php echo site_url('admin'); ?>"><span class="glyphicon glyphicon-user"></span> Admin</a></li>
                      <?php else: ?>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> User<span class="caret"></span></a>
                          <ul class="dropdown-menu">

                            <li><a href="<?php echo site_url('user/thread_view/'.$this->session->userdata('bds_user_id'));?>">Thread Saya</a></li>
                            <li><a href="<?php echo site_url('user/user_view/'.$this->session->userdata('bds_user_id'));?>">Profil</a></li>
                            <li><a href="<?php echo site_url('user/profil_edit/'.$this->session->userdata('bds_user_id'));?>">Edit Profil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                        </li>
                        <?php endif; ?>
                    <li><a href="<?php echo site_url('user/logout'); ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        

				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
	<!-- /.navbar -->

	<!-- Header -->

	<style>
	.side{
		margin-left: 0;
		
		width: 98%;
	}
	</style>
 
<div class="container side">
		


		<div class="row">

			<!-- Sidebar -->
			<aside class="col-md-3 sidebar sidebar-left ">

				<div class="row widget">
					<div class="col-xs-11">
            <ul class="nav nav-pills nav-stacked card">
              <li class="active"><a href="javascript://">PROFIL</a></li>
							<li><a href="<?php echo site_url('admin/profil_admin/'.$this->session->userdata('bds_user_id')); ?>">Profil</a></li>
							<li><a href="<?php echo site_url('chat/pesan/'.$this->session->userdata('bds_user_id')); ?>">Pesan</a></li>
							<li><a href="<?php echo site_url('user/thread_view/'.$this->session->userdata('bds_user_id'));?>">Thread Saya</a></li>
							<li><a href="<?php echo site_url('user/post_view/'.$this->session->userdata('bds_user_id'));?>">Post Saya</a></li>
								
              <br>
							<li class="active"><a href="javascript://">KELOLA</a></li>
							<li><a href="<?php echo site_url('admin/artikel_view'); ?>">Kelola Artikel</a></li>
							<li><a href="<?php echo site_url('admin/user_view'); ?>">Kelola User</a></li>
							<li><a href="<?php echo site_url('admin/category_view'); ?>">Kelola Kategori</a></li>
							<li><a href="<?php echo site_url('admin/thread_view'); ?>">Kelola Thread</a></li>
							<li><a href="<?php echo site_url('admin/post_view'); ?>">Kelola Post</a></li>
								
          	</ul>
					</div>
				</div>
		</aside>
			<!-- /Sidebar -->

			<!-- Article main content -->
			<article class="col-md-9 maincontent">

				<?php echo $contents;?>
			</article>
			<!-- /Article -->

		</div>
</div>	<!-- /container -->
  


  <footer id="footer" class="top-space">

    <div class="footer1">
      <div class="container">
        <div class="row">

          <div class="col-md-3 widget">
						<h3 class="widget-title">Contact</h3>
						<div class="widget-body">

								<a href="mailto:#">bedaaja2@gmail.com</a><br>
								<br>

							</p>
						</div>
					</div>

					<div class="col-md-3 widget">
						<h3 class="widget-title">Follow me</h3>
						<div class="widget-body">
							<p class="follow-me-icons">
								<a href="http://www.twitter.com/bendama"><i class="fa fa-twitter fa-2"></i></a>


								<a href=""><i class="fa fa-facebook fa-2"></i></a>
							</p>
						</div>
					</div>

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
        <div class="row">

          <div class="col-md-6 widget">
						<div class="widget-body">
							<p class="simplenav">
								<a href="#">Home</a> |
								<a href="about.html">About</a> |

								<a href="contact.html">Contact</a> <?php if ($this->session->userdata('bds_logged_in') != 1): ?>|
								<b><a href="<?php echo site_url('user/join'); ?>">Sign up</a></b>
                <?php else: ?>
                <?php endif; ?>
							</p>
						</div>
					</div>

					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="text-right">
								Copyright &copy; 2018, Benny Drs
							</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

  </body>
  </html>
