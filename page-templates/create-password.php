<?php
/**
 * Template Name: Create Password
 *
 * @package WP FanZone 1.0
 * @subpackage Create Password Page Template
 */

$get_ID = isset($_GET['user']) ? (int) trim($_GET['user']) : '';

add_filter( 'wp_robots', 'wp_robots_sensitive_page' );

if(!empty($get_ID) ){
    
    if ( is_user_logged_in() ) {
        wp_safe_redirect(home_url('/'));
        exit;
    }
    
    if(isset($_POST['submit']) && !empty($_POST['submit']) ):
            
        
        $password = isset($_POST['password']) ? esc_sql($_POST['password']) : '';
        $confirm_password = isset($_POST['confirmpassword']) ? esc_sql($_POST['confirmpassword']) : '';
        
        $user_id = $get_ID;
        
        $user_info = get_userdata($user_id);
        $email = '';
        if(!empty($user_info) ):
            $email = $user_info->user_email;
        endif; //endif
        
        $error = array();
        $success = array();

        if(empty($password) || empty($confirm_password) ):
            $error['required_field'] = "<strong>ERROR</strong> Required field is missing";
        elseif ( !email_exists($email) ):
            $error['user_empty'] = "<strong>ERROR</strong> This user Not exits";
        elseif ( strlen($password) < 8 ):                
            $error['pwd_length'] = "<strong>ERROR</strong> Password must be at least 8 characters";
        elseif($password != $confirm_password) :
            $error['pwd_not_match'] = "<strong>ERROR</strong> Confirm Password must be same as 'Password'";               
        endif;
        
        //runset post data
        unset($_POST['password']);
        unset($_POST['confirmpassword']);
        unset($_POST['submit']);
        
        if(count($error) == 0 ):
            
                wp_set_password( $password, $user_id);
                
                update_user_meta( $user_id, '_password_status', 1);

                if (!isset($_SESSION)) {
                    session_start();
                }
                $success['change_pwd'] = "Your password has been successfully set, You can now login!";
                $redirect_url = home_url( '/' );
                $redirect_url = add_query_arg( 'setpassword', 'true', $redirect_url );
                
                echo '<script>setTimeout(function(){  window.location.href = "'.$redirect_url.'";  }, 3000);</script>';
            
        endif;
            
    endif;  //endif
    
get_header(); ?>
    <div class="create-password-section">
        <div class="container-fluid h-100 vertical-center">
            <div class="tab-pane change-password">
                <?php if(sizeof($success) > 0) : ?>
                    <div class="create_pass_success"><?php echo $success['change_pwd']; ?></div>
                <?php endif; ?>
                <div class="tab-details">
                    <div class="title-box text-center">
                        <h2><?php _e('Create Password', get_theme_domain() ); ?></h2>
                        <p><?php _e('Please create a password to activate your account', get_theme_domain() ); ?></p>
                    </div>
                    <div class="row password-form">
                        <div class="col-md-12 col-sm-12">
                            <?php  
                            if(!empty($error) ):
                                foreach ($error as $errors ):
                                   echo ' <div class="row"><div class="col-md-12"><p class="alert alert-danger">'.$errors.'</p></div></div>';
                                endforeach;
                            endif;
                            ?>
                            <form name="addPassword" id="addPassword" action="" method="post">
                                <div class="form-group">
                                    <label><?php _e('Password', get_theme_domain()); ?></label>
                                    <input type="password" name="password" id="password" value="" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><?php _e('Confirm Password', get_theme_domain()); ?></label>
                                    <input type="password" name="confirmpassword" id="confirmpassword" value="" class="form-control" required>
                                </div>
                                <input type="submit" name="submit" value="<?php _e('Create Password',get_theme_domain() );?>" id="addpass" class="btn btn2">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();
}else{
    wp_safe_redirect(home_url('/'));
    exit;
}