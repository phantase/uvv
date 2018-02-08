        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo _('404 Page not found'); ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> <?php echo _('Home'); ?></a></li>
            <li class="active"><?php echo ('404 Page not found'); ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> <?php echo _('Oops! Page not found.'); ?></h3>
              <p>
                <?php echo _('We could not find the page you were looking for.'); ?>
				<?php echo _('Meanwhile, you may <a href=\'home\'>return to dashboard</a> or try using the search form.'); ?>
              </p>
              <form class='search-form'>
                <div class='input-group'>
                  <input type="text" name="search" class='form-control' placeholder="<?php echo _('Search...'); ?>"/>
                  <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                  </div>
                </div><!-- /.input-group -->
              </form>
            </div><!-- /.error-content -->
          </div><!-- /.error-page -->
        </section><!-- /.content -->