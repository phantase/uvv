        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo _('500 Error'); ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> <?php echo _('Home'); ?></a></li>
            <li class="active"><?php echo ('500 Error'); ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="error-page">
            <h2 class="headline text-red">500</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-red"></i> <?php echo _('Oops! Something went wrong.'); ?></h3>
              <p>
                <?php echo _('We will work on fixing that right away.'); ?>
                <?php echo _('Meanwhile, you may <a href=\'home\'>return to dashboard</a> or try using the search form.'); ?>
              </p>
              <form class='search-form'>
                <div class='input-group'>
                  <input type="text" name="search" class='form-control' placeholder="<?php echo _('Search...'); ?>"/>
                  <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                  </div>
                </div><!-- /.input-group -->
              </form>
            </div>
          </div><!-- /.error-page -->

        </section><!-- /.content -->