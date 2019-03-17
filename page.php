<?php
/**
 * Template Name: Cupcakes
 *
 */

get_header(); 
wp_head();
?>

<section class="our-flavours text-center row">
 <?php
// Get all the taxonomies for this post type
$taxonomies = get_object_taxonomies( array( 'post_type' => 'cupcakes' ) );
 
foreach( $taxonomies as $taxonomy ) :
 
    // Gets every "category" (term) in this taxonomy to get the respective posts
    $terms = get_terms( $taxonomy );
 
    foreach( $terms as $term ) : ?>
 
      <h1>
      	<span id="<?php echo $term->slug; ?>"><?php echo $term->name; ?></span>
      </h1> 

        <?php $args = array(
            'post_type' => $post_type,
            'posts_per_page' => -1,  //show all posts
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $term->slug,
                )
            )
        );
        $posts = new WP_Query($args);
 
        if( $posts->have_posts() ): while( $posts->have_posts() ) : $posts->the_post(); ?>
 			<div class="flavour container" id="<?php echo $post->post_name; ?>">
				<a href="<?php echo get_post_permalink(); ?>">
					<div class="col-lg-6 main-thumb">
						<div>
						<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" class="fav-thumb">
						<?php $url = get_site_url() . '/wp-content/uploads/2019/03/cupcake.png'; ?>
						<img src="<?php echo $url ?>" class="cupcake-logo">
						<span class="caption">
							<?php the_title(); ?>
						</span>
						</div>
					</div>

					<?php $attachments = new Attachments( 'my_attachments' ); ?>
					<div class="col-lg-6">
						<?php while( $attachments->get() ) : ?>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div>
									<img src="<?php echo $attachments->url(); ?>" class="fav-thumb">
									<img src="<?php echo $url ?>" class="cupcake-logo">
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</a>
 			</div>
        <?php endwhile; endif;
 
	endforeach;
endforeach; 
?>

</section>

<?php
get_footer();

?>