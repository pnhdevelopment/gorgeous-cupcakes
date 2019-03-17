<?php
/**
 * The template for displaying all single posts and attachments
 *
 */

get_header(); 
wp_head();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section class="our-flavours text-center row popup-gallery simpleCart_shelfItem">
  <h1 class="item_name">
    <span><?php echo get_the_title(); ?></span>
  </h1>

  <div class="flavour container container-single" id="<?php echo $post->post_name; ?>">
    <div class="col-lg-6 main-thumb">
      <div>
        <a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>">
          <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" class="fav-thumb">
        </a>
      </div>
    </div>

    <?php $attachments = new Attachments( 'my_attachments' ); ?>
    <div class="col-lg-6">
      <?php while( $attachments->get() ) : ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div>
            <a href="<?php echo $attachments->url(); ?>">
              <img src="<?php echo $attachments->url(); ?>" class="fav-thumb">
            </a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>


  <div class="container product-info">
    <div class="col-lg-8 col-md-8 col-sm-8 title-description">
      <h2>
        <?php echo get_the_title(); ?>
      </h2>
      <p>
        <?php the_content();?>
      </p>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 text-center">
      <p class="price item_price">
        <?php echo '$' . get_post_meta( $post->ID, '_price', true ); ?>
      </p>
      <p class="detail">Pack of 12</p>      
      <?php echo do_shortcode('[wp_cart_button name="'.get_the_title().'" price="'.get_post_meta( $post->ID, '_price', true ).'"]'); ?>
      
    </div>
  </div>

</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
