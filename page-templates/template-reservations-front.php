<?php /* Template Name: Reservation template Front */ ?>

<?php 
global $post;

get_header();


if(isset($_GET['date']) && $_GET['date'] != ""){
  $today = $_GET['date'];  
}else{
  $today = date("Y-m-d");    
}
$args  = array(
            'post_type' => 'reservation',
            'posts_per_page' => -1,
            'meta_key' => '_zone',
            'orderby' => 'meta_value',
            'order' => 'ACS',
            'meta_query' => array(
                array(
                    'key' => '_bookdate_date',
                    'value' => $today,
                    'compare' => '=',
                )
                )
                
            );
$the_query = new WP_Query( $args );
 
$reservations = array();

$slots_array = array();
$zones_array = array();
$slot =  get_option('slot');
$zones =  get_option('zone');

foreach ($zones as $single_zone):
    
    $zones_array[] = $single_zone['zone_name'];
endforeach; 

foreach ($slot as $time):
    $start_hour = $time['start_hour'];
    $start_min = $time['start_min'];
    $start_time = $time['start_time'];
    $end_hour = $time['end_hour'];
    $end_min = $time['end_min'];
    $end_time = $time['end_time'];

    $slots_array[] = $start_hour.':'.$start_min." ".$start_time ." - ".$end_hour.":".$end_min." ".$end_time;
endforeach;  



// The Loop
$count = 0;
$present_array = array();

if ( $the_query->have_posts() ) {
    
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
       
        $reservation_id = get_the_ID();
        $book_status = get_post_status(get_the_ID() );
        if($book_status == 'present'){
            $present_array[] = get_the_ID();
        }

        $slot = get_post_meta(get_the_ID(), '_slottime', true);
        
        $index = array_search($slot,$slots_array,true);
        $reservations[$index]['index'] = $index;
        $reservations[$index]['bookings'][] =  $reservation_id;
        $count++;
    }
} else {
    // no posts found
}

$total_present = 0;
if(!empty($present_array) ){
    $total_present = count($present_array);
}



array_multisort(array_map(function($element) {
    return $element['index'];
}, $reservations), SORT_ASC, $reservations);


for($i=0;$i<sizeof($reservations);$i++){
    $temp_array = array();
    for($k=sizeof($reservations[$i]['bookings'])-1; $k >= 0; $k--){ 
    	$temp_array[] = $reservations[$i]['bookings'][$k]; 
    } 
    $reservations[$i]['bookings'] = $temp_array;
}

/* Restore original Post Data */
wp_reset_postdata();

?>
<?php  ?>


<div class="site-content pool_reservation_front">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="tabs-content-box">
                <div class="dashboard-contain">
                    <?php if ( ! post_password_required( $post ) ) { ?>
                        <div class="tab-pane">
                            <div class="tab-details">
                                <div class="row">
                                    
                                    <div class="col-md-3 date_picker_frontend">
                                        <label>Pick a Date</label>
                                        <div class="input-group">
                                            <input type="text" placeholder="Select Date" value="<?php echo $today; ?>" class="form-control reservation_date_picker" readonly>
                                        </div>
                                    </div>
                                </div>
                                 
                                <div class="page-title-box">
                                    <div class="title-box">
                                        <h2><?php _e("Today's Pool Reservations",get_theme_domain() ); ?></h2>
                                        <p class="sub-status">
                                            <?php echo !empty($count) ? '<span>Total ('.$count.')</span>' : ''; ?>
                                            <?php echo !empty($total_present) ? '<span>Present ('.$total_present.')</span>' : ''; ?>
                                        </p>
                                    </div>
                                    <div class="page-pdf">
                                        <a href="#" class="btn btn-lg printPage"><?php _e("Print",get_theme_domain() ); ?></a>
                                    </div>
                                </div>
                                <div class="reservation-boxes">
                                    <?php 
                                        foreach ($reservations as $single) {
                                           if(isset($single['bookings']) && sizeof($single['bookings']) > 0){
                                               foreach ($single['bookings'] as $single_booking) {
                                                    $post_ID = $single_booking;

                                                    $user = get_post_meta($post_ID, '_user', true);
                                                    $zone = get_post_meta($post_ID, '_zone', true);
                                                    $total_people = get_post_meta($post_ID, '_people', true);
                                                    $book_date = get_post_meta($post_ID, '_bookdate', true);
                                                    $slot = get_post_meta($post_ID, '_slottime', true);
                                                    $user_ip_address = get_post_meta($post_ID, '_userip', true);

                                                    $user_ID = get_post_meta($post_ID, '_user', true);

                                                    $user = get_user_by( 'id', $user_ID );
                                                    if(!empty($user) ){

                                                        $user_fname = $user->first_name;
                                                        $user_lname = $user->last_name;

                                                    }

                                                    $status = get_post_status($post_ID);
                                                ?>
                                                <div class="reservation-box">
                                                    <div class="booked-box">
                                                        <div class="booked-info">
                                                            <span><?php echo "#".$post_ID;?></span>
                                                            <h6><?php echo "Booked On ".get_the_date('D, j F g:i A',$post_ID); ?></h6>
                                                        </div>
                                                    </div>
                                                    <div class="confirm-booking-info">
                                                        <?php if(!empty($user_fname) || !empty($user_lname) ): ?>
                                                            <div class="confirm-booking-box">
                                                                <span><?php _e('Name',get_theme_domain() );?></span>
                                                                <h5><?php echo $user_fname." ".$user_lname; ?></h5>
                                                            </div>
                                                        <?php endif; //endif ?>
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
                                                        <div class="confirm-booking-box">
                                                            <?php if($status == 'present'): ?>
                                                                <span><?php _e('Present',get_theme_domain() );?></span>
                                                            <?php endif; //endif ?>
                                                            <?php if($status != 'present'): ?>
                                                                <div><a href="javascript:void(0);" class="btn btn-lg present-action present_confirmation" data-booking="<?php echo $post_ID; ?>" data-rel="present_confirmation"><?php _e('Yes',get_theme_domain()); ?></a></div>
                                                            <?php endif; //endif ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                               }
                                           }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php 
                    }else {    
                        echo get_the_password_form();    
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php get_footer(); ?>