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
if( !function_exists('wp_fanzone_register_reservation_posts') ):
/**
 * Register Reservation Posts
 *
 * Handles to Register Reservation Post Type
 *
 * @since wp-fanzone 1.0
 **/
function wp_fanzone_register_reservation_posts(){

    // Reservation Labels
    $reservation_labels= array(
            'name'               => _x('Reservations',get_theme_domain() ),
            'singular_name'      => _x('Reservation','post type singular name',get_theme_domain() ),
            'manu_name'          => _x('Reservations','admin menu',get_theme_domain() ),
            'name_admin_bar'     => _x('Reservation','add new on admin bar',get_theme_domain() ),
            'add new'            => _x('Add New','Reservation',get_theme_domain() ),
            'add_new_item'       => __('Add New Reservation',get_theme_domain() ),
            'new_item'           => __('New Reservation',get_theme_domain() ),
            'edit_item'          => __('Edit Reservation',get_theme_domain() ),
            'view_item'          => __('View Reservation',get_theme_domain() ),
            'all_items'          => __('All Reservations',get_theme_domain() ),
            'Search_items'       => __('Search Reservation',get_theme_domain() ),
            'parent_item_colon'  => __('Parent Reservations:',get_theme_domain() ),
            'not_found'          => __('No Reservation Found.',get_theme_domain() ),
            'not_found_in_trash' => __('No Reservation Found in Trash.',get_theme_domain() )
        );
    // Reservation Arguments
    $reservation_args = array(
            'labels'             =>  $reservation_labels,
            'description'        => __('Reservation Posts.',get_theme_domain() ),
            'public'             => true,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug'=>'reservation'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'can_export'         => true,
            'exclude_from_search'=> false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-clipboard',
            'supports'           => array('title','revisions'),
    );
    // To Register Post Types
    register_post_type('reservation', $reservation_args);
}
// Hooking Up Function To Theme Setup
add_action('init','wp_fanzone_register_reservation_posts');
endif; //endif


if( !function_exists('wp_fanzone_reservation_updated_messages') ) :
/**
 * Update Messages
 *
 * Handles to Update Messages
 *
 * @since wp-fanzone 1.0
 **/
function wp_fanzone_reservation_updated_messages( $messages ){
    $post             = get_post();
    $post_type        = get_post_type($post);
    $post_type_object = get_post_type_object($post_type);

    $messages['reservation'] = array(
        0       => '', // Unused. Messages start at index 1.
        1       => __('Reservation updated',get_theme_domain() ),
        2       => __('Custom Field Updated.',get_theme_domain() ),
        3       => __('Custom Field Deleted.',get_theme_domain() ),
        4       => __('Reservation Updated.',get_theme_domain() ),
        5       => isset( $_GET['revision'] ) ? sprintf( _('Reservation restored to revision from %s',get_theme_domain() ), wp_post_revision_title((int) $_GET['revision'], false)) :false,
        6       => __('Reservation published.',get_theme_domain() ),
        7       => __('Reservation Saved.',get_theme_domain() ),
        8       => __('Reservation Submitted.',get_theme_domain() ),
        9       => sprintf( __('Reservation scheduled for: <strong>%1$s</strong>.',get_theme_domain() ),
                // translators: Publish box date format, see http://php.net/date
                date_i18n( __('M j,Y @ G:i',get_theme_domain() ), strtotime($post->post_date) )),
        10      => __('Reservation draft updated.',get_theme_domain() ),
    );

    if( $post_type_object->publicly_queryable && $post_type == 'reservation' ) {

        $permalink = get_permalink($post-> ID);
        $view_link = sprintf(' <a href="%s">%s</a>', esc_url($permalink), __('View Reservation',get_theme_domain() ) );
        $messages[$post_type][1]  .= $view_link;
        $messages[$post_type][6]  .= $view_link;
        $messages[$post_type][9]  .= $view_link;

        $preview_permalink = add_query_arg('preview','true', $permalink);
        $preview_link = sprintf('<a target="_blank" href="%s">%s</a>' , esc_url($preview_permalink), __('Preview Reservation',get_theme_domain() ) );
        $messages[$post_type][8]  .= $preview_link;
        $messages[$post_type][10] .= $preview_link;
    }
   // Return New Messages
    return $messages;
}
add_filter('post_updated_messages', 'wp_fanzone_reservation_updated_messages');
endif; //endif

if( !function_exists('wp_fanzone_hide_add_new_button') ) :
/**
 * Hide Add New Button From Listing of Reservations
 **/
function wp_fanzone_hide_add_new_button(){

    global $post_type;

    //Hide Link on Listing Page
    if( $post_type == 'reservation' ) {
        echo '<style type="text/css">a.page-title-action{ display:none; }</style>';
    } //Endif
}
add_action('admin_head', 'wp_fanzone_hide_add_new_button');
endif; //endif

if( !function_exists('wp_fanzone_hide_add_new_submenu') ) :
/**
 * Hide Add New From Reservations
 * 
 * Handles to hide add new from payments custom post type
 **/
function wp_fanzone_hide_add_new_submenu(){
    
    // Hide sidebar link
    global $submenu;
    
    //Unset From Sub Navigation
    unset( $submenu['edit.php?post_type=reservation'][10] );
}
add_action('admin_menu', 'wp_fanzone_hide_add_new_submenu');
endif; //endif

if( !function_exists('wp_fanzone_reservations_meta_boxes') ) :
/**
 * Add Reservation Details Metaboxes
 * 
 **/
function wp_fanzone_reservations_meta_boxes( $post ) {
    //Reservation Details Metabox
    add_meta_box( 'reservation-details', __('Reservation Details Box','wp-fanzone'), 'wp_fanzone_details_meta_box', 'reservation', 'normal', 'default' );
}
add_action('add_meta_boxes_reservation', 'wp_fanzone_reservations_meta_boxes', 10, 2);
endif; //endif

if( !function_exists('wp_fanzone_details_meta_box') ) :
/**
 * Adding Payment Details Metabox
 * 
 * Handles to adding payment details metaboxes
 * 
 * @package wp-fanzone 1.0
 * @since 1.0.0
 **/
function wp_fanzone_details_meta_box( $post ) {
    
    $post_ID = $post->ID;
    $user = get_post_meta($post_ID, '_user', true);
    $name = get_display_name($user);
    $email = get_user_email($user);
    $zone = get_post_meta($post_ID, '_zone', true);
    $total_people = get_post_meta($post_ID, '_people', true);
    $book_date = get_post_meta($post_ID, '_bookdate', true);
    $slot = get_post_meta($post_ID, '_slottime', true);
    $user_ip_address = get_post_meta($post_ID, '_userip', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><?php _e('User','wp-fanzone');?></th>
            <td><?php echo !empty($name) ? "<a href=".get_edit_user_link($user)."><strong>".$name."</strong></a>" : '&mdash;'; //Transaction ID ?></td>
        </tr>
        <tr>
            <th><?php _e('Zone','wp-fanzone');?></th>
            <td><?php echo !empty($zone) ? $zone : '&mdash;'; //Transaction ID ?></td>
        </tr>
        <tr>
            <th><?php _e('No of People','wp-fanzone');?></th>
            <td><?php echo !empty( $total_people ) ? $total_people : '&mdash;'; //Payer Name ?></td>
        </tr>
        <tr>
            <th><?php _e('Pool Book Date','wp-fanzone');?></th>
            <td><?php echo !empty($book_date) ? $book_date : '&mdash;'; //Payer Name ?></td>
        </tr>
        <tr>
            <th><?php _e('Slot Time','wp-fanzone');?></th>
            <td><?php echo !empty($slot) ? $slot : '&mdash;'; ?></td>
        </tr>
        
        <tr>
            <th><?php _e('IP Address','wp-fanzone');?></th>
            <td><?php echo !empty($user_ip_address) ? $user_ip_address : '&mdash;'; //IP Address ?></td>
        </tr>
    </table>
<?php
}
endif; //endif