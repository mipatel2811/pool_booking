<?php 

function pool_settings_menu() {
    add_menu_page(
        __( 'Pool Options', get_theme_domain() ),
        __( 'Pool Options', get_theme_domain() ),
        'manage_options',
        'pool-page',
        'wp_funzone_admin_page_contents',
        'dashicons-schedule',
        3
    );
}
add_action( 'admin_menu', 'pool_settings_menu' );

session_start();
function js_str($s){
    return '"' . addcslashes($s, "\0..\37\"\\") . '"';
}

function js_array($array){
    $temp = array_map('js_str', $array);
    return '[' . implode(',', $temp) . ']';
}

function wp_funzone_admin_page_contents() {
    
    $pool_holidays = get_option('holidays');
    
    $holidays = array();
    if(!empty($pool_holidays[0]) ){
        $holidays = explode(",",$pool_holidays[0]);
    }
    
    echo '<script>var holidays =undefined;</script>';
    if(!empty($holidays) ){
        echo '<script>var holidays = ', js_array($holidays), ';</script>';
    }
    ?>
    <h1> <?php esc_html_e( 'Pool options.', 'my-plugin-textdomain' ); ?> </h1>

    <?php if($_SESSION['flag'] == "success") : ?>
        <?php $_SESSION['flag'] = ""; ?>
        <div id="message" class="updated notice">
            <p><strong><?php echo $_SESSION['message']; ?></strong></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
    <?php endif; ?>

    <?php if($_SESSION['flag'] == "error") : ?>
        <?php $_SESSION['flag'] = ""; ?>
        <div class="error">
            <p><strong>Error</strong>: <?php echo $_SESSION['message']; ?></p>	
        </div>
    <?php endif; //endif ?>

    
    <form method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>" class="pool_setting_form" id="pool_settings">
        <input type="hidden" name="action" value="save_pool_settings">
        <div class="section">
            
            <h3><?php _e('Number of person options',get_theme_domain() ); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="max_number_of_person"><?php _e('Max number of person to book',get_theme_domain() ); ?></label></th>
                    <td><input type="number" id="max_number_of_person" min="1" step="1" name="max_number_of_person" value="<?php echo get_option('max_number_of_person'); ?>"></td>
                </tr>
            </table>
            
            <h3><?php _e('Pool image options',get_theme_domain() ); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label><?php _e('Pool full image',get_theme_domain() ); ?></label></th>
                    <td>
                        <?php $pool_image_id  = get_option('pool_image');
                            if( $pool = wp_get_attachment_image_src( $pool_image_id ) ) {
                                echo '<a href="#" class="misha-upl"><img src="' . $pool[0] . '" /></a>
                                      <a href="#" class="misha-rmv">Remove image</a>
                                      <input type="hidden" name="pool_image" class="image_val" value="' . $pool_image_id . '">';
                                echo '<label>Default image dimension (700*1130)</label>';
                            } else {
                                echo '<a href="#" class="misha-upl">Upload image</a>
                                      <a href="#" class="misha-rmv" style="display:none">Remove image</a>
                                      <input type="hidden" name="pool_image" class="image_val" value="">';
                                echo '<label>Default image dimension (43*57)</label>';
                            }
                        ?>
                    </td>
                </tr>
            </table>
            
            <h3><?php _e('Pool pdf options',get_theme_domain() ); ?></h3>
            <table class="form-table pool-options">
                <tr valign="top">
                    <th scope="row"><label><?php _e('Pool image pdf',get_theme_domain() ); ?></label></th>
                    <td>
                        <?php $pool_pdf = get_option('pool_pdf'); ?>
                        <input type="text" id="pool_pdf" class="form-control text-box" name="pool_pdf" value="<?php echo !empty($pool_pdf) ? $pool_pdf : ''; ?>">
                    </td>
                </tr>
            </table>
            
            <h3><?php _e('Holiday options',get_theme_domain() ); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="max_number_of_person"><?php _e('Pool holidays',get_theme_domain() ); ?></label></th>
                    <td>
                        <div id="mdp-demo"></div>
                        <input type="hidden" name="holidays[]" class="holidays" value="<?php echo $pool_holidays[0]; ?>">
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><label for="pool_maintanance"><?php _e('Pool maintenance',get_theme_domain() ); ?></label></th>
                    <td>
                        <div id="mdp-demo"></div>
                        <select class="form-control" name="pool_maintanance" placeholder="Start Time">
                            <option value="no" <?php if( get_option('pool_maintanance') == 'no' || get_option('pool_maintanance') == "") : echo 'selected'; endif; ?>>No</option>
                            <option value="yes" <?php if( get_option('pool_maintanance') == 'yes') : echo 'selected'; endif; ?>>Yes</option>
                        </select>
                    </td>
                </tr>
            </table>
            
            <h3><?php _e('Pool time options',get_theme_domain() ); ?></h3>
            <table class="form-table">
                <?php $slot =  get_option('slot'); ?>
                <?php if(!empty($slot) ): ?>
                    <?php $loop = 0; ?>
                    <?php foreach ($slot as $single_Slot): ?>
                        <tr valign="top">
                            <th scope="row"><label><?php _e('From',get_theme_domain() ); ?></label></th>
                            <td>
                                <select class="form-control" name="start_pool_time[][]" placeholder="Start Time">
                                <?php for ($i=01; $i<=12; $i++): ?>
                                    <option <?php if( $single_Slot['start_hour'] == $i) : echo 'selected'; endif; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; //end of for loop ?>
                                </select>
                                <select class="form-control" name="start_pool_time_minutes[][]" placeholder="Start time mintes">
                                    <option <?php if( $single_Slot['start_min'] == '00') : echo 'selected'; endif; ?> value="00">00</option>
                                    <option <?php if( $single_Slot['start_min'] == 15) : echo 'selected'; endif; ?> value="15">15</option>
                                    <option <?php if( $single_Slot['start_min'] == 30) : echo 'selected'; endif; ?> value="30">30</option>
                                    <option <?php if( $single_Slot['start_min'] == 45) : echo 'selected'; endif; ?> value="45">45</option>
                                </select>
                                <select class="form-control" name="start_pool_time_ampm[][]" placeholder="AM/PM">
                                    <option <?php if( $single_Slot['start_time'] == 'AM') : echo 'selected'; endif; ?> value="AM">AM</option>
                                    <option <?php if( $single_Slot['start_time'] == 'PM') : echo 'selected'; endif; ?> value="PM">PM</option>
                                </select>
                                <label for=""><?php _e(' To ',get_theme_domain() ); ?></label>
                                <select class="form-control" name="end_pool_time[][]" placeholder="End Time">
                                <?php for ($count=1; $count<=12; $count++): ?>
                                    <option <?php if( $single_Slot['end_hour'] == $count) : echo 'selected'; endif; ?> value="<?php echo $count; ?>"><?php echo $count; ?></option>
                                <?php endfor; //end of for loop ?>
                                </select>
                                <select class="form-control" name="end_pool_time_minutes[][]" placeholder="End time mintes">
                                    <option <?php if( $single_Slot['end_min'] == '00') : echo 'selected'; endif; ?> value="00">00</option>
                                    <option <?php if( $single_Slot['end_min'] == 15) : echo 'selected'; endif; ?> value="15">15</option>
                                    <option <?php if( $single_Slot['end_min'] == 30) : echo 'selected'; endif; ?> value="30">30</option>
                                    <option <?php if( $single_Slot['end_min'] == 45) : echo 'selected'; endif; ?> value="45">45</option>
                                </select>
                                <select class="form-control" name="end_pool_time_ampm[][]" placeholder="AM/PM">
                                    <option <?php if( $single_Slot['end_time'] == 'AM') : echo 'selected'; endif; ?> value="AM">AM</option>
                                    <option <?php if( $single_Slot['end_time'] == 'PM') : echo 'selected'; endif; ?> value="PM">PM</option>
                                </select>
                                <?php if($loop > 0): ?>
                                    <a href='javascript:void(0);' id='remove_field'><?php _e('Remove',get_theme_domain() ); ?></a>
                                <?php endif; //endif ?>
                            </td>
                        </tr>
                    <?php $loop++; ?>
                    <?php endforeach; //end of foreach ?>
                <?php else: ?>
                    <tr valign="top">
                        <th scope="row"><label for=""><?php _e('From',get_theme_domain() ); ?></label></th>
                        <td>
                            <select class="form-control" name="start_pool_time[][]" placeholder="Start Time" >
                            <?php for ($i=01; $i<=12; $i++): ?>
                                <option <?php if( get_option('start_pool_time') == $i ) : echo 'selected'; endif; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; //end of for loop ?>
                            </select>
                            <select class="form-control" name="start_pool_time_minutes[][]" placeholder="Start time mintes">
                                <option <?php if( get_option('start_pool_time_minutes') == '00') : echo 'selected'; endif; ?> value="00">00</option>
                                <option <?php if( get_option('start_pool_time_minutes') == 15) : echo 'selected'; endif; ?> value="15">15</option>
                                <option <?php if( get_option('start_pool_time_minutes') == 30) : echo 'selected'; endif; ?> value="30">30</option>
                                <option <?php if( get_option('start_pool_time_minutes') == 45) : echo 'selected'; endif; ?> value="45">45</option>
                            </select>
                            <select class="form-control" name="start_pool_time_ampm[][]" placeholder="AM/PM">
                                <option <?php if( get_option('start_pool_time_ampm') == 'AM') : echo 'selected'; endif; ?> value="AM">AM</option>
                                <option <?php if( get_option('start_pool_time_ampm') == 'PM') : echo 'selected'; endif; ?> value="PM">PM</option>
                            </select>
                            <label><?php _e('To ',get_theme_domain() ); ?></label>
                            <select class="form-control" name="end_pool_time[][]" placeholder="End Time">
                            <?php for ($count=1; $count<=12; $count++): ?>
                                <option <?php if( get_option('end_pool_time') == $count ) : echo 'selected'; endif; ?> value="<?php echo $count; ?>"><?php echo $count; ?></option>
                            <?php endfor; //end of for loop ?>
                            </select>
                            <select class="form-control" name="end_pool_time_minutes[][]" placeholder="End time mintes">
                                <option <?php if( get_option('end_pool_time_minutes') == '00') : echo 'selected'; endif; ?> value="00">00</option>
                                <option <?php if( get_option('end_pool_time_minutes') == 15) : echo 'selected'; endif; ?> value="15">15</option>
                                <option <?php if( get_option('end_pool_time_minutes') == 30) : echo 'selected'; endif; ?> value="30">30</option>
                                <option <?php if( get_option('end_pool_time_minutes') == 45) : echo 'selected'; endif; ?> value="45">45</option>
                            </select>
                            <select class="form-control" name="end_pool_time_ampm[][]" placeholder="AM/PM">
                                <option <?php if( get_option('end_pool_time_ampm') == 'AM') : echo 'selected'; endif; ?> value="AM">AM</option>
                                <option <?php if( get_option('end_pool_time_ampm') == 'PM') : echo 'selected'; endif; ?> value="PM">PM</option>
                            </select>
                        </td>
                    </tr>
                <?php endif; //endif ?>
                <tr class="new_slot_sec">
                    <th></th>
                    <td rowspan="2" style="text-align:left;"><input type="button" class="button button-primary" value="Add new slot" id="addSlot"></td>
                </tr>
            </table>
            <h3><?php _e('Zone settings options',get_theme_domain() ); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="max_number_of_person"><?php _e('2 seat image',get_theme_domain() ); ?></label></th>
                    <td>
                        <?php $row_2_image_id  = get_option('2_seat');
                            if( $image_1 = wp_get_attachment_image_src( $row_2_image_id ) ) {

                                echo '<a href="#" class="misha-upl"><img src="' . $image_1[0] . '" /></a>
                                      <a href="#" class="misha-rmv">Remove image</a>
                                      <input type="hidden" name="2_row" class="image_val" value="' . $row_2_image_id . '">';
                                    echo '<label>Default image dimension (43*57)</label>';
                            } else {
                                echo '<a href="#" class="misha-upl">Upload image</a>
                                      <a href="#" class="misha-rmv" style="display:none">Remove image</a>
                                        <label>Add Image Size(W x H) (43*57)</label>
                                      <input type="hidden" name="2_row" class="image_val" value="">';
                                echo '<label>Default image dimension (43*57)</label>';
                            }
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="max_number_of_person"><?php _e('3 seat image',get_theme_domain() ); ?></label></th>
                    <td>
                        <?php $row_3_image_id  = get_option('3_seat');
                            if( $image_3 = wp_get_attachment_image_src( $row_3_image_id ) ) {

                                echo '<a href="#" class="misha-upl"><img src="' . $image_3[0] . '" /></a>
                                      <a href="#" class="misha-rmv">Remove image</a>
                                      <input type="hidden" name="3_row" class="image_val" value="' . $row_3_image_id . '">';
                                echo '<label>Default image dimension (66*57)</label>';

                            } else {

                                echo '<a href="#" class="misha-upl">Upload image</a>
                                      <a href="#" class="misha-rmv" style="display:none">Remove image</a>
                                      <input type="hidden" name="3_row" class="image_val" value="">';
                                echo '<labelDefault image dimension (66*57)</label>';
                            }
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="max_number_of_person"><?php _e('4 seat image',get_theme_domain() ); ?></label></th>
                    <td>
                        <?php $row_4_image_id  = get_option('4_seat');
                            if( $image2 = wp_get_attachment_image_src( $row_4_image_id ) ) {

                                echo '<a href="#" class="misha-upl"><img src="' . $image2[0] . '" /></a>
                                      <a href="#" class="misha-rmv">Remove image</a>
                                      <input type="hidden" name="4_row" class="image_val" value="' . $row_4_image_id . '">';
                                echo '<label>Default image dimension (90*57)</label>';

                            } else {

                                echo '<a href="#" class="misha-upl">Upload image</a>
                                      <a href="#" class="misha-rmv" style="display:none">Remove image</a>
                                      <input type="hidden" name="4_row" class="image_val" value="">';
                                echo '<label>Default image dimension (90*57)</label>';
                            }
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="max_number_of_person"><?php _e('5 seat image',get_theme_domain() ); ?></label></th>
                    <td>
                        <?php $row_5_image_id  = get_option('5_seat');
                            if( $image4 = wp_get_attachment_image_src( $row_5_image_id ) ) {

                                echo '<a href="#" class="misha-upl"><img src="' . $image4[0] . '" /></a>
                                      <a href="#" class="misha-rmv">Remove image</a>
                                      <input type="hidden" name="5_row" class="image_val" value="' . $row_5_image_id . '">';
                                echo '<label>Default image dimension (99*57)</label>';

                            } else {

                                echo '<a href="#" class="misha-upl">Upload image</a>
                                      <a href="#" class="misha-rmv" style="display:none">Remove image</a>
                                      <input type="hidden" name="5_row" class="image_val" value="">';
                                echo '<label>Default image dimension (99*57)</label>';
                            }
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="max_number_of_person"><?php _e('6 seat image',get_theme_domain() ); ?></label></th>
                    <td>
                        <?php $row_6_image_id  = get_option('6_seat');
                            if( $image3 = wp_get_attachment_image_src( $row_6_image_id ) ) {

                                echo '<a href="#" class="misha-upl"><img src="' . $image3[0] . '" /></a>
                                      <a href="#" class="misha-rmv">Remove image</a>
                                      <input type="hidden" name="6_row" class="image_val" value="' . $row_6_image_id . '">';
                                echo '<label>Default image dimension (93*57)</label>';

                            } else {

                                echo '<a href="#" class="misha-upl">Upload image</a>
                                      <a href="#" class="misha-rmv" style="display:none">Remove image</a>
                                      <input type="hidden" name="6_row" class="image_val" value="">';
                                echo '<label>Default image dimension (93*57)</label>';
                            }
                        ?>
                    </td>
                </tr>
            </table>
            
            <h3><?php _e('Zone options',get_theme_domain() ); ?></h3>
            <table class="form-table">
                <?php $zone =  get_option('zone'); ?>
                <?php if(!empty($zone) ): ?>
                    <?php $counter = 0; ?>
                    <?php foreach ($zone as $single_zone): ?>
                        <tr valign="top">
                            <th><label><?php _e('Zone details',get_theme_domain() ); ?></label></th>
                            <td>
                                <input class="form-control" type="name" id="zone_name" name="zone_name[][]" placeholder="Zone name" value="<?php echo $single_zone['zone_name']; ?>" />
                                <select class="form-control" id="setting_capacity" name="setting_capacity[][]" placeholder="Setting capacity">
                                    <option <?php if( $single_zone['setting_capacity'] == 2) : echo 'selected'; endif; ?> value="2">2 seat</option>
                                    <option <?php if( $single_zone['setting_capacity'] == 3) : echo 'selected'; endif; ?> value="3">3 seat</option>
                                    <option <?php if( $single_zone['setting_capacity'] == 4) : echo 'selected'; endif; ?> value="4">4 seat</option>
                                    <option <?php if( $single_zone['setting_capacity'] == 5) : echo 'selected'; endif; ?> value="5">5 seat</option>
                                    <option <?php if( $single_zone['setting_capacity'] == 6) : echo 'selected'; endif; ?> value="6">6 seat</option>
                                </select>

                                <select class="form-control" id="zone_status" name="zone_status[][]" placeholder="Zone status">
                                    <option <?php if( $single_zone['zone_status'] == 'active') : echo 'selected'; endif; ?> value="active"><?php _e('Active',get_theme_domain() ); ?></option>
                                    <option <?php if( $single_zone['zone_status'] == 'deactive') : echo 'selected'; endif; ?> value="deactive"><?php _e('Deactive',get_theme_domain() ); ?></option>
                                </select>
                                <?php if($counter > 0): ?>
                                    <a href='javascript:void(0);' id='remove_field'><?php _e('Remove',get_theme_domain() ); ?></a>
                                <?php endif; //endif ?>
                            </td>
                        </tr>
                    <?php $counter++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr valign="top">
                        <th><label><?php _e('Zone details',get_theme_domain() ); ?></label></th>
                        <td>
                            <input class="form-control" type="name" id="zone_name" name="zone_name[][]" placeholder="Zone name" value="" />
                            <select class="form-control" id="setting_capacity" name="setting_capacity[][]" placeholder="Setting capacity">
                                <option value="2"><?php _e('2 seat',get_theme_domain() ); ?></option>
                                <option value="3"><?php _e('3 seat',get_theme_domain() ); ?></option>
                                <option value="4"><?php _e('4 seat',get_theme_domain() ); ?></option>
                                <option value="4"><?php _e('5 seat',get_theme_domain() ); ?></option>
                                <option value="6"><?php _e('6 seat',get_theme_domain() ); ?></option>
                            </select>
                            <select class="form-control" id="zone_status" name="zone_status[][]" placeholder="Zone status">
                                <option value="active"><?php _e('Active',get_theme_domain() ); ?></option>
                                <option value="deactive"><?php _e('Deactive',get_theme_domain() ); ?></option>
                            </select>
                        </td>
                    </tr>
                <?php endif; //endif ?>
                <tr class="new_zone_sec">
                    <th></th>
                    <td rowspan="1"><input type="button" class="button button-primary" value="Add new zone" id="addzone"></td>
                </tr>
            </table>
        </div>
        <?php submit_button( __( 'Update', get_theme_domain()) ); ?>
    </form>
    <?php
}

?>