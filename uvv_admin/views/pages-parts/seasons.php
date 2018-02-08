        <?php if( !$printmode ) { ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo _('Seasons'); ?>
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> <?php echo _('Home'); ?></a></li>
            <li class="active"><?php echo _('Seasons'); ?></li>
          </ol>
        </section>
        <?php } ?>

        <!-- Main content -->
        <section class="content">
            
        <?php
            if(isLogged()){
                include_once('controllers/seasons.php');
        ?>
            <div class="row">
                <div class="col-xs-12">
                  <div class="box">
                    <div class="box-header">
                      <i class="ion ion-calendar"></i><h3 class="box-title"><?php echo _('Seasons'); ?></h3>
<?php if( !$printmode ) { ?>
<!--                      <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                          <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                          </div>
                        </div>
                      </div>-->
<?php } ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                      <table class="table table-hover">
                        <tbody><tr>
                          <th><?php echo _('ID'); ?></th>
                          <th><?php echo _('Name'); ?></th>
                          <th><?php echo _('Start'); ?></th>
                          <th><?php echo _('End'); ?></th>
                          <th></th>
                        </tr>
        <?php foreach($seasons as $cle => $singleseason) { ?>
                        <tr>
                            <td><a href="season/<?php echo $singleseason['numsaison']; ?>"><?php echo $singleseason['numsaison']; ?></a></td>
                            <td><?php echo $singleseason['nom']; ?></td>
                            <td><?php echo $singleseason['debut']; ?></td>
                            <td><?php echo $singleseason['fin']; ?></td>
                            <td><?php if( $singleseason['encours'] == 1 ){ ?><span class="badge bg-light-blue"><?php echo _('Current'); ?></span><?php } ?></td>
                        </tr>
        <?php } ?>
                      </tbody></table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
            </div>
        <?php } else { ?>
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo _('Authentication error'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php echo _('You must be logged in to view this page.'); ?>
                    <?php echo _('Please use the menu on the left to log in.'); ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        <?php } ?>
            
        </section><!-- /.content -->