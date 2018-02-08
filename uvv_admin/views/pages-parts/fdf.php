        <?php if( !$printmode ) { ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo _('Fête de Fondation'); ?>
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-ticket"></i> <?php echo _('Home'); ?></a></li>
            <li class="active"><?php echo _('Fête de Fondation'); ?></li>
          </ol>
        </section>
        <?php } ?>
        <!-- Main content -->
        <section class="content">

        <?php 
            if(isAdmin()){
                include_once('controllers/fdf.php');
        ?>
            <div class="row">
                <div class="col-xs-12">
                  <div class="box">
<?php if( !$printmode ) { ?>
                    <div class="box-header">
                      <i class="ion ion-ios-paper-outline"></i>
                      <h3 class="box-title"><?php echo sprintf(_('Inscrits (%s) [%s hommes | %s femmes]'),$nbInscrits, $counts['hommes'],$counts['femmes']); ?></h3>
                    </div>
                    <!-- /.box-header -->
<?php } ?>
                    <!--<div class="box-body table-responsive no-padding">-->
                    <div class="box-body">
                      <table class="table table-hover" id="invoices-table">
                        <thead><tr>
<?php if( !$printmode ) { ?>
                          <th><?php echo _('ID'); ?></th>
<?php } ?>
                          <th><?php echo _('Club'); ?></th>
                          <th><?php echo _('Licence'); ?></th>
                          <th><?php echo _('Name'); ?> <?php echo _('Prénom'); ?></th>
                          <th><?php echo _('Date de naissance'); ?></th>
                          <th><?php echo _('Courriel'); ?></th>
                          <th><i class="fa fa-venus-mars" data-toggle="tooltip" title="<?= _('Sexe'); ?>"></i></th>
                          <th><i class="fa fa-info" data-toggle="tooltip" title="<?= _('Grade'); ?>"></i></th>
                          <th><i class="fa fa-mortar-board" data-toggle="tooltip" title="<?= _('Stage'); ?>"></i></th>
                          <th><i class="fa fa-trophy" data-toggle="tooltip" title="<?= _('Compétition'); ?>"></i></th>
                          <th><i class="fa fa-bed" data-toggle="tooltip" title="<?= _('Nuit'); ?>"></i></th>
                          <th><i class="fa fa-glass" data-toggle="tooltip" title="<?= _('Samedi soir'); ?>"></i></th>
                          <th><i class="fa fa-cutlery" data-toggle="tooltip" title="<?= _('Dimanche midi'); ?>"></i></th>
                          <th><i class="fa fa-comments" data-toggle="tooltip" title="<?= _('Commentaires'); ?>"></i></th>
                          <th><?php echo _('Inscrit le'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
        <?php foreach($inscrits as $inscrit) { ?>
                        <tr>
<?php if( !$printmode ) { ?>
                            <!--<td><a href="fdf/<?= $inscrit['id'] ?>"><?= $inscrit['id'] ?></a></td>-->
                            <td><?= $inscrit['id'] ?></td>
<?php } ?>
                            <td><img src="img/users/user-<?= $inscrit['numclub'] ?>.jpg" class="club-icon" alt="<?= $inscrit['club'] ?>"/>
                                <a href="fdf/invoice/<?= $inscrit['numclub'] ?>"><?= $inscrit['club'] ?></a></td>
                            <td><?= $inscrit['numlicence']; ?></td>
                            <td><?= $inscrit['nom']; ?> <?= $inscrit['prenom'] ?></td>
                            <td><?= $inscrit['datenaissance'] ?></td>
                            <td><?= $inscrit['mail'] ?></td>
                            <td>
                                <?php if($inscrit['categorie']==1){ ?>
                                <i class="fa fa-mars" style="color:blue;"></i>
                                <span style="display:none;"><?= _('Homme') ?></span>
                                <?php } else { ?>
                                <i class="fa fa-venus" style="color:pink;"></i>
                                <span style="display:none;"><?= _('Femme') ?></span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php 
                                    if($inscrit['gradecourt']=='M'){ 
                                        $color = 'red';
                                    } else if($inscrit['gradecourt'][1]=='J'){
                                        $color = 'yellow';
                                    } else {
                                        $color = 'blue';
                                    }
                                ?>
                                    <span class="badge bg-<?= $color ?>" data-toggle="tooltip" title="<?=$inscrit['grade']?>"><?=$inscrit['gradecourt']?></span>
                            </td>
                            <td>
                                <?php if($inscrit['stage']){ ?>
                                <i class="fa fa-check-square" style="color:green;"></i>
                                <?php } else { ?>
                                <i class="fa fa-square" style="color:red;"></i>
                                <?php } ?>
                                <span style="display:none;"><?= $inscrit['stage'] ?></span>
                            </td>
                            <td>
                                <?php if($inscrit['compet']){ ?>
                                <i class="fa fa-check-square" style="color:green;"></i>
                                <?php } else { ?>
                                <i class="fa fa-square" style="color:red;"></i>
                                <?php } ?>
                                <span style="display:none;"><?= $inscrit['compet'] ?></span>
                            </td>
                            <td>
                                <?php if($inscrit['nuit']){ ?>
                                <i class="fa fa-check-square" style="color:green;"></i>
                                <?php } else { ?>
                                <i class="fa fa-square" style="color:red;"></i>
                                <?php } ?>
                                <span style="display:none;"><?= $inscrit['nuit'] ?></span>
                            </td>
                            <td>
                                <?php if($inscrit['samedi']){ ?>
                                <i class="fa fa-check-square" style="color:green;"></i>
                                <?php } else { ?>
                                <i class="fa fa-square" style="color:red;"></i>
                                <?php } ?>
                                <span style="display:none;"><?= $inscrit['samedi'] ?></span>
                            </td>
                            <td>
                                <?php if($inscrit['dimanche']){ ?>
                                <i class="fa fa-check-square" style="color:green;"></i>
                                <?php } else { ?>
                                <i class="fa fa-square" style="color:red;"></i>
                                <?php } ?>
                                <span style="display:none;"><?= $inscrit['dimanche'] ?></span>
                            </td>
                            <td>
                                <?php if($inscrit['commentaires']){ ?>
                                <span class="badge bg-light-blue" data-toggle="tooltip" title="<?=$inscrit['commentaires']?>">1</span>
                                <?php } ?>
                            </td>
                            <td><?= $inscrit['inscription'] ?></td>
                        </tr>
        <?php } ?>
                        </tbody>
<?php if( !$printmode ) { ?>
                        <tfoot>
                            <tr>
                                <th colspan="8"></th>
                                <th><?= $counts["stage"] ?></th>
                                <th><?= $counts["compet"] ?></th>
                                <th><?= $counts["nuit"] ?></th>
                                <th><?= $counts["samedi"] ?></th>
                                <th><?= $counts["dimanche"] ?></th>
                                <th coslpan="2"></th>
                            </tr>
                        </tfoot>
<?php } ?>
                      </table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
            </div>
        <?php if( !$printmode ) { ?>
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="fdf/print" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> <?php echo _('Print'); ?></a>
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