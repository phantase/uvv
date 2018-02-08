        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Union Inter Régionale Vovinam Viet Vo Dao
            <small><?php echo _('Membership area'); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> <?php echo _('Home'); ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
			
			<?php if(isset($authenticationMessage)){ ?>
			<!-- Authentication Box -->
			<div class="box box-solid <?php echo $authenticationMessage['class']; ?>">
			  <div class="box-header with-border">
				<h3 class="box-title"><?php echo $authenticationMessage['title']; ?></h3>
				<div class="box-tools pull-right">
				  <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="<?php echo _('Remove'); ?>"><i class="fa fa-times"></i></button>
				</div><!-- /.box-tools -->
			  </div><!-- /.box-header -->
			  <div class="box-body">
				<?php echo $authenticationMessage['body']; ?>
			  </div><!-- /.box-body -->
			</div><!-- /.box -->
			<?php } ?>
			
			<?php if( isAdmin() ){ ?>
			<div class="row">
				<?php include_once('controllers/currentseason.php'); // Just in case... ?>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3><?php echo $season[0]['nom']; ?></h3>
							<p><?php echo _('Current season'); ?></p>
						</div>
						<div class="icon">
							<i class="ion ion-calendar"></i>
						</div>
						<a href="seasons" class="small-box-footer"><?php echo _('More info'); ?> <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
				<?php include_once('controllers/unpayedinvoices.php'); // Just in case... ?>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3><?php echo $nbFactures; ?></h3>
							<p><?php echo _('Unpayed Invoices'); ?></p>
						</div>
						<div class="icon">
							<i class="ion ion-ios-paper-outline"></i>
						</div>
						<a href="invoices/unpayed" class="small-box-footer"><?php echo _('More info'); ?> <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
				<?php include_once('controllers/allmembers.php'); // Just in case... ?>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
							<h3><?php echo $nbMembers; ?></h3>
							<p><?php echo _('Members'); ?></p>
						</div>
						<div class="icon">
							<!--<i class="ion ion-person"></i>-->
							<i class="fa fa-users"></i>
						</div>
						<a href="users" class="small-box-footer"><?php echo _('More info'); ?> <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
			</div>
			<?php } ?>
			
          <!-- Your Page Content Here -->

        </section><!-- /.content -->