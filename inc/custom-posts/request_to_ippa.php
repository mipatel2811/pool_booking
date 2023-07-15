<?php
//Exit if Directly accessed
if (!defined('ABSPATH')) Exit;
/**
 * Ticket Custom Post Type
 *
 * Handles to Register Custom Post Type For Ticket
 * @subpackage wp-fanzone
 * @since wp-fanzone 1.0
 **/
if( !function_exists('wp_fanzone_register_ticket_posts') ):
/**
 * Register Ticket Posts
 *
 * Handles to Register Ticket Post Type
 *
 * @since wp-fanzone 1.0
 **/
function wp_fanzone_register_ticket_posts(){

    // Ticket Labels
    $ticket_labels= array(
            'name'               => _x('Request to IPPA',get_theme_domain() ),
            'singular_name'      => _x('Request to IPPA','post type singular name',get_theme_domain() ),
            'manu_name'          => _x('Request to IPPA','admin menu',get_theme_domain() ),
            'name_admin_bar'     => _x('Request to IPPA','add new on admin bar',get_theme_domain() ),
            'add new'            => _x('Add New','Request to IPPA',get_theme_domain() ),
            'add_new_item'       => __('Add New Request to IPPA',get_theme_domain() ),
            'new_item'           => __('New Request to IPPA',get_theme_domain() ),
            'edit_item'          => __('Edit Request to IPPA',get_theme_domain() ),
            'view_item'          => __('View Request to IPPA',get_theme_domain() ),
            'all_items'          => __('All Request to IPPAs',get_theme_domain() ),
            'Search_items'       => __('Search Request to IPPA',get_theme_domain() ),
            'parent_item_colon'  => __('Parent Request to IPPAs:',get_theme_domain() ),
            'not_found'          => __('No Request to IPPA Found.',get_theme_domain() ),
            'not_found_in_trash' => __('No Request to IPPAs Found in Trash.',get_theme_domain() )
        );
    // Ticket Arguments
    $ticket_args = array(
            'labels'             =>  $ticket_labels,
            'description'        => __('Request to IPPA Posts.',get_theme_domain() ),
            'public'             => true,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug'=>'ticket'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'can_export'         => true,
            'exclude_from_search'=> false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-migrate',
            'supports'           => array('title','editor','revisions'),
    );
    // To Register Post Types
    register_post_type('ticket', $ticket_args);
}
// Hooking Up Function To Theme Setup
add_action('init','wp_fanzone_register_ticket_posts');
endif; //endif

if( !function_exists('wp_fanzone_ticket_updated_messages') ) :
/**
 * Update Messages
 *
 * Handles to Update Messages
 *
 * @since wp-fanzone 1.0
 **/
function wp_fanzone_ticket_updated_messages( $messages ){
    $post             = get_post();
    $post_type        = get_post_type($post);
    $post_type_object = get_post_type_object($post_type);

    $messages['ticket'] = array(
        0       => '', // Unused. Messages start at index 1.
        1       => __('Request to IPPA updated',get_theme_domain() ),
        2       => __('Custom Field Updated.',get_theme_domain() ),
        3       => __('Custom Field Deleted.',get_theme_domain() ),
        4       => __('Request to IPPA Updated.',get_theme_domain() ),
        5       => isset( $_GET['revision'] ) ? sprintf( _('Request to IPPA restored to revision from %s',get_theme_domain() ), wp_post_revision_title((int) $_GET['revision'], false)) :false,
        6       => __('Request to IPPA published.',get_theme_domain() ),
        7       => __('Request to IPPA Saved.',get_theme_domain() ),
        8       => __('Request to IPPA Submitted.',get_theme_domain() ),
        9       => sprintf( __('Request to IPPA scheduled for: <strong>%1$s</strong>.',get_theme_domain() ),
                // translators: Publish box date format, see http://php.net/date
                date_i18n( __('M j,Y @ G:i',get_theme_domain() ), strtotime($post->post_date) ) ),
        10      => __('Request to IPPA draft updated.',get_theme_domain() ),
    );

    if( $post_type_object->publicly_queryable && $post_type == 'ticket' ) {

        $permalink = get_permalink($post-> ID);
        $view_link = sprintf(' <a href="%s">%s</a>', esc_url($permalink), __('View Request to IPPA',get_theme_domain() ) );
        $messages[$post_type][1]  .= $view_link;
        $messages[$post_type][6]  .= $view_link;
        $messages[$post_type][9]  .= $view_link;

        $preview_permalink = add_query_arg('preview','true', $permalink);
        $preview_link = sprintf('<a target="_blank" href="%s">%s</a>' , esc_url($preview_permalink), __('Preview Request to IPPA',get_theme_domain() ) );
        $messages[$post_type][8]  .= $preview_link;
        $messages[$post_type][10] .= $preview_link;
    }
   // Return New Messages
    return $messages;
}
add_filter('post_updated_messages', 'wp_fanzone_ticket_updated_messages');
endif; //endif