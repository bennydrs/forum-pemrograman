<ol class="breadcrumb">
   <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
   </li>
</ol>

<div class="page-header">
        <center><h3>Selamat Datang Admin <?php echo $this->session->userdata('bds_username')?></h3></center><hr>
</div>

<style>
    .jarak{
        margin-bottom: 100%;
    }
</style>

<div class="row jarak">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $jumlah?></div>
                        <div>Topik</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $jlh_post?></div>
                        <div>Post</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $jlh_member?></div>
                        <div>Member</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $jlh_admin?></div>
                        <div>Admin</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

