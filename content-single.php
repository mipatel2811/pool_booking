<?php
/**
 * @package WP FanZone
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			 <p class="meta-info"><span><em>
                <?php _e('Posted By', 'wp-fanzone'); ?> <?php the_author_posts_link(); ?> <?php _e(' on ', 'wp-fanzone'); ?> <?php the_time( get_option( 'date_format' ) ); ?>
             </em></span></p>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
        <?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'wp-fanzone' ),
				'after'  => '</div>',
			) );
		?>
        <footer class="entry-footer">
			<?php wp_fanzone_entry_footer(); ?>
        </footer><!-- .entry-footer -->
        <?php if (get_theme_mod('wp_fanzone_author_bio') ) : ?>
            <div class="author-bio">        
                <?php 
                $author_avatar = get_avatar( get_the_author_meta('email'), '75' );
                if ($author_avatar) : ?>
                    <div class="author-thumb"><?php echo $author_avatar; ?></div>
                <?php endif; ?>
                
                <div class="author-info">
                    <?php $author_posts_url = get_author_posts_url( get_the_author_meta( 'ID' )); ?> 
                    <h4 class="author-title"><?php _e('Posted by ', 'wp-fanzone'); ?><a href="<?php echo esc_url($author_posts_url); ?>" title="<?php printf( __( 'View all posts by %s', 'wp-fanzone' ), get_the_author() ) ?>"><?php the_author(); ?></a></h4>
                    <?php $author_desc = get_the_author_meta('description');
                    if ( $author_desc ) : ?>
                    <p class="author-description"><?php echo $author_desc; ?></p>
                    <?php endif; ?>
                    <?php $author_url = get_the_author_meta('user_url');
                    if ( $author_url ) : ?>
                    <p><?php _e('Website: ', 'wp-fanzone') ?><a href="<?php echo $author_url; ?>"><?php echo $author_url; ?></a></p>
                    <?php endif; ?>
                </div>
        </div>
        <?php endif; ?>
		
	</div><!-- .entry-content -->

	
</article><!-- #post-## -->
