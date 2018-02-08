        <?php if( !$printmode ) { ?>
        <!-- Content Header (Page header) -->
        <section class="content-header no-print">
          <h1>
            <?php echo _('Season'); ?> 
            <small>#<?php echo filter_input(INPUT_GET,'seasonnumber'); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="home">
                    <i class="fa fa-dashboard"></i> <?php echo _('Home'); ?>
                </a></li>
            <li><a href="seasons">
                <?php echo _('Seasons'); ?>
                </a></li>
            <li class="active">
                <?php echo _('Season'); ?>  #<?php echo filter_input(INPUT_GET,'seasonnumber'); ?>
            </li>
          </ol>
        </section>
        <?php } ?>
        
        <?php 
            if(isLogged()){
                include_once('controllers/season.php');
                if( $season != null ) {
        ?>
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="ion ion-calendar"></i> <?php echo _('Season'); ?> <?php echo $season['nom']; ?>
                <small class="pull-right"><b><?php echo _('From:'); ?></b> <?php echo $season['debut']; ?> <b><?php echo _('To:'); ?></b> <?php echo $season['fin']; ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
    
        
        
        
        
        <?php if( !$printmode ) { ?>
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="season/<?php echo filter_input(INPUT_GET,'seasonnumber'); ?>/print" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> <?php echo _('Print'); ?></a>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo _('Generate PDF'); ?></button>
            </div>
          </div>
        <?php } ?>

        </section><!-- /.content -->
                <?php } else { ?>
        <!-- Main content -->
        <section class="content">
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo _('Season unavailable'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php echo _('The season you try to visualize doesn\'t exist or you don\'t have the right to view it.'); ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
                    </section><!-- /.content -->
                <?php } ?>
        <?php } else { ?>
        <!-- Main content -->
        <section class="content">
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo _('Authentication error'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php echo _('You must be logged in to view this page.'); ?>
                    <?php echo _('Please use the menu on the left to log in.'); ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
                    </section><!-- /.content -->
        <?php } ?>