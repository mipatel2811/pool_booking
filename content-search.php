<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP FanZone
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="post_box">
	<header class="entry-header">
		<?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-summary row">
		<?php if ( has_post_thumbnail()) { ?>
                <div class="col-md-6">
                    <a href="<?php the_permalink('') ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('post-thumb'); ?></a>
                    <div class="meta-info row">
                        <div class="col-md-6"><i class="fa fa-clock-o"></i><?php the_time( get_option( 'date_format' ) ); ?></div>
                        <div class="col-md-6"><a href="<?php comments_link(); ?>" class="meta-comment"><i class="fa fa-comments"></i><?php comments_number( '0 comment', '1 comment', '% comments' ); ?></a> </div>
                    </div> 
                </div>                               
                <div class="col-md-6">                                                           
                    <?php the_excerpt(); ?>
                </div>
                <?php
                    /* translators: %s: Name of current post */					
                ?>
        		<?php } else { ?>
                <div class="col-md-12">                                                           
                    <?php the_excerpt(); ?>
                </div>
                 <div class="meta-info row">
                    <div class="col-md-6"> 
                        <div class="col-md-6"><i class="fa fa-clock-o"></i><?php the_time( get_option( 'date_format' ) ); ?></div>
                        <div class="col-md-6"><a href="<?php comments_link(); ?>" class="meta-comment"><i class="fa fa-comments"></i><?php comments_number( '0 comment', '1 comment', '% comments' ); ?></a></div> 
                    </div>                                 
                    
                </div>
                <?php } ?> 
                <div class="clearfix"></div>
	</div><!-- .entry-summary -->
    <a href="<?php the_permalink('') ?>" class="btn btn-info read_more"><?php _e( 'Read More >>', 'wp-fanzone' ); ?></a>
</div>
</article><!-- #post-## -->
