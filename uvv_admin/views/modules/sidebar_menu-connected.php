          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header"><?php echo _('NAVIGATION'); ?></li>
            <!-- Optionally, you can add icons to the links -->
            <li <?php if($action=="home"){ ?> class="active" <?php } ?>>    
                <a href="home"><i class='fa fa-home'></i> <span><?php echo _('Home'); ?></span></a>
            </li>
            <li <?php if($action=="invoices"){ ?> class="active" <?php } ?>>
                <a href="invoices">
                    <i class='ion ion-ios-paper-outline'></i>
                    <span><?php echo _('Invoices'); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="invoices"><?php echo _('All invoices'); ?></a></li>
                    <li><a href="invoices/payed"><?php echo _('Payed invoices'); ?></a></li>
                    <li><a href="invoices/unpayed"><?php echo _('Unpayed invoices'); ?></a></li>
                </ul>
            </li>
            <?php if(isAdmin()){ ?>
            <li <?php if($action=="fdf"){ ?> class="active" <?php } ?>>
                <a href="fdf"><i class="fa fa-ticket"></i> <span><?php echo _('Fête de Fondation'); ?></span></a>
            </li>
            <?php } ?>
            <li <?php if($action=="help"){ ?> class="active" <?php } ?>>
                <a href="help"><i class='fa fa-question'></i> <span><?php echo _('Help'); ?></span></a>
            </li>
            <li <?php if($action=="about"){ ?> class="active" <?php } ?>>
                <a href="about"><i class='fa fa-info'></i> <span><?php echo _('About'); ?></span></a>
            </li>
          </ul><!-- /.sidebar-menu -->
