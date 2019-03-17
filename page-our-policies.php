<?php 
/* Template Name: Our policies */ 
get_header(); 
wp_head();
?>

<div class="row our-policies">

	<div>
		<?php while ( have_posts() ) : the_post(); ?>
			<h1>
				<span>
					<?php the_title(); ?>
				</span>
			</h1>
			
	        <?php echo the_content(); ?>

	    <?php endwhile; // end of the loop. ?>
	</div>
	
</div>

<?php get_footer(); ?>
