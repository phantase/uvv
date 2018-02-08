        <?php if( !$printmode ) { ?>
        <!-- Content Header (Page header) -->
        <section class="content-header no-print">
          <h1>
            <?php echo _('Fête de Fondation - Facture'); ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="home">
                    <i class="fa fa-dashboard"></i> <?php echo _('Home'); ?>
                </a></li>
            <li><a href="fdf">
                <?php echo _('Fête de Fondation'); ?>
                </a></li>
            <li class="active">
                <?php echo _('Invoice'); ?>
            </li>
          </ol>
        </section>
        <?php } ?>
        
        <?php 
            if(isAdmin()){
                include_once('controllers/fdf_invoice.php');
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
                <strong><?php echo $invoice['club']; ?></strong><br>
                <?php echo $tresorier['nomprenom']; ?><br>
                <?php echo $tresorier['adrvoie']; ?><br>
                <?php echo $tresorier['adrcp']; ?> <?php echo $tresorier['adrville']; ?><br>
                <?php echo _('Email:'); ?> <?php echo $tresorier['mail']; ?>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b><?php echo _('Invoice'); ?> :</b>  FdF2016 - <?php echo $invoice['club']; ?><br>
              <br>
              <b><?php echo _('Participants :'); ?></b> <?php echo $invoice['participants']; ?><br>
              <b><?php echo _('Payment Due:'); ?></b> Immédiat<br>
            </div><!-- /.col -->
          </div><!-- /.row -->
          
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th><i class="fa fa-mortar-board fa-lg"></i></th>
                        <th><i class="fa fa-trophy fa-lg"></i></th>
                        <th><i class="fa fa-bed fa-lg"></i></th>
                        <th><i class="fa fa-glass fa-lg"></i></th>
                        <th><i class="fa fa-cutlery fa-lg"></i></th>
                        <th>Total Vo-sinh</th>
                    </tr>
                </thead>
                <tbody>
        <?php $curcat = ""; ?>
        <?php foreach($invoice['inscrits'] as $cle => $inscrit) { ?>
                  <tr>
                    <td><?php echo $inscrit['nom']." ".$inscrit['prenom']; ?></td>
                    <td><?= $inscrit['stage']?10:0 ?>€</td>
                    <td><?= $inscrit['compet']?10:0 ?>€</td>
                    <td><?= $inscrit['nuit']?30:0 ?>€</td>
                    <td><?= $inscrit['samedi']?15:0 ?>€</td>
                    <td><?= $inscrit['dimanche']?10:0 ?>€</td>
                    <td><?php echo $inscrit['total']; ?>€</td>
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
                <b>Merci de rappeler le nom du club lors du règlement ( à marquer a dos du chèque).</b><br/><br/>
                Le règlement sera à mettre à l’ordre de : UI VVNVVD et à envoyer au vice-secrétaire de l’association :<br/>
                <i>Jean-Sébastien PETER<br/>
                Domaine d’Ambert<br/>
                45400 Chanteau</i>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-6">
              <p class="lead"><?php echo _('Somme dûe'); ?></p>
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
              <a href="fdf/invoice/<?= $invoice['numclub'] ?>/print" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> <?php echo _('Print'); ?></a>
            </div>
          </div>
        <?php } ?>

        </section><!-- /.content -->
        
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