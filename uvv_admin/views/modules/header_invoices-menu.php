<?php include_once('controllers/unpayedinvoices.php'); ?>
              <!-- Factures: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-list-alt"></i>
<?php if( $nbFactures > 0 ) { ?>
                  <span class="label label-warning"><?php echo $nbFactures; ?></span>
<?php } ?>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"><?php echo sprintf(_('%s invoices unpayed'),$nbFactures); ?></li>
<?php foreach($unpayedinvoices as $cle => $singleunpayedinvoice) { ?>
                  <li>
                    <!-- inner menu: contains the messages -->
                    <ul class="menu">
                      <li><!-- start unpayedinvoice -->
                        <a href="invoice/<?php echo $singleunpayedinvoice['numunpayedinvoice']; ?>">
                          <div class="pull-left">
                            <!-- User Image -->
                            <img src="img/users/user-<?php echo $singleunpayedinvoice['club']; ?>.jpg" class="img-circle" alt="User Image"/>
                          </div>
                          <!-- Message title and timestamp -->
                          <h4>
                            <?php echo $singleunpayedinvoice['nom']; ?>
                            <small><i class="fa fa-clock-o"></i> <?php echo sprintf(_('%s days'),$singleunpayedinvoice['interval']->format('%R%a')); ?></small>
                          </h4>
                          <!-- The message -->
                          <p><?php echo sprintf(_('%s licences - %s &euro;'),$singleunpayedinvoice['nblicences'],$singleunpayedinvoice['montant']); ?></p>
                        </a>
                      </li><!-- end message -->
                    </ul><!-- /.menu -->
                  </li>
<?php } ?>
                  <li class="footer"><a href="invoices/unpayed"><?php echo _('See All Invoices'); ?></a></li>
                </ul>
              </li><!-- /.unpayedinvoice-menu -->
