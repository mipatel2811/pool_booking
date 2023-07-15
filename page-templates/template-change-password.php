<?php
/**
 * Template Name: Change Password
 *
 * @package WordPress
 * @subpackage wp-fanzone
 * @since wp-fanzone 1.0
 */ 
if ( !is_user_logged_in() ) {
    $safe_url = home_url( '/' );
    $safe_url = add_query_arg( 'getlogin', 'true', $safe_url );
    wp_safe_redirect($safe_url);
    exit;
}
get_header();
 
    if(have_posts() ) : 
            get_template_part('content','change-password');
    endif;
 
get_footer();