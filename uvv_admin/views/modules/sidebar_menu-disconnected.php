          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header"><?php echo _('NAVIGATION'); ?></li>
            <!-- Optionally, you can add icons to the links -->
            <li <?php if($action=="home"){ ?> class="active" <?php } ?>><a href="home"><i class='fa fa-home'></i> <span><?php echo _('Home'); ?></span></a></li>
            <li <?php if($action=="help"){ ?> class="active" <?php } ?>><a href="help"><i class='fa fa-question'></i> <span><?php echo _('Help'); ?></span></a></li>
            <li <?php if($action=="about"){ ?> class="active" <?php } ?>><a href="about"><i class='fa fa-info'></i> <span><?php echo _('About'); ?></span></a></li>
          </ul><!-- /.sidebar-menu -->
