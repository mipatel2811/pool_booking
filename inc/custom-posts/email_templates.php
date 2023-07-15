<?php

//Exit if Directly accessed
if (!defined('ABSPATH')) Exit;
/**
 * Reservation Custom Post Type
 *
 * Handles to Register Custom Post Type For Reservation
 * @subpackage wp-fanzone
 * @since wp-fanzone 1.0
 **/
if( !function_exists('wp_fanzone_register_email_templates_posts') ):
/**
 * Register Reservation Posts
 *
 * Handles to Register Reservation Post Type
 *
 * @since wp-fanzone 1.0
 **/
function wp_fanzone_register_email_templates_posts(){

    // Reservation Labels
    $email_template_labels= array(
            'name'               => _x('Email Templates',get_theme_domain() ),
            'singular_name'      => _x('Email Template','post type singular name',get_theme_domain() ),
            'manu_name'          => _x('Email Templates','admin menu',get_theme_domain() ),
            'name_admin_bar'     => _x('Email Template','add new on admin bar',get_theme_domain() ),
            'add new'            => _x('Add New','Reservation',get_theme_domain() ),
            'add_new_item'       => __('Add New Email Template',get_theme_domain() ),
            'new_item'           => __('New Email Template',get_theme_domain() ),
            'edit_item'          => __('Edit Email Template',get_theme_domain() ),
            'view_item'          => __('View Email Template',get_theme_domain() ),
            'all_items'          => __('All Email Templates',get_theme_domain() ),
            'Search_items'       => __('Search Email Template',get_theme_domain() ),
            'parent_item_colon'  => __('Parent Email Template:',get_theme_domain() ),
            'not_found'          => __('No Email Template Found.',get_theme_domain() ),
            'not_found_in_trash' => __('No Email Template Found in Trash.',get_theme_domain() )
        );
    // Reservation Arguments
    $email_template_args = array(
            'labels'             =>  $email_template_labels,
            'description'        => __('Email Templates.',get_theme_domain() ),
            'public'             => true,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug'=>'email_template'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'can_export'         => true,
            'exclude_from_search'=> false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-email-alt',
            'supports'           => array('title','revisions','editor')
    );
    // To Register Post Types
    register_post_type('email_template', $email_template_args);
}
// Hooking Up Function To Theme Setup
add_action('init','wp_fanzone_register_email_templates_posts');
endif; //endif
