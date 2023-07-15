<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP FanZone
 */
?>
<?php get_header(); ?>
<div class="row">
	<?php if (!get_theme_mod('wp_fanzone_disable_slider') ) { ?>
        <div class="col-md-12">            	
                    <?php get_template_part( 'inc/slider' ) ?>
        </div>
    <?php } ?>
    <div class="clearfix"></div>
    <div class="margin-bottom-separator"></div> 
	<div id="primary" class="content-area col-md-9" >      
        <main id="main" class="site-main row">
            <div id="manson">
            <?php if ( have_posts() ) : ?>
    
                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>
    
                    <?php
                        /* Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'content', get_post_format() );
                    ?>
                    
                <?php endwhile; ?>
                
            <?php else : ?>
    
                <?php get_template_part( 'content', 'none' ); ?>
    
            <?php endif; ?>
            <?php if (function_exists("wp_fanzone_pagination")) {
                            wp_fanzone_pagination();							
                        }
                ?>
                <div class="clearfix"></div>
            </div>
        </main><!-- #main -->
        <div class="clearfix"></div>
    </div><!-- #primary -->

    <aside id="widget" class="widget-container col-md-3 ">
        <?php get_sidebar(); ?>
    </aside>
</div>
<?php get_footer(); ?>
