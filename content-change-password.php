<?php 
if (! is_user_logged_in() ) {
    echo '<script> var home_url = document.querySelector("#site-logo a").href;window.location.href = home_url;</script>';
    exit; 
} 
global $current_user; 
$user = get_user_meta($current_user->ID);
$role = $current_user->roles[0];
    
    $error = "";
    $success ="";
	if($_REQUEST) {
		if(isset($_REQUEST['old_password']) != "" && isset($_REQUEST['new_password']) != "" && isset($_REQUEST['confirm_password']) != "") {
			if($_REQUEST['new_password'] == $_REQUEST['confirm_password']) {
				$password = esc_sql($_REQUEST['new_password']);
				if(wp_check_password($_REQUEST['old_password'], $current_user->user_pass, $current_user->ID)) {
					wp_set_password( $password, $current_user->ID);
                   
					$success = "Password Changed Successfully, Please login again to continue!";
				} else {
					$error = "Wrong Old Password";
				}
			} else {
				$error = "Mismatch Confirm Password";
			}
		} else {
			$error = "All fields are required";
		}
	}
?>
<div class="">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="tabs-content-box">
                <div class="my-account-sidebar"> 
                    <div class="profile-info">
                        <div class="profile-pic">
                            <figure>
                                <img src="<?php echo get_theme_file_uri('/images/profile-pic.png');  ?>" class="img-responsive" alt="<?php echo $current_user->display_name; ?>">
                            </figure>
                        </div>
                        <?php 
                        $member_Id = $user['member_ID'][0];
                        $first_name = $current_user->first_name;
                        $last_name = $current_user->last_name;
                        ?>
                        <div class="profile-name">
                            <h2><?php echo $first_name." ".$last_name; ?></h2>
                            <?php if(!empty($member_Id) ): ?>
                                <p><?php echo "Member ID - ".$member_Id; ?></p>
                            <?php endif; //endif ?>
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li>
                            <a href="<?php echo home_url('/pool-reservation/'); ?>"><?php _e('Pool Reservations',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/my-reservations/'); ?>"><?php _e('My Reservations ',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/request-to-ippa/'); ?>"><?php _e('Request to IPPA',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/my-profile/'); ?>"><?php _e('My Profile',get_theme_domain()); ?></a>
                        </li>
                        <li class="active">
                            <a href="<?php echo home_url('/change-password/'); ?>"><?php _e('Change Password',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout',get_theme_domain()); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="dashboard-contain">
                     <div class="tab-pane change-password">
                        <div class="tab-details">
                            <div class="title-box">
                                <h2><?php echo get_the_title(); ?></h2>
                            </div>
                            <div class="row">
                                <div class="col-md-7 col-sm-12">
                                    <form id="change-password-form" name="changepassword" action="" method="post">
                                        <div class="form-group">
                                            <label><?php _e('Old Password',get_theme_domain() );?></label>
                                            <input type="password" class="form-control" name="old_password" required>
                                        </div>
                                        <div class="form-group">
                                            <label><?php _e('New Password',get_theme_domain() );?></label>
                                            <input type="password" class="form-control"id="new_password" name="new_password" required>
                                        </div>
                                        <div class="form-group">
                                            <label><?php _e('Confirm New Password',get_theme_domain() );?></label>
                                            <input type="password" class="form-control" name="confirm_password" required>
                                        </div>
                                        <div class="row align-items-center justify-center">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <a href="javascript:void(0);" class="poptrigger forgot-password" data-rel="account_frg_pwd"><?php _e('Forgot Password?',get_theme_domain() );?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center justify-center">
                                            <div class="col-md-12 col-sm-6">
                                                <?php if ($success) : ?>
                                                    <p style="color: rgb(0,128,0);">
                                                        <?php echo $success; ?>	
                                                    </p>
                                                <?php elseif ($error) : ?>
                                                    <p style="color: rgb(255, 51, 51);">
                                                        <?php echo $error; ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn2"><?php _e('Change Password?',get_theme_domain() );?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>