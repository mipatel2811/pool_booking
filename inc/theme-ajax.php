<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) Exit;
/**
 * Theme Ajax
 *
 * Handles to all theme shortcodes to render html from it
 *
 * @since WP FanZone 1.0
 **/
function wp_fanzone_ajax_login(){

    // Nonce is checked, get the POST data and sign user on
    
    $username = isset($_POST['username']) ? esc_sql($_POST['username']) : '';
    $password = isset($_POST['password']) ? esc_sql($_POST['password']) : '';
    $remember_me = isset($_POST['remember_me']) ? esc_sql($_POST['remember_me']) : '';
        
    $login_array = array();
        
    $login_array['user_login'] = $username;
    $login_array['user_password'] = $password;
    $login_array['remember'] = $remember_me;

    $user_signon = wp_signon( $login_array, false );
    
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','wp-fanzone'),'color'=>'#ff3333') );
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...','wp-fanzone'),'color'=>'#008000') );
    }
    die();
}
add_action( 'wp_ajax_nopriv_ajaxlogin', 'wp_fanzone_ajax_login' );


function wp_fanzone_ajax_forgotpass(){

    // Nonce is checked, get the POST data and sign user on
    $email = isset($_POST['user_login']) ? esc_sql($_POST['user_login']) : '';
   
    $data = array();
   
    if(!empty($email) ){
        
        if( ! email_exists( $email ) ){
            $data = array('checkemail'=>false, 'message'=>__('A registered email for that user has not been found.','wp-fanzone' ),'color'=>'#ff3333');
        }else{
            $user_id = null;
            $user = get_user_by( 'email', $email );
            
            if(!empty($user) ):
               
                $user_id = (int) $user->ID;
                $user_login = $user->user_login;
                $member_ID = get_user_meta($user_id,'member_ID',true);
                $user_data = get_userdata($user_id);
            endif; //endif
           
            $key = get_password_reset_key( $user_data );
 
            if ( is_wp_error( $key ) ) {
                return $key;
            }
            
            $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
            $message .= network_home_url( '/' ) . "\r\n\r\n";
            $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
            $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
            $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";

            // replace PAGE_ID with reset page ID
            $message .= esc_url( get_permalink( PAGE_ID ) . "/?action=rp&key=$key&login=" . rawurlencode($user_login) ) . "\r\n";

            if ( is_multisite() )
                    $blogname = $GLOBALS['current_site']->site_name;
            else
                
            /*
             * The blogname option is escaped with esc_html on the way into the database
             * in sanitize_option we want to reverse this for the plain text arena of emails.
             */
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

            $title = sprintf( __('[%s] Password Reset'), $blogname );
            $title = get_field('mail_subject', 1055);

            /**
             * Filter the subject of the password reset email.
             *
             * @since 2.8.0
             * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
             *
             * @param string  $title      Default email title.
             * @param string  $user_login The username for the user.
             * @param WP_User $user_data  WP_User object.
             */
            $title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );
	
            $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

            
            
        if ( wp_mail( $email, wp_specialchars_decode( $title ), $message ) ){
                // Errors found
                $redirect_url = home_url( '/' );
                $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
                $data = array('checkemail'=>true, 'redirect'=>$redirect_url,'message'=>__('Check your email for a link to reset your password.','wp-fanzone'),'color'=>'#008000');
                
            } else {
                // Email sent
                $msg = $errors->get_error_message( $errors->get_error_code() );
                $data = array('checkemail'=>false, 'message'=>$msg,'color'=>'#ff3333');
                
            }

        }
        
    }else{
        $data = array('checkemail'=>false, 'message'=>__('Wrong Email ID','wp-fanzone'),'color'=>'#ff3333');
    }
    echo json_encode($data);
    die();
}
add_action( 'wp_ajax_nopriv_ajax_forgotpass', 'wp_fanzone_ajax_forgotpass' );
add_action( 'wp_ajax_lost_pass', 'wp_fanzone_ajax_forgotpass' );

function wp_fanzone_ajax_resetpass(){

    // Nonce is checked, get the POST data and sign user on
    
    $password = isset($_POST['password']) ? esc_sql($_POST['password']) : '';
    $confirmpassword = isset($_POST['confirmpassword']) ? esc_sql($_POST['confirmpassword']) : '';
    $login = isset($_POST['userlogin']) ? esc_sql($_POST['userlogin']) : '';
    $useraction = isset($_POST['useraction']) ? $_POST['useraction'] : '';
    $key = isset($_POST['key']) ? $_POST['key'] : '';
        
    
    if ( is_user_logged_in() ) {
        wp_safe_redirect(home_url('/'));
        exit;
    }
    $response = array();
    if( isset($key) && isset($login) ){
        
        $user = get_user_by( 'login', $login );
        if(!empty($user)){
            $user_ID = $user->ID;
            $user_email = $user->user_email;
        }
        
        
        if(empty($password) || empty($confirmpassword) ):
            $response = array('loggedin'=>false, 'message'=>__('<strong>ERROR</strong> Required field is missing','wp-fanzone'),'color'=>'#ff3333');
        elseif ( !email_exists($user_email) ):
            $response = array('loggedin'=>false, 'message'=>__('<strong>ERROR</strong> This user Not exits','wp-fanzone'),'color'=>'#ff3333');
        elseif ( strlen($password) < 8 ):   
            $response = array('loggedin'=>false, 'message'=>__('<strong>ERROR</strong> Password must be at least 8 characters','wp-fanzone'),'color'=>'#ff3333');
        elseif($password != $confirmpassword) :
            $response = array('loggedin'=>false, 'message'=>__('<strong>ERROR</strong> Confirm Password must be same as Password','wp-fanzone'),'color'=>'#ff3333');
        else:
            
                wp_set_password( $password, $user_ID);
                 
                $pass_changed_count = get_user_meta($user_ID,'_password_status',true); 
                $pass_changed_count= $pass_changed_count ? $pass_changed_count : 0;
                $pass_changed_count = $pass_changed_count + 1;
                update_user_meta( $user_data, '_password_status', $pass_changed_count);
                $redirect_url = home_url( '/' );
                $redirect_url = add_query_arg( 'password', 'changed', $redirect_url );
                $response = array('loggedin'=>true,'redirect'=>$redirect_url,'message'=>__('Password Reset successfully, redirecting...','wp-fanzone'),'color'=>'#008000');
            
        endif;
    
    }else{
        $response = array('loggedin'=>false, 'message'=>__('Key not Found try again','wp-fanzone'),'color'=>'#ff3333');
    }
    echo json_encode($response);
    die();
}
add_action( 'wp_ajax_nopriv_ajax_resetpass', 'wp_fanzone_ajax_resetpass' );


add_action( 'wp_ajax_nopriv_get_pool_member_info', 'wp_fanzone_get_pool_member_info' );
add_action( 'wp_ajax_get_pool_member_info', 'wp_fanzone_get_pool_member_info' );

function wp_fanzone_get_pool_member_info(){
    $pool_member = $_POST['pool_member'];

    $member_ID = get_user_meta($pool_member, 'member_ID', true);
    $contact_number = get_user_meta($pool_member, 'contact_number', true);
    $address_one = get_user_meta($pool_member, 'address_one', true);
    $address_two = get_user_meta($pool_member, 'address_two', true);
    $user_city = get_user_meta($pool_member, 'user_city', true);
    $zip = get_user_meta($pool_member, 'zip', true);
    $purchase_date = get_user_meta($pool_member, 'purchase_date', true);
    $dues_amount = get_user_meta($pool_member, 'dues_amount', true);
    $pool_key = get_user_meta($pool_member, 'pool_key', true);
    $annual_dues = get_user_meta($pool_member, 'annual_dues', true);

    echo json_encode(
            array(
                'member_ID'         => $member_ID,
                'contact_number'    => $contact_number,
                'address_one'       => $address_one,
                'address_two'       => $address_two,
                'user_city'         => $user_city,
                'zip'               => $zip,
                'purchase_date'     => $purchase_date,
                'dues_amount'       => $dues_amount,
                'pool_key'          => $pool_key,
                'annual_dues'       => $annual_dues
            )
        );
    exit;
    
}
add_action( 'wp_ajax_nopriv_get_poolmember', 'wp_fanzone_get_poolmember' );
add_action( 'wp_ajax_get_poolmember', 'wp_fanzone_get_poolmember' );

function wp_fanzone_get_poolmember(){

    $usersargs = new WP_User_Query( array(
        'search'         => '*'.esc_attr( $_GET['q'] ).'*',
        'search_columns' => array(
            'user_login',
            'user_nicename',
            'user_email',
            'user_url',
        ),
        'role'    => 'pool_member',
        'orderby' => 'user_nicename',
        'order'   => 'ASC'
    ) );
    $users = $usersargs->get_results();
    
    $user_data = array();
    foreach ($users as $user) { 
        $HH_user_ID = $user->ID;
        $user_name = $user->first_name;
        $user_email = $user->user_email;
        $user_member_ID = get_user_meta($HH_user_ID,'member_ID',true);

        $username = $user_name." - ".$user_email." - #".$user_member_ID; 
        $return[] = array( $user->ID, $username );
    }

    echo json_encode( $return );
    die;
}

function wp_fanzone_ajax_book_reservation(){
    
    $user      = isset($_POST['user'])      ? esc_sql($_POST['user'])   : '';
    $zone      = isset($_POST['zone'])      ? esc_sql($_POST['zone'])   : '';
    $people    = isset($_POST['people'])    ? esc_sql($_POST['people']) : '';
    $book_date = isset($_POST['book_date']) ? $_POST['book_date']       : '';
    $slottime  = isset($_POST['slottime'])  ? $_POST['slottime']        : '';
    $book_id   = isset($_POST['book_id'])   ? $_POST['book_id']         : '';
    
    $weak_start_date = isset($_POST['weak_s_date'])   ? $_POST['weak_s_date']   : '';
    $weak_end_date   = isset($_POST['weak_e_date'])   ? $_POST['weak_e_date']   : '';
    
    
    
    
    $zone_cap = get_zone_no_by_name($zone);
    
    $today_booking = '';
    $weak_booking = '';
    
    if ( !is_user_logged_in() ) {
        $safe_url = home_url( '/' );
        $safe_url = add_query_arg( 'getlogin', 'true', $safe_url );
        wp_safe_redirect($safe_url);
        exit;
    }
    
    global $current_user;
    $user_ID = $current_user->ID;
        
    $response = array();
    if( !empty($user) && $user == $user_ID ){
        
        $user = get_user_by( 'id', $user_ID );
        if(!empty($user) ){
            $user_email = $user->user_email;
            $user_fname = $user->first_name;
            $user_role = $user->roles[0];
            $member_ID = get_user_meta( $user->ID, 'member_ID',true );
        }
        
        $emails = get_all_pool_member($member_ID);
        $emails = ($emails != "") ? $emails : $user_email;
        
        if($user_role != 'administrator'){
            $args = array('posts_per_page'=>-1, 'post_type'=>'reservation','post_status'=>'publish',
                            'meta_query' => array( 
                                'relation' => 'AND',
                                array( 'key' => '_member_id','value' => $member_ID, 'compare' => '=='),
                                array( 'key' => '_bookdate' ,'value' => $book_date, 'compare' => '==')
                            ),
                        );
            $get_reservations = new WP_Query($args);
            $today_booking = $get_reservations->found_posts;
            wp_reset_postdata(); 

            if(!empty($weak_start_date) && !empty($weak_end_date) ){

                $weak_args = array('posts_per_page'=>-1, 'post_type'=>'reservation','post_status'=>'publish',
                                'meta_query' => array( 
                                    'relation' => 'AND',
                                    array( 'key' => '_member_id','value' => $member_ID, 'compare' => '=='),
                                    array( 'key' => '_bookdate_date' ,'value'   => [$weak_start_date, $weak_end_date],  'compare' => 'BETWEEN', 'type' => 'DATE')
                                ),
                            );

                $weak_reservations = new WP_Query($weak_args);
                $weak_booking = $weak_reservations->found_posts;
                wp_reset_postdata(); 
            }
        }
        
        $temp_date = strtotime($book_date);
        $formatted_date = date("Y-m-d", $temp_date);
        
        global $wpdb;
        
        $table_name =  $wpdb->prefix."reserved_zone";
        
        $check_if_reserved = "SELECT ID, zonename FROM $table_name WHERE zonename = '$zone' AND slotname = '$slottime' AND date= '$book_date' AND user_id != '$user_ID' ";
        
        $get_reserved_zone = $wpdb->get_results($check_if_reserved);
        
        $check_if_reserved_already = "SELECT ID
                                        FROM wp_posts
                                        INNER JOIN wp_postmeta m1
                                          ON ( wp_posts.ID = m1.post_id )
                                          INNER JOIN wp_postmeta m2
                                          ON ( wp_posts.ID = m2.post_id )
                                          INNER JOIN wp_postmeta m3
                                          ON ( wp_posts.ID = m3.post_id )
                                          INNER JOIN wp_postmeta m4
                                          ON ( wp_posts.ID = m4.post_id )
                                        WHERE
                                        wp_posts.post_type = 'reservation'
                                        AND wp_posts.post_status = 'publish'
                                        AND ( m1.meta_key = '_bookdate_date' AND m1.meta_value = '$formatted_date' )
                                        AND ( m2.meta_key = '_slottime' AND m2.meta_value = '$slottime' )
                                        AND ( m3.meta_key = '_zone' AND m3.meta_value = '$zone' )
                                        AND ( m4.meta_key = '_user' AND m4.meta_value != '$user_ID' )
                                        GROUP BY wp_posts.ID
                                        ORDER BY wp_posts.post_date
                                        DESC";
        $check_if_reserved_zone = $wpdb->get_results($check_if_reserved_already);
        
        
        $check_if_total_sql = "SELECT count(ID) count_reservation
                                        FROM wp_posts
                                        INNER JOIN wp_postmeta m1
                                          ON ( wp_posts.ID = m1.post_id )
                                        WHERE
                                        wp_posts.post_type = 'reservation'
                                        AND wp_posts.post_status = 'publish'
                                        AND ( m1.meta_key = '_bookdate_date' AND m1.meta_value = '$formatted_date' )";
        
        
        $check_if_total_result = $wpdb->get_results($check_if_total_sql);
        
        $total_flag = 0;
        
        if(sizeof($check_if_total_result) > 0){
            if(isset($check_if_total_result[0]->count_reservation)){
                $total_flag = $check_if_total_result[0]->count_reservation; 
            }
        }
        
        
        
        $now = time(); // or your date as well
        $your_date = strtotime($formatted_date);
        $datediff = $your_date - $now;
        
        $difference = round($datediff / (60 * 60 * 24));
        
        $get_today = date('w');
        $future = 0;
        if($user_role != 'administrator'){
            if($get_today == 0 || $get_today == 6){
                if($get_today == 0){
                    if($difference > 6 ){
                       $future = 1; 
                    }
                }else{
                   if($difference > 7 ){
                       $future = 1; 
                    } 
                }
            }else{
                $max_days = 6 - $get_today;
               if($difference > $max_days ){ 
                    $future = 1; 
               }
            }
        }
        
        
        
        
        
        
        if( empty($people) || empty($book_date) || empty($slottime) ):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Please fill all values','wp-fanzone'),'color'=>'#ff3333');
        elseif ( empty($zone) ):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Please select any zone','wp-fanzone'),'color'=>'#ff3333');
        elseif ( empty($people) ):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Please select no of People','wp-fanzone'),'color'=>'#ff3333');
        elseif ( empty($book_date) ):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Please select date','wp-fanzone'),'color'=>'#ff3333');
        elseif ( empty($slottime) ):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Please select time slot','wp-fanzone'),'color'=>'#ff3333');
        
        elseif ( empty($book_id) &&  !empty($today_booking) && $today_booking >= 1 ):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Pool reservations are limited to one per day.','wp-fanzone'),'color'=>'#ff3333');
        elseif ( empty($book_id) &&  !empty($weak_booking) && $weak_booking >= 3 ):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Pool reservations are currently limited to 3 per week.','wp-fanzone'),'color'=>'#ff3333');
        
        elseif ( $people > $zone_cap ):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Please select zone with high seat','wp-fanzone'),'color'=>'#ff3333');
        
        elseif (sizeof($get_reserved_zone) > 0):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Sorry, This zone is already booked by someone else.','wp-fanzone'),'color'=>'#ff3333');
            
         elseif (sizeof($check_if_reserved_zone) > 0):
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Sorry, This zone is already booked by someone else.','wp-fanzone'),'color'=>'#ff3333');
            
        elseif ($total_flag >= 60): 
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Sorry, The bookings are full for this date, Try for some other day.','wp-fanzone'),'color'=>'#ff3333');
            
        elseif ($future  == 1): 
            $response = array('success'=>false, 'message'=> __('<strong>ERROR</strong> Sorry, Please book only allowed date.','wp-fanzone'),'color'=>'#ff3333');
        else:
            
                if(!empty($book_id) ){
                    $args = array(
                            'ID'          => $book_id,
                            'post_type'   => 'reservation',
                            'post_status' => 'publish',
                        );
                    $bID = wp_update_post($args);


                }else{
                    $args = array(
                            'post_type'   => 'reservation',
                            'post_status' => 'publish',
                        );
                    $bID = wp_insert_post($args);

                }
            
                $user_ip = wp_fanzone_get_ip();
                
                $temp_date = strtotime($book_date);
                $formatted_date = date("Y-m-d", $temp_date);
                                    
                $member_ID = get_user_meta( $user_ID, 'member_ID',true );
                
                
                if(!empty($bID) ):
                    update_post_meta( $bID, '_user', $user_ID );
                    update_post_meta( $bID, '_zone', $zone );
                    update_post_meta( $bID, '_people', $people );
                    update_post_meta( $bID, '_bookdate', $book_date );
                    update_post_meta( $bID, '_bookdate_date', $formatted_date );
                    update_post_meta( $bID, '_slottime', $slottime );
                    update_post_meta( $bID, '_userip', $user_ip );
                    update_post_meta( $bID, '_member_id', $member_ID );
                endif;        
                
                
                $login_url = home_url( '/' );
                $login_url = add_query_arg( 'getlogin', 'true', $login_url );
                
                global $wpdb;
                
                $msg = get_field('mail_subject', 1063);
                $msg = str_replace("{{bid}}","#".$bID,$msg);
                $msg = str_replace("{{bookdate}}",$book_date,$msg);
                $msg = str_replace("{{slottime}}",$slottime,$msg);
                $msg = str_replace("{{zone}}",$zone,$msg);
                
                $welcome_email_data = $wpdb->get_results('SELECT * FROM '.$wpdb->posts.' WHERE ID = "1063" AND post_type="email_template"');

                if(sizeof($welcome_email_data) > 0){
                    $email_content = $welcome_email_data[0]->post_content;

                    $email_content = str_replace("{{name}}",$user_fname,$email_content);
                    $email_content = str_replace("{{bid}}","#".$bID,$email_content);
                    $email_content = str_replace("{{email}}",$user_email,$email_content);
                    $email_content = str_replace("{{zone}}",$zone,$email_content);
                    $email_content = str_replace("{{people}}",$people,$email_content);
                    $email_content = str_replace("{{slottime}}",$slottime,$email_content);
                    $email_content = str_replace("{{bookdate}}",$book_date,$email_content);
                    $email_content = str_replace("{{login_url}}",$login_url,$email_content);

                   
                    $cs_message = $email_content;
                }else{
                    $cs_message = "
                    <html>
                    <head>
                    <title>".$msg."</title>
                    </head>
                    <body>   
                    <table>
                    <tr><th>Booking ID</th><td>#".$bID."</td></tr>
                    <tr><th>Email ID</th><td>".$user_email."</td></tr>
                    <tr><th>Zone</th><td>".$zone."</td></tr>
                    <tr><th>No of People</th><td>".$people."</td></tr>
                    <tr><th>Book Date</th><td>".$book_date."</td></tr>
                    <tr><th>Slot Time</th><td>".$slottime."</td></tr>
                    </table>
                    </body>
                    </html>";
                }
                
                $cs_to = $emails;
                $cs_subject = $msg;
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'Content-Type: multipart/mixed;\n' . "\r\n";
                $headers .= 'From: <noreply@inmanparkpool.org>' . "\r\n";
                $customer_email = wp_mail($cs_to, $cs_subject, $cs_message, $headers);
                
                
                $post_title = "#".$bID;
                $u_args = array(
                    'ID'=>$bID,
                    'post_type'   => 'reservation',
                    'post_title'  => $post_title,
                );
                
                $bID = wp_update_post( $u_args );
                
                $redirect_url = get_permalink(979);
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['success_msg'] = __('Your pool reservation is confirmed.',get_theme_domain() );
                $response = array('success'=>true,'redirect'=>$redirect_url,'message'=>__('Pool reservation made successfully, redirecting...','wp-fanzone'),'color'=>'#008000');
            
        endif;
    
    }else{
        $response = array('success'=>false, 'message'=>__('User not found. Try again.','wp-fanzone'),'color'=>'#ff3333');
    }
    
    echo json_encode($response);
    die();
}
add_action( 'wp_ajax_book_reservation', 'wp_fanzone_ajax_book_reservation' );

function wp_fanzone_ajax_book_cancel(){
    
    $booking_ID = isset($_POST['booking'])  ? esc_sql($_POST['booking'])   : '';
    
    if ( !is_user_logged_in() ) {
        $safe_url = home_url( '/' );
        $safe_url = add_query_arg( 'getlogin', 'true', $safe_url );
        wp_safe_redirect($safe_url);
        exit;
    }
    
    global $current_user;
    $user_ID = $current_user->ID;
        
    $response = array();
    if( !empty($booking_ID) ){
        
        $user = get_user_by( 'id', $user_ID );
        if(!empty($user) ){
            $user_email = $user->user_email;
            $user_fname = $user->first_name;
            $member_ID = get_user_meta( $user->ID, 'member_ID',true );
        }
        
        $emails = get_all_pool_member($member_ID);
        $emails = $emails ? $emails : $user_email;
        
        
            $zone      = get_post_meta( $booking_ID, '_zone',true      );
            $people    = get_post_meta( $booking_ID, '_people',true    );
            $book_date = get_post_meta( $booking_ID, '_bookdate',true  );
            $slottime  = get_post_meta( $booking_ID, '_slottime' ,true );
                    
            $uID = wp_trash_post($booking_ID);
                
            if (is_wp_error($uID) ) {
                    $msg = $errors->get_error_message( $errors->get_error_code() );
                    $response = array('success'=>false, 'message'=>$msg,'color'=>'#ff3333');
            }else{
                
                global $wpdb;

                $pool_cancelled = $wpdb->get_results('SELECT * FROM '.$wpdb->posts.' WHERE ID = "1068" AND post_type="email_template"');
                
                
                if(sizeof($pool_cancelled) > 0){
                    $email_content = $pool_cancelled[0]->post_content;

                    $email_content = str_replace("{{name}}",$user_fname,$email_content);
                    $email_content = str_replace("{{bid}}","#".$booking_ID,$email_content);
                    $email_content = str_replace("{{bookdate}}",$book_date,$email_content);
                    $email_content = str_replace("{{slottime}}",$slottime,$email_content);
                    $email_content = str_replace("{{zone}}",$zone,$email_content);
                    
                    $cs_message = $email_content;
                }else{
                    $cs_message = "
                    <html>
                    <head>
                    <title>Your pool reservation has been cancelled</title>
                    </head>
                    <body>
                    <table>
                    <tr><th>Booking ID</th><td>#".$booking_ID."</td></tr>                   
                    </table>
                    </body>
                    </html>";
                }
                
                $msg = get_field('mail_subject', 1068);
                $msg = str_replace("{{bid}}","#".$booking_ID,$msg);
                $msg = str_replace("{{bookdate}}",$book_date,$msg);
                $msg = str_replace("{{slottime}}",$slottime,$msg);
                $msg = str_replace("{{zone}}",$zone,$msg);
                
                
                $cs_to = $emails;
                $cs_subject = $msg;
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'Content-Type: multipart/mixed;\n' . "\r\n";
                // More headers
                $headers .= 'From: <noreply@inmanparkpool.org>' . "\r\n";
                $customer_email = wp_mail($cs_to, $cs_subject, $cs_message, $headers);

                $redirect_url = get_permalink(979);
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['pool_cancel'] = __('Your pool reservation has been cancelled.',get_theme_domain() );
                $response = array('success'=>true,'redirect'=>$redirect_url,'message'=>__('Pool reservation has been cancelled, redirecting...','wp-fanzone'),'color'=>'#008000');
            }
    }else{
        $response = array('success'=>false, 'message'=>__('Select your Booking reservation to Cancel','wp-fanzone'),'color'=>'#ff3333');
    }
    
    echo json_encode($response);
    die();
}
add_action( 'wp_ajax_booking_cancal', 'wp_fanzone_ajax_book_cancel' );


function wp_fanzone_ajax_booked_zone(){
    
    $time_slot    = isset($_POST['time_slot'])    ? esc_sql($_POST['time_slot'])    : '';
    $startdate    = isset($_POST['startdate'])    ? esc_sql($_POST['startdate'])    : '';
    $total_people = isset($_POST['total_people']) ? esc_sql($_POST['total_people']) : '';
    
    global $wpdb;
    $response = array();
    
    if ( !is_user_logged_in() ) {
        $safe_url = home_url( '/' );
        $safe_url = add_query_arg( 'getlogin', 'true', $safe_url );
        wp_safe_redirect($safe_url);
        exit;
    }
    
    $data = array();
    if(!empty($total_people) ){
        $allzone = get_option('zone');
        
        if(!empty($allzone) ){
            foreach ( $allzone as $zonename ){
                
                $zone_name = $zonename['zone_name'];
                $zone_capacity = $zonename['setting_capacity'];
                $zone_status = $zonename['zone_status'];
                
                if($total_people > $zone_capacity ){
                    $data[] = $zone_name;
                }
            }
        }
    }
    
    if(!empty($time_slot) && !empty($startdate) ){
        
        $args = array('posts_per_page'=>-1, 'post_type'=>'reservation','post_status'=>'publish','orderby' => 'ID','order' => 'DESC',
                    'meta_query' => array( 
                            'relation' => 'AND',
                            array(
                                'key' => '_slottime',
                                'value' => $time_slot,
                                'compare' => '=='
                            ),
                            array(
                                'key' => '_bookdate',
                                'value' => $startdate,
                                'compare' => '=='
                            ),
                        )
                    );
        
        $reservations = new WP_Query($args);
        if($reservations->have_posts() ):
            while( $reservations->have_posts() ) : $reservations->the_post();
                    $zone = get_post_meta( get_the_ID(), '_zone',true );
                    $data[] = $zone;
            endwhile; //end of while loop
        endif; //endif
        wp_reset_postdata();
        
        //get reserved Zone
        $table_name =  $wpdb->prefix."reserved_zone";
        
        $sql = "SELECT ID, zonename FROM $table_name WHERE 1 = 1 AND slotname = '$time_slot' AND date= '$startdate'";
        
        $get_reserved_zone = $wpdb->get_results($sql);
        
        if(!empty($get_reserved_zone) ){
            foreach ($get_reserved_zone as $zonename){
                $data[] = $zonename->zonename;
            }
        }
        
    }
    
    $response['data'] = $data;
    
    echo json_encode($response);
    die();
}
add_action( 'wp_ajax_booked_zone', 'wp_fanzone_ajax_booked_zone' );


function set_present_callback(){
    if ( isset($_POST['booking']) ) {

        wp_update_post(array(
            'ID' => $_POST['booking'],
            'post_status' => 'present'
            )
        );
    }
    $response['status'] = 1;
    echo json_encode($response);
    die();
}
add_action( 'wp_ajax_set_present', 'set_present_callback' );
add_action( 'wp_ajax_nopriv_set_present', 'set_present_callback' );


function wp_funzone_reserved_zone_callback(){
    global $wpdb;
    $response = array();
    
    $zone      = isset($_POST['zone'])      ? esc_sql($_POST['zone'])      : '';
    $time_slot = isset($_POST['time_slot']) ? esc_sql($_POST['time_slot']) : '';
    $startdate = isset($_POST['startdate']) ? esc_sql($_POST['startdate']) : '';
    
    $table_name =  $wpdb->prefix."reserved_zone";
    
    if(!empty($zone) && !empty($time_slot) && !empty($startdate) ){
        $date = date('Y-m-d H:i:s');     
            
        global $current_user;
        $user_ID = $current_user->ID;
     
        $delete = $wpdb->query("DELETE FROM $table_name WHERE user_id = $user_ID");
        
        $zone_ID = $wpdb->insert($table_name, array('ID' => NULL, 'zonename' => $zone,'user_id'=> $user_ID, 'slotname' => $time_slot,'date' =>$startdate,'booking_time'=>$date ) ); 
        
    }
    
    if($zone_ID){
        $response['status'] = 1;   
    }
    echo json_encode($response);
    die();
}
add_action( 'wp_ajax_reserved_zone', 'wp_funzone_reserved_zone_callback' );