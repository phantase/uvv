          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="img/users/user-<?php echo $_SESSION['clubnum']; ?>.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['clubnom']; ?></p>
              <?php if( isAdmin() ){ ?>
              <p><?php echo _('Administrator'); ?></p>
              <?php } ?>
              <!-- Status -->
              <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
          </div>
