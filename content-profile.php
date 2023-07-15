<?php 
    if (! is_user_logged_in() ) {    
        echo '<script> var home_url = document.querySelector("#site-logo a").href;window.location.href = home_url;</script>';
        exit;
    } 
    
    global $current_user; 
    $user = get_user_meta($current_user->ID);

    $current_user_role = $current_user->roles;
    $household_members = array();
    if(sizeof($current_user_role) > 0 && $current_user_role[0] == "pool_member"):  
        $household_query = new WP_User_Query( array( 'meta_key' => 'pool_member', 'meta_value' => $current_user->ID ) );
        $household_members = $household_query->get_results();
    endif;

    $extra_div = 0;
    if(sizeof($current_user_role) > 0 && $current_user_role[0] == "pool_member" && sizeof($household_members) > 0){
        $extra_div = 1;
    }

    if(sizeof($current_user_role) > 0 && $current_user_role[0] == "household_member"){
        $extra_div = 1;
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
                            <li class="active">
                                <a href="<?php echo home_url('/my-profile/'); ?>"><?php _e('My Profile',get_theme_domain()); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo home_url('/'); ?>change-password/"><?php _e('Change Password','wp-fanzone'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout',get_theme_domain()); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="dashboard-contain"> 
                            <div class="tab-pane">
                                <div class="tab-details">
                                    <div class="profile-box myprofile">
                                        <div class="title-box">
                                            <h2><?php _e('My Profile','wp-fanzone'); ?></h2>
                                            <p><?php _e('Member ID','wp-fanzone'); ?><span><?php echo $user['member_ID'][0]; ?></span></p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="confirm-booking-box">
                                                    <span><?php _e('First Name','wp-fanzone'); ?></span>
                                                    <h5><?php echo $user['first_name'][0]; ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="confirm-booking-box">
                                                <span><?php _e('Last Name','wp-fanzone'); ?></span>
                                                <h5><?php echo $user['last_name'][0]; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="confirm-booking-box">
                                                    <span><?php _e('Email','wp-fanzone'); ?></span>
                                                    <h5><?php echo $current_user->user_email; ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="confirm-booking-box">
                                                <span><?php _e('Contact Number','wp-fanzone'); ?></span>
                                                <h5><?php echo $user['contact_number'][0]; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">    
                                            <div class="col-md-6 col-sm-6">
                                                <div class="confirm-booking-box">
                                                    <span><?php _e('Address','wp-fanzone'); ?></span>
                                                    <h5><?php echo $user['address_one'][0]; ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="confirm-booking-box">
                                                <span><?php _e('Address Line 2','wp-fanzone'); ?></span>
                                                <h5><?php echo $user['address_two'][0]; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="confirm-booking-box">
                                                <span><?php _e('City','wp-fanzone'); ?></span>
                                                <h5><?php echo $user['user_city'][0]; ?></h5>
                                                </div>
                                            </div>
                                            <?php $userState = get_user_meta($current_user->ID,"user_state",true); ?>
                                            <?php if(!empty($userState) ): ?>
                                                <?php global $states; ?>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="confirm-booking-box">
                                                    <span><?php _e('State','wp-fanzone'); ?></span>
                                                    <?php foreach ($states as $state): ?>
                                                        <?php
                                                            $state_name = $state['state'];
                                                            $state_id = $state['state_id'];
                                                        ?>
                                                        <?php if($state_name == $userState): ?>
                                                            <h5><?php echo $userState; ?></h5>
                                                        <?php endif; ?>
                                                    <?php endforeach; //end of foreadh loop ?>
                                                    </div>
                                                </div>
                                            <?php endif; //endif ?>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="confirm-booking-box">
                                                <span><?php _e('Zip','wp-fanzone'); ?></span>
                                                <h5><?php echo $user['zip'][0]; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-box membership">
                                        <div class="title-box">
                                            <h2><?php _e('Membership','wp-fanzone'); ?></h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-6">
                                                <div class="confirm-booking-box">
                                                    <span><?php _e('Purchase Date','wp-fanzone'); ?></span>
                                                    <h5><?php echo $user['purchase_date'][0]; ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="confirm-booking-box">
                                                <span><?php _e('Amount','wp-fanzone'); ?></span>
                                                <h5>$<?php echo $user['dues_amount'][0]; ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="confirm-booking-box">
                                                    <span><?php _e('Pool Key','wp-fanzone'); ?></span>
                                                    <h5><?php echo $user['pool_key'][0]; ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="confirm-booking-box">
                                                <span><?php _e('Annual Dues','wp-fanzone'); ?></span>
                                                <h5><?php echo $user['annual_dues'][0]; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($user['annual_dues'][0] == 'Due') : ?>
                                            <p class="note"><?php _e('Please submit a Request to IPPA to resolve dues status','wp-fanzone'); ?> <a href="<?php echo home_url('/'); ?>request-to-ippa/"><?php _e('here','wp-fanzone'); ?></a></p>
                                        <?php endif; ?> 
                                    </div>

                                    <?php if($extra_div == 1) : ?>
                                    <div class="profile-box household-members">
                                        <div class="title-box">
                                            <?php if(sizeof($current_user_role) > 0 && $current_user_role[0] == "pool_member" && sizeof($household_members) > 0):  ?>
                                                <h2>Household Members</h2>
                                            <?php endif;  ?>   
                                            <?php if(sizeof($current_user_role) > 0 && $current_user_role[0] == "household_member"):  ?>
                                                <!-- <h2>Pool Members</h2> -->
                                                <h2>Household Members</h2>
                                                
                                            <?php endif;  ?>   
                                        </div>
                                        

                                            <?php 
                                            
                                                if(sizeof($current_user_role) > 0 && $current_user_role[0] == "pool_member"):  
                                                    if(sizeof($household_members) > 0) : 
                                                        foreach($household_members as $household_member) :

                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="confirm-booking-box">
                                                                <span>Name</span>
                                                                <h5><?php echo $household_member->first_name . ' ' . $household_member->last_name ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="confirm-booking-box">
                                                            <span>Email</span>
                                                            <h5><?php echo $household_member->user_email; ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="confirm-booking-box">
                                                                <span>Contact Number</span>
                                                                <h5><?php echo get_user_meta($household_member->ID,"contact_number",true); ?></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php

                                                        endforeach;
                                                    endif;
                                                ?>
                                                
                                                <?php
                                                else: 
                                                    $pool_member = get_user_meta($current_user->ID,"pool_member",true); 
                                                    $pool_member_data = get_userdata($pool_member);
                                                ?>

                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="confirm-booking-box">
                                                                <span>Name</span>
                                                                <h5><?php echo $pool_member_data->first_name . ' ' . $pool_member_data->last_name ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="confirm-booking-box">
                                                            <span>Email</span>
                                                            <h5><?php echo $pool_member_data->user_email; ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="confirm-booking-box">
                                                                <span>Contact Number</span>
                                                                <h5><?php echo get_user_meta($pool_member_data->ID,"contact_number",true); ?></h5>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php


                                                endif;
                                            ?>
                                    </div>

                                    <?php endif; ?>
                                </div>
                            </div>
                    </div>
            </div>
            </div>
        </div>

    </div>
    