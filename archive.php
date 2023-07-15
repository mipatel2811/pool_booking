<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP FanZone
 */
?>
<?php get_header(); ?>
<div class="row breadcrumb-container">
	<?php wp_fanzone_breadcrumb(); ?>
</div>
<div class="row">
	<section id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author: %s', 'wp-fanzone' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'wp-fanzone' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'wp-fanzone' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'wp-fanzone' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'wp-fanzone' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'wp-fanzone' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'wp-fanzone' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'wp-fanzone' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'wp-fanzone' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'wp-fanzone' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'wp-fanzone' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'wp-fanzone' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'wp-fanzone' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'wp-fanzone' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'wp-fanzone' );

						else :
							_e( 'Archives', 'wp-fanzone' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', 'search' );
				?>

			<?php endwhile; ?>
			<div class="clearfix"></div>
			<?php if (function_exists("wp_fanzone_pagination")) {
						wp_fanzone_pagination();							
					}
			?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		
		</main><!-- #main -->
	</section><!-- #primary -->

	<aside id="widget" class="widget-container col-md-3 ">
        <?php get_sidebar(); ?>
    </aside>
</div> 
<?php get_footer(); ?>
