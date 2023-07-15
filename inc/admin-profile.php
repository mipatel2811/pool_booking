<?php
/**
 * to show admin profile in admin ara 
 *
 * @package WordPress
 * @subpackage WP FanZone
 * @since 1.0
 */
if( !function_exists('fanZone_user_profile_fields') ):
/*
 * to Add custom option in User Profile
 */
function fanZone_admin_profile_fields( $profileuser ) {
    $user_id = null;
    $user_id = $profileuser->ID;
    $due = get_user_meta($user_id,'annual_dues',true);
    $current_user_role = $profileuser->roles;
    $isHousehold_member = "";
    $pool_member = "";
    if(sizeof($current_user_role) > 0 && $current_user_role[0] == "household_member") {
        $isHousehold_member = "yes";
        $pool_member = get_user_meta($user_id,'pool_member',true);
        $pool_member_data = get_userdata($pool_member);
        $pool_member_member_ID = get_user_meta($pool_member,'member_ID',true);
        $pool_member_name = $pool_member_data->display_name." - ".$pool_member_data->user_email." - ".$pool_member_member_ID;
    } 
?>    
    <div class="member_profile_section <?php echo ($isHousehold_member == "yes") ? "ishousehold" : " "; ?>">
        <h2><label for="title"><?php esc_html_e('Profile',get_theme_domain() ); ?></label></h2>
        <table class="form-group form-table" style='text-align:left;'>
            <tr class="household_member <?php echo ($isHousehold_member == "yes") ? " edited" : " hidden"; ?>">
                <th>
                    <label><?php esc_html_e('Pool member',get_theme_domain() ); ?></label> 
                </th>
                <td>
                    <?php if($pool_member != ""): ?>
                        <select class="pool_member" name="pool_member" id="pool_member" style="width:100%">
                            <option value="<?php echo $pool_member; ?>" selected><?php echo $pool_member_name; ?></option>
                        </select> 
                    <?php else: ?>
                        <select class="pool_member" name="pool_member" id="pool_member" style="width:100%">
                        </select> 
                    <?php endif; ?>
                </td>
                <td class="overlay"></td>
            </tr>
            <tr>
                <th><label><?php esc_html_e('Member ID',get_theme_domain() ); ?></label></th>
                <td>
                    <input type="text" name="member_ID" class="form-control regular-text" placeholder="Member ID" value="<?php echo get_user_meta($user_id,'member_ID',true); ?>">
                </td>
                <td class="overlay"></td>
            </tr>
            <tr class="contact_number_tr">
                <th><label><?php esc_html_e('Contact Number',get_theme_domain() ); ?></label></th>
                <td>
                    <input type="text" name="contact_number" class="form-control regular-text contact_number" placeholder="Contact Number" value="<?php echo get_user_meta($user_id,'contact_number',true); ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('Address',get_theme_domain()); ?></label>
                </th>
                <td>
                    <input type="text" name="address_one" class="form-control regular-text" placeholder="Address" value="<?php echo get_user_meta($user_id,'address_one',true); ?>">
                </td>
                <td class="overlay"></td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('Address Line 2',get_theme_domain() ); ?></label>
                </th>
                <td>
                    <input type="text" name="address_two" class="form-control regular-text" placeholder="Address Line 2" value="<?php echo get_user_meta($user_id,'address_two',true); ?>">
                </td>
                <td class="overlay"></td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('City',get_theme_domain() ); ?></label>
                </th>
                <td>
                    <input type="text" name="user_city" class="form-control regular-text" placeholder="City" value="<?php echo get_user_meta($user_id,'user_city',true); ?>">
                </td>
                <td class="overlay"></td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('State',get_theme_domain() ); ?></label>
                </th>
                <td>
                <?php 
                    global $states;
                    if(!empty($states) ) : ?>
                        <select class="form-control" name="user_state" placeholder="States" id="states">
                            <option value=""><?php _e('Select State',get_theme_domain() ); ?></option>
                            <?php foreach ($states as $state): ?>
                                <?php
                                    $state_id =$state['state_id'];
                                    $state_name = $state['state'] ;
                                ?>
                                <option <?php if( get_user_meta($user_id,'user_state',true) == $state_name) : echo 'selected'; endif; ?> value="<?php echo $state_name; ?>"><?php echo $state_name; ?></option>
                            <?php endforeach; //end of foreadh loop ?>
                        </select>
                    <?php endif; //endif ?>
                </td>
                <td class="overlay"></td>
            </tr>
            <tr>
                <th>
                    <label><?php esc_html_e('Zip',get_theme_domain() ); ?></label>
                </th>
                <td>
                    <input type="text" name="zip" class="form-control regular-text" placeholder="Zip" value="<?php echo get_user_meta($user_id,'zip',true); ?>">
                </td>
                <td class="overlay"></td>
            </tr>
            
        </table>
    </div>
    <div class="membership_section <?php echo ($isHousehold_member == "yes") ? "ishousehold" : " "; ?>">
        <h2><label for="title"><?php esc_html_e('Membership Details',get_theme_domain() ); ?></label></h2>
        <table class="form-group form-table" style='text-align:left;'>
            <tr>
                <th><label><?php esc_html_e('Purchase Date',get_theme_domain() ); ?></label></th>
                <td>
                    <input type="text" name="purchase_date" class="form-control regular-text select_date" placeholder="Purchase Date" readonly="" value="<?php echo get_user_meta($user_id,'purchase_date',true); ?>" autocomplete="off">
                </td>
                <td class="overlay"></td>
            </tr>
            <tr>
                <th><label><?php esc_html_e('Amount',get_theme_domain() ); ?></label></th>
                <td>
                    <input type="number" name="dues_amount" class="form-control regular-text" min="1" placeholder="Amount" value="<?php echo get_user_meta($user_id,'dues_amount',true); ?>">
                </td>
                <td class="overlay"></td>
            </tr>
            <tr>
                <th><label><?php esc_html_e('Pool Key',get_theme_domain() ); ?></label></th>
                <td>
                    <input type="text" name="pool_key" class="form-control regular-text" placeholder="Pool Key" value="<?php echo get_user_meta($user_id,'pool_key',true); ?>">
                </td>
                <td class="overlay"></td>
            </tr>
            <tr>
                <th><label><?php esc_html_e('Annual Dues', get_theme_domain() ); ?></label></th>
                <td> 
                    <select name="annual_dues" class="form-control">
                        <option value="" <?php echo ($due == "") ? "selected" : ""; ?>><?php esc_html_e('Select Due',get_theme_domain() ); ?></option>
                        <option value="Due" <?php echo ($due == "Due") ? "selected" : ""; ?>><?php esc_html_e('Due',get_theme_domain() ); ?></option>
                        <option value="Current" <?php echo ($due == "Current") ? "selected" : ""; ?>><?php esc_html_e('Current',get_theme_domain() ); ?></option>
                    </select>
                </td>
                <td class="overlay"></td>
            </tr>
        </table>
    </div>
    <h2><label for="title"><?php esc_html_e('Notes',get_theme_domain() ); ?></label></h2>
    <table class="form-group form-table" style='text-align:left;'>
        <tr>
            <th><label><?php esc_html_e('Notes',get_theme_domain() ); ?></label></th>
            <td>
                <textarea name="user_notes" rows="4" cols="50" style="height:100px" class="form-control"><?php echo get_user_meta($user_id,'user_notes',true); ?></textarea>
            </td>
        </tr>
    </table>
    <?php 
     
     if($user_id != null){
         $current_user_role = $profileuser->roles;
        if(sizeof($current_user_role) > 0 && $current_user_role[0] == "pool_member") {
            $household_query = new WP_User_Query( array( 'meta_key' => 'pool_member', 'meta_value' => $profileuser->ID ) );
            $household_members = $household_query->get_results();
            if(sizeof($household_members) > 0){
                ?>

                <h2><label for="title"><?php esc_html_e('Household Members',get_theme_domain() ); ?></label></h2>
                <table class="form-group form-table household_members" style='text-align:left;'>
                    <tr>
                        <th><label><?php esc_html_e('Name',get_theme_domain() ); ?></label></th>
                        <th><label><?php esc_html_e('Email',get_theme_domain() ); ?></label></th>
                        <th><label><?php esc_html_e('Contact Number',get_theme_domain() ); ?></label></th>
                    </tr>
                    <?php foreach($household_members as $household_member) : ?>
                        <?php $household_member_info = get_userdata($household_member->ID); ?>
                        <tr>
                            <td><a href="<?php echo admin_url('user-edit.php?user_id='.$household_member->ID) ?>"><label><?php echo $household_member->first_name . ' ' . $household_member->last_name ?></label></a></td>
                            <td><label><?php echo $household_member->user_email; ?></label></td>
                            <td><label><?php echo get_user_meta($household_member->ID,"contact_number",true); ?></label></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php
            }
        }    
    }  
?>
<?php 
}
add_action( 'show_user_profile', 'fanZone_admin_profile_fields', 11, 1 );
add_action( 'edit_user_profile', 'fanZone_admin_profile_fields', 11, 1 );
add_action( 'user_new_form',     'fanZone_admin_profile_fields', 11, 1 );
endif; //endif

function fanZone_save_user_profile_fields( $user_id ) {
    
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false;
    }else{
        $usermeta = array(
            'member_ID'     => !empty($_POST['member_ID'])      ? $_POST['member_ID']      : '',
            'pool_member'   => !empty($_POST['pool_member'])    ? $_POST['pool_member']    : '',
            'contact_number'=> !empty($_POST['contact_number']) ? $_POST['contact_number'] : '',
            'address_one'   => !empty($_POST['address_one'])    ? $_POST['address_one']    : '',
            'address_two'   => !empty($_POST['address_two'])    ? $_POST['address_two']    : '',
            'user_city'     => !empty($_POST['user_city'])      ? $_POST['user_city']      : '',
            'user_state'    => !empty($_POST['user_state'])     ? $_POST['user_state']     : '',
            'zip'           => !empty($_POST['zip'])            ? $_POST['zip']            : '',
            'household'     => !empty($_POST['household'])      ? $_POST['household']      : '',
            'purchase_date' => !empty($_POST['purchase_date'])  ? $_POST['purchase_date']  : '',
            'dues_amount'   => !empty($_POST['dues_amount'])    ? $_POST['dues_amount']    : '',
            'pool_key'      => !empty($_POST['pool_key'])       ? $_POST['pool_key']       : '',
            'annual_dues'   => !empty($_POST['annual_dues'])    ? $_POST['annual_dues']    : '',
            'user_notes'   => !empty($_POST['user_notes'])      ? $_POST['user_notes']     : '',
            
        );

        foreach ($usermeta as $key => $value):
            update_user_meta( $user_id, $key, $value );
        endforeach; //end foreach

    }    
}
add_action( 'user_register',  'fanZone_save_user_profile_fields' );
add_action( 'profile_update', 'fanZone_save_user_profile_fields' );