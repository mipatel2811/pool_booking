<?php
if (! is_user_logged_in() ) {
    echo '<script> var home_url = document.querySelector("#site-logo a").href;window.location.href = home_url;</script>';
    exit; 
} 

global $current_user; 
$user = get_user_meta($current_user->ID);

$role = $current_user->roles[0];


$dues = get_user_meta($current_user->ID,'annual_dues',true);

$member_Id = $user['member_ID'][0];

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
        $members_ID = $user_data->ID;
        $member_role = $user_data->roles[0];
        
        if($member_role == 'pool_member'){
            $member_dues = get_user_meta($members_ID,'annual_dues',true);
        }        
    }
endif;


$dues_status_label = get_field('dues_status_label','option');
$coming_soon_label = get_field('coming_soon_label','option');
$registration_label = get_field('registration_label','option');
$maintanance_label = get_field('maintanance_label','option');
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
                        <li class="active">
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
                        <li>
                            <a href="<?php echo home_url('/change-password/'); ?>"><?php _e('Change Password',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout',get_theme_domain()); ?></a>
                        </li>
                    </ul>
                </div>
                <?php 
                $slot =  get_option('slot');
                $zone =  get_option('zone');
                $max_person =  get_option('max_number_of_person');
                ?>
                <?php if( $role == 'pool_member' || $role == 'household_member' || $role == 'administrator'): ?>
                    <?php if($member_dues == 'Due'): ?>
                        <div class="dashboard-contain no-border">
                            <div class="tab-pane">
                                <div class="tab-details">
                                    <div class="no-current-reservations">
                                        <figure>
                                            <img src="<?php echo get_theme_file_uri('/images/frame.png'); ?>" alt="no current reservations">
                                        </figure>
                                        <?php if(!empty($dues_status_label) ): ?>
                                            <h2><?php echo $dues_status_label; ?></h2>
                                        <?php endif; //endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                    <?php 
                        //temp hide for members
                        $hide = 1;
                        
                        
                        if($role == 'administrator'){
                           $hide = 1;
                        }  
                        if($user_ID == 37 || $user_ID == 30 || $user_ID == 31 || $user_ID == 36 || $user_ID == 32 || $user_ID == 33 || $user_ID == 34 || $user_ID == 35 || $user_ID == 58 || $user_ID == 38 ){
                            $hide = 1;
                        }
                        if(get_option('pool_maintanance') == 'yes'){
                            $hide = 3;
                        }
                        if($user_ID == 56){
                              $hide = 1;
                        }
                    ?>
                    <?php if($hide == 1): ?>
                        <?php if(!empty($slot) && !empty($zone) && !empty($max_person) ): ?>
                            <?php
                            $p_heading = get_field('pool_heading');
                            $sub_heading = get_field('sub_heading');
                            ?>
                            <div class="dashboard-contain">
                                <div class="tab-pane">
                                    <div class="tab-details">
                                        <div class="title-box">
                                            <?php if(!empty($p_heading) ): ?>
                                                <h2><?php echo $p_heading; ?></h2>
                                            <?php endif; //endif ?>
                                            <?php if(!empty($sub_heading) ): ?>
                                                <p><?php echo $sub_heading; ?></p>
                                            <?php endif; //endif ?>
                                            
                                            <p><?php the_content(); ?></p>
                                           
                                        </div>
                                        <?php
                                        $get_book_ID = !empty($_GET['book']) ? $_GET['book'] : '';
                                        if(!empty($get_book_ID) ){
                                            $user_zone = get_post_meta( $get_book_ID, '_zone',true);
                                            $user_people = get_post_meta( $get_book_ID, '_people',true);
                                            $user_book_date = get_post_meta( $get_book_ID, '_bookdate',true);
                                            $user_slottime = get_post_meta( $get_book_ID, '_slottime',true);
                                            
                                            if (session_status() == PHP_SESSION_NONE) {
                                                session_start();
                                            }
                                            $_SESSION['book_date'] = $user_book_date;
                                        }
                                        ?>
                                        <div class="booking-info">
                                            <div class="row">
                                                <form class="" id="pool_booking" name="pool_booking">
                                                    <div class="col-md-4">
                                                        <div class="choose-date">
                                                            <label><?php _e('Select Date',get_theme_domain()); ?></label>
                                                            <div class="input-group date">
                                                                <input type="text" placeholder="Select Date" name="startdate" value="<?php echo $user_book_date; ?>" class="form-control date" id="startdate" readonly>
                                                                <span class="input-group-addon">
                                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label><?php _e('Select Time Slot',get_theme_domain()); ?></label>
                                                            <?php if(!empty($slot) ): ?>
                                                                <div class="custom-select">
                                                                    <select id="time_slot" name="time_slot" placeholder="Select Time Slot">
                                                                        <option value=""><?php _e('Select Time Slot',get_theme_domain()); ?></option>
                                                                        <?php foreach ($slot as $time):
                                                                            $start_hour = $time['start_hour'];
                                                                            $start_min = $time['start_min'];
                                                                            $start_time = $time['start_time'];
                                                                            $end_hour = $time['end_hour'];
                                                                            $end_min = $time['end_min'];
                                                                            $end_time = $time['end_time'];

                                                                            $slot =$start_hour.':'.$start_min." ".$start_time ." - ".$end_hour.":".$end_min." ".$end_time;
                                                                            
                                                                            $display = "";
                                                                            
                                                                            if($start_time == "PM"){
                                                                                if($start_hour != 12){
                                                                                   $display =  $start_hour + 12;
                                                                                }else{
                                                                                   $display =  $start_hour; 
                                                                                }
                                                                            }else{
                                                                                 $display =  $start_hour; 
                                                                            }
                                                                            ?>
                                                                            <option <?php selected( $user_slottime, $slot ); ?> value="<?php echo $slot; ?>" data-start="<?php echo $display; ?>"><?php echo $slot; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            <?php endif; //endif ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label><?php _e('No. of People',get_theme_domain()); ?></label>
                                                            <div class="custom-select">
                                                                <select id="total_people" name="total_people" placeholder="select No People">
                                                                    <option value=""><?php _e('Select No. of People',get_theme_domain() ); ?></option>
                                                                    <?php for ($count=1; $count<=$max_person; $count++): ?>
                                                                        <option <?php selected( $user_people, $count ); ?> value="<?php echo $count; ?>"><?php echo $count; ?></option>
                                                                    <?php endfor; //end of for loop ?>
                                                                </select>              
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="select-zone-box">
                                            <div class="select-zone-heading">
                                                <?php if(!empty($get_book_ID) ): ?>
                                                    <h2><?php _e('Edit a Zone',get_theme_domain()); ?></h2>
                                                <?php else: ?>
                                                    <h2><?php _e('Select a Zone',get_theme_domain()); ?></h2>
                                                <?php endif; //endif ?>
                                                <a href="javascript:void(0);" class="poptrigger view-pool-btn" data-rel="view-pool">
                                                    <img src="<?php echo get_theme_file_uri('/images/map-icon.png'); ?>" alt="pool"><?php _e('View Pool',get_theme_domain()); ?> 
                                                </a>
                                                <?php $pool_pdf = get_option('pool_pdf'); ?>
                                                <?php if(!empty($pool_pdf)): ?>
                                                    <a href="<?php echo $pool_pdf;?>" target="_blank" class="view-pool-btn pdf-btn">
                                                        <?php _e('Download PDF',get_theme_domain()); ?> 
                                                    </a>
                                                <?php endif; //endif ?>
                                            </div>
                                            <?php if(!empty($zone) ): ?>
                                                <div class="zone-boxes">
                                                    <div class="overlay-box"></div>
                                                    <?php foreach ($zone as $single_zone): ?>
                                                        <?php 
                                                            $zone_name = $single_zone['zone_name'];
                                                            $setting_capacity = $single_zone['setting_capacity'];
                                                            $zone_status = $single_zone['zone_status'];
                                                            if(!empty($setting_capacity) ):
                                                                switch ($setting_capacity){
                                                                    case 2:
                                                                       $image_ID = get_option('2_seat');
                                                                       break;
                                                                    case 3:
                                                                        $image_ID = get_option('3_seat');
                                                                        break;
                                                                    case 4:
                                                                        $image_ID = get_option('4_seat');
                                                                        break;
                                                                    case 5:
                                                                        $image_ID = get_option('5_seat');
                                                                        break;
                                                                    case 6:
                                                                        $image_ID = get_option('6_seat');
                                                                        break;
                                                                    default:
                                                                        $image_ID = '';
                                                                }
                                                            endif; //endif
                                                        ?>
                                                        <?php if($zone_status == 'active'): ?>
                                                            <?php 
                                                                $class = '';
                                                                if($user_zone == $zone_name){
                                                                    $class ='select';
                                                                }
                                                            ?>
                                                            <div class="zone-box <?php echo $class;?>">
                                                                <?php if(!empty($zone_name) ): ?>
                                                                    <span class="series"><?php echo $zone_name; ?></span>
                                                                <?php endif; //endif ?>
                                                                <?php if(!empty($image_ID) ):
                                                                    $image = wp_get_attachment_image_src( $image_ID,'full'); ?>    
                                                                    <img src="<?php echo $image[0]; ?>" alt="<?php echo $zone_name; ?>">
                                                                <?php endif; //endif ?>
                                                            </div>
                                                        <?php endif; //endif ?>
                                                    <?php endforeach; // ?>
                                                </div>
                                            <?php endif; //endif ?>
                                            <a href="javascript:void(0);" class="btn btn-lg confirmation" data-rel="confirmation-window"><?php _e('Make Reservation',get_theme_domain()); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; //endif ?>
                        <?php else: //temp hide for memebers ?>
                            
                             <?php if($hide = 3): ?>
                                <div class="dashboard-contain no-border">
                                    <div class="tab-pane">
                                        <div class="tab-details">
                                            <div class="no-current-reservations">
                                                <figure>
                                                    <img src="<?php echo get_theme_file_uri('/images/frame.png'); ?>" alt="no current reservations">
                                                </figure>
                                                <?php if(!empty($maintanance_label) ): ?>
                                                    <h2><?php echo $maintanance_label; ?></h2>
                                                <?php endif; //endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else:  ?>
                                <div class="dashboard-contain no-border">
                                    <div class="tab-pane">
                                        <div class="tab-details">
                                            <div class="no-current-reservations">
                                                <figure>
                                                    <img src="<?php echo get_theme_file_uri('/images/frame.png'); ?>" alt="no current reservations">
                                                </figure>
                                                <?php if(!empty($coming_soon_label) ): ?>
                                                    <h2><?php echo $coming_soon_label; ?></h2>
                                                <?php endif; //endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; //endif ?>
                    <?php endif; //endif ?>
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