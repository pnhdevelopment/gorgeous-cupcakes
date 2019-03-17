<?php 
get_header();
wp_head();
?>
    <!-- SLIDESHOW -->
    <section class='slideshow row'>
      <span class='every-moment'>For every moment...</span>
      <div class='slick'>
        <?php $args = array(
            'post_type' => 'slideshow',
            'posts_per_page' => -1,  //show all posts
        );
        $posts = new WP_Query($args);
        if( $posts->have_posts() ): while( $posts->have_posts() ) : $posts->the_post(); ?>
        <div>
          <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>">
          <span class="slider-caption"><?php the_title(); ?></span>
        </div>
        <?php endwhile; endif; ?>
      </div>
    </section>

    <!-- EVENTS -->
    <section class='events clearfix row'>
      <?php // Get all the taxonomies for this post type
      $url = get_site_url() . '/wp-content/uploads/2019/03/cupcake.png';
      $taxonomies = get_object_taxonomies( array( 'post_type' => 'cupcakes' ) );
      foreach( $taxonomies as $taxonomy ) :
          // Gets every "category" (term) in this taxonomy to get the respective posts
          $terms = get_terms( $taxonomy );
          foreach( $terms as $term ) : ?>
            <div class='col-lg-3 col-md-6 col-sm-6 col-xs-6'>
              <a href="cupcakes#<?php echo $term->slug; ?>">
                <div>
                  <img class="cupcake" src="<?php echo z_taxonomy_image_url($term->term_id); ?>">
                  <img src="<?php echo $url ?>" class="cupcake-logo">
                  <span class='event'><?php echo $term->name; ?></span>
                </div>
              </a>
            </div> 
        <?php  endforeach;
      endforeach; ?>
    </section>

    <!-- OUR DELICIOUS FLAVOURS -->
    <section class='our-flavours text-center row'>
      <h1>
        <span>Our delicious flavours</span>
      </h1>

      <?php $args = array(
            'post_type' => 'cupcakes',
            'posts_per_page' => -1,
            'meta_query' => array(
              array(
                'key' => 'featured-checkbox',
                'value' => 'yes'
              )
            )
        );
        $posts = new WP_Query($args);
        
      if( $posts->have_posts() ): while( $posts->have_posts() ) : $posts->the_post(); ?>
      <div class='flavour container'>
        <div class='col-lg-6 main-thumb'>
          <a href="cupcakes#<?php echo $post->post_name ?>">
            <div>
              <img class='fav-thumb' src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>">
              <img class='cupcake-logo' src="<?php echo $url ?>">
              <span class='caption'><?php the_title(); ?></span>
            </div>
          </a>
        </div>

        <?php $attachments = new Attachments( 'my_attachments' ); ?>
        <div class='col-lg-6'>
          <?php while( $attachments->get() ) : ?>

          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
            <a href="cupcakes#<?php echo $post->post_name ?>">
              <div>
                <img src="<?php echo $attachments->url(); ?>" class="fav-thumb">
                <img src="<?php echo $url; ?>" class="cupcake-logo">
              </div>
            </a>
          </div>
          <?php endwhile; ?>
        </div>
      </div>
      <?php endwhile; endif; ?>
      
      <br><br>
      <?php $url = get_site_url(); ?>
      <a class="view-more" href="<?php echo $url .'/cupcakes' ?>">
        View more
      </a>

    </section>

    <!-- PICKUPS & DELIVERIES -->
    <section class='pickups-deliveries text-center row'>
      <h1>
        <span id="pickups-and-deliveries">Pickups & deliveries</span>
      </h1>
      <div class='col-lg-6'>
        <div>
          <img src="<?php bloginfo('template_url'); ?>/assets/pickups.png">
          <h3>Pickups</h3>
          <?php echo get_option('pickups'); ?>
        </div>
      </div>
      <div class='col-lg-6'>
        <div>
          <img src="<?php bloginfo('template_url'); ?>/assets/deliveries.png">
          <h3>Deliveries</h3>
          <?php echo get_option('deliveries'); ?>
        </div>
      </div>
    </section>
    <!-- CONTACT US -->
    <section class='contact-us text-center row'>
      <h1>
        <span id="contact-us">Contact Us</span>
      </h1>
      
      <div class='col-lg-6'>

        <?php if ( is_active_sidebar( 'contact_us' ) ) : ?>
        <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
          <?php dynamic_sidebar( 'contact_us' ); ?>
        </div>
        <?php endif; ?>
        
      </div>


      <div class='col-lg-6 contact-info'>
        <div>
        <span class="glyphicon glyphicon-phone-alt"></span>
          <br> <?php echo get_option('contact_number'); ?>
        </div>
        <br>

        <div>
        <span class="glyphicon glyphicon-envelope"></span>
          <br> sales@gorgeouscupcakes.com.au
        </div>
        <br>

      </div>
    </section>
    <!-- FOOTER -->
    <?php get_footer(); ?>
  
