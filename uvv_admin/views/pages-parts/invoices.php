        <?php if( !$printmode ) { ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo _('Invoices'); ?>
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> <?php echo _('Home'); ?></a></li>
            <li class="active"><?php echo _('Invoices'); ?></li>
          </ol>
        </section>
        <?php } ?>

        <!-- Main content -->
        <section class="content">

        <?php 
        
            if(isLogged()){
                include_once('controllers/invoices.php');
                
                $invoiceFor = sprintf(_('Invoices for %s'),$_SESSION['clubnom']);
                if(isAdmin())
                    $invoiceFor = _('Invoices for everybody');
                
                $invoiceStatus = _('Payed or Not');
                $pagepath = 'invoices';
                if( filter_has_var(INPUT_GET, 'payed') ){
                    if( filter_input(INPUT_GET, 'payed')==='yes' ){
                        $invoiceStatus = _('Payed');
                        $pagepath = 'invoices/payed';
                    } else if( filter_input(INPUT_GET, 'payed')==='no' ){
                        $invoiceStatus = _('Not payed');
                        $pagepath = 'invoices/unpayed';
                    }
                }
        ?>
            <div class="row">
                <div class="col-xs-12">
                  <div class="box">
                    <div class="box-header">
                      <i class="ion ion-ios-paper-outline"></i>
                      <h3 class="box-title"><?php echo $invoiceFor; ?> (<?php echo $invoiceStatus; ?>)</h3>
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
                    <!--<div class="box-body table-responsive no-padding">-->
                    <div class="box-body">
                      <table class="table table-hover" id="invoices-table">
                        <thead><tr>
                          <th><?php echo _('ID'); ?></th>
                          <th><?php echo _('Club'); ?></th>
                          <th><?php echo _('Amount'); ?></th>
                          <th><?php echo _('Licences'); ?></th>
                          <th><?php echo _('Date'); ?></th>
                          <th><?php echo _('Season'); ?></th>
                          <th><?php echo _('Status'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
        <?php foreach($allinvoices as $cle => $singleinvoice) { ?>
                        <tr>
                            <td><a href="invoice/<?php echo $singleinvoice['numfacture']; ?>"><?php echo $singleinvoice['numfacture']; ?></a></td>
                            <td>
                                <img src="img/users/user-<?php echo $singleinvoice['club']; ?>.jpg" class="club-icon" alt="<?php echo $singleinvoice['nom']; ?>"/>
                                <?php echo $singleinvoice['nom']; ?>
                            </td>
                            <td><?php echo $singleinvoice['montant']; ?> &euro;</td>
                            <td><span class="badge bg-light-blue"><?php echo $singleinvoice['nblicences']; ?></span></td>
                            <td><?php echo $singleinvoice['datefact']; ?></td>
                            <td><?php echo $singleinvoice['saison']; ?></td>
                            <td>
                                <?php if( $singleinvoice['paye'] == 0 ){ ?>
                                <span class="label label-danger" style="margin-right: 5px;"><?php echo _('Not payed'); ?></span>
                                <small><i class="fa fa-clock-o"></i> <?php echo sprintf(_('%s days'),$singleinvoice['interval']->format('%R%a')); ?></small>
                                <?php } else { ?>
                                <span class="label label-success"><?php echo _('Payed'); ?></span>
                                <?php } ?>
                            </td>
                        </tr>
        <?php } ?>
                      </tbody></table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
            </div>
        <?php if( !$printmode ) { ?>
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="<?php echo $pagepath; ?>/print" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> <?php echo _('Print'); ?></a>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo _('Generate PDF'); ?></button>
            </div>
          </div>
        <?php } ?>
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