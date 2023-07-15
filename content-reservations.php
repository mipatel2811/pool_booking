<?php 
if (! is_user_logged_in() ) {
    echo '<script> var home_url = document.querySelector("#site-logo a").href;window.location.href = home_url;</script>';
    exit; 
}

global $current_user; 
$user = get_user_meta($current_user->ID);
$user_ID = $current_user->ID;
$role = $current_user->roles[0];

$member_ID = get_user_meta( $user_ID, 'member_ID',true );

$dues_status_label = get_field('dues_status_label','option');
$coming_soon_label = get_field('coming_soon_label','option');
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
                        <li class="active">
                            <a href="<?php echo home_url('/my-reservations/'); ?>"><?php _e('My Reservations ',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/request-to-ippa/'); ?>"><?php _e('Request to IPPA',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/my-profile/'); ?>"><?php _e('My Profile',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/change-password/');?>"><?php _e('Change Password',get_theme_domain()); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout',get_theme_domain()); ?></a>
                        </li> 
                    </ul>
                </div>
                <?php 
                    //temp hide for members
                    $hide = 1;
                    if($role == 'administrator'){
                        $hide = 1;
                    }
                    if($user_ID == 37 || $user_ID == 30 || $user_ID == 31 || $user_ID == 36 || $user_ID == 32 || $user_ID == 33 || $user_ID == 34 || $user_ID == 35 || $user_ID == 58 || $user_ID == 38 ){
                        $hide = 1;
                    }
                ?>
                <?php if($hide == 1): ?>
                    <?php if( $role == 'pool_member' || $role == 'household_member' || $role == 'administrator'): ?>
                        <?php
                        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                        $par_page = get_option('posts_per_page') ? get_option('posts_per_page') : 10;
                        
                        if($member_ID != ""){
                            $get_members = get_users(array(
                                    'meta_key' => 'member_ID',
                                    'meta_value' => $member_ID
                                ));    
                        }else{
                            $get_members = array();
                        }
                        
                        $members = array($user_ID);
                        foreach($get_members as $single_member){
                            $members[] = $single_member->ID;
                        }
                        
                        
                        
                        $args = array('posts_per_page'=>-1, 'post_type'=>'reservation','post_status'=>'publish','meta_key'=>'_bookdate_date','orderby' => 'meta_value','order' => 'ASC','paged'=>$paged,
                                    'meta_query' => array( 
                                        array( 'key' => '_user','value' => $members,'compare' => 'IN' )
                                    )
                                );
                        $reservations = new WP_Query($args);
                        ?>
                        <?php if($reservations->have_posts() ): ?>
                            <?php 
                            $heading = get_field('res_heading');
                            $sub_heading_2 = get_field('ub_heading_2');
                            
                            ?>
                            <div class="dashboard-contain">
                                <div class="tab-pane">
                                    <div class="tab-details">
                                        <?php if(!empty($heading) ): ?>
                                            <div class="title-box">
                                                <h2><?php echo $heading; ?></h2>
                                            </div>
                                        <?php endif; //endif ?>
                                        <?php
                                        if( !empty($_SESSION['success_msg']) && isset($_SESSION['success_msg'] ) ):
                                            echo '<div class="row">';
                                                echo '<div class="col-xs-12 col-md-12">';
                                                    echo '<p class="alert alert-success">'.$_SESSION['success_msg'].'</p>';
                                                echo '</div>';
                                            echo '</div>';
                                            unset($_SESSION['success_msg']);   
                                        endif; //endif

                                        if( !empty($_SESSION['pool_cancel']) && isset($_SESSION['pool_cancel'] ) ):
                                            echo '<div class="row">';
                                                echo '<div class="col-xs-12 col-md-12">';
                                                    echo '<p class="alert alert-success">'.$_SESSION['pool_cancel'].'</p>';
                                                echo '</div>';
                                            echo '</div>';
                                            unset($_SESSION['pool_cancel']);   
                                        endif; //endif
                                        ?>
                                        <?php if(!empty($sub_heading_2) ): ?>
                                            <div class="row-title">
                                                <h3><?php echo $sub_heading_2; ?></h3>
                                            </div>
                                        <?php endif; //endif ?>
                                        <div class="reservation-boxes">
                                            <?php while( $reservations->have_posts() ) : $reservations->the_post(); //loop start ?>
                                                <?php 
                                                $post_ID = get_the_ID();
                                                $user = get_post_meta($post_ID, '_user', true);
                                                $zone = get_post_meta($post_ID, '_zone', true);
                                                $total_people = get_post_meta($post_ID, '_people', true);
                                                $book_date = get_post_meta($post_ID, '_bookdate', true);
                                                $slot = get_post_meta($post_ID, '_slottime', true);
                                                $user_ip_address = get_post_meta($post_ID, '_userip', true);
                                                
                                                $date_now = date("Y-m-d");
                                                $reservation_date = get_post_meta($post_ID, '_bookdate_date', true);
                                                if($reservation_date >= $date_now):

                                                ?>
                                                <div class="reservation-box">
                                                    <div class="booked-box">
                                                        <div class="booked-info">
                                                            <span><?php echo "#".$post_ID;?></span>
                                                            <h6><?php echo "Reserved on ".get_the_date('D, j F g:i A',$post_ID); ?></h6>
                                                        </div>
                                                        <div class="modify-booking">
                                                            <a href="javascript:void(0);" class="modify-toggle">
                                                                <span></span>
                                                            </a>
                                                            <?php 
                                                            $pool_url = get_permalink(976);
                                                            $pool_url = add_query_arg( 'book', $post_ID, $pool_url );
                                                            ?>
                                                            <div class="modify-box">
                                                                <a title="Modify" href="<?php echo $pool_url; ?>"><?php _e('Modify',get_theme_domain() );?></a>
                                                                <a title="Cancel" class="poptrigger booking-cancel" data-id="<?php echo $post_ID;?>" data-rel="cancel-reservation" href="javascript:void(0);"><?php _e('Cancel',get_theme_domain() );?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="confirm-booking-info">
                                                        <?php if(!empty($book_date) ): ?>
                                                            <div class="confirm-booking-box">
                                                                <span><?php _e('Date',get_theme_domain() );?></span>
                                                                <h5><?php echo $book_date; ?></h5>
                                                            </div>
                                                        <?php endif; //endif ?>
                                                        <?php if(!empty($slot) ): ?>
                                                            <div class="confirm-booking-box">
                                                                <span><?php _e('Time Slot',get_theme_domain() );?></span>
                                                                <h5><?php echo $slot; ?></h5>
                                                            </div>
                                                        <?php endif; //endif ?>
                                                        <?php if(!empty($total_people) ): ?>
                                                            <div class="confirm-booking-box">
                                                                <span><?php _e('No. of People',get_theme_domain() );?></span>
                                                                <h5><?php echo $total_people; ?></h5>
                                                            </div>
                                                        <?php endif; //endif ?>
                                                        <?php if(!empty($zone) ): ?>
                                                            <div class="confirm-booking-box">
                                                                <span><?php _e('Zone',get_theme_domain() );?></span>
                                                                <h5><?php echo $zone;?></h5>
                                                            </div>
                                                        <?php endif; //endif ?>
                                                    </div>
                                                </div>
                                                
                                            <?php endif; ?>
                                            <?php endwhile; //end of while ?>
                                            <?php $total_pages = $reservations->max_num_pages; ?>
                                            <?php if ($total_pages > 1): ?>
                                                <div class="pagination-box">
                                                <?php
                                                    global $wp_query;
                                                    $big = 999999999; // need an unlikely integer
                                                    $pagination = paginate_links(array(
                                                            'base'     => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                                            'format'    => '?paged=%#%',
                                                            'current'   => max( 1, get_query_var('paged') ),
                                                            'total'     => $reservations->max_num_pages,
                                                            'prev_text' => __('Previous',get_theme_domain() ),
                                                            'next_text' => __('Next',get_theme_domain() ),
                                                            'prev_next' => true,
                                                            'show_all'  => true,
                                                            'type'      => 'array',
                                                        )   );
                                                    ?>
                                                    <?php if(!empty($pagination) && isset($pagination) ): ?>
                                                        <ul class="pagination">
                                                            <?php foreach ( $pagination as $key => $page_link ): ?>
                                                                <li <?php if ( strpos( $page_link, 'current' ) !== false ) { echo 'class="active"'; } ?>><?php echo $page_link; ?></li>
                                                            <?php endforeach; //end of loop ?>
                                                        </ul>
                                                    <?php endif; //endif ?>
                                                </div>
                                            <?php endif; //endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: //temp hide for memebers ?>
                            <div class="dashboard-contain no-border">
                                <div class="tab-pane">
                                    <div class="tab-details">
                                        <div class="no-current-reservations">
                                            <figure>
                                                <img src="<?php echo get_theme_file_uri('/images/frame.png') ?>" alt="no current reservations">
                                            </figure>
                                            <h2><?php _e('You have no current reservations.',get_theme_domain() ); ?></h2>
                                            <a href="<?php echo get_permalink(976); ?>" class="btn btn2"><?php _e('Pool Reservations',get_theme_domain() ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; //endif ?>
                        <?php wp_reset_postdata(); //Reset WP Post data ?>
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
                <?php else: ?>
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
                <?php endif; //endif ?> 
            </div>
        </div>
    </div>
</div>