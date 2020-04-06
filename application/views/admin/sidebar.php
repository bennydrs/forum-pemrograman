<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/admin_assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/admin_assets/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>assets/admin_assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/admin_assets/js/jquery.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('topic'); ?>">Forum Pemrograman</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('bds_username'); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo site_url('profil_member/profil/'.$this->session->userdata('bds_user_id')); ?>"><i class="fa fa-fw fa-user"></i> Profil</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('profil_member/pesan/'.$this->session->userdata('bds_user_id')); ?>"><i class="fa fa-fw fa-envelope"></i> Pesan</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo site_url('user/logout'); ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>

            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="<?php echo site_url('admin'); ?>"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/user_view'); ?>"><i class="fa fa-fw fa-table"></i> Kelola Member</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/topic_view'); ?>"><i class="fa fa-fw fa-table"></i> Kelola Topik</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/post_view'); ?>"><i class="fa fa-fw fa-table"></i> Kelola Post</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/category_view'); ?>"><i class="fa fa-fw fa-table"></i> Kelola Kategori</a>
                    </li>
                 
                    <li>
                        <a href="<?php echo site_url('admin/admin_view'); ?>"><i class="fa fa-fw fa-table"></i> Kelola Admin</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <style>#page-wrapper{ padding: 30px; padding-bottom:120px;}</style>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        
                    <?php echo $contents;?>
                    </div>
                </div>
                <!-- /.row -->

                    
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

   
   <!-- Bootstrap Core JavaScript -->
   <script src="<?php echo base_url(); ?>assets/admin_assets/js/bootstrap.js"></script>

   <script>
        $(".nav a").on("click", function(){
            $(".nav").find(".active").removeClass("active");
            $(this).parent().addClass("active");
        })
   </script>

</body>

</html>
