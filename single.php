<?php
/**
 * The template for displaying all single posts.
 *
 * @package WP FanZone
 */

get_header(); ?>
<div class="row breadcrumb-container">
	<?php wp_fanzone_breadcrumb(); ?>
</div>
<div class="row">
	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php wp_fanzone_post_nav(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<aside id="widget" class="widget-container col-md-3 ">
        <?php get_sidebar(); ?>
    </aside>
</div> 
<?php get_footer(); ?>
