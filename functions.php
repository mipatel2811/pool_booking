<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * WP FanZone functions and definitions
 *
 * @package WP FanZone
 */
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Set the content width based on the theme's design and stylesheet.
 */
function get_theme_domain() {
    return 'wp-fanzone';
}

if (!isset($content_width)) {
    $content_width = 640; /* pixels */
}

if (!function_exists('wp_fanzone_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function wp_fanzone_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on WP FanZone, use a find and replace
         * to change 'wp-fanzone' to the name of your theme in all the template files
         */
        load_theme_textdomain('wp-fanzone', get_template_directory() . '/languages');
        // Add default posts and comments RSS feed links to head.
        add_theme_support("title-tag");
        add_theme_support('automatic-feed-links');
        add_editor_style();
        add_theme_support('post-thumbnails');
        add_image_size('widget-post-thumb', 70, 70, true);
        add_image_size('post-thumb', 400, '200', true);
        add_image_size('slide-small-thumb', 130, 135, true);
        add_image_size('slide-medium-thumb', 265, 135, true);
        add_image_size('slide-large-image', 849, 424, true);
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        //add_theme_support( 'post-thumbnails' );
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'wp-fanzone'),
            'top-menu' => __('Top Menu', 'wp-fanzone')
        ));


        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'comment-form', 'comment-list', 'gallery', 'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside', 'image', 'video', 'quote', 'link',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('wp_fanzone_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));


        // Options Page
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page();
        }
    }

endif; // wp_fanzone_setup
add_action('after_setup_theme', 'wp_fanzone_setup');


if (!function_exists('wp_fanzone_menu')) {

    function wp_fanzone_menu() {
        require get_template_directory() . '/inc/wpfanzoneMenu.php';
    }

}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function wp_fanzone_widgets_init() {
    register_sidebar(array(
        'name' => __('Homepage Sidebar', 'wp-fanzone'),
        'id' => 'defaul-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title"><h4>',
        'after_title' => '</h4><div class="arrow-right"></div></div>',
    ));

    register_sidebar(array(
        'name' => __('Post Sidebar', 'wp-fanzone'),
        'id' => 'post-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title"><h4>',
        'after_title' => '</h4><div class="arrow-right"></div></div>',
    ));

    register_sidebar(array(
        'name' => __('Page Sidebar', 'wp-fanzone'),
        'id' => 'page-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title"><h4>',
        'after_title' => '</h4><div class="arrow-right"></div></div>',
    ));

    register_sidebar(array(
        'name' => __('Archives Sidebar', 'wp-fanzone'),
        'id' => 'archives-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title"><h4>',
        'after_title' => '</h4><div class="arrow-right"></div></div>',
    ));

    register_sidebar(array(
        'name' => __('Banner Widget', 'wp-fanzone'),
        'description' => 'Enter your banner code into this text widget.',
        'id' => 'top-right-widget',
        'before_widget' => '<div id="top-widget">',
        'after_widget' => "</div>",
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('Footer 1', 'wp-fanzone'),
        'id' => 'footer-one',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<div class="widget-title"><h3>',
        'after_title' => '</h3></div>',
    ));

    register_sidebar(array(
        'name' => __('Footer 2', 'wp-fanzone'),
        'id' => 'footer-two',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<div class="widget-title"><h3>',
        'after_title' => '</h3></div>',
    ));

    register_sidebar(array(
        'name' => __('Footer 3', 'wp-fanzone'),
        'id' => 'footer-three',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<div class="widget-title"><h3>',
        'after_title' => '</h3></div>',
    ));
}

add_action('widgets_init', 'wp_fanzone_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function wp_fanzone_scripts() {
    global $wp_scripts;
    global $wp_styles;
    $slider_speed = 6000;
    if (get_theme_mod('wp_fanzone_slider_speed')) {
        $slider_speed = wp_fanzone_sanitize_integer(get_theme_mod('wp_fanzone_slider_speed'));
    }
    wp_enqueue_style('wp_fanzone_slider', get_template_directory_uri() . '/css/slider.css', array(), false, 'screen');
    wp_enqueue_style('wp_fanzone_responsive', get_template_directory_uri() . '/css/responsive.css', array(), rand(), 'screen');
    wp_enqueue_style('wp_fanzone_font_awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css');
    wp_enqueue_style('wp_fanzone_googleFonts', '//fonts.googleapis.com/css?family=Lato|Oswald');
    wp_enqueue_style('wp_fanzone-ie', get_stylesheet_directory_uri() . "/css/ie.css", array());
    $wp_styles->add_data('wp_fanzone-ie', 'conditional', 'IE');
    wp_enqueue_style('wp-fanzone-style', get_stylesheet_uri(), array(), rand(), '');

    /* New css V2 */
    wp_enqueue_style('wp_fanzone-bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', array(), '3.2.0', '');
    wp_enqueue_style('wp_fanzone-bootstrap-theme-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css', array(), '3.2.0', '');
    wp_enqueue_style('wp_fanzone-bootstrap-datepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css', array(), '1.3.0', '');
    wp_enqueue_style('wp_fanzone-style-css', get_template_directory_uri() . '/css/style.css', array(), rand(), '');

    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_theme_file_uri('/js/jquery.min.js'), array(), '3.6', false);

    wp_enqueue_script('wp_fanzone_responsive_js', get_template_directory_uri() . '/js/responsive.js', array('jquery'));
    wp_enqueue_script('wp_fanzone_slider_js', get_template_directory_uri() . '/js/slider.js', array('jquery'));
    wp_enqueue_script('wp_fanzone_navigation_js', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true);
    wp_enqueue_script('wp_fanzone_load_images_js', get_template_directory_uri() . '/js/jquery.imagesloaded.min.js');
    wp_enqueue_script('wp-fanzone-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true);
    wp_enqueue_script('wp_fanzone_ie', get_template_directory_uri() . "/js/html5shiv.js");
    $wp_scripts->add_data('wp_fanzone_ie', 'conditional', 'lt IE 9');
    wp_enqueue_script('wp_fanzone_ie-responsive', get_template_directory_uri() . "/js/ie-responsive.min.js");
    $wp_scripts->add_data('wp_fanzone_ie-responsive', 'conditional', 'lt IE 9');


    wp_register_script("wp_fanzone_custom_js", get_template_directory_uri() . "/js/custom.js", array('jquery-masonry'));
    wp_enqueue_script("wp_fanzone_custom_js");
    wp_localize_script("wp_fanzone_custom_js", "slider_speed", array('vars' => $slider_speed));

    /* New JS V2 */
    
    wp_enqueue_script('wp_fanzone-bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array('jquery'), '3.2.0', false);
    wp_enqueue_script('wp_fanzone-datepicker-js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js', array('jquery'), '1.5.0', false);
    wp_enqueue_script('wp_fanzone-validate-js', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), '1.19.0', false);
    wp_enqueue_script('wp_fanzone-moment-js', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js', array('jquery'), '3.2.0', false);
    wp_enqueue_script('wp_fanzone-general-js', get_template_directory_uri() . '/js/general.js', array('jquery'), rand(), true);

    global $current_user; 
    $role = $current_user->roles[0];

    wp_localize_script('wp_fanzone-general-js', 'WP_Fanzone_Obj', array(
        'ajaxurl' => admin_url('admin-ajax.php', is_ssl() ? 'https' : 'http' ),
        'redirecturl' => home_url($path = 'my-profile', $scheme = 'relative'),
        'loadingmessage' => __('In progress, please wait...', get_theme_domain()),
        'role'=> $role == 'administrator' ? 1  :0, 
    ) );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }


    $pool_holidays = get_option('holidays');

    $holidays = array();
    $holiday_formatted = array();
    if (!empty($pool_holidays)) {
        $holidays = explode(",", $pool_holidays[0]);

        foreach ($holidays as $day) {

            $date = explode("-", $day);
            $new_date = $date[2] . "-" . $date[1] . "-" . $date[0];
            $new_date = date("F j, Y", strtotime($new_date));
            $holiday_formatted[] = $new_date;
        }
    }

    if (!empty($holiday_formatted)) {
        echo '<script>var holidays = ', js_array($holiday_formatted), ';</script>';
    }
}

add_action('wp_enqueue_scripts', 'wp_fanzone_scripts');

function wp_fanzone_excerpt_length($length) {
    return 70;
}

add_filter('excerpt_length', 'wp_fanzone_excerpt_length', 999);

function wp_fanzone_excerpt_more($more) {
    return '...';
}

add_filter('excerpt_more', 'wp_fanzone_excerpt_more');

//====================================Breadcrumbs=============================================================================================
function wp_fanzone_breadcrumb() {
    global $post;
    echo '<ul id="breadcrumbs">';
    if (!is_home()) {
        echo '<li><a href="';
        echo esc_url(home_url());
        echo '">';
        echo 'Home';
        echo '</a></li><li class="separator"> / </li>';
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li class="separator"> / </li><li> ');
            if (is_single()) {
                echo '</li><li class="separator"> / </li><li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if ($post->post_parent) {
                $fanzone_act = get_post_ancestors($post->ID);
                $title = get_the_title();
                foreach ($fanzone_act as $fanzone_inherit) {
                    $output = '<li><a href="' . get_permalink($fanzone_inherit) . '" title="' . get_the_title($fanzone_inherit) . '">' . get_the_title($fanzone_inherit) . '</a></li> <li class="separator">/</li>';
                }
                echo $output;
                echo '<strong title="' . $title . '"> ' . $title . '</strong>';
            } else {
                echo '<li><strong> ' . get_the_title() . '</strong></li>';
            }
        }
    }
    echo '</ul>';
}

//For admin css js script
function wp_fanzone_admin_scripts() {

    wp_enqueue_style('select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css');

    wp_enqueue_style('wp_fanzone_jqueryui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), null);
    wp_enqueue_script('jquery-ui');
    wp_enqueue_style('wp_fanzone-multidatespicker-style', get_theme_file_uri('/css/multidatespicker.css'), array(), null);
    wp_enqueue_style('wp_fanzone-admin-custom-style', get_theme_file_uri('/css/admin-custom.css'), array(), rand());

    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_theme_file_uri('/js/jquery.min.js'), array(), '3.6', false);

    wp_enqueue_script('wp_fanzone-jquery', get_theme_file_uri('/js/jquery-ui.js'), array(), null, true);
    wp_enqueue_script('wp_fanzone-multidatespicker', get_theme_file_uri('/js/multidatespicker.js'), array(), null, true);

    wp_enqueue_script('select2-js', get_theme_file_uri('/js/select2.min.js'), array(), rand(), true);

    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
    wp_enqueue_script('wp_fanzone-admin-custom-script', get_theme_file_uri('/js/admin-custom.js'), array(), rand(), true);
}

add_action('admin_enqueue_scripts', 'wp_fanzone_admin_scripts');

function my_custom_admin_head() {
    echo '<script>var ajax_url = "' . admin_url('admin-ajax.php') . '";</script>';
}

add_action('admin_head', 'my_custom_admin_head');

function wp_fanzone_remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'wp_fanzone_remove_admin_bar');

function wp_fanzone_email_content_type($content_type) {
    return 'text/html';
}
add_filter('wp_mail_content_type', 'wp_fanzone_email_content_type');

function wp_fanzone_change_mail_charset($charset) {
    return 'UTF-8';
}
add_filter('wp_mail_charset', 'wp_fanzone_change_mail_charset');

function wp_fanzone_wp_mail_from_name($name) {
    return get_bloginfo('name');
}
add_filter('wp_mail_from_name', 'wp_fanzone_wp_mail_from_name');


require get_template_directory() . '/inc/pagination.php';
require get_template_directory() . '/inc/widget.php';


function mime_types($mimes) {
    
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}

function wp_fanzone_login_logo_url_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'wp_fanzone_login_logo_url_title' );

function wp_fanzone_login_logo_url(){
    return home_url('/');
}
add_filter('login_headerurl', 'wp_fanzone_login_logo_url');

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/*
 * To show states list to admin's users.php file  
 */
require get_template_directory() . '/inc/states.php';

/*
 * To show member profile to admin's users.php file  
 */
require get_template_directory() . '/inc/admin-profile.php';

/*
 * To Add Email filters in Theme  
 */
require get_template_directory() . '/inc/email-filters.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * For All Ajax Function
 */
require get_template_directory() . '/inc/theme-ajax.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load ACF by Code
 */
require get_template_directory() . '/inc/acf/acf.php';

/**
 * Custom Post Type Reservation For This Theme.
 */
require get_parent_theme_file_path('/inc/custom-posts/reservation.php');

/**
 * Custom Post Type Email Template For This Theme.
 */
require get_parent_theme_file_path('/inc/custom-posts/email_templates.php');

/**
 * Custom Post Type Ticket For This Theme.
 */
require get_parent_theme_file_path('/inc/custom-posts/request_to_ippa.php');


$action = !empty($_GET['action']) ? $_GET['action'] : '';
$key = !empty($_GET['key']) ? $_GET['key'] : '';
$login = !empty($_GET['login']) ? $_GET['login'] : '';

if (!empty($action) && !empty($key) && !empty($login)):

    if ('GET' == $_SERVER['REQUEST_METHOD']) {
        $user = check_password_reset_key($_REQUEST['key'], $_REQUEST['login']);
        if (!$user || is_wp_error($user)) {
            if ($user && $user->get_error_code() === 'expired_key') {
                $redirect_url = home_url('/');
                $redirect_url = add_query_arg('login', 'expiredkey', $redirect_url);
                wp_safe_redirect($redirect_url);
            } else {
                $redirect_url = home_url('/');
                $redirect_url = add_query_arg('login', 'invalidkey', $redirect_url);
                wp_safe_redirect($redirect_url);
            }
            exit;
        }
    }
endif;

function wp_fanzone_methods($contactmethods) {
    $contactmethods['Contact_number'] = 'Contact Number';
    return $contactmethods;
}

add_filter('user_contactmethods', 'wp_fanzone_methods', 10, 1);

function get_display_name($user_id) {
    if (!$user = get_userdata($user_id))
        return false;
    $fname = $user->first_name;
    $lname = $user->last_name;
    $name = $fname . " " . $lname;
    return $name;
}

function get_user_email($user_id) {
    if (!$user = get_userdata($user_id))
        return false;
    $email = $user->user_email;
    return $email;
}

function wp_fanzone_user_table($column) {

    $column = array(
        'cb' => '<input type="checkbox">',
        'username' => __('Username'),
        'name' => __('Name'),
        'email' => __('Email'),
        'role' => __('Role'),
        'Member_Id' => __('Member ID'),
		'Address' => __('Address'),
		'Contact_number' => __('Contact Number'),
        'Annual_due' => __('Annual Due'),
		'Pool_key' => __('Pool Key'),
        //'dues_amount' => __('Amount'),
        "Date_created" => __('Date Created'),
    );
    return $column;
}

add_filter('manage_users_columns', 'wp_fanzone_user_table');

function wp_fanzone_edit_reservation_columns($columns) {
    unset($columns['date']);
    $columns['user'] = __('User Name', get_theme_domain());
    $columns['zone'] = __('Zone', get_theme_domain());
    $columns['people'] = __('No of People', get_theme_domain());
    $columns['bookdate'] = __('Reservation Date', get_theme_domain());
    $columns['slottime'] = __('Time Slot', get_theme_domain());
    $columns['date'] = __('Date', get_theme_domain());

    return $columns;
}

add_filter('manage_reservation_posts_columns', 'wp_fanzone_edit_reservation_columns');

function wp_fanzone_edit_ticket_columns($columns) {
    unset($columns['date']);
    unset($columns['title']);
    $columns['id'] = __('ID', get_theme_domain());
    $columns['title'] = __('Title', get_theme_domain());
    $columns['email'] = __('Email', get_theme_domain());
    $columns['phone'] = __('Phone', get_theme_domain());
    $columns['request'] = __('Request', get_theme_domain());
    $columns['date'] = __('Date', get_theme_domain());

    return $columns;
}

add_filter('manage_ticket_posts_columns', 'wp_fanzone_edit_ticket_columns');

function wp_fanzone_ticket_column_value($column, $post_id) {
    switch ($column) {
        case 'id':
            echo!empty($post_id) ? "<a href=" . get_edit_post_link($post_id) . ">" . "<strong>#" . $post_id . "</strong></a>" : '&#8212;';
            break;
        case 'email':
            $email = get_post_meta($post_id, '_email', true);
            echo!empty($email) ? "<a href=mailto:" . $email . ">" . $email . "</a>" : '&#8212;';
            break;
        case 'phone':
            $phone = get_post_meta($post_id, '_phone', true);
            echo!empty($phone) ? $phone : '&#8212;';
            break;
        case 'request':
            $request = get_post_meta($post_id, '_request', true);
            echo!empty($request) ? $request : '&#8212;';
            break;
        default:
    }
}

add_action('manage_ticket_posts_custom_column', 'wp_fanzone_ticket_column_value', 10, 2);

// make it sortable
function wp_fanzone_edit_reservation_sortable_columns($columns) {
    $columns['bookdate'] = 'bookdate';
    return $columns;
}

add_filter('manage_edit-reservation_sortable_columns', 'wp_fanzone_edit_reservation_sortable_columns');

function book_slice_orderby($query) {
    if (!is_admin())
        return;

    $orderby = $query->get('orderby');

    if ('bookdate' == $orderby) {
        $query->set('meta_key', '_bookdate_date');
        $query->set('orderby', 'meta_value');  // "meta_value_num" is used for numeric sorting
        // "meta_value"     is used for Alphabetically sort.
        // We can user any query params which used in WP_Query.
    }
}

add_action('pre_get_posts', 'book_slice_orderby');

function wp_fanzone_column_value($column, $post_id) {
    switch ($column) {
        case 'user':
            $u_ID = get_post_meta($post_id, '_user', true);
            $name = get_display_name($u_ID);
            echo!empty($name) ? $name : '&#8212;';
            break;
        case 'zone':
            $zone = get_post_meta($post_id, '_zone', true);
            echo!empty($zone) ? $zone : '&#8212;';
            break;
        case 'people':
            $people = get_post_meta($post_id, '_people', true);
            echo!empty($people) ? $people : '&#8212;';
            break;
        case 'bookdate':
            $book_date = get_post_meta($post_id, '_bookdate', true);
            echo!empty($book_date) ? $book_date : '&#8212;';
            break;
        case 'slottime':
            $slot = get_post_meta($post_id, '_slottime', true);
            echo!empty($slot) ? $slot : '&#8212;';
            break;
            break;
    }
}

add_action('manage_reservation_posts_custom_column', 'wp_fanzone_column_value', 10, 2);

function wp_fanzone_user_table_row($val, $column_name, $user_id) {
    $date_format = 'j M, Y';
    $user_data = get_userdata($user_id);
    $current_user_role = $user_data->roles;
    switch ($column_name) {
        case 'Contact_number' :
            return get_user_meta($user_id, "contact_number", true);
        case 'Member_Id' :
           
                return get_user_meta($user_id, "member_ID", true);
            
		case 'Address':
			return get_user_meta($user_id, "address_one", true);
        case 'Pool_key' :
           
                return get_user_meta($user_id, "pool_key", true);
            
        case 'Annual_due' :
            
                return get_user_meta($user_id, "annual_dues", true);
            
        case 'dues_amount' :
            
                $amount = get_user_meta($user_id, "dues_amount", true);
                if(!empty($amount) ){
                    return "$".$amount;
                }else{
                    return '';
                }
            
        case 'Date_created' :
            return date($date_format, strtotime(get_the_author_meta('registered', $user_id)));
        default:
    }
    return $val;
}

add_filter('manage_users_custom_column', 'wp_fanzone_user_table_row', 10, 3);

function wp_fanzone_sortable_columns($columns) {
    return wp_parse_args(array('Date_created' => 'registered'), $columns);
}

add_filter('manage_users_sortable_columns', 'wp_fanzone_sortable_columns');


/* * * Sort and Filter Users ** */
add_action('restrict_manage_users', 'filter_by_due_status');

function filter_by_due_status($which) {
    // template for filtering
    $st = '<select name="due_status_%s" style="float:none;margin-left:10px;">
    <option value="">%s</option>%s</select>';

    // generate options
    $options = '<option value="Due">Due</option>
    <option value="Current">Current</option>';

    // combine template and options
    $select = sprintf($st, $which, __('Dues Status...'), $options);

    // output <select> and submit button
    echo $select;
    submit_button(__('Filter'), null, $which, false);
}

function filter_users_due_status_section($query) {
    global $pagenow;
    if (is_admin() && 'users.php' == $pagenow) {

        $top = isset($_GET['due_status_top']) ? $_GET['due_status_top'] : null;
        $bottom = isset($_GET['due_status_bottom']) ? $_GET['due_status_bottom'] : null;
        if (!empty($top) OR ! empty($bottom)) {
            $section = !empty($top) ? $top : $bottom;
            $query->query_vars['role__in'] = array('pool_member');
            // change the meta query based on which option was chosen
            $meta_query = array(array(
                    'key' => 'annual_dues',
                    'value' => $section,
                    'compare' => 'LIKE'
                ));
            $query->set('meta_query', $meta_query);
        }
    }
}

add_filter('pre_get_users', 'filter_users_due_status_section');

require get_template_directory() . '/inc/pool-settings.php';
require get_template_directory() . '/inc/pool-settings-save.php';

add_filter('send_password_change_email', '__return_false');

function get_zone_no_by_name($zone) {
    $allzone = get_option('zone');
    $total = '';
    if (!empty($allzone)) {
        foreach ($allzone as $zonename) {
            $zone_name = $zonename['zone_name'];

            if ($zone_name == $zone) {
                $total = $zonename['setting_capacity'];
            }
        }
    }
    return $total;
}

function wp_fanzone_save_form_data_to_post($contact_form) {

    $form_id = $contact_form->id();

    $submission = WPCF7_Submission::get_instance();
    
    if (!$submission) {
        return;
    }
    $wpcf7 = WPCF7_ContactForm::get_current();
    
    $posted_data = $submission->get_posted_data();

    $new_post = array();
    if ($form_id == 1009) {

        $subject = $posted_data['request'][0];
        $fname = $posted_data['user-name'];
        $lname = $posted_data['user-lname'];
        $full_name = $fname . " " . $lname;
        $title = $subject . ' - ' . $fname . ' ' . $lname;
        $mesage = $posted_data['message'];
        $email = $posted_data['useremail'];
        $phone = $posted_data['userphone'];

        $user_ID = 0;
        $user = get_user_by('email', $email);
        if (!empty($user)) {
            $user_ID = $user->ID;
        }

        $args = array(
            'post_title' => $title,
            'post_status' => 'open',
            'post_type' => 'ticket',
            'post_content' => $mesage,
            'post_author' => $user_ID,
        );

        $post_id = wp_insert_post($args);
        
        $mail = $wpcf7->prop('mail');

        $mail['body'] = str_replace('[ticket]', "#".$post_id, $mail['body']);
        $mail['subject'] = str_replace('[ticket]', "#".$post_id, $mail['subject']);
        $wpcf7->set_properties(array(
                "mail" => $mail
            ));
                    
        
        if ($post_id) {
            add_post_meta($post_id, '_name', $full_name);
            add_post_meta($post_id, '_phone', $phone);
            add_post_meta($post_id, '_email', $email);
            add_post_meta($post_id, '_request', $subject);
        }
        
    }   
    return $wpcf7;
}
add_action('wpcf7_before_send_mail', 'wp_fanzone_save_form_data_to_post');


function my_custom_open_status_creation() {

    //open
    register_post_status('open', array(
        'label' => _x('Open', 'post'),
        'label_count' => _n_noop('Open <span class="count">(%s)</span>', 'Open <span class="count">(%s)</span>'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true
    ));

    //In Progress
    register_post_status('in_progress', array(
        'label' => _x('In Progress', 'post'),
        'label_count' => _n_noop('In Progress <span class="count">(%s)</span>', 'In Progress <span class="count">(%s)</span>'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true
    ));

    //Resolved
    register_post_status('resolved', array(
        'label' => _x('Resolved', 'post'),
        'label_count' => _n_noop('Resolved <span class="count">(%s)</span>', 'Resolved <span class="count">(%s)</span>'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true
    ) );
    //Present
    register_post_status('present', array(
        'label' => _x('Present', 'post'),
        'label_count' => _n_noop('Present <span class="count">(%s)</span>', 'Present <span class="count">(%s)</span>'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true
    )   );
}
add_action('init', 'my_custom_open_status_creation',0);

//1
function add_to_post_status_dropdown() {
    global $post;
    if ($post->post_type != 'ticket')
        return false;
    $status = ($post->post_status == 'open') ? "jQuery( '#post-status-display' ).text( 'Open' );
            jQuery( 'select[name=\"post_status\"]' ).val('Open');" : '';
    echo "<script>
        jQuery(document).ready( function() {
        jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"open\">Open</option>' );
        " . $status . "
    });
    </script>";
}

add_action('post_submitbox_misc_actions', 'add_to_post_status_dropdown');

function add_to_post_present_dropdown() {
    global $post;
    
    if ($post->post_type == 'ticket')
        return false;
    $status = ($post->post_status == 'present') ? "jQuery( '#post-status-display' ).text( 'Present' );
            jQuery( 'select[name=\"post_status\"]' ).val('present');" : '';
    echo "<script>
        jQuery(document).ready( function() {
        jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"present\">Present</option>' );
        " . $status . "
    });
    </script>";
}

add_action('post_submitbox_misc_actions', 'add_to_post_present_dropdown');

//2
function add_to_post_in_progress_status_dropdown() {
    global $post;
    if ($post->post_type != 'ticket')
        return false;
       
    $status = ($post->post_status == 'in_progress') ? "jQuery( '#post-status-display' ).text( 'In Progress' );
            jQuery( 'select[name=\"post_status\"]' ).val('In Progress');" : '';
    echo "<script>
        jQuery(document).ready( function() {
        jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"in_progress\">In Progress</option>' );
        " . $status . "
    });
    </script>";
}

add_action('post_submitbox_misc_actions', 'add_to_post_in_progress_status_dropdown');

//3
function add_to_post_resolved_status_dropdown() {
    global $post;
    if ($post->post_type != 'ticket')
        return false;
    $status = ($post->post_status == 'resolved') ? "jQuery( '#post-status-display' ).text( 'Resolved' );
            jQuery( 'select[name=\"post_status\"]' ).val('Resolved');" : '';
    echo "<script>
        jQuery(document).ready( function() {
        jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"resolved\">Resolved</option>' );
        " . $status . "
    });
    </script>";
}
add_action('post_submitbox_misc_actions', 'add_to_post_resolved_status_dropdown');

//1
function custom_status_add_in_quick_edit() {
    global $post;
    if ($post->post_type != 'ticket')
        return false;
    echo "<script>
        jQuery(document).ready( function() {
            jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"open\">Open</option>' );
        });
        </script>";
}
add_action('admin_footer-edit.php', 'custom_status_add_in_quick_edit');


function custom_status_add_in__present_quick_edit() {
    global $post;
    if ($post->post_type == 'ticket')
        return false;
    echo "<script>
        jQuery(document).ready( function() {
            jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"present\">Present</option>' );
        });
        </script>";
}

add_action('admin_footer-edit.php', 'custom_status_add_in__present_quick_edit');
//2
function in_progress_add_in_quick_edit() {
    global $post;
    if ($post->post_type != 'ticket')
        return false;
    echo "<script>
        jQuery(document).ready( function() {
            jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"in_progress\">In Progress</option>' );
        });
        </script>";
}

add_action('admin_footer-edit.php', 'in_progress_add_in_quick_edit');

//3
function resolved_add_in_quick_edit() {
    global $post;
    if ($post->post_type != 'ticket')
        return false;
    echo "<script>
        jQuery(document).ready( function() {
            jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"resolved\">Resolved</option>' );
        });
        </script>";
}

add_action('admin_footer-edit.php', 'resolved_add_in_quick_edit');

//1
function display_archive_state($states) {
    global $post;
    $arg = get_query_var('post_status');
    if ($arg != 'open') {
        if ($post->post_status == 'open') {
            echo "<script>
            jQuery(document).ready( function() {
                jQuery( '#post-status-display' ).text( 'open' );
            });
            </script>";
            return array('Open');
        }
    }
    return $states;
}

add_filter('display_post_states', 'display_archive_state');

//2
function in_progress_display_archive_state($states) {
    global $post;
    $arg = get_query_var('post_status');
    if ($arg != 'in_progress') {
        if ($post->post_status == 'in_progress') {
            echo "<script>
            jQuery(document).ready( function() {
                jQuery( '#post-status-display' ).text( 'In Progress' );
            });
            </script>";
            return array('In Progress');
        }
    }
    return $states;
}

add_filter('display_post_states', 'in_progress_display_archive_state');

//3
function resolved_display_archive_state($states) {
    global $post;
    $arg = get_query_var('post_status');
    if ($arg != 'resolved') {
        if ($post->post_status == 'resolved') {
            echo "<script>
            jQuery(document).ready( function() {
                jQuery( '#post-status-display' ).text( 'Resolved' );
            });
            </script>";
            return array('Resolved');
        }
    }
    return $states;
}
add_filter('display_post_states', 'resolved_display_archive_state');

//4
function resolved_display_archive_present($states) {
    global $post;
    if ($post->post_type == 'ticket')
        return false;
    $arg = get_query_var('post_status');
    if ($arg != 'present') {
        if ($post->post_status == 'present') {
            echo "<script>
            jQuery(document).ready( function() {
                jQuery( '#post-status-display' ).text( 'Present' );
            });
            </script>";
            return array('Present');
        }
    }
    return $states;
}
add_filter('display_post_states', 'resolved_display_archive_present');

function wp_fanzone_posts_orderby( $search, $wp_query) {
    if (!is_admin() || !$wp_query->is_main_query()) {
         return $search;
    }
    if ( ! $wp_query->is_main_query() && !$wp_query->is_search() ) {
        return $search;
    }
    $search_string = get_query_var( 's' );

    if ( ! filter_var( $search_string, FILTER_VALIDATE_INT ) ) {
        return $search;
    }
    if(!empty($search_string) ){
        return "AND wp_posts.ID = '" . intval( $search_string )  . "'";
    }

}
add_action('posts_search', 'wp_fanzone_posts_orderby', 10, 2 );

function rudr_mailchimp_subscribe_unsubscribe($email, $status, $merge_fields = array('FNAME' => '', 'LNAME' => '')) {
    /*
     * please provide the values of the following variables 
     * do not know where to get them? read above
     */
    $api_key = 'cb6e32d40622dee6b83b9218ba1044d0-us13';
    $list_id = 'cd9b925288';

    /* MailChimp API URL */
    $url = 'https://' . substr($api_key, strpos($api_key, '-') + 1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($email));


    /* MailChimp POST data */
    $data = array(
        'apikey' => $api_key,
        'email_address' => $email,
        'status' => $status, // in this post we will use only 'subscribed' and 'unsubscribed'
        'merge_fields' => $merge_fields // in this post we will use only FNAME and LNAME
    );
    return json_decode(rudr_mailchimp_curl_connect($url, 'PUT', $api_key, $data));
}

add_action('user_register', 'rudr_user_register_hook', 20, 1);

function rudr_user_register_hook($user_id) {

    $user = get_user_by('id', $user_id);


    $subscription = rudr_mailchimp_subscribe_unsubscribe($user->user_email, 'subscribed', array('FNAME' => $user->first_name, 'LNAME' => $user->last_name));

    /*
     * if user subscription was failed you can try to store the errors the following way
    */
    if ($subscription->status != 'subscribed') {
        update_user_meta($user_id, '_subscription_error', 'User was not subscribed because:' . $subscription->detail);
    } else {
        update_user_meta($user_id, '_subscription_success', 'User was  subscribed ');
    }
}

function rudr_mailchimp_curl_connect($url, $request_type, $api_key, $data = array()) {
    if ($request_type == 'GET')
        $url .= '?' . http_build_query($data);

    $mch = curl_init();
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode('user:' . $api_key)
    );
    curl_setopt($mch, CURLOPT_URL, $url);
    curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
    curl_setopt($mch, CURLOPT_CUSTOMREQUEST, $request_type); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
    curl_setopt($mch, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection

    if ($request_type != 'GET') {
        curl_setopt($mch, CURLOPT_POST, true);
        curl_setopt($mch, CURLOPT_POSTFIELDS, json_encode($data)); // send data in json
    }

    return curl_exec($mch);
}

add_action('delete_user', 'rudr_user_delete_hook', 20, 1);

function rudr_user_delete_hook($user_id) {
    $user = get_user_by('id', $user_id);
    $subscription = rudr_mailchimp_subscribe_unsubscribe($user->user_email, 'unsubscribed', array('FNAME' => $user->first_name, 'LNAME' => $user->last_name));
}


function get_all_pool_member($member_Id){
    $emails = '';
    $data = array();
    if($member_Id != ""){
        $args_1  = array(
            'meta_key' => 'member_ID',
            'meta_value' => $member_Id,
            'meta_compare' => '==' // everything but the exact match
        );
     
        $user_query = new WP_User_Query( $args_1 );
        $authors = $user_query->get_results();
    
        $member_role = '';
        if(!empty($authors) ):
    
            foreach ($authors as $user_data){
    
                $email = $user_data->user_email;
                $data[] = $email;       
    
            }
        endif;
        
        if(!empty($data)){
            $emails = implode(", ", $data);
        }
    }
    
    
    return $emails;
}

function wp_fanzone_custom_password_form() {
    global $post;
    $label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
    $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="form-inline post-password-form" method="post">
                <p>' . __( 'This content is password protected. Please enter password below to view. ' ) . '</p>
                <label for="' . $label . '">' . __( 'Password:' ) . ' <input name="post_password" id="' . $label . '" required type="password" size="20" /></label>
                <input type="submit" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form' ) . '"></form>';
    return $output;
}
add_filter('the_password_form', 'wp_fanzone_custom_password_form', 99);


function wp_fanzone_check_fields($errors, $update, $user) {
    
    if($user->role == "pool_member"){
        if ( empty( $_POST['member_ID'] ) ) {
    		$errors->add('member_ID',__('Please enter Member ID'));
    	}else{
    	    global $wpdb;

            $result = $wpdb->get_results ('SELECT * FROM `wp_usermeta` WHERE `meta_key` = "member_ID" AND meta_value = "'.$_POST['member_ID'].'"');
           
            if(sizeof($result) > 0){
                if(isset($user->ID) && $result[0]->user_id != $user->ID){
                    
                    $check_pool_member = $wpdb->get_results ('SELECT * FROM `wp_usermeta` WHERE `meta_key` = "pool_member" AND meta_value = "'.$user->ID.'"');
                    
                    $check_household_member = $wpdb->get_results ('SELECT * FROM `wp_usermeta` WHERE `meta_key` = "household" AND meta_value = "'.$user->ID.'"');
                    
                    if(sizeof($check_pool_member) == 0 && sizeof($check_household_member) == 0){
                        $errors->add('member_ID_unique',__('Please enter Unique Member ID'));        
                    }
                }
                
            }
    	    
    	}
    	
    }
}
add_action('user_profile_update_errors', 'wp_fanzone_check_fields', 10, 3);
        

add_filter( 'posts_join', 'wp_fanzone_search_join' );
function wp_fanzone_search_join($join) {
    global $pagenow, $wpdb;
	// Search on Edit page only on Reservation CPT
    if (is_admin() && 'edit.php' === $pagenow && 'reservation' === $_GET['post_type'] && ! empty( $_GET['s'])) {    
        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id LEFT JOIN '.$wpdb->users. ' ON '. $wpdb->postmeta .'.meta_value = '. $wpdb->users .'.ID';
    }
    return $join;
}

add_filter( 'posts_where', 'wp_fanzone_search_where' );
function wp_fanzone_search_where($where) {
    global $pagenow, $wpdb;
	// Search on Edit page only on Reservation CPT
    if (is_admin() && 'edit.php' === $pagenow && 'reservation' === $_GET['post_type'] && ! empty( $_GET['s'])) {
        $where = preg_replace(
            "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->users . ".display_name LIKE $1)", $where );
        $where.= " GROUP BY {$wpdb->posts}.id"; // Solves duplicated results
    }
    return $where;
}

function search_by_users_query($query)
{
    global $pagenow;
	global $wpdb;

    if (is_admin() && 'users.php' == $pagenow) {
        
        if(isset($_GET['s']) && $_GET['s'] != ""){
            //Remove trailing and starting empty spaces
            $the_search = trim($query->query_vars['search']);
    
           
            $the_search = trim($query->query_vars['search'], '*');
    
            $query->set('meta_query', array(
                'relation' => 'OR',
                
                array(
                    'key'     => 'first_name',
                    'value'   => $the_search,
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'last_name',
                    'value'   => $the_search,
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'member_ID',
                    'value'   => $the_search,
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'contact_number',
                    'value'   => $the_search,
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'address_one',
                    'value'   => $the_search,
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'address_two',
                    'value'   => $the_search,
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'zip',
                    'value'   => $the_search,
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'pool_key',
                    'value'   => $the_search,
                    'compare' => 'LIKE'
                ),
            ));
           
            $query->set('search', '');
        }
        
    }
}
add_action('pre_get_users', 'search_by_users_query', 20);

function wpfanzone_extra_buttons() { ?>
	<input type="submit" name="export_users" class="button button-primary" value="<?php _e('Export to CSV'); ?>" />
<?php }
add_action('manage_users_extra_tablenav','wpfanzone_extra_buttons');

function wpfanzone_export_csv() {
	if(isset($_REQUEST['export_users'])) {
		$user_query = new WP_User_Query( array ( 'orderby' => 'id', 'order' => 'ASC' ) );
		if($user_query->get_results()) {
			 header('Content-Type: text/csv');
		        header('Content-Disposition: attachment; filename="users.csv"');
		        header('Pragma: no-cache');
		        header('Expires: 0');
		        $file = fopen('php://output', 'w');
		        fputcsv($file, array(
					'Member ID',
		        	'First Name',
		        	'Last Name',
		        	'Email', 
		        	'Role',	
		        	'Contact Number', 
		        	'Address 1', 
		        	'Address 2', 
		        	'City', 
		        	'State', 
		        	'Zip', 
		        	'Purchase Date', 
		        	'Amount', 
		        	'Annual Dues',
		        	'Pool Key', 
		        	'User Notes'
				)
			    );
			foreach($user_query->get_results() as $user) {
				fputcsv($file, array(
					get_user_meta($user->ID,'member_ID',true), 
		        	$user->first_name,
		        	$user->last_name, 
		        	$user->user_email, 
		        	$user->roles[0],
		        	get_user_meta($user->ID,'contact_number',true), 
		        	get_user_meta($user->ID,'address_one',true),  
		        	get_user_meta($user->ID,'address_two',true), 
		        	get_user_meta($user->ID,'user_city',true), 
		        	get_user_meta($user->ID,'user_state',true), 
		        	get_user_meta($user->ID,'zip',true),  
		        	get_user_meta($user->ID,'purchase_date',true), 
		        	get_user_meta($user->ID,'dues_amount',true), 
		        	get_user_meta($user->ID,'annual_dues',true),
		        	get_user_meta($user->ID,'pool_key',true),
		        	get_user_meta($user->ID,'user_notes',true)
				)
			    );

			}
			exit();
		}
	}

}
add_action('init','wpfanzone_export_csv');
add_filter( 'admin_body_class', 'custom_admin_body_class' );
function custom_admin_body_class( $classes ) {
   $user = wp_get_current_user();
    if ( in_array( 'author', (array) $user->roles ) ) {
       $classes .= ' admin_author';  
    }
      

	return $classes;
}
