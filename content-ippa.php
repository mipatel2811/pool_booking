<?php 
if (! is_user_logged_in() ) {
    echo '<script> var home_url = document.querySelector("#site-logo a").href;window.location.href = home_url;</script>';
    exit; 
} 
global $current_user; 

$user = get_user_meta($current_user->ID);
$user_ID = $current_user->ID;
$role = $current_user->roles[0];   
$phone = get_user_meta($user_ID,'contact_number',true);

$registration_label = get_field('registration_label','option');
?>
<div class="">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="tabs-content-box"> 
                <div class="my-account-sidebar">
                    <div class="profile-info">
                        <div class="profile-pic">
                            <figure>
                                <img src="<?php echo get_theme_file_uri('/images/profile-pic.png'); ?>" class="img-responsive" alt="<?php echo $current_user->display_name; ?>">
                            </figure>
                        </div>
                        <?php 
                        $member_Id = $user['member_ID'][0];
                        $first_name = $current_user->first_name;
                        $last_name  = $current_user->last_name;
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
                        <li class="active">
                            <a href="<?php echo home_url('/request-to-ippa/'); ?>"><?php _e('Request to IPPA',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/my-profile/'); ?>"><?php _e('My Profile',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/change-password/');?>"><?php _e('Change Password',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout',get_theme_domain());?></a>
                        </li>
                    </ul>
                </div>
                <?php if($role == 'pool_member' || $role == 'household_member' || $role == 'administrator'): ?>
                    <?php 
                    $heading = get_field('iipa_heading');
                    $iipa_sub_text = get_field('iipa_sub_text');
                    $cf7_formcode = get_field('cf7_formcode');
                    ?>
                    <div class="dashboard-contain">
                        <div class="tab-pane request-to-ippa">
                            <div class="tab-details">
                                <div class="title-box">
                                    <?php if(!empty($heading) ): ?>
                                        <h2><?php echo $heading; ?></h2>
                                    <?php endif; //endif ?>
                                    <?php if(!empty($iipa_sub_text) ): ?>
                                        <p><?php echo $iipa_sub_text; ?></p>
                                    <?php endif; //endif ?>
                                </div>
                                <?php if(!empty($cf7_formcode) ): ?>
                                    <div class="row">
                                        <div class="col-md-7 col-sm-12">
                                            <?php echo do_shortcode($cf7_formcode); ?>
                                        </div>
                                    </div>
                                    <div class="hide" id="get_phone"><?php echo $phone;?></div>
                                <?php endif; //endif ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="dashboard-contain no-border">
                        <div class="tab-pane">
                            <div class="tab-details">
                                <div class="no-current-reservations">
                                    <figure>
                                        <img src="<?php echo get_theme_file_uri('/images/frame.png'); ?>" alt="no current reservations">
                                    </figure>
                                    <?php if(!empty($registration_label) ): ?>
                                        <h2><?php echo $registration_label; ?></h2>
                                    <?php endif; //endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; //endif ?>
            </div>
        </div>
    </div>
</div>