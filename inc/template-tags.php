<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WP FanZone
 */

if ( ! function_exists( 'wp_fanzone_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function wp_fanzone_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'wp-fanzone' ); ?></h1>
            <div class="nav-links">
                <?php if ( get_next_posts_link() ) : ?>
                    <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'wp-fanzone' ) ); ?></div>
                <?php endif; ?>
                <?php if ( get_previous_posts_link() ) : ?>
                    <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'wp-fanzone' ) ); ?></div>
                <?php endif; ?>
            </div><!-- .nav-links -->
	</nav><!-- .navigation -->
    <?php
}
endif;

if ( ! function_exists( 'wp_fanzone_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function wp_fanzone_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
            return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e( 'Post navigation', 'wp-fanzone' ); ?></h1>
            <div class="nav-links">
                <?php
                    previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'wp-fanzone' ) );
                    next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'wp-fanzone' ) );
                ?>
            </div><!-- .nav-links -->
	</nav><!-- .navigation -->
    <?php
}
endif;

if ( ! function_exists( 'wp_fanzone_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function wp_fanzone_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = 
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = sprintf(
		_x( 'by %s', 'post author', 'wp-fanzone' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);


	echo '<span class="posted-on col-md-6  col-xs-6"><i class="fa fa-clock-o"></i>'. $posted_on . '</span>'; 
	echo '<span class="comments-link col-md-6  col-xs-6"><i class="fa fa-comments"></i>';
		comments_popup_link( __( 'Leave a comment', 'wp-fanzone' ), __( '1 Comment', 'wp-fanzone' ), __( '% Comments', 'wp-fanzone' ) );
	echo '</span>';

}
endif;

if ( ! function_exists( 'wp_fanzone_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function wp_fanzone_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'wp-fanzone' ) );
		if ( $categories_list && wp_fanzone_categorized_blog() ) {
                    printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'wp-fanzone' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'wp-fanzone' ) );
		if ( $tags_list ) {
                    printf( '<span class="tags-links">' . __( ' Tagged %1$s', 'wp-fanzone' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'wp-fanzone' ), __( '1 Comment', 'wp-fanzone' ), __( '% Comments', 'wp-fanzone' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'wp-fanzone' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function wp_fanzone_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'wp_fanzone_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wp_fanzone_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so wp_fanzone_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so wp_fanzone_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in wp_fanzone_categorized_blog.
 */
function wp_fanzone_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'wp_fanzone_categories' );
}
add_action( 'edit_category', 'wp_fanzone_category_transient_flusher' );
add_action( 'save_post',     'wp_fanzone_category_transient_flusher' );



function wp_fanzone_body_classes( $classes ) {
 
    if( is_page_template('page-templates/create-password.php') ) :
        $classes[] = 'password-form';
    endif; //endif
    if( is_page('registration') ) :
        $classes[] = 'registration-page';
    endif; //endif 
    return $classes;
}
add_filter( 'body_class','wp_fanzone_body_classes' );

function wp_fanzone_get_ip(){

    if ( isset( $_SERVER ) ) {
	if ( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
	    $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} elseif ( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
	    $realip = $_SERVER["HTTP_CLIENT_IP"];
	} else {
	    $realip = $_SERVER["REMOTE_ADDR"];
	}
    } else {
	if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
	    $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
	} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
	    $realip = getenv( 'HTTP_CLIENT_IP' );
	} else {
	    $realip = getenv( 'REMOTE_ADDR' );
	}
    }
    return $realip;
}