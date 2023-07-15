<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WP FanZone
 */
?>
<?php if( is_page_template('page-templates/create-password.php') ): ?>
<?php else: ?>
</div><!-- #content -->
    <footer id="colophon" class="site-footer">
        <?php if( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three') ): ?>
            <div class="container">
                <div class="row">
                    <?php if( is_active_sidebar( 'footer-one' ) ):  ?>
                        <div class="col-md-4">
                            <?php dynamic_sidebar('footer-one'); ?>
                        </div>
                    <?php endif; //Endif ?>
                    <?php if( is_active_sidebar( 'footer-two' ) ):  ?>
                        <div class="col-md-4">
                            <?php dynamic_sidebar('footer-two'); ?>
                        </div>
                    <?php endif; //Endif ?>
                    <?php if( is_active_sidebar( 'footer-three' ) ): ?>
                        <div class="col-md-4">
                            <?php dynamic_sidebar('footer-three'); ?>
                        </div>
                    <?php endif; //Endif ?>
                </div>
            </div>
        <?php endif; //Endif ?>
        <div class="site-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <?php echo __('&copy; ', 'wp-fanzone') . esc_attr(get_bloginfo('name', 'wp-fanzone')); ?>
                        <?php if (is_home() && !is_paged()) { ?>            
                            <?php echo __('Built with', 'wp-fanzone'); ?> 
                            <a href="<?php echo esc_url(__('https://wordpress.org/', 'wp-fanzone') ); ?>" rel="nofollow" target="_blank"><?php printf(esc_html('%s', 'wp-fanzone'), 'WordPress'); ?></a>
                                <span><?php esc_html_e(' and ', 'wp-fanzone'); ?></span>
                            <a href="<?php echo esc_url(__('https://wpdevshed.com/wp-fanzone-theme/', 'wp-fanzone')); ?>" rel="nofollow" target="_blank"><?php printf(esc_html('%s', 'wp-fanzone'), 'WP FanZone'); ?></a>
                        <?php } ?>
                    </div>
                    <div class="col-md-5 fan-sociel-media">
                        <?php if (get_theme_mod('wp_fanzone_email') ) : ?>
                            <a href="<?php _e('mailto:', 'wp-fanzone'); echo sanitize_email(get_theme_mod('wp_fanzone_email') ); ?>" class="btn btn-default btn-xs" title="Email">
                                <span class="fa fa-envelope"></span>
                            </a>
                        <?php endif; ?>             	
                        <?php if (get_theme_mod('wp_fanzone_rss') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_rss') ); ?>" class="btn btn-default btn-xs" title="RSS"><span class="fa fa-rss"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_vimeo') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_vimeo') ); ?>" class="btn btn-default btn-xs" title="Vimeo"><span class="fa fa-vimeo-square"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_flickr') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_flickr') ); ?>" class="btn btn-default btn-xs" title="Flickr"><span class="fa fa-flickr"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_instagram') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_instagram') ); ?>" class="btn btn-default btn-xs" title="Instagram"><span class="fa fa-instagram"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_tumblr') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_tumblr') ); ?>" class="btn btn-default btn-xs" title="Tumblr"><span class="fa fa-tumblr"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_youtube') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_youtube') ); ?>" class="btn btn-default btn-xs" title="Youtube"><span class="fa fa-youtube"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_linkedin') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_linkedin') ); ?>" class="btn btn-default btn-xs" title="Linkedin"><span class="fa fa-linkedin"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_pinterest') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_pinterest') ); ?>" class="btn btn-default btn-xs" title="Pinterest"><span class="fa fa-pinterest"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_google') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_google') ); ?>" class="btn btn-default btn-xs" title="Google Plus"><span class="fa fa-google-plus"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_twitter') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_twitter') ); ?>" class="btn btn-default btn-xs" title="Twitter"><span class="fa fa-twitter"></span></a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('wp_fanzone_facebook') ) : ?>
                            <a target="_blank" href="<?php echo esc_url(get_theme_mod('wp_fanzone_facebook') ); ?>" class="btn btn-default btn-xs" title="Facebook"><span class="fa fa-facebook"></span></a>
                        <?php endif; ?>              
                    </div> <!--end fan-sociel-media-->
                </div>
            </div>
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php if (!is_user_logged_in() ): ?>
<!-- Login Popup Start -->
<div class="popouterbox account_popups" id="account_login">
    <div class="popup-block">
        <div class="pop-contentbox">
            <div class="account-login-block">
                <div class="account-login-block-details">
                    <span><?php _e('Welcome back',get_theme_domain() ); ?></span>
                    <h2><?php _e('Login to Your Account',get_theme_domain() ); ?></h2>
                    <form name="formLogin" id="formLogin" action="" method="post">
                        <div class="form-group">
                            <label for="user_login"><?php _e('Email',get_theme_domain() );?></label>
                            <input type="text" name="username" id="user_login" class="form-control" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="user_pass"><?php _e('Password',get_theme_domain() );?></label>
                            <input name="password" type="password" id="user_pass" class="form-control" value="" required>
                        </div>
                        <div class="row align-items-center justify-center">
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="remember_me" id="remember_me" value=""><?php _e('Remember Me',get_theme_domain() );?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group text-right">
                                    <a href="javascript:void(0);" class="poptrigger" data-rel="account_frg_pwd"><?php _e('Forgot Password?',get_theme_domain() );?></a>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="submit" value="<?php _e('Login',get_theme_domain() );?>" id="login" class="login-out-btn">
                        <div class="form-group">
                            <p class="status-msg"></p>
                        </div>
                    </form>
                    <?php /*<div class="other-login-option">
                        <p><?php _e('Don&#8217;t have an account? ',get_theme_domain() ); ?><a href="javascript:void(0);" class="poptrigger" data-rel="account_registration"><?php _e('Register Here',get_theme_domain() ); ?></a></p>
                    </div> */
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Popup End -->
<?php endif; //endif ?>


<?php if(is_page('registration') ): ?>
<?php
$heading = get_field('heading','option');
$sub_heading = get_field('sub_heading','option');
$form_shortcode = get_field('form_shortcode','option');
$login_text = get_field('login_text','option');
?>
<?php if( !empty($heading) || !empty($sub_heading) || !empty($form_shortcode) || !empty($login_text) ): ?>
    <!-- registration Popup Start -->
    <div class="popouterbox account_popups register-account" id="account_registration">
        <div class="popup-block">
            <div class="pop-contentbox">
                <div class="account-login-block">
                    <div class="account-login-block-details">
                        <?php if(!empty($sub_heading) ): ?>
                            <span><?php echo $sub_heading; ?></span>
                        <?php endif; //endif ?>
                        <?php if(!empty($heading) ): ?>
                            <h2><?php echo $heading; ?></h2>
                        <?php endif; //endif ?>
                        <?php if( !empty($form_shortcode) ): ?>
                            <?php echo do_shortcode($form_shortcode); ?>
                        <?php endif; //endif ?>
                        <?php if (!is_user_logged_in() ): ?>
                            <div class="other-login-option">
                                <p><?php echo $login_text; ?> <a href="javascript:void(0);" class="poptrigger" data-rel="account_login"><?php _e('Login Here',get_theme_domain() );?></a></p>
                            </div>
                        <?php endif; //endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- registration Popup End -->
    <?php endif; //endif ?>
<?php endif; //endif ?>

<!-- Forgot Password Popup Start -->
<div class="popouterbox account_popups" id="account_frg_pwd">
    <div class="popup-block">
        <div class="pop-contentbox">
            <div class="account-login-block">
                <div class="account-login-block-details">
                    <h2><?php _e('Forgot Password',get_theme_domain() ); ?></h2>
                    <p><?php _e('To reset your password, enter your registered email address. An email with instructions will be sent to you.',get_theme_domain() ); ?></p>
                    <form role="form" name="lostpassword" id="formforgetPass" action="" method="post">
                        <div class="form-group">
                            <label><?php _e('Email',get_theme_domain() );?></label>
                            <input type="email" name="email" value="" size="40" autocapitalize="off" id="sendemail" class="form-control" required>
                        </div>
                        <input type="submit" name="submit" id="lostpassword" value="<?php _e('Send Link',get_theme_domain() );?>" class="login-out-btn">
                        <div class="form-group">
                            <p class="pass_info"></p>
                        </div>
                        <div class="row-blk">
                            <?php if (!is_user_logged_in() ): ?>
                                <div class="col">
                                    <div class="form-group">
                                        <a href="javascript:void(0);" class="poptrigger" data-rel="account_login"><?php _e('Login',get_theme_domain() );?></a>
                                    </div>
                                </div>
                            <?php endif; //endif ?>
                            <?php
                            /*
                            <div class="col">
                                <div class="form-group">
                                    <p><?php _e('Not a Member? ',get_theme_domain());?></p><a href="javascript:void(0);" class="poptrigger" data-rel="account_registration"><?php _e('Register Here',get_theme_domain()); ?></a>
                                </div>
                            </div>
                            */
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Popup End -->

<?php 
$action = !empty($_GET['action']) ? $_GET['action'] : '';
$key = !empty($_GET['key']) ? $_GET['key'] : '';
$login = !empty($_GET['login']) ? $_GET['login'] : '';

if(!empty($action) && !empty($key) && !empty($login) ): ?>
<!-- Reset Password Popup Start -->
<div class="popouterbox account_popups" id="account_rst_pwd">
    <div class="popup-block">
        <div class="pop-contentbox">
            <div class="account-login-block">
                <div class="account-login-block-details">
                    <h2><?php _e('Reset Password', get_theme_domain() ); ?></h2>
                    <form name="resetPassword" id="resetPassword" action="" method="post">
                        <div class="form-group">
                            <label><?php _e('New Password', get_theme_domain() ); ?></label>
                            <input type="password" name="password" id="password" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><?php _e('Confirm New Password', get_theme_domain()); ?></label>
                            <input type="password" name="confirmpassword" id="confirmpassword" value="" class="form-control" required>
                        </div>
                        <input type="hidden" name="userlogin" value="<?php echo $login; ?>" id="userlogin">
                        <input type="hidden" name="useraction" value="<?php echo $action; ?>" id="useraction">
                        <input type="hidden" name="key" value="<?php echo $login; ?>" id="key">
                        <input type="submit" name="submit" value="<?php _e('Reset Password',get_theme_domain() );?>" id="resetPass" class="login-out-btn">
                        <div class="form-group">
                            <p class="status-label"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reset Password Popup End -->
<?php endif; //endif ?>

<?php 
$pool_image_id  = get_option('pool_image'); 
$pool_image = wp_get_attachment_image_src( $pool_image_id,'full');
?>
<?php if(!empty($pool_image) ): ?>
    <!-- Poll image Popup Start -->
    <div class="popouterbox view-pool" id="view-pool">
        <div class="popup-block">
            <div class="pop-contentbox">
                <figure>
                    <img src="<?php echo $pool_image[0]; ?>" alt="View Pool">
                </figure>
            </div>
        </div>
    </div>
    <!-- Poll image Popup End -->
<?php endif; //endif ?>

<?php if (is_user_logged_in() ): ?>
    <?php global $current_user; ?>
    <?php 
    $get_book_ID = '';
    $get_book_ID = !empty($_GET['book']) ? $_GET['book'] : '';
    
    $user_zone = '';
    $user_people = '';
    $user_book_date = '';
    $user_slottime = '';
    
    if(!empty($get_book_ID) ){
        $user_zone   = get_post_meta( $get_book_ID, '_zone',true);
        $user_people = get_post_meta( $get_book_ID, '_people',true);
        $user_book_date = get_post_meta( $get_book_ID, '_bookdate',true);
        $user_slottime  = get_post_meta( $get_book_ID, '_slottime',true);
    }
    ?>
    <div class="popouterbox account_popups confirmation-popup" id="confirmation-window">
        <div class="popup-block">
            <div class="pop-contentbox">
                <div class="account-login-block">
                    <div class="account-login-block-details">
                        <h2><?php _e('Confirm Reservation',get_theme_domain() ); ?></h2>
                        <form name="confirmation_reservation" id="confirmation_reservation" action="" method="post">
                            <div class="confirmation-box">
                                <div class="confirm-booking-info">
                                    <div class="confirm-booking-box">
                                        <span><?php _e('Date',get_theme_domain() );?></span>
                                        <h5 class="get_date"><?php echo $user_book_date; ?></h5>
                                    </div>
                                    <div class="confirm-booking-box">
                                        <span><?php _e('Time Slot',get_theme_domain() );?></span>
                                        <h5 class="get_time"><?php echo $user_slottime; ?></h5>
                                    </div>
                                </div>
                                <div class="confirm-booking-info">
                                    <div class="confirm-booking-box">
                                        <span><?php _e('No. of People',get_theme_domain() );?></span>
                                        <h5 class="get_people"><?php echo $user_people; ?></h5>
                                    </div>
                                    <div class="confirm-booking-box">
                                        <span><?php _e('Zone',get_theme_domain() );?></span>
                                        <h5 class="get_zone"><?php echo $user_zone; ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-section">
                                <div class="hide">
                                    <input type="hidden" name="user" value="<?php echo $current_user->ID; ?>" id="user" required>
                                    <input type="hidden" name="zone" value="<?php echo $user_zone; ?>" id="zone" required>
                                    <input type="hidden" name="people" value="<?php echo $user_people; ?>" id="people" required>
                                    <input type="hidden" name="book_date" value="<?php echo $user_book_date; ?>" id="book_date" required>
                                    <input type="hidden" name="slottime" value="<?php echo $user_slottime; ?>" id="slottime" required>
                                    <input type="hidden" name="book" value="<?php echo $get_book_ID; ?>" id="book_id" required>
                                    <input type="hidden" name="weak_s_date" value="" id="weak_s_date" required>
                                    <input type="hidden" name="weak_e_date" value="" id="weak_e_date" required>
                                </div>
                                <input type="submit" name="submit" value="<?php _e('Confirm',get_theme_domain() );?>" id="reservation_confrim" class="btn2">
                                <a href="javascript:void(0);" class="btn2 btn-outline close-dialog"><?php _e('Cancel',get_theme_domain() );?></a>
                            </div>
                            <div class="form-group">
                                <p class="status-msg" id="booking-label"></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; //endif ?>
    
<?php if( is_user_logged_in() ): ?>
    <div class="popouterbox account_popups confirmation-popup" id="cancel-reservation">
        <div class="popup-block">
            <div class="pop-contentbox">
                <div class="account-login-block">
                    <div class="account-login-block-details cancel-reservation">
                        <h2><?php _e('Cancel Reservation',get_theme_domain() );?></h2>
                        <p><?php _e('Are you sure you want to cancel this reservation?',get_theme_domain() );?></p>
                        <div class="btn-section">
                            <div class="hide">
                                <input type="hidden" name="booking" value="" id="booking" required>
                            </div>
                            <a href="javascript:void(0);" class="btn2 close-dialog"><?php _e('No',get_theme_domain() );?></a>
                            <a href="javascript:void(0);" id="cancel_booking" class="btn2 btn-outline"><?php _e('Yes',get_theme_domain() );?></a>
                        </div>
                        <div class="form-group">
                            <p class="status-msg" id="message-label"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; //endif ?>

<?php endif; //Endif ?>
<?php wp_footer(); ?>
</body>
</html>