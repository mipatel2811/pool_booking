<?php
/**
 * @package WP FanZone
 */
?>
<div class="item col-md-6">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="post_box">
        	<a href="<?php the_permalink('') ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('large'); ?></a>
            <header class="entry-header">
                <?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>        
                <?php if ( 'post' == get_post_type() ) : ?>
                <div class="entry-meta row">
                    <?php wp_fanzone_posted_on(); ?>
                </div><!-- .entry-meta -->
                <?php endif; ?>
            </header><!-- .entry-header -->
        
            <div class="entry-content">
                <?php
                    /* translators: %s: Name of current post */
                    the_excerpt();
					
                ?>
        		
                <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'wp-fanzone' ),
                        'after'  => '</div>',
                    ) );
                ?>
            </div><!-- .entry-content -->
            <a href="<?php the_permalink('') ?>" class="btn btn-info read_more"><?php _e( 'Read More >>', 'wp-fanzone' ); ?></a>
        </div>
    </article><!-- #post-## -->
    <div class="clearfix"></div>
</div>
