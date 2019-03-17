<footer class='text-center row'>
      <div class='col-lg-12 text-center'>
        <a href="<?php echo get_site_url(); ?>">
          <img title="<?php bloginfo('name'); ?>" src="<?php echo get_theme_mod( 'gorgeous_logo' ); ?>">
        </a>
      </div>
      <div class='col-lg-3'>
        <?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
          <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
        <?php endif; ?>
      </div>
      <div class='col-lg-3'>
        <?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
          <?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
        <?php endif; ?>
      </div>
      <div class='col-lg-3'>
        <?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
          <?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
        <?php endif; ?>
      </div>
      <div class='col-lg-3'>
        <?php if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
          <?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
        <?php endif; ?>
      </div>
      <div class='col-lg-12 copyright text-center'>
        &copy; <?php echo date("Y"); ?> Georgeous Cupcakes &bull; All Rights Reserved
      </div>
    </footer>


    </body>
</head>