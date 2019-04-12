<!DOCTYPE html>
<html></html>
<head>
  <meta charset='utf-8'>
  <meta content='width=device-width' initial-scale='1' name='viewport'>


  <title><?php wp_title('&raquo;','true','right'); ?><?php bloginfo('name'); ?></title>

  <!-- <link rel="shortcut icon" href="#"> -->
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />




  <body class='container Site'>
    <div class="row cart-display" style="display:none">
      <?php if ( is_active_sidebar( 'shopping-cart-widget-area' ) ) : ?>
        <?php dynamic_sidebar( 'shopping-cart-widget-area' ); ?>
      <?php endif; ?>
    </div>

    <!-- HEADER -->
    <header class='row'>
      
      <!-- Dashboard -->
      <?php if ( is_active_sidebar( 'dashboard-widget-area' ) ) : ?>
        <?php dynamic_sidebar( 'dashboard-widget-area' ); ?>
      <?php endif; ?>

      <div class='col-lg-12 text-center'>
        <a href="<?php echo get_site_url(); ?>">
          <img class='logo' title="<?php bloginfo('name'); ?>" src="<?php echo get_theme_mod( 'gorgeous_logo' ); ?>">
        </a>
      </div>
      <div class='col-lg-12 text-center'>
        <span class='phone'>Ph: <?php echo get_option('contact_number'); ?></span>
      </div>
      <div class='col-lg-12 text-center'>
        <span class='slogan'>Pickups & deliveries</span>
      </div>
      
    </header>
    <!-- NAV MENU -->
    <nav class='navbar navbar-inverse row'>
      <div class='container-fluid'>
        <div class='navbar-header'>
          <button class='navbar-toggle' data-target='#myNavbar' data-toggle='collapse' type='button'>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
        </div>
        <div class='collapse navbar-collapse' id='myNavbar'>
          <?php wp_nav_menu( 
            array(
              'theme_location' => 'header-menu',
              'menu_class'      => 'nav navbar-nav',
            )
          ); ?>
        </div>
      </div>
    </nav>

    <main class="Site-content">