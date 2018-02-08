        <?php if( !$printmode ) { ?>
        <!-- Content Header (Page header) -->
        <section class="content-header no-print">
          <h1>
            <?php echo _('Invoice'); ?> 
            <small>#<?php echo filter_input(INPUT_GET,'invoicenumber'); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="home">
                    <i class="fa fa-dashboard"></i> <?php echo _('Home'); ?>
                </a></li>
            <li><a href="invoices">
                <?php echo _('Invoices'); ?>
                </a></li>
            <li class="active">
                <?php echo _('Invoice'); ?>  #<?php echo filter_input(INPUT_GET,'invoicenumber'); ?>
            </li>
          </ol>
        </section>
        <?php } ?>
        
        <?php 
            if(isLogged()){
                include_once('controllers/invoice.php');
                if( $invoice != null ) {
        ?>
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="ion ion-ios-paper-outline"></i> <?php echo _('Union Vovinam Viet Vo Dao'); ?>
                <small class="pull-right"><b><?php echo _('Date:'); ?></b> <?php echo $invoice['datefac']; ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <?php echo _('From'); ?>
              <address>
                <strong><?php echo _('Union Vovinam Viet Vo Dao'); ?></strong><br>
                Jean-Sébastien PETER<br>
                Domaine d’Ambert<br>
                45400 Chanteau<br>
                <?php echo _('Email:'); ?> tresorier@unionvovinam.fr
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <?php echo _('To'); ?>
              <address>
                <strong><?php echo $invoice['nom']; ?></strong><br>
                <?php echo $tresorier['nomprenom']; ?><br>
                <?php echo $tresorier['adrvoie']; ?><br>
                <?php echo $tresorier['adrcp']; ?> <?php echo $tresorier['adrville']; ?><br>
                <?php echo _('Email:'); ?> <?php echo $tresorier['mail']; ?>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b><?php echo _('Invoice'); ?>  #<?php echo filter_input(INPUT_GET,'invoicenumber'); ?></b><br>
              <br>
              <b><?php echo _('Licences:'); ?></b> <?php echo $invoice['nblicences']; ?><br>
              <b><?php echo _('Payment Due:'); ?></b> <?php echo $invoice['datedue']; ?><br>
            </div><!-- /.col -->
          </div><!-- /.row -->
          
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <tbody>
        <?php $curcat = ""; ?>
        <?php foreach($adherents as $cle => $adherent) { ?>
                      <?php 
                            if( $curcat != $adherent['categorieid'] ){ 
                                $curcat = $adherent['categorieid'];
                      ?>
                  <tr>
                      <td colspan="4">
                          <h3><?php echo $adherent['categorie']; ?></h3>
                      </td>
                  </tr>
                      <?php } ?>
                  <tr>
                    <td><?php echo $adherent['adherent']; ?></td>
                    <td><?php echo $adherent['nom']; ?> <?php echo $adherent['prenom']; ?></td>
                    <td><abbr title="<?php echo $adherent['grade']; ?>"><?php echo $adherent['gradecourt']; ?></abbr></td>
                    <td><?php echo $adherent['montant']; ?> €</td>
                  </tr>
        <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
          
          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
              <p class="lead"><?php echo _('Payment Methods:'); ?></p>
              <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                <b>Merci de rappeler le n° de la facture lors de l’envoi du règlement ( à marquer a dos du chèque).</b><br/><br/>
                Le règlement sera à mettre à l’ordre de : UI VVNVVD et à envoyer au vice-secrétaire de l’association :<br/>
                <i>Jean-Sébastien PETER<br/>
                Domaine d’Ambert<br/>
                45400 Chanteau</i>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-6">
              <p class="lead"><?php echo _('Amount Due'); ?> <?php echo $invoice['datedue']; ?></p>
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%"><?php echo _('Total:'); ?></th>
                    <td><?php echo $invoice['total']; ?> €</td>
                  </tr>
                </table>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->

        <?php if( !$printmode ) { ?>
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="invoice/<?php echo filter_input(INPUT_GET,'invoicenumber'); ?>/print" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> <?php echo _('Print'); ?></a>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo _('Generate PDF'); ?></button>
            </div>
          </div>
        <?php } ?>

        </section><!-- /.content -->
        
        <?php if( !$printmode ) { ?>
        <?php if(isAdmin() ) { ?>
        <section class="invoice">
          <div class="row no-print">
            <div class="col-xs-12">
              <strong><?php echo _('Administration'); ?></strong>
        <?php if($invoice['paye']) { ?>
              <button class="btn btn-danger pull-right disabled" style="margin-right: 5px;"><i class="fa fa-close"></i> <?php echo _('Cannot cancel'); ?></button>
              <button class="btn btn-success pull-right disabled" style="margin-right: 5px;"><i class="fa fa-check"></i> <?php echo _('Already payed'); ?></button>
        <?php } else { ?>
              <button class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-close"></i> <?php echo _('Cancel invoice'); ?></button>
              <button class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-check"></i> <?php echo _('Mark as payed'); ?></button>
        <?php } ?>
            </div>
          </div>
        </section>
        <?php } ?>
        <br/>
        <?php } ?>
        
                <?php } else { ?>
        <!-- Main content -->
        <section class="content">
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo _('Invoice unavailable'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php echo _('The invoice you try to visualize doesn\'t exist or you don\'t have the right to view it.'); ?>
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