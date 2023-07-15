<?php
/**
 * Template Name: My Reservations
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
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
 get_header();
 
    if( have_posts() ) : 
        get_template_part('content','reservations');
    endif;
 
get_footer();