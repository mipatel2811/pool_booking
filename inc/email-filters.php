<?php /**
 *  Custom register email
 *
 * @package WordPress
 * @subpackage WP FanZone
 * @since 1.0
 */

function wp_fanzone_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {
 
    $user_login = stripslashes( $user->user_login );
    $user_email = stripslashes( $user->user_email );
    $first_name = stripslashes( $user->first_name );
    $user_ID = stripslashes( $user->ID );
    $login_url  = home_url('/');
    $create_pass  = home_url('/create-password/');
    $create_pass = add_query_arg( 'user', $user_ID, $create_pass );

    global $wpdb;

    $welcome_email_data = $wpdb->get_results('SELECT * FROM '.$wpdb->posts.' WHERE post_title = "Welcome Email" AND post_type="email_template"');

    if(sizeof($welcome_email_data) > 0){
        $email_content = $welcome_email_data[0]->post_content;
        
        $email_Id = $welcome_email_data[0]->ID;
        $subject = get_field('mail_subject', $email_Id);
        
        $email_content = str_replace("{{name}}",$first_name,$email_content);
        $link = '<a href="'.$create_pass.'" target="_blank">click here</a>';
        $email_content = str_replace("{{link}}",$link,$email_content);

        $wp_new_user_notification_email['subject'] = $subject;
        $wp_new_user_notification_email['headers'] = array('Content-Type: text/html; charset=UTF-8');
        $wp_new_user_notification_email['message'] = $email_content;
     
        return $wp_new_user_notification_email;

    }else{
        return $wp_new_user_notification_email;
    }
    
}
add_filter( 'wp_new_user_notification_email', 'wp_fanzone_new_user_notification_email', 10, 3 );


function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {
    // Create new message
    $id = $user_data->ID;
    $fname = $user_data->first_name;
    $member_ID = get_user_meta($id,'member_ID',true);
    
    $url = home_url( "?action=rp&key=".$key."&login=".rawurlencode($user_login));

    global $wpdb;

    $welcome_email_data = $wpdb->get_results('SELECT * FROM '.$wpdb->posts.' WHERE post_title = "Forgot Password" AND post_type="email_template"');

    if(sizeof($welcome_email_data) > 0){
        $email_content = $welcome_email_data[0]->post_content;

        $email_content = str_replace("{{name}}",$first_name,$email_content);

        $email_content = str_replace("{{email}}",$user_login,$email_content);

        $link = '<a href="'.$url.'" target="_blank">'.$url.'</a>';
        $email_content = str_replace("{{link}}",$link,$email_content);

        $message = $email_content;

        return $message;
    }else{
        return $message;
    }
}
add_filter( 'retrieve_password_message', 'replace_retrieve_password_message', 10, 4 );